<?php
/**
 * Router: every marketing page lives here (not as WP pages) so URLs,
 * titles, descriptions, breadcrumbs, hreflang and the sitemap come from one
 * table and stay consistent in all four languages.
 *
 * URL scheme: English at the root (/companies/), other languages prefixed
 * (/ar/companies/, /ru/companies/, /de/companies/).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

function kf_sector_slugs() {
	return array( 'ecommerce', 'clinics', 'education', 'nonprofits', 'services', 'apps' );
}

/** Route table: key => array( path, template ). */
function kf_routes() {
	$r = array(
		'home'      => array( '', 'home' ),
		'companies' => array( 'companies/', 'companies' ),
		'solutions' => array( 'solutions/', 'solutions' ),
		'how'       => array( 'how-it-works/', 'how' ),
		'about'     => array( 'about/', 'about' ),
		'book'      => array( 'book/', 'book' ),
		'blog'      => array( 'blog/', 'blog' ),
		'careers'   => array( 'careers/', 'careers' ),
		'partners'  => array( 'partners/', 'partners' ),
		'faq'       => array( 'faq/', 'faq' ),
		'contact'   => array( 'contact/', 'contact' ),
		'privacy'   => array( 'privacy-policy/', 'legal' ),
		'terms'     => array( 'terms/', 'legal' ),
	);
	foreach ( array_keys( kf_brands_meta() ) as $slug ) {
		$r[ 'company-' . $slug ] = array( 'companies/' . $slug . '/', 'company' );
	}
	foreach ( kf_sector_slugs() as $slug ) {
		$r[ 'solution-' . $slug ] = array( 'solutions/' . $slug . '/', 'solution' );
	}
	return $r;
}

/** URL of a route in the current (or given) language. */
function kf_route_url( $key, $lang = null ) {
	$r = kf_routes();
	return isset( $r[ $key ] ) ? kf_url( $r[ $key ][0], $lang ) : kf_url( '', $lang );
}

/** Current route key, or '' when WordPress handles the request itself. */
function kf_route() {
	$k = (string) get_query_var( 'kf_route' );
	if ( '' === $k && is_front_page() ) {
		return 'home';
	}
	if ( 'post' === $k ) {
		return 'post';
	}
	return isset( kf_routes()[ $k ] ) ? $k : '';
}

function kf_route_brand() {
	$k = kf_route();
	return 0 === strpos( $k, 'company-' ) ? substr( $k, 8 ) : '';
}

function kf_route_sector() {
	$k = kf_route();
	return 0 === strpos( $k, 'solution-' ) ? substr( $k, 9 ) : '';
}

add_action(
	'init',
	function () {
		$lp = '(?:(?:ar|ru|de)/)?';
		add_rewrite_rule( '^(?:ar|ru|de)/?$', 'index.php?kf_route=home', 'top' );
		foreach ( kf_routes() as $key => $route ) {
			if ( '' === $route[0] ) {
				continue;
			}
			add_rewrite_rule( '^' . $lp . preg_quote( rtrim( $route[0], '/' ), '#' ) . '/?$', 'index.php?kf_route=' . $key, 'top' );
		}
		add_rewrite_rule( '^' . $lp . 'blog/page/([0-9]+)/?$', 'index.php?kf_route=blog&kf_page=$matches[1]', 'top' );
		add_rewrite_rule( '^' . $lp . 'blog/topic/([a-z0-9\-]+)/?$', 'index.php?kf_route=blog&kf_topic=$matches[1]', 'top' );
		add_rewrite_rule( '^' . $lp . 'blog/([a-z0-9\-]+)/?$', 'index.php?kf_route=post&kf_post=$matches[1]', 'top' );
	}
);

add_filter(
	'query_vars',
	function ( $vars ) {
		return array_merge( $vars, array( 'kf_route', 'kf_page', 'kf_topic', 'kf_post' ) );
	}
);

/** Legacy ?lang=en URLs from v1.x → new path scheme (permanent). */
add_action(
	'template_redirect',
	function () {
		if ( isset( $_GET['lang'] ) && ! is_admin() ) { // phpcs:ignore
			$l    = sanitize_key( wp_unslash( $_GET['lang'] ) ); // phpcs:ignore
			$l    = isset( kf_langs()[ $l ] ) ? $l : 'en';
			$path = ltrim( kf_request_path(), '/' );
			wp_safe_redirect( kf_url( $path, $l ), 301 );
			exit;
		}
	},
	0
);

