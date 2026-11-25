<?php
/**
 * Solution by industry — /solutions/{sector}/
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

$slug = kf_route_sector();
$s    = kf_get( 'sectors_pages.' . $slug );
$ui   = kf_get( 'sector_ui' );
get_header();

kf_part(
	'page-hero',
	array(
		'eyebrow' => $s['name'],
		'title'   => $s['title'],
		'sub'     => $s['intro'],
		'ctas'    => true,
	)
);
?>
<section class="section section--tight">
	<div class="wrap sol-grid">
		<div class="panel reveal">
			<h2><?php echo esc_html( $ui['pains_t'] ); ?></h2>
			<ul class="pains">
				<?php foreach ( $s['pains'] as $p ) : ?>
					<li><span class="x" aria-hidden="true">✕</span><?php echo esc_html( $p ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="panel reveal" style="--d:.08s">
			<h2><?php echo esc_html( $ui['outcomes_t'] ); ?></h2>
			<ul class="ticks">
				<?php foreach ( $s['outcomes'] as $o ) : ?>
					<li><?php echo kf_icon( 'check' ); // phpcs:ignore ?><?php echo esc_html( $o ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<header class="head reveal">
			<span class="eyebrow"><?php echo esc_html( $s['name'] ); ?></span>
			<h2 class="h2"><?php echo esc_html( $ui['plan_t'] ); ?></h2>
		</header>
		<ol class="plan">
			<?php foreach ( $s['plan'] as $i => $pl ) : $b = kf_brand( $pl[0] ); ?>
				<li class="spotlight reveal" style="<?php echo esc_attr( kf_brand_style( $pl[0] ) ); ?>;--d:<?php echo esc_attr( 0.06 * $i ); ?>s">
					<a class="badge" href="<?php echo esc_url( kf_company_url( $pl[0] ) ); ?>"><?php echo kf_icon( $pl[0] ); // phpcs:ignore ?><span dir="ltr"><?php echo esc_html( $b['name'] ); ?></span></a>
					<p><?php echo esc_html( $pl[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="section section--alt">
	<div class="wrap faq-wrap">
		<header class="head reveal">
			<span class="eyebrow"><?php kf_e( 'faq.eyebrow' ); ?></span>
			<h2 class="h2"><?php echo esc_html( $ui['faq_t'] ); ?></h2>
		</header>
		<?php kf_part( 'faq-list', array( 'items' => $s['faq'] ) ); ?>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<header class="head reveal">
			<h2 class="eyebrow eyebrow--h"><?php echo esc_html( $ui['others_t'] ); ?></h2>
		</header>
		<?php kf_part( 'sector-cards', array( 'exclude' => $slug ) ); ?>
	</div>
</section>

<?php
kf_part( 'cta' );
get_footer();
