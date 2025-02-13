<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

$container_width = get_post_meta($post->ID, 'page_container', true);
get_header();

?>

	<main id="primary" class="site-main" template="archive">
		<div class="container fw">
			<div class="container">
				<div class="boxes space-top-bot">
					<div class="box-75 my-0<?php if($container_width=='fw'): ?> p-0<?php endif; ?>">
						<div class="boxes">

							<?php if ( have_posts() ) : ?>

								<header class="page-header box-100">
									<?php
									the_archive_title( '<h1 class="page-title m-0">', '</h1>' );
									the_archive_description( '<div class="archive-description m-0">', '</div>' );
									?>
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
