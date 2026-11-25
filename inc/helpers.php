<?php
/**
 * Language + content helpers.
 *
 * Language is carried in the URL (?lang=en) — never a cookie — so page
 * caches (LiteSpeed on Hostinger) keep one copy per language safely.
 * Arabic is the default.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

/**
 * Current language: 'ar' (default) or 'en'.
 */
function kf_lang() {
	static $lang = null;
	if ( null === $lang ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$q    = isset( $_GET['lang'] ) ? sanitize_key( wp_unslash( $_GET['lang'] ) ) : '';
		$lang = ( 'en' === $q ) ? 'en' : 'ar';
	}
	return $lang;
}

function kf_is_rtl() {
	return 'ar' === kf_lang();
}

/**
 * Get a value from the content dictionary using dot notation.
 *
 * @param string      $key  e.g. 'hero.title_a'.
 * @param string|null $lang Force language.
 * @return mixed
 */
function kf_get( $key, $lang = null ) {
	$lang = $lang ? $lang : kf_lang();
	$all  = kf_content();
	$node = isset( $all[ $lang ] ) ? $all[ $lang ] : $all['ar'];
	foreach ( explode( '.', $key ) as $part ) {
		if ( is_array( $node ) && array_key_exists( $part, $node ) ) {
			$node = $node[ $part ];
		} else {
			return '';
		}
	}
	return $node;
}

/** Echo escaped text. */
function kf_e( $key ) {
	echo esc_html( kf_get( $key ) );
}

/**
 * Build an internal URL that keeps the current (or given) language.
 *
 * @param string      $path Path relative to home, e.g. 'contact/'.
 * @param string|null $lang Target language.
 */
function kf_url( $path = '', $lang = null ) {
	$lang = $lang ? $lang : kf_lang();
	$url  = home_url( '/' . ltrim( $path, '/' ) );
	return ( 'en' === $lang ) ? add_query_arg( 'lang', 'en', $url ) : $url;
}

/**
 * URL of the current page in the other language (keeps other query args).
 */
function kf_switch_url() {
	return kf_is_rtl() ? add_query_arg( 'lang', 'en' ) : remove_query_arg( 'lang' );
}

/** WhatsApp link (digits only number from the Customizer). */
function kf_whatsapp_url( $text = '' ) {
	$num = preg_replace( '/\D+/', '', (string) get_theme_mod( 'kf_whatsapp', '201119811153' ) );
	$url = 'https://wa.me/' . $num;
	if ( $text ) {
		$url .= '?text=' . rawurlencode( $text );
	}
	return $url;
}

function kf_whatsapp_display() {
	$num = preg_replace( '/\D+/', '', (string) get_theme_mod( 'kf_whatsapp', '201119811153' ) );
	// +20 111 981 1153 style for Egyptian numbers; generic grouping otherwise.
	if ( 0 === strpos( $num, '20' ) && 12 === strlen( $num ) ) {
		return '+20 ' . substr( $num, 2, 3 ) . ' ' . substr( $num, 5, 3 ) . ' ' . substr( $num, 8 );
	}
	return '+' . $num;
}

/** Brand meta merged with translated copy. */
function kf_brand( $slug ) {
	$meta = kf_brands_meta();
	if ( ! isset( $meta[ $slug ] ) ) {
		return null;
	}
	$brand = array_merge( $meta[ $slug ], (array) kf_get( 'companies.items.' . $slug ) );
	if ( 'keclinic' === $slug ) {
		$custom = trim( (string) get_theme_mod( 'kf_keclinic_url', '' ) );
		if ( $custom ) {
			$brand['url']  = esc_url_raw( $custom );
			$brand['host'] = wp_parse_url( $brand['url'], PHP_URL_HOST );
		}
	}
	$brand['slug'] = $slug;
	return $brand;
}

function kf_company_url( $slug ) {
	return kf_url( 'companies/' . $slug . '/' );
}

/** Render a template part with args. */
function kf_part( $name, $args = array() ) {
	get_template_part( 'template-parts/' . $name, null, $args );
}
