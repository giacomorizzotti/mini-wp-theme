<?php
/**
 * The template for displaying Landing Pages
 *
 * @package mini
 */

$layout = mini_get_page_layout();

$slideshow_id = get_post_meta( get_the_ID(), '_mini_page_slideshow', true );

get_header();
?>

	<main id="primary" class="site-main" template="landing_page">

		<?php
		if ( $slideshow_id && is_mini_option_enabled( 'mini_content_settings', 'mini_slide' ) ) {
			$slideshow_post = get_post( $slideshow_id );
			setup_postdata( $GLOBALS['post'] = $slideshow_post );
			get_template_part( 'template-parts/content', 'slideshow' );
			wp_reset_postdata();
		}
		?>

		<?php if ( has_post_thumbnail() ) : ?>
		<div class="container fw" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url() ); ?>'); background-size: cover; background-position: center center;">
			<div class="container">
				<div class="boxes hh align-content-end">
					<?php if ( $layout['title_presence'] ) : ?>
					<header class="box-100 my-0 p-0 entry-header">
						<?php the_title( '<h1 class="entry-title m-0"><span class="wh-box lh-12">', '</span></h1>' ); ?>
						<div class="space-2"></div>
					</header>
					<?php else : ?>
						<?php the_title( '<h1 class="visually-hidden">', '</h1>' ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="container fw">
			<div class="container <?php echo esc_attr( $layout['container_width'] ); ?>">
				<div class="boxes <?php echo esc_attr( $layout['spacing_class'] ); ?>">
					<div class="box my-0<?php if ( $layout['container_width'] === 'fw' ) : ?> p-0<?php else : ?> py-0<?php endif; ?> <?php echo esc_attr( $layout['content_size'] ); ?>">
						<div class="boxes">
							<?php
							while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/content', 'landing_page' );
							endwhile;
							?>
						</div>
					</div>

					<?php
					if ( $layout['sidebar_presence'] ) {
						get_sidebar( 'landing_page' );
					}
					?>
				</div>
			</div>
		</div>

	</main><!-- #main -->

	<?php
	// Display author byline for E-E-A-T
	if ( $layout['display_author_info'] ) {
		$author_name = get_post_meta( get_the_ID(), '_mini_author_name', true );
		if ( empty( $author_name ) ) {
			$author_name = get_variable( 'mini_seo_settings', 'default_author_name' );
		}
		$author_job_title = get_post_meta( get_the_ID(), '_mini_author_job_title', true ) ?: get_variable( 'mini_seo_settings', 'default_author_job_title' );
		if ( ! empty( $author_name ) ) {
			echo '<div class="container fw fw-bg order-9"><div class="container author-byline py-05"><p class="S m-0 px-1">';
			echo 'By <strong>' . esc_html( $author_name ) . '</strong>';
			if ( ! empty( $author_job_title ) ) {
				echo ', ' . esc_html( $author_job_title );
			}
			echo '</p></div></div>';
		}
	}
	?>

<?php
get_footer();
