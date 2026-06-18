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
    wp_enqueue_style( 'mini-style', get_stylesheet_uri(), array(), MINI_VERSION );
    wp_style_add_data( 'mini-style', 'rtl', 'replace' );

    wp_enqueue_script( 'mini-navigation', get_template_directory_uri() . '/js/navigation.js', array(), MINI_VERSION, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'mini_scripts' );

/**
 * Enqueue styles for admin area
 */
function mini_admin_styles() {
    wp_enqueue_style( 'mini-admin-style', get_stylesheet_uri(), array(), MINI_VERSION );
}
add_action( 'admin_enqueue_scripts', 'mini_admin_styles' );

/**
 * Enqueue styles for login page
 */
function mini_login_styles() {
    // Load parent theme styles
    wp_enqueue_style( 'mini-login-style', get_template_directory_uri() . '/style.css', array(), MINI_VERSION );
    
    // Load child theme styles if active
    if ( get_stylesheet_directory_uri() !== get_template_directory_uri() ) {
        wp_enqueue_style( 'mini-child-login-style', get_stylesheet_uri(), array('mini-login-style'), MINI_VERSION );
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
            $mini_CSS = esc_url( $options['css_cdn_url'] );
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
    wp_enqueue_style( 'mini_header_css', $mini_CSS, array(), MINI_VERSION);
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
            $mini_JS = esc_url( $options['js_cdn_url'] );
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
    wp_enqueue_script( 'mini_footer_js', $mini_JS, array(), MINI_VERSION, true);
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
                $mini_slider_JS = esc_url( $cdn_options['slider_cdn_url'] );
            } else {
                // Use parent theme path if child theme is active, otherwise use current theme
                if (is_child_theme()) {
                    $mini_slider_JS = get_template_directory_uri() . '/js/slider.js';
                } else {
                    $mini_slider_JS = get_stylesheet_directory_uri() . '/js/slider.js';
                }
            }
        }
        wp_enqueue_script( 'mini_slider_footer_js', $mini_slider_JS, array(), MINI_VERSION, true);
    }
}

/**
 * Build the Google Fonts URL and CSS variable block from saved options.
 * Returns [ 'url' => string, 'css_vars' => string ].
 */
function mini_compute_font_data() {
    $options    = get_option( 'mini_font_options' );
    $fonts_data = mini_get_google_fonts();

    $fonts_to_load = [];

    $sans_font = isset( $options['mini_sans_font'] ) && ! empty( $options['mini_sans_font'] )
        ? $options['mini_sans_font'] : 'Barlow';
    if ( isset( $fonts_data['sans'][ $sans_font ] ) ) {
        $fonts_to_load[] = $fonts_data['sans'][ $sans_font ];
    }

    $secondary_font = isset( $options['mini_secondary_font'] ) && ! empty( $options['mini_secondary_font'] )
        ? $options['mini_secondary_font'] : 'Oswald';
    if ( isset( $fonts_data['secondary'][ $secondary_font ] ) ) {
        $fonts_to_load[] = $fonts_data['secondary'][ $secondary_font ];
    }

    $serif_font = $mono_font = $handwriting_font = null;

    if ( ! empty( $options['mini_serif_font_status'] ) ) {
        $serif_font = isset( $options['mini_serif_font'] ) && ! empty( $options['mini_serif_font'] )
            ? $options['mini_serif_font'] : 'Crimson Pro';
        if ( isset( $fonts_data['serif'][ $serif_font ] ) ) {
            $fonts_to_load[] = $fonts_data['serif'][ $serif_font ];
        }
    }

    if ( ! empty( $options['mini_mono_font_status'] ) ) {
        $mono_font = isset( $options['mini_mono_font'] ) && ! empty( $options['mini_mono_font'] )
            ? $options['mini_mono_font'] : 'Courier Prime';
        if ( isset( $fonts_data['mono'][ $mono_font ] ) ) {
            $fonts_to_load[] = $fonts_data['mono'][ $mono_font ];
        }
    }

    if ( ! empty( $options['mini_handwriting_font_status'] ) ) {
        $handwriting_font = isset( $options['mini_handwriting_font'] ) && ! empty( $options['mini_handwriting_font'] )
            ? $options['mini_handwriting_font'] : 'Indie Flower';
        if ( isset( $fonts_data['handwriting'][ $handwriting_font ] ) ) {
            $fonts_to_load[] = $fonts_data['handwriting'][ $handwriting_font ];
        }
    }

    $fonts_url = '';
    if ( ! empty( $fonts_to_load ) ) {
        $fonts_to_load = array_unique( $fonts_to_load );
        $fonts_query   = implode( '&family=', $fonts_to_load );
        $fonts_url     = 'https://fonts.googleapis.com/css2?family=' . $fonts_query . '&display=swap';
    }

    $allowed_font_vars  = [ '--font-sans', '--font-second', '--font-serif', '--font-mono', '--font-handwriting' ];
    $title_font_var     = isset( $options['mini_title_font'] ) && in_array( $options['mini_title_font'], $allowed_font_vars, true )
        ? $options['mini_title_font'] : '--font-second';
    $most_used_font_var = isset( $options['mini_most_used_font'] ) && in_array( $options['mini_most_used_font'], $allowed_font_vars, true )
        ? $options['mini_most_used_font'] : '--font-sans';

    $css = ':root {';
    if ( isset( $fonts_data['sans'][ $sans_font ] ) ) {
        $css .= '--font-sans:"' . $sans_font . '", sans-serif;';
        $css .= '--sans-font:"' . $sans_font . '", sans-serif;';
    }
    if ( isset( $fonts_data['secondary'][ $secondary_font ] ) ) {
        $css .= '--font-second:"' . $secondary_font . '", sans-serif;';
        $css .= '--secondary-font:"' . $secondary_font . '", sans-serif;';
    }
    if ( $serif_font && isset( $fonts_data['serif'][ $serif_font ] ) ) {
        $css .= '--font-serif:"' . $serif_font . '", serif;';
        $css .= '--serif-font:"' . $serif_font . '", serif;';
    }
    if ( $mono_font && isset( $fonts_data['mono'][ $mono_font ] ) ) {
        $css .= '--font-mono:"' . $mono_font . '", monospace;';
        $css .= '--mono-font:"' . $mono_font . '", monospace;';
    }
    if ( $handwriting_font && isset( $fonts_data['handwriting'][ $handwriting_font ] ) ) {
        $css .= '--font-handwriting:"' . $handwriting_font . '", cursive;';
        $css .= '--handwriting-font:"' . $handwriting_font . '", cursive;';
    }
    $css .= '--title-font:var(' . $title_font_var . ');';
    $css .= '--font-main:var(' . $most_used_font_var . ');';
    $css .= '--text-font:var(' . $most_used_font_var . ');';
    $css .= '--font:var(' . $most_used_font_var . ');';
    $css .= '}';

    return [ 'url' => $fonts_url, 'css_vars' => $css ];
}

