<?php
/**
 * Admin Customization
 *
 * Functions to customize the WordPress admin area
 *
 * @package mini
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * mini favicon - fallback if plugin not active
 */
function mini_theme_favicon() {
    // Only run if plugin function doesn't exist (plugin not active)
    if (function_exists('mini_plugin_favicon')) {
        return;
    }
    
    $favicon_path = get_template_directory() . '/img/favicon.ico';
    if (file_exists($favicon_path)) {
        $favicon_url = get_template_directory_uri() . '/img/favicon.ico';
        echo "<link rel='shortcut icon' href='" . esc_url($favicon_url) . "' />\n";
    }
}
add_action('admin_head', 'mini_theme_favicon');
add_action('login_head', 'mini_theme_favicon');

/**
 * mini logo image class
 */
add_filter( 'get_custom_logo', 'change_logo_class' );
function change_logo_class( $html ) {
    $html = str_replace( 'custom-logo', 'logo', $html );
    $html = str_replace( 'custom-logo-link', 'logo-link', $html );
    return $html;
}

/**
 * mini login link
 */
function mini_login_url( $url ) {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'mini_login_url', 10, 1 );

/**
 * mini admin bar image class
 */
function dashboard_logo() {
    echo '
    <style type="text/css">
        #wpadminbar #wp-admin-bar-wp-logo>.ab-item {
            padding: 0 7px;
            background-image: url('.get_stylesheet_directory_uri().'/img/mini_emblem_2.svg) !important;
            background-size: 50%;
            background-position: center;
            background-repeat: no-repeat;
        }
        #wpadminbar #wp-admin-bar-wp-logo>.ab-item {
        }
        #wpadminbar #wp-admin-bar-wp-logo>.ab-item .ab-icon:before {
            content: " ";
            top: 2px;
        }
    </style>
    ';
}
add_action('wp_before_admin_bar_render', 'dashboard_logo');

/**
 * Fix SVG display in media library
 */
function fix_svg() {
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );
