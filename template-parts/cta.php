<?php
/**
 * Closing call-to-action. Args: style (brand vars).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$style = isset( $args['style'] ) ? $args['style'] : '';
?>
<section class="cta" aria-labelledby="cta-title" <?php echo $style ? 'style="' . esc_attr( $style ) . '"' : ''; ?>>
	<div class="wrap">
		<div class="cta__inner reveal">
			<?php echo kf_logo_mark( 56 ); // phpcs:ignore ?>
			<h2 id="cta-title" class="cta__title"><?php kf_e( 'cta.title' ); ?></h2>
			<p class="lead"><?php kf_e( 'cta.sub' ); ?></p>
			<div class="hero__ctas">
				<a class="btn btn--lg btn--inv" href="<?php echo esc_url( kf_route_url( 'book' ) ); ?>"><?php echo kf_icon( 'calendar' ); // phpcs:ignore ?><span><?php kf_e( 'hero2.cta_book' ); ?></span></a>
				<a class="btn btn--lg btn--wa" href="<?php echo esc_url( kf_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php echo kf_icon( 'whatsapp' ); // phpcs:ignore ?><span><?php kf_e( 'cta.btn2' ); ?></span></a>
				<a class="link-arrow link-arrow--inv" href="<?php echo esc_url( kf_route_url( 'contact' ) ); ?>"><?php kf_e( 'cta.btn1' ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></a>
			</div>
		</div>
	</div>
</section>
