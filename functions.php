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
 * Enqueue styles for admin area.
 */
function mini_admin_styles() {
    wp_enqueue_style( 'mini-admin-style', get_stylesheet_uri(), array(), _S_VERSION );
}
add_action( 'admin_enqueue_scripts', 'mini_admin_styles' );
add_action( 'login_enqueue_scripts', 'mini_admin_styles' );

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

    // Add nonce field for security
    wp_nonce_field( 'title_presence_save', 'title_presence_nonce' );

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

    // Verify nonce
    if ( ! isset( $_POST['title_presence_nonce'] ) || ! wp_verify_nonce( $_POST['title_presence_nonce'], 'title_presence_save' ) ) {
        return;
    }

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
        ['page', 'post'],
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

    // Verify nonce
    if ( ! isset( $_POST['sidebar_presence_nonce'] ) || ! wp_verify_nonce( $_POST['sidebar_presence_nonce'], 'sidebar_presence_save' ) ) {
        return;
    }

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
 * ADD space-top-bot option
 */

add_action( 'add_meta_boxes', 'add_space_top_bot_box' );

// Saving data when the post is saved
add_action( 'save_post', 'space_top_bot_save_postdata' );

function add_space_top_bot_box() {
    add_meta_box(
        'space-top-bot',
        'Top and bottom spacing',
        'space_top_bot_box_html',
        ['page', 'post'],
        'side'
    );
}

// HTML code of the block
function space_top_bot_box_html( $post, $meta ){

    $spaceTop = get_post_meta( $post->ID, 'space_top', true);
    $spaceTopState = null;
    if ( $spaceTop == true ) {
        $spaceTopState = ' checked';
    }
    
    $spaceBot = get_post_meta( $post->ID, 'space_top', true);
    $spaceBotState = null;
    if ( $spaceBot == true ) {
        $spaceBotState = ' checked';
    }

    echo '<label for="space_top" style="display: block; margin-bottom: 5px;">' . __("Space top", 'space_top_box_textdomain' ) . '</label> ';
    echo '<input type="checkbox" id="space_top" name="space_top"'.$spaceTopState.'>';
    echo '<label for="space_bot" style="display: block; margin-bottom: 5px;">' . __("Space bottom", 'space_bot_box_textdomain' ) . '</label> ';
    echo '<input type="checkbox" id="space_bot" name="space_bot"'.$spaceBotState.'>';

}

function space_top_bot_save_postdata( $post_id ) {

    // if this is autosave do nothing
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) { return; }

    // check user permission
    if( ! current_user_can( 'edit_post', $post_id ) ) { return; }

    // Everything is OK. Now, we need to find and save the data
    // Define the value of the input field.
    if ( isset($_POST['space_top']) ) {
        $spaceTop = true;
    } else {
        $spaceTop = false;
    }
    if ( isset($_POST['space_bot']) ) {
        $spaceBot = true;
    } else {
        $spaceBot = false;
    }
    // Update data in the database.
    update_post_meta( $post_id, 'space_top', $spaceTop );
    update_post_meta( $post_id, 'space_bot', $spaceBot );

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
        ['page', 'post', 'event', 'match', 'slide'],
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
        ['page', 'post', 'match'],
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















// Patterns
add_filter( 'should_load_remote_block_patterns', '__return_false' );

// mini favicon
function mini_favicon(){
    echo "<link rel='shortcut icon' href='" . get_stylesheet_directory_uri() . "/favicon.ico' />" . "\n";
}
add_action( 'admin_head', 'mini_favicon' );
//add_action( 'wp_head', 'mini_favicon');

// Contact form 7 BUG FIX
add_filter('wpcf7_autop_or_not', '__return_false');

// mini logo image class
add_filter( 'get_custom_logo', 'change_logo_class' );
function change_logo_class( $html ) {
    $html = str_replace( 'custom-logo', 'logo', $html );
    $html = str_replace( 'custom-logo-link', 'logo-link', $html );
    return $html;
}