add_action(
	'template_redirect',
	function () {
		$k = kf_route();
		if ( 'post' === $k && ! kf_current_post() ) {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			return;
		}
		if ( $k && 'home' !== $k ) {
			global $wp_query;
			$wp_query->is_404  = false;
			$wp_query->is_home = false;
			$wp_query->is_page = false;
			status_header( 200 );
		}
	},
	1
);

add_filter(
	'template_include',
	function ( $template ) {
		if ( is_404() ) {
			return $template;
		}
		$k = kf_route();
		if ( 'home' === $k ) {
			return KF_DIR . '/front-page.php';
		}
		if ( 'post' === $k ) {
			return KF_DIR . '/templates/post.php';
		}
		if ( $k ) {
			$file = KF_DIR . '/templates/' . kf_routes()[ $k ][1] . '.php';
			if ( file_exists( $file ) ) {
				return $file;
			}
		}
		return $template;
	}
);

add_filter(
	'body_class',
	function ( $c ) {
		$k = kf_route();
		if ( $k ) {
			$c[] = 'route-' . sanitize_html_class( $k );
		}
		return $c;
	}
);

/**
 * Title, description and breadcrumb trail for the current route.
 *
 * @return array{title:string,desc:string,crumbs:array}
 */
function kf_route_meta( $key = null ) {
	$key   = $key ? $key : kf_route();
	$home  = array( kf_get( 'nav.home' ), kf_route_url( 'home' ) );
	$crumb = array( $home );

	if ( 'home' === $key || '' === $key ) {
		return array(
			'title'  => kf_get( 'meta.title' ),
			'desc'   => kf_get( 'meta.description' ),
			'crumbs' => array(),
		);
	}

	$brand  = 0 === strpos( (string) $key, 'company-' ) ? substr( $key, 8 ) : '';
	$sector = 0 === strpos( (string) $key, 'solution-' ) ? substr( $key, 9 ) : '';

	if ( $brand ) {
		$b       = kf_brand( $brand );
		$t       = $b['name'] . ' — ' . rtrim( $b['headline'], '.' );
		$d       = $b['desc'];
		$crumb[] = array( kf_get( 'nav.companies' ), kf_route_url( 'companies' ) );
		$crumb[] = array( $b['name'], kf_route_url( $key ) );
	} elseif ( $sector ) {
		$s       = kf_get( 'sectors_pages.' . $sector );
		$t       = $s['seo_title'];
		$d       = $s['seo_desc'];
		$crumb[] = array( kf_get( 'nav.solutions' ), kf_route_url( 'solutions' ) );
		$crumb[] = array( $s['name'], kf_route_url( $key ) );
	} elseif ( 'post' === $key ) {
		$p       = kf_current_post();
		$t       = $p ? get_the_title( $p ) : '';
		$d       = $p ? wp_strip_all_tags( get_the_excerpt( $p ) ) : '';
		$crumb[] = array( kf_get( 'pages.blog.crumb' ), kf_route_url( 'blog' ) );
		$crumb[] = array( $t, $p ? kf_post_url( $p ) : '' );
	} else {
		$p       = kf_get( 'pages.' . $key );
		$t       = isset( $p['seo_title'] ) ? $p['seo_title'] : '';
		$d       = isset( $p['seo_desc'] ) ? $p['seo_desc'] : '';
		$crumb[] = array( isset( $p['crumb'] ) ? $p['crumb'] : '', kf_route_url( $key ) );
	}
	$suffix = ' | KeFamily';
	if ( mb_strlen( $t . $suffix ) > 70 ) {
		$suffix = '';
	}
	return array(
		'title'  => $t . $suffix,
		'desc'   => $d,
		'crumbs' => $crumb,
	);
}

/**
 * URLs of the current page in every language (only languages that exist).
 *
 * @return array lang => url
 */
function kf_alt_urls() {
	$k   = kf_route();
	$out = array();
	if ( 'post' === $k ) {
		$p = kf_current_post();
		if ( $p ) {
			foreach ( kf_post_translations( $p ) as $lang => $tp ) {
				$out[ $lang ] = kf_post_url( $tp );
			}
		}
		return $out;
	}
	if ( $k ) {
		foreach ( array_keys( kf_langs() ) as $lang ) {
			$out[ $lang ] = kf_route_url( $k, $lang );
			if ( 'blog' === $k ) {
				$base  = get_query_var( 'kf_topic' ) ? 'blog/topic/' . sanitize_title( get_query_var( 'kf_topic' ) ) . '/' : 'blog/';
				$paged = (int) get_query_var( 'kf_page' );
				$out[ $lang ] = kf_url( $base . ( $paged > 1 ? 'page/' . $paged . '/' : '' ), $lang );
			}
		}
	}
	return $out;
}
