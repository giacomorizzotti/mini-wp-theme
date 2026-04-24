<?php
/**
 * Contact Form – Field configuration and template helpers
 *
 * Defines the default field list (filterable) and the functions used by
 * the plugin shortcode and template parts to resolve, load and render fields.
 *
 * @package mini
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ---------------------------------------------------------------------------
// Field registry
// ---------------------------------------------------------------------------

/**
 * Return the contact-form field definitions.
 *
 * Each entry is keyed by a short slug and contains:
 *   type         string  HTML input type, or 'textarea'
 *   label        string  Visible label (i18n)
 *   name         string  HTML name attribute sent to the AJAX handler
 *   required     bool
 *   box_class    string  Grid class (box-25 / box-33 / box-50 / box-100 …)
 *   autocomplete string  HTML5 autocomplete token (omit key to skip)
 *   rows         int     Textarea rows (textarea only)
 *
 * Override example (in micro/custom-functions.php):
 *
 *   add_filter( 'mini_contact_form_fields', function ( $fields ) {
 *       unset( $fields['phone'] );           // remove a field
 *       $fields['company'] = [               // add a field
 *           'type'         => 'text',
 *           'label'        => __( 'Company', 'mini' ),
 *           'name'         => 'mini_cf_company',
 *           'required'     => false,
 *           'box_class'    => 'box-100',
 *           'autocomplete' => 'organization',
 *       ];
 *       return $fields;
 *   } );
 *
 * @return array
 */
function mini_get_contact_form_fields() {
    $fields = [
        'name' => [
            'type'         => 'text',
            'label'        => __( 'Name', 'mini' ),
            'name'         => 'mini_cf_name',
            'required'     => true,
            'box_class'    => 'box-50',
            'autocomplete' => 'given-name',
        ],
        'surname' => [
            'type'         => 'text',
            'label'        => __( 'Surname', 'mini' ),
            'name'         => 'mini_cf_surname',
            'required'     => true,
            'box_class'    => 'box-50',
            'autocomplete' => 'family-name',
        ],
        'email' => [
            'type'         => 'email',
            'label'        => __( 'Email', 'mini' ),
            'name'         => 'mini_cf_email',
            'required'     => true,
            'box_class'    => 'box-50',
            'autocomplete' => 'email',
        ],
        'phone' => [
            'type'         => 'tel',
            'label'        => __( 'Phone number', 'mini' ),
            'name'         => 'mini_cf_phone',
            'required'     => false,
            'box_class'    => 'box-50',
            'autocomplete' => 'tel',
        ],
        'message' => [
            'type'      => 'textarea',
            'label'     => __( 'Message', 'mini' ),
            'name'      => 'mini_cf_message',
            'required'  => false,
            'box_class' => 'box-100',
            'rows'      => 5,
        ],
    ];

    /**
     * Filters the contact form field definitions.
     *
     * @param array $fields Associative array of field configs keyed by slug.
     */
    return apply_filters( 'mini_contact_form_fields', $fields );
}

// ---------------------------------------------------------------------------
// Template resolution
// ---------------------------------------------------------------------------

/**
 * Resolve the main contact-form template path.
 *
 * Priority:
 *   1. overrides/parts/contact-form.php        (instance override)
 *   2. micro/template-parts/contact-form.php   (micro subtheme)
 *   3. template-parts/contact-form.php         (mini-theme default)
 *
 * @return string Absolute path to the template file.
 */
function mini_get_contact_form_template() {
    $base = get_template_directory();

    $candidates = [
        $base . '/overrides/parts/contact-form.php',
        $base . '/micro/template-parts/contact-form.php',
        $base . '/template-parts/contact-form.php',
    ];

    foreach ( $candidates as $path ) {
        if ( file_exists( $path ) ) {
            return $path;
        }
    }

    // Last-resort: the default (will 404 gracefully if template-parts file is missing).
    return $base . '/template-parts/contact-form.php';
}

/**
 * Load the main contact-form template with $uid, $opts and $fields in scope.
 *
 * Using a dedicated function means each variable is a named parameter and
 * is naturally in scope when the file is include'd — no WP version dependency.
 *
 * @param string $template Absolute path resolved by mini_get_contact_form_template().
 * @param string $uid      Unique form-instance ID.
 * @param array  $opts     Saved contact-form option values.
 * @param array  $fields   Field definitions from mini_get_contact_form_fields().
 */
