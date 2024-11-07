<?php
/**
 * The template for the front page of your website
 *
 * @package mini
 */

/* page options */
$pageID = get_option('page_on_front');

/* title */
$title_presence = get_post_meta($pageID, 'title_presence', true);
/* sidebar */
$sidebar_presence = get_post_meta($pageID, 'sidebar_presence', true);
/* container width */
$container_width = get_post_meta($pageID, 'page_container', true);

/* top and bottom spacing */
$space_top = get_post_meta($pageID, 'space_top', true);
$space_bottom = get_post_meta($pageID, 'space_bot', true);
$spacing_class= '';
if($space_top==true && $space_top==false) {
	$spacing_class= 'space-top';
}else if($space_top==false && $space_top==true) {
	$spacing_class= 'space-bot';
}else if($space_top==true && $space_top==true) {
	$spacing_class= 'space-top-bot';
}

/* content size with and without sidebar sidebar */
$content_size = 'box-100';
if ( is_active_sidebar( 'sidebar-1' ) ) {
	if ($sidebar_presence != false) {
		$content_size = 'box-75';
	}
}

get_header();
?>

	<main id="primary" class="site-main" template="front-page">
		<div class="container fw">
			<div class="container <?= $container_width ?>">
				<div class="boxes <?=$spacing_class?>">
					<div class="box my-0<?php if($container_width=='fw'): ?> p-0<?php endif; ?> <?= $content_size ?>">
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
					if ($sidebar_presence != false) {
						get_sidebar();
					}
					?>
					
				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
