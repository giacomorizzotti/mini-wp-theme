<?php
/**
 * Contact Form template
 *
 * Default template loaded by the [mini_contact_form] shortcode.
 * Can be overridden (in priority order) at:
 *   overrides/parts/contact-form.php
 *   micro/template-parts/contact-form.php
 *
 * Variables available (set by the shortcode before load_template()):
 *   $uid    string  Unique ID for this form instance (e.g. "mini-cf-1")
 *   $opts   array   Saved contact-form option values
 *   $fields array   Field definitions from mini_get_contact_form_fields()
 *
 * @package mini
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div id="<?php echo esc_attr( $uid ); ?>" class="mini-contact-form-wrap">
    <form class="mini-contact-form" novalidate>
        <?php wp_nonce_field( 'mini_contact_form_nonce', 'mini_cf_nonce' ); ?>
        <div class="boxes">

            <div class="box-100 mini-cf-response-wrap" style="display:none;">
                <p class="mini-cf-response" role="alert" aria-live="polite"></p>
            </div>

            <?php foreach ( $fields as $field_key => $field ) : ?>
                <?php mini_render_contact_form_field( $field_key, $field, $uid ); ?>
            <?php endforeach; ?>

            <?php if ( ! empty( $opts['mini_cf_gdpr_consent'] ) ) : ?>
                <?php mini_render_contact_form_gdpr( $uid, $opts ); ?>
            <?php endif; ?>

            <div class="box-30 mini-cf-field mini-cf-altcha">
                <altcha-widget
                    challengeurl="<?php echo esc_url( admin_url( 'admin-ajax.php' ) . '?action=mini_altcha_challenge' ); ?>"
                    auto="onload"
                    hidefooter
                ></altcha-widget>
            </div>

            <div class="box-100 mini-cf-field mini-cf-submit">
                <button type="submit" class="btn"><?php esc_html_e( 'Send message', 'mini' ); ?></button>
            </div>

        </div>
    </form>
</div>
<script>
(function () {
    var wrap         = document.getElementById( '<?php echo esc_js( $uid ); ?>' );
    if ( ! wrap ) return;
    var form         = wrap.querySelector( '.mini-contact-form' );
    var responseWrap = wrap.querySelector( '.mini-cf-response-wrap' );
    var response     = wrap.querySelector( '.mini-cf-response' );
    var submitBtn    = wrap.querySelector( 'button[type="submit"]' );

    function clearFieldErrors() {
        wrap.querySelectorAll( '.mini-cf-field-error' ).forEach( function ( el ) { el.remove(); } );
        wrap.querySelectorAll( '.danger-border' ).forEach( function ( el ) {
            el.classList.remove( 'danger-border' );
        } );
    }

    function showFieldErrors( fields ) {
        clearFieldErrors();
        Object.keys( fields ).forEach( function ( name ) {
            var input = form.querySelector( '[name="' + name + '"]' );
            if ( ! input ) return;
            input.classList.add( 'danger-border' );
            var msg = document.createElement( 'span' );
            msg.className = 'mini-cf-field-error danger-text S';
            msg.textContent = fields[ name ];
            var fieldWrap = input.closest( '.mini-cf-field' );
            if ( fieldWrap ) {
                fieldWrap.appendChild( msg );
            } else {
                input.insertAdjacentElement( 'afterend', msg );
            }
            // Clear error on next user interaction
            input.addEventListener( 'input', function onInput() {
                input.classList.remove( 'danger-border' );
                var err = fieldWrap ? fieldWrap.querySelector( '.mini-cf-field-error' ) : msg;
                if ( err ) err.remove();
                input.removeEventListener( 'input', onInput );
            } );
        } );
    }

    form.addEventListener( 'submit', function ( e ) {
        e.preventDefault();
        clearFieldErrors();
        var data = new FormData( form );
        data.append( 'action', 'mini_contact_form_submit' );

        submitBtn.disabled = true;
        responseWrap.style.display = 'none';
        responseWrap.className = 'box-100 mini-cf-response-wrap';
        response.textContent = '';

        fetch( '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>', {
            method: 'POST',
            credentials: 'same-origin',
            body: data
        } )
        .then( function ( r ) { return r.json(); } )
        .then( function ( res ) {
            responseWrap.style.display = '';
            if ( res.success ) {
                responseWrap.classList.add( 'success-bg' );
                response.classList.add( 'white-text' );
                response.textContent = res.data.message;
                form.reset();
            } else {
                responseWrap.classList.add( 'danger-bg' );
                response.classList.add( 'white-text' );
                response.textContent = res.data.message;
                if ( res.data.fields ) {
                    showFieldErrors( res.data.fields );
                }
                submitBtn.disabled = false;
            }
        } )
        .catch( function () {
            responseWrap.style.display = '';
            responseWrap.classList.add( 'danger-bg' );
            response.classList.add( 'white-text' );
            response.textContent = '<?php echo esc_js( __( 'An error occurred. Please try again.', 'mini' ) ); ?>';
            submitBtn.disabled = false;
        } );
    } );
}());
</script>