function mini_load_contact_form_tpl( $template, $uid, $opts, $fields ) {
    include $template;
}

/**
 * Load a per-field template with $field_key, $field and $uid in scope.
 *
 * @param string $template  Absolute path to the field partial.
 * @param string $field_key Field slug.
 * @param array  $field     Field config.
 * @param string $uid       Unique form-instance ID.
 */
function mini_load_contact_form_field_tpl( $template, $field_key, $field, $uid ) {
    include $template;
}

/**
 * Resolve a per-field template path.
 *
 * Looks for contact-form-field-{$slug}.php in the same hierarchy as the
 * main template. Returns false when no specialised template is found so
 * the caller falls back to mini_render_contact_form_field().
 *
 * The textarea type is special: always resolved to
 * contact-form-field-textarea.php when no slug-specific override exists.
 *
 * @param string $slug  Field slug (e.g. 'name', 'message', 'gdpr').
 * @param array  $field Field config array (optional, used to detect textarea).
 * @return string|false Absolute path or false.
 */
function mini_get_contact_form_field_template( $slug, $field = [] ) {
    $base     = get_template_directory();
    $filename = "contact-form-field-{$slug}.php";

    $dirs = [
        $base . '/overrides/parts/',
        $base . '/micro/template-parts/',
        $base . '/template-parts/',
    ];

    // Slug-specific override (works for any slug including 'gdpr').
    foreach ( $dirs as $dir ) {
        if ( file_exists( $dir . $filename ) ) {
            return $dir . $filename;
        }
    }

    // Fallback for textarea type: use the shared textarea partial.
    if ( isset( $field['type'] ) && 'textarea' === $field['type'] ) {
        foreach ( $dirs as $dir ) {
            if ( file_exists( $dir . 'contact-form-field-textarea.php' ) ) {
                return $dir . 'contact-form-field-textarea.php';
            }
        }
    }

    return false;
}

// ---------------------------------------------------------------------------
// Rendering helpers
// ---------------------------------------------------------------------------

/**
 * Render a single form field.
 *
 * If a template file is found for this slug it is loaded (with $field,
 * $field_key and $uid in scope); otherwise a minimal inline markup is output.
 *
 * @param string $field_key Field slug.
 * @param array  $field     Field config.
 * @param string $uid       Unique form instance ID.
 */
function mini_render_contact_form_field( $field_key, $field, $uid ) {
    $template = mini_get_contact_form_field_template( $field_key, $field );
    if ( $template ) {
        mini_load_contact_form_field_tpl( $template, $field_key, $field, $uid );
        return;
    }

    // Default inline markup for text / email / tel inputs.
    ?>
    <div class="<?php echo esc_attr( $field['box_class'] ?? 'box-100' ); ?> mini-cf-field">
        <label for="<?php echo esc_attr( $uid . '-' . $field_key ); ?>">
            <?php echo esc_html( $field['label'] ); ?>
            <?php if ( ! empty( $field['required'] ) ) : ?>
                <span class="color-text" aria-hidden="true">*</span>
            <?php endif; ?>
        </label>
        <input
            type="<?php echo esc_attr( $field['type'] ?? 'text' ); ?>"
            id="<?php echo esc_attr( $uid . '-' . $field_key ); ?>"
            name="<?php echo esc_attr( $field['name'] ); ?>"
            <?php if ( ! empty( $field['required'] ) ) : ?>required<?php endif; ?>
            <?php if ( ! empty( $field['autocomplete'] ) ) : ?>autocomplete="<?php echo esc_attr( $field['autocomplete'] ); ?>"<?php endif; ?>
        >
    </div>
    <?php
}

/**
 * Render the GDPR consent checkbox.
 *
 * Uses a template file if one is found; otherwise outputs inline markup.
 *
 * @param string $uid  Unique form instance ID.
 * @param array  $opts Contact-form option values.
 */
function mini_render_contact_form_gdpr( $uid, $opts ) {
    $template = mini_get_contact_form_field_template( 'gdpr' );
    if ( $template ) {
        mini_load_contact_form_field_tpl( $template, 'gdpr', [], $uid );
        return;
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
    <?php
}
