<?php
/**
 * mini functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mini
 */

if ( ! defined( '_S_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    define( '_S_VERSION', '1.0.0' );
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
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'mini' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'mini' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action( 'widgets_init', 'mini_widgets_init' );

/**
 * Enqueue scripts and styles.
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
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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

// Allow SVG
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

function fix_svg() {
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );


/**
 * ADD header styling meta box to page edit
 */

// Add blocks to the main column on the page pages
add_action( 'add_meta_boxes', 'add_header_styling_box' );

// Saving data when the post is saved
add_action( 'save_post', 'header_styling_save_postdata' );

function add_header_styling_box() {
    add_meta_box(
        'header-style',
        'Header style',
        'header_styling_box_html',
        'page',
        'side'
    );
}

// HTML code of the block
function header_styling_box_html( $post, $meta ){

    // field value
    $headerTopStyle = get_post_meta( $post->ID, 'header_top', true);
    $headerScrollStyle = get_post_meta( $post->ID, 'header_scroll', true);

    $headerTopStyleDefaultState = null;
    if ( $headerTopStyle == '') { $headerTopStyleDefaultState = ' selected'; }
    $headerTopStyleInvState = null;
    if ( $headerTopStyle == 'top-neg') { $headerTopStyleInvState = ' selected'; }
    $headerTopStyleWhState = null;
    if ( $headerTopStyle == 'top-wh') { $headerTopStyleWhState = ' selected'; }
    $headerTopStyleBkState = null;
    if ( $headerTopStyle == 'top-bk') { $headerTopStyleBkState = ' selected'; }

    // Form fields for entering data
    echo '<label for="header_top_style" style="display: block; margin-bottom: 5px;">' . __("Header top style", 'header_styleng_box_textdomain' ) . '</label> ';
    echo '<select name="header_top_style">
		<option value=""'.$headerTopStyleDefaultState.'>Normal</option>
		<option value="top-neg"'.$headerTopStyleInvState.'>Invert</option>
		<option value="top-wh"'.$headerTopStyleWhState.'>White Background</option>
		<option value="top-bk"'.$headerTopStyleBkState.'>Black Background</option>
	</select>';

    echo '<div style="display: block; height: 15px;"></div>';

    $headerScrollStyleDefaultState = null;
    if ( $headerScrollStyle == '') { $headerScrollStyleDefaultState = ' selected'; }
    $headerScrollStyleInvState = null;
    if ( $headerScrollStyle == 'scroll-neg') { $headerScrollStyleInvState = ' selected'; }
    $headerScrollStyleWhState = null;
    if ( $headerScrollStyle == 'scroll-wh') { $headerScrollStyleWhState = ' selected'; }
    $headerScrollStyleBkState = null;
    if ( $headerScrollStyle == 'scroll-bk') { $headerScrollStyleBkState = ' selected'; }

    echo '<label for="header_scroll_style" style="display: block; margin-bottom: 5px;">' . __("Header scrolled style", 'header_styleng_box_textdomain' ) . '</label> ';
    echo '<select name="header_scroll_style">
		<option value=""'.$headerScrollStyleDefaultState.'>Normal</option>
		<option value="scroll-neg"'.$headerScrollStyleInvState.'>Invert</option>
		<option value="scroll-wh"'.$headerScrollStyleWhState.'>White Background</option>
		<option value="scroll-bk"'.$headerScrollStyleBkState.'>Black Background</option>
	</select>';

}

function header_styling_save_postdata( $post_id ) {

    // make sure the field is set.
    if ( ! isset( $_POST['header_top_style'] ) || ! isset( $_POST['header_scroll_style'] ) ) { return; }

    // if this is autosave do nothing
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) { return; }

    // check user permission
    if( ! current_user_can( 'edit_post', $post_id ) ) { return; }

    // Everything is OK. Now, we need to find and save the data
    if ( isset( $_POST['header_top_style'] ) ) {
        // Define the value of the input field.
        $headerTopStyle = $_POST['header_top_style'];
        // Update data in the database.
        update_post_meta( $post_id, 'header_top', $headerTopStyle );
    }
    if ( isset( $_POST['header_scroll_style'] ) ) {
        // Define the value of the input field.
        $headerScrollStyle = $_POST['header_scroll_style'];
        // Update data in the database.
        update_post_meta( $post_id, 'header_scroll', $headerScrollStyle );
    }
}

/**
 * ADD title presence meta box to page edit
 */

// Add blocks to the main column on the page pages
add_action( 'add_meta_boxes', 'add_title_presence_box' );

// Saving data when the post is saved
add_action( 'save_post', 'title_presence_save_postdata' );

function add_title_presence_box() {
    add_meta_box(
        'title-presence',
        'Show title',
        'title_presence_box_html',
        'page',
        'side'
    );
}

// HTML code of the block
function title_presence_box_html( $post, $meta ){

    // field value
    $titlePresence = get_post_meta( $post->ID, 'title_presence', true);

    $titlePresenceState = null;
    if ( $titlePresence == true ) {
        $titlePresenceState = ' checked';
    }

    // Form fields for entering data
    echo '<label for="title_presence" style="display: block; margin-bottom: 5px;">' . __("Show article title", 'title_presence_box_textdomain' ) . '</label> ';
    echo '<input type="checkbox" id="title_presence" name="title_presence"'.$titlePresenceState.'>';

}

function title_presence_save_postdata( $post_id ) {

    // make sure the field is set.
    // if ( ! isset( $_POST['title_presence'] ) ) { return; }

    // if this is autosave do nothing
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) { return; }

    // check user permission
    if( ! current_user_can( 'edit_post', $post_id ) ) { return; }

    // Everything is OK. Now, we need to find and save the data
    // Define the value of the input field.
    if ( isset($_POST['title_presence']) ) {
        $titlePresence = true;
    } else {
        $titlePresence = false;
    }
    // Update data in the database.
    update_post_meta( $post_id, 'title_presence', $titlePresence );

}

/**
 * ADD sidebar presence meta box to page edit
 */

// Add blocks to the main column on the page pages
add_action( 'add_meta_boxes', 'add_sidebar_presence_box' );

// Saving data when the post is saved
add_action( 'save_post', 'sidebar_presence_save_postdata' );

function add_sidebar_presence_box() {
    add_meta_box(
        'sidebar-presence',
        'Show sidebar',
        'sidebar_presence_box_html',
        'page',
        'side'
    );
}

// HTML code of the block
function sidebar_presence_box_html( $post, $meta ){

    // field value
    $sidebarPresence = get_post_meta( $post->ID, 'sidebar_presence', true);

    $sidebarPresenceState = null;
    if ( $sidebarPresence == true ) {
        $sidebarPresenceState = ' checked';
    }

    // Form fields for entering data
    echo '<label for="sidebar_presence" style="display: block; margin-bottom: 5px;">' . __("Show sidebar", 'sidebar_presence_box_textdomain' ) . '</label> ';
    echo '<input type="checkbox" id="sidebar_presence" name="sidebar_presence"'.$sidebarPresenceState.'>';

}

function sidebar_presence_save_postdata( $post_id ) {

    // make sure the field is set.
    // if ( ! isset( $_POST['title_presence'] ) ) { return; }

    // if this is autosave do nothing
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) { return; }

    // check user permission
    if( ! current_user_can( 'edit_post', $post_id ) ) { return; }

    // Everything is OK. Now, we need to find and save the data
    // Define the value of the input field.
    if ( isset($_POST['sidebar_presence']) ) {
        $sidebarPresence = true;
    } else {
        $sidebarPresence = false;
    }
    // Update data in the database.
    update_post_meta( $post_id, 'sidebar_presence', $sidebarPresence );

}

/**
 * ADD page container meta box to page edit
 */

