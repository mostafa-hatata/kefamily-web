<?php
/**
 * FAQ accordion + FAQPage schema. Args: items (array of [q, a]), open_first (bool).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$items = isset( $args['items'] ) ? (array) $args['items'] : array();
$open  = ! isset( $args['open_first'] ) || $args['open_first'];
$hl    = isset( $args['hl'] ) ? $args['hl'] : 'h3';
?>
<div class="faq">
	<?php foreach ( $items as $i => $q ) : ?>
		<details class="faq__item reveal" style="--d: <?php echo esc_attr( min( 0.05 * $i, 0.3 ) ); ?>s" <?php echo ( $open && 0 === $i ) ? 'open' : ''; ?>>
			<summary><<?php echo esc_html( $hl ); ?>><?php echo esc_html( $q[0] ); ?></<?php echo esc_html( $hl ); ?>><i class="faq__plus" aria-hidden="true"></i></summary>
			<div class="faq__a"><p><?php echo esc_html( $q[1] ); ?></p></div>
		</details>
	<?php endforeach; ?>
</div>
<?php kf_faq_schema( $items ); ?>
