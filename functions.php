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
    define( '_S_VERSION', '1.1.5' );
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
    echo '<label for="title_presence" style="display: block; margin-bottom: 5px;">' . __("Show title", 'title_presence_box_textdomain' ) . '</label> ';
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
 * ADD header styling meta box to page edit
 */

// Add blocks to the main column on the page pages
add_action( 'add_meta_boxes', 'add_header_styling_box' );

// Saving data when the post is saved
add_action( 'save_post', 'header_styling_save_postdata' );

function add_header_styling_box() {
    add_meta_box(
        'header-styling',
        'Header styling',
        'header_styling_box_html',
        'page',
        'side'
    );
}

// HTML code of the block
function header_styling_box_html( $post, $meta ){

    // field value
    $header_styling_top_style = get_post_meta( $post->ID, 'header_styling_top', true);
    $header_styling_scroll_style = get_post_meta( $post->ID, 'header_styling_scroll', true);

    $header_styling_state_top_standard = null;
    if ( $header_styling_top_style == '') { $header_styling_state_top_standard = ' selected'; }
    $header_styling_state_top_white = null;
    if ( $header_styling_top_style == 'top-wh') { $header_styling_state_top_white = ' selected'; }
    $header_styling_state_top_black = null;
    if ( $header_styling_top_style == 'top-bk') { $header_styling_state_top_black = ' selected'; }
    $header_styling_state_top_color = null;
    if ( $header_styling_top_style == 'top-col') { $header_styling_state_top_color = ' selected'; }
    $header_styling_state_top_negative = null;
    if ( $header_styling_top_style == 'top-inv') { $header_styling_state_top_negative = ' selected'; }

    $header_styling_state_scroll_standard = null;
    if ( $header_styling_scroll_style == '') { $header_styling_state_scroll_standard = ' selected'; }
    $header_styling_state_scroll_white = null;
    if ( $header_styling_scroll_style == 'scroll-wh') { $header_styling_state_scroll_white = ' selected'; }
    $header_styling_state_scroll_black = null;
    if ( $header_styling_scroll_style == 'scroll-bk') { $header_styling_state_scroll_black = ' selected'; }
    $header_styling_state_scroll_color = null;
    if ( $header_styling_scroll_style == 'scroll-col') { $header_styling_state_scroll_color = ' selected'; }
    $header_styling_state_scroll_negative = null;
    if ( $header_styling_scroll_style == 'scroll-inv') { $header_styling_state_scroll_negative = ' selected'; }

    // Form fields for entering data
    ?>
    <label for="header_styling_top" style="display: block; margin-bottom: 5px;"><?=__("Header top styling", 'header_styling_top_box_textdomain' )?></label>
    <select name="header_styling_top">
		<option value=""<?=$header_styling_state_top_standard?>>Default</option>
		<option value="top-wh"<?=$header_styling_state_top_white?>>Top white background</option>
		<option value="top-bk"<?=$header_styling_state_top_black?>>Top black background</option>
		<option value="top-col"<?=$header_styling_state_top_color?>>Top main color background</option>
		<option value="top-inv"<?=$header_styling_state_top_negative?>>Top inverted colors</option>
	</select>
    <br/><br/>
    <label for="header_styling_scroll" style="display: block; margin-bottom: 5px;"><?=__("Header scroll styling", 'header_styling_scroll_box_textdomain' )?></label>
    <select name="header_styling_scroll">
		<option value=""<?=$header_styling_state_scroll_standard?>>Default</option>
		<option value="scroll-wh"<?=$header_styling_state_scroll_white?>>Scroll white background</option>
		<option value="scroll-bk"<?=$header_styling_state_scroll_black?>>Scroll black background</option>
		<option value="scroll-col"<?=$header_styling_state_scroll_color?>>Scroll main color background</option>
		<option value="scroll-inv"<?=$header_styling_state_scroll_negative?>>Scroll inverted colors</option>
	</select>
<?php
}

