<?php
$size          = ! empty( $attributes['size'] )      ? trim( $attributes['size'] )      : '';
$bg_color      = ! empty( $attributes['bgColor'] )   ? trim( $attributes['bgColor'] )   : '';
$space_top     = ! empty( $attributes['spaceTop'] );
$space_bot     = ! empty( $attributes['spaceBot'] );
$extra_classes = ! empty( $attributes['className'] ) ? sanitize_text_field( $attributes['className'] ) : '';
$parts         = [ 'container' ];
if ( $size )          $parts[] = esc_attr( $size );
if ( $bg_color )      $parts[] = esc_attr( $bg_color );
if ( $space_top )     $parts[] = 'space-top';
if ( $space_bot )     $parts[] = 'space-bot';
if ( $extra_classes ) $parts[] = $extra_classes;
?>
<div class="<?php echo esc_attr( implode( ' ', $parts ) ); ?>">
    <?php echo $content; ?>
</div>
