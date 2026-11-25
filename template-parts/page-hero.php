<?php
/**
 * Generic inner-page hero.
 * Args: eyebrow, title, sub, center (bool), style (brand css vars), ctas (bool).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$a = wp_parse_args(
	$args,
	array(
		'eyebrow' => '',
		'title'   => '',
		'sub'     => '',
		'center'  => true,
		'style'   => '',
		'ctas'    => false,
	)
);
?>
<section class="phero" <?php echo $a['style'] ? 'style="' . esc_attr( $a['style'] ) . '"' : ''; ?>>
	<div class="phero__glow" aria-hidden="true"></div>
	<div class="hero__grid" aria-hidden="true"></div>
	<div class="wrap phero__inner <?php echo $a['center'] ? 'phero__inner--center' : ''; ?>">
		<?php kf_part( 'crumbs' ); ?>
		<?php if ( $a['eyebrow'] ) : ?><span class="eyebrow reveal"><?php echo esc_html( $a['eyebrow'] ); ?></span><?php endif; ?>
		<h1 class="h1 reveal" style="--d:.06s"><?php echo esc_html( $a['title'] ); ?></h1>
		<?php if ( $a['sub'] ) : ?><p class="lead reveal" style="--d:.12s"><?php echo esc_html( $a['sub'] ); ?></p><?php endif; ?>
		<?php if ( $a['ctas'] ) : ?>
			<div class="hero__ctas <?php echo $a['center'] ? 'hero__ctas--center' : ''; ?> reveal" style="--d:.18s">
				<a class="btn btn--shimmer" href="<?php echo esc_url( kf_route_url( 'contact' ) ); ?>" data-magnetic><span class="btn__shine" aria-hidden="true"></span><span class="btn__label"><?php kf_e( 'cta.btn1' ); ?></span><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></a>
				<a class="btn btn--ghost" href="<?php echo esc_url( kf_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php echo kf_icon( 'whatsapp' ); // phpcs:ignore ?><span><?php kf_e( 'cta.btn2' ); ?></span></a>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $args['after'] ) && is_callable( $args['after'] ) ) { call_user_func( $args['after'] ); } ?>
	</div>
</section>
