<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

$sidebar_presence = get_post_meta($post->ID, 'sidebar_presence', true);
$container_width = get_post_meta($post->ID, 'page_container', true);

$content_size = 'box-100';
if ( is_active_sidebar( 'sidebar-1' ) ) {
	if ($sidebar_presence != false) {
		$content_size = 'box-75';
	}
}

get_header();
?>

	<main id="primary" class="site-main" template="page">
		<div class="container fw">
			<div class="container <?= $container_width ?>">
				<div class="boxes">
					<div class="box my-0<?php if($container_width=='fw'): ?> p-0<?php else: ?> py-0<?php endif; ?> <?= $content_size ?>">
						<div class="boxes">

							<?php
							while ( have_posts() ) :
								the_post();

								get_template_part( 'template-parts/content', 'page' );

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							endwhile; // End of the loop.
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
get_footer();
