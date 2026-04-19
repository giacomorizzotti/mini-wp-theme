<?php
if ( empty( $attributes['url'] ) ) {
    return;
}

$url          = $attributes['url'];
$alt          = isset( $attributes['alt'] )          ? $attributes['alt']          : '';
$link_url     = isset( $attributes['linkUrl'] )      ? trim( $attributes['linkUrl'] )      : '';
$open_new     = ! empty( $attributes['openInNewTab'] );
$width        = isset( $attributes['width'] )        ? trim( $attributes['width'] )        : '';
$height       = isset( $attributes['height'] )       ? trim( $attributes['height'] )       : '';

$style_parts = [];
if ( $width )  $style_parts[] = 'width:'  . esc_attr( $width );
if ( $height ) $style_parts[] = 'height:' . esc_attr( $height );
$style_attr = $style_parts ? ' style="' . implode( ';', $style_parts ) . '"' : '';

$img = '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $alt ) . '" class="img"' . $style_attr . '>';

if ( $link_url ) {
    $target = $open_new ? ' target="_blank" rel="noopener noreferrer"' : '';
    echo '<a href="' . esc_url( $link_url ) . '"' . $target . '>' . $img . '</a>';
} else {
    echo $img;
}
