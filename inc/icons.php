<?php
/**
 * Inline SVG icons + KeFamily logo.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

function kf_icon( $name, $class = '' ) {
	$p = array(
		'arrow'     => '<path d="M5 12h14M13 6l6 6-6 6"/>',
		'arrow-up'  => '<path d="M7 17L17 7M8 7h9v9"/>',
		'whatsapp'  => '<path d="M3.5 20.5l1.3-4.6A8.5 8.5 0 1 1 8.2 19.3z"/><path d="M9 8.6c.2-.5.5-.6.8-.6h.5c.2 0 .4 0 .5.4l.7 1.7c.1.2 0 .4-.1.6l-.5.6c-.1.1-.2.3 0 .5.5.9 1.5 1.9 2.6 2.4.2.1.4.1.5-.1l.6-.7c.2-.2.4-.2.6-.1l1.7.8c.2.1.3.2.3.4 0 .9-.7 1.8-1.8 1.9-1 .1-2.7-.3-4.6-2.1-1.8-1.7-2.4-3.5-2.4-4.4 0-.5.2-.9.6-1.3z" fill="currentColor" stroke="none"/>',
		'data'      => '<ellipse cx="12" cy="5.5" rx="7.5" ry="2.8"/><path d="M4.5 5.5v6.5c0 1.5 3.4 2.8 7.5 2.8s7.5-1.3 7.5-2.8V5.5"/><path d="M4.5 12v6.5c0 1.5 3.4 2.8 7.5 2.8s7.5-1.3 7.5-2.8V12"/>',
		'link'      => '<path d="M10 14a4.5 4.5 0 0 0 6.4 0l3-3a4.5 4.5 0 0 0-6.4-6.4l-1 1"/><path d="M14 10a4.5 4.5 0 0 0-6.4 0l-3 3a4.5 4.5 0 0 0 6.4 6.4l1-1"/>',
		'chart'     => '<path d="M4 20V10M10 20V4M16 20v-7M21 20H3"/>',
		'team'      => '<circle cx="9" cy="8" r="3.2"/><path d="M3 20c.6-3.4 3-5.3 6-5.3s5.4 1.9 6 5.3"/><circle cx="17" cy="9" r="2.4"/><path d="M16.5 14.2c2.4.2 4 1.8 4.5 4.3"/>',
		'check'     => '<path d="M5 12.5l4.2 4.2L19 7"/>',
		'plus'      => '<path d="M12 5v14M5 12h14"/>',
		'menu'      => '<path d="M4 8h16M4 16h16"/>',
		'close'     => '<path d="M6 6l12 12M18 6L6 18"/>',
		'globe'     => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.6 2.6 3.8 5.6 3.8 9S14.6 18.4 12 21c-2.6-2.6-3.8-5.6-3.8-9S9.4 5.6 12 3z"/>',
		'clock'     => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'pin'       => '<path d="M12 21s-7-6.2-7-11.5a7 7 0 1 1 14 0C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
		'spark'     => '<path d="M12 3l1.9 5.6L19.5 10l-5.6 1.9L12 17.5l-1.9-5.6L4.5 10l5.6-1.4z"/>',
		'linkedin'  => '<rect x="3" y="3" width="18" height="18" rx="4"/><path d="M8 10.5V16M8 7.6v.1M11.5 16v-3.2c0-1.4.9-2.3 2.1-2.3s1.9.9 1.9 2.3V16"/>',
		'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.3" cy="6.7" r=".6" fill="currentColor"/>',
		'shield'    => '<path d="M12 3l7.5 3v5.5c0 4.6-3.2 8.3-7.5 9.5-4.3-1.2-7.5-4.9-7.5-9.5V6z"/><path d="M8.8 12l2.2 2.2 4.3-4.4"/>',
		/* Company glyphs */
		'kepixel'   => '<rect x="3.5" y="3.5" width="7" height="7" rx="1.6"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.6" fill="currentColor"/><rect x="3.5" y="13.5" width="7" height="7" rx="1.6" fill="currentColor"/><rect x="13.5" y="13.5" width="7" height="7" rx="1.6"/>',
		'kemarq'    => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r="1.2" fill="currentColor"/><path d="M18 6l2.5-2.5"/>',
		'kechat'    => '<path d="M4 18.5V7a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v6.5a3 3 0 0 1-3 3H8.5z"/><path d="M8.5 10.3h.01M12 10.3h.01M15.5 10.3h.01" stroke-width="2.6"/>',
		'keclinic'  => '<rect x="3.5" y="5" width="17" height="15" rx="3"/><path d="M3.5 9.5h17M8 3v4M16 3v4M12 12.2v5M9.5 14.7h5"/>',
	);
	if ( ! isset( $p[ $name ] ) ) {
		return '';
	}
	return '<svg class="icon ' . esc_attr( $class ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $p[ $name ] . '</svg>';
}

/**
 * KeFamily mark: four brand-coloured tiles orbiting a core — the family.
 */
function kf_logo_mark( $size = 32 ) {
	$id = 'kfm' . wp_rand( 100, 999999 );
	return '<svg class="kf-mark" width="' . (int) $size . '" height="' . (int) $size . '" viewBox="0 0 40 40" aria-hidden="true">'
		. '<defs><linearGradient id="' . $id . '" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#fff"/><stop offset="1" stop-color="#c9c3ff"/></linearGradient></defs>'
		. '<rect x="3" y="3" width="15" height="15" rx="5" fill="#8B5CF6"/>'
		. '<rect x="22" y="3" width="15" height="15" rx="7.5" fill="#FF7A45"/>'
		. '<rect x="3" y="22" width="15" height="15" rx="7.5" fill="#22D39A"/>'
		. '<rect x="22" y="22" width="15" height="15" rx="5" fill="#FACC15"/>'
		. '<circle cx="20" cy="20" r="6.2" fill="#06060a"/><circle cx="20" cy="20" r="3.4" fill="url(#' . $id . ')"/>'
		. '</svg>';
}

function kf_logo() {
	return '<span class="kf-logo">' . kf_logo_mark( 30 ) . '<span class="kf-logo__word" dir="ltr">Ke<b>Family</b></span></span>';
}
