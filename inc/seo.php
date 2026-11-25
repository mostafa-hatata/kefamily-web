<?php
/**
 * SEO: titles, meta, Open Graph, hreflang, JSON-LD, staging noindex.
 *
 * Skips its own tags when Yoast / Rank Math is active.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

function kf_has_seo_plugin() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' );
}

/** True on staging / temporary hosts — they must never be indexed. */
function kf_is_staging() {
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	return (bool) preg_match( '/(hostingersite\.com|staging|localhost|\.test$)/i', (string) $host )
		|| 'staging' === wp_get_environment_type();
}

add_filter(
	'wp_robots',
	function ( $robots ) {
		if ( kf_is_staging() ) {
			return array(
				'noindex'  => true,
				'nofollow' => true,
			);
		}
		return $robots;
	}
);

/** Page-specific title / description. */
function kf_page_meta() {
	$title = kf_get( 'meta.title' );
	$desc  = kf_get( 'meta.description' );
	$slug  = get_query_var( 'kf_company' );
	if ( $slug && ( $b = kf_brand( $slug ) ) ) {
		$title = $b['name'] . ' — ' . rtrim( $b['headline'], '.。' ) . ' | KeFamily';
		$desc  = $b['desc'];
	} elseif ( is_page( 'about' ) ) {
		$title = kf_is_rtl() ? 'من نحن | KeFamily — الشركة الأم لـ KePixel وKeMarq وKeChat وKeClinic' : 'About KeFamily — parent of KePixel, KeMarq, KeChat & KeClinic';
		$desc  = kf_get( 'about.sub' );
	} elseif ( is_page( 'contact' ) ) {
		$title = kf_get( 'contact.title' ) . ' — ' . ( kf_is_rtl() ? 'واتساب ونموذج تواصل' : 'WhatsApp & contact form' ) . ' | KeFamily';
		$desc  = kf_get( 'contact.sub' );
	} elseif ( is_404() ) {
		$title = kf_get( 'notfound.title' ) . ' | KeFamily';
	} elseif ( ! is_front_page() && is_singular() ) {
		$title = get_the_title() . ' | KeFamily';
		$desc  = wp_strip_all_tags( get_the_excerpt() );
	}
	return array( $title, $desc );
}

add_filter(
	'pre_get_document_title',
	function ( $t ) {
		if ( kf_has_seo_plugin() ) {
			return $t;
		}
		list( $title ) = kf_page_meta();
		return $title;
	},
	20
);

