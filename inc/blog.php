<?php
/**
 * Multilingual blog on top of normal WordPress posts.
 *
 * Each post carries:
 *  - _kf_lang  : en | ar | ru | de
 *  - _kf_slug  : URL slug shared by all translations of the same article
 *  - _kf_topic : kefamily | kepixel | kemarq | kechat | keclinic
 * URL: /blog/{slug}/ (English), /{lang}/blog/{slug}/ (others).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

function kf_blog_topics() {
	return array( 'kefamily', 'kepixel', 'kemarq', 'kechat', 'keclinic' );
}

function kf_post_lang( $post ) {
	$l = get_post_meta( is_object( $post ) ? $post->ID : $post, '_kf_lang', true );
	return isset( kf_langs()[ $l ] ) ? $l : 'en';
}

function kf_post_slug( $post ) {
	$post = get_post( $post );
	$s    = get_post_meta( $post->ID, '_kf_slug', true );
	return $s ? $s : $post->post_name;
}

function kf_post_topic( $post ) {
	$t = get_post_meta( is_object( $post ) ? $post->ID : $post, '_kf_topic', true );
	return in_array( $t, kf_blog_topics(), true ) ? $t : 'kefamily';
}

function kf_post_url( $post ) {
	return kf_url( 'blog/' . kf_post_slug( $post ) . '/', kf_post_lang( $post ) );
}

/** The post requested by /blog/{slug}/ in the current language. */
function kf_current_post() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache ? $cache : null;
	}
	$slug = sanitize_title( (string) get_query_var( 'kf_post' ) );
	if ( '' === $slug ) {
		$cache = false;
		return null;
	}
	$q     = new WP_Query(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
			'meta_query'     => array( // phpcs:ignore
				array( 'key' => '_kf_slug', 'value' => $slug ),
				array( 'key' => '_kf_lang', 'value' => kf_lang() ),
			),
		)
	);
	$cache = $q->have_posts() ? $q->posts[0] : false;
	return $cache ? $cache : null;
}

/** All published translations of a post, keyed by language. */
function kf_post_translations( $post ) {
	$q   = new WP_Query(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 10,
			'no_found_rows'  => true,
			'meta_query'     => array( array( 'key' => '_kf_slug', 'value' => kf_post_slug( $post ) ) ), // phpcs:ignore
		)
	);
	$out = array();
	foreach ( $q->posts as $p ) {
		$out[ kf_post_lang( $p ) ] = $p;
	}
	return $out;
}

/** Blog listing query for the current language. */
function kf_blog_query( $paged = 1, $topic = '', $per_page = 9, $exclude = array() ) {
	$meta = array( array( 'key' => '_kf_lang', 'value' => kf_lang() ) );
	if ( $topic ) {
		$meta[] = array( 'key' => '_kf_topic', 'value' => $topic );
	}
	return new WP_Query(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $per_page,
			'paged'          => max( 1, (int) $paged ),
			'post__not_in'   => $exclude,
			'meta_query'     => $meta, // phpcs:ignore
		)
	);
}

/** Reading time in minutes. */
function kf_reading_time( $post ) {
	$words = count( preg_split( '/\s+/u', wp_strip_all_tags( get_post_field( 'post_content', $post ) ) ) );
	return max( 1, (int) round( $words / 200 ) );
}

/** Make WordPress' own links (admin "View post", REST) point to our URLs. */
add_filter(
	'post_link',
	function ( $url, $post ) {
		return 'post' === $post->post_type && 'publish' === $post->post_status ? kf_post_url( $post ) : $url;
	},
	10,
	2
);

/* Old WP single-post URLs → language URL. */
add_action(
	'template_redirect',
	function () {
		if ( is_singular( 'post' ) && ! kf_route() ) {
			wp_safe_redirect( kf_post_url( get_queried_object() ), 301 );
			exit;
		}
	}
);

/* ---------- Admin: language / slug / topic box ---------- */
add_action(
	'add_meta_boxes',
	function () {
		add_meta_box( 'kf_post_lang', 'KeFamily — language & URL', 'kf_post_lang_box', 'post', 'side', 'high' );
	}
);

function kf_post_lang_box( $post ) {
	wp_nonce_field( 'kf_post_lang', 'kf_post_lang_nonce' );
	$lang  = kf_post_lang( $post );
	$slug  = get_post_meta( $post->ID, '_kf_slug', true );
	$topic = kf_post_topic( $post );
	echo '<p><label><strong>Language</strong><br><select name="kf_lang" style="width:100%">';
	foreach ( kf_langs() as $k => $l ) {
		printf( '<option value="%s" %s>%s</option>', esc_attr( $k ), selected( $lang, $k, false ), esc_html( $l['name'] ) );
	}
	echo '</select></label></p>';
	echo '<p><label><strong>Shared URL slug</strong><br><input type="text" name="kf_slug" value="' . esc_attr( $slug ) . '" style="width:100%" placeholder="e.g. server-side-tracking"></label><br><small>Use the same slug for every translation of this article — that links them (hreflang). Latin letters, numbers and dashes.</small></p>';
	echo '<p><label><strong>Topic</strong><br><select name="kf_topic" style="width:100%">';
	foreach ( kf_blog_topics() as $t ) {
		printf( '<option value="%s" %s>%s</option>', esc_attr( $t ), selected( $topic, $t, false ), esc_html( 'kefamily' === $t ? 'KeFamily' : kf_brands_meta()[ $t ]['name'] ) );
	}
	echo '</select></label></p>';
}