// Add blocks to the main column on the page pages
add_action( 'add_meta_boxes', 'add_page_container_box' );

// Saving data when the post is saved
add_action( 'save_post', 'page_container_save_postdata' );

function add_page_container_box() {
    add_meta_box(
        'page-container',
        'Page container',
        'page_container_box_html',
        'page',
        'side'
    );
}

// HTML code of the block
function page_container_box_html( $post, $meta ){

    // field value
    $pageContainerStyle = get_post_meta( $post->ID, 'page_container', true);

    $pageContainerStdDefaultState = null;
    if ( $pageContainerStyle == 'fw') { $pageContainerStdDefaultState = ' selected'; }
    $pageContainerFullDefaultState = null;
    if ( $pageContainerStyle == '') { $pageContainerFullDefaultState = ' selected'; }
    $pageContainerThinDefaultState = null;
    if ( $pageContainerStyle == 'thin') { $pageContainerThinDefaultState = ' selected'; }
    $pageContainerWideDefaultState = null;
    if ( $pageContainerStyle == 'wide') { $pageContainerWideDefaultState = ' selected'; }

    // Form fields for entering data
    echo '<label for="page_container" style="display: block; margin-bottom: 5px;">' . __("Page container", 'page_container_box_textdomain' ) . '</label> ';
    echo '<select name="page_container">
		<option value="fw"'.$pageContainerStdDefaultState.'>Full width</option>
		<option value=""'.$pageContainerFullDefaultState.'>Standard</option>
		<option value="thin"'.$pageContainerThinDefaultState.'>Thin</option>
		<option value="wide"'.$pageContainerWideDefaultState.'>Wide</option>
	</select>';

}

function page_container_save_postdata( $post_id ) {

    // make sure the field is set.
    if ( ! isset( $_POST['page_container'] ) ) { return; }

    // if this is autosave do nothing
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) { return; }

    // check user permission
    if( ! current_user_can( 'edit_post', $post_id ) ) { return; }

    // Everything is OK. Now, we need to find and save the data
    // Define the value of the input field.
    $pageContainerStyle = $_POST['page_container'];
    // Update data in the database.
    update_post_meta( $post_id, 'page_container', $pageContainerStyle );
}




















/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * custom option and settings
 */
function mini_settings_init() {

    // Register a new setting for "mini" page.
    register_setting( 'mini_cdn', 'mini_cdn_options');

    // Register a new section in the "mini" page.
    add_settings_section(
        'mini_cdn_section',
        __( 'Mini CDN settings', 'mini' ),
        'mini_cdn_section_callback',
        'mini-cdn'
    );

    add_settings_field(
        'mini_cdn_field', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'CDN', 'mini' ),
        'mini_cdn_field_callback',
        'mini-cdn',
        'mini_cdn_section',
        array(
            'label_for'         => 'mini_cdn',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
    );

    // Register a new setting for "mini" page.
    register_setting( 'mini_colors', 'mini_colors_options');

    // Register a new section in the "mini" page.
    add_settings_section(
        'mini_colors_section',
        __( 'Mini Colors settings', 'mini' ),
        'mini_colors_section_callback',
        'mini-colors'
    );

    // Register a new field in the "mini_section" section, inside the "mini" page.
    add_settings_field(
        'mini_colors', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'Colors', 'mini' ),
        'mini_colors_callback',
        'mini-colors',
        'mini_colors_section',
        array(
            'label_for'         => 'mini_colors',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
    );

    // Register a new setting for "mini" page.
    register_setting( 'mini_size', 'mini_size_options');

    // Register a new section in the "mini" page.
    add_settings_section(
        'mini_size_section',
        __( 'Mini size settings', 'mini' ),
        'mini_size_section_callback',
        'mini-size'
    );

    add_settings_field(
        'mini_logo_size', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'Logo size', 'mini' ),
        'mini_logo_size_field_callback',
        'mini-size',
        'mini_size_section',
        array(
            'label_for'         => 'mini_logo_size',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
    );

    // Register a new setting for "mini" page.
    register_setting( 'mini_font', 'mini_font_options');

    // Register a new section in the "mini" page.
    add_settings_section(
        'mini_font_section',
        __( 'Mini font settings', 'mini' ),
        'mini_font_section_callback',
        'mini-font'
    );

    add_settings_field(
        'mini_fonts', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'Fonts', 'mini' ),
        'mini_fonts_field_callback',
        'mini-font',
        'mini_font_section',
        array(
            'label_for'         => 'mini_fonts',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
    );

    // Register a new setting for "mini" page.
    register_setting( 'mini_ext_lib', 'mini_ext_lib_options');

    // Register a new section in the "mini" page.
    add_settings_section(
        'mini_ext_lib_section',
        __( 'Mini external libraries settings', 'mini' ),
        'mini_ext_lib_section_callback',
        'mini-ext-lib'
    );

    add_settings_field(
        'mini_ext_lib', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'External libraries', 'mini' ),
        'mini_ext_lib_field_callback',
        'mini-ext-lib',
        'mini_ext_lib_section',
        array(
            'label_for'         => 'mini_ext_lib',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
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

    add_settings_field(
        'mini_analytics', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'Analytics', 'mini' ),
        'mini_analytics_field_callback',
        'mini-analytics',
        'mini_analytics_section',
        array(
            'label_for'         => 'mini_analytics',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
    );



}






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
function mini_cdn_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is the CDN section', 'mini' ); ?></p>
    <?php
}
function mini_colors_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is the colors section', 'mini' ); ?></p>
    <?php
}
function mini_size_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is the sizes section', 'mini' ); ?></p>
    <?php
}
function mini_font_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is the font section', 'mini' ); ?></p>
    <?php
}
function mini_ext_lib_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is the external libraries section', 'mini' ); ?></p>
    <?php
}
function mini_analytics_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is the analytics section', 'mini' ); ?></p>
    <?php
}


