<?php
$label       = ! empty( $attributes['label'] )       ? $attributes['label']       : 'Click here';
$url         = ! empty( $attributes['url'] )         ? $attributes['url']         : '#';
$color       = isset( $attributes['color'] )         ? $attributes['color']       : '';
$size        = ! empty( $attributes['size'] )        ? $attributes['size']        : '';
$open_new    = ! empty( $attributes['openInNewTab'] );
$invert      = ! empty( $attributes['invert'] );
$transp_bg   = ! empty( $attributes['transpBg'] );

$extra_classes = ! empty( $attributes['className'] ) ? sanitize_text_field( $attributes['className'] ) : '';
$color_class   = $color ? esc_attr( $color ) . '-btn' . ( $invert ? '-invert' : '' ) : '';
$classes       = array_filter( [ 'btn', $size, $color_class, $transp_bg ? 'transp-bg' : '', $extra_classes ] );
$target  = $open_new ? ' target="_blank" rel="noopener noreferrer"' : '';
?>
<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"<?php echo $target; ?>>
    <?php echo esc_html( $label ); ?>
</a>
