<?php
/**
 * Header.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$is_home = is_front_page();
$anchor  = function ( $hash ) use ( $is_home ) {
	return $is_home ? '#' . $hash : kf_url( '#' . $hash );
};
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main"><?php kf_e( 'nav.skip' ); ?></a>
<div class="noise" aria-hidden="true"></div>

<header class="nav" data-nav>
	<div class="nav__inner">
		<a class="nav__brand" href="<?php echo esc_url( kf_url() ); ?>" aria-label="KeFamily"><?php echo kf_logo(); // phpcs:ignore ?></a>

		<nav class="nav__links" aria-label="Primary">
			<a href="<?php echo esc_url( $anchor( 'companies' ) ); ?>"><?php kf_e( 'nav.companies' ); ?></a>
			<a href="<?php echo esc_url( $anchor( 'ecosystem' ) ); ?>"><?php kf_e( 'nav.ecosystem' ); ?></a>
			<a href="<?php echo esc_url( kf_url( 'about/' ) ); ?>" <?php echo is_page( 'about' ) ? 'aria-current="page"' : ''; ?>><?php kf_e( 'nav.about' ); ?></a>
			<a href="<?php echo esc_url( kf_url( 'contact/' ) ); ?>" <?php echo is_page( 'contact' ) ? 'aria-current="page"' : ''; ?>><?php kf_e( 'nav.contact' ); ?></a>
		</nav>

		<div class="nav__actions">
			<a class="lang" href="<?php echo esc_url( kf_switch_url() ); ?>" hreflang="<?php echo kf_is_rtl() ? 'en' : 'ar'; ?>" lang="<?php echo kf_is_rtl() ? 'en' : 'ar'; ?>">
				<?php echo kf_icon( 'globe' ); // phpcs:ignore ?><span><?php kf_e( 'nav.switch' ); ?></span>
			</a>
			<a class="btn btn--shimmer btn--sm nav__cta" href="<?php echo esc_url( kf_url( 'contact/' ) ); ?>">
				<span class="btn__shine" aria-hidden="true"></span><span class="btn__label"><?php kf_e( 'nav.cta' ); ?></span>
			</a>
			<button class="nav__burger" type="button" aria-expanded="false" aria-controls="mobile-menu" data-burger>
				<span class="sr"><?php kf_e( 'nav.menu' ); ?></span><span class="burger" aria-hidden="true"><i></i><i></i></span>
			</button>
		</div>
	</div>
</header>

<div class="mmenu" id="mobile-menu" hidden data-mmenu>
	<nav aria-label="Mobile">
		<a href="<?php echo esc_url( kf_url() ); ?>"><?php kf_e( 'nav.home' ); ?></a>
		<a href="<?php echo esc_url( $anchor( 'companies' ) ); ?>"><?php kf_e( 'nav.companies' ); ?></a>
		<a href="<?php echo esc_url( $anchor( 'ecosystem' ) ); ?>"><?php kf_e( 'nav.ecosystem' ); ?></a>
		<a href="<?php echo esc_url( kf_url( 'about/' ) ); ?>"><?php kf_e( 'nav.about' ); ?></a>
		<a href="<?php echo esc_url( kf_url( 'contact/' ) ); ?>"><?php kf_e( 'nav.contact' ); ?></a>
	</nav>
	<div class="mmenu__foot">
		<a class="lang" href="<?php echo esc_url( kf_switch_url() ); ?>"><?php echo kf_icon( 'globe' ); // phpcs:ignore ?><span><?php kf_e( 'nav.switch' ); ?></span></a>
		<a class="btn btn--wa" href="<?php echo esc_url( kf_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php echo kf_icon( 'whatsapp' ); // phpcs:ignore ?><span><?php kf_e( 'hero.cta2' ); ?></span></a>
	</div>
</div>

<main id="main">
