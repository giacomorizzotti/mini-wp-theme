<?php
/**
 * The template for the front page of your website
 *
 * @package mini
 */

// Get page layout settings for the front page
$pageID = get_option('page_on_front');
$layout = mini_get_page_layout( $pageID );

// Override for special case when front page is also the blog
if ( is_front_page() && is_home() ) {
	$layout['spacing_class'] = 'space-top-bot';
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$layout['content_size'] = 'box-75';
		$layout['sidebar_presence'] = true;
	}
}

get_header();

?>

	<main id="primary" class="site-main" template="front-page">
		<?php if (is_front_page() and is_home()): ?>
		<div class="container fw color-bg">
			<div class="container">
				<div class="boxes hh align-items-center">
					<div class="box-100">
						<h1 class="white-text">
							<?php echo get_bloginfo( 'name' ); ?>
						</h1>
					</div>
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

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							endwhile; // End of the loop.
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