/* START - mini login link */
function mini_login_url( $url ) {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'mini_login_url', 10, 1 );
/* END - mini login link */

/* START - mini admin bar image class */
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
/* END - mini admin bar image class */




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

    /*
    register_setting( 'mini_size', 'mini_size_options');

    add_settings_section(
        'mini_size_section',
        __( 'Mini size settings', 'mini' ),
        'mini_size_section_callback',
        'mini-size'
    );

    add_settings_field(
        'mini_logo_size',
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
    */

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




















function mini_load_theme_textdomain() {
    load_theme_textdomain( 'mini', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'mini_load_theme_textdomain' );

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
    <div class="boxes">
        <div class="box-100 p-2 white-bg b-rad-5 box-shadow">
            <h4 class="" for="mini_match"><?php esc_html_e( 'Footer credit strip', 'mini' ); ?></h4>
            <?= mini_theme_checkbox_option('mini_options','mini_credits'); ?>
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
            <?= mini_theme_checkbox_option('mini_cdn_options','cdn'); ?>
            <p class="" for="mini_news">This option will let you use external CDN to load <i>mini</i> library framework files for this website.</p>
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
 * Generic functions
 */
function mini_theme_checkbox_option(
    string $option_group, 
    string $option, 
    string $status = '',
) {
    $options = get_option( $option_group );
    if (is_array($options) && array_key_exists($option, $options)) {
        if ($options[$option]) {
            $status = 'checked';
        }
    }
    return '
    <input
        type="checkbox"
        id="'.$option.'"
        name="'.$option_group.'['.$option.']"
        value="1"
        '.$status.'
    >
    ';
}
function mini_theme_text_field_option(
    string $option_group, 
    string $option, 
    string $default_value = '', 
    string $style='width: 100%;',
) {
    $options = get_option( $option_group );
    if ( 
        is_array($options) && array_key_exists($option, $options )
    ) {
        $value = $options[$option];
    } else {
        $value = '';
    }
    return '
    <input
        type="text"
        id="'.$option.'"
        name="'.$option_group.'['.$option.']"
        value="'.esc_attr($value).'"
        placeholder="'.esc_attr($default_value).'"
        style="'.$style.'";
    >
    ';
}

function mini_theme_textarea_option(
    string $option_group, 
    string $option, 
    string $default_value = '', 
    string $style='width: 100%;',
    int $rows = 3
) {
    $options = get_option( $option_group );
    if ( 
        is_array($options) && array_key_exists($option, $options )
    ) {
        $value = $options[$option];
    } else {
        $value = '';
    }
    $placeholder_attr = $default_value ? 'placeholder="'.esc_attr($default_value).'"' : '';
    return '
    <textarea
        id="'.$option.'"
        name="'.$option_group.'['.$option.']"
        '.$placeholder_attr.'
        style="'.$style.'"
        rows="'.$rows.'"
    >'.esc_textarea($value).'</textarea>
    ';
}

function mini_theme_text_field_color_option(
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

function mini_theme_option_list_option(
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


function mini_get_google_fonts() {
    return [
        'sans' => [
            'Barlow' => ['family' => 'Barlow', 'weights' => 'ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900', 'css' => '\'Barlow\', sans-serif'],
            'Roboto' => ['family' => 'Roboto', 'weights' => 'ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900', 'css' => '\'Roboto\', sans-serif'],
            'Open Sans' => ['family' => 'Open+Sans', 'weights' => 'ital,wght@0,300..800;1,300..800', 'css' => '\'Open Sans\', sans-serif'],
            'Lato' => ['family' => 'Lato', 'weights' => 'ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900', 'css' => '\'Lato\', sans-serif'],
            'Montserrat' => ['family' => 'Montserrat', 'weights' => 'ital,wght@0,100..900;1,100..900', 'css' => '\'Montserrat\', sans-serif'],
            'Inter' => ['family' => 'Inter', 'weights' => 'ital,opsz,wght@0,14..32,100..900;1,14..32,100..900', 'css' => '\'Inter\', sans-serif'],
            'Poppins' => ['family' => 'Poppins', 'weights' => 'ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900', 'css' => '\'Poppins\', sans-serif'],
            'Nunito' => ['family' => 'Nunito', 'weights' => 'ital,wght@0,200..1000;1,200..1000', 'css' => '\'Nunito\', sans-serif'],
        ],
        'secondary' => [
            'Oswald' => ['family' => 'Oswald', 'weights' => 'wght@200;300;400;500;600;700', 'css' => '\'Oswald\', sans-serif'],
            'Bebas Neue' => ['family' => 'Bebas+Neue', 'weights' => '', 'css' => '\'Bebas Neue\', sans-serif'],
            'Anton' => ['family' => 'Anton', 'weights' => '', 'css' => '\'Anton\', sans-serif'],
            'Raleway' => ['family' => 'Raleway', 'weights' => 'ital,wght@0,100..900;1,100..900', 'css' => '\'Raleway\', sans-serif'],
            'Ubuntu' => ['family' => 'Ubuntu', 'weights' => 'ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700', 'css' => '\'Ubuntu\', sans-serif'],
        ],
        'serif' => [
            'Playfair Display' => ['family' => 'Playfair+Display', 'weights' => 'ital,wght@0,400..900;1,400..900', 'css' => '\'Playfair Display\', serif'],
            'Merriweather' => ['family' => 'Merriweather', 'weights' => 'ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900', 'css' => '\'Merriweather\', serif'],
            'Lora' => ['family' => 'Lora', 'weights' => 'ital,wght@0,400..700;1,400..700', 'css' => '\'Lora\', serif'],
            'EB Garamond' => ['family' => 'EB+Garamond', 'weights' => 'ital,wght@0,400..800;1,400..800', 'css' => '\'EB Garamond\', serif'],
            'Crimson Text' => ['family' => 'Crimson+Text', 'weights' => 'ital,wght@0,400;0,600;0,700;1,400;1,600;1,700', 'css' => '\'Crimson Text\', serif'],
        ],
        'mono' => [
            'Roboto Mono' => ['family' => 'Roboto+Mono', 'weights' => 'ital,wght@0,100..700;1,100..700', 'css' => '\'Roboto Mono\', monospace'],
            'Source Code Pro' => ['family' => 'Source+Code+Pro', 'weights' => 'ital,wght@0,200..900;1,200..900', 'css' => '\'Source Code Pro\', monospace'],
            'JetBrains Mono' => ['family' => 'JetBrains+Mono', 'weights' => 'ital,wght@0,100..800;1,100..800', 'css' => '\'JetBrains Mono\', monospace'],
            'Fira Code' => ['family' => 'Fira+Code', 'weights' => 'wght@300..700', 'css' => '\'Fira Code\', monospace'],
            'Courier Prime' => ['family' => 'Courier+Prime', 'weights' => 'ital,wght@0,400;0,700;1,400;1,700', 'css' => '\'Courier Prime\', monospace'],
        ],
        'handwriting' => [
            'Edu VIC WA NT Beginner' => ['family' => 'Edu+VIC+WA+NT+Beginner', 'weights' => 'wght@400..700', 'css' => '\'Edu VIC WA NT Beginner\', cursive'],
            'Caveat' => ['family' => 'Caveat', 'weights' => 'wght@400..700', 'css' => '\'Caveat\', cursive'],
            'Pacifico' => ['family' => 'Pacifico', 'weights' => '', 'css' => '\'Pacifico\', cursive'],
            'Dancing Script' => ['family' => 'Dancing+Script', 'weights' => 'wght@400..700', 'css' => '\'Dancing Script\', cursive'],
            'Permanent Marker' => ['family' => 'Permanent+Marker', 'weights' => '', 'css' => '\'Permanent Marker\', cursive'],
        ]
    ];
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
 * SHORTCODES
 */
if (!function_exists('get_variable')) {
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
}

function get_company_name() {
    if ( get_variable('mini_company_options', 'mini_company_name') != false ) {
        return get_variable('mini_company_options', 'mini_company_name');
    } else {
        return false;
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
        return false;
    }
}
function get_company_address_line_2() {
    if ( 
        get_variable('mini_company_options', 'mini_company_city') != false &&
        get_variable('mini_company_options', 'mini_company_province') != false &&
        get_variable('mini_company_options', 'mini_company_country') &&
        get_variable('mini_company_options', 'mini_company_city_code')
    ) {
        return get_variable('mini_company_options', 'mini_company_city_code').', '.get_variable('mini_company_options', 'mini_company_city').' ['.get_variable('mini_company_options', 'mini_company_province').'], '.get_variable('mini_company_options', 'mini_company_country');
    } else {
        return false;
    }
}
add_shortcode('get_company_address_line_1', 'get_company_address_line_1');
add_shortcode('get_company_address_line_2', 'get_company_address_line_2');

function get_company_email() {
    if ( get_variable('mini_company_options', 'mini_company_email') != false ) {
        return get_variable('mini_company_options', 'mini_company_email');
    } else {
        return false;
    }
}
add_shortcode('get_company_email', 'get_company_email');

function get_company_phone() {
    if ( get_variable('mini_company_options', 'mini_company_phone') != false ) {
        return get_variable('mini_company_options', 'mini_company_phone');
    } else {
        return false;
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
            return false;
        }
    }
}
add_shortcode('get_company_pec', 'get_company_pec');

function get_company_service_email() {
    if ( get_variable('mini_company_options', 'mini_company_service_email') != false ) {
        return get_variable('mini_company_options', 'mini_company_service_email');
    } else {
        return false;
    }
}
add_shortcode('get_company_service_email', 'get_company_service_email');

function get_company_service_phone() {
    if ( get_variable('mini_company_options', 'mini_company_service_phone') != false ) {
        return get_variable('mini_company_options', 'mini_company_service_phone');
    } else {
        return false;
    }
}
add_shortcode('get_company_service_phone', 'get_company_service_phone');

function get_company_tax_number() {
    if ( get_variable('mini_company_options', 'mini_company_tax_number') != false ) {
        return get_variable('mini_company_options', 'mini_company_tax_number');
    } else {
        return false;
    }
}
add_shortcode('get_company_tax_number', 'get_company_tax_number');

function get_company_id_code() {
    if ( get_variable('mini_company_options', 'mini_company_id_code') != false ) {
        return get_variable('mini_company_options', 'mini_company_id_code');
    } else {
        return false;
    }
}
add_shortcode('get_company_id_code', 'get_company_id_code');

// Social networks helper function
function get_enabled_social_networks() {
    $socials = [
        'instagram' => ['icon' => 'iconoir-instagram', 'name' => 'Instagram'],
        'facebook' => ['icon' => 'iconoir-facebook', 'name' => 'Facebook'],
        'x' => ['icon' => 'iconoir-x', 'name' => 'X'],
        'linkedin' => ['icon' => 'iconoir-linkedin', 'name' => 'LinkedIn'],
        'youtube' => ['icon' => 'iconoir-youtube', 'name' => 'YouTube'],
        'tiktok' => ['icon' => 'iconoir-tiktok', 'name' => 'TikTok'],
        'threads' => ['icon' => 'iconoir-threads', 'name' => 'Threads'],
    ];
    
    $enabled = [];
    foreach ($socials as $key => $data) {
        $enabled_key = 'mini_company_' . $key . '_enabled';
        $url_key = 'mini_company_' . $key;
        
        if (get_variable('mini_company_options', $enabled_key) && 
            get_variable('mini_company_options', $url_key)) {
            $enabled[$key] = [
                'url' => get_variable('mini_company_options', $url_key),
                'icon' => $data['icon'],
                'name' => $data['name']
            ];
        }
    }
    
    return $enabled;
}

// Messaging apps helper function
function get_enabled_messaging_apps() {
    $messaging = [
        'whatsapp' => ['icon' => 'iconoir-chat-bubble', 'name' => 'WhatsApp'],
        'telegram' => ['icon' => 'iconoir-telegram', 'name' => 'Telegram'],
    ];
    
    $enabled = [];
    foreach ($messaging as $key => $data) {
        $enabled_key = 'mini_company_' . $key . '_enabled';
        $url_key = 'mini_company_' . $key;
        
        if (get_variable('mini_company_options', $enabled_key) && 
            get_variable('mini_company_options', $url_key)) {
            $enabled[$key] = [
                'url' => get_variable('mini_company_options', $url_key),
                'icon' => $data['icon'],
                'name' => $data['name']
            ];
        }
    }
    
    return $enabled;
}

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



// Adding .css from CDN or from ext source or from local theme folder
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

// Adding .js from CDN or from ext source or from local theme folder
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

// Adding .js from CDN or from ext source or from local theme folder
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

# Google fonts

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
            ? $options['mini_serif_font'] : 'Playfair Display';
        if (isset($fonts_data['serif'][$serif_font])) {
            $fonts_to_load[] = $fonts_data['serif'][$serif_font];
        }
    }
    
    // Mono (optional)
    if (isset($options['mini_mono_font_status']) && $options['mini_mono_font_status']) {
        $mono_font = isset($options['mini_mono_font']) && !empty($options['mini_mono_font']) 
            ? $options['mini_mono_font'] : 'Roboto Mono';
        if (isset($fonts_data['mono'][$mono_font])) {
            $fonts_to_load[] = $fonts_data['mono'][$mono_font];
        }
    }
    
    // Handwriting (optional)
    if (isset($options['mini_handwriting_font_status']) && $options['mini_handwriting_font_status']) {
        $handwriting_font = isset($options['mini_handwriting_font']) && !empty($options['mini_handwriting_font']) 
            ? $options['mini_handwriting_font'] : 'Edu VIC WA NT Beginner';
        if (isset($fonts_data['handwriting'][$handwriting_font])) {
            $fonts_to_load[] = $fonts_data['handwriting'][$handwriting_font];
        }
    }
    
    // Build Google Fonts URL
    if (!empty($fonts_to_load)) {
        $families = [];
        foreach ($fonts_to_load as $font) {
            $family = $font['family'];
            if (!empty($font['weights'])) {
                $family .= ':' . $font['weights'];
            }
            $families[] = $family;
        }
        
        $google_fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $families) . '&display=swap';
        wp_enqueue_style('mini_google_fonts', $google_fonts_url, array(), null);
    }
    
    // Add inline CSS for font variables
    $css_vars = ':root {';
    
    if (isset($fonts_data['sans'][$sans_font])) {
        $css_vars .= '--font-sans: ' . $fonts_data['sans'][$sans_font]['css'] . ';';
    }
    
    if (isset($fonts_data['secondary'][$secondary_font])) {
        $css_vars .= '--font-second: ' . $fonts_data['secondary'][$secondary_font]['css'] . ';';
    }
    
    if ($serif_font && isset($fonts_data['serif'][$serif_font])) {
        $css_vars .= '--font-serif: ' . $fonts_data['serif'][$serif_font]['css'] . ';';
    }
    
    if ($mono_font && isset($fonts_data['mono'][$mono_font])) {
        $css_vars .= '--font-mono: ' . $fonts_data['mono'][$mono_font]['css'] . ';';
    }
    
    if ($handwriting_font && isset($fonts_data['handwriting'][$handwriting_font])) {
        $css_vars .= '--font-handwriting: ' . $fonts_data['handwriting'][$handwriting_font]['css'] . ';';
    }
    
    $css_vars .= '}';
    
    // Add inline styles to mini_header_css (mini.min.css) so they override the framework defaults
    wp_add_inline_style('mini_header_css', $css_vars);
}

/**
 * ========================================
 * INSTANCE-SPECIFIC OVERRIDES SYSTEM
 * ========================================
 * This system allows you to customize theme files per WordPress instance
 * without modifying the core theme files.
 */

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