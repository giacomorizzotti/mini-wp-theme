<?php
$size          = ! empty( $attributes['size'] )    ? preg_replace( '/[^0-9]/', '', $attributes['size'] ) : '1';
$extra_classes = ! empty( $attributes['className'] ) ? sanitize_text_field( $attributes['className'] )   : '';
$class         = $size === '1' ? 'space' : 'space-' . $size;
if ( $extra_classes ) $class .= ' ' . $extra_classes;
echo '<div class="' . esc_attr( $class ) . '"></div>';
