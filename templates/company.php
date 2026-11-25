<?php
/**
 * Company page — /companies/{slug}/
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

$slug  = kf_route_brand();
$b     = kf_brand( $slug );
$style = kf_brand_style( $slug );
get_header();
?>
<div style="<?php echo esc_attr( $style ); ?>">
<section class="phero">
	<div class="phero__glow" aria-hidden="true"></div>
	<div class="hero__grid" aria-hidden="true"></div>
	<div class="wrap phero__inner">
		<?php kf_part( 'crumbs' ); ?>
		<div class="phero__cols">
			<div>
				<span class="badge badge--lg reveal"><?php echo kf_icon( $slug ); // phpcs:ignore ?><span dir="ltr"><?php echo esc_html( $b['name'] ); ?></span></span>
				<span class="eyebrow reveal" style="--d:.05s"><?php echo esc_html( $b['tag'] ); ?></span>
				<h1 class="h1 reveal" style="--d:.1s"><span class="brand-text"><?php echo esc_html( $b['headline'] ); ?></span></h1>
				<p class="lead reveal" style="--d:.15s"><?php echo esc_html( $b['desc'] ); ?></p>
				<div class="hero__ctas reveal" style="--d:.2s">
					<?php if ( ! empty( $b['url'] ) ) : ?>
						<a class="btn btn--shimmer" href="<?php echo esc_url( $b['url'] ); ?>" target="_blank" rel="noopener" data-magnetic>
							<span class="btn__shine" aria-hidden="true"></span><span class="btn__label"><?php kf_e( 'company.visit' ); ?> <span dir="ltr"><?php echo esc_html( $b['host'] ); ?></span></span><?php echo kf_icon( 'arrow-up' ); // phpcs:ignore ?>
						</a>
					<?php else : ?>
						<a class="btn btn--shimmer" href="<?php echo esc_url( kf_route_url( 'contact' ) ); ?>" data-magnetic><span class="btn__shine" aria-hidden="true"></span><span class="btn__label"><?php kf_e( 'company.talk' ); ?></span><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></a>
					<?php endif; ?>
					<a class="btn btn--ghost" href="<?php echo esc_url( kf_whatsapp_url( $b['name'] ) ); ?>" target="_blank" rel="noopener"><?php echo kf_icon( 'whatsapp' ); // phpcs:ignore ?><span><?php kf_e( 'cta.btn2' ); ?></span></a>
				</div>
			</div>
			<div class="phero__visual card card--<?php echo esc_attr( $slug ); ?> spotlight reveal" style="--d:.15s" data-spotlight aria-hidden="true">
				<span class="beam"></span>
				<div class="card__visual card__visual--tall"><?php kf_part( 'visual', array( 'slug' => $slug ) ); ?></div>
			</div>
		</div>
	</div>
</section>

<section class="section section--tight">
	<div class="wrap">
		<p class="bigtext reveal"><?php echo esc_html( $b['long'] ); ?></p>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<header class="head reveal">
			<span class="eyebrow"><?php kf_e( 'company.features' ); ?></span>
			<h2 class="h2"><?php echo esc_html( $b['name'] . ' — ' . $b['tag'] ); ?></h2>
		</header>
		<div class="features features--<?php echo (int) count( $b['features'] ); ?>">
			<?php foreach ( $b['features'] as $i => $f ) : ?>
				<div class="feature spotlight reveal" data-spotlight style="--d: <?php echo esc_attr( 0.05 * $i ); ?>s">
					<span class="feature__n" dir="ltr">0<?php echo (int) $i + 1; ?></span>
					<h3><?php echo esc_html( $f[0] ); ?></h3>
					<p><?php echo esc_html( $f[1] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
// Industries where this company is part of the plan.
$sectors = array();
foreach ( kf_sector_slugs() as $sec ) {
	foreach ( (array) kf_get( 'sectors_pages.' . $sec . '.plan' ) as $pl ) {
		if ( $pl[0] === $slug ) {
			$sectors[ $sec ] = $pl[1];
		}
	}
}
if ( $sectors ) :
	?>
<section class="section section--tight section--alt">
	<div class="wrap">
		<header class="head reveal">
			<span class="eyebrow"><?php kf_e( 'nav.solutions' ); ?></span>
		</header>
		<div class="sector-cards">
			<?php $i = 0; foreach ( $sectors as $sec => $line ) : ?>
				<a class="sector-card spotlight reveal" data-spotlight href="<?php echo esc_url( kf_solution_url( $sec ) ); ?>" style="--d:<?php echo esc_attr( 0.05 * $i++ ); ?>s">
					<span class="value__icon" style="margin:0"><?php echo kf_sector_icon( $sec ); // phpcs:ignore ?></span>
					<h3><?php echo esc_html( kf_get( 'sectors_pages.' . $sec . '.name' ) ); ?></h3>
					<p><?php echo esc_html( $line ); ?></p>
					<span class="link-arrow"><?php kf_e( 'sector_ui.more' ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>
</div>

<section class="section section--tight">
	<div class="wrap">
		<header class="head reveal">
			<h2 class="eyebrow eyebrow--h"><?php kf_e( 'company.family' ); ?></h2>
		</header>
		<div class="siblings">
			<?php foreach ( array_keys( kf_brands_meta() ) as $s ) : if ( $s === $slug ) { continue; } $o = kf_brand( $s ); ?>
				<a class="sibling spotlight reveal" data-spotlight href="<?php echo esc_url( kf_company_url( $s ) ); ?>" style="<?php echo esc_attr( kf_brand_style( $s ) ); ?>">
					<span class="badge"><?php echo kf_icon( $s ); // phpcs:ignore ?><span dir="ltr"><?php echo esc_html( $o['name'] ); ?></span></span>
					<h3><?php echo esc_html( $o['headline'] ); ?></h3>
					<span class="link-arrow"><?php kf_e( 'companies.more' ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
kf_part( 'cta', array( 'style' => $style ) );
get_footer();
