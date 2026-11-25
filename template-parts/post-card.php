<?php
/**
 * Blog card. Args: post (WP_Post), i (int), hl (heading level).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$p     = $args['post'];
$i     = isset( $args['i'] ) ? (int) $args['i'] : 0;
$hl    = isset( $args['hl'] ) ? $args['hl'] : 'h3';
$topic = kf_post_topic( $p );
$style = $topic && isset( kf_brands_meta()[ $topic ] ) ? kf_brand_style( $topic ) : '';
?>
<article class="post-card reveal" style="<?php echo esc_attr( $style ); ?>;--d:<?php echo esc_attr( 0.05 * $i ); ?>s">
	<div class="post-card__meta">
		<?php if ( $style ) : ?><span class="tag" dir="ltr"><i class="dot" aria-hidden="true"></i><?php echo esc_html( kf_brand( $topic )['name'] ); ?></span><?php endif; ?>
		<time datetime="<?php echo esc_attr( get_the_date( 'c', $p ) ); ?>"><?php echo esc_html( kf_date( $p ) ); ?></time>
	</div>
	<<?php echo esc_html( $hl ); ?> class="post-card__title"><a href="<?php echo esc_url( kf_post_url( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a></<?php echo esc_html( $hl ); ?>>
	<p class="post-card__ex"><?php echo esc_html( wp_trim_words( get_the_excerpt( $p ), 26 ) ); ?></p>
	<p class="post-card__foot"><span><?php echo (int) kf_reading_time( $p ); ?> <?php kf_e( 'blog_ui.read' ); ?></span><span class="link-arrow" aria-hidden="true"><?php kf_e( 'blog_ui.more' ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></span></p>
</article>
