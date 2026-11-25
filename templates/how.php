<?php
/**
 * How it works — /how-it-works/
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();
$p = kf_get( 'pages.how' );

kf_part(
	'page-hero',
	array(
		'eyebrow' => $p['eyebrow'],
		'title'   => $p['title'],
		'sub'     => $p['sub'],
	)
);
?>
<section class="section section--flow section--tight" aria-labelledby="how-flow">
	<div class="wrap">
		<h2 id="how-flow" class="sr"><?php kf_e( 'flow.title' ); ?></h2>
		<?php kf_part( 'beams' ); ?>
	</div>
</section>

<section class="section">
	<div class="wrap stages">
		<?php foreach ( $p['stages'] as $i => $st ) : $b = kf_brand( $st[0] ); ?>
			<article class="stage reveal" style="<?php echo esc_attr( kf_brand_style( $st[0] ) ); ?>">
				<span class="stage__n" dir="ltr">0<?php echo (int) $i + 1; ?></span>
				<div>
					<a class="badge" href="<?php echo esc_url( kf_company_url( $st[0] ) ); ?>"><?php echo kf_icon( $st[0] ); // phpcs:ignore ?><span dir="ltr"><?php echo esc_html( $b['name'] ); ?></span></a>
					<h2><?php echo esc_html( $st[1] ); ?></h2>
					<p><?php echo esc_html( $st[2] ); ?></p>
				</div>
				<ul class="chips-list">
					<?php foreach ( $st[3] as $c ) : ?><li><?php echo esc_html( $c ); ?></li><?php endforeach; ?>
				</ul>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<section class="section section--alt">
	<div class="wrap sol-grid">
		<div class="panel reveal">
			<h2><?php echo esc_html( $p['data_t'] ); ?></h2>
			<ul class="ticks">
				<?php foreach ( $p['data'] as $d ) : ?><li><?php echo kf_icon( 'data' ); // phpcs:ignore ?><?php echo esc_html( $d ); ?></li><?php endforeach; ?>
			</ul>
		</div>
		<div class="panel reveal" style="--d:.08s">
			<h2><?php echo esc_html( $p['start_t'] ); ?></h2>
			<p class="muted"><?php echo esc_html( $p['start'] ); ?></p>
			<a class="link-arrow" href="<?php echo esc_url( kf_route_url( 'contact' ) ); ?>"><?php kf_e( 'cta.btn1' ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></a>
		</div>
	</div>
</section>

<?php
kf_part( 'cta' );
get_footer();
