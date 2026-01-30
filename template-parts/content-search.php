<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

// Get page layout settings if not already set
if ( ! isset( $layout ) ) {
	$layout = mini_get_page_layout();
}

?>

<div class="box box-100 my-0<?php if( $layout['container_width'] == 'fw' ): ?> p-0<?php else: ?> py-0<?php endif; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if( $layout['container_width'] == 'fw' ): ?>
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
		
<?php if( $layout['container_width'] == 'fw' ): ?>
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
