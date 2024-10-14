<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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

							<?php if ( have_posts() ) : ?>

								<header class="page-header">
									<?php
									the_archive_title( '<h1 class="page-title">', '</h1>' );
									the_archive_description( '<div class="archive-description">', '</div>' );
									?>
								</header><!-- .page-header -->

								<?php
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();

									/*
									* Include the Post-Type-specific template for the content.
									* If you want to override this in a child theme, then include a file
									* called content-___.php (where ___ is the Post Type name) and that will be used instead.
									*/
									get_template_part( 'template-parts/content', get_post_type() );

								endwhile;

								the_posts_navigation();

							else :

								get_template_part( 'template-parts/content', 'none' );

							endif;
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
