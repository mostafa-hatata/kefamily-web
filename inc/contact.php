<?php
/**
 * Contact form: AJAX handler, leads stored in wp-admin, email notification.
 *
 * Every submission is saved as a private "Lead" post first, so nothing is
 * lost even if mail delivery fails.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		register_post_type(
			'kf_lead',
			array(
				'labels'          => array(
					'name'          => 'Leads',
					'singular_name' => 'Lead',
					'menu_name'     => 'KeFamily Leads',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-email-alt',
				'supports'        => array( 'title', 'editor', 'custom-fields' ),
				'capability_type' => 'post',
				'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
				'map_meta_cap'    => true,
			)
		);
	}
);

/* Admin list columns. */
add_filter(
	'manage_kf_lead_posts_columns',
	function ( $cols ) {
		return array(
			'cb'          => $cols['cb'],
			'title'       => 'Name',
			'kf_contact'  => 'Contact',
			'kf_interest' => 'Interest',
			'date'        => 'Date',
		);
	}
);
add_action(
	'manage_kf_lead_posts_custom_column',
	function ( $col, $post_id ) {
		if ( 'kf_contact' === $col ) {
			echo esc_html( trim( get_post_meta( $post_id, 'email', true ) . '  ' . get_post_meta( $post_id, 'phone', true ) ) );
		}
		if ( 'kf_interest' === $col ) {
			echo esc_html( get_post_meta( $post_id, 'interest', true ) );
		}
	},
	10,
	2
);

/* Fresh nonce on demand, so cached pages never submit an expired one. */
add_action( 'wp_ajax_kf_nonce', 'kf_fresh_nonce' );
add_action( 'wp_ajax_nopriv_kf_nonce', 'kf_fresh_nonce' );
function kf_fresh_nonce() {
	nocache_headers();
	wp_send_json_success( array( 'nonce' => wp_create_nonce( 'kf_contact' ) ) );
}

add_action( 'wp_ajax_kf_contact', 'kf_handle_contact' );
add_action( 'wp_ajax_nopriv_kf_contact', 'kf_handle_contact' );

function kf_handle_contact() {
	if ( ! isset( $_POST['kf_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kf_nonce'] ) ), 'kf_contact' ) ) {
		wp_send_json_error( array( 'code' => 'nonce' ), 403 );
	}
	// Honeypot.
	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_success();
	}
	// Simple rate limit: 5 per IP per 10 minutes.
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '0';
	$key = 'kf_rl_' . md5( $ip );
	$hit = (int) get_transient( $key );
	if ( $hit >= 5 ) {
		wp_send_json_error( array( 'code' => 'rate' ), 429 );
	}
	set_transient( $key, $hit + 1, 10 * MINUTE_IN_SECONDS );

	$f = array();
	foreach ( array( 'name', 'company', 'email', 'phone', 'interest', 'lang', 'page' ) as $k ) {
		$f[ $k ] = isset( $_POST[ $k ] ) ? sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) : '';
	}
	$f['email']   = sanitize_email( $f['email'] );
	$f['message'] = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $f['name'] || ( '' === $f['email'] && '' === $f['phone'] ) ) {
		wp_send_json_error( array( 'code' => 'required' ), 422 );
	}

	$body = sprintf(
		"Name: %s\nCompany: %s\nEmail: %s\nPhone: %s\nInterest: %s\nLanguage: %s\nPage: %s\n\n%s",
		$f['name'],
		$f['company'],
		$f['email'],
		$f['phone'],
		$f['interest'],
		$f['lang'],
		$f['page'],
		$f['message']
	);

	$post_id = wp_insert_post(
		array(
			'post_type'    => 'kf_lead',
			'post_status'  => 'private',
			'post_title'   => $f['name'] . ( $f['company'] ? ' — ' . $f['company'] : '' ),
			'post_content' => $body,
		)
	);
	if ( $post_id && ! is_wp_error( $post_id ) ) {
		foreach ( $f as $k => $v ) {
			update_post_meta( $post_id, $k, $v );
		}
	}

	$to      = sanitize_email( get_theme_mod( 'kf_leads_email', get_option( 'admin_email' ) ) );
	$headers = array();
	if ( $f['email'] ) {
		$headers[] = 'Reply-To: ' . $f['name'] . ' <' . $f['email'] . '>';
	}
	wp_mail( $to, '[KeFamily] New lead: ' . $f['name'], $body, $headers );

	/**
	 * Hook for integrations (CRM, KePixel server event, WhatsApp, …).
	 */
	do_action( 'kf_lead_created', $post_id, $f );

	wp_send_json_success();
}
