<?php
/**
 * Template part for displaying landing page content in single-landing_page.php
 *
 * @package mini
 */

// Get page layout settings if not already set
if ( ! isset( $layout ) ) {
	$layout = mini_get_page_layout();
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'box-100 my-0 p-0' ); ?> template="content-landing_page">

	<?php if ( $layout['title_presence'] && ! has_post_thumbnail() ) : ?>
	<div class="container fw">
		<div class="container<?php if ( $layout['container_width'] !== 'fw' ) : ?> <?php echo esc_attr( $layout['container_width'] ); ?><?php endif; ?>">
			<div class="boxes">
				<div class="box-100 my-2">
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title m-0">', '</h1>' ); ?>
					</header><!-- .entry-header -->
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<?php if ( ! $layout['title_presence'] ) : ?>
		<?php the_title( '<h1 class="visually-hidden">', '</h1>' ); ?>
	<?php endif; ?>

	<div class="container <?php echo esc_attr( $layout['container_width'] ); ?>">

		<div class="entry-content">
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
		<footer class="entry-footer">
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
				'<div class="container"><span class="edit-link">',
				'</span></div>'
			);
			?>
		</footer><!-- .entry-footer -->
		<?php endif; ?>

	</div>
</article><!-- #post-<?php the_ID(); ?> -->
