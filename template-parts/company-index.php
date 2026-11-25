<?php
/**
 * Editorial index of the four companies (numbered rows).
 * Args: heading_level (h2|h3).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$hl = isset( $args['heading_level'] ) ? $args['heading_level'] : 'h3';
?>
<ol class="cindex">
	<?php foreach ( array_keys( kf_brands_meta() ) as $i => $s ) : $b = kf_brand( $s ); ?>
		<li class="cindex__row reveal" style="<?php echo esc_attr( kf_brand_style( $s ) ); ?>;--d:<?php echo esc_attr( 0.05 * $i ); ?>s">
			<span class="cindex__n" dir="ltr">0<?php echo (int) $i + 1; ?></span>
			<div class="cindex__name">
				<span class="cindex__ico"><?php echo kf_icon( $s ); // phpcs:ignore ?></span>
				<<?php echo esc_html( $hl ); ?> dir="ltr"><a href="<?php echo esc_url( kf_company_url( $s ) ); ?>"><?php echo esc_html( $b['name'] ); ?></a></<?php echo esc_html( $hl ); ?>>
			</div>
			<div class="cindex__body">
				<p class="cindex__tag"><?php echo esc_html( $b['tag'] ); ?></p>
				<p class="cindex__head"><?php echo esc_html( $b['headline'] ); ?></p>
				<ul class="cindex__pts">
					<?php foreach ( $b['points'] as $pt ) : ?><li><?php echo esc_html( $pt ); ?></li><?php endforeach; ?>
				</ul>
			</div>
			<div class="cindex__go">
				<?php if ( ! empty( $b['url'] ) ) : ?>
					<span class="cindex__host" dir="ltr"><?php echo esc_html( $b['host'] ); ?></span>
				<?php else : ?>
					<span class="soon"><?php kf_e( 'companies.soon' ); ?></span>
				<?php endif; ?>
				<span class="cindex__arrow" aria-hidden="true"><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></span>
			</div>
			<i class="cindex__bar" aria-hidden="true"></i>
		</li>
	<?php endforeach; ?>
</ol>