add_action(
	'wp_head',
	function () {
		$path = wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/', PHP_URL_PATH );
		$base = home_url( $path ? $path : '/' );
		$home_path = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
		if ( '/' !== $home_path && $home_path && 0 === strpos( (string) $path, rtrim( $home_path, '/' ) ) ) {
			$base = home_url( substr( $path, strlen( rtrim( $home_path, '/' ) ) ) );
		}
		$ar = $base;
		$en = add_query_arg( 'lang', 'en', $base );

		echo '<link rel="alternate" hreflang="ar" href="' . esc_url( $ar ) . '">' . "\n";
		echo '<link rel="alternate" hreflang="en" href="' . esc_url( $en ) . '">' . "\n";
		echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( $ar ) . '">' . "\n";

		if ( kf_has_seo_plugin() ) {
			return;
		}
		list( $title, $desc ) = kf_page_meta();
		$canonical = kf_is_rtl() ? $ar : $en;
		$og_image  = KF_URI . '/assets/img/og.png';
		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
		echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
		echo '<meta property="og:type" content="website">' . "\n";
		echo '<meta property="og:site_name" content="KeFamily">' . "\n";
		echo '<meta property="og:locale" content="' . ( kf_is_rtl() ? 'ar_SA' : 'en_US' ) . '">' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $canonical ) . '">' . "\n";
		echo '<meta property="og:image" content="' . esc_url( $og_image ) . '">' . "\n";
		echo '<meta property="og:image:width" content="1200"><meta property="og:image:height" content="630">' . "\n";
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

		$subs = array();
		foreach ( array_keys( kf_brands_meta() ) as $slug ) {
			$b   = kf_brand( $slug );
			$org = array(
				'@type'       => 'Organization',
				'name'        => $b['name'],
				'description' => $b['desc'],
			);
			if ( ! empty( $b['url'] ) ) {
				$org['url'] = $b['url'];
			}
			$subs[] = $org;
		}
		$schema = array(
			'@context'        => 'https://schema.org',
			'@type'           => 'Organization',
			'name'            => 'KeFamily',
			'url'             => home_url( '/' ),
			'logo'            => KF_URI . '/assets/img/logo-mark.png',
			'description'     => kf_get( 'meta.description' ),
			'subOrganization' => $subs,
			'contactPoint'    => array(
				'@type'             => 'ContactPoint',
				'contactType'       => 'sales',
				'telephone'         => kf_whatsapp_display(),
				'availableLanguage' => array( 'Arabic', 'English' ),
			),
			'areaServed'      => array( 'SA', 'EG', 'AE', 'KW', 'QA', 'BH', 'OM' ),
		);
		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";

		$crumbs = array( array( kf_get( 'nav.home' ), kf_url() ) );
		$slug   = get_query_var( 'kf_company' );
		if ( $slug && ( $cb = kf_brand( $slug ) ) ) {
			$crumbs[] = array( kf_get( 'nav.companies' ), kf_url( '#companies' ) );
			$crumbs[] = array( $cb['name'], kf_company_url( $slug ) );
		} elseif ( is_page( 'about' ) ) {
			$crumbs[] = array( kf_get( 'nav.about' ), kf_url( 'about/' ) );
		} elseif ( is_page( 'contact' ) ) {
			$crumbs[] = array( kf_get( 'nav.contact' ), kf_url( 'contact/' ) );
		}
		if ( count( $crumbs ) > 1 ) {
			$items = array();
			foreach ( $crumbs as $i => $c ) {
				$items[] = array(
					'@type'    => 'ListItem',
					'position' => $i + 1,
					'name'     => $c[0],
					'item'     => $c[1],
				);
			}
			echo '<script type="application/ld+json">' . wp_json_encode(
				array(
					'@context'        => 'https://schema.org',
					'@type'           => 'BreadcrumbList',
					'itemListElement' => $items,
				),
				JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
			) . '</script>' . "\n";
		}
	},
	5
);

/* ---------- XML sitemap ---------- */

/* No author archives in the sitemap (they leak usernames and add thin pages). */
add_filter(
	'wp_sitemaps_add_provider',
	function ( $provider, $name ) {
		return 'users' === $name ? false : $provider;
	},
	10,
	2
);

/* Private leads must never be listed. */
add_filter(
	'wp_sitemaps_post_types',
	function ( $types ) {
		unset( $types['kf_lead'] );
		return $types;
	}
);

/**
 * Adds the theme-routed pages (company pages) and every English version.
 */
add_action(
	'init',
	function () {
		if ( ! class_exists( 'WP_Sitemaps_Provider' ) ) {
			return;
		}
		if ( ! class_exists( 'KF_Sitemap_Provider' ) ) {
			class KF_Sitemap_Provider extends WP_Sitemaps_Provider {
				public function __construct() {
					$this->name        = 'kefamily';
					$this->object_type = 'kefamily';
				}
				public function get_url_list( $page_num, $object_subtype = '' ) {
					$paths = array( '', 'about/', 'contact/' );
					foreach ( array_keys( kf_brands_meta() ) as $slug ) {
						$paths[] = 'companies/' . $slug . '/';
					}
					$list = array();
					foreach ( $paths as $p ) {
						if ( '' !== $p ) { // Arabic home is already in the core pages sitemap.
							$list[] = array( 'loc' => home_url( '/' . $p ) );
						}
						$list[] = array( 'loc' => add_query_arg( 'lang', 'en', home_url( '/' . $p ) ) );
					}
					return $list;
				}
				public function get_max_num_pages( $object_subtype = '' ) {
					return 1;
				}
			}
		}
		wp_register_sitemap_provider( 'kefamily', new KF_Sitemap_Provider() );
	}
);

/* Keep the About/Contact placeholder pages out of the default pages sitemap (already listed above with both languages). */
add_filter(
	'wp_sitemaps_posts_query_args',
	function ( $args, $post_type ) {
		if ( 'page' === $post_type ) {
			$ids = array();
			foreach ( array( 'about', 'contact' ) as $slug ) {
				$p = get_page_by_path( $slug );
				if ( $p ) {
					$ids[] = $p->ID;
				}
			}
			$args['post__not_in'] = isset( $args['post__not_in'] ) ? array_merge( (array) $args['post__not_in'], $ids ) : $ids;
		}
		return $args;
	},
	10,
	2
);
