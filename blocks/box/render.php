<?php
$width         = ! empty( $attributes['width'] )     ? preg_replace( '/[^0-9]/', '', $attributes['width'] ) : '50';
$padding       = isset( $attributes['padding'] ) && $attributes['padding'] !== '' ? preg_replace( '/[^0-5]/', '', $attributes['padding'] ) : '';
$extra_classes = ! empty( $attributes['className'] ) ? sanitize_text_field( $attributes['className'] ) : '';
$classes       = 'box-' . $width . ( $padding !== '' ? ' p-' . $padding : '' ) . ( $extra_classes ? ' ' . $extra_classes : '' );

$aos_attrs = '';
$aos_enabled = function_exists( 'mini_check_option' ) && mini_check_option( 'mini_ext_lib_options', 'mini_aos' );
if ( $aos_enabled && ! empty( $attributes['aosAnimation'] ) ) {
    $aos_attrs .= ' data-aos="' . esc_attr( $attributes['aosAnimation'] ) . '"';
    if ( ! empty( $attributes['aosDelay'] ) )    $aos_attrs .= ' data-aos-delay="'    . absint( $attributes['aosDelay'] )    . '"';
    if ( ! empty( $attributes['aosDuration'] ) ) $aos_attrs .= ' data-aos-duration="' . absint( $attributes['aosDuration'] ) . '"';
    if ( ! empty( $attributes['aosOffset'] ) )   $aos_attrs .= ' data-aos-offset="'   . absint( $attributes['aosOffset'] )   . '"';
}
?>
<div class="<?php echo esc_attr( $classes ); ?>"<?php echo $aos_attrs; ?>>
    <?php echo $content; ?>
</div>
