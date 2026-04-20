<?php
/**
 * Server-side render for mini/section block
 *
 * @package mini
 */

$section_id    = ! empty( $attributes['sectionId'] )    ? trim( $attributes['sectionId'] )    : '';
$wp_classes    = ! empty( $attributes['className'] )    ? trim( $attributes['className'] )    : '';
$menu_name     = ! empty( $attributes['menuItemName'] ) ? trim( $attributes['menuItemName'] ) : '';
$is_page_menu  = ! empty( $attributes['isPageMenu'] );
$size          = ! empty( $attributes['size'] )     ? trim( $attributes['size'] )     : '';
$bg_color      = ! empty( $attributes['bgColor'] )  ? trim( $attributes['bgColor'] )  : '';
$space_top     = ! empty( $attributes['spaceTop'] );
$space_bot     = ! empty( $attributes['spaceBot'] );

$classes = [];
if ( $size !== 'none' ) {
    $classes[] = 'container';
    if ( $size && $size !== 'default' ) $classes[] = esc_attr( $size );
}
if ( $is_page_menu ) $classes[] = 'page-menu';
if ( $bg_color )     $classes[] = esc_attr( $bg_color );
if ( $space_top )    $classes[] = 'space-top';
if ( $space_bot )    $classes[] = 'space-bot';
if ( $wp_classes )   $classes[] = esc_attr( $wp_classes );
$class_str = $classes ? implode( ' ', $classes ) : '';

$id_attr    = $section_id ? ' id="' . esc_attr( $section_id ) . '"' : '';
$class_attr = $class_str  ? ' class="' . esc_attr( $class_str ) . '"' : '';
$menu_attr  = $menu_name  ? ' menuItemName="' . esc_attr( $menu_name ) . '"' : '';
?>
<section<?php echo $id_attr; ?><?php echo $class_attr; ?><?php echo $menu_attr; ?>>
    <?php echo $content; ?>
</section>
