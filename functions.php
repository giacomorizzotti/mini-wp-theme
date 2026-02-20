<?php
/**
 * mini functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mini
 */

if ( ! defined( 'MINI_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    define( 'MINI_VERSION', '1.1.5' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mini_setup() {
    /*
        * Make theme available for translation.
        * Translations can be filed in the /languages/ directory.
        * If you're building a theme based on mini, use a find and replace
        * to change 'mini' to the name of your theme in all the template files.
        */
    load_theme_textdomain( 'mini', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
        * Let WordPress manage the document title.
        * By adding theme support, we declare that this theme does not use a
        * hard-coded <title> tag in the document head, and expect WordPress to
        * provide it for us.
        */
    add_theme_support( 'title-tag' );

    /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'main-menu' => esc_html__( 'Main menu', 'mini' ),
            'user-menu' => esc_html__( 'User', 'mini' ),
            'footer-menu' => esc_html__( 'Footer', 'mini' ),
        )
    );

    /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    /*
    add_theme_support(
        'custom-background',
        apply_filters(
            'mini_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );
    */

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );

}
add_action( 'after_setup_theme', 'mini_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mini_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'mini_content_width', 640 );
}
add_action( 'after_setup_theme', 'mini_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mini_widgets_init() {
    // Default sidebar
    register_sidebar(
        array(
            'name'          => esc_html__( 'Default Sidebar', 'mini' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'mini' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    
    // Course sidebar
    register_sidebar(
        array(
            'name'          => esc_html__( 'Course Sidebar', 'mini' ),
            'id'            => 'course-sidebar',
            'description'   => esc_html__( 'Sidebar for courses.', 'mini' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    
    // Event sidebar
    register_sidebar(
        array(
            'name'          => esc_html__( 'Event Sidebar', 'mini' ),
            'id'            => 'event-sidebar',
            'description'   => esc_html__( 'Sidebar for events.', 'mini' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    
    // Lesson sidebar
    register_sidebar(
        array(
            'name'          => esc_html__( 'Lesson Sidebar', 'mini' ),
            'id'            => 'lesson-sidebar',
            'description'   => esc_html__( 'Sidebar for lessons.', 'mini' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    
    // News sidebar
    register_sidebar(
        array(
            'name'          => esc_html__( 'News Sidebar', 'mini' ),
            'id'            => 'news-sidebar',
            'description'   => esc_html__( 'Sidebar for news.', 'mini' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    
    // Match sidebar
    register_sidebar(
        array(
            'name'          => esc_html__( 'Match Sidebar', 'mini' ),
            'id'            => 'match-sidebar',
            'description'   => esc_html__( 'Sidebar for matches.', 'mini' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    
    // Post sidebar
    register_sidebar(
        array(
            'name'          => esc_html__( 'Post Sidebar', 'mini' ),
            'id'            => 'post-sidebar',
            'description'   => esc_html__( 'Sidebar for posts.', 'mini' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action( 'widgets_init', 'mini_widgets_init' );

/**
 * Remove wrapper div from button blocks and add 'btn' class
 */
function mini_render_block_button( $block_content, $block ) {
    if ( 'core/button' === $block['blockName'] ) {
        // Extract the link element
        if ( preg_match( '/<a\s+class="([^"]*)"([^>]*)>([^<]*)<\/a>/', $block_content, $matches ) ) {
            $classes = $matches[1];
            $attributes = $matches[2];
            $text = $matches[3];
            
            // Get wrapper classes and merge them to the link
            if ( preg_match( '/class="wp-block-button\s+([^"]*)"/', $block_content, $wrapper_matches ) ) {
                $wrapper_classes = $wrapper_matches[1];
                // Remove 'wp-block-button' prefix classes, keep only style classes
                $wrapper_classes = preg_replace( '/\bwp-block-button__\S+/', '', $wrapper_classes );
                $wrapper_classes = trim( $wrapper_classes );
                
                if ( ! empty( $wrapper_classes ) ) {
                    $classes .= ' ' . $wrapper_classes;
                }
            }
            
            $classes .= ' btn';
            
            // Return just the link without wrapper div
            return '<a class="' . esc_attr( trim( $classes ) ) . '"' . $attributes . '>' . $text . '</a>';
        }
    }
    return $block_content;
}
add_filter( 'render_block', 'mini_render_block_button', 10, 2 );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Implement the Custom Logo feature.
 */
require get_template_directory() . '/inc/custom-logo.php';

/**
 * Custom template tags for this theme. 
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * ========================================
 * ORGANIZED THEME FUNCTIONALITY
 * ========================================
 * Theme functions have been organized into separate files
 * for better maintainability and code organization.
 */

/**
 * Helper functions and utilities
 */
require get_template_directory() . '/inc/helpers.php';

/**
 * Enqueue scripts and styles
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Admin area customization
 */
require get_template_directory() . '/inc/admin-customization.php';

/**
 * Meta boxes for post types
 */
require get_template_directory() . '/inc/meta-boxes.php';

/**
 * Shortcodes
 */
require get_template_directory() . '/inc/shortcodes.php';

/**
 * Template override system
 */
require get_template_directory() . '/inc/override.php';

/* Allow SVG */
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

    global $wp_version;
    if ( $wp_version !== '4.7.1' ) {
        return $data;
    }

    $filetype = wp_check_filetype( $filename, $mimes );

    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];

}, 10, 4 );

function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

// Patterns
add_filter( 'should_load_remote_block_patterns', '__return_false' );

// Contact form 7 BUG FIX
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * custom option and settings
 */
function mini_settings_init() {

    // Register a new setting for "mini" page.
    register_setting( 'mini', 'mini_options');

    // Register a new section in the "mini" page.
    add_settings_section(
        'mini_section',
        __( '<i>mini</i> general settings', 'mini' ),
        'mini_section_callback',
        'mini'
    );

    // Register a new setting for "mini" page.
    register_setting( 'mini_cdn', 'mini_cdn_options');

    // Register a new section in the "mini" page.
    add_settings_section(
        'mini_cdn_section',
        __( '<i>mini</i> CDN settings', 'mini' ),
        'mini_cdn_section_callback',
        'mini-cdn'
    );

    // Register a new setting for "mini" page.
    register_setting( 'mini_font', 'mini_font_options');

    // Register a new section in the "mini" page.
    add_settings_section(
        'mini_font_section',
        __( '<i>mini</i> font settings', 'mini' ),
        'mini_font_section_callback',
        'mini-font'
    );

    // Register a new setting for "mini" page.
    register_setting( 'mini_ext_lib', 'mini_ext_lib_options');

    // Register a new section in the "mini" page.
    add_settings_section(
        'mini_ext_lib_section',
        __( '<i>mini</i> external libraries settings', 'mini' ),
        'mini_ext_lib_section_callback',
        'mini-ext-lib'
    );

    // Register a new setting for "mini" page.
    register_setting( 'mini_analytics', 'mini_analytics_options');

    // Register a new section in the "mini" page.
    add_settings_section(
        'mini_analytics_section',
        __( 'Mini analytics settings', 'mini' ),
        'mini_analytics_section_callback',
        'mini-analytics'
    );

    // Register a new setting for "mini" page.
    register_setting( 'mini_company', 'mini_company_options');

    // Register a new section in the "mini" page.
    add_settings_section(
        'mini_company_section',
        __( 'Mini company settings', 'mini' ),
        'mini_company_section_callback',
        'mini-company'
    );

}

// Theme textdomain is already loaded in mini_setup() function

/**
 * Register our mini_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'mini_settings_init' );


/**
 * Custom option and settings:
 *  - callback functions
 */

/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function mini_section_callback( $args ) {
    $options = get_option('mini_options');
    $credits_enabled = isset($options['mini_credits']) && $options['mini_credits'];
    ?>
    <div class="boxes">
        <div class="box-100 p-2 white-bg b-rad-5 box-shadow">
            <h4 class="" for="mini_match"><?php esc_html_e( 'Footer credit strip', 'mini' ); ?></h4>
            <label class="">
                <input type="checkbox" id="mini_credits" name="mini_options[mini_credits]" value="1" <?php checked($credits_enabled, true); ?>>
                <?php esc_html_e( 'Enable footer credits', 'mini' ); ?>
            </label>
            <p class="" for="mini_news">This option put a small banner at the bottom of the page with the credits to <a href="https://www.uwa.agency/" target="_blank" rel="noopener noreferrer">UWA Agency</a> and <a href="https://mini.uwa.agency/" target="_blank" rel="noopener noreferrer">mini</a> project.</p>
        </div>
    </div>
    <?php
}
function mini_cdn_section_callback( $args ) {
    $options = get_option('mini_cdn_options');
    $cdn_enabled = isset($options['cdn']) && $options['cdn'];
    $selected_version = isset($options['cdn_version']) ? $options['cdn_version'] : 'main';
    $versions = mini_get_github_versions();
    ?>
    <div class="boxes">
        <div class="box-100 p-2 white-bg b-rad-5 box-shadow">
            <h4 class="" for="mini_match"><?php esc_html_e( 'Use CDN', 'mini' ); ?></h4>
            <label class="">
                <input type="checkbox" id="cdn" name="mini_cdn_options[cdn]" value="1" <?php checked($cdn_enabled, true); ?>>
                <?php esc_html_e( 'Enable CDN', 'mini' ); ?>
            </label>
            <p class="" for="mini_news">Load mini CSS and JS from GitHub CDN instead of local files.</p>
        </div>
        <div id="mini_cdn_version_box" class="box-50 p-2 white-bg b-rad-5 box-shadow <?php echo !$cdn_enabled ? 'hidden' : 'shown'; ?>">
            <h4 class="" for="mini_match"><?php esc_html_e( 'GitHub Version', 'mini' ); ?></h4>
            <select id="cdn_version" name="mini_cdn_options[cdn_version]" class="regular-text">
                <option value="main" <?php selected($selected_version, 'main'); ?>>@main (latest)</option>
                <?php if (!empty($versions)) : ?>
                    <?php foreach ($versions as $version) : ?>
                        <option value="<?php echo esc_attr($version); ?>" <?php selected($selected_version, $version); ?>><?php echo esc_html($version); ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <p class="" for="mini_news">Select which version/tag from GitHub to use when CDN is enabled.</p>
        </div>
        <div id="mini_cdn_dev_box" class="box-50 p-2 warning-bg b-rad-5 box-shadow <?php echo !$cdn_enabled ? 'hidden' : 'shown'; ?>">
            <h4 class="white-text" for="mini_match"><?php esc_html_e( 'Use DEV CDN', 'mini' ); ?></h4>
            <?= mini_theme_checkbox_option('mini_cdn_options','cdn_dev'); ?>
            <p class="white-text" for="mini_news">This option let you use the development version of the CDN, which is slower but contains the latest updates.</p>
            <p class="white-text S" for="mini_news"><b>⚠️ Pay attention</b> when enabling this option in production environments, it can cause visualization problems.</p>
        </div>
        <div id="mini_custom_css_box" class="box-50 p-2 white-bg b-rad-5 box-shadow <?php echo $cdn_enabled ? 'hidden' : 'shown'; ?>">
            <h4 class="" for="mini_match"><?php echo __( 'Absolute (or relative) <i>mini.min.css</i> path', 'mini' ); ?></h4>
            <?= mini_theme_text_field_option('mini_cdn_options','css_cdn_url', '/css/mini.min.css'); ?>
            <p class="" for="mini_news">Specify a custom path to mini.min.css (default: theme's /css/mini.min.css).</p>
        </div>
        <div id="mini_custom_js_box" class="box-50 p-2 white-bg b-rad-5 box-shadow <?php echo $cdn_enabled ? 'hidden' : 'shown'; ?>">
            <h4 class="" for="mini_match"><?php echo __( 'Absolute (or relative) <i>mini.js</i> path', 'mini' ); ?></h4>
            <?= mini_theme_text_field_option('mini_cdn_options','js_cdn_url', '/js/mini.js'); ?>
            <p class="" for="mini_news">Specify a custom path to mini.js (default: theme's /js/mini.js).</p>
        </div>
        <div id="mini_custom_slider_box" class="box-50 p-2 white-bg b-rad-5 box-shadow <?php echo $cdn_enabled ? 'hidden' : 'shown'; ?>">
            <h4 class="" for="mini_match"><?php echo __( 'Absolute (or relative) <i>slider.js</i> path', 'mini' ); ?></h4>
            <?= mini_theme_text_field_option('mini_cdn_options','slider_cdn_url', '/js/slider.js'); ?>
            <p class="" for="mini_news">Specify a custom path to slider.js (default: theme's /js/slider.js).</p>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cdnCheckbox = document.getElementById('cdn');
            const versionBox = document.getElementById('mini_cdn_version_box');
            const devBox = document.getElementById('mini_cdn_dev_box');
            const customCssBox = document.getElementById('mini_custom_css_box');
            const customJsBox = document.getElementById('mini_custom_js_box');
            const customSliderBox = document.getElementById('mini_custom_slider_box');
            
            if (cdnCheckbox && versionBox && devBox && customCssBox && customJsBox && customSliderBox) {
                cdnCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Show CDN options
                        versionBox.classList.remove('hidden');
                        versionBox.classList.add('shown');
                        devBox.classList.remove('hidden');
                        devBox.classList.add('shown');
                        // Hide custom path options
                        customCssBox.classList.remove('shown');
                        customCssBox.classList.add('hidden');
                        customJsBox.classList.remove('shown');
                        customJsBox.classList.add('hidden');
                        customSliderBox.classList.remove('shown');
                        customSliderBox.classList.add('hidden');
                    } else {
                        // Hide CDN options
                        versionBox.classList.remove('shown');
                        versionBox.classList.add('hidden');
                        devBox.classList.remove('shown');
                        devBox.classList.add('hidden');
                        // Show custom path options
                        customCssBox.classList.remove('hidden');
                        customCssBox.classList.add('shown');
                        customJsBox.classList.remove('hidden');
                        customJsBox.classList.add('shown');
                        customSliderBox.classList.remove('hidden');
                        customSliderBox.classList.add('shown');
                    }
                });
            }
        });
    </script>
    <?php
}

function mini_get_github_versions() {
    $transient_key = 'mini_github_versions';
    $versions = get_transient($transient_key);
    
    if ($versions === false) {
        $response = wp_remote_get('https://api.github.com/repos/giacomorizzotti/mini/tags', array(
            'timeout' => 10,
            'headers' => array(
                'User-Agent' => 'WordPress-Mini-Theme'
            )
        ));
        
        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            $body = wp_remote_retrieve_body($response);
            $tags = json_decode($body, true);
            
            $versions = array();
            if (is_array($tags)) {
                foreach ($tags as $tag) {
                    if (isset($tag['name'])) {
                        $versions[] = $tag['name'];
                    }
                }
            }
            
            // Cache for 1 hour
            set_transient($transient_key, $versions, HOUR_IN_SECONDS);
        } else {
            $versions = array();
        }
    }
    
    return $versions;
}

function mini_colors_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is the colors section', 'mini' ); ?></p>
    <?php
}
/*
function mini_size_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is the sizes section', 'mini' ); ?></p>
    <?php
}
*/
function mini_font_section_callback( $args ) {
    $fonts = mini_get_google_fonts();
    $options = get_option('mini_font_options');
    ?>
    <div class="boxes">
        <!-- Font Usage Selection -->
        <div class="box-50 p-2 white-bg b-rad-5 box-shadow">
            <h4><?php esc_html_e( 'Font for titles', 'mini' ); ?></h4>
            <?= mini_theme_option_list_option('mini_font_options','mini_title_font', ['Sans Serif font' => '--font-sans', 'Secondary font' => '--font-second', 'Font serif' => '--font-serif', 'Font mono' => '--font-mono', 'Font handwriting' => '--font-handwriting'], 'Font used for titles'); ?>
        </div>
        <div class="box-50 p-2 white-bg b-rad-5 box-shadow">
            <h4><?php esc_html_e( 'Most used font', 'mini' ); ?></h4>
            <?= mini_theme_option_list_option('mini_font_options','mini_most_used_font', ['Sans Serif font' => '--font-sans', 'Secondary font' => '--font-second', 'Font serif' => '--font-serif', 'Font mono' => '--font-mono', 'Font handwriting' => '--font-handwriting'], 'Most used font (paragraphs, links, menus, ...)'); ?>
        </div>

        <!-- Sans Serif Font -->
        <div class="box-33 p-2 white-bg b-rad-5 box-shadow">
            <h4><?php esc_html_e( 'Sans Serif font', 'mini' ); ?></h4>
            <label><?php esc_html_e( 'Select font', 'mini' ); ?></label>
            <select name="mini_font_options[mini_sans_font]" style="width: 100%; margin-top: 8px;">
                <option value="">Default (Barlow)</option>
                <?php foreach ($fonts['sans'] as $name => $data): 
                    $selected = (isset($options['mini_sans_font']) && $options['mini_sans_font'] === $name) ? 'selected' : '';
                ?>
                <option value="<?= esc_attr($name) ?>" <?= $selected ?>><?= esc_html($name) ?></option>
                <?php endforeach; ?>
            </select>
            <p class="description"><?php esc_html_e( 'Used for paragraphs and most of the website\'s content.', 'mini' ); ?> <b><?php esc_html_e( 'Always enabled.', 'mini' ); ?></b></p>
        </div>

        <!-- Secondary Font -->
        <div class="box-33 p-2 white-bg b-rad-5 box-shadow">
            <h4><?php esc_html_e( 'Secondary font', 'mini' ); ?></h4>
            <label><?php esc_html_e( 'Select font', 'mini' ); ?></label>
            <select name="mini_font_options[mini_secondary_font]" style="width: 100%; margin-top: 8px;">
                <option value="">Default (Oswald)</option>
                <?php foreach ($fonts['secondary'] as $name => $data): 
                    $selected = (isset($options['mini_secondary_font']) && $options['mini_secondary_font'] === $name) ? 'selected' : '';
                ?>
                <option value="<?= esc_attr($name) ?>" <?= $selected ?>><?= esc_html($name) ?></option>
                <?php endforeach; ?>
            </select>
            <p class="description"><?php esc_html_e( 'Alternative font, used for titles and in CSS class ".font-two".', 'mini' ); ?> <b><?php esc_html_e( 'Always enabled.', 'mini' ); ?></b></p>
        </div>

        <!-- Serif Font -->
        <div class="box-33 p-2 white-bg b-rad-5 box-shadow">
            <h4><?php esc_html_e( 'Serif font', 'mini' ); ?></h4>
            <label style="display: block; margin-bottom: 8px;">
                <?= mini_theme_checkbox_option('mini_font_options','mini_serif_font_status'); ?>
                <?php esc_html_e( 'Enable serif font', 'mini' ); ?>
            </label>
            <label><?php esc_html_e( 'Select font', 'mini' ); ?></label>
            <select name="mini_font_options[mini_serif_font]" style="width: 100%; margin-top: 8px;">
                <option value="">Default (Playfair Display)</option>
                <?php foreach ($fonts['serif'] as $name => $data): 
                    $selected = (isset($options['mini_serif_font']) && $options['mini_serif_font'] === $name) ? 'selected' : '';
                ?>
                <option value="<?= esc_attr($name) ?>" <?= $selected ?>><?= esc_html($name) ?></option>
                <?php endforeach; ?>
            </select>
            <p class="description"><?php esc_html_e( 'Serif font, used in CSS class ".serif"', 'mini' ); ?></p>
        </div>

        <!-- Mono Font -->
        <div class="box-33 p-2 white-bg b-rad-5 box-shadow">
            <h4><?php esc_html_e( 'Mono font', 'mini' ); ?></h4>
            <label style="display: block; margin-bottom: 8px;">
                <?= mini_theme_checkbox_option('mini_font_options','mini_mono_font_status'); ?>
                <?php esc_html_e( 'Enable mono font', 'mini' ); ?>
            </label>
            <label><?php esc_html_e( 'Select font', 'mini' ); ?></label>
            <select name="mini_font_options[mini_mono_font]" style="width: 100%; margin-top: 8px;">
                <option value="">Default (Roboto Mono)</option>
                <?php foreach ($fonts['mono'] as $name => $data): 
                    $selected = (isset($options['mini_mono_font']) && $options['mini_mono_font'] === $name) ? 'selected' : '';
                ?>
                <option value="<?= esc_attr($name) ?>" <?= $selected ?>><?= esc_html($name) ?></option>
                <?php endforeach; ?>
            </select>
            <p class="description"><?php esc_html_e( 'Monospace font, used in CSS class ".mono"', 'mini' ); ?></p>
        </div>

        <!-- Handwriting Font -->
        <div class="box-33 p-2 white-bg b-rad-5 box-shadow">
            <h4><?php esc_html_e( 'Handwriting font', 'mini' ); ?></h4>
            <label style="display: block; margin-bottom: 8px;">
                <?= mini_theme_checkbox_option('mini_font_options','mini_handwriting_font_status'); ?>
                <?php esc_html_e( 'Enable handwriting font', 'mini' ); ?>
            </label>
            <label><?php esc_html_e( 'Select font', 'mini' ); ?></label>
            <select name="mini_font_options[mini_handwriting_font]" style="width: 100%; margin-top: 8px;">
                <option value="">Default (Edu VIC WA NT Beginner)</option>
                <?php foreach ($fonts['handwriting'] as $name => $data): 
                    $selected = (isset($options['mini_handwriting_font']) && $options['mini_handwriting_font'] === $name) ? 'selected' : '';
                ?>
                <option value="<?= esc_attr($name) ?>" <?= $selected ?>><?= esc_html($name) ?></option>
                <?php endforeach; ?>
            </select>
            <p class="description"><?php esc_html_e( 'Handwriting font, used in CSS class ".handwriting"', 'mini' ); ?></p>
        </div>
    </div>
    <?php
}
function mini_ext_lib_section_callback( $args ) {
    ?>
    <div class="boxes">
        <div class="box-33 p-2 white-bg b-rad-5 box-shadow">
            <h4 class="" for="mini_match"><?php esc_html_e( 'AOS', 'mini' ); ?></h4>
            <?= mini_theme_checkbox_option('mini_ext_lib_options','mini_aos'); ?>
            <p class="" for="mini_news">This option enables the AOS (Animate On Scroll) library for animations on scroll events.</p>
        </div>
        <div class="box-33 p-2 white-bg b-rad-5 box-shadow">
            <h4 class="" for="mini_match"><?php esc_html_e( 'Iconoir', 'mini' ); ?></h4>
            <?= mini_theme_checkbox_option('mini_ext_lib_options','mini_iconoir'); ?>
            <p class="" for="mini_news">This option enables the Iconoir library for icons.</p>
        </div>
    </div>
    <?php
}
function mini_analytics_section_callback( $args ) {
    ?>
    <div class="boxes">
        <div class="box-50 p-2 white-bg b-rad-5 box-shadow">
            <h4><?php esc_html_e( 'Google Analytics', 'mini' ); ?></h4>
            <label style="display: block; margin-bottom: 8px;">
                <?= mini_theme_checkbox_option('mini_analytics_options','mini_google_analytics'); ?>
                <?php esc_html_e( 'Enable Google Analytics', 'mini' ); ?>
            </label>
            <label><?php esc_html_e( 'Google Analytics Code', 'mini' ); ?></label>
            <?= mini_theme_text_field_option('mini_analytics_options','mini_google_analytics_code','G-XXXXXXXXXX', 'width: 100%; margin-top: 8px;'); ?>
            <p class="description"><?php esc_html_e( 'Enter your Google Analytics measurement ID (e.g., G-XXXXXXXXXX)', 'mini' ); ?></p>
        </div>
    </div>
    <?php
}
function mini_company_section_callback( $args ) {
    ?>
    <div class="boxes">
        <div class="box-66 p-2 white-bg b-rad-5 box-shadow">
            <h3 class=""><?= esc_html__( 'Your data', 'mini' ) ?></h3>
            <p class="m-0">These data will populate the footer of this web application.</p>
            <p class="s m-0">They could also be used in the "About us" page, in "Cookie policy", in "Privacy policy" or in other sections.</p>
        </div>
        <div class="box-66 white-bg b-rad-5 box-shadow">
            <div class="boxes">
                <div class="box-100">
                    <h4 class="m-0">Company details</h4>
                </div>
                <div class="box-75">
                    <p class="label"><?php esc_html_e( 'Company / Owner', 'mini' ); ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_name',''); ?>
                </div>
                <div class="box-50">
                    <p class="label"><?= esc_html__( 'Address', 'mini' ) ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_address',''); ?>
                </div>
                <div class="box-25">
                    <p class="label"><?= esc_html__( 'House number', 'mini' ) ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_house_number',''); ?>
                </div>
            </div>
            <div class="boxes">
                <div class="box-25">
                    <p class="label"><?= esc_html__( 'City', 'mini' ) ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_city',''); ?>
                </div>
                <div class="box-25">
                    <p class="label"><?= esc_html__( 'City code', 'mini' ) ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_city_code',''); ?>
                </div>
                <div class="box-12">
                    <p class="label"><?= esc_html__( 'Province', 'mini' ) ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_province',''); ?>
                </div>
                <div class="box-12">
                    <p class="label"><?= esc_html__( 'Country', 'mini' ) ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_country',''); ?>
                </div>
            </div>
            <div class="boxes">
                <div class="box-50">
                    <p class="label"><?= esc_html__( 'Email', 'mini' ) ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_email',''); ?>
                    <p class="description"><?= esc_html__( 'This email could be used by users.', 'mini' ) ?></p>
                </div>
                <div class="box-50">
                    <p class="label"><?= esc_html__( 'Phone', 'mini' ) ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_phone',''); ?>
                    <p class="description"><?= esc_html__( 'This phone number could be used by users.', 'mini' ) ?></p>
                </div>
            </div>
            <div class="boxes">
                <div class="box-33">
                    <p class="label"><?= esc_html__( 'Tax number', 'mini' ) ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_tax_number',''); ?>
                    <p class="description"><?= esc_html__( 'Also known as VAT number (Partita IVA).', 'mini' ) ?></p>
                </div>
                <div class="box-33">
                    <p class="label"><?= esc_html__( 'ID code', 'mini' ) ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_id_code',''); ?>
                    <p class="description"><?= esc_html__( 'Also known as Fiscal Code (Codice Fiscale).', 'mini' ) ?></p>
                </div>
                <div class="box-33">
                    <p class="label"><?= esc_html__( 'PEC', 'mini' ) ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_pec',''); ?>
                    <p class="description"><?= esc_html__( 'Only for Italian companies: Certified Email (Posta Elettronica Certificata).', 'mini' ) ?></p>
                </div>
            </div>
        </div>
        <div class="box-100 white-bg b-rad-5 box-shadow">
            <div class="boxes">
                <div class="box-100">
                    <h4 class="m-0">Social networks</h4>
                    <p class="description m-0"><?= esc_html__( 'Enable the social networks you want to use and add your profile URLs', 'mini' ) ?></p>
                </div>
                <div class="box-25">
                    <label style="display: block; margin-bottom: 8px;">
                        <?= mini_theme_checkbox_option('mini_company_options','mini_company_instagram_enabled'); ?>
                        <strong><?= esc_html__( 'Instagram', 'mini' ) ?></strong>
                    </label>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_instagram','https://instagram.com/yourprofile'); ?>
                </div>
                <div class="box-25">
                    <label style="display: block; margin-bottom: 8px;">
                        <?= mini_theme_checkbox_option('mini_company_options','mini_company_facebook_enabled'); ?>
                        <strong><?= esc_html__( 'Facebook', 'mini' ) ?></strong>
                    </label>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_facebook','https://facebook.com/yourpage'); ?>
                </div>
                <div class="box-25">
                    <label style="display: block; margin-bottom: 8px;">
                        <?= mini_theme_checkbox_option('mini_company_options','mini_company_x_enabled'); ?>
                        <strong><?= esc_html__( 'X (Twitter)', 'mini' ) ?></strong>
                    </label>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_x','https://x.com/yourhandle'); ?>
                </div>
                <div class="box-25">
                    <label style="display: block; margin-bottom: 8px;">
                        <?= mini_theme_checkbox_option('mini_company_options','mini_company_linkedin_enabled'); ?>
                        <strong><?= esc_html__( 'LinkedIn', 'mini' ) ?></strong>
                    </label>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_linkedin','https://linkedin.com/company/yourcompany'); ?>
                </div>
                <div class="box-25">
                    <label style="display: block; margin-bottom: 8px;">
                        <?= mini_theme_checkbox_option('mini_company_options','mini_company_youtube_enabled'); ?>
                        <strong><?= esc_html__( 'YouTube', 'mini' ) ?></strong>
                    </label>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_youtube','https://youtube.com/@yourchannel'); ?>
                </div>
                <div class="box-25">
                    <label style="display: block; margin-bottom: 8px;">
                        <?= mini_theme_checkbox_option('mini_company_options','mini_company_tiktok_enabled'); ?>
                        <strong><?= esc_html__( 'TikTok', 'mini' ) ?></strong>
                    </label>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_tiktok','https://tiktok.com/@yourhandle'); ?>
                </div>
                <div class="box-25">
                    <label style="display: block; margin-bottom: 8px;">
                        <?= mini_theme_checkbox_option('mini_company_options','mini_company_threads_enabled'); ?>
                        <strong><?= esc_html__( 'Threads', 'mini' ) ?></strong>
                    </label>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_threads','https://threads.net/@yourhandle'); ?>
                </div>
            </div>
        </div>
        <div class="box-66 white-bg b-rad-5 box-shadow">
            <div class="boxes">
                <div class="box-100">
                    <h4 class="m-0">Messaging apps</h4>
                    <p class="description m-0"><?= esc_html__( 'Enable messaging apps for direct customer contact', 'mini' ) ?></p>
                </div>
                <div class="box-50">
                    <label style="display: block; margin-bottom: 8px;">
                        <?= mini_theme_checkbox_option('mini_company_options','mini_company_whatsapp_enabled'); ?>
                        <strong><?= esc_html__( 'WhatsApp', 'mini' ) ?></strong>
                    </label>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_whatsapp','https://wa.me/1234567890'); ?>
                    <p class="description"><?= esc_html__( 'Format: https://wa.me/1234567890', 'mini' ) ?></p>
                </div>
                <div class="box-50">
                    <label style="display: block; margin-bottom: 8px;">
                        <?= mini_theme_checkbox_option('mini_company_options','mini_company_telegram_enabled'); ?>
                        <strong><?= esc_html__( 'Telegram', 'mini' ) ?></strong>
                    </label>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_telegram','https://t.me/yourusername'); ?>
                    <p class="description"><?= esc_html__( 'Format: https://t.me/yourusername', 'mini' ) ?></p>
                </div>
            </div>
        </div>  
<?php /*
        <div class="box-66 p-2 white-bg b-rad-5 box-shadow">
            <div class="boxes">
                <div class="box-100">
                    <h4 class="m-0">Technical contacts</h4>
                </div>
                <div class="box-50">
                    <p class="label"><?= esc_html__( 'Email', 'mini' ) ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_service_email',''); ?>
                </div>
                <div class="box-50">
                    <p class="label"><?= esc_html__( 'Phone', 'mini' ) ?></p>
                    <?= mini_theme_text_field_option('mini_company_options','mini_company_service_phone',''); ?>
                </div>
            </div>
        </div>
*/ ?>
    </div>
    <?php
}

/**
 * Add the top level menu page.
 */
function mini_options_page() {
    if ( empty ( $GLOBALS['admin_page_hooks']['mini'] ) ) {
        add_menu_page(
            'mini options',
            'mini',
            'manage_options',
            'mini',
            'mini_theme_main_page_html',
            'https://cdn.jsdelivr.net/gh/giacomorizzotti/mini/img/brand/mini_emblem_wh.svg'
        );
    }
    add_submenu_page(
        'mini',
        'General options',
        'General',
        'manage_options',
        'mini-general',
        'mini_options_page_html'
    );
    add_submenu_page(
        'mini',
        'CDN options',
        'CDN',
        'manage_options',
        'mini-cdn',
        'mini_cdn_options_page_html'
    );
    add_submenu_page(
        'mini',
        'Font options',
        'Fonts',
        'manage_options',
        'mini-fonts',
        'mini_font_options_page_html'
    );
    /*
    add_submenu_page(
        'mini',
        'Size options',
        'Sizes',
        'manage_options',
        'mini-size',
        'mini_size_options_page_html'
    );
    */
    add_submenu_page(
        'mini',
        'External libraries options',
        'External libraries',
        'manage_options',
        'mini-ext-lib',
        'mini_ext_lib_options_page_html'
    );
    add_submenu_page(
        'mini',
        'Analytics options',
        'Analytics',
        'manage_options',
        'mini-analytics',
        'mini_analytics_options_page_html'
    );
    add_submenu_page(
        'mini',
        'Company options',
        'Company',
        'manage_options',
        'mini-company',
        'mini_company_options_page_html'
    );
}


function mini_theme_main_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="boxes">
        <div class="box-100 p-2 white-bg b-rad-5 box-shadow mb-2">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <div class="space"></div>
            <img src="https://cdn.jsdelivr.net/gh/giacomorizzotti/mini/img/brand/mini_logo_full_wh.svg" alt="mini logo" style="max-width: 300px;">
        </div>
    </div>
    <?php
}

/**
 * Register our mini_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'mini_options_page' );

/**
 * Top level menu callback function
 */
function mini_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // add error/update messages

    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'mini_messages', 'mini_message', __( 'Settings Saved', 'mini' ), 'updated' );
    }

    // show error/update messages
    settings_errors( 'mini_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <div class="space"></div>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "mini"
            settings_fields( 'mini' );
            // output setting sections and their fields
            // (sections are registered for "mini", each field is registered to a specific section)
            do_settings_sections( 'mini' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

// CDN options page
function mini_cdn_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error( 'mini_messages', 'mini_message', __( 'Settings Saved', 'mini' ), 'updated' );
    }
    settings_errors( 'mini_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <div class="space"></div>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'mini_cdn' );
            do_settings_sections( 'mini-cdn' );
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

// Sizes options page
/*
function mini_size_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error( 'mini_messages', 'mini_message', __( 'Settings Saved', 'mini' ), 'updated' );
    }
    settings_errors( 'mini_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'mini_size' );
            do_settings_sections( 'mini-size' );
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}
*/

// Fonts options page
function mini_font_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error( 'mini_messages', 'mini_message', __( 'Settings Saved', 'mini' ), 'updated' );
    }
    settings_errors( 'mini_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <div class="space"></div>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'mini_font' );
            do_settings_sections( 'mini-font' );
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

// External libraries options page
function mini_ext_lib_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( isset( $_GET['settings-updated'] ) ) {

        add_settings_error( 'mini_messages', 'mini_message', __( 'Settings Saved', 'mini' ), 'updated' );
    }
    settings_errors( 'mini_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <div class="space"></div>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'mini_ext_lib' );
            do_settings_sections( 'mini-ext-lib' );
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

// Analytics options page
function mini_analytics_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error( 'mini_messages', 'mini_message', __( 'Settings Saved', 'mini' ), 'updated' );
    }
    settings_errors( 'mini_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <div class="space"></div>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'mini_analytics' );
            do_settings_sections( 'mini-analytics' );
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

// Company options page
function mini_company_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error( 'mini_messages', 'mini_message', __( 'Settings Saved', 'mini' ), 'updated' );
    }
    settings_errors( 'mini_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <div class="space"></div>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'mini_company' );
            do_settings_sections( 'mini-company' );
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}
