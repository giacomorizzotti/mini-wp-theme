<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

$container_width = get_post_meta($post->ID, 'page_container', true);
$title_classes_if_thumbnail = '';
if ( has_post_thumbnail() ) {
	$title_classes_if_thumbnail = ' wh-box';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class("box box-100 my-0 p-0"); ?>>

	<?php if ( !has_post_thumbnail() || is_home() || is_archive() ): ?>
	<div class="container fw"
			<?php if ( has_post_thumbnail() ): ?>style="background-image: url('<?=get_the_post_thumbnail_url(); ?>'); background-size: cover; background-position: center center;"<?php endif; ?>
			>
		<?php /*<div class="container<?php if ($container_width!='fw'): ?><?=' '.$container_width?><?php endif; ?>">*/ ?>
		<div class="container<?php if ( !is_home() && !is_archive() ){echo ' '.$container_width;}?>">
			<div class="boxes <?php if ( has_post_thumbnail() ): ?> <?php if ( is_singular() ): ?>hfh<?php else: ?>one-third-full-height<?php endif; ?> align-content-end<?php endif; ?>">
				<header class="box box-100 my-0 entry-header">
				<?php if ( 'post' === get_post_type() ) :?>
					<p class="entry-meta S m-0 fw-box">
						<?php
						mini_posted_on();
						mini_posted_by();
						?>
					</p><!-- .entry-meta -->
					<div class="space"></div>
				<?php endif; ?>
				<?php
					if ( is_singular() ) {
						the_title( '<h1 class="entry-title m-0'.$title_classes_if_thumbnail.'">', '</h1>' );
					} else {
						the_title( '<h2 class="entry-title m-0"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="m-0'.$title_classes_if_thumbnail.' bk-text">', '</a></h2>' );
					}
					?>
				</header><!-- .entry-header -->
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="container<?php if ( !is_home() && !is_archive() ){echo ' '.$container_width;}?>">

		<div class="boxes">

			<div class="box box-100 entry-content">
				<?php
				if ( !is_singular() && has_excerpt() ) {
					the_excerpt();
				} else {
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
			<div class="sep-1 grey-bg mx-2" style="width: 60px;"></div>
			<footer class="box box-100 my-0 entry-footer">
				<p class="S"><?php mini_entry_footer(); ?></p>
			</footer><!-- .entry-footer -->
		</div>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
