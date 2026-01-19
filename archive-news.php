<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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

	<main id="primary" class="site-main" template="archive">
		<div class="container fw">
			<div class="container">
				<div class="boxes space-top-bot">
					<div class="box my-0<?php if($container_width=='fw'): ?> p-0<?php endif; ?> <?= $content_size ?>">
						<div class="boxes">

							<?php if ( have_posts() ) : ?>

								<header class="page-header box-100">
									<h1 class="m-0"> <span class="color-box m-0 p-1"><?= esc_html__( 'News', 'mini') ?></span></h1>
									<?php /*
									the_archive_title( '<h1 class="page-title m-0">', '</h1>' );
									the_archive_description( '<div class="archive-description m-0">', '</div>' );
									*/ ?>
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

					<div class="box-25 p-2">
						<h4 class=""><?=esc_html__( 'Monthly archive', 'mini' )?>:</h4>
						<ul>
						<?php wp_get_archives( array( 'post_type' => 'news', 'type' => 'monthly' ) ); ?>
						</ul>
						<div class="sep-1 light-grey-bg my-2"></div>
					</div>
					
					<?php
					/* get_sidebar(); */
					?>
						
				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
