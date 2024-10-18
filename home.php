<?php
/**
 * 
 * The template for the blog of your website
 *
 * @package mini
 */

$sidebar_presence = get_post_meta($post->ID, 'sidebar_presence', true);
$container_width = get_post_meta($post->ID, 'page_container', true);

$content_size = 'box-100';
if ( is_active_sidebar( 'sidebar-1' ) ) {
	$content_size = 'box-75';
}

get_header();
?>

	<main id="primary" class="site-main" template="home">
		<div class="container fw">
			<div class="container <?= $container_width ?>">
				<div class="boxes">
					<div class="box my-0<?php if($container_width=='fw'): ?> p-0<?php else: ?> py-0<?php endif; ?> <?= $content_size ?>">
						<div class="boxes space-top">
							
							<div class="box box-100 my-2">
								<header class="entry-header">
									<h1 class="page-title m-0"><?php single_post_title(); ?></h1>
								</header><!-- .entry-header -->
							</div>

							<?php
							if ( have_posts() ) :

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
