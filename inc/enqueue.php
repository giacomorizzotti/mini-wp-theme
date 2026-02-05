<?php
/**
 * Enqueue Scripts and Styles
 *
 * All functions for loading CSS, JavaScript, and fonts
 *
 * @package mini
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue scripts and styles for frontend
 */
function mini_scripts() {
    wp_enqueue_style( 'mini-style', get_stylesheet_uri(), array(), _S_VERSION );
    wp_style_add_data( 'mini-style', 'rtl', 'replace' );

    wp_enqueue_script( 'mini-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'mini_scripts' );

/**
 * Enqueue styles for admin area
 */
function mini_admin_styles() {
    wp_enqueue_style( 'mini-admin-style', get_stylesheet_uri(), array(), _S_VERSION );
}
add_action( 'admin_enqueue_scripts', 'mini_admin_styles' );

/**
 * Enqueue styles for login page
 */
function mini_login_styles() {
    // Load parent theme styles
    wp_enqueue_style( 'mini-login-style', get_template_directory_uri() . '/style.css', array(), _S_VERSION );
    
    // Load child theme styles if active
    if ( get_stylesheet_directory_uri() !== get_template_directory_uri() ) {
        wp_enqueue_style( 'mini-child-login-style', get_stylesheet_uri(), array('mini-login-style'), _S_VERSION );
    }
}
add_action( 'login_enqueue_scripts', 'mini_login_styles' );

/**
 * Enqueue mini CSS from CDN or local
 */
add_action( 'wp_enqueue_scripts', 'mini_css' );
function mini_css(){
    $options = get_option( 'mini_cdn_options' );
    if (is_array($options) && array_key_exists('cdn', $options) && $options['cdn'] != null) {
        if (is_array($options) && array_key_exists('cdn_dev', $options) && $options['cdn_dev'] != null) {
            $mini_CSS = 'https://serversaur.doingthings.space/mini/css/mini.min.css';
        } else {
            $version = isset($options['cdn_version']) ? $options['cdn_version'] : 'main';
            $mini_CSS = 'https://cdn.jsdelivr.net/gh/giacomorizzotti/mini@' . $version . '/css/mini.min.css';
        }
    } else {
        if (is_array($options) && array_key_exists('css_cdn_url', $options) && $options['css_cdn_url'] != null) {
            $mini_CSS = $options['css_cdn_url'];
        } else {
            // Check if mini.min.css exists in child theme, otherwise use parent theme
            $child_css = get_stylesheet_directory() . '/css/mini.min.css';
            if (is_child_theme() && !file_exists($child_css)) {
                $mini_CSS = get_template_directory_uri() . '/css/mini.min.css';
            } else {
                $mini_CSS = get_stylesheet_directory_uri() . '/css/mini.min.css';
            }
        }
    }
    wp_enqueue_style( 'mini_header_css', $mini_CSS, array(), _S_VERSION);
}

/**
 * Enqueue mini JavaScript from CDN or local
 */
add_action( 'wp_enqueue_scripts', 'mini_js' );
function mini_js(){
    $options = get_option( 'mini_cdn_options' );
    if (is_array($options) && array_key_exists('cdn', $options) && $options['cdn'] != null) {
        if (is_array($options) && array_key_exists('cdn_dev', $options) && $options['cdn_dev'] != null) {
            $mini_JS = 'https://serversaur.doingthings.space/mini/js/mini.js';
        } else {
            $version = isset($options['cdn_version']) ? $options['cdn_version'] : 'main';
            $mini_JS = 'https://cdn.jsdelivr.net/gh/giacomorizzotti/mini@' . $version . '/js/mini.js';
        }
    } else {
        if (is_array($options) && array_key_exists('js_cdn_url', $options) && $options['js_cdn_url'] != null) {
            $mini_JS = $options['js_cdn_url'];
        } else {
            // Check if mini.js exists in child theme, otherwise use parent theme
            $child_js = get_stylesheet_directory() . '/js/mini.js';
            if (is_child_theme() && !file_exists($child_js)) {
                $mini_JS = get_template_directory_uri() . '/js/mini.js';
            } else {
                $mini_JS = get_stylesheet_directory_uri() . '/js/mini.js';
            }
        }
    }
    wp_enqueue_script( 'mini_footer_js', $mini_JS, array(), _S_VERSION, true);
}

/**
 * Enqueue slider JavaScript
 */
add_action( 'wp_enqueue_scripts', 'mini_slider' );
function mini_slider(){
    $cdn_options = get_option( 'mini_cdn_options' );
    // Load slider only if 'slide' post type is registered (enabled in mini plugin)
    if ( post_type_exists( 'slide' ) ) {
        if (is_array($cdn_options) && array_key_exists('cdn', $cdn_options) && $cdn_options['cdn'] != null) {
            if (is_array($cdn_options) && array_key_exists('cdn_dev', $cdn_options) && $cdn_options['cdn_dev'] != null) {
                $mini_slider_JS = 'https://serversaur.doingthings.space/mini/js/slider.js';
            } else {
                $version = isset($cdn_options['cdn_version']) ? $cdn_options['cdn_version'] : 'main';
                $mini_slider_JS = 'https://cdn.jsdelivr.net/gh/giacomorizzotti/mini@' . $version . '/js/slider.js';
            }
        } else {
            if (is_array($cdn_options) && array_key_exists('slider_cdn_url', $cdn_options) && $cdn_options['slider_cdn_url'] != null) {
                $mini_slider_JS = $cdn_options['slider_cdn_url'];
            } else {
                // Use parent theme path if child theme is active, otherwise use current theme
                if (is_child_theme()) {
                    $mini_slider_JS = get_template_directory_uri() . '/js/slider.js';
                } else {
                    $mini_slider_JS = get_stylesheet_directory_uri() . '/js/slider.js';
                }
            }
        }
        wp_enqueue_script( 'mini_slider_footer_js', $mini_slider_JS, array(), _S_VERSION, true);
    }
}

/**
 * Enqueue Google Web Fonts
 */
add_action( 'wp_enqueue_scripts', 'mini_gwf_font' );
function mini_gwf_font(){
    $options = get_option('mini_font_options');
    $fonts_data = mini_get_google_fonts();
    $fonts_to_load = [];
    
    // Sans Serif (always enabled)
    $sans_font = isset($options['mini_sans_font']) && !empty($options['mini_sans_font']) 
        ? $options['mini_sans_font'] : 'Barlow';
    if (isset($fonts_data['sans'][$sans_font])) {
        $fonts_to_load[] = $fonts_data['sans'][$sans_font];
    }
    
    // Secondary (always enabled)
    $secondary_font = isset($options['mini_secondary_font']) && !empty($options['mini_secondary_font']) 
        ? $options['mini_secondary_font'] : 'Oswald';
    if (isset($fonts_data['secondary'][$secondary_font])) {
        $fonts_to_load[] = $fonts_data['secondary'][$secondary_font];
    }
    
    // Initialize optional font variables
    $serif_font = null;
    $mono_font = null;
    $handwriting_font = null;
    
    // Serif (optional)
    if (isset($options['mini_serif_font_status']) && $options['mini_serif_font_status']) {
        $serif_font = isset($options['mini_serif_font']) && !empty($options['mini_serif_font']) 
            ? $options['mini_serif_font'] : 'Crimson Pro';
        if (isset($fonts_data['serif'][$serif_font])) {
            $fonts_to_load[] = $fonts_data['serif'][$serif_font];
        }
    }
    
    // Mono (optional)
    if (isset($options['mini_mono_font_status']) && $options['mini_mono_font_status']) {
        $mono_font = isset($options['mini_mono_font']) && !empty($options['mini_mono_font']) 
            ? $options['mini_mono_font'] : 'Courier Prime';
        if (isset($fonts_data['mono'][$mono_font])) {
            $fonts_to_load[] = $fonts_data['mono'][$mono_font];
        }
    }
    
    // Handwriting (optional)
    if (isset($options['mini_handwriting_font_status']) && $options['mini_handwriting_font_status']) {
        $handwriting_font = isset($options['mini_handwriting_font']) && !empty($options['mini_handwriting_font']) 
            ? $options['mini_handwriting_font'] : 'Indie Flower';
        if (isset($fonts_data['handwriting'][$handwriting_font])) {
            $fonts_to_load[] = $fonts_data['handwriting'][$handwriting_font];
        }
    }
    
    // Build Google Fonts URL
    if (!empty($fonts_to_load)) {
        // Remove duplicates to avoid loading the same font twice
        $fonts_to_load = array_unique($fonts_to_load);
        $fonts_query = implode('&family=', $fonts_to_load);
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . $fonts_query . '&display=swap';
        
        wp_enqueue_style(
            'mini-google-fonts',
            $fonts_url,
            array(),
            null
        );
    }
    
    // Add inline CSS for font variables
    $css_vars = ':root {';
    
    if (isset($fonts_data['sans'][$sans_font])) {
        $css_vars .= '--font-sans:"' . $sans_font . '", sans-serif;';
        $css_vars .= '--sans-font:"' . $sans_font . '", sans-serif;'; // Legacy support
    }
    
    if (isset($fonts_data['secondary'][$secondary_font])) {
        $css_vars .= '--font-second:"' . $secondary_font . '", sans-serif;';
        $css_vars .= '--secondary-font:"' . $secondary_font . '", sans-serif;'; // Legacy support
    }
    
    if ($serif_font && isset($fonts_data['serif'][$serif_font])) {
        $css_vars .= '--font-serif:"' . $serif_font . '", serif;';
        $css_vars .= '--serif-font:"' . $serif_font . '", serif;'; // Legacy support
    }
    
    if ($mono_font && isset($fonts_data['mono'][$mono_font])) {
        $css_vars .= '--font-mono:"' . $mono_font . '", monospace;';
        $css_vars .= '--mono-font:"' . $mono_font . '", monospace;'; // Legacy support
    }
    
    if ($handwriting_font && isset($fonts_data['handwriting'][$handwriting_font])) {
        $css_vars .= '--font-handwriting:"' . $handwriting_font . '", cursive;';
        $css_vars .= '--handwriting-font:"' . $handwriting_font . '", cursive;'; // Legacy support
    }
    
    // Get user's font usage preferences
    $title_font_var = isset($options['mini_title_font']) && !empty($options['mini_title_font']) 
        ? $options['mini_title_font'] : '--font-second';
    $most_used_font_var = isset($options['mini_most_used_font']) && !empty($options['mini_most_used_font']) 
        ? $options['mini_most_used_font'] : '--font-sans';
    
    // Apply font usage preferences
    $css_vars .= '--title-font:var(' . $title_font_var . ');';
    $css_vars .= '--font-main:var(' . $most_used_font_var . ');';
    $css_vars .= '--text-font:var(' . $most_used_font_var . ');';
    $css_vars .= '--font:var(' . $most_used_font_var . ');';
    
    $css_vars .= '}';
    
    wp_add_inline_style('mini-google-fonts', $css_vars);
}
