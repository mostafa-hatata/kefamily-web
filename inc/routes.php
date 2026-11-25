<?php
/**
 * Router: every marketing page of the site lives here (not as WP pages),
 * so URLs, titles, descriptions, breadcrumbs and the sitemap come from one
 * table and stay consistent in both languages.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

function kf_sector_slugs() {
	return array( 'ecommerce', 'clinics', 'education', 'nonprofits', 'services', 'apps' );
}

/**
 * Route table: key => array( path, template ).
 */
function kf_routes() {
	$r = array(
		'companies'    => array( 'companies/', 'companies' ),
		'solutions'    => array( 'solutions/', 'solutions' ),
		'how'          => array( 'how-it-works/', 'how' ),
		'about'        => array( 'about/', 'about' ),
		'careers'      => array( 'careers/', 'careers' ),
		'partners'     => array( 'partners/', 'partners' ),
		'faq'          => array( 'faq/', 'faq' ),
		'contact'      => array( 'contact/', 'contact' ),
		'privacy'      => array( 'privacy-policy/', 'legal' ),
		'terms'        => array( 'terms/', 'legal' ),
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
	if ( 'home' === $key ) {
		return kf_url( '', $lang );
	}
	$r = kf_routes();
	return isset( $r[ $key ] ) ? kf_url( $r[ $key ][0], $lang ) : kf_url( '', $lang );
}

/** Current route key ('home', a key from kf_routes(), or ''). */
function kf_route() {
	if ( is_front_page() && ! get_query_var( 'kf_route' ) ) {
		return 'home';
	}
	$k = (string) get_query_var( 'kf_route' );
	return isset( kf_routes()[ $k ] ) ? $k : '';
}

/** Brand slug when on a company page. */
function kf_route_brand() {
	$k = kf_route();
	return 0 === strpos( $k, 'company-' ) ? substr( $k, 8 ) : '';
}

/** Sector slug when on a solution page. */
function kf_route_sector() {
	$k = kf_route();
	return 0 === strpos( $k, 'solution-' ) ? substr( $k, 9 ) : '';
}

add_action(
	'init',
	function () {
		foreach ( kf_routes() as $key => $route ) {
			add_rewrite_rule( '^' . preg_quote( rtrim( $route[0], '/' ), '#' ) . '/?$', 'index.php?kf_route=' . $key, 'top' );
		}
	}
);

add_filter(
	'query_vars',
	function ( $vars ) {
		$vars[] = 'kf_route';
		return $vars;
	}
);

/* Old WP pages created by v1.0 (about/contact) are superseded by routes. */
add_action(
	'template_redirect',
	function () {
		if ( kf_route() && ! is_front_page() ) {
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
		$k = kf_route();
		if ( $k && 'home' !== $k ) {
			$file = KF_DIR . '/templates/' . kf_routes()[ $k ][1] . '.php';
			if ( file_exists( $file ) ) {
				return $file;
			}
		}
		return $template;
	}
);

/* Body class per route. */
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
	$t     = '';
	$d     = '';
	$crumb = array( $home );

	$brand  = 0 === strpos( (string) $key, 'company-' ) ? substr( $key, 8 ) : '';
	$sector = 0 === strpos( (string) $key, 'solution-' ) ? substr( $key, 9 ) : '';

	if ( 'home' === $key || '' === $key ) {
		return array(
			'title'  => kf_get( 'meta.title' ),
			'desc'   => kf_get( 'meta.description' ),
			'crumbs' => array(),
		);
	}
	if ( $brand ) {
		$b       = kf_brand( $brand );
		$t       = $b['name'] . ' — ' . rtrim( $b['headline'], '.' ) . ' | KeFamily';
		$d       = $b['desc'];
		$crumb[] = array( kf_get( 'nav.companies' ), kf_route_url( 'companies' ) );
		$crumb[] = array( $b['name'], kf_route_url( $key ) );
	} elseif ( $sector ) {
		$s       = kf_get( 'sectors_pages.' . $sector );
		$t       = $s['seo_title'] . ' | KeFamily';
		$d       = $s['seo_desc'];
		$crumb[] = array( kf_get( 'nav.solutions' ), kf_route_url( 'solutions' ) );
		$crumb[] = array( $s['name'], kf_route_url( $key ) );
	} else {
		$p       = kf_get( 'pages.' . $key );
		$t       = ( isset( $p['seo_title'] ) ? $p['seo_title'] : '' ) . ' | KeFamily';
		$d       = isset( $p['seo_desc'] ) ? $p['seo_desc'] : '';
		$crumb[] = array( isset( $p['crumb'] ) ? $p['crumb'] : '', kf_route_url( $key ) );
	}
	return array(
		'title'  => $t,
		'desc'   => $d,
		'crumbs' => $crumb,
	);
}
