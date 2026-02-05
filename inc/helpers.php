<?php
/**
 * Helper Functions
 *
 * Utility functions used throughout the theme
 *
 * @package mini
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Checkbox option helper
 */
function mini_theme_checkbox_option(
    string $option_group, 
    string $option, 
    string $status = '',
) {
    $options = get_option( $option_group );
    if ( is_array( $options ) && isset( $options[$option] ) && $options[$option] ) {
        $status = 'checked';
    }
    
    return sprintf(
        '<input type="checkbox" id="%s" name="%s[%s]" value="1" %s>',
        esc_attr( $option ),
        esc_attr( $option_group ),
        esc_attr( $option ),
        $status
    );
}

/**
 * Text field option helper
 */
function mini_theme_text_field_option(
    string $option_group, 
    string $option, 
    string $default_value = '', 
    string $style='width: 100%;',
) {
    $options = get_option( $option_group );
    $value = '';
    
    if ( is_array( $options ) && isset( $options[$option] ) ) {
        $value = $options[$option];
    }
    
    return sprintf(
        '<input type="text" id="%s" name="%s[%s]" value="%s" placeholder="%s" style="%s">',
        esc_attr( $option ),
        esc_attr( $option_group ),
        esc_attr( $option ),
        esc_attr( $value ),
        esc_attr( $default_value ),
        esc_attr( $style )
    );
}

/**
 * Textarea option helper
 */
function mini_theme_textarea_option(
    string $option_group, 
    string $option, 
    string $default_value = '', 
    string $style='width: 100%;',
    int $rows = 3
) {
    $options = get_option( $option_group );
    $value = '';
    
    if ( is_array( $options ) && isset( $options[$option] ) ) {
        $value = $options[$option];
    }
    
    $placeholder_attr = $default_value ? sprintf( 'placeholder="%s"', esc_attr( $default_value ) ) : '';
    
    return sprintf(
        '<textarea id="%s" name="%s[%s]" %s style="%s" rows="%d">%s</textarea>',
        esc_attr( $option ),
        esc_attr( $option_group ),
        esc_attr( $option ),
        $placeholder_attr,
        esc_attr( $style ),
        absint( $rows ),
        esc_textarea( $value )
    );
}

/**
 * Color field option helper
 */
function mini_theme_text_field_color_option(
    string $option_group, 
    string $option, 
    string $default_value = '', 
    string $style='',
) {
    $options = get_option( $option_group );
    if ( 
        is_array($options) && array_key_exists($option, $options ) && $options[$option] != null 
    ) {
        $value = $options[$option];
        $placeholder = null;
    } else {
        $value = $options[$option];
        $placeholder = $default_value;
    }
    $color = $placeholder;
    if ( $value != '' ) {
        $color = $value;
    }
    return '
    <input
        type="text"
        id="'.$option.'"
        name="'.$option_group.'['.$option.']"
        value="'.$value.'"
        placeholder="'.$placeholder.'"
        style="border: 2px solid '.$color.'; border-right: 30px solid '.$color.';'.$style.'";
    >
    ';
}

/**
 * Select dropdown option helper
 */
function mini_theme_option_list_option(
    string $option_group, 
    string $option, 
    array $select_options, 
    string $label,
    string $style='width: 100%;',
) {
    /**
     * $options = [
     *  'Main font' => 'main-font',
     *  'Secondary font' => 'secondary-font',
     * ]
     */
    $options = get_option( $option_group );
    $stored_choice = '';
    if (
        is_array($options) && array_key_exists($option, $options) && $options[$option] != null 
    ) {
        $stored_choice = $options[$option];
    }

    $select_field = '
    <label for="'.$option.'">' . __($label, 'mini' ) . '</label>
    ';
    $select_field .= '
    <select name="'.$option_group.'['.$option.']" style="'.$style.'">
    ';
    $select_field .= '
        <option value="" selected>Default</option>
    ';
    $o = 1;
    foreach($select_options as $select_option => $value ) {
        $state = null;
        if($value == $stored_choice) {
            $state = ' selected';
        }
        $select_field .= '
        <option value="'.$value.'"'.$state.'>'.$select_option.'</option>
        ';
        $o++;
    }
    $select_field .= '
    </select>
    ';

    return $select_field;
}

/**
 * Get Google Fonts list
 */
function mini_get_google_fonts() {
    return [
        'sans' => [
            'Barlow' => 'Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900',
            'Montserrat' => 'Montserrat:ital,wght@0,100..900;1,100..900',
            'Open Sans' => 'Open+Sans:ital,wght@0,300..800;1,300..800',
            'Lato' => 'Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900',
            'Roboto' => 'Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900',
            'Poppins' => 'Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900',
            'Reddit Sans' => 'Reddit+Sans:ital,wght@0,200..900;1,200..900',
        ],
        'secondary' => [
            'Oswald' => 'Oswald:wght@200..700',
            'Bebas Neue' => 'Bebas+Neue',
            'Archivo Black' => 'Archivo+Black',
            'Raleway' => 'Raleway:ital,wght@0,100..900;1,100..900',
            'Inter' => 'Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900',
        ],
        'serif' => [
            'Crimson Pro' => 'Crimson+Pro:ital,wght@0,200..900;1,200..900',
            'Merriweather' => 'Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900',
            'Playfair Display' => 'Playfair+Display:ital,wght@0,400..900;1,400..900',
            'Lora' => 'Lora:ital,wght@0,400..700;1,400..700',
        ],
        'mono' => [
            'Courier Prime' => 'Courier+Prime:ital,wght@0,400;0,700;1,400;1,700',
            'Roboto Mono' => 'Roboto+Mono:ital,wght@0,100..700;1,100..700',
            'Source Code Pro' => 'Source+Code+Pro:ital,wght@0,200..900;1,200..900',
            'Reddit Mono' => 'Reddit+Mono:wght@200..900',
        ],
        'handwriting' => [
            'Indie Flower' => 'Indie+Flower',
            'Caveat' => 'Caveat:wght@400..700',
            'Shadows Into Light' => 'Shadows+Into+Light',
        ]
    ];
}

/**
 * Get variable from theme options
 */
if (!function_exists('get_variable')) {
    function get_variable($option_group, $option) {
        $options = get_option($option_group);
        if (is_array($options) && array_key_exists($option, $options)) {
            if ($options[$option] != '') {
                return $options[$option];
            } else {
                return false;
            }
        }
    }
}
