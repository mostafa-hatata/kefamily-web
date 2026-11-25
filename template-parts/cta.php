<?php
/**
 * Closing call-to-action with retro grid + meteors.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="cta" aria-labelledby="cta-title">
	<div class="wrap">
		<div class="cta__box reveal">
			<div class="retro" aria-hidden="true"><div class="retro__grid"></div></div>
			<div class="meteors" aria-hidden="true"><?php for ( $i = 0; $i < 14; $i++ ) : ?><i style="--x: <?php echo (int) ( ( $i * 37 + 11 ) % 100 ); ?>%; --t: <?php echo esc_attr( ( ( $i * 23 ) % 60 ) / 10 ); ?>s; --s: <?php echo esc_attr( 3 + ( ( $i * 17 ) % 40 ) / 10 ); ?>s"></i><?php endfor; ?></div>
			<span class="beam" aria-hidden="true"></span>
			<div class="cta__content">
				<?php echo kf_logo_mark( 48 ); // phpcs:ignore ?>
				<h2 id="cta-title" class="h2"><?php kf_e( 'cta.title' ); ?></h2>
				<p class="lead"><?php kf_e( 'cta.sub' ); ?></p>
				<div class="hero__ctas hero__ctas--center">
					<a class="btn btn--shimmer" href="<?php echo esc_url( kf_url( 'contact/' ) ); ?>" data-magnetic>
						<span class="btn__shine" aria-hidden="true"></span><span class="btn__label"><?php kf_e( 'cta.btn1' ); ?></span><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?>
					</a>
					<a class="btn btn--wa" href="<?php echo esc_url( kf_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php echo kf_icon( 'whatsapp' ); // phpcs:ignore ?><span><?php kf_e( 'cta.btn2' ); ?></span></a>
				</div>
			</div>
		</div>
	</div>
</section>
