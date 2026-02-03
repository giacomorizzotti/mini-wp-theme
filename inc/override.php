<?php
/**
 * Template Override System
 *
 * System for instance-specific template customization
 * without modifying core theme files
 *
 * @package mini
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Load instance-specific template file if it exists
 * 
 * @param string $template The template path
 * @return string Modified template path
 */
function mini_load_override_template( $template ) {
    static $override_dir = null;
    
    // Cache the override directory path
    if ( $override_dir === null ) {
        $override_dir = get_template_directory() . '/overrides/templates/';
    }
    
    $template_name = basename( $template );
    $override_path = $override_dir . $template_name;
    
    // Check if override exists
    if ( file_exists( $override_path ) ) {
        return $override_path;
    }
    
    return $template;
}
add_filter( 'template_include', 'mini_load_override_template', 99 );

/**
 * Load instance-specific template parts
 * 
 * @param string $slug The slug name for the generic template
 * @param string $name The name of the specialised template
 */
function mini_get_template_part_override( $slug, $name = null ) {
    static $override_dir = null;
    
    // Cache the override directory path
    if ( $override_dir === null ) {
        $override_dir = get_template_directory() . '/overrides/';
    }
    
    // Build template file names
    $templates = array();
    if ( $name ) {
        $templates[] = "{$slug}-{$name}.php";
    }
    $templates[] = "{$slug}.php";
    
    // Check in overrides/parts first
    foreach ( $templates as $template_name ) {
        $override_path = $override_dir . 'parts/' . $template_name;
        if ( file_exists( $override_path ) ) {
            load_template( $override_path, false );
            return;
        }
    }
    
    // Check in overrides/patterns
    foreach ( $templates as $template_name ) {
        $override_path = $override_dir . 'patterns/' . $template_name;
        if ( file_exists( $override_path ) ) {
            load_template( $override_path, false );
            return;
        }
    }
    
    // Fall back to default get_template_part
    get_template_part( $slug, $name );
}

/**
 * Load instance-specific custom functions
 * Loaded early to allow overrides to hook into WordPress
 */
function mini_load_custom_functions() {
    $custom_functions = get_template_directory() . '/overrides/custom-functions.php';
    if ( file_exists( $custom_functions ) ) {
        require_once $custom_functions;
    }
}
add_action( 'after_setup_theme', 'mini_load_custom_functions', 5 );

/**
 * Enqueue instance-specific custom styles
 */
function mini_enqueue_override_styles() {
    static $custom_css_checked = false;
    static $custom_css_exists = false;
    static $custom_css_path = null;
    
    // Check only once per request
    if ( ! $custom_css_checked ) {
        $custom_css_path = get_template_directory() . '/overrides/styles/custom.css';
        $custom_css_exists = file_exists( $custom_css_path );
        $custom_css_checked = true;
    }
    
    if ( $custom_css_exists ) {
        wp_enqueue_style( 
            'mini-custom-overrides', 
            get_template_directory_uri() . '/overrides/styles/custom.css', 
            array( 'mini-style' ), 
            filemtime( $custom_css_path ) 
        );
    }
}
add_action( 'wp_enqueue_scripts', 'mini_enqueue_override_styles', 99 );

/**
 * Helper function to check if an override exists
 * 
 * @param string $type Type of override (template, part, pattern, style, function)
 * @param string $file Filename to check
 * @return bool
 */
function mini_has_override( $type, $file ) {
    static $override_dir = null;
    static $cache = array();
    
    // Cache the override directory path
    if ( $override_dir === null ) {
        $override_dir = get_template_directory() . '/overrides/';
    }
    
    // Create cache key
    $cache_key = $type . '_' . $file;
    
    // Return cached result if available
    if ( isset( $cache[ $cache_key ] ) ) {
        return $cache[ $cache_key ];
    }
    
    // Check file existence based on type
    $exists = false;
    switch ( $type ) {
        case 'template':
            $exists = file_exists( $override_dir . 'templates/' . $file );
            break;
        case 'part':
            $exists = file_exists( $override_dir . 'parts/' . $file );
            break;
        case 'pattern':
            $exists = file_exists( $override_dir . 'patterns/' . $file );
            break;
        case 'style':
            $exists = file_exists( $override_dir . 'styles/' . $file );
            break;
        case 'function':
            $exists = file_exists( $override_dir . $file );
            break;
    }
    
    // Cache the result
    $cache[ $cache_key ] = $exists;
    
    return $exists;
}
