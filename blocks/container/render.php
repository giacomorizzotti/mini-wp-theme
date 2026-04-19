<?php
$size      = ! empty( $attributes['size'] )     ? trim( $attributes['size'] ) : '';
$space_top = ! empty( $attributes['spaceTop'] );
$space_bot = ! empty( $attributes['spaceBot'] );
$parts     = [ 'container' ];
if ( $size )      $parts[] = esc_attr( $size );
if ( $space_top ) $parts[] = 'space-top';
if ( $space_bot ) $parts[] = 'space-bot';
?>
<div class="<?php echo esc_attr( implode( ' ', $parts ) ); ?>">
    <?php echo $content; ?>
</div>
