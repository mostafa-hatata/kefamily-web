<?php
/**
 * Partners — /partners/
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();
$p = kf_get( 'pages.partners' );

kf_part(
	'page-hero',
	array(
		'eyebrow' => $p['eyebrow'],
		'title'   => $p['title'],
		'sub'     => $p['sub'],
	)
);
?>
<section class="section section--tight">
	<div class="wrap">
		<header class="head reveal">
			<h2 class="h2"><?php echo esc_html( $p['types_t'] ); ?></h2>
		</header>
		<div class="features">
			<?php foreach ( $p['types'] as $i => $t ) : ?>
				<div class="feature reveal" style="--d: <?php echo esc_attr( 0.06 * $i ); ?>s">
					<span class="value__icon" style="margin:0 0 8px"><?php echo kf_icon( $t[0] ); // phpcs:ignore ?></span>
					<h3><?php echo esc_html( $t[1] ); ?></h3>
					<p><?php echo esc_html( $t[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--alt">
	<div class="wrap contact">
		<div class="contact__info">
			<h2 class="h2 reveal"><?php echo esc_html( $p['how_t'] ); ?></h2>
			<ol class="steps" style="grid-template-columns:1fr;margin-top:8px;width:100%">
				<?php foreach ( $p['how'] as $i => $h ) : ?>
					<li class="step reveal" style="--d:<?php echo esc_attr( 0.06 * $i ); ?>s"><span class="step__n" dir="ltr">0<?php echo (int) $i + 1; ?></span><h3><?php echo esc_html( $h ); ?></h3></li>
				<?php endforeach; ?>
			</ol>
		</div>
		<?php kf_part( 'form', array( 'page' => 'partners', 'interests' => false ) ); ?>
	</div>
</section>
<?php
get_footer();
