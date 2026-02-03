<?php
/**
 * Shortcodes
 *
 * All custom shortcode functions for the theme
 *
 * @package mini
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Company name shortcode
 */
function get_company_name() {
    if ( get_variable('mini_company_options', 'mini_company_name') != false ) {
        return get_variable('mini_company_options', 'mini_company_name');
    } else {
        return false;
    }
}
add_shortcode('get_company_name', 'get_company_name');

/**
 * Company address line 1 shortcode
 */
function get_company_address_line_1() {
    if ( 
        get_variable('mini_company_options', 'mini_company_address') != false &&
        get_variable('mini_company_options', 'mini_company_house_number')
    ) {
        return get_variable('mini_company_options', 'mini_company_address').' '.get_variable('mini_company_options', 'mini_company_house_number');
    } else {
        return false;
    }
}
add_shortcode('get_company_address_line_1', 'get_company_address_line_1');

/**
 * Company address line 2 shortcode
 */
function get_company_address_line_2() {
    if ( 
        get_variable('mini_company_options', 'mini_company_city') != false &&
        get_variable('mini_company_options', 'mini_company_province') != false &&
        get_variable('mini_company_options', 'mini_company_country') &&
        get_variable('mini_company_options', 'mini_company_city_code')
    ) {
        return get_variable('mini_company_options', 'mini_company_city_code').', '.get_variable('mini_company_options', 'mini_company_city').' ['.get_variable('mini_company_options', 'mini_company_province').'], '.get_variable('mini_company_options', 'mini_company_country');
    } else {
        return false;
    }
}
add_shortcode('get_company_address_line_2', 'get_company_address_line_2');

/**
 * Company email shortcode
 */
function get_company_email() {
    if ( get_variable('mini_company_options', 'mini_company_email') != false ) {
        return get_variable('mini_company_options', 'mini_company_email');
    } else {
        return false;
    }
}
add_shortcode('get_company_email', 'get_company_email');

/**
 * Company phone shortcode
 */
function get_company_phone() {
    if ( get_variable('mini_company_options', 'mini_company_phone') != false ) {
        return get_variable('mini_company_options', 'mini_company_phone');
    } else {
        return false;
    }
}
add_shortcode('get_company_phone', 'get_company_phone');

/**
 * Company PEC shortcode
 */
function get_company_pec() {
    if ( get_variable('mini_company_options', 'mini_company_pec') != false ) {
        return get_variable('mini_company_options', 'mini_company_pec');
    } else {
        if ( get_variable('mini_company_options', 'mini_company_email') != false ) {
            return get_variable('mini_company_options', 'mini_company_email');
        } else {
            return false;
        }
    }
}
add_shortcode('get_company_pec', 'get_company_pec');

/**
 * Company service email shortcode
 */
function get_company_service_email() {
    if ( get_variable('mini_company_options', 'mini_company_service_email') != false ) {
        return get_variable('mini_company_options', 'mini_company_service_email');
    } else {
        return false;
    }
}
add_shortcode('get_company_service_email', 'get_company_service_email');

/**
 * Company service phone shortcode
 */
function get_company_service_phone() {
    if ( get_variable('mini_company_options', 'mini_company_service_phone') != false ) {
        return get_variable('mini_company_options', 'mini_company_service_phone');
    } else {
        return false;
    }
}
add_shortcode('get_company_service_phone', 'get_company_service_phone');

/**
 * Company tax number shortcode
 */
function get_company_tax_number() {
    if ( get_variable('mini_company_options', 'mini_company_tax_number') != false ) {
        return get_variable('mini_company_options', 'mini_company_tax_number');
    } else {
        return false;
    }
}
add_shortcode('get_company_tax_number', 'get_company_tax_number');

/**
 * Company ID code shortcode
 */
function get_company_id_code() {
    if ( get_variable('mini_company_options', 'mini_company_id_code') != false ) {
        return get_variable('mini_company_options', 'mini_company_id_code');
    } else {
        return false;
    }
}
add_shortcode('get_company_id_code', 'get_company_id_code');

/**
 * Social networks helper function
 */
function get_enabled_social_networks() {
    $socials = [
        'instagram' => ['icon' => 'iconoir-instagram', 'name' => 'Instagram'],
        'facebook' => ['icon' => 'iconoir-facebook', 'name' => 'Facebook'],
        'x' => ['icon' => 'iconoir-x', 'name' => 'X'],
        'linkedin' => ['icon' => 'iconoir-linkedin', 'name' => 'LinkedIn'],
        'youtube' => ['icon' => 'iconoir-youtube', 'name' => 'YouTube'],
        'tiktok' => ['icon' => 'iconoir-tiktok', 'name' => 'TikTok'],
        'threads' => ['icon' => 'iconoir-threads', 'name' => 'Threads'],
    ];
    
    $enabled = [];
    foreach ($socials as $key => $data) {
        $enabled_key = 'mini_company_' . $key . '_enabled';
        $url_key = 'mini_company_' . $key;
        
        if (get_variable('mini_company_options', $enabled_key) && 
            get_variable('mini_company_options', $url_key)) {
            $enabled[$key] = [
                'url' => get_variable('mini_company_options', $url_key),
                'icon' => $data['icon'],
                'name' => $data['name']
            ];
        }
    }
    
    return $enabled;
}

/**
 * Messaging apps helper function
 */
function get_enabled_messaging_apps() {
    $messaging = [
        'whatsapp' => ['icon' => 'iconoir-whatsapp', 'name' => 'WhatsApp'],
        'telegram' => ['icon' => 'iconoir-telegram', 'name' => 'Telegram'],
    ];
    
    $enabled = [];
    foreach ($messaging as $key => $data) {
        $enabled_key = 'mini_company_' . $key . '_enabled';
        $number_key = 'mini_company_' . $key;
        
        if (get_variable('mini_company_options', $enabled_key) && 
            get_variable('mini_company_options', $number_key)) {
            $enabled[$key] = [
                'number' => get_variable('mini_company_options', $number_key),
                'icon' => $data['icon'],
                'name' => $data['name']
            ];
        }
    }
    
    return $enabled;
}
