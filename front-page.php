<?php
/**
 * Home page — editorial layout.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();

$slugs  = array_keys( kf_brands_meta() );
$rotate = (array) kf_get( 'hero2.rotate' );
$order  = array( 'kemarq', 'kepixel', 'kechat', 'keclinic' );
?>

<section class="hero" aria-labelledby="hero-title">
	<div class="wrap">
		<div class="hero__meta reveal">
			<span><?php kf_e( 'footer.tagline' ); ?></span>
			<span class="hero__meta-r" dir="ltr">KePixel · KeMarq · KeChat · KeClinic</span>
		</div>

		<h1 id="hero-title" class="hero__title">
			<span class="hero__line reveal"><?php kf_e( 'hero2.title_a' ); ?></span>
			<span class="hero__line reveal" style="--d:.06s"><?php kf_e( 'hero2.title_b' ); ?></span>
			<span class="hero__line hero__line--rot reveal" style="--d:.12s"><span class="rotator" aria-live="polite"><span class="rotator__word brand-text" data-rotator-word style="<?php echo esc_attr( kf_brand_style( $order[0] ) ); ?>"><?php echo esc_html( $rotate[0] ); ?></span></span></span>
		</h1>

		<div class="hero__foot">
			<p class="hero__sub reveal" style="--d:.18s"><?php kf_e( 'hero.sub' ); ?></p>
			<div class="hero__ctas reveal" style="--d:.24s">
				<a class="btn btn--lg" href="<?php echo esc_url( kf_route_url( 'book' ) ); ?>"><?php echo kf_icon( 'calendar' ); // phpcs:ignore ?><span><?php kf_e( 'hero2.cta_book' ); ?></span></a>
				<a class="btn btn--lg btn--line" href="<?php echo esc_url( kf_whatsapp_url() ); ?>" target="_blank" rel="noopener"><?php echo kf_icon( 'whatsapp' ); // phpcs:ignore ?><span><?php kf_e( 'hero.cta2' ); ?></span></a>
			</div>
		</div>

		<ol class="hero__index reveal" style="--d:.3s" aria-label="<?php kf_e( 'hero2.index_t' ); ?>">
			<?php foreach ( $slugs as $i => $s ) : $b = kf_brand( $s ); ?>
				<li style="<?php echo esc_attr( kf_brand_style( $s ) ); ?>">
					<a href="<?php echo esc_url( kf_company_url( $s ) ); ?>">
						<span class="hero__index-n" dir="ltr">0<?php echo (int) $i + 1; ?></span>
						<b dir="ltr"><?php echo esc_html( $b['name'] ); ?></b>
						<small><?php echo esc_html( $b['tag'] ); ?></small>
						<i class="bar" aria-hidden="true"></i>
					</a>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="section" id="companies" aria-labelledby="companies-title">
	<div class="wrap">
		<header class="shead reveal">
			<span class="shead__n" dir="ltr">01</span>
			<span class="eyebrow"><?php kf_e( 'companies.eyebrow' ); ?></span>
			<h2 id="companies-title" class="h2"><?php kf_e( 'companies.title' ); ?></h2>
			<p class="lead"><?php kf_e( 'companies.sub' ); ?></p>
		</header>
		<?php kf_part( 'company-index' ); ?>
	</div>
</section>

<section class="section section--alt" id="ecosystem" aria-labelledby="flow-title">
	<div class="wrap">
		<header class="shead reveal">
			<span class="shead__n" dir="ltr">02</span>
			<span class="eyebrow"><?php kf_e( 'flow.eyebrow' ); ?></span>
			<h2 id="flow-title" class="h2"><?php kf_e( 'flow.title' ); ?></h2>
			<p class="lead"><?php kf_e( 'flow.sub' ); ?></p>
		</header>
		<?php kf_part( 'beams' ); ?>
		<p class="more-row"><a class="link-arrow" href="<?php echo esc_url( kf_route_url( 'how' ) ); ?>"><?php kf_e( 'pages.how.crumb' ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></a></p>
	</div>
</section>

<section class="section section--tight" aria-label="<?php kf_e( 'stats.eyebrow' ); ?>">
	<div class="wrap">
		<dl class="facts">
			<?php foreach ( (array) kf_get( 'stats.items' ) as $i => $st ) : ?>
				<div class="fact reveal" style="--d: <?php echo esc_attr( 0.06 * $i ); ?>s">
					<dt class="fact__num" dir="ltr"><span data-count="<?php echo (int) $st[0]; ?>"><?php echo (int) $st[0]; ?></span><small><?php echo esc_html( $st[1] ); ?></small></dt>
					<dd><?php echo esc_html( $st[2] ); ?></dd>
				</div>
			<?php endforeach; ?>
		</dl>
	</div>
</section>

<section class="section manifesto" aria-label="<?php kf_e( 'manifesto.eyebrow' ); ?>">
	<div class="wrap">
		<span class="eyebrow reveal"><?php kf_e( 'manifesto.eyebrow' ); ?></span>
		<p class="manifesto__text reveal"><?php kf_e( 'manifesto.text' ); ?></p>
	</div>
</section>

<section class="section" aria-labelledby="sectors-title">
	<div class="wrap">
		<header class="shead reveal">
			<span class="shead__n" dir="ltr">03</span>
			<span class="eyebrow"><?php kf_e( 'sectors.eyebrow' ); ?></span>
			<h2 id="sectors-title" class="h2"><?php kf_e( 'sectors.title' ); ?></h2>
		</header>
		<ul class="sectors">
			<?php foreach ( kf_sector_slugs() as $i => $slug ) : $sp = kf_get( 'sectors_pages.' . $slug ); ?>
				<li class="reveal" style="--d: <?php echo esc_attr( 0.04 * $i ); ?>s"><a href="<?php echo esc_url( kf_solution_url( $slug ) ); ?>">
					<span class="sectors__n" dir="ltr">0<?php echo (int) $i + 1; ?></span>
					<span class="sectors__name"><?php echo esc_html( $sp['name'] ); ?></span>
					<span class="sectors__line"><?php echo esc_html( $sp['title'] ); ?></span>
					<span class="sectors__dots" aria-hidden="true"><?php foreach ( $sp['plan'] as $pl ) : ?><i style="<?php echo esc_attr( kf_brand_style( $pl[0] ) ); ?>"></i><?php endforeach; ?></span>
					<?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?>
				</a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="section section--alt" aria-labelledby="values-title">
	<div class="wrap">
		<header class="shead reveal">
			<span class="shead__n" dir="ltr">04</span>
			<span class="eyebrow"><?php kf_e( 'values.eyebrow' ); ?></span>
			<h2 id="values-title" class="h2"><?php kf_e( 'values.title' ); ?></h2>
		</header>
		<div class="values">
			<?php foreach ( (array) kf_get( 'values.items' ) as $i => $v ) : ?>
				<div class="value reveal" style="--d: <?php echo esc_attr( 0.05 * $i ); ?>s">
					<span class="value__icon"><?php echo kf_icon( $v[0] ); // phpcs:ignore ?></span>
					<h3><?php echo esc_html( $v[1] ); ?></h3>
					<p><?php echo esc_html( $v[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
$latest = kf_blog_query( 1, '', 3 );
if ( $latest->have_posts() ) :
	?>
<section class="section" aria-labelledby="blog-title">
	<div class="wrap">
		<header class="shead shead--row reveal">
			<div>
				<span class="shead__n" dir="ltr">05</span>
				<span class="eyebrow"><?php kf_e( 'blog_ui.latest' ); ?></span>
				<h2 id="blog-title" class="h2"><?php kf_e( 'pages.blog.sub' ); ?></h2>
			</div>
			<a class="link-arrow" href="<?php echo esc_url( kf_route_url( 'blog' ) ); ?>"><?php kf_e( 'nav.blog' ); ?><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?></a>
		</header>
		<div class="posts">
			<?php foreach ( $latest->posts as $i => $p ) { kf_part( 'post-card', array( 'post' => $p, 'i' => $i ) ); } ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="section" aria-labelledby="faq-title">
	<div class="wrap faq-wrap">
		<header class="shead reveal">
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
