<?php
/**
 * About — /about/
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();

kf_part(
	'page-hero',
	array(
		'eyebrow' => kf_get( 'about.eyebrow' ),
		'title'   => kf_get( 'about.title' ),
		'sub'     => kf_get( 'about.sub' ),
		'after'   => function () {
			echo '<div class="about-family reveal" style="--d:.2s">';
			foreach ( array_keys( kf_brands_meta() ) as $s ) {
				$b = kf_brand( $s );
				printf(
					'<a href="%s" style="%s">%s<b dir="ltr">%s</b></a>',
					esc_url( kf_company_url( $s ) ),
					esc_attr( kf_brand_style( $s ) ),
					kf_icon( $s ), // phpcs:ignore
					esc_html( $b['name'] )
				);
			}
			echo '</div>';
		},
	)
);
?>

<section class="section">
	<div class="wrap story">
		<header class="head reveal">
			<h2 class="eyebrow eyebrow--h"><?php kf_e( 'about.story_t' ); ?></h2>
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
		<div class="mv__card reveal">
			
			<h2 class="eyebrow eyebrow--h"><?php kf_e( 'about.mission_t' ); ?></h2>
			<p><?php kf_e( 'about.mission' ); ?></p>
		</div>
		<div class="mv__card reveal" style="--d:.08s">
			<h2 class="eyebrow eyebrow--h"><?php kf_e( 'about.vision_t' ); ?></h2>
			<p><?php kf_e( 'about.vision' ); ?></p>
		</div>
	</div>
</section>

<section class="section section--tight">
	<div class="wrap">
		<header class="head head--center reveal">
			<h2 class="eyebrow eyebrow--h"><?php kf_e( 'about.markets_t' ); ?></h2>
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
				<div class="value reveal" style="--d: <?php echo esc_attr( 0.06 * $i ); ?>s">
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
