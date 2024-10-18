<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

$container_width = get_post_meta($post->ID, 'page_container', true);

?>

<div class="box box-100 my-0<?php if($container_width=='fw'): ?> p-0<?php endif; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if($container_width=='fw'): ?>
		</div>
		<div class="container">
			<div class="boxes">
<?php endif; ?>

		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				mini_posted_on();
				mini_posted_by();
				?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->
		
<?php if($container_width=='fw'): ?>
			</div>
		</div>
		<div class="boxes">
<?php endif; ?>

		<?php mini_post_thumbnail(); ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

		<footer class="entry-footer">
			<?php mini_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div>
