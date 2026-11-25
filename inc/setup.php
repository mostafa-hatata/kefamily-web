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
		return kf_is_rtl() ? 'lang="ar" dir="rtl"' : 'lang="en" dir="ltr"';
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
		$font = kf_is_rtl() ? 'readex-pro-arabic-wght-normal.woff2' : 'readex-pro-latin-wght-normal.woff2';
		printf( '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n", esc_url( KF_URI . '/assets/fonts/' . $font ) );
		echo '<meta name="theme-color" content="#07070a" media="(prefers-color-scheme: dark)">' . "\n";
		echo '<meta name="theme-color" content="#fafafa" media="(prefers-color-scheme: light)">' . "\n";
		if ( ! has_site_icon() ) {
			printf( '<link rel="icon" type="image/svg+xml" href="%s">' . "\n", esc_url( KF_URI . '/assets/img/favicon.svg' ) );
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
		if ( get_option( 'kf_rewrite_ver' ) !== KF_VERSION ) {
			flush_rewrite_rules( false );
			update_option( 'kf_rewrite_ver', KF_VERSION );
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
