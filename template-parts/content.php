<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

$container_width = get_post_meta($post->ID, 'page_container', true);

?>

<div class="box box-100 my-0 p-0">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<div class="boxes">

			<div class="space space-3"></div>

			<header class="box box-100 my-0<?php if($container_width=='fw'): ?> p-0<?php endif; ?> entry-header">
				<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;
				if ( 'post' === get_post_type() ) :
					?>
					<p class="entry-meta S">
						<?php
						mini_posted_on();
						mini_posted_by();
						?>
					</p><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->

			<div class="box box-100 mt-2 mb-0 p-0">
				<?php mini_post_thumbnail(); ?>
			</div>

			<div class="box box-100 mt-0 mb-2 py-0 entry-content">
				<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'mini' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mini' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->

			<footer class="entry-footer box box-100 my-0 py-0 S">
				<?php mini_entry_footer(); ?>
			</footer><!-- .entry-footer -->

		</div>

	</article><!-- #post-<?php the_ID(); ?> -->
</div>
