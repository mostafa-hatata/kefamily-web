<?php
/**
 * Header.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$route  = kf_route();
$brands = array_keys( kf_brands_meta() );
$langs  = kf_langs();
$cur    = function ( $keys ) use ( $route ) {
	foreach ( (array) $keys as $k ) {
		if ( $route === $k || ( '*' === substr( $k, -1 ) && 0 === strpos( (string) $route, rtrim( $k, '*' ) ) ) ) {
			return true;
		}
	}
	return false;
};
$lang_menu = function ( $id ) use ( $langs ) {
	?>
	<div class="langs" data-dd>
		<button type="button" aria-expanded="false" aria-controls="<?php echo esc_attr( $id ); ?>" aria-label="<?php kf_e( 'nav.language' ); ?>">
			<?php echo kf_icon( 'globe' ); // phpcs:ignore ?><span><?php echo esc_html( $langs[ kf_lang() ]['short'] ); ?></span>
		</button>
		<ul class="langs__menu" id="<?php echo esc_attr( $id ); ?>">
			<?php foreach ( $langs as $code => $l ) : ?>
				<li><a href="<?php echo esc_url( kf_lang_url( $code ) ); ?>" hreflang="<?php echo esc_attr( $l['hreflang'] ); ?>" lang="<?php echo esc_attr( $l['hreflang'] ); ?>" <?php echo kf_lang() === $code ? 'aria-current="true"' : ''; ?>><b><?php echo esc_html( $l['short'] ); ?></b><?php echo esc_html( $l['name'] ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
};
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<script>(function(){var d=document.documentElement;try{var t=localStorage.getItem('kf-theme');d.setAttribute('data-theme',t==='dark'?'dark':'light');}catch(e){d.setAttribute('data-theme','light');}d.classList.add('js');})();</script>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main"><?php kf_e( 'nav.skip' ); ?></a>

<header class="nav" data-nav>
	<div class="nav__inner">
		<a class="nav__brand" href="<?php echo esc_url( kf_route_url( 'home' ) ); ?>" aria-label="KeFamily — <?php kf_e( 'nav.home' ); ?>"><?php echo kf_logo( 26 ); // phpcs:ignore ?></a>

		<nav class="nav__links" aria-label="Primary">
			<div class="dd" data-dd>
				<button type="button" aria-expanded="false" class="<?php echo $cur( array( 'companies', 'company-*' ) ) ? 'is-current' : ''; ?>"><?php kf_e( 'nav.companies' ); ?><?php echo kf_icon( 'chev' ); // phpcs:ignore ?></button>
				<div class="dd__menu">
					<?php foreach ( $brands as $i => $s ) : $b = kf_brand( $s ); ?>
						<a href="<?php echo esc_url( kf_company_url( $s ) ); ?>" style="<?php echo esc_attr( kf_brand_style( $s ) ); ?>">
							<span class="dd__n" dir="ltr">0<?php echo (int) $i + 1; ?></span>
							<span><b dir="ltr"><?php echo esc_html( $b['name'] ); ?></b><small><?php echo esc_html( $b['tag'] ); ?></small></span>
						</a>
					<?php endforeach; ?>
					<a class="dd__all" href="<?php echo esc_url( kf_route_url( 'companies' ) ); ?>"><?php kf_e( 'pages.companies.crumb' ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></a>
				</div>
			</div>
			<div class="dd" data-dd>
				<button type="button" aria-expanded="false" class="<?php echo $cur( array( 'solutions', 'solution-*' ) ) ? 'is-current' : ''; ?>"><?php kf_e( 'nav.solutions' ); ?><?php echo kf_icon( 'chev' ); // phpcs:ignore ?></button>
				<div class="dd__menu">
					<?php foreach ( kf_sector_slugs() as $s ) : ?>
						<a href="<?php echo esc_url( kf_solution_url( $s ) ); ?>">
							<span class="dd__ico"><?php echo kf_sector_icon( $s ); // phpcs:ignore ?></span>
							<span><b><?php echo esc_html( kf_get( 'sectors_pages.' . $s . '.name' ) ); ?></b></span>
						</a>
					<?php endforeach; ?>
					<a class="dd__all" href="<?php echo esc_url( kf_route_url( 'solutions' ) ); ?>"><?php kf_e( 'pages.solutions.crumb' ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></a>
				</div>
			</div>
			<a href="<?php echo esc_url( kf_route_url( 'how' ) ); ?>" <?php echo $cur( 'how' ) ? 'aria-current="page"' : ''; ?>><?php kf_e( 'nav.ecosystem' ); ?></a>
			<a href="<?php echo esc_url( kf_route_url( 'blog' ) ); ?>" <?php echo $cur( array( 'blog', 'post' ) ) ? 'aria-current="page"' : ''; ?>><?php kf_e( 'nav.blog' ); ?></a>
			<a href="<?php echo esc_url( kf_route_url( 'about' ) ); ?>" <?php echo $cur( 'about' ) ? 'aria-current="page"' : ''; ?>><?php kf_e( 'nav.about' ); ?></a>
			<a href="<?php echo esc_url( kf_route_url( 'contact' ) ); ?>" <?php echo $cur( 'contact' ) ? 'aria-current="page"' : ''; ?>><?php kf_e( 'nav.contact' ); ?></a>
		</nav>

		<div class="nav__actions">
			<?php $lang_menu( 'langs-top' ); ?>
			<button class="icon-btn theme-toggle" type="button" data-theme-toggle aria-label="<?php kf_e( 'nav.theme' ); ?>" title="<?php kf_e( 'nav.theme' ); ?>">
				<?php echo kf_icon( 'moon', 'icon--moon' ); // phpcs:ignore ?><?php echo kf_icon( 'sun', 'icon--sun' ); // phpcs:ignore ?>
			</button>
			<a class="btn btn--sm nav__cta" href="<?php echo esc_url( kf_route_url( 'book' ) ); ?>"><?php echo kf_icon( 'calendar' ); // phpcs:ignore ?><span><?php kf_e( 'nav.book' ); ?></span></a>
			<button class="nav__burger" type="button" aria-expanded="false" aria-controls="mobile-menu" data-burger>
				<span class="sr"><?php kf_e( 'nav.menu' ); ?></span><span class="burger" aria-hidden="true"><i></i><i></i></span>
			</button>
		</div>
	</div>
</header>

<div class="mmenu" id="mobile-menu" hidden data-mmenu>
	<div class="mmenu__group">
		<span><?php kf_e( 'nav.companies' ); ?></span>
		<?php foreach ( $brands as $i => $s ) : $b = kf_brand( $s ); ?>
			<a href="<?php echo esc_url( kf_company_url( $s ) ); ?>" style="<?php echo esc_attr( kf_brand_style( $s ) ); ?>"><i class="dot" aria-hidden="true"></i><span dir="ltr"><?php echo esc_html( $b['name'] ); ?></span></a>
		<?php endforeach; ?>
	</div>
	<div class="mmenu__group">
		<span><?php kf_e( 'nav.solutions' ); ?></span>
		<?php foreach ( kf_sector_slugs() as $s ) : ?>
			<a href="<?php echo esc_url( kf_solution_url( $s ) ); ?>"><?php echo esc_html( kf_get( 'sectors_pages.' . $s . '.name' ) ); ?></a>
		<?php endforeach; ?>
	</div>
	<div class="mmenu__group">
		<span>KeFamily</span>
		<?php foreach ( array( 'how' => 'nav.ecosystem', 'blog' => 'nav.blog', 'about' => 'nav.about', 'careers' => 'nav.careers', 'partners' => 'nav.partners', 'faq' => 'nav.faq', 'contact' => 'nav.contact' ) as $k => $label ) : ?>
			<a href="<?php echo esc_url( kf_route_url( $k ) ); ?>"><?php kf_e( $label ); ?></a>
		<?php endforeach; ?>
	</div>
	<div class="mmenu__langs" aria-label="<?php kf_e( 'nav.language' ); ?>">
		<?php foreach ( $langs as $code => $l ) : ?>
			<a href="<?php echo esc_url( kf_lang_url( $code ) ); ?>" hreflang="<?php echo esc_attr( $l['hreflang'] ); ?>" lang="<?php echo esc_attr( $l['hreflang'] ); ?>" <?php echo kf_lang() === $code ? 'aria-current="true"' : ''; ?>><?php echo esc_html( $l['name'] ); ?></a>
		<?php endforeach; ?>
	</div>
	<div class="mmenu__foot">
		<a class="btn" href="<?php echo esc_url( kf_route_url( 'book' ) ); ?>"><?php echo kf_icon( 'calendar' ); // phpcs:ignore ?><span><?php kf_e( 'nav.book' ); ?></span></a>
		<a class="btn btn--line" href="<?php echo esc_url( kf_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php echo kf_icon( 'whatsapp' ); // phpcs:ignore ?><span><?php kf_e( 'hero.cta2' ); ?></span></a>
		<button class="icon-btn theme-toggle" type="button" data-theme-toggle aria-label="<?php kf_e( 'nav.theme' ); ?>"><?php echo kf_icon( 'moon', 'icon--moon' ); // phpcs:ignore ?><?php echo kf_icon( 'sun', 'icon--sun' ); // phpcs:ignore ?></button>
	</div>
</div>

<main id="main">
