<?php
$size  = ! empty( $attributes['size'] ) ? preg_replace( '/[^0-9]/', '', $attributes['size'] ) : '1';
$class = $size === '1' ? 'space' : 'space-' . $size;
echo '<div class="' . esc_attr( $class ) . '"></div>';
