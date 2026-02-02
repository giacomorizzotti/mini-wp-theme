<?php
/**
 * The template for displaying single lesson posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package mini
 */

// Get page layout settings
$layout = mini_get_page_layout();

get_header();
?>
	<main id="primary" class="site-main" template="single-lesson">

		<div class="container fw">
			<div class="container <?php echo esc_attr( $layout['container_width'] ); ?>">
				
				<div class="boxes space-top-bot">
					
					<div class="box my-0 <?php if ($layout['sidebar_presence']) echo 'box-75'; else echo 'box-100'; ?>">
						<div class="boxes">
							<?php
							while ( have_posts() ) :
								the_post();

								get_template_part( 'template-parts/content', get_post_type() );
							?>
							<div class="box-zero-50 fw-bg">
								<p class=""><?php previous_post_link(); ?></p>
							</div>
							<div class="box-zero-50 fw-bg">
								<p class=""><?php next_post_link(); ?></p>
							</div>
							<?php
							endwhile; // End of the loop.
							?>
						</div>
					</div>

					<?php
						if ($layout['sidebar_presence']) {
							get_sidebar('lesson');
						}
					?>

				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