function header_styling_save_postdata( $post_id ) {

    // make sure the field is set.
    if ( ! isset( $_POST['header_styling_top'] ) && ! isset( $_POST['header_styling_scroll'] ) ) { return; }

    // if this is autosave do nothing
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) { return; }

    // check user permission
    if( ! current_user_can( 'edit_post', $post_id ) ) { return; }

    // Everything is OK. Now, we need to find and save the data
    // Define the value of the input field.
    $header_style_top = $_POST['header_styling_top'];
    $header_style_scroll = $_POST['header_styling_scroll'];
    // Update data in the database.
    update_post_meta( $post_id, 'header_styling_top', $header_style_top );
    update_post_meta( $post_id, 'header_styling_scroll', $header_style_scroll );
    
}













// mini logo image class
add_filter( 'get_custom_logo', 'change_logo_class' );
function change_logo_class( $html ) {
    $html = str_replace( 'custom-logo', 'your-custom-class', $html );
    $html = str_replace( 'custom-logo-link', 'your-custom-class', $html );
    return $html;
}

// START - MINI LOGIN
// mini login style
function mini_login_style() { ?>
    <style type="text/css">
        body.login-action-login {
            background: -webkit-linear-gradient(135deg, rgb(60 90 255) 0, rgb(60 30 99) 100%) !important;
            background: -moz-linear-gradient(135deg, rgb(60 90 255) 0, rgb(60 30 99) 100%) !important;
            background: -o-linear-gradient(135deg, rgb(60 90 255) 0, rgb(60 30 99) 100%) !important;
            background: linear-gradient(135deg, rgb(60 90 255) 0, rgb(60 30 99) 100%) !important;
        }
        body.login-action-login #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/mini_emblem.svg);
            width:100px;
            height: 58px;
            background-size: contain;
            background-repeat: no-repeat;
            margin-bottom: 3rem;
            filter: brightness(0) invert(1);
        }
        body.login-action-login #loginform {
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            border:0;
            box-shadow: 0 0 10px 0 rgb( 0 0 0 / 45%);
        }
        body.login-action-login #nav a.wp-login-lost-password, body.login-action-login #backtoblog a, .privacy-policy-page-link a.privacy-policy-link {
            color: white;
        }
        body.login-action-login #nav a.wp-login-lost-password:hover, body.login-action-login #backtoblog a:hover, .privacy-policy-page-link a.privacy-policy-link:hover {
            color: #CCCCCC;
        }
        body.login-action-login .language-switcher #language-switcher label span.dashicons {
            color: white;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'mini_login_style' );
// mini login link
function mini_login_url( $url ) {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'mini_login_url', 10, 1 );
// END - MINI LOGIN

// mini admin bar image class
function dashboard_logo() {
    echo '
    <style type="text/css">
        #wpadminbar #wp-admin-bar-wp-logo>.ab-item {
            padding: 0 7px;
            background-image: url('.get_stylesheet_directory_uri().'/img/mini_emblem.svg) !important;
            background-size: 70%;
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
        __( 'Mini general settings', 'mini' ),
        'mini_section_callback',
        'mini'
    );

    add_settings_field(
        'mini_field', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'General options', 'mini' ),
        'mini_field_callback',
        'mini',
        'mini_section',
        array(
            'label_for'         => 'mini',
            'class'             => 'mini_row',
            'mini_custom_data' => 'custom',
        )
    );

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

    // Register a new setting for "mini" page.
    register_setting( 'mini_company', 'mini_company_options');

    // Register a new section in the "mini" page.
    add_settings_section(
        'mini_company_section',
        __( 'Mini company settings', 'mini' ),
        'mini_company_section_callback',
        'mini-company'
    );

    add_settings_field(
        'mini_company', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __( 'Company / Ownership', 'mini' ),
        'mini_company_field_callback',
        'mini-company',
        'mini_company_section',
        array(
            'label_for'         => 'mini_company',
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
function mini_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is the General options section', 'mini' ); ?></p>
    <?php
}
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
function mini_company_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is the company/ownership section', 'mini' ); ?></p>
    <?php
}



/**
 * Generif functions
 */
