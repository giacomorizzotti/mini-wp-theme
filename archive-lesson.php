<?php
/**
 * The template for displaying lesson archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

// Get page layout settings
$layout = mini_get_page_layout();

get_header();

?>

	<main id="primary" class="site-main" template="archive-lesson">
		<div class="container fw">
			<div class="container">
				<div class="boxes space-top-bot">
					<div class="box-75 my-0<?php if( $layout['container_width'] == 'fw' ): ?> p-0<?php else: ?> py-0<?php endif; ?>">
						<div class="boxes">

							<?php if ( have_posts() ) : ?>

								<header class="page-header box-100">
									<h1 class="m-0"> <span class="color-box m-0 p-1"><?= esc_html__( 'Lessons', 'mini' ) ?></span></h1>
									<?php /*
									the_archive_title( '<h1 class="page-title m-0">', '</h1>' );
									the_archive_description( '<div class="archive-description m-0">', '</div>' );
									*/ ?>
								</header><!-- .page-header -->

								<?php
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();
									get_template_part( 'template-parts/content', get_post_type() );
								endwhile;

								the_posts_navigation();

							else :

								get_template_part( 'template-parts/content', 'none' );

							endif;
							?>

						</div>
					</div>

					<div class="box-25 p-2">
						<h4 class=""><?=esc_html__( 'Monthly archive', 'mini' )?>:</h4>
						<ul>
						<?php wp_get_archives( array( 'post_type' => 'lesson', 'type' => 'monthly' ) ); ?>
						</ul>
						<div class="sep-1 light-grey-bg my-2"></div>
					</div>
						
				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
