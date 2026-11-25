<?php
/**
 * Customizer: editable business details (Appearance → Customize → KeFamily).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'customize_register',
	function ( $wp_customize ) {
		$wp_customize->add_section(
			'kf_business',
			array(
				'title'    => 'KeFamily — Business details',
				'priority' => 30,
			)
		);
		$fields = array(
			'kf_whatsapp'     => array( 'WhatsApp number (international, digits only)', '201119811153', 'sanitize_text_field' ),
			'kf_leads_email'  => array( 'Email that receives contact-form leads', get_option( 'admin_email' ), 'sanitize_email' ),
			'kf_keclinic_url' => array( 'KeClinic website URL (leave empty until it launches)', '', 'esc_url_raw' ),
			'kf_booking_endpoint' => array( 'Meeting booking endpoint (Google Apps Script web app URL)', KF_BOOKING_DEFAULT, 'esc_url_raw' ),
			'kf_linkedin'     => array( 'LinkedIn URL', '', 'esc_url_raw' ),
			'kf_instagram'    => array( 'Instagram URL', '', 'esc_url_raw' ),
		);
		foreach ( $fields as $id => $f ) {
			$wp_customize->add_setting(
				$id,
				array(
					'default'           => $f[1],
					'sanitize_callback' => $f[2],
				)
			);
			$wp_customize->add_control(
				$id,
				array(
					'label'   => $f[0],
					'section' => 'kf_business',
					'type'    => 'text',
				)
			);
		}
	}
);
