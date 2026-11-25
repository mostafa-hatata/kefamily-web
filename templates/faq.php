<?php
/**
 * FAQ — /faq/
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();
$p = kf_get( 'pages.faq' );

kf_part(
	'page-hero',
	array(
		'eyebrow' => $p['eyebrow'],
		'title'   => $p['title'],
		'sub'     => $p['sub'],
	)
);

$items = array_merge( (array) kf_get( 'faq.items' ), (array) $p['more'] );
foreach ( kf_sector_slugs() as $sec ) {
	$items = array_merge( $items, (array) kf_get( 'sectors_pages.' . $sec . '.faq' ) );
}
?>
<section class="section section--tight">
	<div class="wrap" style="max-width:900px">
		<?php kf_part( 'faq-list', array( 'items' => $items, 'hl' => 'h2' ) ); ?>
	</div>
</section>
<?php
kf_part( 'cta' );
get_footer();
