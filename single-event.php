<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package mini
 */

// Get page layout settings
$layout = mini_get_page_layout();

get_header();
?>
	<main id="primary" class="site-main" template="single-event">

		<?php if ( has_post_thumbnail() ): ?>
		<div class="container fw">
			<div class="fit" style="background-image: url('<?= get_the_post_thumbnail_url(get_the_ID(), 'full') ?>'); background-size: cover; background-position: center;"></div>
			<div class="container<?php echo ' ' . esc_attr( $layout['container_width'] ); ?>">
				<div class="boxes hh align-items-end">
					<header class="box-100 entry-header p-2">
					<?php
						the_title( '<h1 class="entry-title big inline-block white-box">', '</h1>' );
						if ( has_post_thumbnail() && get_post_meta(get_the_ID(), 'event_poster_id', true)) { echo '<div class="space" style="height:calc( var(--margin) *  6);"></div>';}
					?>
					</header><!-- .entry-header -->
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="container fw">
			<div class="container <?php echo esc_attr( $layout['container_width'] ); ?>">
				
				<div class="boxes <?php if ( has_post_thumbnail() ) { echo "py-4"; } else { echo esc_attr( $layout['spacing_class'] ); } ?>">
					
					<div class="box my-0 py-0 <?php if ($layout['sidebar_presence']) echo 'box-75'; else echo 'box-100'; ?>">
						<div class="boxes">
							<?php
							while ( have_posts() ) :
								the_post();

								get_template_part( 'template-parts/content', get_post_type() );
							?>
							<div class="box-zero-50 px-1">
								<p class=""><?php previous_post_link(); ?></p>
							</div>
							<div class="box-zero-50 px-1">
								<p class="right"><?php next_post_link(); ?></p>
							</div>
							<?php
							endwhile; // End of the loop.
							?>
						</div>
					</div>

					<?php
						if ($layout['sidebar_presence']) {
							get_sidebar('event');
						}
					?>

				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
