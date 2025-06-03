<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

get_header();
?>
	<main id="primary" class="site-main" template="single">

		<?php if ( has_post_thumbnail() ): ?>
		<div class="container fw" <?php if ( has_post_thumbnail() ): ?>style="background-image: url('<?=get_the_post_thumbnail_url(); ?>'); background-size: cover; background-position: center center;"<?php endif; ?>>
			<div class="container <?=$container_width?>">
				<div class="boxes hh align-content-end">
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
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="container fw">
			<div class="container <?=$container_width?>">
				
				<div class="boxes <?=$spacing_class?>">
					
					<div class="box my-0<?php if($container_width=='fw' || $space_top==false): ?> p-0<?php endif; ?> <?= $content_size ?>">
						<div class="boxes">

							<?php
							while ( have_posts() ) :
								the_post();

								get_template_part( 'template-parts/content', get_post_type() );
							?>
							
							<div class="box-100">
							<?php
								the_post_navigation(
									array(
										'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'mini' ) . '</span> <span class="nav-title">%title</span>',
										'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'mini' ) . '</span> <span class="nav-title">%title</span>',
									)
								);

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							endwhile; // End of the loop.
							?>
							</div>
							
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
