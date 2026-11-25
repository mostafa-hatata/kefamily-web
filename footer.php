<?php
/**
 * Footer.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$li = get_theme_mod( 'kf_linkedin', '' );
$ig = get_theme_mod( 'kf_instagram', '' );
?>
</main>

<footer class="footer">
	<div class="footer__glow" aria-hidden="true"></div>
	<div class="wrap footer__grid">
		<div class="footer__brand">
			<a href="<?php echo esc_url( kf_route_url( 'home' ) ); ?>" aria-label="KeFamily"><?php echo kf_logo(); // phpcs:ignore ?></a>
			<p><?php kf_e( 'footer.tagline' ); ?></p>
			<div class="footer__social">
				<a href="<?php echo esc_url( kf_whatsapp_url() ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><?php echo kf_icon( 'whatsapp' ); // phpcs:ignore ?></a>
				<?php if ( $li ) : ?><a href="<?php echo esc_url( $li ); ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><?php echo kf_icon( 'linkedin' ); // phpcs:ignore ?></a><?php endif; ?>
				<?php if ( $ig ) : ?><a href="<?php echo esc_url( $ig ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo kf_icon( 'instagram' ); // phpcs:ignore ?></a><?php endif; ?>
			</div>
		</div>

		<div>
			<h2 class="footer__h"><?php kf_e( 'footer.companies' ); ?></h2>
			<ul>
				<?php foreach ( array_keys( kf_brands_meta() ) as $slug ) : $b = kf_brand( $slug ); ?>
					<li><a href="<?php echo esc_url( kf_company_url( $slug ) ); ?>" style="<?php echo esc_attr( kf_brand_style( $slug ) ); ?>"><i class="dot"></i><span dir="ltr"><?php echo esc_html( $b['name'] ); ?></span></a></li>
				<?php endforeach; ?>
				<li><a href="<?php echo esc_url( kf_route_url( 'companies' ) ); ?>"><?php kf_e( 'pages.companies.crumb' ); ?></a></li>
			</ul>
		</div>

		<div>
			<h2 class="footer__h"><?php kf_e( 'nav.solutions' ); ?></h2>
			<ul>
				<?php foreach ( kf_sector_slugs() as $s ) : ?>
					<li><a href="<?php echo esc_url( kf_solution_url( $s ) ); ?>"><?php echo esc_html( kf_get( 'sectors_pages.' . $s . '.name' ) ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div>
			<h2 class="footer__h">KeFamily</h2>
			<ul>
				<li><a href="<?php echo esc_url( kf_route_url( 'how' ) ); ?>"><?php kf_e( 'nav.ecosystem' ); ?></a></li>
				<li><a href="<?php echo esc_url( kf_route_url( 'about' ) ); ?>"><?php kf_e( 'nav.about' ); ?></a></li>
				<li><a href="<?php echo esc_url( kf_route_url( 'careers' ) ); ?>"><?php kf_e( 'nav.careers' ); ?></a></li>
				<li><a href="<?php echo esc_url( kf_route_url( 'partners' ) ); ?>"><?php kf_e( 'nav.partners' ); ?></a></li>
				<li><a href="<?php echo esc_url( kf_route_url( 'faq' ) ); ?>"><?php kf_e( 'nav.faq' ); ?></a></li>
			</ul>
		</div>

		<div>
			<h2 class="footer__h"><?php kf_e( 'footer.contact' ); ?></h2>
			<ul>
				<li><a href="<?php echo esc_url( kf_route_url( 'contact' ) ); ?>"><?php kf_e( 'nav.contact' ); ?></a></li>
				<li><a href="<?php echo esc_url( kf_whatsapp_url() ); ?>" target="_blank" rel="noopener" dir="ltr"><?php echo esc_html( kf_whatsapp_display() ); ?></a></li>
				<li class="muted"><?php kf_e( 'contact.hours' ); ?></li>
			</ul>
		</div>
	</div>

	<div class="footer__word" aria-hidden="true" dir="ltr">KeFamily</div>

	<div class="wrap footer__bar">
		<span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> KeFamily. <?php kf_e( 'footer.rights' ); ?></span>
		<nav aria-label="Legal">
			<a href="<?php echo esc_url( kf_route_url( 'privacy' ) ); ?>"><?php kf_e( 'nav.privacy' ); ?></a>
			<a href="<?php echo esc_url( kf_route_url( 'terms' ) ); ?>"><?php kf_e( 'nav.terms' ); ?></a>
		</nav>
	</div>
</footer>

<a class="wa-float" href="<?php echo esc_url( kf_whatsapp_url() ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><?php echo kf_icon( 'whatsapp' ); // phpcs:ignore ?></a>

<?php wp_footer(); ?>
</body>
</html>
