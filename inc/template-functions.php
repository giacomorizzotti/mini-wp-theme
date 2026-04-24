<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package mini
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function mini_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'mini_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function mini_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'mini_pingback_header' );

/**
 * Serve 403.php template when WordPress sets a 403 status.
 */
add_action( 'template_redirect', function() {
    if ( http_response_code() === 403 ) {
        status_header( 403 );
        $template = locate_template( '403.php' );
        if ( $template ) {
            include $template;
            exit;
        }
    }
} );

/**
 * Get header styling for current page
 *
 * @return array Array with 'top' and 'scroll' style values
 */
function mini_get_header_styling() {
	$header_top_style = '';
	$header_scroll_style = '';
	$post_id = null;

	if ( is_singular() ) {
		$post_id = get_the_ID();
	} elseif ( is_home() ) {
		$post_id = get_option( 'page_for_posts' );
	} elseif ( is_front_page() && ! is_home() ) {
		$post_id = get_option( 'page_on_front' );
	}

	if ( $post_id ) {
		$header_top_style = get_post_meta( $post_id, 'header_styling_top', true );
		$header_scroll_style = get_post_meta( $post_id, 'header_styling_scroll', true );
		// Default to white backgrounds if empty
		$header_top_style = ( $header_top_style === '' ) ? 'top-wh' : $header_top_style;
		$header_scroll_style = ( $header_scroll_style === '' ) ? 'scroll-wh' : $header_scroll_style;
	}

	return array(
		'top' => $header_top_style,
		'scroll' => $header_scroll_style
	);
}

/**
 * Get page layout settings
 *
 * @param int $post_id Post ID (optional, defaults to current post)
 * @return array Array with layout settings
 */
function mini_get_page_layout( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( ! $post_id ) {
		return array(
			'title_presence' => false,
			'sidebar_presence' => false,
			'container_width' => '',
			'space_top' => false,
			'space_bottom' => false,
			'spacing_class' => '',
			'content_size' => 'box-100',
			'display_author_info' => true
		);
	}

	$title_presence = get_post_meta( $post_id, 'title_presence', true );
	$sidebar_presence = get_post_meta( $post_id, 'sidebar_presence', true );
	// Default sidebar_presence to false if empty (only true when explicitly set)
	$sidebar_presence = ( $sidebar_presence === '1' || $sidebar_presence === true ) ? true : false;
	$container_width = get_post_meta( $post_id, 'page_container', true );
	$space_top = get_post_meta( $post_id, 'space_top', true );
	$space_bottom = get_post_meta( $post_id, 'space_bot', true );
	// Default space_top and space_bottom to true (checked) if empty
	$space_top = ( $space_top === '' ) ? '1' : $space_top;
	$space_bottom = ( $space_bottom === '' ) ? '1' : $space_bottom;
	$display_author_info = get_post_meta( $post_id, 'display_author_info', true );
	$display_author_info = ( $display_author_info !== '0' ); // Default true, false only if explicitly '0'

	// Calculate spacing class
	$spacing_class = '';
	if ( $space_top && $space_bottom ) {
		$spacing_class = 'space-top-bot';
	} elseif ( $space_top ) {
		$spacing_class = 'space-top';
	} elseif ( $space_bottom ) {
		$spacing_class = 'space-bot';
	}

	// Calculate content size
	$content_width_meta = get_post_meta( $post_id, 'content_width', true );
	$content_size = ( $content_width_meta === 'box-66' ) ? 'box-66' : 'box-100';
	if ( is_active_sidebar( 'sidebar-1' ) && $sidebar_presence ) {
		$content_size = 'box-75';
	}

	return array(
		'title_presence' => $title_presence,
		'sidebar_presence' => $sidebar_presence,
		'container_width' => $container_width,
		'space_top' => $space_top,
		'space_bottom' => $space_bottom,
		'spacing_class' => $spacing_class,
		'content_size' => $content_size,
		'display_author_info' => $display_author_info
	);
}

/**
 * Check if option value exists
 *
 * @param string $options_group Option group name
 * @param string $option Option key
 * @return bool True if option exists and has value
 */
function mini_check_option( $options_group, $option ) {
	$options = get_option( $options_group );
	return is_array( $options ) && isset( $options[$option] ) && ! empty( $options[$option] );
}

/**
 * Get option value
 *
 * @param string $options_group Option group name
 * @param string $option Option key
 * @param mixed $default Default value if option not found
 * @return mixed Option value or default
 */
function mini_get_option( $options_group, $option, $default = '' ) {
	$options = get_option( $options_group );
	
	if ( is_array( $options ) && isset( $options[$option] ) ) {
		return $options[$option];
	}
	
	return $default;
}

/**
 * Output CSS variable from theme option
 *
 * @param string $options_group Option group name
 * @param string $option Option key
 * @param string $variable_name CSS variable name
 * @param bool $var_refer Whether to use var() reference
 */
function mini_css_variable( $options_group, $option, $variable_name, $var_refer = false ) {
	if ( ! mini_check_option( $options_group, $option ) ) {
		return;
	}
	
	$value = mini_get_option( $options_group, $option );
	
	if ( $var_refer ) {
		echo esc_html( $variable_name . ':var(' . $value . ');' );
	} else {
		echo esc_html( $variable_name . ':' . $value . ';' );
	}
}
