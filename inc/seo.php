<?php
/**
 * Technical SEO: titles, meta description, canonical, hreflang, Open Graph,
 * Twitter, JSON-LD (Organization, WebSite, BreadcrumbList, Service, FAQPage),
 * XML sitemap, staging noindex.
 *
 * Skips its own head tags when Yoast / Rank Math is active.
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
		$robots['max-image-preview'] = 'large';
		return $robots;
	}
);

/** Title + description for whatever is being shown. */
function kf_page_meta() {
	if ( kf_route() ) {
		$m = kf_route_meta();
		return array( $m['title'], $m['desc'] );
	}
	if ( is_404() ) {
		return array( kf_get( 'notfound.title' ) . ' | KeFamily', kf_get( 'meta.description' ) );
	}
	if ( is_singular() ) {
		return array( get_the_title() . ' | KeFamily', wp_strip_all_tags( get_the_excerpt() ) );
	}
	return array( kf_get( 'meta.title' ), kf_get( 'meta.description' ) );
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

function kf_json_ld( $data ) {
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}

/** Canonical URL of the current page (current language). */
function kf_canonical_url() {
	$alts = kf_alt_urls();
	if ( isset( $alts[ kf_lang() ] ) ) {
		return $alts[ kf_lang() ];
	}
	$path = wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/', PHP_URL_PATH );
	return home_url( $path ? $path : '/' );
}

add_action(
	'wp_head',
	function () {
		$langs = kf_langs();
		$alts  = is_404() ? array() : kf_alt_urls();
		foreach ( $alts as $code => $url ) {
			echo '<link rel="alternate" hreflang="' . esc_attr( $langs[ $code ]['hreflang'] ) . '" href="' . esc_url( $url ) . '">' . "\n";
		}
		if ( isset( $alts['en'] ) ) {
			echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( $alts['en'] ) . '">' . "\n";
		}

		if ( kf_has_seo_plugin() ) {
			return;
		}
		list( $title, $desc ) = kf_page_meta();
		$canonical = kf_canonical_url();
		$post      = 'post' === kf_route() ? kf_current_post() : null;
		$og_image  = KF_URI . '/assets/img/og.png';
		if ( $post && has_post_thumbnail( $post ) ) {
			$og_image = get_the_post_thumbnail_url( $post, 'large' );
		}

		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
		if ( ! is_404() ) {
			echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
		}
		echo '<meta property="og:type" content="' . ( $post ? 'article' : 'website' ) . '">' . "\n";
		echo '<meta property="og:site_name" content="KeFamily">' . "\n";
		echo '<meta property="og:locale" content="' . esc_attr( $langs[ kf_lang() ]['locale'] ) . '">' . "\n";
		foreach ( array_keys( $alts ) as $code ) {
			if ( $code !== kf_lang() ) {
				echo '<meta property="og:locale:alternate" content="' . esc_attr( $langs[ $code ]['locale'] ) . '">' . "\n";
			}
		}
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $canonical ) . '">' . "\n";
		echo '<meta property="og:image" content="' . esc_url( $og_image ) . '">' . "\n";
		if ( ! $post || ! has_post_thumbnail( $post ) ) {
			echo '<meta property="og:image:width" content="1200"><meta property="og:image:height" content="630">' . "\n";
		}
		echo '<meta property="og:image:alt" content="KeFamily — KePixel, KeMarq, KeChat, KeClinic">' . "\n";
		if ( $post ) {
			echo '<meta property="article:published_time" content="' . esc_attr( get_the_date( 'c', $post ) ) . '">' . "\n";
			echo '<meta property="article:modified_time" content="' . esc_attr( get_the_modified_date( 'c', $post ) ) . '">' . "\n";
		}
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
		echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
		echo '<meta name="twitter:image" content="' . esc_url( $og_image ) . '">' . "\n";

		if ( $post ) {
			kf_json_ld(
				array(
					'@context'         => 'https://schema.org',
					'@type'            => 'BlogPosting',
					'headline'         => get_the_title( $post ),
					'description'      => $desc,
					'inLanguage'       => $langs[ kf_lang() ]['hreflang'],
					'datePublished'    => get_the_date( 'c', $post ),
					'dateModified'     => get_the_modified_date( 'c', $post ),
					'mainEntityOfPage' => $canonical,
					'image'            => $og_image,
					'wordCount'        => count( preg_split( '/\s+/u', wp_strip_all_tags( $post->post_content ) ) ),
					'author'           => array( '@type' => 'Organization', 'name' => 'KeFamily', '@id' => home_url( '/#organization' ) ),
					'publisher'        => array( '@id' => home_url( '/#organization' ) ),
				)
			);
		}

		/* Organization (+ sub-organizations) on every page. */
		$subs = array();
		foreach ( array_keys( kf_brands_meta() ) as $slug ) {
			$b   = kf_brand( $slug );
			$sub = array(
				'@type'       => 'Organization',
				'@id'         => home_url( '/#' . $slug ),
				'name'        => $b['name'],
				'description' => $b['desc'],
			);
			if ( ! empty( $b['url'] ) ) {
				$sub['url'] = $b['url'];
			}
			$subs[] = $sub;
		}
		$same = array_values( array_filter( array( get_theme_mod( 'kf_linkedin', '' ), get_theme_mod( 'kf_instagram', '' ) ) ) );
		$org  = array(
			'@context'        => 'https://schema.org',
			'@type'           => 'Organization',
			'@id'             => home_url( '/#organization' ),
			'name'            => 'KeFamily',
			'url'             => home_url( '/' ),
			'logo'            => KF_URI . '/assets/img/icon-512.png',
			'description'     => kf_get( 'meta.description' ),
			'subOrganization' => $subs,
			'contactPoint'    => array(
				'@type'             => 'ContactPoint',
				'contactType'       => 'sales',
				'telephone'         => kf_whatsapp_display(),
				'availableLanguage' => array( 'English', 'Arabic', 'Russian', 'German' ),
			),
			'areaServed'      => array( 'SA', 'EG', 'AE', 'KW', 'QA', 'BH', 'OM' ),
		);
		if ( $same ) {
			$org['sameAs'] = $same;
		}
		kf_json_ld( $org );

		if ( 'home' === kf_route() ) {
			kf_json_ld(
				array(
					'@context'   => 'https://schema.org',
					'@type'      => 'WebSite',
					'@id'        => home_url( '/#website' ),
					'url'        => home_url( '/' ),
					'name'       => 'KeFamily',
					'inLanguage' => array( 'en', 'ar', 'ru', 'de' ),
					'publisher'  => array( '@id' => home_url( '/#organization' ) ),
				)
			);
		}

		/* Breadcrumbs. */
		if ( kf_route() && 'home' !== kf_route() ) {
			$m     = kf_route_meta();
			$items = array();
			foreach ( $m['crumbs'] as $i => $c ) {
				$items[] = array(
					'@type'    => 'ListItem',
					'position' => $i + 1,
					'name'     => $c[0],
					'item'     => $c[1],
				);
			}
			kf_json_ld(
				array(
					'@context'        => 'https://schema.org',
					'@type'           => 'BreadcrumbList',
					'itemListElement' => $items,
				)
			);
		}

		/* Service schema on company pages. */
		$brand = kf_route_brand();
		if ( $brand ) {
			$b   = kf_brand( $brand );
			$svc = array(
				'@context'    => 'https://schema.org',
				'@type'       => 'Service',
				'name'        => $b['name'] . ' — ' . $b['tag'],
				'description' => $b['desc'],
				'provider'    => array( '@id' => home_url( '/#' . $brand ) ),
				'areaServed'  => array( 'SA', 'EG', 'AE', 'KW', 'QA', 'BH', 'OM' ),
				'serviceType' => $b['tag'],
			);
			if ( ! empty( $b['url'] ) ) {
				$svc['url'] = $b['url'];
			}
			kf_json_ld( $svc );
		}
	},
	5
);

