<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

$container_width = get_post_meta($post->ID, 'page_container', true);

?>

<div class="box box-100 my-0<?php if($container_width=='fw'): ?> p-0<?php endif; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="boxes">
			

			<?php
			$title_presence = get_post_meta($post->ID, 'title_presence', true);
			if ($title_presence == true):
			?>
			<div class="space space-3"></div>
			<div class="box box-100 my-0 p-0">
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->
			</div>
			<?php endif; ?>

			<div class="box box-100 my-0 p-0">
			<?php mini_post_thumbnail(); ?>
			</div>

			<div class="box box-100 my-0 p-0 entry-content">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mini' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->
			
			<?php if ( get_edit_post_link() ) : ?>
				<footer class="box box-100 my-0 p-0 entry-footer">
					<?php
					edit_post_link(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Edit <span class="screen-reader-text">%s</span>', 'mini' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							wp_kses_post( get_the_title() )
						),
						'<span class="edit-link">',
						'</span>'
					);
					?>
				</footer><!-- .entry-footer -->
			<?php endif; ?>

		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
</div>
