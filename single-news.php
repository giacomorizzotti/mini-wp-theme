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
	<main id="primary" class="site-main" template="single-news">

		<div class="container fw">
			<div class="container <?=$container_width?>">
				
				<div class="boxes space-top-bot">
					
					<div class="box my-0 p-0 box-75">
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

					<div class="box-25 p-2 fw-bg">
						<h4 class=""><?=esc_html__( 'Monthly archive', 'mini' )?>:</h4>
						<ul>
						<?php wp_get_archives( array( 'post_type' => 'news', 'type' => 'monthly' ) ); ?>
						</ul>
						<div class="sep-1 light-grey-bg my-2"></div>
					</div>

					<?php
						/* get_sidebar();*/
					?>

				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