/** FAQPage schema helper (used by templates that print an FAQ). */
function kf_faq_schema( $items ) {
	if ( ! $items ) {
		return;
	}
	kf_json_ld(
		array(
			'@context'   => 'https://schema.org',
			'@type'      => 'FAQPage',
			'mainEntity' => array_map(
				function ( $q ) {
					return array(
						'@type'          => 'Question',
						'name'           => $q[0],
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => $q[1],
						),
					);
				},
				array_values( $items )
			),
		)
	);
}

/* ---------- XML sitemap ---------- */

add_filter(
	'wp_sitemaps_add_provider',
	function ( $provider, $name ) {
		return 'users' === $name ? false : $provider;
	},
	10,
	2
);

add_filter(
	'wp_sitemaps_post_types',
	function ( $types ) {
		unset( $types['kf_lead'], $types['post'] );
		return $types;
	}
);

/* Theme routes replace the legacy About/Contact WP pages — keep those out. */
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
			$args['post__not_in'] = array_merge( isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array(), $ids );
		}
		return $args;
	},
	10,
	2
);

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
					$list = array();
					foreach ( kf_routes() as $route ) {
						foreach ( array_keys( kf_langs() ) as $lang ) {
							$list[] = array( 'loc' => kf_url( $route[0], $lang ) );
						}
					}
					$posts = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 500, 'meta_key' => '_kf_lang' ) ); // phpcs:ignore
					foreach ( $posts as $p ) {
						$list[] = array(
							'loc'     => kf_post_url( $p ),
							'lastmod' => get_post_modified_time( 'c', true, $p ),
						);
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
