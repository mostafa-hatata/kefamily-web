<?php
/**
 * Animated beams: the four companies wired to the KeFamily hub,
 * plus the four journey steps.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$steps = (array) kf_get( 'flow.steps' );
?>
<div class="beams reveal" data-beams>
	<svg class="beams__svg" aria-hidden="true"><defs></defs></svg>

	<?php foreach ( $steps as $i => $st ) : $b = kf_brand( $st[0] ); ?>
		<a class="beams__node beams__node--<?php echo (int) $i; ?>" href="<?php echo esc_url( kf_company_url( $st[0] ) ); ?>" data-beam-node style="<?php echo esc_attr( kf_brand_style( $b['slug'] ) ); ?>">
			<span class="beams__icon"><?php echo kf_icon( $st[0] ); // phpcs:ignore ?></span>
			<span class="beams__name" dir="ltr"><?php echo esc_html( $b['name'] ); ?></span>
		</a>
	<?php endforeach; ?>

	<div class="beams__hub" data-beam-hub>
		<span class="beams__hub-ring"></span>
		<?php echo kf_logo_mark( 54 ); // phpcs:ignore ?>
		<span class="beams__hub-label" dir="ltr"><?php kf_e( 'flow.hub' ); ?></span>
	</div>
</div>

<ol class="steps">
	<?php foreach ( $steps as $i => $st ) : $b = kf_brand( $st[0] ); ?>
		<li class="step reveal" style="<?php echo esc_attr( kf_brand_style( $b['slug'] ) ); ?>; --d: <?php echo esc_attr( 0.08 * $i ); ?>s">
			<span class="step__n" dir="ltr">0<?php echo (int) $i + 1; ?></span>
			<span class="step__brand" dir="ltr"><?php echo esc_html( $b['name'] ); ?></span>
			<h3><?php echo esc_html( $st[1] ); ?></h3>
			<p><?php echo esc_html( $st[2] ); ?></p>
		</li>
	<?php endforeach; ?>
</ol>
