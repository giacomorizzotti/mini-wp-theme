<?php
/**
 * Template part for displaying a slide inside a slideshow.
 *
 * @package mini
 */

$slideshow_id   = $args['slideshow_id'] ?? get_post_field( 'post_parent', get_the_ID() );
$layout         = mini_get_page_layout( get_the_ID() );
$bg_color       = get_post_meta( get_the_ID(), 'slide_bg_color', true );
$container_cls  = trim( sanitize_html_class( (string) ( $layout['container_width'] ?? '' ) ) );
$spacing_cls    = trim( sanitize_html_class( (string) ( $layout['spacing_class']    ?? '' ) ) );
$show_title     = ! empty( $layout['title_presence'] );
?>
<li class="slide <?php echo esc_attr( $bg_color ); ?>"
	data-header-top="<?php echo esc_attr( get_post_meta( get_the_ID(), 'header_styling_top', true ) ); ?>"
	data-header-scroll="<?php echo esc_attr( get_post_meta( get_the_ID(), 'header_styling_scroll', true ) ); ?>"
	template="content-slide">

	<?php if ( has_post_thumbnail() ) : ?>
	<div class="img">
		<?php the_post_thumbnail( 'full' ); ?>
	</div>
	<?php endif; ?>

	<?php if ( get_post_meta( get_the_ID(), 'dot_mask', true ) === '1' ) : ?>
	<div class="dot-bg fit"></div>
	<?php endif; ?>

	<?php if ( get_the_content() ) : ?>
	<div class="caption fit">
		<div class="container fw">
			<div class="container <?php echo esc_attr( $container_cls ); ?>">
				<div class="boxes fh align-content-end <?php echo esc_attr( $spacing_cls ); ?>">
					<?php if ( $show_title ) : ?>
					<div class="box-100">
						<h2 class="m-0 white-box p-1"><?php the_title(); ?></h2>
					</div>
					<?php endif; ?>
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</li>

