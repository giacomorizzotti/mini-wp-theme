<?php
/**
 * Meta Boxes
 *
 * All custom meta box functions for the theme
 *
 * @package mini
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ADD In-page elements meta box (title and sidebar visibility)
 */

add_action( 'add_meta_boxes', 'add_inpage_elements_box' );
add_action( 'save_post', 'inpage_elements_save_postdata' );

function add_inpage_elements_box() {
    add_meta_box(
        'inpage-elements',
        'In-page elements',
        'inpage_elements_box_html',
        ['page', 'post', 'course', 'lesson'],
        'side'
    );
}

function inpage_elements_box_html( $post, $meta ) {
    // Add nonce field for security
    wp_nonce_field( 'inpage_elements_save', 'inpage_elements_nonce' );

    // Get field values
    $titlePresence = get_post_meta( $post->ID, 'title_presence', true);
    $sidebarPresence = get_post_meta( $post->ID, 'sidebar_presence', true);

    $titlePresenceState = $titlePresence == true ? ' checked' : '';
    $sidebarPresenceState = $sidebarPresence == true ? ' checked' : '';

    // Form fields
    echo '<div class="my-1">';
    echo '<label for="title_presence">
            <input type="checkbox" id="title_presence" name="title_presence"' . $titlePresenceState . '>&nbsp;' 
            . __("Show title", 'mini' ) . '
          </label>';
    
    echo '<label for="sidebar_presence">
            <input type="checkbox" id="sidebar_presence" name="sidebar_presence"' . $sidebarPresenceState . '>&nbsp;' 
            . __("Show sidebar", 'mini' ) . '
          </label>';
    echo '</div>';
}

function inpage_elements_save_postdata( $post_id ) {
    // Verify nonce
    if ( ! isset( $_POST['inpage_elements_nonce'] ) || ! wp_verify_nonce( $_POST['inpage_elements_nonce'], 'inpage_elements_save' ) ) {
        return;
    }

    // If this is autosave do nothing
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return;
    }

    // Check user permission
    if( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save title presence
    $titlePresence = isset($_POST['title_presence']) ? true : false;
    update_post_meta( $post_id, 'title_presence', $titlePresence );

    // Save sidebar presence
    $sidebarPresence = isset($_POST['sidebar_presence']) ? true : false;
    update_post_meta( $post_id, 'sidebar_presence', $sidebarPresence );
}


/**
 * ADD Page customization settings meta box (spacing and container)
 */

add_action( 'add_meta_boxes', 'add_page_customization_box' );
add_action( 'save_post', 'page_customization_save_postdata' );

function add_page_customization_box() {
    add_meta_box(
        'page-customization',
        'Page customization',
        'page_customization_box_html',
        ['page', 'post', 'event', 'match', 'slide', 'course', 'lesson'],
        'side'
    );
}

function page_customization_box_html( $post, $meta ) {
    // Add nonce field for security
    wp_nonce_field( 'page_customization_save', 'page_customization_nonce' );

    // Get field values for spacing
    $spaceTop = get_post_meta( $post->ID, 'space_top', true);
    $spaceBot = get_post_meta( $post->ID, 'space_bot', true);
    $spaceTopState = $spaceTop == true ? ' checked' : '';
    $spaceBotState = $spaceBot == true ? ' checked' : '';

    // Get field value for container
    $pageContainerStyle = get_post_meta( $post->ID, 'page_container', true);

    // Output spacing checkboxes
    echo '<div class="my-1">';
    echo '<label for="space_bot" style="display: block; margin-bottom: 5px;">
            <input type="checkbox" id="space_bot" name="space_bot"' . $spaceBotState . '>&nbsp;' 
            . __("Space bottom", 'mini' ) . '
          </label>';
    echo '<label for="space_top" style="display: block; margin-bottom: 8px;">
            <input type="checkbox" id="space_top" name="space_top"' . $spaceTopState . '>&nbsp;' 
            . __("Space top", 'mini' ) . '
          </label>';
    echo '</div>';

    // Output container dropdown
    echo '<div>';
    echo '<label for="page_container" style="display: block; margin-bottom: 5px; font-weight: 600;">' . __("Container", 'mini' ) . '</label>';
    echo '<select name="page_container" style="width: 100%;">
        <option value="fw"' . ($pageContainerStyle == 'fw' ? ' selected' : '') . '>Full width</option>
        <option value=""' . ($pageContainerStyle == '' ? ' selected' : '') . '>Standard</option>
        <option value="thin"' . ($pageContainerStyle == 'thin' ? ' selected' : '') . '>Thin</option>
        <option value="wide"' . ($pageContainerStyle == 'wide' ? ' selected' : '') . '>Wide</option>
    </select>';
    echo '</div>';
}

function page_customization_save_postdata( $post_id ) {
    // Verify nonce
    if ( ! isset( $_POST['page_customization_nonce'] ) || ! wp_verify_nonce( $_POST['page_customization_nonce'], 'page_customization_save' ) ) {
        return;
    }

    // If this is autosave do nothing
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return;
    }

    // Check user permission
    if( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save spacing options
    $spaceTop = isset($_POST['space_top']) ? true : false;
    update_post_meta( $post_id, 'space_top', $spaceTop );

    $spaceBot = isset($_POST['space_bot']) ? true : false;
    update_post_meta( $post_id, 'space_bot', $spaceBot );

    // Save container style
    if ( isset( $_POST['page_container'] ) ) {
        $allowed_values = array( 'fw', '', 'thin', 'wide' );
        $container_value = sanitize_text_field( $_POST['page_container'] );
        
        // Only save if it's a valid value
        if ( in_array( $container_value, $allowed_values, true ) ) {
            update_post_meta( $post_id, 'page_container', $container_value );
        }
    }
}

/**
 * ADD header styling meta box to page edit
 */

add_action( 'add_meta_boxes', 'add_header_styling_box' );
add_action( 'save_post', 'header_styling_save_postdata' );

function add_header_styling_box() {
    add_meta_box(
        'header-styling',
        'Header styling',
        'header_styling_box_html',
        ['page', 'post', 'match', 'course', 'lesson'],
        'side'
    );
}

function header_styling_box_html( $post, $meta ){
    // Add nonce field for security
    wp_nonce_field( 'header_styling_save', 'header_styling_nonce' );

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
    // Verify nonce
    if ( ! isset( $_POST['header_styling_nonce'] ) || ! wp_verify_nonce( $_POST['header_styling_nonce'], 'header_styling_save' ) ) {
        return;
    }

    // If this is autosave do nothing
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return;
    }

    // Check user permission
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Make sure the fields are set
    if ( ! isset( $_POST['header_styling_top'] ) && ! isset( $_POST['header_styling_scroll'] ) ) {
        return;
    }

    // Sanitize and save the data
    if ( isset( $_POST['header_styling_top'] ) ) {
        update_post_meta( $post_id, 'header_styling_top', sanitize_text_field( $_POST['header_styling_top'] ) );
    }
    
    if ( isset( $_POST['header_styling_scroll'] ) ) {
        update_post_meta( $post_id, 'header_styling_scroll', sanitize_text_field( $_POST['header_styling_scroll'] ) );
    }
}
