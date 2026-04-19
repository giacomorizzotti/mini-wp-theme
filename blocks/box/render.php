<?php
$width   = ! empty( $attributes['width'] )   ? preg_replace( '/[^0-9]/', '', $attributes['width'] ) : '50';
$padding = isset( $attributes['padding'] ) && $attributes['padding'] !== '' ? preg_replace( '/[^0-5]/', '', $attributes['padding'] ) : '';
$classes = 'box-' . $width . ( $padding !== '' ? ' p-' . $padding : '' );
?>
<div class="<?php echo esc_attr( $classes ); ?>">
    <?php echo $content; ?>
</div>
