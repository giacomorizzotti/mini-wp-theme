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
    define( '_S_VERSION', '2.0.0' );
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
            'main-menu' => esc_html__( 'Header', 'mini' ),
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
        'mini_main_color', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'Main color', 'mini' ),
        'mini_main_color_callback',
        'mini-colors',
        'mini_colors_section',
        array(
            'label_for'         => 'mini_main_color',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
    );
    add_settings_field(
        'mini_second_color', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'Second color', 'mini' ),
        'mini_second_color_callback',
        'mini-colors',
        'mini_colors_section',
        array(
            'label_for'         => 'mini_second_color',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
    );
    add_settings_field(
        'mini_third_color', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'Third color', 'mini' ),
        'mini_third_color_callback',
        'mini-colors',
        'mini_colors_section',
        array(
            'label_for'         => 'mini_third_color',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
    );
    add_settings_field(
        'mini_fourth_color', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'Fourth color', 'mini' ),
        'mini_fourth_color_callback',
        'mini-colors',
        'mini_colors_section',
        array(
            'label_for'         => 'mini_fourth_color',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
    );
    add_settings_field(
        'mini_link_color', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'Link color', 'mini' ),
        'mini_link_color_callback',
        'mini-colors',
        'mini_colors_section',
        array(
            'label_for'         => 'mini_link_color',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
    );
    add_settings_field(
        'mini_sheet_color', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'Sheet color', 'mini' ),
        'mini_sheet_color_callback',
        'mini-colors',
        'mini_colors_section',
        array(
            'label_for'         => 'mini_sheet_color',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
    );
    add_settings_field(
        'mini_semaphore_color', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'Semaphore color', 'mini' ),
        'mini_semaphore_color_callback',
        'mini-colors',
        'mini_colors_section',
        array(
            'label_for'         => 'mini_semaphore_color',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
    );
    add_settings_field(
        'mini_blacks_color', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'Blacks', 'mini' ),
        'mini_blacks_color_callback',
        'mini-colors',
        'mini_colors_section',
        array(
            'label_for'         => 'mini_blacks_color',
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
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is the Colors section', 'mini' ); ?></p>
    <?php
}
function mini_size_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is the Size section', 'mini' ); ?></p>
    <?php
}
function mini_font_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is the Font section', 'mini' ); ?></p>
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