function text_field_option(
    string $option_group, 
    string $option, 
    string $default_value = '', 
    string $style='width: 100%;',
) {
    $options = get_option( $option_group );
    if ( 
        is_array($options) && array_key_exists($option, $options ) && $options[$option] != null 
    ) {
        $value = $options[$option];
        $placeholder = null;
    } else {
        $value = $options[$option];
        $placeholder = $default_value;
    }
    return '
    <input
        type="text"
        id="'.$option.'"
        name="'.$option_group.'['.$option.']"
        value="'.$value.'"
        placeholder="'.htmlspecialchars($placeholder).'"
        style="'.$style.'";
    >
    ';
}
function text_field_color_option(
    string $option_group, 
    string $option, 
    string $default_value = '', 
    string $style='',
) {
    $options = get_option( $option_group );
    if ( 
        is_array($options) && array_key_exists($option, $options ) && $options[$option] != null 
    ) {
        $value = $options[$option];
        $placeholder = null;
    } else {
        $value = $options[$option];
        $placeholder = $default_value;
    }
    $color = $placeholder;
    if ( $value != '' ) {
        $color = $value;
    }
    return '
    <input
        type="text"
        id="'.$option.'"
        name="'.$option_group.'['.$option.']"
        value="'.$value.'"
        placeholder="'.$placeholder.'"
        style="border: 2px solid '.$color.'; border-right: 30px solid '.$color.';'.$style.'";
    >
    ';
}
function checkbox_option(
    string $option_group, 
    string $option, 
    string $status = '',
) {
    $options = get_option( $option_group );
    if (is_array($options) && array_key_exists($option, $options)) {
        if ($options[$option] == true) {
            $status = 'checked';
        }
    }
    return '
    <input
        type="checkbox"
        id="cdn"
        name="'.$option_group.'['.$option.']"
        '.$status.'
    >
    ';
}

