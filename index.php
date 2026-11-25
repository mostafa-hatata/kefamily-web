<?php
/**
 * Generic fallback (blog index, archives, single posts, other pages).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="phero phero--plain">
	<div class="phero__glow" aria-hidden="true"></div>
	<div class="wrap prose">
		<?php if ( have_posts() ) : ?>
			<?php if ( ! is_singular() ) : ?>
				<h1 class="h1"><?php echo esc_html( is_home() ? 'Blog' : wp_strip_all_tags( get_the_archive_title() ) ); ?></h1>
				<div class="posts">
				<?php while ( have_posts() ) : the_post(); ?>
					<a class="post-card spotlight" data-spotlight href="<?php the_permalink(); ?>">
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						<h2><?php the_title(); ?></h2>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
					</a>
				<?php endwhile; ?>
				</div>
				<?php the_posts_pagination(); ?>
			<?php else : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class(); ?>>
						<h1 class="h1"><?php the_title(); ?></h1>
						<div class="entry"><?php the_content(); ?></div>
					</article>
				<?php endwhile; ?>
			<?php endif; ?>
		<?php else : ?>
			<h1 class="h1"><?php kf_e( 'notfound.title' ); ?></h1>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
