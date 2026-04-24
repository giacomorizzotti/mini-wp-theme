<?php
/**
 * Contact Form – GDPR consent field partial
 *
 * Can be overridden (in priority order) at:
 *   overrides/parts/contact-form-field-gdpr.php
 *   micro/template-parts/contact-form-field-gdpr.php
 *
 * Variables in scope (set by load_template in mini_render_contact_form_gdpr()):
 *   $uid   string  Unique form-instance ID
 *   $opts  array   Saved contact-form option values
 *
 * @package mini
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$gdpr_settings = get_option( 'mini_gdpr_privacy_settings', [] );
$gdpr_page_id  = absint( $gdpr_settings['mini_gdpr_privacy_page_id'] ?? 0 );
if ( ! $gdpr_page_id ) {
    $gdpr_page_id = (int) get_option( 'wp_page_for_privacy_policy' );
}
$privacy_url = $gdpr_page_id
    ? esc_url( get_permalink( $gdpr_page_id ) )
    : esc_url( get_privacy_policy_url() );
?>
<div class="box-100 mini-cf-field mini-cf-consent">
    <label>
        <input type="checkbox" name="mini_cf_consent" value="1"
               class="inline-block" style="vertical-align: middle;" required>
        <?php if ( $privacy_url ) :
            printf(
                wp_kses(
                    /* translators: %s: URL to the privacy policy page */
                    __( 'I have read and accept the <a href="%s" target="_blank" rel="noopener noreferrer">Privacy Policy</a>.', 'mini' ),
                    [ 'a' => [ 'href' => [], 'target' => [], 'rel' => [] ] ]
                ),
                $privacy_url
            );
        else :
            esc_html_e( 'I have read and accept the Privacy Policy.', 'mini' );
        endif; ?>
    </label>
</div>
