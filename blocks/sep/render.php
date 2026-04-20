<?php
$size          = isset( $attributes['size'] )       ? preg_replace( '/[^0-9]/', '', $attributes['size'] ) : '';
$color_class   = isset( $attributes['colorClass'] ) ? sanitize_html_class( $attributes['colorClass'] )   : '';
$extra_classes = ! empty( $attributes['className'] ) ? sanitize_text_field( $attributes['className'] )   : '';

$base    = $size === '' ? 'sep' : 'sep-' . $size;
$classes = trim( implode( ' ', array_filter( [ $base, $color_class, $extra_classes ] ) ) );

echo '<div class="' . esc_attr( $classes ) . '"></div>';
