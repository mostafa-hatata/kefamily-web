<?php
/**
 * Solutions hub — /solutions/
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();

kf_part(
	'page-hero',
	array(
		'eyebrow' => kf_get( 'pages.solutions.eyebrow' ),
		'title'   => kf_get( 'pages.solutions.title' ),
		'sub'     => kf_get( 'pages.solutions.sub' ),
	)
);
?>
<section class="section section--tight">
	<div class="wrap">
		<?php kf_part( 'sector-cards', array( 'heading_level' => 'h2' ) ); ?>
	</div>
</section>

<?php
kf_part( 'cta' );
get_footer();