function mini_main_color_callback( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'mini_colors_options' );
    $default_value = 'rgb(60 90 255 / 100%)';
    $default_value_dark = 'rgb(50 75 180 / 100%)';
    $default_value_transp = 'rgb( 60 90 255 / 20% )';
    if ( 
        is_array($options) && array_key_exists('mini_main_color', $options ) && $options['mini_main_color'] != null
    ) {
        $value = $options['mini_main_color'];
        $placeholder = null;
    } else {
        $value = null;
        $placeholder = $default_value;
    }
    if ( 
        is_array($options) && array_key_exists('mini_main_color_dark', $options ) && $options['mini_main_color_dark'] != null 
    ) {
        $value_dark = $options['mini_main_color_dark'];
        $placeholder_dark = null;
    } else {
        $value_dark = null;
        $placeholder_dark = $default_value_dark;
    }
    if ( 
        is_array($options) && array_key_exists('mini_main_color_transp', $options ) && $options['mini_main_color_transp'] != null 
    ) {
        $value_transp = $options['mini_main_color_transp'];
        $placeholder_transp = null;
    } else {
        $value_transp = null;
        $placeholder_transp = $default_value_transp;
    }
    ?>
    <input
            type="text"
            id="mini_main_color"
            name="mini_colors_options[mini_main_color]"
            value="<?= $value ?>"
            placeholder="<?= $placeholder ?>" 
            style="border: 2px solid <?=$placeholder?>; border-right: 30px solid <?=$placeholder?>;">
    <input 
            type="text"
            id="mini_main_color_dark"
            name="mini_colors_options[mini_main_color_dark]"
            value="<?= $value_dark ?>"
            placeholder="<?= $placeholder_dark ?>" 
            style="border: 2px solid <?=$placeholder_dark?>; border-right: 30px solid <?=$placeholder_dark?>;">
    <input
            type="text"
            id="mini_main_color_transp"
            name="mini_colors_options[mini_main_color_transp]"
            value="<?= $value_transp ?>"
            placeholder="<?= $placeholder_transp ?>" 
            style="border: 2px solid <?=$placeholder_transp?>; border-right: 30px solid <?=$placeholder_transp?>;">
    <p class="description">
        <?php esc_html_e( 'Main color, dark version and transparent version', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <?php
}
function mini_second_color_callback( $args ) {
    $options = get_option( 'mini_colors_options' );
    $default_value = 'rgb(50 75 180 / 100%)';
    $default_value_dark = 'rgb(37 56 133 / 100%)';
    if ( 
        is_array($options) && array_key_exists('mini_second_color', $options ) && $options['mini_second_color'] != null
    ) {
        $value = $options['mini_second_color'];
        $placeholder = null;
        $value = $border_color['mini_second_color'];
    } else {
        $value = null;
        $placeholder = $default_value;
        $value = $default_value;
    }
    if ( 
        is_array($options) && array_key_exists('mini_second_color_dark', $options ) && $options['mini_second_color_dark'] != null
    ) {
        $value_dark = $options['mini_second_color_dark'];
        $placeholder_dark = null;
    } else {
        $value_dark = null;
        $placeholder_dark = $default_value_dark;
    }
    ?>
    <input
            type="text"
            id="mini_second_color"
            name="mini_colors_options[mini_second_color]"
            value="<?= $value ?>"
            placeholder="<?= $placeholder ?>" 
            style="border: 2px solid <?=$default_value?>; border-right: 30px solid <?=$default_value?>;">
    <input
            type="text"
            id="mini_second_color_dark"
            name="mini_colors_options[mini_second_color_dark]"
            value="<?= $value_dark ?>"
            placeholder="<?= $placeholder_dark ?>" 
            style="border: 2px solid <?=$placeholder_dark?>; border-right: 30px solid <?=$placeholder_dark?>;">
    <p class="description">
        <?php esc_html_e( 'Second color and dark version', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <?php
}
function mini_third_color_callback( $args ) {
    $options = get_option( 'mini_colors_options' );
    $default_value = 'rgb(60 30 99 / 100%)';
    $default_value_dark = 'rgb(34 15 61 / 100%)';
    if ( is_array($options) && array_key_exists('mini_third_color', $options ) && $options['mini_third_color'] != null ) {
        $value = $options['mini_third_color'];
        $placeholder = null;
    } else {
        $value = null;
        $placeholder = $default_value;
    }
    if ( is_array($options) && array_key_exists('mini_third_color_dark', $options ) && $options['mini_third_color_dark'] != null ) {
        $value_dark = $options['mini_third_color_dark'];
        $placeholder_dark = null;
    } else {
        $value_dark = null;
        $placeholder_dark = $default_value_dark;
    }
    ?>
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $value ?>"
            placeholder="<?= $placeholder ?>" 
            style="border: 2px solid <?=$placeholder?>; border-right: 30px solid <?=$placeholder?>;">
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $value_dark ?>"
            placeholder="<?= $placeholder_dark ?>" 
            style="border: 2px solid <?=$placeholder_dark?>; border-right: 30px solid <?=$placeholder_dark?>;">
    <p class="description">
        <?php esc_html_e( 'Third color and dark version', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <?php
}
function mini_fourth_color_callback( $args ) {
    $options = get_option( 'mini_colors_options' );
    $default_value = 'rgb(220 230 0 / 100%)';
    $default_value_dark = 'rgb(180 190 0 / 100%)';
    if ( is_array($options) && array_key_exists('mini_fourth_color', $options ) && $options['mini_fourth_color'] != null ) {
        $value = $options['mini_fourth_color'];
        $placeholder = null;
    } else {
        $value = null;
        $placeholder = $default_value;
    }
    if ( is_array($options) && array_key_exists('mini_fourth_color_dark', $options ) && $options['mini_fourth_color_dark'] != null ) {
        $value_dark = $options['mini_fourth_color_dark'];
        $placeholder_dark = null;
    } else {
        $value_dark = null;
        $placeholder_dark = $default_value_dark;
    }
    ?>
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $value ?>"
            placeholder="<?= $placeholder ?>" 
            style="border: 2px solid <?=$placeholder?>; border-right: 30px solid <?=$placeholder?>;">
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $value_dark ?>"
            placeholder="<?= $placeholder_dark ?>" 
            style="border: 2px solid <?=$placeholder_dark?>; border-right: 30px solid <?=$placeholder_dark?>;">
    <p class="description">
        <?php esc_html_e( 'Fourth color and dark version', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <?php
}
function mini_link_color_callback( $args ) {
    $options = get_option( 'mini_colors_options' );
    $default_value = 'rgb(60 185 225 / 100%)';
    $default_value_hover = 'rgb(40 130 160 / 100%)';
    if ( is_array($options) && array_key_exists('mini_link_color', $options ) && $options['mini_link_color'] != null ) {
        $value = $options['mini_link_color'];
        $placeholder = null;
    } else {
        $value = null;
        $placeholder = $default_value;
    }
    if ( is_array($options) && array_key_exists('mini_link_hover_color', $options ) && $options['mini_link_hover_color'] != null ) {
        $value_hover = $options['mini_link_hover_color'];
        $placeholder_hover = null;
    } else {
        $value_hover = null;
        $placeholder_hover = $default_value_hover;
    }
    ?>
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $value ?>"
            placeholder="<?= $placeholder ?>"
            style="border: 2px solid <?=$placeholder?>; border-right: 30px solid <?=$placeholder?>;">
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $value_hover ?>"
            placeholder="<?= $placeholder_hover ?>"
            style="border: 2px solid <?=$placeholder_dark?>; border-right: 30px solid <?=$placeholder_dark?>;">
    <p class="description">
        <?php esc_html_e( 'Link and buttons color', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <?php
}
function mini_sheet_color_callback( $args ) {
    $options = get_option( 'mini_colors_options' );
    $default_sheet_value = 'rgb( 20 10 40 / 100% )';
    $default_menu_toggle_value = 'rgb( 20 10 40 / 100% )';
    if ( is_array($options) && array_key_exists('mini_sheet_color', $options ) && $options['mini_sheet_color'] != null ) {
        $sheet_value = $options['mini_sheet_color'];
        $sheet_placeholder = null;
    } else {
        $sheet_value = null;
        $sheet_placeholder = $default_sheet_value;
    }
    if ( is_array($options) && array_key_exists('mini_menu_toggle_color', $options ) && $options['mini_menu_toggle_color'] != null ) {
        $menu_toggle_value = $options['mini_menu_toggle_color'];
        $menu_toggle_placeholder = null;
    } else {
        $menu_toggle_value = null;
        $menu_toggle_placeholder = $default_menu_toggle_value;
    }
    ?>
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $sheet_value ?>"
            placeholder="<?= $sheet_placeholder ?>"
            style="border: 2px solid <?=$placeholder?>; border-right: 30px solid <?=$sheet_placeholder?>;">
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $menu_toggle_value ?>"
            placeholder="<?= $menu_toggle_placeholder ?>"
            style="border: 2px solid <?=$placeholder?>; border-right: 30px solid <?=$menu_toggle_placeholder?>;">
    <p class="description">
        <?php esc_html_e( 'Page second level background and menu icon color', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <?php
}
function mini_semaphore_color_callback( $args ) {
    $options = get_option( 'mini_colors_options' );
    $info_default_value = 'rgb(113 202 189)';
    $success_default_value = 'rgb(160 220 110)';
    $warning_default_value = 'rgb(248 187 83)';
    $danger_default_value = 'rgb(255 111 97)';
    $bad_default_value = 'rgb(235 55 80)';
    if ( is_array($options) && array_key_exists('mini_semaphore_color_info', $options ) && $options['mini_semaphore_color_info'] != null ) {
        $info_value = $options['mini_semaphore_color_info'];
        $info_placeholder = null;
    } else {
        $info_value = null;
        $info_placeholder = $info_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_semaphore_color_success', $options ) && $options['mini_semaphore_color_success'] != null ) {
        $success_value = $options['mini_semaphore_color_success'];
        $success_placeholder = null;
    } else {
        $success_value = null;
        $success_placeholder = $success_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_semaphore_color_warning', $options ) && $options['mini_semaphore_color_warning'] != null ) {
        $warning_value = $options['mini_semaphore_color_warning'];
        $warning_placeholder = null;
    } else {
        $warning_value = null;
        $warning_placeholder = $warning_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_semaphore_color_danger', $options ) && $options['mini_semaphore_color_danger'] != null ) {
        $danger_value = $options['mini_semaphore_color_danger'];
        $danger_placeholder = null;
    } else {
        $danger_value = null;
        $danger_placeholder = $danger_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_semaphore_color_bad', $options ) && $options['mini_semaphore_color_bad'] != null ) {
        $bad_value = $options['mini_semaphore_color_bad'];
        $bad_placeholder = null;
    } else {
        $bad_value = null;
        $bad_placeholder = $bad_default_value;
    }
    ?>
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $info_value ?>"
            placeholder="<?= $info_placeholder ?>"
            style="border: 2px solid <?=$info_placeholder?>; border-right: 30px solid <?=$info_placeholder?>;">
    <br/>
    <br/>
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $success_value ?>"
            placeholder="<?= $success_placeholder ?>"
            style="border: 2px solid <?=$success_placeholder?>; border-right: 30px solid <?=$success_placeholder?>;">
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $warning_value ?>"
            placeholder="<?= $warning_placeholder ?>"
            style="border: 2px solid <?=$warning_placeholder?>; border-right: 30px solid <?=$warning_placeholder?>;">
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $danger_value ?>"
            placeholder="<?= $danger_placeholder ?>"
            style="border: 2px solid <?=$danger_placeholder?>; border-right: 30px solid <?=$danger_placeholder?>;">
    <br/>
    <br/>
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $bad_value ?>"
            placeholder="<?= $bad_placeholder ?>"
            style="border: 2px solid <?=$bad_placeholder?>; border-right: 30px solid <?=$bad_placeholder?>;">
    <p class="description">
        <?php esc_html_e( 'Color used for semaphore logic', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <?php
}
function mini_blacks_color_callback( $args ) {
    $options = get_option( 'mini_colors_options' );
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
        $black_value = $options['mini_blacks_color_black']; $black_placeholder = null;
    } else {
        $black_value = null; $black_placeholder = $black_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_false_black', $options ) && $options['mini_blacks_color_false_black'] != null ) {
        $false_black_value = $options['mini_blacks_color_false_black']; $false_black_placeholder = null;
    } else {
        $false_black_value = null; $false_black_placeholder = $false_black_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_dark_grey', $options ) && $options['mini_blacks_color_dark_grey'] != null ) {
        $dark_grey_default_value_value = $options['mini_blacks_color_dark_grey']; $dark_grey_default_value_placeholder = null;
    } else {
        $dark_grey_value = null; $dark_grey_placeholder = $dark_grey_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_grey', $options ) && $options['mini_blacks_color_grey'] != null ) {
        $grey_value = $options['mini_blacks_color_grey']; $grey_placeholder = null;
    } else {
        $grey_value = null; $grey_placeholder = $grey_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_light_grey', $options ) && $options['mini_blacks_color_light_grey'] != null ) {
        $light_grey_value = $options['mini_blacks_color_light_grey']; $light_grey_placeholder = null;
    } else {
        $light_grey_value = null; $light_grey_placeholder = $light_grey_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_false_white', $options ) && $options['mini_blacks_color_false_white'] != null ) {
        $false_white_value = $options['mini_blacks_color_false_white']; $false_white_placeholder = null;
    } else {
        $false_white_value = null; $false_white_placeholder = $false_white_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_false_white_transp', $options ) && $options['mini_blacks_color_false_white_transp'] != null ) {
        $false_white_transp_value = $options['mini_blacks_color_false_white_transp']; $false_white_transp_placeholder = null;
    } else {
        $false_white_transp_value = null; $false_white_transp_placeholder = $false_white_transp_default_value;
    }
    if ( is_array($options) && array_key_exists('mini_blacks_color_white', $options ) && $options['mini_blacks_color_white'] != null ) {
        $white_value = $options['mini_blacks_color_white']; $white_placeholder = null;
    } else {
        $white_value = null; $white_placeholder = $white_default_value;
    }
    /*
    if ( is_array($options) && array_key_exists('mini_blacks_color_transp', $options ) && $options['mini_blacks_color_transp'] != null ) {
        $transp_value = $options['mini_blacks_color_transp']; $transp_placeholder = null;
    } else {
        $transp_value = null; $transp_placeholder = $transp_default_value;
    }*/
    ?>
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $black_value ?>"
            placeholder="<?= $black_placeholder ?>"
            style="border: 2px solid <?=$black_placeholder?>; border-right: 30px solid <?=$black_placeholder?>;">
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $false_black_value ?>"
            placeholder="<?= $false_black_placeholder ?>"
            style="border: 2px solid <?=$false_black_placeholder?>; border-right: 30px solid <?=$false_black_placeholder?>;">
    <br/>
    <br/>
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $dark_grey_value ?>"
            placeholder="<?= $dark_grey_placeholder ?>"
            style="border: 2px solid <?=$dark_grey_placeholder?>; border-right: 30px solid <?=$dark_grey_placeholder?>;">
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $grey_value ?>"
            placeholder="<?= $grey_placeholder ?>"
            style="border: 2px solid <?=$grey_placeholder?>; border-right: 30px solid <?=$grey_placeholder?>;">
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $light_grey_value ?>"
            placeholder="<?= $light_grey_placeholder ?>"
            style="border: 2px solid <?=$light_grey_placeholder?>; border-right: 30px solid <?=$light_grey_placeholder?>;">
    <br/><br/>
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $false_white_value ?>"
            placeholder="<?= $false_white_placeholder ?>"
            style="border: 2px solid <?=$false_white_placeholder?>; border-right: 30px solid <?=$false_white_placeholder?>;">
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $false_white_transp_value ?>"
            placeholder="<?= $false_white_transp_placeholder ?>"
            style="border: 2px solid <?=$false_white_transp_placeholder?>; border-right: 30px solid <?=$false_white_transp_placeholder?>;">
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $white_value ?>"
            placeholder="<?= $white_placeholder ?>"
            style="border: 2px solid <?=$white_placeholder?>; border-right: 30px solid <?=$white_placeholder?>;">
    <?php /*
    <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="mini_colors_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?= $transp_value ?>"
            placeholder="<?= $transp_placeholder ?>">
    */ ?>
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

/**
 * Top level menu callback function
 */
function mini_cdn_options_page_html() {
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
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "mini"
            settings_fields( 'mini_cdn' );
            // output setting sections and their fields
            // (sections are registered for "mini", each field is registered to a specific section)
            do_settings_sections( 'mini-cdn' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

/**
 * Top level menu callback function
 */
function mini_color_options_page_html() {
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
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "mini"
            settings_fields( 'mini_colors' );
            // output setting sections and their fields
            // (sections are registered for "mini", each field is registered to a specific section)
            do_settings_sections( 'mini-colors' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

/**
 * Top level menu callback function
 */
function mini_size_options_page_html() {
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
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "mini"
            settings_fields( 'mini_size' );
            // output setting sections and their fields
            // (sections are registered for "mini", each field is registered to a specific section)
            do_settings_sections( 'mini-size' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

function mini_font_options_page_html() {
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
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "mini"
            settings_fields( 'mini_font' );
            // output setting sections and their fields
            // (sections are registered for "mini", each field is registered to a specific section)
            do_settings_sections( 'mini-font' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

function mini_css(){
    $options = get_option( 'mini_cdn_options' );
    if (is_array($options) && array_key_exists('mini_cdn', $options) && $options['mini_cdn'] != null) {
        //$miniCSS = 'https://mini.uwa.agency/css/mini.min.css';
        $miniCSS = 'https://cdn.jsdelivr.net/gh/giacomorizzotti/mini@v1.3/css/mini.min.css';
    } else {
        $miniCSS = get_stylesheet_directory_uri().'/mini/mini.min.css';
    }
    wp_enqueue_style( 'wp_header', $miniCSS, array(), _S_VERSION);
}

add_action( 'wp_enqueue_scripts', 'mini_css' );

function mini_js(){
    $options = get_option( 'mini_cdn_options' );
    if (is_array($options) && array_key_exists('mini_cdn', $options) && $options['mini_cdn'] != null) {
        $miniJS = 'https://cdn.jsdelivr.net/gh/giacomorizzotti/mini@v1.3/js/mini.js';
    } else {
        $miniJS = get_stylesheet_directory_uri().'/mini/mini.js';
    }
    wp_enqueue_script( 'wp_footer', $miniJS, array(), _S_VERSION, true);
}

add_action( 'wp_enqueue_scripts', 'mini_js' );