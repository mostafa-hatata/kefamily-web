<?php
/**
 * Meeting booking.
 *
 * The browser talks to the Google Apps Script booking endpoint directly
 * (free slots + create the Calendar event with a Meet link), exactly like
 * kemarq.net. Every confirmed booking is also logged here as a private
 * Lead, so the team sees it in wp-admin even if email fails.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

define( 'KF_BOOKING_DEFAULT', 'https://script.google.com/macros/s/AKfycbykr0xRfAWs4QZ5Pf9ODwJnsB2d4f5bU6GuCem7hxHsaY1WjFt6s32JhxqGWtaS_lH1/exec' );

/** Booking web-app URL (Appearance → Customize → KeFamily). */
function kf_booking_endpoint() {
	return (string) get_theme_mod( 'kf_booking_endpoint', KF_BOOKING_DEFAULT );
}

add_action( 'wp_ajax_kf_book_log', 'kf_book_log' );
add_action( 'wp_ajax_nopriv_kf_book_log', 'kf_book_log' );

/** Store a confirmed booking as a Lead. */
function kf_book_log() {
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'kf_book' ) ) {
		wp_send_json_error( array( 'code' => 'nonce' ), 403 );
	}
	$f = array();
	foreach ( array( 'name', 'email', 'phone', 'company', 'service', 'topic', 'meeting', 'date', 'hour', 'lang', 'status' ) as $k ) {
		$f[ $k ] = isset( $_POST[ $k ] ) ? sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) : '';
	}
	if ( '' === $f['name'] || ! is_email( $f['email'] ) || ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $f['date'] ) ) {
		wp_send_json_error( array( 'code' => 'invalid' ), 400 );
	}
	// One log per email+slot.
	$key = 'kf_book_' . md5( strtolower( $f['email'] ) . $f['date'] . $f['hour'] );
	if ( get_transient( $key ) ) {
		wp_send_json_success();
	}
	set_transient( $key, 1, DAY_IN_SECONDS );

	$when = $f['date'] . ' ' . str_pad( $f['hour'], 2, '0', STR_PAD_LEFT ) . ':00 (Riyadh)';
	$id   = wp_insert_post(
		array(
			'post_type'    => 'kf_lead',
			'post_status'  => 'private',
			'post_title'   => $f['name'] . ' — Meeting ' . $when,
			'post_content' => $f['topic'],
		)
	);
	if ( $id && ! is_wp_error( $id ) ) {
		foreach ( $f as $k => $v ) {
			update_post_meta( $id, $k, $v );
		}
		update_post_meta( $id, 'interest', 'Meeting (' . $f['meeting'] . ') ' . $when . ' — ' . $f['service'] );
		$to = get_theme_mod( 'kf_leads_email', get_option( 'admin_email' ) );
		wp_mail( $to, 'KeFamily — new meeting: ' . $f['name'] . ' · ' . $when, implode( "\n", array_map( function ( $k, $v ) { return $k . ': ' . $v; }, array_keys( $f ), $f ) ) );
		do_action( 'kf_lead_created', $id, $f );
	}
	wp_send_json_success();
}
