<?php
/**
 * Template part for displaying a slide inside a slideshow.
 *
 * @package mini
 */

$slideshow_id = $args['slideshow_id'] ?? get_post_field( 'post_parent', get_the_ID() );
$layout = mini_get_page_layout( $slideshow_id );
$bg_color = get_post_meta( get_the_ID(), 'slide_bg_color', true );
?>
<li class="slide <?php echo esc_attr( $bg_color ); ?>" data-header-top="<?php echo esc_attr( get_post_meta( get_the_ID(), 'header_styling_top', true ) ); ?>" template="content-slide">
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="img">
		<?php the_post_thumbnail( 'full' ); ?>
	</div>
	<?php endif; ?>

	<?php if ( get_post_meta( get_the_ID(), 'dot_mask', true ) === '1' ) : ?>
	<div class="dot-bg fit"></div>
	<?php endif; ?>

	<?php if ( get_the_content() ) : ?>
	<div class="caption container <?php echo esc_attr( $layout['container_width'] ); ?> fh">
		<?php the_content(); ?>
	</div>
	<?php endif; ?>
</li>

