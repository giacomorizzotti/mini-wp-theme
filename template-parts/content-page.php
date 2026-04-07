<?php
/**
 * Template part for displaying page content in page.php
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

<article id="post-<?php the_ID(); ?>" <?php post_class("box box-100 my-0 p-0"); ?>>

	<?php if ( $layout['title_presence'] && ! has_post_thumbnail() ): ?>
	<div class="container fw forced"
		<?php if ( has_post_thumbnail() ): ?>style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url() ); ?>'); background-size: cover; background-position: center center;"<?php endif; ?>
		>
		<div class="container<?php if ( $layout['container_width'] != 'fw' ): ?> <?php echo esc_attr( $layout['container_width'] ); ?><?php endif; ?>">
			<div class="boxes space-top<?php if ( has_post_thumbnail() ): ?> hh align-content-end<?php endif; ?>">
				<div class="box box-100 my-2">
					<header class="entry-header">
						<?php if ( has_post_thumbnail() ): ?>
						<?php the_title( '<h1 class="entry-title wh-box m-0">', '</h1>' ); ?>
						<?php else: ?>
						<?php the_title( '<h1 class="entry-title m-0">', '</h1>' ); ?>
						<?php endif; ?>
					</header><!-- .entry-header -->
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<?php if ( !$layout['title_presence'] ): ?>
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
	<?php 
		// Display author byline for E-E-A-T
		if ( $layout['display_author_info'] ) {
			$author_name = get_post_meta(get_the_ID(), '_mini_author_name', true);
			if (empty($author_name)) {
				$author_name = get_variable('mini_seo_settings', 'default_author_name');
			}
			$author_job_title = get_post_meta(get_the_ID(), '_mini_author_job_title', true) ?: get_variable('mini_seo_settings', 'default_author_job_title');
			if (!empty($author_name)) {
				echo '<div class="container fw fw-bg mt-2"><div class="container author-byline py-05"><p class="S m-0 px-1">';
				echo 'By <strong>' . esc_html($author_name) . '</strong>';
				if (!empty($author_job_title)) {
					echo ', ' . esc_html($author_job_title);
				}
				echo '</p></div></div>';
			}
		}
	?>
</article><!-- #post-<?php the_ID(); ?> -->
