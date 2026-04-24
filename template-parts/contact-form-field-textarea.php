<?php
/**
 * Contact Form – textarea field partial
 *
 * Used for any field whose 'type' is 'textarea'.
 * Can be overridden (in priority order) at:
 *   overrides/parts/contact-form-field-textarea.php
 *   micro/template-parts/contact-form-field-textarea.php
 *
 * Variables in scope (set by load_template in mini_render_contact_form_field()):
 *   $field_key  string
 *   $field      array   Field config
 *   $uid        string  Unique form-instance ID
 *
 * @package mini
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="<?php echo esc_attr( $field['box_class'] ?? 'box-100' ); ?> mini-cf-field">
    <label for="<?php echo esc_attr( $uid . '-' . $field_key ); ?>">
        <?php echo esc_html( $field['label'] ); ?>
        <?php if ( ! empty( $field['required'] ) ) : ?>
            <span class="color-text" aria-hidden="true">*</span>
        <?php endif; ?>
    </label>
    <textarea
        id="<?php echo esc_attr( $uid . '-' . $field_key ); ?>"
        name="<?php echo esc_attr( $field['name'] ); ?>"
        rows="<?php echo esc_attr( $field['rows'] ?? 5 ); ?>"
        <?php if ( ! empty( $field['required'] ) ) : ?>required<?php endif; ?>
    ></textarea>
</div>
