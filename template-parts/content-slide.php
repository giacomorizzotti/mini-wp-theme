<?php
/**
 * Template part for displaying a slide inside a slideshow.
 *
 * @package mini
 */

$slideshow_id = $args['slideshow_id'] ?? get_post_field( 'post_parent', get_the_ID() );
$layout = mini_get_page_layout( $slideshow_id );
?>
<li class="slide" data-header-top="<?php echo esc_attr( get_post_meta( get_the_ID(), 'header_styling_top', true ) ); ?>" template="content-slide">
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="img">
		<?php the_post_thumbnail( 'full' ); ?>
	</div>
	<?php endif; ?>

	<?php
	$slide_show_title = get_post_meta( get_the_ID(), 'title_presence', true );
	?>
	<?php if ( ( $slide_show_title && get_the_title() ) || get_the_content() ) : ?>
	<div class="caption">
		<div class="container<?php if ( $layout['container_width'] && $layout['container_width'] !== 'fw' ) : ?> <?php echo esc_attr( $layout['container_width'] ); ?><?php endif; ?>">
			<div class="boxes fh space-top-bot align-content-end">
				<div class="<?php echo esc_attr( $layout['content_size'] ); ?>"><?php // box-100 or box-66 ?>
					<?php if ( $slide_show_title && get_the_title() ) : ?>
					<h2 class="wh-text"><?php the_title(); ?></h2>
					<?php endif; ?>
					<?php if ( get_the_content() ) : ?>
					<div class="XL wh-text"><?php the_content(); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</li>

