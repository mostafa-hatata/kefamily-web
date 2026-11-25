<?php
/**
 * Sector cards linking to the solution pages. Args: exclude (slug), heading_level.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$exclude = isset( $args['exclude'] ) ? $args['exclude'] : '';
$hl      = isset( $args['heading_level'] ) ? $args['heading_level'] : 'h3';
$i       = 0;
?>
<div class="sector-cards">
	<?php foreach ( kf_sector_slugs() as $slug ) : if ( $slug === $exclude ) { continue; } $s = kf_get( 'sectors_pages.' . $slug ); ?>
		<a class="sector-card spotlight reveal" data-spotlight href="<?php echo esc_url( kf_solution_url( $slug ) ); ?>" style="--d:<?php echo esc_attr( 0.05 * $i++ ); ?>s">
			<span class="value__icon" style="margin:0"><?php echo kf_sector_icon( $slug ); // phpcs:ignore ?></span>
			<<?php echo esc_html( $hl ); ?>><?php echo esc_html( $s['name'] ); ?></<?php echo esc_html( $hl ); ?>>
			<p><?php echo esc_html( $s['title'] ); ?></p>
			<div class="sector-card__brands">
				<?php foreach ( $s['plan'] as $pl ) : ?>
					<span class="dotb" style="<?php echo esc_attr( kf_brand_style( $pl[0] ) ); ?>" dir="ltr"><?php echo esc_html( kf_brand( $pl[0] )['name'] ); ?></span>
				<?php endforeach; ?>
			</div>
			<span class="link-arrow"><?php kf_e( 'sector_ui.more' ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></span>
		</a>
	<?php endforeach; ?>
</div>
