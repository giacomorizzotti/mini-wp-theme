<?php
/**
 * The template for displaying Landing Pages
 *
 * @package mini
 */

$layout      = mini_get_page_layout();
$show_header = get_post_meta( get_the_ID(), 'landing_show_header', true );
$show_footer = get_post_meta( get_the_ID(), 'landing_show_footer', true );
$show_header = ( $show_header !== '0' ); // Default true
$show_footer = ( $show_footer !== '0' ); // Default true

$slideshow_id = get_post_meta( get_the_ID(), '_mini_page_slideshow', true );

if ( $show_header ) {
	get_header();
} else {
	?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<?php
}
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
						<?php the_title( '<h1 class="entry-title m-0 wh-box">', '</h1>' ); ?>
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
if ( $show_footer ) {
	get_footer();
} else {
	// Credits line
	if ( get_variable( 'mini_options', 'mini_credits' ) ) {
		?>
	<div id="credits" class="fw-bg">
		<p class="S m-0 center grey-text p-1 pt-05">
			<i class="fa fa-heart mini-text heart" aria-hidden="true"></i>&nbsp;
			Proudly <i>fully custom</i> designed & developed by&nbsp;
			<a href="https://www.uwa.agency/" target="_blank" class="fb-text hover-col">
				<img src="https://mini.uwa.agency/img/uwa/brand/uwa_logo.svg" class="img" alt="UWA logo" style="display: inline-block; width: 26px; transform: translate(0, 25%);"/>
			</a>&nbsp;
			using&nbsp;
			<a href="https://mini.uwa.agency/" target="_blank" class="fb-text link-hover-text">
				<img src="https://mini.uwa.agency/img/brand/mini_emblem.svg" class="img" alt="mini logo" style="display: inline-block; width: 16px;"/>&nbsp;
				mini
			</a>
		</p>
	</div>
		<?php
	}
	wp_footer();
	?>
</body>
</html>
	<?php
}
