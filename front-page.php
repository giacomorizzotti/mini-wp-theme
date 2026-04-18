<?php
/**
 * The template for the front page of your website
 *
 * @package mini
 */

// Get page layout settings for the front page
$pageID = get_option('page_on_front');
$layout = mini_get_page_layout( $pageID );

// Override for special case when front page is also the blog
if ( is_front_page() && is_home() ) {
	$layout['spacing_class'] = 'space-top-bot';
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$layout['content_size'] = 'box-75';
		$layout['sidebar_presence'] = true;
	}
}

$slideshow_id = get_post_meta( $pageID, '_mini_page_slideshow', true );

get_header();

?>

	<main id="primary" class="site-main" template="front-page">
		<?php
		if ( $slideshow_id ) {
			$slideshow_post = get_post( $slideshow_id );
			setup_postdata( $GLOBALS['post'] = $slideshow_post );
			get_template_part( 'template-parts/content', 'slideshow' );
			wp_reset_postdata();
		}
		?>
		<?php if (is_front_page() and is_home()): ?>
		<div class="container fw color-bg">
			<div class="container">
				<div class="boxes hh align-items-center">
					<div class="box-100">
						<h1 class="white-text">
							<?php echo get_bloginfo( 'name' ); ?>
						</h1>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="container fw">
			<div class="container <?php echo esc_attr( $layout['container_width'] ); ?>">
				<div class="boxes <?php echo esc_attr( $layout['spacing_class'] ); ?>">
					<div class="box my-0<?php if( $layout['container_width'] == 'fw' ): ?> p-0<?php else: ?> py-0<?php endif; ?> <?php echo esc_attr( $layout['content_size'] ); ?>">
						<div class="boxes">

							<?php
							while ( have_posts() ) :
								the_post();

								get_template_part( 'template-parts/content', get_post_type() );

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							endwhile; // End of the loop.
							?>

						</div>
					</div>
					
					<?php
					if ( $layout['sidebar_presence'] ) {
						get_sidebar();
					}
					?>
					
				</div>
			</div>
		</div>

	</main><!-- #main -->
	<?php 
		// Display author byline for E-E-A-T
		if ( $layout['display_author_info'] ) {
			$author_name = get_post_meta(get_the_ID(), '_mini_author_name', true);
			if (empty($author_name)) {
				$author_name = get_variable('mini_seo_settings', 'default_author_name');
			}
			$author_job_title = get_post_meta(get_the_ID(), '_mini_author_job_title', true) ?: get_variable('mini_seo_settings', 'default_author_job_title');
			if (!empty($author_name)) {
				echo '<div class="container fw fw-bg order-9"><div class="container author-byline py-05"><p class="S m-0 px-1">';
				echo 'By <strong>' . esc_html($author_name) . '</strong>';
				if (!empty($author_job_title)) {
					echo ', ' . esc_html($author_job_title);
				}
				echo '</p></div></div>';
			}
		}
	?>

<?php
get_footer();
