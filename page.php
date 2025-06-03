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

$content_size = 'box-100';
if ( is_active_sidebar( 'sidebar-1' ) ) {
	if ($sidebar_presence != false) {
		$content_size = 'box-75';
	}
}

$title_presence = get_post_meta($post->ID, 'title_presence', true);

get_header();
?>

	<main id="primary" class="site-main" template="page">

		<?php if ( has_post_thumbnail() ): ?>
		<div class="container fw" <?php if ( has_post_thumbnail() ): ?>style="background-image: url('<?=get_the_post_thumbnail_url(); ?>'); background-size: cover; background-position: center center;"<?php endif; ?>>
			<div class="container">
				<div class="boxes hh align-content-end">
					<?php if ($title_presence): ?>
					<header class="box box-100 my-0 p-0 entry-header">
					<?php if ( 'post' === get_post_type() ) :?>
						<p class="entry-meta S m-0 fw-box">
							<?php
							mini_posted_on();
							mini_posted_by();
							?>
						</p><!-- .entry-meta -->
						<div class="space"></div>
					<?php endif; ?>
					<?php the_title( '<h1 class="entry-title m-0 wh-box">', '</h1>' ); ?>
						<div class="space-2"></div>
					</header>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="container fw">
			<div class="container <?= $container_width ?>">
				<div class="boxes <?=$spacing_class?>">
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
