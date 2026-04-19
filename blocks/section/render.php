<?php
/**
 * Server-side render for mini/section block
 *
 * @package mini
 */

$section_id    = ! empty( $attributes['sectionId'] )    ? trim( $attributes['sectionId'] )    : '';
$extra_classes = ! empty( $attributes['extraClasses'] ) ? trim( $attributes['extraClasses'] ) : '';
$menu_name     = ! empty( $attributes['menuItemName'] ) ? trim( $attributes['menuItemName'] ) : '';
$is_page_menu  = ! empty( $attributes['isPageMenu'] );
$size          = ! empty( $attributes['size'] )         ? trim( $attributes['size'] )         : '';
$space_top     = ! empty( $attributes['spaceTop'] );
$space_bot     = ! empty( $attributes['spaceBot'] );

$classes = [];
if ( $is_page_menu )  $classes[] = 'page-menu';
if ( $space_top )     $classes[] = 'space-top';
if ( $space_bot )     $classes[] = 'space-bot';
if ( $extra_classes ) $classes[] = esc_attr( $extra_classes );
$class_str = $classes ? ' ' . implode( ' ', $classes ) : '';

$id_attr   = $section_id ? ' id="' . esc_attr( $section_id ) . '"' : '';
$menu_attr = $menu_name  ? ' menuItemName="' . esc_attr( $menu_name ) . '"' : '';

if ( $size ) {
    $container_class = $size === 'default' ? 'container' : 'container ' . esc_attr( $size );
    $inner = '<div class="' . $container_class . '">' . $content . '</div>';
} else {
    $inner = $content;
}
?>
<section<?php echo $id_attr; ?> class="<?php echo esc_attr( ltrim( $class_str ) ); ?>"<?php echo $menu_attr; ?>>
    <?php echo $inner; ?>
</section>
