<?php
/**
 * Legal pages — /privacy-policy/ and /terms/
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();
$key = kf_route();
$p   = kf_get( 'pages.' . $key );

kf_part(
	'page-hero',
	array(
		'title'  => $p['title'],
		'sub'    => $p['updated'],
		'center' => false,
	)
);
?>
<section class="section section--tight">
	<div class="wrap legal">
		<?php foreach ( $p['sections'] as $sec ) : ?>
			<div class="reveal">
				<h2><?php echo esc_html( $sec[0] ); ?></h2>
				<p><?php echo esc_html( $sec[1] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php
get_footer();
