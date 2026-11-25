<?php
/**
 * /blog/ — index, topic filter, pagination.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();
$paged  = max( 1, (int) get_query_var( 'kf_page' ) );
$topic  = sanitize_title( (string) get_query_var( 'kf_topic' ) );
$topics = kf_blog_topics();
if ( $topic && ! in_array( $topic, $topics, true ) ) {
	$topic = '';
}
$q = kf_blog_query( $paged, $topic, 9 );

kf_part(
	'page-hero',
	array(
		'title'  => kf_get( 'pages.blog.title' ),
		'sub'    => kf_get( 'pages.blog.sub' ),
		'center' => false,
	)
);
?>
<section class="section section--tight">
	<div class="wrap">
		<nav class="filters" aria-label="<?php kf_e( 'nav.blog' ); ?>">
			<a href="<?php echo esc_url( kf_route_url( 'blog' ) ); ?>" <?php echo $topic ? '' : 'aria-current="page"'; ?>><?php kf_e( 'blog_ui.all' ); ?></a>
			<?php foreach ( $topics as $t ) : ?>
				<?php $tb = kf_brand( $t ); ?>
				<a href="<?php echo esc_url( kf_url( 'blog/topic/' . $t . '/' ) ); ?>" <?php echo $tb ? 'style="' . esc_attr( kf_brand_style( $t ) ) . '"' : ''; ?> <?php echo $topic === $t ? 'aria-current="page"' : ''; ?> dir="ltr"><i class="dot" aria-hidden="true"></i><?php echo esc_html( $tb ? $tb['name'] : 'KeFamily' ); ?></a>
			<?php endforeach; ?>
		</nav>

		<?php if ( $q->have_posts() ) : ?>
			<div class="posts">
				<?php foreach ( $q->posts as $i => $p ) { kf_part( 'post-card', array( 'post' => $p, 'i' => $i, 'hl' => 'h2' ) ); } ?>
			</div>
			<?php if ( $q->max_num_pages > 1 ) : $base = $topic ? 'blog/topic/' . $topic . '/' : 'blog/'; ?>
				<nav class="pager" aria-label="Pagination">
					<?php if ( $paged > 1 ) : ?><a href="<?php echo esc_url( kf_url( $base . ( $paged > 2 ? 'page/' . ( $paged - 1 ) . '/' : '' ) ) ); ?>" rel="prev"><?php kf_e( 'blog_ui.prev' ); ?></a><?php endif; ?>
					<span dir="ltr"><?php echo (int) $paged; ?> / <?php echo (int) $q->max_num_pages; ?></span>
					<?php if ( $paged < $q->max_num_pages ) : ?><a href="<?php echo esc_url( kf_url( $base . 'page/' . ( $paged + 1 ) . '/' ) ); ?>" rel="next"><?php kf_e( 'blog_ui.next' ); ?></a><?php endif; ?>
				</nav>
			<?php endif; ?>
		<?php else : ?>
			<p class="empty"><?php kf_e( 'blog_ui.empty' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
kf_part( 'cta' );
get_footer();
