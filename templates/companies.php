<?php
/**
 * Companies hub — /companies/
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();

kf_part(
	'page-hero',
	array(
		'eyebrow' => kf_get( 'pages.companies.eyebrow' ),
		'title'   => kf_get( 'pages.companies.title' ),
		'sub'     => kf_get( 'pages.companies.sub' ),
	)
);
?>
<section class="section section--tight" id="companies">
	<div class="wrap">
		<?php kf_part( 'bento', array( 'heading_level' => 'h2' ) ); ?>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<header class="head reveal">
			<span class="eyebrow"><?php kf_e( 'nav.companies' ); ?></span>
			<h2 class="h2"><?php kf_e( 'pages.companies.which_t' ); ?></h2>
		</header>
		<div class="which">
			<?php foreach ( (array) kf_get( 'pages.companies.which' ) as $i => $w ) : $b = kf_brand( $w[0] ); ?>
				<a class="which__row spotlight reveal" data-spotlight href="<?php echo esc_url( kf_company_url( $w[0] ) ); ?>" style="<?php echo esc_attr( kf_brand_style( $w[0] ) ); ?>;--d:<?php echo esc_attr( 0.05 * $i ); ?>s">
					<span class="which__q">“<?php echo esc_html( $w[1] ); ?>”</span>
					<span class="which__a"><?php echo esc_html( $w[2] ); ?></span>
					<span class="badge"><?php echo kf_icon( $w[0] ); // phpcs:ignore ?><span dir="ltr"><?php echo esc_html( $b['name'] ); ?></span></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--flow section--alt">
	<div class="wrap">
		<header class="head head--center reveal">
			<span class="eyebrow"><?php kf_e( 'flow.eyebrow' ); ?></span>
			<h2 class="h2"><?php kf_e( 'flow.title' ); ?></h2>
		</header>
		<?php kf_part( 'beams' ); ?>
	</div>
</section>

<?php
kf_part( 'cta' );
get_footer();
