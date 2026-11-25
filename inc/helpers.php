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

/** Supported languages. English is the default and lives at the site root. */
function kf_langs() {
	return array(
		'en' => array( 'name' => 'English', 'short' => 'EN', 'locale' => 'en_US', 'hreflang' => 'en', 'dir' => 'ltr' ),
		'ar' => array( 'name' => 'العربية', 'short' => 'AR', 'locale' => 'ar_SA', 'hreflang' => 'ar', 'dir' => 'rtl' ),
		'ru' => array( 'name' => 'Русский', 'short' => 'RU', 'locale' => 'ru_RU', 'hreflang' => 'ru', 'dir' => 'ltr' ),
		'de' => array( 'name' => 'Deutsch', 'short' => 'DE', 'locale' => 'de_DE', 'hreflang' => 'de', 'dir' => 'ltr' ),
	);
}

/** Request path relative to the site root, without the language prefix. */
function kf_request_path() {
	$uri       = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/'; // phpcs:ignore
	$path      = (string) wp_parse_url( $uri, PHP_URL_PATH );
	$home_path = rtrim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
	if ( $home_path && 0 === strpos( $path, $home_path ) ) {
		$path = substr( $path, strlen( $home_path ) );
	}
	$path = '/' . ltrim( $path, '/' );
	if ( preg_match( '#^/(ar|ru|de)(/|$)#', $path, $m ) ) {
		$path = '/' . ltrim( substr( $path, 3 ), '/' );
	}
	return $path;
}

/**
 * Current language, from the URL prefix (/ar/, /ru/, /de/); English otherwise.
 * Path-based (never a cookie) so page caches keep one copy per language.
 */
function kf_lang() {
	static $lang = null;
	if ( null === $lang ) {
		$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/'; // phpcs:ignore
		$path = (string) wp_parse_url( $uri, PHP_URL_PATH );
		$home = rtrim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
		if ( $home && 0 === strpos( $path, $home ) ) {
			$path = substr( $path, strlen( $home ) );
		}
		$lang = preg_match( '#^/(ar|ru|de)(/|$)#', $path, $m ) ? $m[1] : 'en';
		if ( is_admin() && ! wp_doing_ajax() ) {
			$lang = 'en';
		}
		if ( wp_doing_ajax() && isset( $_REQUEST['lang'] ) && isset( kf_langs()[ sanitize_key( wp_unslash( $_REQUEST['lang'] ) ) ] ) ) { // phpcs:ignore
			$lang = sanitize_key( wp_unslash( $_REQUEST['lang'] ) ); // phpcs:ignore
		}
	}
	return $lang;
}

function kf_is_rtl() {
	return 'ar' === kf_lang();
}

/**
 * Get a value from the content dictionary using dot notation.
 * Missing keys fall back to English.
 *
 * @param string      $key  e.g. 'hero.title_a'.
 * @param string|null $lang Force language.
 * @return mixed
 */
function kf_get( $key, $lang = null ) {
	$lang = $lang ? $lang : kf_lang();
	$all  = kf_content();
	foreach ( array_unique( array( $lang, 'en' ) ) as $try ) {
		$node  = isset( $all[ $try ] ) ? $all[ $try ] : array();
		$found = true;
		foreach ( explode( '.', $key ) as $part ) {
			if ( is_array( $node ) && array_key_exists( $part, $node ) ) {
				$node = $node[ $part ];
			} else {
				$found = false;
				break;
			}
		}
		if ( $found ) {
			return $node;
		}
	}
	return '';
}

/** Echo escaped text. */
function kf_e( $key ) {
	echo esc_html( kf_get( $key ) );
}

/**
 * Internal URL in the current (or given) language.
 *
 * @param string      $path Path relative to the site root, e.g. 'contact/'.
 * @param string|null $lang Target language.
 */
function kf_url( $path = '', $lang = null ) {
	$lang = $lang ? $lang : kf_lang();
	$path = ltrim( $path, '/' );
	$pref = ( 'en' === $lang ) ? '' : $lang . '/';
	if ( '' === $path ) {
		return home_url( '/' . $pref );
	}
	if ( '#' === $path[0] ) {
		return home_url( '/' . $pref ) . $path;
	}
	return home_url( '/' . $pref . $path );
}

/** URL of the current page in another language. */
function kf_lang_url( $lang ) {
	if ( function_exists( 'kf_alt_urls' ) ) {
		$alts = kf_alt_urls();
		if ( isset( $alts[ $lang ] ) ) {
			return $alts[ $lang ];
		}
	}
	return kf_url( ltrim( kf_request_path(), '/' ), $lang );
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
	return kf_route_url( 'company-' . $slug );
}

function kf_solution_url( $slug ) {
	return kf_route_url( 'solution-' . $slug );
}

/** Render a template part with args. */
function kf_part( $name, $args = array() ) {
	get_template_part( 'template-parts/' . $name, null, $args );
}
