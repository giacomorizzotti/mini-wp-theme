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
	<main id="primary" class="site-main" template="single">

		<?php if ( has_post_thumbnail() ): ?>
		<div class="container fw" <?php if ( has_post_thumbnail() ): ?>style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url() ); ?>'); background-size: cover; background-position: center center;"<?php endif; ?>>
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

								get_template_part( 'template-parts/content', get_post_type() );
							?>
							
							<div class="sep-1 my-1 light-grey-bg">
								
							</div>
							<div class="box-100 w-100">
							<?php
								the_post_navigation(
									array(
										'prev_text' => '<span class="label">' . esc_html__( 'Previous', 'mini' ) . ':</span> <span class="nav-title" style="line-height: 1.8;">%title</span><br/>',
										'next_text' => '<span class="label">' . esc_html__( 'Next', 'mini' ) . ':</span> <span class="nav-title" style="line-height: 1.8;">%title</span>',
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
					get_sidebar('post');
					?>
		</div>

	</main><!-- #main -->

<?php
get_footer();
