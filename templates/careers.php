<?php
/**
 * Careers — /careers/
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();
$p = kf_get( 'pages.careers' );

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
			<h2 class="h2"><?php echo esc_html( $p['how_t'] ); ?></h2>
		</header>
		<div class="values">
			<?php foreach ( $p['how'] as $i => $v ) : ?>
				<div class="value spotlight reveal" data-spotlight style="--d: <?php echo esc_attr( 0.06 * $i ); ?>s">
					<span class="value__icon"><?php echo kf_icon( $v[0] ); // phpcs:ignore ?></span>
					<h3><?php echo esc_html( $v[1] ); ?></h3>
					<p><?php echo esc_html( $v[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--alt">
	<div class="wrap contact">
		<div class="contact__info">
			<h2 class="h2 reveal"><?php echo esc_html( $p['roles_t'] ); ?></h2>
			<ul class="chips-list reveal">
				<?php foreach ( $p['roles'] as $r ) : ?><li><?php echo esc_html( $r ); ?></li><?php endforeach; ?>
			</ul>
			<h2 class="h2 reveal" style="margin-top:24px"><?php echo esc_html( $p['form_t'] ); ?></h2>
			<p class="lead reveal"><?php echo esc_html( $p['form_sub'] ); ?></p>
		</div>
		<?php kf_part( 'form', array( 'page' => 'careers', 'interests' => false ) ); ?>
	</div>
</section>
<?php
get_footer();
