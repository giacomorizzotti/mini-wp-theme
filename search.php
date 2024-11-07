<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package mini
 */

$sidebar_presence = get_post_meta($post->ID, 'sidebar_presence', true);
$container_width = get_post_meta($post->ID, 'page_container', true);

$space_top = get_post_meta($post->ID, 'space_top', true);
$space_bottom = get_post_meta($post->ID, 'space_bot', true);
$spacing_class= '';
if($space_top==true && $space_top==false) {
	$spacing_class= 'space-top';
}else if($space_top==false && $space_top==true) {
	$spacing_class= 'space-bot';
}else if($space_top==true && $space_top==true) {
	$spacing_class= 'space-top-bot';
}

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
				if ($sidebar_presence == true):
				?>

				<?php
				get_sidebar();
				?>
					
				<?php
				endif;
				?>

				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
