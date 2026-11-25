<?php
/**
 * Single article — /blog/{slug}/
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$p = kf_current_post();
if ( ! $p ) {
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	include get_404_template();
	return;
}
setup_postdata( $GLOBALS['post'] = $p ); // phpcs:ignore
$topic = kf_post_topic( $p );
$style = $topic && isset( kf_brands_meta()[ $topic ] ) ? kf_brand_style( $topic ) : '';
get_header();
?>
<article class="article" style="<?php echo esc_attr( $style ); ?>">
	<header class="phero phero--article">
		<div class="wrap wrap--text">
			<?php kf_part( 'crumbs' ); ?>
			<div class="post-card__meta reveal">
				<?php if ( $style ) : ?><a class="tag" href="<?php echo esc_url( kf_url( 'blog/topic/' . $topic . '/' ) ); ?>" dir="ltr"><i class="dot" aria-hidden="true"></i><?php echo esc_html( kf_brand( $topic )['name'] ); ?></a><?php endif; ?>
				<time datetime="<?php echo esc_attr( get_the_date( 'c', $p ) ); ?>"><?php echo esc_html( kf_date( $p, true ) ); ?></time>
				<span><?php echo (int) kf_reading_time( $p ); ?> <?php kf_e( 'blog_ui.read' ); ?></span>
			</div>
			<h1 class="h1 article__title reveal" style="--d:.05s"><?php echo esc_html( get_the_title( $p ) ); ?></h1>
			<p class="lead reveal" style="--d:.1s"><?php echo esc_html( get_the_excerpt( $p ) ); ?></p>
			<p class="article__by reveal" style="--d:.12s"><?php echo kf_logo_mark( 24 ); // phpcs:ignore ?><span><?php kf_e( 'blog_ui.by' ); ?></span></p>
		</div>
	</header>
	<div class="wrap wrap--text">
		<div class="prose reveal">
			<?php echo apply_filters( 'the_content', $p->post_content ); // phpcs:ignore ?>
		</div>
		<?php $tr = kf_post_translations( $p ); unset( $tr[ kf_lang() ] ); ?>
		<?php if ( $tr ) : ?>
			<p class="article__tr"><?php echo kf_icon( 'globe' ); // phpcs:ignore ?>
				<?php foreach ( $tr as $code => $tp ) : ?>
					<a href="<?php echo esc_url( kf_post_url( $tp ) ); ?>" hreflang="<?php echo esc_attr( kf_langs()[ $code ]['hreflang'] ); ?>" lang="<?php echo esc_attr( kf_langs()[ $code ]['hreflang'] ); ?>"><?php echo esc_html( kf_langs()[ $code ]['name'] ); ?></a>
				<?php endforeach; ?>
			</p>
		<?php endif; ?>
		<aside class="article__cta">
			<p><?php kf_e( 'cta.sub' ); ?></p>
			<div class="hero__ctas">
				<a class="btn" href="<?php echo esc_url( kf_route_url( 'book' ) ); ?>"><?php echo kf_icon( 'calendar' ); // phpcs:ignore ?><span><?php kf_e( 'nav.book' ); ?></span></a>
				<a class="btn btn--line" href="<?php echo esc_url( kf_whatsapp_url( get_the_title( $p ) ) ); ?>" target="_blank" rel="noopener"><?php echo kf_icon( 'whatsapp' ); // phpcs:ignore ?><span><?php kf_e( 'cta.btn2' ); ?></span></a>
			</div>
		</aside>
	</div>
</article>

<?php
$rel = kf_blog_query( 1, '', 3, array( $p->ID ) );
if ( $rel->have_posts() ) :
	?>
<section class="section">
	<div class="wrap">
		<header class="shead reveal"><h2 class="h2"><?php kf_e( 'blog_ui.related' ); ?></h2></header>
		<div class="posts">
			<?php foreach ( $rel->posts as $i => $rp ) { kf_part( 'post-card', array( 'post' => $rp, 'i' => $i ) ); } ?>
		</div>
	</div>
</section>
<?php endif; ?>
<?php
wp_reset_postdata();
get_footer();