add_action(
	'save_post_post',
	function ( $post_id ) {
		if ( ! isset( $_POST['kf_post_lang_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kf_post_lang_nonce'] ) ), 'kf_post_lang' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		$lang  = isset( $_POST['kf_lang'] ) ? sanitize_key( wp_unslash( $_POST['kf_lang'] ) ) : 'en';
		$slug  = isset( $_POST['kf_slug'] ) ? sanitize_title( wp_unslash( $_POST['kf_slug'] ) ) : '';
		$topic = isset( $_POST['kf_topic'] ) ? sanitize_key( wp_unslash( $_POST['kf_topic'] ) ) : 'kefamily';
		update_post_meta( $post_id, '_kf_lang', isset( kf_langs()[ $lang ] ) ? $lang : 'en' );
		update_post_meta( $post_id, '_kf_slug', $slug ? $slug : sanitize_title( get_post_field( 'post_name', $post_id ) ) );
		update_post_meta( $post_id, '_kf_topic', in_array( $topic, kf_blog_topics(), true ) ? $topic : 'kefamily' );
	}
);

/* Admin list column. */
add_filter(
	'manage_post_posts_columns',
	function ( $c ) {
		$c['kf_lang'] = 'Lang';
		return $c;
	}
);
add_action(
	'manage_post_posts_custom_column',
	function ( $col, $id ) {
		if ( 'kf_lang' === $col ) {
			echo esc_html( strtoupper( kf_post_lang( $id ) ) . ' · ' . get_post_meta( $id, '_kf_slug', true ) );
		}
	},
	10,
	2
);

/* ---------- Seed articles (once per seed version) ---------- */
add_action(
	'init',
	function () {
		$ver = 2;
		if ( (int) get_option( 'kf_seed_posts' ) >= $ver ) {
			return;
		}
		require_once KF_DIR . '/inc/seed-posts.php';
		$cat = get_cat_ID( 'Insights' );
		if ( ! $cat ) {
			$cat = (int) wp_insert_term( 'Insights', 'category' )['term_id'];
		}
		foreach ( kf_seed_posts() as $slug => $article ) {
			foreach ( $article['langs'] as $lang => $a ) {
				$exists = get_posts(
					array(
						'post_type'   => 'post',
						'post_status' => 'any',
						'numberposts' => 1,
						'fields'      => 'ids',
						'meta_query'  => array( array( 'key' => '_kf_slug', 'value' => $slug ), array( 'key' => '_kf_lang', 'value' => $lang ) ), // phpcs:ignore
					)
				);
				if ( $exists ) {
					continue;
				}
				$id = wp_insert_post(
					array(
						'post_type'     => 'post',
						'post_status'   => 'publish',
						'post_title'    => $a['title'],
						'post_excerpt'  => $a['excerpt'],
						'post_content'  => $a['content'],
						'post_name'     => $slug . ( 'en' === $lang ? '' : '-' . $lang ),
						'post_date'     => $article['date'],
						'post_category' => array( $cat ),
					)
				);
				if ( $id && ! is_wp_error( $id ) ) {
					update_post_meta( $id, '_kf_lang', $lang );
					update_post_meta( $id, '_kf_slug', $slug );
					update_post_meta( $id, '_kf_topic', $article['topic'] );
				}
			}
		}
		// The default "Hello world!" post is not part of the site.
		$hello = get_page_by_path( 'hello-world', OBJECT, 'post' );
		if ( $hello && ! get_post_meta( $hello->ID, '_kf_slug', true ) ) {
			wp_trash_post( $hello->ID );
		}
		update_option( 'kf_seed_posts', $ver );
	},
	20
);

/** Post date in the page language (Intl when available). */
function kf_date( $post, $long = false ) {
	$ts = get_post_timestamp( $post );
	if ( class_exists( 'IntlDateFormatter' ) ) {
		$f = new IntlDateFormatter( kf_langs()[ kf_lang() ]['locale'], $long ? IntlDateFormatter::LONG : IntlDateFormatter::MEDIUM, IntlDateFormatter::NONE, 'UTC' );
		$out = $f->format( $ts );
		if ( $out ) {
			return $out;
		}
	}
	return gmdate( 'Y-m-d', $ts );
}