function option_list_option(
    string $option_group, 
    string $option, 
    array $select_options, 
    string $label,
    string $style='width: 100%;',
) {
    /**
     * $options = [
     *  'Main font' => 'main-font',
     *  'Socondary font' => 'secondary-font',
     * ]
     */
    $options = get_option( $option_group );
    $stored_choice = '';
    if (
        is_array($options) && array_key_exists($option, $options) && $options[$option] != null 
    ) {
        $stored_choice = $options[$option];
    }

    $select_field = '
    <label for="'.$option.'">' . __($label, 'mini' ) . '</label>
    <br/><br/>
    ';
    $select_field .= '
    <select name="'.$option_group.'['.$option.']" style="'.$style.'">
    ';
    $select_field .= '
        <option value="" selected>Default</option>
    ';
    $o = 1;
    foreach($select_options as $select_option => $value ) {
        $state = null;
        if($value == $stored_choice) {
            $state = ' selected';
        }
        $select_field .= '
        <option value="'.$value.'"'.$state.'>'.$select_option.'</option>
        ';
        $o++;
    }
    $select_field .= '
    </select>
    ';

    return $select_field;
    
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

function mini_field_callback( $args ) {
    ?>
    <?= checkbox_option('mini_options','credits'); ?>
    <p class="description">
        <?php esc_html_e( 'Footer credits strip', 'mini' ); ?>
    </p>
    <?php
}

function mini_cdn_field_callback( $args ) {
    ?>
    <?= checkbox_option('mini_cdn_options','cdn'); ?>
    <br/><br/>
    <?= text_field_option('mini_cdn_options','css_cdn_url','https://cdn.jsdelivr.net/gh/giacomorizzotti/mini@main/css/mini.min.css'); ?>
    <br/><br/>
    <?= text_field_option('mini_cdn_options','js_cdn_url','https://cdn.jsdelivr.net/gh/giacomorizzotti/mini@main/js/mini.js'); ?>
    <p class="description">
        <?php esc_html_e( 'Use external (CDN) files for this website', 'mini' ); ?>
    </p>
    <p class="description small">
        <?php esc_html_e( 'If you want to avoid the CDN due to performance reasons, please ensure to get .css .js files locally!', 'mini' ); ?>
    </p>
    <?php
}

function mini_colors_callback( $args ) {
    ?>
    <h4 class="m-0">
        Main color
    </h4>
    <?= text_field_color_option('mini_colors_options','mini_main_color','rgb( 60 90 255 / 100% )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_main_color_dark','rgb( 50 75 180 / 100% )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_main_color_transp','rgb( 60 90 255 / 20% )'); ?>
    <p class="description">
        <?php esc_html_e( 'Main color, dark version and transparent version', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <h4 class="m-0">
        Second color
    </h4>
    <?= text_field_color_option('mini_colors_options','mini_second_color','rgb( 50 75 180 / 100% )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_second_color_dark','rgb( 37 56 133 / 100% )'); ?>
    <p class="description">
        <?php esc_html_e( 'Second color and dark version', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <h4 class="m-0">
        Third color
    </h4>
    <?= text_field_color_option('mini_colors_options','mini_third_color','rgb( 60 30 99 / 100% )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_third_color_dark','rgb( 34 15 61 / 100% )'); ?>
    <p class="description">
        <?php esc_html_e( 'Third color and dark version', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <h4 class="m-0">
        Fourth color
    </h4>
    <?= text_field_color_option('mini_colors_options','mini_fourth_color','rgb( 220 230 0 / 100% )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_fourth_color_dark','rgb( 180 190 0 / 100% )'); ?>
    <p class="description">
        <?php esc_html_e( 'Fourth color and dark version', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <h4 class="m-0">
        Link color
    </h4>
    <?= text_field_color_option('mini_colors_options','mini_link_color','rgb( 60 185 225 / 100% )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_link_hover_color','rgb( 40 130 160 / 100% )'); ?>
    <p class="description">
        <?php esc_html_e( 'Link and buttons color', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <h4 class="m-0">
        Sheet & menu colors
    </h4>
    <?= text_field_color_option('mini_colors_options','mini_sheet_color','rgb( 20 10 40 / 100% )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_menu_toggle_color','rgb( 20 10 40 / 100% )'); ?>
    <p class="description">
        <?php esc_html_e( 'Page second level background and menu icon color', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <h4 class="m-0">
        Semaphore colors
    </h4>
    <?= text_field_color_option('mini_colors_options','mini_semaphore_color_info','rgb( 113 202 189 )'); ?>
    <br/><br/>
    <?= text_field_color_option('mini_colors_options','mini_semaphore_color_success','rgb( 160 220 110 )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_semaphore_color_warning','rgb( 248 187 83 )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_semaphore_color_danger','rgb( 255 111 97 )'); ?>
    <br/><br/>
    <?= text_field_color_option('mini_colors_options','mini_semaphore_color_bad','rgb( 235 55 80 )'); ?>
    <p class="description">
        <?php esc_html_e( 'Color used for semaphore logic', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <h4 class="m-0">
        Blacks
    </h4>
    <?= text_field_color_option('mini_colors_options','mini_blacks_color_black','rgb( 10 10 20 / 100% )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_blacks_color_false_black','rgb( 20 10 40 / 100% )'); ?>
    <br/><br/>
    <?= text_field_color_option('mini_colors_options','mini_blacks_color_dark_grey','rgb( 55 55 80 / 100% )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_blacks_color_grey','rgb( 120 120 150 / 100% )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_blacks_color_light_grey','rgb( 215 210 230 / 100% )'); ?>
    <br/><br/>
    <?= text_field_color_option('mini_colors_options','mini_blacks_color_false_white','rgb( 250 248 255 / 100% )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_blacks_color_false_white_transp','rgb( 0 0 0 / 3% )'); ?>
    <?= text_field_color_option('mini_colors_options','mini_blacks_color_white','rgb( 255 255 255 / 100% )'); ?>
    <br/><br/>
    <?= text_field_color_option('mini_colors_options','mini_blacks_color_false_transp','rgb( 0 0 0 / 0% )'); ?>
    <p class="description">
        <?php esc_html_e( 'Greyscale', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>

    <?php
}


function mini_logo_size_field_callback( $args ) {
    ?>
    <h4 class="">Logo height</h4>
    <?= text_field_option('mini_size_options','mini_logo_height','2rem', 'width: auto;'); ?>
    <p class="description">
        <i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <br/>
    <hr>
    <h4 class="">Height when page is scrolled</h4>
    <?= text_field_option('mini_size_options','mini_scroll_logo_height','1.25rem', 'width: auto;'); ?>
    <p class="description">
        <i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <?php
}


function mini_fonts_field_callback( $args ) {
    ?>
    <h4 class="">
        <?php esc_html_e( 'Font for titles', 'mini' ); ?>
    </h4>
    <div style="display: flex; flex-flow: row wrap; gap: 1rem;">
        <div style="flex:1;">
            <?= option_list_option('mini_font_options','mini_title_font', ['Main font' => '--font', 'Secondary font' => '--font-second', 'Font serif' => '--font-serif', 'Font mono' => '--font-mono', 'Font handwriting' => '--font-handwriting'], 'Font used for titles'); ?>
        </div>
        <div style="flex:1;">
            <?= option_list_option('mini_font_options','mini_most_used_font', ['Main font' => '--font', 'Secondary font' => '--font-second', 'Font serif' => '--font-serif', 'Font mono' => '--font-mono', 'Font handwriting' => '--font-handwriting'], 'Most used font (paragraphs, links, menus, ...)'); ?>
        </div>
    </div>
    <h4 class="">
        <?php esc_html_e( 'Main font', 'mini' ); ?>
    </h4>
    <?= text_field_option('mini_font_options','mini_main_font','\'Roboto\', sans-serif', 'width=auto;'); ?>
    <br/><br/>
    <?= text_field_option('mini_font_options','mini_main_font_embed_link', '<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">'); ?>
    <p class="description">
        <?php esc_html_e( 'Used for paragraphs and most of the website\'s content. Sans Serif.', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<b><?php esc_html_e( 'Enabled by default.', 'mini' ); ?></b>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <h4 class="">
        <?php esc_html_e( 'Secondary font', 'mini' ); ?>
    </h4>
    <?= text_field_option('mini_font_options','mini_secondary_font','\'Oswald\', sans-serif', 'width=auto;'); ?>
    <br/><br/>
    <?= text_field_option('mini_font_options','mini_secondary_font_embed_link', '<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">'); ?>
    <p class="description">
        <?php esc_html_e( 'Alternative font, used for titles and in CSS class ".font-two"', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<b><?php esc_html_e( 'Enabled by default.', 'mini' ); ?></b>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <h4 class="">
        <?php esc_html_e( 'Serif font', 'mini' ); ?>
    </h4>
    <?= checkbox_option('mini_font_options','mini_serif_fontz_status'); ?>
    <br/><br/>
    <?= text_field_option('mini_font_options','mini_serif_font','\'Playfair Display\', serif', 'width=auto;'); ?>
    <br/><br/>
    <?= text_field_option('mini_font_options','mini_serif_font_embed_link', '<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">'); ?>
    <p class="description">
        <?php esc_html_e( 'Serif font, used in CSS class ".serif"', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    
    <h4 class="">
        <?php esc_html_e( 'Mono font', 'mini' ); ?>
    </h4>
    <?= checkbox_option('mini_font_options','mini_mono_font_status'); ?>
    <br/><br/>
    <?= text_field_option('mini_font_options','mini_mono_font','\'Roboto Mono\', monospace', 'width=auto;'); ?>
    <br/><br/>
    <?= text_field_option('mini_font_options','mini_mono_font_embed_link', '<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">'); ?>
    <p class="description">
        <?php esc_html_e( 'Monospace font, used in CSS class ".mono"', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <h4 class="">
        <?php esc_html_e( 'Handwriting font', 'mini' ); ?>
    </h4>
    <?= checkbox_option('mini_font_options','mini_handwriting_font_status'); ?>
    <br/><br/>
    <?= text_field_option('mini_font_options','mini_handwriting_font','\'Edu VIC WA NT Beginner\', serif'); ?>
    <br/><br/>
    <?= text_field_option('mini_font_options','mini_handwriting_font_embed_link', '<link href="https://fonts.googleapis.com/css2?family=Edu+VIC+WA+NT+Beginner:wght@400..700&display=swap" rel="stylesheet">'); ?>
    <p class="description">
        <?php esc_html_e( 'Handwriting font, used in CSS class ".handwriting"', 'mini' ); ?>&nbsp;&nbsp;|&nbsp;&nbsp;<i><?php esc_html_e( 'Leave blank to reset.', 'mini' ); ?></i>
    </p>
    <?php
}


function mini_ext_lib_field_callback( $args ) {
    ?>
    <h4 class="">AOS</h4>
    <?= checkbox_option('mini_ext_lib_options','mini_aos'); ?>
    <br/><br/>
    <hr>
    <h4 class="">Iconoir</h4>
    <?= checkbox_option('mini_ext_lib_options','mini_iconoir'); ?>
    <br/><br/>
    <hr>
    <h4 class="">Fontawesome</h4>
    <?= checkbox_option('mini_ext_lib_options','mini_fontawesome'); ?>
    <br/><br/>
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
    <?= checkbox_option('mini_analytics_options','mini_google_analytics'); ?>
    <br/><br/>
    <?= text_field_option('mini_analytics_options','mini_google_analytics_code',''); ?>
    <br/><br/>
    <hr>
    <?php
}

function mini_company_field_callback( $args ) {
    ?>
    <h3 class=""><?= esc_html__( 'Istitutional data', 'mini' ) ?></h3>

    <div style="display: flex; flex-flow: row wrap; gap: 1rem;">
        <div style="flex:1;">
            <h4 class=""><?= esc_html__( 'Company name', 'mini' ) ?></h4>
            <?= text_field_option('mini_company_options','mini_company_name','', 'width: 33.3333333%;'); ?>
        </div>
    </div>

    <div style="display: flex; flex-flow: row wrap; gap: 1rem;">
        <div style="flex:4;">
            <h4 class=""><?= esc_html__( 'Address', 'mini' ) ?></h4>
            <?= text_field_option('mini_company_options','mini_company_address',''); ?>
        </div>
        <div style="flex:1;">
        <h4 class=""><?= esc_html__( 'House number', 'mini' ) ?></h4>
            <?= text_field_option('mini_company_options','mini_company_house_number',''); ?>
        </div>
    </div>

    <div style="display: flex; flex-flow: row wrap; gap: 1rem;">
        <div style="flex:1;">
            <h4 class=""><?= esc_html__( 'City', 'mini' ) ?></h4>
            <?= text_field_option('mini_company_options','mini_company_city',''); ?>
            <br/>
        </div>
        <div style="flex:1;">
            <h4 class=""><?= esc_html__( 'Province', 'mini' ) ?></h4>
            <?= text_field_option('mini_company_options','mini_company_province',''); ?>
            <br/>
        </div>
        <div style="flex:1;">
            <h4 class=""><?= esc_html__( 'Country', 'mini' ) ?></h4>
            <?= text_field_option('mini_company_options','mini_company_country',''); ?>
            <br/>
        </div>
    </div>

    <div style="display: flex; flex-flow: row wrap; gap: 1rem;">
        <div style="flex:1;">
            <h4 class=""><?= esc_html__( 'Email', 'mini' ) ?></h4>
            <?= text_field_option('mini_company_options','mini_company_email',''); ?>
        </div>
        <div style="flex:1;">
            <h4 class=""><?= esc_html__( 'Phone', 'mini' ) ?></h4>
            <?= text_field_option('mini_company_options','mini_company_phone',''); ?>
        </div>
    </div>

    <div style="display: flex; flex-flow: row wrap; gap: 1rem;">
        <div style="flex:1;">
            <h4 class=""><?= esc_html__( 'PEC', 'mini' ) ?></h4>
            <?= text_field_option('mini_company_options','mini_company_pec',''); ?>
        </div>
    </div>

    <br/><hr>

    <h3 class=""><?= esc_html__( 'Technical addresses', 'mini' ) ?></h3>

    <div style="display: flex; flex-flow: row wrap; gap: 1rem;">
        <div style="flex:1;">
            <h4 class=""><?= esc_html__( 'Email', 'mini' ) ?></h4>
            <?= text_field_option('mini_company_options','mini_company_service_email',''); ?>
        </div>
        <div style="flex:1;">
            <h4 class=""><?= esc_html__( 'Phone', 'mini' ) ?></h4>
            <?= text_field_option('mini_company_options','mini_company_service_phone',''); ?>
        </div>
    </div>
    <br/><hr>
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
        'https://cdn.jsdelivr.net/gh/giacomorizzotti/mini/img/brand/mini_emblem_space_around.svg'
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
    add_submenu_page(
        'mini',
        'Company options',
        'Company',
        'manage_options',
        'mini-company',
        'mini_company_options_page_html'
    );
}


/**
 * SHORTCODES
 */
function get_variable($option_group, $option) {
    $options = get_option( $option_group );
    $variable = false;
    if ( 
        is_array($options) && array_key_exists($option, $options ) && $options[$option] != null 
    ) {
        $variable = $options[$option];
    }
    return $variable;
}

function get_company_name() {
    if ( get_variable('mini_company_options', 'mini_company_name') != false ) {
        return get_variable('mini_company_options', 'mini_company_name');
    } else {
        return 'NONE';
    }
}
add_shortcode('get_company_name', 'get_company_name');

function get_company_address_line_1() {
    if ( 
        get_variable('mini_company_options', 'mini_company_address') != false &&
        get_variable('mini_company_options', 'mini_company_house_number')
    ) {
        return get_variable('mini_company_options', 'mini_company_address').' '.get_variable('mini_company_options', 'mini_company_house_number');
    } else {
        return 'NONE';
    }
}
function get_company_address_line_2() {
    if ( 
        get_variable('mini_company_options', 'mini_company_city') != false &&
        get_variable('mini_company_options', 'mini_company_province') != false &&
        get_variable('mini_company_options', 'mini_company_country')
    ) {
        return get_variable('mini_company_options', 'mini_company_city').' ['.get_variable('mini_company_options', 'mini_company_province').'], '.get_variable('mini_company_options', 'mini_company_country');
    } else {
        return 'NONE';
    }
}
add_shortcode('get_company_address_line_1', 'get_company_address_line_1');
add_shortcode('get_company_address_line_2', 'get_company_address_line_2');

function get_company_email() {
    if ( get_variable('mini_company_options', 'mini_company_email') != false ) {
        return get_variable('mini_company_options', 'mini_company_email');
    } else {
        return 'NONE';
    }
}
add_shortcode('get_company_email', 'get_company_email');

function get_company_phone() {
    if ( get_variable('mini_company_options', 'mini_company_phone') != false ) {
        return get_variable('mini_company_options', 'mini_company_phone');
    } else {
        return 'NONE';
    }
}
add_shortcode('get_company_phone', 'get_company_phone');

function get_company_pec() {
    if ( get_variable('mini_company_options', 'mini_company_pec') != false ) {
        return get_variable('mini_company_options', 'mini_company_pec');
    } else {
        if ( get_variable('mini_company_options', 'mini_company_email') != false ) {
            return get_variable('mini_company_options', 'mini_company_email');
        } else {
            return 'NONE';
        }
    }
}
add_shortcode('get_company_pec', 'get_company_pec');

function get_company_service_email() {
    if ( get_variable('mini_company_options', 'mini_company_service_email') != false ) {
        return get_variable('mini_company_options', 'mini_company_service_email');
    } else {
        return 'NONE';
    }
}
add_shortcode('get_company_service_email', 'get_company_service_email');

function get_company_service_phone() {
    if ( get_variable('mini_company_options', 'mini_company_service_phone') != false ) {
        return get_variable('mini_company_options', 'mini_company_service_phone');
    } else {
        return 'NONE';
    }
}
add_shortcode('get_company_service_phone', 'get_company_service_phone');

/**
 * END OF SHORTCODES
 */



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
        <br/>
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
/*
add_action( 'wp_head', 'themeprefix_load_fonts' ); 
function themeprefix_load_fonts() { 
    ?> 
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php
}
*/
add_action( 'wp_enqueue_scripts', 'mini_main_gwf_font' );
function mini_main_gwf_font(){
    $options = get_option( 'mini_font_options' );
    if (is_array($options) && array_key_exists('mini_main_font_embed_link', $options) && $options['mini_main_font_embed_link'] != null) {
        $main_font_gwf_embed_link = $options['mini_main_font_embed_link'] ;
    } else {
        $main_font_gwf_embed_link = 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap';
    }
    wp_enqueue_style( 'google_fonts', $main_font_gwf_embed_link, array(), _S_VERSION);
}
add_action( 'wp_enqueue_scripts', 'mini_secondary_gwf_font' );
function mini_secondary_gwf_font(){
    $options = get_option( 'mini_font_options' );
    if (is_array($options) && array_key_exists('mini_secondary_font_embed_link', $options) && $options['mini_secondary_font_embed_link'] != null) {
        $secondary_font_gwf_embed_link = $options['mini_secondary_font_embed_link'] ;
    } else {
        $secondary_font_gwf_embed_link = 'https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap';
    }
    wp_enqueue_style( 'google_fonts', $secondary_font_gwf_embed_link, array(), _S_VERSION);
}
add_action( 'wp_enqueue_scripts', 'mini_serif_gwf_font' );
function mini_serif_gwf_font(){
    $options = get_option( 'mini_font_options' );
    if (is_array($options) && array_key_exists('mini_serif_font_embed_link', $options) && $options['mini_serif_font_embed_link'] != null) {
        $serif_font_gwf_embed_link = $options['mini_serif_font_embed_link'] ;
    } else {
        $serif_font_gwf_embed_link = 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap';
    }
    if (is_array($options) && array_key_exists('mini_serif_font_status', $options) && $options['mini_serif_font_status'] != null) {
        wp_enqueue_style( 'google_fonts', $serif_font_gwf_embed_link, array(), _S_VERSION);
    }
}
add_action( 'wp_enqueue_scripts', 'mini_mono_gwf_font' );
function mini_mono_gwf_font(){
    $options = get_option( 'mini_font_options' );
    if (is_array($options) && array_key_exists('mini_mono_font_embed_link', $options) && $options['mini_mono_font_embed_link'] != null) {
        $mono_font_gwf_embed_link = $options['mini_mono_font_embed_link'] ;
    } else {
        $mono_font_gwf_embed_link = 'https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap';
    }
    if (is_array($options) && array_key_exists('mini_mono_font_status', $options) && $options['mini_mono_font_status'] != null) {
        wp_enqueue_style( 'google_fonts', $mono_font_gwf_embed_link, array(), _S_VERSION);
    }
}
add_action( 'wp_enqueue_scripts', 'mini_handwriting_gwf_font' );
function mini_handwriting_gwf_font(){
    $options = get_option( 'mini_font_options' );
    if (is_array($options) && array_key_exists('mini_handwriting_font_embed_link', $options) && $options['mini_handwriting_font_embed_link'] != null) {
        $handwriting_font_gwf_embed_link = $options['mini_handwriting_font_embed_link'] ;
    } else {
        $handwriting_font_gwf_embed_link = 'https://fonts.googleapis.com/css2?family=Edu+VIC+WA+NT+Beginner:wght@400..700&display=swap';
    }
    if (is_array($options) && array_key_exists('mini_handwriting_font_status', $options) && $options['mini_handwriting_font_status'] != null) {
        wp_enqueue_style( 'google_fonts', $handwriting_font_gwf_embed_link, array(), _S_VERSION);
    }
}