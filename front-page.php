<?php
/**
 * Home page.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();

$slugs  = array_keys( kf_brands_meta() );
$rotate = (array) kf_get( 'hero.rotate' );
?>

<!-- ============ HERO ============ -->
<section class="hero" aria-labelledby="hero-title">
	<canvas class="hero__particles" data-particles aria-hidden="true"></canvas>
	<div class="hero__aurora" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></div>
	<div class="hero__grid" aria-hidden="true"></div>

	<div class="wrap hero__inner">
		<div class="hero__copy">
			<a class="pill reveal" href="#companies">
				<span class="pill__dots" aria-hidden="true"><?php foreach ( $slugs as $s ) : ?><i style="<?php echo esc_attr( kf_brand_style( $s ) ); ?>"></i><?php endforeach; ?></span>
				<span class="shiny"><?php kf_e( 'hero.eyebrow' ); ?></span>
				<?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?>
			</a>

			<h1 id="hero-title" class="hero__title reveal" style="--d:.08s">
				<span class="hero__line"><?php kf_e( 'hero.title_a' ); ?></span>
				<span class="rotator" aria-live="polite">
					<span class="rotator__word brand-text" data-rotator-word style="<?php echo esc_attr( kf_brand_style( 'kemarq' ) ); ?>"><?php echo esc_html( $rotate[0] ); ?></span>
				</span>
			</h1>

			<p class="hero__sub reveal" style="--d:.16s"><?php kf_e( 'hero.sub' ); ?></p>

			<div class="hero__ctas reveal" style="--d:.24s">
				<a class="btn btn--shimmer" href="#companies" data-magnetic>
					<span class="btn__shine" aria-hidden="true"></span>
					<span class="btn__label"><?php kf_e( 'hero.cta1' ); ?></span>
					<?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?>
				</a>
				<a class="btn btn--ghost" href="<?php echo esc_url( kf_whatsapp_url() ); ?>" target="_blank" rel="noopener">
					<?php echo kf_icon( 'whatsapp' ); // phpcs:ignore ?><span><?php kf_e( 'hero.cta2' ); ?></span>
				</a>
			</div>

			<ul class="hero__brands reveal" style="--d:.32s" aria-label="<?php kf_e( 'nav.companies' ); ?>">
				<?php foreach ( $slugs as $s ) : $b = kf_brand( $s ); ?>
					<li><a href="<?php echo esc_url( kf_company_url( $s ) ); ?>" style="<?php echo esc_attr( kf_brand_style( $s ) ); ?>"><?php echo kf_icon( $s ); // phpcs:ignore ?><span dir="ltr"><?php echo esc_html( $b['name'] ); ?></span></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="hero__visual reveal" style="--d:.2s" aria-hidden="true">
			<div class="orbit">
				<div class="orbit__ring orbit__ring--1"></div>
				<div class="orbit__ring orbit__ring--2"></div>
				<div class="orbit__ring orbit__ring--3"></div>
				<div class="orbit__core">
					<span class="orbit__pulse"></span><span class="orbit__pulse orbit__pulse--2"></span>
					<?php echo kf_logo_mark( 64 ); // phpcs:ignore ?>
				</div>
				<div class="orbit__track orbit__track--outer">
					<?php foreach ( $slugs as $i => $s ) : $b = kf_brand( $s ); ?>
						<div class="planet" style="--a: <?php echo (int) ( $i * 90 + 20 ); ?>deg; <?php echo esc_attr( kf_brand_style( $s ) ); ?>">
							<div class="planet__body"><?php echo kf_icon( $s ); // phpcs:ignore ?><span dir="ltr"><?php echo esc_html( $b['name'] ); ?></span></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="orbit__track orbit__track--inner">
					<?php foreach ( array( 'Meta', 'GA4', 'TikTok', 'Snap', 'Google', 'WhatsApp' ) as $i => $chip ) : ?>
						<div class="moon" style="--a: <?php echo (int) ( $i * 60 ); ?>deg"><span dir="ltr"><?php echo esc_html( $chip ); ?></span></div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

	<a class="hero__scroll" href="#companies"><span><?php kf_e( 'hero.scroll' ); ?></span><i aria-hidden="true"></i></a>
</section>

<!-- ============ MARQUEE ============ -->
<div class="marquee" aria-hidden="true">
	<?php
	$m_items  = (array) kf_get( 'marquee' );
	$m_brands = array( 'kepixel', 'kemarq', 'kechat', 'keclinic' );
	for ( $row = 0; $row < 2; $row++ ) :
		$items = $row ? array_reverse( $m_items ) : $m_items;
		?>
		<div class="marquee__track <?php echo $row ? 'marquee__track--rev' : ''; ?>">
			<?php for ( $dup = 0; $dup < 2; $dup++ ) : foreach ( $items as $k => $m ) : ?>
				<span class="marquee__item" style="<?php echo esc_attr( kf_brand_style( $m_brands[ $k % 4 ] ) ); ?>"><?php echo kf_icon( 'spark' ); // phpcs:ignore ?><?php echo esc_html( $m ); ?></span>
			<?php endforeach; endfor; ?>
		</div>
	<?php endfor; ?>
</div>

<!-- ============ COMPANIES ============ -->
<section class="section" id="companies" aria-labelledby="companies-title">
	<div class="wrap">
		<header class="head reveal">
			<span class="eyebrow"><?php kf_e( 'companies.eyebrow' ); ?></span>
			<h2 id="companies-title" class="h2"><?php kf_e( 'companies.title' ); ?></h2>
			<p class="lead"><?php kf_e( 'companies.sub' ); ?></p>
		</header>
		<?php kf_part( 'bento', array( 'heading_level' => 'h3' ) ); ?>
	</div>
</section>

<!-- ============ ECOSYSTEM ============ -->
<section class="section section--flow" id="ecosystem" aria-labelledby="flow-title">
	<div class="wrap">
		<header class="head head--center reveal">
			<span class="eyebrow"><?php kf_e( 'flow.eyebrow' ); ?></span>
			<h2 id="flow-title" class="h2"><?php kf_e( 'flow.title' ); ?></h2>
			<p class="lead"><?php kf_e( 'flow.sub' ); ?></p>
		</header>
		<?php kf_part( 'beams' ); ?>
		<p class="hero__ctas hero__ctas--center" style="margin-top:36px"><a class="link-arrow" href="<?php echo esc_url( kf_route_url( 'how' ) ); ?>"><?php kf_e( 'pages.how.crumb' ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></a></p>
	</div>
</section>

<!-- ============ STATS ============ -->
<section class="section section--tight" aria-label="<?php kf_e( 'stats.eyebrow' ); ?>">
	<div class="wrap">
		<div class="stats">
			<?php foreach ( (array) kf_get( 'stats.items' ) as $i => $st ) : ?>
				<div class="stat reveal" style="--d: <?php echo esc_attr( 0.07 * $i ); ?>s">
					<div class="stat__num" dir="ltr"><span data-count="<?php echo (int) $st[0]; ?>">0</span><small><?php echo esc_html( $st[1] ); ?></small></div>
					<p><?php echo esc_html( $st[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============ MANIFESTO ============ -->
<section class="manifesto" aria-label="<?php kf_e( 'manifesto.eyebrow' ); ?>" data-textreveal>
	<div class="manifesto__sticky">
		<div class="wrap">
			<span class="eyebrow"><?php kf_e( 'manifesto.eyebrow' ); ?></span>
			<p class="manifesto__text" data-words><?php kf_e( 'manifesto.text' ); ?></p>
		</div>
	</div>
</section>

<!-- ============ SOLUTIONS ============ -->
<section class="section section--sectors" aria-labelledby="sectors-title">
	<div class="dots-bg" aria-hidden="true"></div>
	<div class="wrap">
		<header class="head head--center reveal">
			<span class="eyebrow"><?php kf_e( 'sectors.eyebrow' ); ?></span>
			<h2 id="sectors-title" class="h2"><?php kf_e( 'sectors.title' ); ?></h2>
		</header>
		<ul class="sectors">
			<?php foreach ( kf_sector_slugs() as $i => $slug ) : ?>
				<li class="reveal" style="--d: <?php echo esc_attr( 0.05 * $i ); ?>s"><a href="<?php echo esc_url( kf_solution_url( $slug ) ); ?>"><span class="sectors__n" dir="ltr">0<?php echo (int) $i + 1; ?></span><?php echo esc_html( kf_get( 'sectors_pages.' . $slug . '.name' ) ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<!-- ============ VALUES ============ -->
<section class="section" aria-labelledby="values-title">
	<div class="wrap">
		<header class="head reveal">
			<span class="eyebrow"><?php kf_e( 'values.eyebrow' ); ?></span>
			<h2 id="values-title" class="h2"><?php kf_e( 'values.title' ); ?></h2>
		</header>
		<div class="values">
			<?php foreach ( (array) kf_get( 'values.items' ) as $i => $v ) : ?>
				<div class="value spotlight reveal" data-spotlight style="--d: <?php echo esc_attr( 0.06 * $i ); ?>s">
					<span class="value__icon"><?php echo kf_icon( $v[0] ); // phpcs:ignore ?></span>
					<h3><?php echo esc_html( $v[1] ); ?></h3>
					<p><?php echo esc_html( $v[2] ); ?></p>
					<span class="value__num" dir="ltr">0<?php echo (int) $i + 1; ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============ FAQ ============ -->
<section class="section" aria-labelledby="faq-title">
	<div class="wrap faq-wrap">
		<header class="head reveal">
			<span class="eyebrow"><?php kf_e( 'faq.eyebrow' ); ?></span>
			<h2 id="faq-title" class="h2"><?php kf_e( 'faq.title' ); ?></h2>
			<a class="link-arrow" href="<?php echo esc_url( kf_route_url( 'faq' ) ); ?>"><?php kf_e( 'nav.faq' ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></a>
		</header>
		<?php kf_part( 'faq-list', array( 'items' => (array) kf_get( 'faq.items' ) ) ); ?>
	</div>
</section>

<?php kf_part( 'cta' ); ?>

<?php
get_footer();
