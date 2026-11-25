<?php
/**
 * 404.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="phero phero--404">
	<div class="phero__glow" aria-hidden="true"></div>
	<div class="hero__grid" aria-hidden="true"></div>
	<div class="wrap phero__inner phero__inner--center">
		<div class="big404 reveal" dir="ltr" aria-hidden="true">4<span><?php echo kf_logo_mark( 120 ); // phpcs:ignore ?></span>4</div>
		<h1 class="h1 reveal" style="--d:.08s"><?php kf_e( 'notfound.title' ); ?></h1>
		<p class="lead reveal" style="--d:.14s"><?php kf_e( 'notfound.sub' ); ?></p>
		<div class="hero__ctas hero__ctas--center reveal" style="--d:.2s">
			<a class="btn btn--shimmer" href="<?php echo esc_url( kf_url() ); ?>"><span class="btn__shine" aria-hidden="true"></span><span class="btn__label"><?php kf_e( 'notfound.btn' ); ?></span></a>
		</div>
	</div>
</section>
<?php
get_footer();
