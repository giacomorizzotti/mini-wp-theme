<?php
/**
 * Instance-Specific Custom Functions
 * 
 * Add your custom functions, hooks, and modifications here.
 * This file is loaded automatically if it exists.
 * 
 * IMPORTANT: Remove the .example extension to activate this file.
 * Rename: custom-functions.example.php → custom-functions.php
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Example: Register a custom post type
 */
/*
function mini_instance_custom_post_type() {
    register_post_type('custom_type', array(
        'labels' => array(
            'name' => __('Custom Types', 'mini'),
            'singular_name' => __('Custom Type', 'mini'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-admin-post',
    ));
}
add_action('init', 'mini_instance_custom_post_type');
*/

/**
 * Example: Add custom menu location
 */
/*
function mini_instance_custom_menus() {
    register_nav_menus(array(
        'custom-menu' => __('Custom Instance Menu', 'mini'),
    ));
}
add_action('init', 'mini_instance_custom_menus');
*/

/**
 * Example: Modify excerpt length
 */
/*
function mini_instance_excerpt_length($length) {
    return 30; // Number of words
}
add_filter('excerpt_length', 'mini_instance_excerpt_length', 999);
*/

/**
 * Example: Add custom body classes
 */
/*
function mini_instance_body_classes($classes) {
    $classes[] = 'instance-custom';
    return $classes;
}
add_filter('body_class', 'mini_instance_body_classes');
*/

/**
 * Example: Register custom sidebar
 */
/*
function mini_instance_custom_sidebar() {
    register_sidebar(array(
        'name' => __('Instance Custom Sidebar', 'mini'),
        'id' => 'instance-sidebar',
        'description' => __('Custom sidebar for this instance', 'mini'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'mini_instance_custom_sidebar');
*/

/**
 * Example: Enqueue custom JavaScript
 */
/*
function mini_instance_custom_scripts() {
    wp_enqueue_script(
        'instance-custom-js',
        get_template_directory_uri() . '/overrides/scripts/custom.js',
        array('jquery'),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'mini_instance_custom_scripts');
*/

/**
 * Example: Modify theme support
 */
/*
function mini_instance_theme_support() {
    // Add support for wide images in Gutenberg
    add_theme_support('align-wide');
    
    // Add custom image sizes
    add_image_size('instance-custom', 800, 600, true);
}
add_action('after_setup_theme', 'mini_instance_theme_support', 11);
*/

/**
 * Example: Custom shortcode
 */
/*
function mini_instance_custom_shortcode($atts) {
    $atts = shortcode_atts(array(
        'text' => 'Default text',
    ), $atts);
    
    return '<div class="custom-shortcode">' . esc_html($atts['text']) . '</div>';
}
add_shortcode('custom', 'mini_instance_custom_shortcode');
*/