/**
 * Enqueue Google Web Fonts on the frontend.
 */
add_action( 'wp_enqueue_scripts', 'mini_gwf_font' );
function mini_gwf_font() {
    $font_data = mini_compute_font_data();
    if ( $font_data['url'] ) {
        wp_enqueue_style( 'mini-google-fonts', $font_data['url'], [], null );
    }
    wp_add_inline_style( 'mini-google-fonts', $font_data['css_vars'] );
}

/**
 * Load fonts inside the block editor iframe.
 * enqueue_block_editor_assets targets the outer admin page only;
 * add_editor_style + block_editor_settings_all reach the editor content iframe.
 */
add_action( 'init', 'mini_gwf_font_editor' );
function mini_gwf_font_editor() {
    if ( ! is_admin() ) {
        return;
    }
    $font_data = mini_compute_font_data();
    if ( $font_data['url'] ) {
        add_editor_style( $font_data['url'] );
    }
    add_filter( 'block_editor_settings_all', function ( $settings ) use ( $font_data ) {
        $settings['styles'][] = [ 'css' => $font_data['css_vars'] ];
        return $settings;
    } );
}

/**
 * Register mini Gutenberg blocks (only those enabled in mini > Blocks)
 */
add_action( 'init', 'mini_register_blocks' );
function mini_register_blocks() {
    $opts      = get_option( 'mini_blocks_settings', [] );
    $blocks_dir = get_template_directory() . '/blocks/';

    $block_map = [
        // Layout
        'mini_section'   => 'section',
        'mini_container' => 'container',
        'mini_boxes'     => 'boxes',
        'mini_box'       => 'box',
        // Content
        'mini_posts'     => 'posts',
        'mini_news'      => 'news',
        'mini_events'    => 'events',
        'mini_courses'   => 'courses',
        'mini_matches'   => 'matches',
        // UI
        'mini_button'    => 'button',
        'mini_image'     => 'image',
        // Utilities
        'mini_sep'       => 'sep',
        'mini_space'     => 'space',
    ];

    foreach ( $block_map as $option_key => $dir ) {
        if ( ! empty( $opts[ $option_key ] ) ) {
            register_block_type( $blocks_dir . $dir );
        }
    }
}

/**
 * Enqueue AOS library on the frontend when enabled.
 */
add_action( 'wp_enqueue_scripts', 'mini_enqueue_aos' );
function mini_enqueue_aos() {
    if ( ! mini_check_option( 'mini_ext_lib_options', 'mini_aos' ) ) {
        return;
    }
    wp_enqueue_style(
        'aos-css',
        'https://unpkg.com/aos@2.3.1/dist/aos.css',
        [],
        null
    );
    wp_enqueue_script(
        'aos-js',
        'https://unpkg.com/aos@2.3.1/dist/aos.js',
        [],
        null,
        true
    );
    wp_add_inline_script( 'aos-js', 'AOS.init();' );
}

/**
 * Inject miniBlocksData into the block editor so editor.js scripts can read PHP settings.
 */
add_action( 'enqueue_block_editor_assets', 'mini_inject_block_editor_data' );
function mini_inject_block_editor_data() {
    $aos_enabled = function_exists( 'mini_check_option' ) && mini_check_option( 'mini_ext_lib_options', 'mini_aos' );
    wp_add_inline_script(
        'wp-blocks',
        'window.miniBlocksData = window.miniBlocksData || {}; window.miniBlocksData.aosEnabled = ' . ( $aos_enabled ? 'true' : 'false' ) . ';',
        'before'
    );
}
