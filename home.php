<?php
/**
 * 
 * The template for the blog of your website
 *
 * @package mini
 */

// Get page layout settings for the blog page
$pageID = get_option('page_for_posts');
$layout = mini_get_page_layout( $pageID );

get_header();

?>

	<main id="primary" class="site-main" template="home">

		<?php if ( has_post_thumbnail($pageID) ): ?>
		<div class="container fw" <?php if ( has_post_thumbnail($pageID) ): ?>style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url($pageID) ); ?>'); background-size: cover; background-position: center center;"<?php endif; ?>>
			<div class="container <?php echo esc_attr( $layout['container_width'] ); ?>">
				<div class="boxes hh align-content-end">
					<?php if ( $layout['title_presence'] ): ?>
					<header class="box box-100 my-0 p-0 entry-header">
					 	<h1 class="entry-title m-0 wh-box"><?php single_post_title(); ?></h1>
						<div class="space-2"></div>
					</header>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="container fw">
			<div class="container <?php echo esc_attr( $layout['container_width'] ); ?>">
				<div class="boxes <?php echo esc_attr( $layout['spacing_class'] ); ?>">
					<div class="box my-0<?php if( $layout['container_width'] == 'fw' ): ?> p-0<?php else: ?> py-0<?php endif; ?> <?php echo esc_attr( $layout['content_size'] ); ?>">
						<div class="boxes">
							
							<?php if ( ! has_post_thumbnail($pageID) && $layout['title_presence'] ): ?>
							<div class="box box-100 my-2">
								<header class="entry-header">
									<h1 class="page-title m-0"><?php single_post_title(); ?></h1>
								</header><!-- .entry-header -->
							</div>
							<?php endif; ?>

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

							?>
							<div class="sep-1 light-grey-bg my-3"></div>
							<?php

								endwhile;

								the_posts_navigation();

							else :

								get_template_part( 'template-parts/content', 'none' );

							endif;
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
get_footer();
