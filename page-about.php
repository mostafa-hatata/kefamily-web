<?php
/**
 * About page (slug: about).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="phero phero--about">
	<div class="phero__glow" aria-hidden="true"></div>
	<div class="hero__grid" aria-hidden="true"></div>
	<div class="wrap phero__inner phero__inner--center">
		<span class="eyebrow reveal"><?php kf_e( 'about.eyebrow' ); ?></span>
		<h1 class="h1 reveal" style="--d:.08s"><?php kf_e( 'about.title' ); ?></h1>
		<p class="lead reveal" style="--d:.16s"><?php kf_e( 'about.sub' ); ?></p>
		<div class="about-family reveal" style="--d:.22s" aria-hidden="true">
			<?php foreach ( array_keys( kf_brands_meta() ) as $s ) : $b = kf_brand( $s ); ?>
				<span style="--c: <?php echo esc_attr( $b['color'] ); ?>; --g: <?php echo esc_attr( $b['glow'] ); ?>"><?php echo kf_icon( $s ); // phpcs:ignore ?><b dir="ltr"><?php echo esc_html( $b['name'] ); ?></b></span>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section">
	<div class="wrap story">
		<header class="head reveal">
			<span class="eyebrow"><?php kf_e( 'about.story_t' ); ?></span>
		</header>
		<ol class="timeline" data-timeline>
			<span class="timeline__line" aria-hidden="true"><i data-timeline-fill></i></span>
			<?php foreach ( (array) kf_get( 'about.story' ) as $i => $p ) : ?>
				<li class="reveal"><span class="timeline__dot" aria-hidden="true"></span><span class="timeline__n" dir="ltr">0<?php echo (int) $i + 1; ?></span><p><?php echo esc_html( $p ); ?></p></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="section section--tight">
	<div class="wrap mv">
		<div class="mv__card spotlight reveal" data-spotlight>
			<span class="beam" aria-hidden="true"></span>
			<span class="eyebrow"><?php kf_e( 'about.mission_t' ); ?></span>
			<p><?php kf_e( 'about.mission' ); ?></p>
		</div>
		<div class="mv__card spotlight reveal" data-spotlight style="--d:.08s">
			<span class="eyebrow"><?php kf_e( 'about.vision_t' ); ?></span>
			<p><?php kf_e( 'about.vision' ); ?></p>
		</div>
	</div>
</section>

<section class="section section--tight">
	<div class="wrap">
		<header class="head head--center reveal">
			<span class="eyebrow"><?php kf_e( 'about.markets_t' ); ?></span>
		</header>
		<ul class="markets">
			<?php foreach ( (array) kf_get( 'about.markets' ) as $i => $m ) : ?>
				<li class="reveal" style="--d: <?php echo esc_attr( 0.06 * $i ); ?>s"><?php echo kf_icon( 'pin' ); // phpcs:ignore ?><?php echo esc_html( $m ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<header class="head reveal">
			<span class="eyebrow"><?php kf_e( 'values.eyebrow' ); ?></span>
			<h2 class="h2"><?php kf_e( 'values.title' ); ?></h2>
		</header>
		<div class="values">
			<?php foreach ( (array) kf_get( 'values.items' ) as $i => $v ) : ?>
				<div class="value spotlight reveal" data-spotlight style="--d: <?php echo esc_attr( 0.06 * $i ); ?>s">
					<span class="value__icon"><?php echo kf_icon( $v[0] ); // phpcs:ignore ?></span>
					<h3><?php echo esc_html( $v[1] ); ?></h3>
					<p><?php echo esc_html( $v[2] ); ?></p>
					<span class="value__num" dir="ltr">0<?php echo (int) $i + 1; ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
kf_part( 'cta' );
get_footer();
