<?php
/**
 * Theme setup, assets, routing.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'site-icon' );
		register_nav_menus( array( 'primary' => 'Primary' ) );
	}
);

/* ---------- <html lang dir> ---------- */
add_filter(
	'language_attributes',
	function () {
		$l = kf_langs()[ kf_lang() ];
		return sprintf( 'lang="%s" dir="%s"', esc_attr( $l['hreflang'] ), esc_attr( $l['dir'] ) );
	}
);

/* ---------- Assets ---------- */
add_action(
	'wp_enqueue_scripts',
	function () {
		$css_ver = KF_VERSION . '.' . filemtime( KF_DIR . '/assets/css/main.css' );
		$js_ver  = KF_VERSION . '.' . filemtime( KF_DIR . '/assets/js/main.js' );
		wp_enqueue_style( 'kefamily', KF_URI . '/assets/css/main.css', array(), $css_ver );
		wp_enqueue_script( 'kefamily', KF_URI . '/assets/js/main.js', array(), $js_ver, array( 'strategy' => 'defer', 'in_footer' => true ) );
		wp_localize_script(
			'kefamily',
			'KF',
			array(
				'ajax'    => admin_url( 'admin-ajax.php' ),
				'lang'    => kf_lang(),
				'rotate'  => kf_get( 'hero.rotate' ),
				'book'    => array(
					'endpoint' => kf_booking_endpoint(),
					'nonce'    => wp_create_nonce( 'kf_book' ),
					'i18n'     => kf_get( 'book' ),
					'wa'       => kf_whatsapp_url(),
				),
				'rotateStyles' => array_map( 'kf_brand_style', array( 'kemarq', 'kepixel', 'kechat', 'keclinic' ) ),
				'i18n'    => array(
					'sending'  => kf_get( 'contact.sending' ),
					'send'     => kf_get( 'contact.send' ),
					'ok'       => kf_get( 'contact.ok' ),
					'err'      => kf_get( 'contact.err' ),
					'required' => kf_get( 'contact.required' ),
				),
			)
		);
		// The theme ships no block styles on the marketing pages.
		if ( is_front_page() || kf_route() || is_404() ) {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
			wp_dequeue_style( 'global-styles' );
			wp_dequeue_style( 'classic-theme-styles' );
		}
	},
	20
);

/* Preload the two fonts used above the fold. */
add_action(
	'wp_head',
	function () {
		$fonts = array( 'ar' => 'readex-pro-arabic-wght-normal.woff2', 'ru' => 'manrope-cyrillic-wght-normal.woff2' );
		$font  = isset( $fonts[ kf_lang() ] ) ? $fonts[ kf_lang() ] : 'readex-pro-latin-wght-normal.woff2';
		printf( '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n", esc_url( KF_URI . '/assets/fonts/' . $font ) );
		echo '<meta name="theme-color" content="#07070a" media="(prefers-color-scheme: dark)">' . "\n";
		echo '<meta name="theme-color" content="#fafafa" media="(prefers-color-scheme: light)">' . "\n";
		if ( ! has_site_icon() ) {
			printf( '<link rel="icon" type="image/png" sizes="32x32" href="%s">' . "\n", esc_url( KF_URI . '/assets/img/icon-32.png' ) );
			printf( '<link rel="icon" type="image/png" sizes="48x48" href="%s">' . "\n", esc_url( KF_URI . '/assets/img/icon-48.png' ) );
			printf( '<link rel="apple-touch-icon" href="%s">' . "\n", esc_url( KF_URI . '/assets/img/icon-180.png' ) );
		}
	},
	1
);

/* ---------- Head cleanup ---------- */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/* ---------- First activation: pages, front page, permalinks ---------- */
add_action( 'after_switch_theme', 'kf_activate' );
function kf_activate() {
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}
	// Static front page is not required: front-page.php renders the home.
	update_option( 'show_on_front', 'posts' );
	update_option( 'blogname', 'KeFamily' );
	update_option( 'blogdescription', 'The parent company of KePixel, KeMarq, KeChat & KeClinic' );
	flush_rewrite_rules();
}

/* Make sure rewrite rules exist after a git deploy (no re-activation). */
add_action(
	'init',
	function () {
		$host = (string) wp_parse_url( home_url(), PHP_URL_HOST );
		$key  = KF_VERSION . '@' . $host;
		if ( get_option( 'kf_rewrite_ver' ) !== $key ) {
			flush_rewrite_rules( false );
			update_option( 'kf_rewrite_ver', $key );
		}
	},
	99
);

/* Body classes. */
add_filter(
	'body_class',
	function ( $classes ) {
		$classes[] = 'kf';
		$classes[] = 'lang-' . kf_lang();
		return $classes;
	}
);

/**
 * HTML must never sit in a visitor's browser for days: the host was sending
 * "max-age=604800" on pages, so returning visitors kept an old design after a
 * deploy. Browsers now revalidate every page; the server/CDN may still keep a
 * copy for 10 minutes (s-maxage) so traffic bursts don't reach MySQL.
 * CSS/JS are versioned by file time, so they stay long-cached safely.
 */
add_action( 'send_headers', function () {
	if ( is_admin() || wp_doing_ajax() || is_user_logged_in() || headers_sent() ) {
		return;
	}
	header( 'Cache-Control: public, max-age=0, s-maxage=600, must-revalidate', true );
	header_remove( 'Expires' );
}, 99 );
