<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package mini
 */

// Get page layout settings
$layout = mini_get_page_layout();

get_header();
?>

<main id="primary" class="site-main" template="search">
	<div class="container fw">
		<div class="container">
			<div class="boxes">
				<div class="box my-0<?php if($container_width=='fw'): ?> p-0<?php endif; ?> <?= $content_size ?>">
					<div class="boxes">

						<?php if ( have_posts() ) : ?>

							<header class="page-header">
								<h1 class="page-title">
									<?php
									/* translators: %s: search query. */
									printf( esc_html__( 'Search Results for: %s', 'mini' ), '<span>' . get_search_query() . '</span>' );
									?>
								</h1>
							</header><!-- .page-header -->

							<?php
							/* Start the Loop */
							while ( have_posts() ) :
								the_post();

								/**
								 * Run the loop for the search to output the results.
								 * If you want to overload this in a child theme then include a file
								 * called content-search.php and that will be used instead.
								 */
								get_template_part( 'template-parts/content', 'search' );

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
