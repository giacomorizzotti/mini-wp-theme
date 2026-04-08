<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

// Get page layout settings if not already set
if ( ! isset( $layout ) ) {
	$layout = mini_get_page_layout();
}
// Default to true when meta has never been saved ('0' means explicitly disabled)
$show_archive_image = get_post_meta( get_the_ID(), 'archive_featured_image', true ) !== '0';
$is_shortcode = ! empty( $args['is_shortcode'] );
$title_classes_if_thumbnail = '';
if ( has_post_thumbnail() && $show_archive_image ) {
	$title_classes_if_thumbnail = ' wh-box';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class("box-100 my-0 p-0"); ?>>

	<?php if ( (is_singular() && $is_shortcode ) || is_home() || is_archive() || ( !$is_shortcode && !has_post_thumbnail() ) ): ?>
	<div class="container fw"
			<?php if ( ( ! is_singular() || $is_shortcode ) && ( has_post_thumbnail() && $show_archive_image ) ): ?>style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url() ); ?>'); background-size: cover; background-position: center center;"<?php endif; ?>
			>
		<div class="container<?php if ( ! is_home() && ! is_archive() ) { echo ' ' . esc_attr( $layout['container_width'] ); } ?>">
			<div class="boxes <?php if ( has_post_thumbnail() && $show_archive_image ): ?> <?php if ( $is_shortcode || is_home() || is_archive() ): ?>h33<?php endif; ?> align-content-end<?php endif; ?>">
				<header class="box-100 my-0 entry-header">
				<?php if ( 'post' === get_post_type() ) :?>
					<p class="entry-meta S m-0 fw-px-1">
						<?php
						mini_posted_on();
						if ( $layout['display_author_info'] ) {
							mini_posted_by();
						}
						?>
					</p><!-- .entry-meta -->
					<div class="space"></div>
				<?php endif; ?>
				<?php
					if ( is_singular() && ! $is_shortcode ) {
						the_title( '<h1 class="entry-title m-0'.$title_classes_if_thumbnail.'">', '</h1>' );
					} else {
						the_title( '<h3 class="entry-title m-0'.$title_classes_if_thumbnail.'"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="m-0 bk-text">', '</a></h3>' );
					}
					?>
				</header><!-- .entry-header -->
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="container<?php if ( ! is_home() && ! is_archive() ) { echo ' ' . esc_attr( $layout['container_width'] ); } ?>">

		<div class="boxes">

			<div class="<?php echo esc_attr( $layout['content_size'] ); ?> entry-content">
				<?php
				if ( !is_singular() || ! empty( $args['is_shortcode'] ) ) {
					// Show excerpt on archive pages, category pages, etc.
					the_excerpt();
				} else {
					// Show full content on single post pages
					the_content(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'mini' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							wp_kses_post( get_the_title() )
						)
					);
				}
				
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mini' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->
			<footer class="box-100 my-0 entry-footer">
				<p class="S"><?php mini_entry_footer(); ?></p>
			</footer><!-- .entry-footer -->
		</div>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