/**
 * CDN field callback function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function mini_cdn_field_callback( $args ) {
    $options = get_option( 'mini_cdn_options' );
    $status = '';
    $cdn_css_default_value = 'https://cdn.jsdelivr.net/gh/giacomorizzotti/mini@main/css/mini.min.css';
    $cdn_js_default_value = 'https://cdn.jsdelivr.net/gh/giacomorizzotti/mini@main/js/mini.js';
    if (is_array($options) && array_key_exists('cdn', $options)) {
        if ($options['cdn'] == true) {
            $status = 'checked';
        }
    }
    if ( 
        is_array($options) && array_key_exists('css_cdn_url', $options ) && $options['css_cdn_url'] != null 
    ) {
        $cdn_css_value = $options['css_cdn_url'];
        $cdn_css_placeholder = null;
    } else {
        $cdn_css_value = $options['css_cdn_url'];
        $cdn_css_placeholder = $cdn_css_default_value;
    }
    if ( 
        is_array($options) && array_key_exists('js_cdn_url', $options ) && $options['js_cdn_url'] != null 
    ) {
        $cdn_js_value = $options['js_cdn_url'];
        $cdn_js_placeholder = null;
    } else {
        $cdn_js_value = $options['js_cdn_url'];
        $cdn_js_placeholder = $cdn_js_default_value;
    }
    ?>
    <input
        type="checkbox"
        id="cdn"
        name="mini_cdn_options[cdn]"
        <?=$status?>
    >
    <br/>
    <br/>
    <input
        type="text"
        id="css_cdn_url"
        name="mini_cdn_options[css_cdn_url]"
        value="<?= $cdn_css_value ?>"
        placeholder="<?= $cdn_css_placeholder ?>"
        style="width: 100%";
    >
    <br/>
    <br/>
    <input
        type="text"
        id="css_cdn_url"
        name="mini_cdn_options[js_cdn_url]"
        value="<?= $cdn_js_value ?>"
        placeholder="<?= $cdn_js_placeholder ?>"
        style="width: 100%";
    >
    <p class="description">
        <?php esc_html_e( 'Use external (CDN) files for this website', 'mini' ); ?>
    </p>
    <p class="description small">
        <?php esc_html_e( 'If you want to avoid the CDN due to performance reasons, please ensure to get .css .js files locally!', 'mini' ); ?>
    </p>
    <?php
}

function mini_colors_callback( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'mini_colors_options' );
    
    /* Main color */
    $main_color_default_value = 'rgb(60 90 255 / 100%)';
    $main_color_dark_default_value = 'rgb(50 75 180 / 100%)';
    $main_color_transp_default_value = 'rgb( 60 90 255 / 20% )';
    if ( 
        is_array($options) && array_key_exists('mini_main_color', $options ) && $options['mini_main_color'] != null
    ) {
        $main_color_value = $options['mini_main_color'];
        $main_color_placeholder = null;
        $main_color_color = $options['mini_main_color'];
    } else {
        $main_color_value = null;
        $main_color_placeholder = $main_color_default_value;
        $main_color_color = $main_color_default_value;
    }
    if ( 
        is_array($options) && array_key_exists('mini_main_color_dark', $options ) && $options['mini_main_color_dark'] != null 
    ) {
        $main_color_dark_value = $options['mini_main_color_dark'];
        $main_color_dark_placeholder = null;
        $main_color_dark_color = $options['mini_main_color_dark'];
    } else {
        $main_color_dark_value = null;
        $main_color_dark_placeholder = $main_color_dark_default_value;
        $main_color_dark_color = $main_color_dark_default_value;
    }
    if ( 
        is_array($options) && array_key_exists('mini_main_color_transp', $options ) && $options['mini_main_color_transp'] != null 
    ) {
        $main_color_transp_value = $options['mini_main_color_transp'];
        $main_color_transp_placeholder = null;
        $main_color_transp_color = $options['mini_main_color_transp'];
    } else {
        $main_color_transp_value = null;
        $main_color_transp_placeholder = $main_color_transp_default_value;
        $main_color_transp_color = $main_color_transp_default_value;
    }
    /* Second color */
    $second_color_default_value = 'rgb(50 75 180 / 100%)';
    $second_color_dark_default_value = 'rgb(37 56 133 / 100%)';
    if ( 
        is_array($options) && array_key_exists('mini_second_color', $options ) && $options['mini_second_color'] != null
    ) {
        $second_color_value = $options['mini_second_color'];
        $second_color_placeholder = null;
        $second_color_color = $border_color['mini_second_color'];
    } else {
        $second_color_value = null;
        $second_color_placeholder = $second_color_default_value;
        $second_color_color = $second_color_default_value;
    }
    if ( 
        is_array($options) && array_key_exists('mini_second_color_dark', $options ) && $options['mini_second_color_dark'] != null
    ) {
        $second_color_dark_value = $options['mini_second_color_dark'];
        $second_color_dark_placeholder = null;
        $second_color_dark_color = $options['mini_second_color_dark'];
    } else {
        $second_color_dark_value = null;
        $second_color_dark_placeholder = $second_color_dark_default_value;
        $second_color_dark_color = $second_color_dark_default_value;
    }
    /* Third color */
    $third_color_default_value = 'rgb(60 30 99 / 100%)';
    $third_color_dark_default_value = 'rgb(34 15 61 / 100%)';
    if ( is_array($options) && array_key_exists('mini_third_color', $options ) && $options['mini_third_color'] != null ) {
        $third_color_value = $options['mini_third_color'];
        $third_color_placeholder = null;
        $third_color_color = $options['mini_third_color'];
    } else {
        $third_color_value = null;
        $third_color_placeholder = $third_color_default_value;
        $third_color_color = $third_color_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_third_color_dark', $options ) && $options['mini_third_color_dark'] != null ) {
        $third_color_dark_value = $options['mini_third_color_dark'];
        $third_color_dark_placeholder = null;
        $third_color_dark_color = $options['mini_third_color_dark'];
    } else {
        $third_color_dark_value = null;
        $third_color_dark_placeholder = $third_color_dark_default_value;
        $third_color_dark_color = $third_color_dark_default_value;
    }
    /* Fourth color */
    $fourth_color_default_value = 'rgb(220 230 0 / 100%)';
    $fourth_color_dark_default_value = 'rgb(180 190 0 / 100%)';
    if ( is_array($options) && array_key_exists('mini_fourth_color', $options ) && $options['mini_fourth_color'] != null ) {
        $fourth_color_value = $options['mini_fourth_color'];
        $fourth_color_placeholder = null;
        $fourth_color_color = $options['mini_fourth_color'];
    } else {
        $fourth_color_value = null;
        $fourth_color_placeholder = $fourth_color_default_value;
        $fourth_color_color = $fourth_color_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_fourth_color_dark', $options ) && $options['mini_fourth_color_dark'] != null ) {
        $fourth_color_dark_value = $options['mini_fourth_color_dark'];
        $fourth_color_dark_placeholder = null;
        $fourth_color_dark_color = $options['mini_fourth_color_dark'];
    } else {
        $fourth_color_dark_value = null;
        $fourth_color_dark_placeholder = $fourth_color_dark_default_value;
        $fourth_color_dark_color = $fourth_color_dark_default_value;
    }
    /* Link color */
    $link_color_default_value = 'rgb(60 185 225 / 100%)';
    $link_hover_color_default_value = 'rgb(40 130 160 / 100%)';
    if ( is_array($options) && array_key_exists('mini_link_color', $options ) && $options['mini_link_color'] != null ) {
        $link_color_value = $options['mini_link_color'];
        $link_color_placeholder = null;
        $link_color_color = $options['mini_link_color'];
    } else {
        $link_color_value = null;
        $link_color_placeholder = $link_color_default_value;
        $link_color_color = $link_color_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_link_hover_color', $options ) && $options['mini_link_hover_color'] != null ) {
        $link_hover_color_value = $options['mini_link_hover_color'];
        $link_hover_color_placeholder = null;
        $link_hover_color_color = $options['mini_link_hover_color'];
    } else {
        $link_hover_color_value = null;
        $link_hover_color_placeholder = $link_hover_color_default_value;
        $link_hover_color_color = $link_hover_color_default_value;
    }
    /* Sheet & menu color */
    $sheet_default_value = 'rgb( 20 10 40 / 100% )';
    $menu_toggle_default_value = 'rgb( 20 10 40 / 100% )';
    if ( is_array($options) && array_key_exists('mini_sheet_color', $options ) && $options['mini_sheet_color'] != null ) {
        $sheet_color_value = $options['mini_sheet_color'];
        $sheet_color_placeholder = null;
        $sheet_color_color = $options['mini_sheet_color'];
    } else {
        $sheet_color_value = null;
        $sheet_color_placeholder = $sheet_default_value;
        $sheet_color_color = $sheet_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_menu_toggle_color', $options ) && $options['mini_menu_toggle_color'] != null ) {
        $menu_toggle_color_value = $options['mini_menu_toggle_color'];
        $menu_toggle_color_placeholder = null;
        $menu_toggle_color_color = $options['mini_menu_toggle_color'];
    } else {
        $menu_toggle_color_value = null;
        $menu_toggle_color_placeholder = $menu_toggle_default_value;
        $menu_toggle_color_color = $menu_toggle_default_value;
    }

    ?>
    <h4 class="m-0">
        Main color
    </h4>
    <input
        type="text"
        id="mini_main_color"
        name="mini_colors_options[mini_main_color]"
        value="<?= $main_color_value ?>"
        placeholder="<?= $main_color_placeholder ?>" 
        style="border: 2px solid <?=$main_color_color?>; border-right: 30px solid <?=$main_color_color?>;"
        >
    <input
        type="text"
        id="mini_main_color_dark"
        name="mini_colors_options[mini_main_color_dark]"
        value="<?= $main_color_dark_value ?>"
        placeholder="<?= $main_color_dark_placeholder ?>" 
        style="border: 2px solid <?=$main_color_dark_color?>; border-right: 30px solid <?=$main_color_dark_color?>;"
        >
    <input
        type="text"
        id="mini_main_color_transp"
        name="mini_colors_options[mini_main_color_transp]"
        value="<?= $main_color_transp_value ?>"
        placeholder="<?= $main_color_transp_placeholder ?>" 
        style="border: 2px solid <?=$main_color_transp_color?>; border-right: 30px solid <?=$main_color_transp_color?>;"
        >
    <p class="description">
        <?php esc_html_e( 'Main color, dark version and transparent version', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <h4 class="m-0">
        Second color
    </h4>
    <input
        type="text"
        id="mini_second_color"
        name="mini_colors_options[mini_second_color]"
        value="<?= $second_color_dark_value ?>"
        placeholder="<?= $second_color_dark_placeholder ?>" 
        style="border: 2px solid <?=$second_color_dark_color?>; border-right: 30px solid <?=$second_color_dark_color?>;"
        >
    <input
        type="text"
        id="mini_second_color_dark"
        name="mini_colors_options[mini_second_color_dark]"
        value="<?= $second_color_dark_value ?>"
        placeholder="<?= $second_color_dark_placeholder ?>" 
        style="border: 2px solid <?=$second_color_dark_color?>; border-right: 30px solid <?=$second_color_dark_color?>;"
        >
    <p class="description">
        <?php esc_html_e( 'Second color and dark version', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <h4 class="m-0">
        Third color
    </h4>
    <input
        type="text"
        id="mini_third_color"
        name="mini_colors_options[mini_third_color]"
        value="<?= $third_color_value ?>"
        placeholder="<?= $third_color_placeholder ?>" 
        style="border: 2px solid <?=$third_color_color?>; border-right: 30px solid <?=$third_color_color?>;"
        >
    <input
        type="text"
        id="mini_third_color_dark"
        name="mini_colors_options[mini_third_color_dark]"
        value="<?= $third_color_dark_value ?>"
        placeholder="<?= $third_color_dark_placeholder ?>" 
        style="border: 2px solid <?=$third_color_dark_color?>; border-right: 30px solid <?=$third_color_dark_color?>;"
        >
    <p class="description">
        <?php esc_html_e( 'Third color and dark version', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <h4 class="m-0">
        Fourth color
    </h4>
    <input
        type="text"
        id="mini_fourth_color"
        name="mini_colors_options[mini_fourth_color]"
        value="<?= $fourth_color_value ?>"
        placeholder="<?= $fourth_color_placeholder ?>" 
        style="border: 2px solid <?=$fourth_color_color?>; border-right: 30px solid <?=$fourth_color_color?>;"
        >
    <input
        type="text"
        id="mini_fourth_color_dark"
        name="mini_colors_options[mini_fourth_color_dark]"
        value="<?= $fourth_color_dark_value ?>"
        placeholder="<?= $fourth_color_dark_placeholder ?>" 
        style="border: 2px solid <?=$fourth_color_dark_color?>; border-right: 30px solid <?=$fourth_color_dark_color?>;"
        >
    <p class="description">
        <?php esc_html_e( 'Fourth color and dark version', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <h4 class="m-0">
        Link color
    </h4>
    <input
        type="text"
        id="mini_link_color"
        name="mini_colors_options[mini_link_color]"
        value="<?= $link_color_value ?>"
        placeholder="<?= $link_color_placeholder ?>"
        style="border: 2px solid <?=$link_color_color?>; border-right: 30px solid <?=$link_color_color?>;"
        >
    <input
        type="text"
        id="mini_link_hover_color"
        name="mini_colors_options[mini_link_hover_color]"
        value="<?= $link_hover_color_value ?>"
        placeholder="<?= $link_hover_color_placeholder ?>"
        style="border: 2px solid <?=$link_hover_color_color?>; border-right: 30px solid <?=$link_hover_color_color?>;"
        >
    <p class="description">
        <?php esc_html_e( 'Link and buttons color', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <h4 class="m-0">
        Sheet & menu colors
    </h4>
    <input
        type="text"
        id="mini_sheet_color"
        name="mini_colors_options[mini_sheet_color]"
        value="<?= $sheet_color_value ?>"
        placeholder="<?= $sheet_color_placeholder ?>"
        style="border: 2px solid <?=$sheet_color_color?>; border-right: 30px solid <?=$sheet_color_color?>;"
        >
    <input
        type="text"
        id="mini_menu_toggle_color"
        name="mini_colors_options[mini_menu_toggle_color]"
        value="<?= $menu_toggle_color_value ?>"
        placeholder="<?= $menu_toggle_color_placeholder ?>"
        style="border: 2px solid <?=$menu_toggle_color_color?>; border-right: 30px solid <?=$menu_toggle_color_color?>;"
        >
    <p class="description">
        <?php esc_html_e( 'Page second level background and menu icon color', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <?php
    $info_default_value = 'rgb(113 202 189)';
    $success_default_value = 'rgb(160 220 110)';
    $warning_default_value = 'rgb(248 187 83)';
    $danger_default_value = 'rgb(255 111 97)';
    $bad_default_value = 'rgb(235 55 80)';
    if ( is_array($options) && array_key_exists('mini_semaphore_color_info', $options ) && $options['mini_semaphore_color_info'] != null ) {
        $info_semaphore_color_value = $options['mini_semaphore_color_info'];
        $info_semaphore_color_placeholder = null;
        $info_semaphore_color_color = $options['mini_semaphore_color_info'];
    } else {
        $info_semaphore_color_value = null;
        $info_semaphore_color_placeholder = $info_default_value;
        $info_semaphore_color_color = $info_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_semaphore_color_success', $options ) && $options['mini_semaphore_color_success'] != null ) {
        $success_semaphore_color_value = $options['mini_semaphore_color_success'];
        $success_semaphore_color_placeholder = null;
        $success_semaphore_color_color = $options['mini_semaphore_color_success'];
    } else {
        $success_semaphore_color_value = null;
        $success_semaphore_color_placeholder = $success_default_value;
        $success_semaphore_color_color = $success_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_semaphore_color_warning', $options ) && $options['mini_semaphore_color_warning'] != null ) {
        $warning_semaphore_color_value = $options['mini_semaphore_color_warning'];
        $warning_semaphore_color_placeholder = null;
        $warning_semaphore_color_color = $options['mini_semaphore_color_warning'];
    } else {
        $warning_semaphore_color_value = null;
        $warning_semaphore_color_placeholder = $warning_default_value;
        $warning_semaphore_color_color = $warning_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_semaphore_color_danger', $options ) && $options['mini_semaphore_color_danger'] != null ) {
        $danger_semaphore_color_value = $options['mini_semaphore_color_danger'];
        $danger_semaphore_color_placeholder = null;
        $danger_semaphore_color_color = $options['mini_semaphore_color_danger'];
    } else {
        $danger_semaphore_color_value = null;
        $danger_semaphore_color_placeholder = $danger_default_value;
        $danger_semaphore_color_color = $danger_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_semaphore_color_bad', $options ) && $options['mini_semaphore_color_bad'] != null ) {
        $bad_semaphore_color_value = $options['mini_semaphore_color_bad'];
        $bad_semaphore_color_placeholder = null;
        $bad_semaphore_color_color = $options['mini_semaphore_color_bad'];
    } else {
        $bad_semaphore_color_value = null;
        $bad_semaphore_color_placeholder = $bad_default_value;
        $bad_semaphore_color_color = $bad_default_value;
    }
    ?>
    <h4 class="m-0">
        Semaphore colors
    </h4>
    <input
        type="text"
        id="mini_semaphore_color_info"
        name="mini_colors_options[mini_semaphore_color_info]"
        value="<?= $info_semaphore_color_value ?>"
        placeholder="<?= $info_semaphore_color_placeholder ?>"
        style="border: 2px solid <?=$info_semaphore_color_color?>; border-right: 30px solid <?=$info_semaphore_color_color?>;"
        >
    <br/>
    <br/>
    <input
        type="text"
        id="mini_semaphore_color_success"
        name="mini_colors_options[mini_semaphore_color_success]"
        value="<?= $success_semaphore_color_value ?>"
        placeholder="<?= $success_semaphore_color_placeholder ?>"
        style="border: 2px solid <?=$success_semaphore_color_color?>; border-right: 30px solid <?=$success_semaphore_color_color?>;"
        >
    <input
        type="text"
        id="mini_semaphore_color_warning"
        name="mini_colors_options[<mini_semaphore_color_warning]"
        value="<?= $warning_semaphore_color_value ?>"
        placeholder="<?= $warning_semaphore_color_placeholder ?>"
        style="border: 2px solid <?=$warning_semaphore_color_color?>; border-right: 30px solid <?=$warning_semaphore_color_color?>;"
        >
    <input
        type="text"
        id="mini_semaphore_color_danger"
        name="mini_colors_options[mini_semaphore_color_danger]"
        value="<?= $danger_semaphore_color_value ?>"
        placeholder="<?= $danger_semaphore_color_placeholder ?>"
        style="border: 2px solid <?=$danger_semaphore_color_color?>; border-right: 30px solid <?=$danger_semaphore_color_color?>;"
        >
    <br/>
    <br/>
    <input
        type="text"
        id="mini_semaphore_color_bad"
        name="mini_colors_options[mini_semaphore_color_bad]"
        value="<?= $bad_semaphore_color_value ?>"
        placeholder="<?= $bad_semaphore_color_placeholder ?>"
        style="border: 2px solid <?=$bad_semaphore_color_color?>; border-right: 30px solid <?=$bad_semaphore_color_color?>;"
        >
    <p class="description">
        <?php esc_html_e( 'Color used for semaphore logic', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <?php
    $black_default_value = 'rgb( 10 10 20 / 100% )';
    $false_black_default_value = 'rgb( 20 10 40 / 100% )';
    $dark_grey_default_value = 'rgb( 55 55 80 / 100% )';
    $grey_default_value = 'rgb( 120 120 150 / 100% )';
    $light_grey_default_value = 'rgb( 215 210 230 / 100% )';
    $false_white_default_value = 'rgb( 250 248 255 / 100% )';
    $false_white_transp_default_value = 'rgb( 0 0 0 / 3% )';
    $white_default_value = 'rgb( 255 255 255 / 100% )';
    $transp_default_value = 'rgb( 0 0 0 / 0% )';
    if ( is_array($options) && array_key_exists('mini_blacks_color_black', $options ) && $options['mini_blacks_color_black'] != null ) {
        $black_value = $options['mini_blacks_color_black']; 
        $black_placeholder = null; 
        $black_color = $options['mini_blacks_color_black'];
    } else {
        $black_value = null; 
        $black_placeholder = $black_default_value;
        $black_color = $black_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_false_black', $options ) && $options['mini_blacks_color_false_black'] != null ) {
        $false_black_value = $options['mini_blacks_color_false_black']; 
        $false_black_placeholder = null;
        $false_black_color = $options['mini_blacks_color_false_black']; 
    } else {
        $false_black_value = null; 
        $false_black_placeholder = $false_black_default_value;
        $false_black_color = $false_black_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_dark_grey', $options ) && $options['mini_blacks_color_dark_grey'] != null ) {
        $dark_grey_value = $options['mini_blacks_color_dark_grey']; 
        $dark_grey_placeholder = null;
        $dark_grey_color = $options['mini_blacks_color_dark_grey']; 
    } else {
        $dark_grey_value = null; 
        $dark_grey_placeholder = $dark_grey_default_value;
        $dark_grey_color = $dark_grey_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_grey', $options ) && $options['mini_blacks_color_grey'] != null ) {
        $grey_value = $options['mini_blacks_color_grey']; 
        $grey_placeholder = null;
        $grey_color = $options['mini_blacks_color_grey']; 
    } else {
        $grey_value = null; 
        $grey_placeholder = $grey_default_value;
        $grey_color = $grey_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_light_grey', $options ) && $options['mini_blacks_color_light_grey'] != null ) {
        $light_grey_value = $options['mini_blacks_color_light_grey']; 
        $light_grey_placeholder = null;
        $light_grey_color = $options['mini_blacks_color_light_grey']; 
    } else {
        $light_grey_value = null; 
        $light_grey_placeholder = $light_grey_default_value;
        $light_grey_color = $light_grey_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_false_white', $options ) && $options['mini_blacks_color_false_white'] != null ) {
        $false_white_value = $options['mini_blacks_color_false_white']; 
        $false_white_placeholder = null;
        $false_white_color = $options['mini_blacks_color_false_white']; 
    } else {
        $false_white_value = null; 
        $false_white_placeholder = $false_white_default_value;
        $false_white_color = $false_white_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_false_white_transp', $options ) && $options['mini_blacks_color_false_white_transp'] != null ) {
        $false_white_transp_value = $options['mini_blacks_color_false_white_transp']; 
        $false_white_transp_placeholder = null;
        $false_white_transp_color = $options['mini_blacks_color_false_white_transp']; 
    } else {
        $false_white_transp_value = null; 
        $false_white_transp_placeholder = $false_white_transp_default_value;
        $false_white_transp_color = $false_white_transp_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_white', $options ) && $options['mini_blacks_color_white'] != null ) {
        $white_value = $options['mini_blacks_color_white']; 
        $white_placeholder = null;
        $white_vcolor = $options['mini_blacks_color_white']; 
    } else {
        $white_value = null; 
        $white_placeholder = $white_default_value;
        $white_color = $white_default_value;
    }
    ?>
    <h4 class="m-0">
        Blacks
    </h4>
    <input
        type="text"
        id="mini_blacks_color_black"
        name="mini_colors_options[mini_blacks_color_black]"
        value="<?= $black_value ?>"
        placeholder="<?= $black_placeholder ?>"
        style="border: 2px solid <?=$black_placeholder?>; border-right: 30px solid <?=$black_placeholder?>;"
        >
    <input
        type="text"
        id="mini_blacks_color_false_black"
        name="mini_colors_options[mini_blacks_color_false_black]"
        value="<?= $false_black_value ?>"
        placeholder="<?= $false_black_placeholder ?>"
        style="border: 2px solid <?=$false_black_placeholder?>; border-right: 30px solid <?=$false_black_placeholder?>;"
        >
    <br/>
    <br/>
    <input
        type="text"
        id="mini_blacks_color_dark_grey"
        name="mini_colors_options[mini_blacks_color_dark_grey]"
        value="<?= $dark_grey_value ?>"
        placeholder="<?= $dark_grey_placeholder ?>"
        style="border: 2px solid <?=$dark_grey_placeholder?>; border-right: 30px solid <?=$dark_grey_placeholder?>;"
        >
    <input
        type="text"
        id="mini_blacks_color_grey"
        name="mini_colors_options[mini_blacks_color_grey]"
        value="<?= $grey_value ?>"
        placeholder="<?= $grey_placeholder ?>"
        style="border: 2px solid <?=$grey_placeholder?>; border-right: 30px solid <?=$grey_placeholder?>;"
        >
    <input
        type="text"
        id="mini_blacks_color_light_grey"
        name="mini_colors_options[mini_blacks_color_light_grey]"
        value="<?= $light_grey_value ?>"
        placeholder="<?= $light_grey_placeholder ?>"
        style="border: 2px solid <?=$light_grey_placeholder?>; border-right: 30px solid <?=$light_grey_placeholder?>;"
        >
    <br/><br/>
    <input
        type="text"
        id="mini_blacks_color_false_white"
        name="mini_colors_options[mini_blacks_color_false_white]"
        value="<?= $false_white_value ?>"
        placeholder="<?= $false_white_placeholder ?>"
        style="border: 2px solid <?=$false_white_placeholder?>; border-right: 30px solid <?=$false_white_placeholder?>;"
        >
    <input
        type="text"
        id="mini_blacks_color_false_white_transp"
        name="mini_colors_options[mini_blacks_color_false_white_transp]"
        value="<?= $false_white_transp_value ?>"
        placeholder="<?= $false_white_transp_placeholder ?>"
        style="border: 2px solid <?=$false_white_transp_placeholder?>; border-right: 30px solid <?=$false_white_transp_placeholder?>;"
        >
    <input
        type="text"
        id="mini_blacks_color_white"
        name="mini_colors_options[mini_blacks_color_white]"
        value="<?= $white_value ?>"
        placeholder="<?= $white_placeholder ?>"
        style="border: 2px solid <?=$white_placeholder?>; border-right: 30px solid <?=$white_placeholder?>;"
        >

    <p class="description">
        <?php esc_html_e( 'Greyscale', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>

    <?php
}


function mini_logo_size_field_callback( $args ) {
    $options = get_option( 'mini_size_options' );
    $default_value = '2rem';
    if ( is_array($options) && array_key_exists('mini_logo_height', $options ) && $options['mini_logo_height'] != null ) {
        $value = $options['mini_logo_height'];
        $placeholder = null;
    } else {
        $value = null;
        $placeholder = $default_value;
    }
    $default_scroll_value = '1.25rem';
    if ( is_array($options) && array_key_exists('mini_scroll_logo_height', $options ) && $options['mini_scroll_logo_height'] != null ) {
        $scroll_value = $options['mini_scroll_logo_height'];
        $scroll_placeholder = null;
    } else {
        $scroll_value = null;
        $scroll_placeholder = $default_scroll_value;
    }
    ?>
    <h4 class="">Logo height</h4>
    <input
        type="text"
        id="mini_logo_height"
        name="mini_size_options[mini_logo_height]"
        value="<?= $value ?>"
        placeholder="<?= $placeholder ?>"
    >
    <p class="description">
        <i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <h4 class="">Height when page is scrolled</h4>
    <input
        type="text"
        id="mini_scroll_logo_height"
        name="mini_size_options[mini_scroll_logo_height]"
        value="<?= $scroll_value ?>"
        placeholder="<?= $scroll_placeholder ?>"
    >
    <p class="description">
        <i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <?php
}


function mini_fonts_field_callback( $args ) {
    $options = get_option( 'mini_font_options' );
    $default_main_font = '\'Roboto\', sans-serif';
    $default_main_font_embed_link = '<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">';
    $default_main_font_state_status = '';
    if (is_array($options) && array_key_exists('mini_main_font_status', $options)) {
        if ($options['mini_main_font_status'] == true) {
            $default_main_font_state_status = 'checked';
        }
    }
    if ( is_array($options) && array_key_exists('mini_main_font', $options ) && $options['mini_main_font'] != null ) {
        $main_font_value = $options['mini_main_font'];
        $main_font_placeholder = null;
    } else {
        $main_font_value = null;
        $main_font_placeholder = $default_main_font;
    }
    if ( is_array($options) && array_key_exists('mini_main_font_embed_link', $options ) && $options['mini_main_font_embed_link'] != null ) {
        $main_font_embed_link_value = $options['mini_main_font_embed_link'];
        $main_font_embed_link_placeholder = null;
    } else {
        $main_font_embed_link_value = null;
        $main_font_embed_link_placeholder = $default_main_font_embed_link;
    }

    $default_secondary_font = '\'Oswald\', sans-serif';
    $default_secondary_font_embed_link = '<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">';
    $default_secondary_font_state_status = '';
    if (is_array($options) && array_key_exists('mini_secondary_font_status', $options)) {
        if ($options['mini_secondary_font_status'] == true) {
            $default_secondary_font_state_status = 'checked';
        }
    }
    if ( is_array($options) && array_key_exists('mini_secondary_font', $options ) && $options['mini_secondary_font'] != null ) {
        $secondary_font_value = $options['mini_secondary_font'];
        $secondary_font_placeholder = null;
    } else {
        $secondary_font_value = null;
        $secondary_font_placeholder = $default_secondary_font;
    }
    if ( is_array($options) && array_key_exists('mini_secondary_font_embed_link', $options ) && $options['mini_secondary_font_embed_link'] != null ) {
        $secondary_font_embed_link_value = $options['mini_secondary_font_embed_link'];
        $secondary_font_embed_link_placeholder = null;
    } else {
        $secondary_font_embed_link_value = null;
        $secondary_font_embed_link_placeholder = $default_secondary_font_embed_link;
    }

    $default_serif_font = '\'Playfair Display\', serif';
    $default_serif_font_embed_link = '<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">';
    $default_serif_font_state_status = '';
    if (is_array($options) && array_key_exists('mini_serif_font_status', $options)) {
        if ($options['mini_serif_font_status'] == true) {
            $default_serif_font_state_status = 'checked';
        }
    }
    if ( is_array($options) && array_key_exists('mini_serif_font', $options ) && $options['mini_serif_font'] != null ) {
        $serif_font_value = $options['mini_serif_font'];
        $serif_font_placeholder = null;
    } else {
        $serif_font_value = null;
        $serif_font_placeholder = $default_serif_font;
    }
    if ( is_array($options) && array_key_exists('mini_serif_font_embed_link', $options ) && $options['mini_serif_font_embed_link'] != null ) {
        $serif_font_embed_link_value = $options['mini_serif_font_embed_link'];
        $serif_font_embed_link_placeholder = null;
    } else {
        $serif_font_embed_link_value = null;
        $serif_font_embed_link_placeholder = $default_serif_font_embed_link;
    }

    $default_mono_font = '\'Roboto Mono\', monospace';
    $default_mono_font_embed_link = '<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">';
    $default_mono_font_state_status = '';
    if (is_array($options) && array_key_exists('mini_mono_font_status', $options)) {
        if ($options['mini_handwriting_font_status'] == true) {
            $default_mono_font_state_status = 'checked';
        }
    }
    if ( is_array($options) && array_key_exists('mini_mono_font', $options ) && $options['mini_mono_font'] != null ) {
        $mono_font_value = $options['mini_mono_font'];
        $mono_font_placeholder = null;
    } else {
        $mono_font_value = null;
        $mono_font_placeholder = $default_mono_font;
    }
    if ( is_array($options) && array_key_exists('mini_mono_font_embed_link', $options ) && $options['mini_mono_font_embed_link'] != null ) {
        $mono_font_embed_link_value = $options['mini_mono_font_embed_link'];
        $mono_font_embed_link_placeholder = null;
    } else {
        $mono_font_embed_link_value = null;
        $mono_font_embed_link_placeholder = $default_mono_font_embed_link;
    }

    $default_handwriting_font = '\'Edu VIC WA NT Beginner\', serif';
    $default_handwriting_font_embed_link = '<link href="https://fonts.googleapis.com/css2?family=Edu+VIC+WA+NT+Beginner:wght@400..700&display=swap" rel="stylesheet">';
    $default_handwriting_font_state_status = '';
    if (is_array($options) && array_key_exists('mini_handwriting_font_status', $options)) {
        if ($options['mini_handwriting_font_status'] == true) {
            $default_handwriting_font_state_status = 'checked';
        }
    }
    if ( is_array($options) && array_key_exists('mini_handwriting_font', $options ) && $options['mini_handwriting_font'] != null ) {
        $handwriting_font_value = $options['mini_handwriting_font'];
        $handwriting_font_placeholder = null;
    } else {
        $handwriting_font_value = null;
        $handwriting_font_placeholder = $default_handwriting_font;
    }
    if ( is_array($options) && array_key_exists('mini_handwriting_font_embed_link', $options ) && $options['mini_handwriting_font_embed_link'] != null ) {
        $handwriting_font_embed_link_value = $options['mini_handwriting_font_embed_link'];
        $handwriting_font_embed_link_placeholder = null;
    } else {
        $handwriting_font_embed_link_value = null;
        $handwriting_font_embed_link_placeholder = $default_handwriting_font_embed_link;
    }

    ?>
    <h4 class="">
        <?php esc_html_e( 'Main font', 'mini' ); ?>
    </h4>
    <?php /*
    <input
        type="checkbox"
        id="mini_main_font_status"
        name="mini_font_options[mini_main_font_status]"
        <?=$default_main_font_state_status?>
    >
    <br/>
    <br/>
    */ ?>
    <input
        type="text"
        id="mini_main_font"
        name="mini_font_options[mini_main_font]"
        value="<?= $main_font_value ?>"
        placeholder="<?= $main_font_placeholder ?>"
        >
    <br/>
    <br/>
    <input
        type="text"
        id="mini_main_font_embed_link"
        name="mini_font_options[mini_main_font_embed_link]"
        value="<?= htmlspecialchars($main_font_embed_link_value); ?>"
        placeholder="<?= htmlspecialchars($main_font_embed_link_placeholder); ?>"
        style="width: 100%;"
        >
    <p class="description">
        <?php esc_html_e( 'Used for paragraphs and most of the website\'s content. Sans Serif.', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<b><?php esc_html_e( 'Enabled by default.', 'mini' ); ?></b>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>

    <h4 class="">
        <?php esc_html_e( 'Secondary font', 'mini' ); ?>
    </h4>
    <?php /*
    <input
        type="checkbox"
        id="mini_secondary_font_status"
        name="mini_font_options[mini_secondary_font_status]"
        <?=$default_secondary_font_state_status?>
    >
    <br/>
    <br/>
    */ ?>
    <input
        type="text"
        id="mini_secondary_font"
        name="mini_font_options[mini_secondary_font]"
        value="<?= $secondary_font_value ?>"
        placeholder="<?= $secondary_font_placeholder ?>"
        >
    <br/>
    <br/>
    <input
        type="text"
        id="mini_secondary_font_embed_link"
        name="mini_font_options[mini_secondary_font_embed_link]"
        value="<?= htmlspecialchars($secondary_font_embed_link_value); ?>"
        placeholder="<?= htmlspecialchars($secondary_font_embed_link_placeholder); ?>"
        style="width: 100%;"
        >
    <p class="description">
        <?php esc_html_e( 'Alternative font, used for titles and in CSS class ".font-two"', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<b><?php esc_html_e( 'Enabled by default.', 'mini' ); ?></b>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>

    <h4 class="">
        <?php esc_html_e( 'Serif font', 'mini' ); ?>
    </h4>
    <input
        type="checkbox"
        id="mini_serif_font_status"
        name="mini_font_options[mini_serif_font_status]"
        <?=$default_serif_font_state_status?>
    >
    <br/>
    <br/>
    <input
        type="text"
        id="mini_serif_font"
        name="mini_font_options[mini_serif_font]"
        value="<?= $serif_font_value ?>"
        placeholder="<?= $serif_font_placeholder ?>"
        >
    <br/>
    <br/>
    <input
        type="text"
        id="mini_serif_font_embed_link"
        name="mini_font_options[mini_serif_font_embed_link]"
        value="<?= htmlspecialchars($serif_font_embed_link_value); ?>"
        placeholder="<?= htmlspecialchars($serif_font_embed_link_placeholder); ?>"
        style="width: 100%;"
        >
    <p class="description">
        <?php esc_html_e( 'Serif font, used in CSS class ".serif"', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    
    <h4 class="">
        <?php esc_html_e( 'Mono font', 'mini' ); ?>
    </h4>
    <input
        type="checkbox"
        id="mini_mono_font_status"
        name="mini_font_options[mini_mono_font_status]"
        <?=$default_mono_font_state_status?>
    >
    <br/>
    <br/>
    <input
        type="text"
        id="mini_mono_font"
        name="mini_font_options[mini_mono_font]"
        value="<?= $mono_font_value ?>"
        placeholder="<?= $mono_font_placeholder ?>"
        >
    <br/>
    <br/>
    <input
        type="text"
        id="mini_mono_font_embed_link"
        name="mini_font_options[mini_mono_font_embed_link]"
        value="<?= htmlspecialchars($mono_font_embed_link_value); ?>"
        placeholder="<?= htmlspecialchars($mono_font_embed_link_placeholder); ?>"
        style="width: 100%;"
        >
    <p class="description">
        <?php esc_html_e( 'Monospace font, used in CSS class ".mono"', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>

    <h4 class="">
        <?php esc_html_e( 'Handwriting font', 'mini' ); ?>
    </h4>
    <input
        type="checkbox"
        id="mini_handwriting_font_status"
        name="mini_font_options[mini_handwriting_font_status]"
        <?=$default_handwriting_font_state_status?>
    >
    <br/>
    <br/>
    <input
        type="text"
        id="mini_handwriting_font"
        name="mini_font_options[mini_handwriting_font]"
        value="<?= $handwriting_font_value ?>"
        placeholder="<?= $handwriting_font_placeholder ?>"
        style="width: 33.333333%;"
    >
    <br/>
    <br/>
    <input
        type="text"
        id="mini_handwriting_font_embed_link"
        name="mini_font_options[mini_handwriting_font_embed_link]"
        value="<?= htmlspecialchars($handwriting_font_embed_link_value); ?>"
        placeholder="<?= htmlspecialchars($handwriting_font_embed_link_placeholder); ?>"
        style="width: 100%;"
    >
    <p class="description">
        <?php esc_html_e( 'Handwriting font, used in CSS class ".handwriting"', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>

    <?php
}


function mini_ext_lib_field_callback( $args ) {
    $options = get_option( 'mini_ext_lib_options' );
    $default_ext_lib_aos_status = '';
    if (is_array($options) && array_key_exists('mini_aos', $options)) {
        if ($options['mini_aos'] == true) {
            $default_ext_lib_aos_status = 'checked';
        }
    }
    ?>
    <h4 class="">AOS</h4>
    <input
        type="checkbox"
        id="mini_aos"
        name="mini_ext_lib_options[mini_aos]"
        <?=$default_ext_lib_aos_status?>
    >
    <br/>
    <br/>
    <hr>
    <?php
    $default_ext_lib_iconoir_status = '';
    if (is_array($options) && array_key_exists('mini_iconoir', $options)) {
        if ($options['mini_iconoir'] == true) {
            $default_ext_lib_iconoir_status = 'checked';
        }
    }
    ?>
    <h4 class="">Iconoir</h4>
    <input
        type="checkbox"
        id="mini_iconoir"
        name="mini_ext_lib_options[mini_iconoir]"
        <?=$default_ext_lib_iconoir_status?>
    >
    <br/>
    <br/>
    <hr>
    <?php
    $default_ext_lib_fontawesome_status = '';
    if (is_array($options) && array_key_exists('mini_fontawesome', $options)) {
        if ($options['mini_fontawesome'] == true) {
            $default_ext_lib_fontawesome_status = 'checked';
        }
    }
    ?>
    <h4 class="">Fontawesome</h4>
    <input
        type="checkbox"
        id="mini_fontawesome"
        name="mini_ext_lib_options[mini_fontawesome]"
        <?=$default_ext_lib_fontawesome_status?>
    >
    <br/>
    <br/>
    <hr>
    <?php
}


function mini_analytics_field_callback( $args ) {
    $options = get_option( 'mini_analytics_options' );
    $default_google_analytics_status = '';
    if (is_array($options) && array_key_exists('mini_google_analytics', $options)) {
        if ($options['mini_google_analytics'] == true) {
            $google_analytics_status = 'checked';
        }
    }
    $default_google_analytics_code_default_value = 'Insert here Google Analytics G- code';
    if ( is_array($options) && array_key_exists('mini_google_analytics_code', $options ) && $options['mini_google_analytics_code'] != null ) {
        $google_analytics_code_value = $options['mini_google_analytics_code'];
        $google_analytics_code_placeholder = null;
    } else {
        $google_analytics_code_value = null;
        $google_analytics_code_placeholder = $default_google_analytics_code_default_value;
    }
    ?>
    <h4 class="">Google Analytics</h4>
    <input
        type="checkbox"
        id="mini_google_analytics"
        name="mini_analytics_options[mini_google_analytics]"
        <?=$google_analytics_status?>
    >
    <br/>
    <br/>
    <input
        type="text"
        id="mini_google_analytics_code"
        name="mini_analytics_options[mini_google_analytics_code]"
        value="<?= $google_analytics_code_value ?>"
        placeholder="<?= $google_analytics_code_placeholder ?>"
        style="width: 33.333333%;"
    >
    <br/>
    <br/>
    <hr>
    <?php
}


/**
 * Add the top level menu page.
 */
function mini_options_page() {
    add_menu_page(
        'mini options',
        'mini',
        'manage_options',
        'mini',
        'mini_options_page_html',
        'dashicons-carrot'
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
        'Color options',
        'Colors',
        'manage_options',
        'mini-colors',
        'mini_color_options_page_html'
    );
    add_submenu_page(
        'mini',
        'Font options',
        'Fonts',
        'manage_options',
        'mini-fonts',
        'mini_font_options_page_html'
    );
    add_submenu_page(
        'mini',
        'Size options',
        'Sizes',
        'manage_options',
        'mini-size',
        'mini_size_options_page_html'
    );
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
        <p class=""><span class="bold">mini</span> is a frontend framework.</p>
        <!--
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
        -->
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

// Colors options page
function mini_color_options_page_html() {
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
            settings_fields( 'mini_colors' );
            do_settings_sections( 'mini-colors' );
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

// Sizes options page
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



// Adding .css from CDN or from ext source or from local theme folder
add_action( 'wp_enqueue_scripts', 'mini_css' );
function mini_css(){
    $options = get_option( 'mini_cdn_options' );
    if (is_array($options) && array_key_exists('cdn', $options) && $options['cdn'] != null) {
        $mini_CSS = 'https://cdn.jsdelivr.net/gh/giacomorizzotti/mini@main/css/mini.min.css';
        $mini_CSS = 'https://mini.uwa.agency/css/mini.min.css';
    } else {
        if (is_array($options) && array_key_exists('css_cdn_url', $options) && $options['css_cdn_url'] != null) {
            $mini_CSS = $options['css_cdn_url'];
        } else {
            $mini_CSS = get_stylesheet_directory_uri().'/mini/mini.min.css';
        }
    }
    wp_enqueue_style( 'wp_header', $mini_CSS, array(), _S_VERSION);
}

// Adding .js from CDN or from ext source or from local theme folder
add_action( 'wp_enqueue_scripts', 'mini_js' );

function mini_js(){
    $options = get_option( 'mini_cdn_options' );
    if (is_array($options) && array_key_exists('cdn', $options) && $options['cdn'] != null) {
        $mini_JS = 'https://cdn.jsdelivr.net/gh/giacomorizzotti/mini@main/js/mini.js';
        $mini_JS = 'https://mini.uwa.agency/js/mini.js';
    } else {
        if (is_array($options) && array_key_exists('js_cdn_url', $options) && $options['js_cdn_url'] != null) {
            $mini_JS = $options['js_cdn_url'];
        } else {
            $mini_JS = get_stylesheet_directory_uri().'/mini/mini.js';
        }
    }
    wp_enqueue_script( 'wp_footer', $mini_JS, array(), _S_VERSION, true);
}

// Adding Google Web Fonts
add_action( 'wp_head', 'themeprefix_load_fonts' ); 
function themeprefix_load_fonts() { 
    ?> 
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php
}
add_action( 'wp_enqueue_scripts', 'mini_main_gwf_font' );
function mini_main_gwf_font(){
    $options = get_option( 'mini_font_options' );
    if (is_array($options) && array_key_exists('mini_main_font_embed_link', $options) && $options['mini_main_font_embed_link'] != null) {
        $main_font_gwf_embed_link = $options['mini_main_font_embed_link'] ;
    } else {
        $main_font_gwf_embed_link = 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap';
    }
    wp_enqueue_style( 'wp_header', $main_font_gwf_embed_link, array(), _S_VERSION);
}
add_action( 'wp_enqueue_scripts', 'mini_secondary_gwf_font' );
function mini_secondary_gwf_font(){
    $options = get_option( 'mini_font_options' );
    if (is_array($options) && array_key_exists('mini_secondary_font_embed_link', $options) && $options['mini_secondary_font_embed_link'] != null) {
        $secondary_font_gwf_embed_link = $options['mini_secondary_font_embed_link'] ;
    } else {
        $secondary_font_gwf_embed_link = 'https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap';
    }
    wp_enqueue_style( 'wp_header', $secondary_font_gwf_embed_link, array(), _S_VERSION);
}
add_action( 'wp_enqueue_scripts', 'mini_serif_gwf_font' );
function mini_serif_gwf_font(){
    $options = get_option( 'mini_font_options' );
    if (is_array($options) && array_key_exists('mini_serif_font_embed_link', $options) && $options['mini_serif_font_embed_link'] != null) {
        $serif_font_gwf_embed_link = $options['mini_serif_font_embed_link'] ;
    } else {
        $serif_font_gwf_embed_link = 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap';
    }
    wp_enqueue_style( 'wp_header', $serif_font_gwf_embed_link, array(), _S_VERSION);
}
add_action( 'wp_enqueue_scripts', 'mini_mono_gwf_font' );
function mini_mono_gwf_font(){
    $options = get_option( 'mini_font_options' );
    if (is_array($options) && array_key_exists('mini_mono_font_embed_link', $options) && $options['mini_mono_font_embed_link'] != null) {
        $mono_font_gwf_embed_link = $options['mini_mono_font_embed_link'] ;
    } else {
        $mono_font_gwf_embed_link = 'https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap';
    }
    wp_enqueue_style( 'wp_header', $mono_font_gwf_embed_link, array(), _S_VERSION);
}
add_action( 'wp_enqueue_scripts', 'mini_handwriting_gwf_font' );
function mini_handwriting_gwf_font(){
    $options = get_option( 'mini_font_options' );
    if (is_array($options) && array_key_exists('mini_handwriting_font_embed_link', $options) && $options['mini_handwriting_font_embed_link'] != null) {
        $handwriting_font_gwf_embed_link = $options['mini_handwriting_font_embed_link'] ;
    } else {
        $handwriting_font_gwf_embed_link = 'https://fonts.googleapis.com/css2?family=Edu+VIC+WA+NT+Beginner:wght@400..700&display=swap';
    }
    wp_enqueue_style( 'wp_header', $handwriting_font_gwf_embed_link, array(), _S_VERSION);
}