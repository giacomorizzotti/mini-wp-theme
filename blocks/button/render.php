<?php
$label       = ! empty( $attributes['label'] )       ? $attributes['label']       : 'Click here';
$url         = ! empty( $attributes['url'] )         ? $attributes['url']         : '#';
$color       = ! empty( $attributes['color'] )       ? $attributes['color']       : 'main-color';
$size        = ! empty( $attributes['size'] )        ? $attributes['size']        : '';
$open_new    = ! empty( $attributes['openInNewTab'] );
$invert      = ! empty( $attributes['invert'] );
$transp_bg   = ! empty( $attributes['transpBg'] );

$color_class = esc_attr( $color ) . '-btn' . ( $invert ? '-invert' : '' );
$classes = array_filter( [ 'btn', $size, $color_class, $transp_bg ? 'transp-bg' : '' ] );
$target  = $open_new ? ' target="_blank" rel="noopener noreferrer"' : '';
?>
<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"<?php echo $target; ?>>
    <?php echo esc_html( $label ); ?>
</a>
