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

// Get page layout settings
$layout = mini_get_page_layout();

get_header();
?>

	<main id="primary" class="site-main" template="page">

		<?php if ( has_post_thumbnail() ): ?>
		<div class="container fw" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url() ); ?>'); background-size: cover; background-position: center center;">
			<div class="container">
				<div class="boxes hh align-content-end">
					<?php if ( $layout['title_presence'] ): ?>
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
					<?php the_title( '<h1 class="entry-title m-0 wh-bg p-1 inline-block">', '</h1>' ); ?>
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
