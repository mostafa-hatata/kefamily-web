<?php
/**
 * Visible breadcrumb trail (matches the BreadcrumbList schema).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$m = kf_route_meta();
if ( empty( $m['crumbs'] ) ) {
	return;
}
$last = count( $m['crumbs'] ) - 1;
?>
<nav class="crumbs reveal" aria-label="<?php kf_e( 'nav.breadcrumb' ); ?>">
	<ol>
		<?php foreach ( $m['crumbs'] as $i => $c ) : ?>
			<li>
				<?php if ( $i === $last ) : ?>
					<span aria-current="page"><?php echo esc_html( $c[0] ); ?></span>
				<?php else : ?>
					<a href="<?php echo esc_url( $c[1] ); ?>"><?php echo esc_html( $c[0] ); ?></a>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>
</nav>
