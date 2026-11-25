<?php
/**
 * Bento grid of the four companies. Args: heading_level (h2|h3).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$hl = isset( $args['heading_level'] ) ? $args['heading_level'] : 'h3';
?>
<div class="bento">
	<?php foreach ( array_keys( kf_brands_meta() ) as $i => $s ) : $b = kf_brand( $s ); ?>
		<article class="card card--<?php echo esc_attr( $s ); ?> spotlight reveal" style="<?php echo esc_attr( kf_brand_style( $s ) ); ?>;--d:<?php echo esc_attr( 0.06 * $i ); ?>s" data-spotlight>
			<span class="beam" aria-hidden="true"></span>
			<div class="card__visual" aria-hidden="true"><?php kf_part( 'visual', array( 'slug' => $s ) ); ?></div>
			<div class="card__body">
				<div class="card__top">
					<span class="badge"><?php echo kf_icon( $s ); // phpcs:ignore ?><span dir="ltr"><?php echo esc_html( $b['name'] ); ?></span></span>
					<span class="card__tag"><?php echo esc_html( $b['tag'] ); ?></span>
				</div>
				<<?php echo esc_html( $hl ); ?> class="card__title"><?php echo esc_html( $b['headline'] ); ?></<?php echo esc_html( $hl ); ?>>
				<p class="card__desc"><?php echo esc_html( $b['desc'] ); ?></p>
				<ul class="ticks">
					<?php foreach ( $b['points'] as $pt ) : ?>
						<li><?php echo kf_icon( 'check' ); // phpcs:ignore ?><?php echo esc_html( $pt ); ?></li>
					<?php endforeach; ?>
				</ul>
				<div class="card__links">
					<a class="link-arrow" href="<?php echo esc_url( kf_company_url( $s ) ); ?>"><?php kf_e( 'companies.more' ); ?> <span class="sr" dir="ltr"><?php echo esc_html( $b['name'] ); ?></span><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></a>
					<?php if ( ! empty( $b['url'] ) ) : ?>
						<a class="link-ext" href="<?php echo esc_url( $b['url'] ); ?>" target="_blank" rel="noopener" dir="ltr"><?php echo esc_html( $b['host'] ); ?><?php echo kf_icon( 'arrow-up' ); // phpcs:ignore ?></a>
					<?php else : ?>
						<span class="soon"><?php kf_e( 'companies.soon' ); ?></span>
					<?php endif; ?>
				</div>
			</div>
		</article>
	<?php endforeach; ?>
</div>
