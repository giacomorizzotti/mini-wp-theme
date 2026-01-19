<?php
/**
 * Mini Child Theme Functions
 * 
 * @package Mini_Child
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue parent and child theme styles
 */
function mini_child_enqueue_styles() {
    // Enqueue parent theme stylesheet
    wp_enqueue_style(
        'mini-parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme()->parent()->get('Version')
    );
    
    // Enqueue child theme stylesheet
    wp_enqueue_style(
        'mini-child-style',
        get_stylesheet_uri(),
        array('mini-parent-style'),
        wp_get_theme()->get('Version')
    );
    
    // Enqueue custom child theme CSS if exists
    if (file_exists(get_stylesheet_directory() . '/assets/css/custom.css')) {
        wp_enqueue_style(
            'mini-child-custom-style',
            get_stylesheet_directory_uri() . '/assets/css/custom.css',
            array('mini-child-style'),
            filemtime(get_stylesheet_directory() . '/assets/css/custom.css')
        );
    }
    
    // Enqueue custom child theme JavaScript if exists
    if (file_exists(get_stylesheet_directory() . '/assets/js/custom.js')) {
        wp_enqueue_script(
            'mini-child-custom-js',
            get_stylesheet_directory_uri() . '/assets/js/custom.js',
            array('jquery'),
            filemtime(get_stylesheet_directory() . '/assets/js/custom.js'),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'mini_child_enqueue_styles', 20);

/**
 * ========================================================================
 * CUSTOM FUNCTIONALITY
 * Add your custom functions below
 * ========================================================================
 */

/**
 * Example: Register custom post type
 */
/*
function mini_child_custom_post_type() {
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => __('Portfolio', 'mini-child'),
            'singular_name' => __('Portfolio Item', 'mini-child'),
            'add_new' => __('Add New', 'mini-child'),
            'add_new_item' => __('Add New Portfolio Item', 'mini-child'),
            'edit_item' => __('Edit Portfolio Item', 'mini-child'),
            'view_item' => __('View Portfolio Item', 'mini-child'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-portfolio',
        'rewrite' => array('slug' => 'portfolio'),
    ));
}
add_action('init', 'mini_child_custom_post_type');
*/

/**
 * Example: Register custom menu location
 */
/*
function mini_child_register_menus() {
    register_nav_menus(array(
        'child-menu' => __('Child Theme Menu', 'mini-child'),
    ));
}
add_action('init', 'mini_child_register_menus');
*/

/**
 * Example: Add custom image sizes
 */
/*
function mini_child_image_sizes() {
    add_image_size('child-thumbnail', 300, 300, true);
    add_image_size('child-medium', 600, 400, true);
    add_image_size('child-large', 1200, 800, true);
}
add_action('after_setup_theme', 'mini_child_image_sizes');
*/

/**
 * Example: Modify excerpt length
 */
/*
function mini_child_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'mini_child_excerpt_length', 999);
*/

/**
 * Example: Add custom excerpt more text
 */
/*
function mini_child_excerpt_more($more) {
    return '... <a class="read-more" href="' . get_permalink() . '">' . __('Continue Reading', 'mini-child') . '</a>';
}
add_filter('excerpt_more', 'mini_child_excerpt_more');
*/

/**
 * Example: Add custom body classes
 */
/*
function mini_child_body_classes($classes) {
    // Add instance-specific class
    $classes[] = 'mini-child-instance';
    
    // Add conditional classes
    if (is_singular('portfolio')) {
        $classes[] = 'portfolio-single';
    }
    
    return $classes;
}
add_filter('body_class', 'mini_child_body_classes');
*/

/**
 * Example: Register custom sidebar
 */
/*
function mini_child_widgets_init() {
    register_sidebar(array(
        'name' => __('Child Theme Sidebar', 'mini-child'),
        'id' => 'child-sidebar',
        'description' => __('Sidebar for child theme', 'mini-child'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'mini_child_widgets_init');
*/

/**
 * Example: Add theme support features
 */
/*
function mini_child_theme_support() {
    // Add support for editor color palette
    add_theme_support('editor-color-palette', array(
        array(
            'name' => __('Primary', 'mini-child'),
            'slug' => 'primary',
            'color' => '#3498db',
        ),
        array(
            'name' => __('Secondary', 'mini-child'),
            'slug' => 'secondary',
            'color' => '#2ecc71',
        ),
    ));
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add support for wide alignment
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'mini_child_theme_support', 11);
*/

/**
 * Example: Custom shortcode
 */
/*
function mini_child_button_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'url' => '#',
        'style' => 'primary',
        'size' => 'medium',
    ), $atts);
    
    $classes = 'btn btn-' . esc_attr($atts['style']) . ' btn-' . esc_attr($atts['size']);
    
    return '<a href="' . esc_url($atts['url']) . '" class="' . $classes . '">' . 
           esc_html($content) . '</a>';
}
add_shortcode('child_button', 'mini_child_button_shortcode');
*/

/**
 * Example: Modify WP Query
 */
/*
function mini_child_modify_query($query) {
    if (!is_admin() && $query->is_main_query() && is_home()) {
        // Show 12 posts per page on homepage
        $query->set('posts_per_page', 12);
    }
}
add_action('pre_get_posts', 'mini_child_modify_query');
*/

/**
 * Example: Add custom meta box
 */
/*
function mini_child_add_meta_boxes() {
    add_meta_box(
        'mini_child_custom_meta',
        __('Custom Information', 'mini-child'),
        'mini_child_custom_meta_callback',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'mini_child_add_meta_boxes');

function mini_child_custom_meta_callback($post) {
    wp_nonce_field('mini_child_save_meta', 'mini_child_meta_nonce');
    $value = get_post_meta($post->ID, '_mini_child_custom_field', true);
    echo '<label for="mini_child_custom_field">' . __('Custom Field:', 'mini-child') . '</label>';
    echo '<input type="text" id="mini_child_custom_field" name="mini_child_custom_field" value="' . esc_attr($value) . '" style="width:100%;">';
}

function mini_child_save_meta($post_id) {
    if (!isset($_POST['mini_child_meta_nonce']) || !wp_verify_nonce($_POST['mini_child_meta_nonce'], 'mini_child_save_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['mini_child_custom_field'])) {
        update_post_meta($post_id, '_mini_child_custom_field', sanitize_text_field($_POST['mini_child_custom_field']));
    }
}
add_action('save_post', 'mini_child_save_meta');
*/
