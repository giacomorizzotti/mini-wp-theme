<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package mini
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container fw">
			<div class="container">
				<div class="boxes space-top-bot">
					<div class="box my-0 p-0 <?php if ( is_active_sidebar( 'sidebar-1' ) ): ?>box-75<?php else: ?>box-100<?php endif; ?>">
						<div class="boxes">

							<?php
							while ( have_posts() ) :
								the_post();

								get_template_part( 'template-parts/content', get_post_type() );

								the_post_navigation(
									array(
										'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'mini' ) . '</span> <span class="nav-title">%title</span>',
										'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'mini' ) . '</span> <span class="nav-title">%title</span>',
									)
								);

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							endwhile; // End of the loop.
							?>
							
						</div>
					</div>

					<?php
					get_sidebar();
					?>

				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
