<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package mini
 */

$container_width = get_post_meta($post->ID, 'page_container', true);


get_header();
?>
	<main id="primary" class="site-main" template="single">

		<div class="container fw">
			<div class="container <?=$container_width?>">
				
				<div class="boxes space-top-bot">
					
					<div class="box my-0 box-75">
						<div class="boxes">

							<?php
							while ( have_posts() ) :
								the_post();

								get_template_part( 'template-parts/content', get_post_type() );
							?>
							
							<div class="box-100">
							<?php
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
					</div>

					<div class="box-25 p-2 fw-bg">
						<h4 class=""><?=esc_html__( 'Monthly archive:', 'mini' )?></h4>
						<ul>
						<?php wp_get_archives( array( 'post_type' => 'event', 'type' => 'monthly' ) ); ?>
						</ul>
						<div class="sep-1 light-grey-bg my-2"></div>
					</div>

				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
