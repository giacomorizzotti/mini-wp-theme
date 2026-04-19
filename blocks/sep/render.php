<?php
$size        = isset( $attributes['size'] )       ? preg_replace( '/[^0-9]/', '', $attributes['size'] ) : '';
$color_class = isset( $attributes['colorClass'] ) ? sanitize_html_class( $attributes['colorClass'] )   : '';

$base    = $size === '' ? 'sep' : 'sep-' . $size;
$classes = trim( implode( ' ', array_filter( [ $base, $color_class ] ) ) );

echo '<div class="' . esc_attr( $classes ) . '"></div>';
