<?php
$classes = ['boxes'];

$flex_direction  = isset( $attributes['flexDirection'] )  ? sanitize_html_class( $attributes['flexDirection'] )  : '';
$flex_wrap       = isset( $attributes['flexWrap'] )       ? sanitize_html_class( $attributes['flexWrap'] )       : '';
$justify_content = isset( $attributes['justifyContent'] ) ? sanitize_html_class( $attributes['justifyContent'] ) : '';
$align_content   = isset( $attributes['alignContent'] )   ? sanitize_html_class( $attributes['alignContent'] )   : '';
$align_items     = isset( $attributes['alignItems'] )     ? sanitize_html_class( $attributes['alignItems'] )     : '';
$height_class    = isset( $attributes['heightClass'] )    ? sanitize_html_class( $attributes['heightClass'] )    : '';
$gap_class       = isset( $attributes['gapClass'] )       ? sanitize_html_class( $attributes['gapClass'] )       : '';
$space_top       = ! empty( $attributes['spaceTop'] );
$space_bot       = ! empty( $attributes['spaceBot'] );
$extra_classes   = isset( $attributes['className'] )      ? sanitize_text_field( $attributes['className'] )      : '';

if ( $space_top ) $classes[] = 'space-top';
if ( $space_bot ) $classes[] = 'space-bot';
foreach ( [ $flex_direction, $flex_wrap, $justify_content, $align_content, $align_items, $height_class, $gap_class, $extra_classes ] as $cls ) {
    if ( $cls !== '' ) $classes[] = $cls;
}

echo '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $content . '</div>';
?>
