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
	<div class="hero__aurora" aria-hidden="true"><i></i><i></i><i></i></div>
	<div class="hero__grid" aria-hidden="true"></div>

	<div class="wrap hero__inner">
		<div class="hero__copy">
			<a class="pill pill--shiny reveal" href="#companies">
				<span class="pill__dots" aria-hidden="true"><?php foreach ( $slugs as $s ) : ?><i style="--c: <?php echo esc_attr( kf_brand( $s )['color'] ); ?>"></i><?php endforeach; ?></span>
				<span class="shiny"><?php kf_e( 'hero.eyebrow' ); ?></span>
				<?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?>
			</a>

			<h1 id="hero-title" class="hero__title reveal" style="--d:.08s">
				<span class="hero__line"><?php kf_e( 'hero.title_a' ); ?></span>
				<span class="rotator" data-rotator aria-live="polite">
					<span class="rotator__word aurora-text" data-rotator-word><?php echo esc_html( $rotate[0] ); ?></span>
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
					<li><a href="<?php echo esc_url( kf_company_url( $s ) ); ?>" style="--c: <?php echo esc_attr( $b['color'] ); ?>"><?php echo kf_icon( $s ); // phpcs:ignore ?><span dir="ltr"><?php echo esc_html( $b['name'] ); ?></span></a></li>
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
						<div class="planet" style="--a: <?php echo (int) ( $i * 90 + 20 ); ?>deg; --c: <?php echo esc_attr( $b['color'] ); ?>; --g: <?php echo esc_attr( $b['glow'] ); ?>">
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
	<?php for ( $row = 0; $row < 2; $row++ ) : ?>
		<div class="marquee__track <?php echo $row ? 'marquee__track--rev' : ''; ?>">
			<?php
			$items = (array) kf_get( 'marquee' );
			if ( $row ) {
				$items = array_reverse( $items );
			}
			for ( $dup = 0; $dup < 2; $dup++ ) :
				foreach ( $items as $m ) :
					?>
					<span class="marquee__item"><?php echo kf_icon( 'spark' ); // phpcs:ignore ?><?php echo esc_html( $m ); ?></span>
					<?php
				endforeach;
			endfor;
			?>
		</div>
	<?php endfor; ?>
</div>

<!-- ============ COMPANIES (BENTO) ============ -->
<section class="section" id="companies" aria-labelledby="companies-title">
	<div class="wrap">
		<header class="head reveal">
			<span class="eyebrow"><?php kf_e( 'companies.eyebrow' ); ?></span>
			<h2 id="companies-title" class="h2"><?php kf_e( 'companies.title' ); ?></h2>
			<p class="lead"><?php kf_e( 'companies.sub' ); ?></p>
		</header>

		<div class="bento">
			<?php foreach ( $slugs as $i => $s ) : $b = kf_brand( $s ); ?>
				<article class="card card--<?php echo esc_attr( $s ); ?> spotlight reveal" style="--c: <?php echo esc_attr( $b['color'] ); ?>; --g: <?php echo esc_attr( $b['glow'] ); ?>; --d: <?php echo esc_attr( 0.06 * $i ); ?>s" data-spotlight>
					<span class="beam" aria-hidden="true"></span>
					<div class="card__visual" aria-hidden="true">
						<?php kf_part( 'visual', array( 'slug' => $s ) ); ?>
					</div>
					<div class="card__body">
						<div class="card__top">
							<span class="badge"><?php echo kf_icon( $s ); // phpcs:ignore ?><span dir="ltr"><?php echo esc_html( $b['name'] ); ?></span></span>
							<span class="card__tag"><?php echo esc_html( $b['tag'] ); ?></span>
						</div>
						<h3 class="card__title"><?php echo esc_html( $b['headline'] ); ?></h3>
						<p class="card__desc"><?php echo esc_html( $b['desc'] ); ?></p>
						<ul class="ticks">
							<?php foreach ( $b['points'] as $pt ) : ?>
								<li><?php echo kf_icon( 'check' ); // phpcs:ignore ?><?php echo esc_html( $pt ); ?></li>
							<?php endforeach; ?>
						</ul>
						<div class="card__links">
							<a class="link-arrow" href="<?php echo esc_url( kf_company_url( $s ) ); ?>"><?php kf_e( 'companies.more' ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></a>
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
	</div>
</section>

<!-- ============ ECOSYSTEM (ANIMATED BEAMS) ============ -->
<section class="section section--flow" id="ecosystem" aria-labelledby="flow-title">
	<div class="wrap">
		<header class="head head--center reveal">
			<span class="eyebrow"><?php kf_e( 'flow.eyebrow' ); ?></span>
			<h2 id="flow-title" class="h2"><?php kf_e( 'flow.title' ); ?></h2>
			<p class="lead"><?php kf_e( 'flow.sub' ); ?></p>
		</header>

		<?php kf_part( 'beams' ); ?>
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

<!-- ============ MANIFESTO (TEXT REVEAL) ============ -->
<section class="manifesto" aria-label="<?php kf_e( 'manifesto.eyebrow' ); ?>" data-textreveal>
	<div class="manifesto__sticky">
		<div class="wrap">
			<span class="eyebrow"><?php kf_e( 'manifesto.eyebrow' ); ?></span>
			<p class="manifesto__text" data-words><?php kf_e( 'manifesto.text' ); ?></p>
		</div>
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

<!-- ============ SECTORS ============ -->
<section class="section section--sectors" aria-labelledby="sectors-title">
	<div class="dots-bg" aria-hidden="true"></div>
	<div class="wrap">
		<header class="head head--center reveal">
			<span class="eyebrow"><?php kf_e( 'sectors.eyebrow' ); ?></span>
			<h2 id="sectors-title" class="h2"><?php kf_e( 'sectors.title' ); ?></h2>
		</header>
		<ul class="sectors">
			<?php foreach ( (array) kf_get( 'sectors.items' ) as $i => $sec ) : ?>
				<li class="reveal" style="--d: <?php echo esc_attr( 0.05 * $i ); ?>s"><span class="sectors__n" dir="ltr">0<?php echo (int) $i + 1; ?></span><?php echo esc_html( $sec ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<!-- ============ FAQ ============ -->
<section class="section" aria-labelledby="faq-title">
	<div class="wrap faq-wrap">
		<header class="head reveal">
			<span class="eyebrow"><?php kf_e( 'faq.eyebrow' ); ?></span>
			<h2 id="faq-title" class="h2"><?php kf_e( 'faq.title' ); ?></h2>
		</header>
		<div class="faq">
			<?php foreach ( (array) kf_get( 'faq.items' ) as $i => $q ) : ?>
				<details class="faq__item reveal" style="--d: <?php echo esc_attr( 0.05 * $i ); ?>s" <?php echo 0 === $i ? 'open' : ''; ?>>
					<summary><span><?php echo esc_html( $q[0] ); ?></span><i class="faq__plus" aria-hidden="true"></i></summary>
					<div class="faq__a"><p><?php echo esc_html( $q[1] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
	$faq_schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => array_map(
			function ( $q ) {
				return array(
					'@type'          => 'Question',
					'name'           => $q[0],
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => $q[1],
					),
				);
			},
			(array) kf_get( 'faq.items' )
		),
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $faq_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>';
	?>
</section>

<?php kf_part( 'cta' ); ?>

<?php
get_footer();
