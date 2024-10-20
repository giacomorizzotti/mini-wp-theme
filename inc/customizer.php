<?php
/**
 * mini Theme Customizer
 *
 * @package mini
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mini_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'mini_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'mini_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'mini_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function mini_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function mini_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mini_customize_preview_js() {
	wp_enqueue_script( 'mini-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'mini_customize_preview_js' );



function wpctmz_logo_height( $wp_customize ){

	//Setting
	$wp_customize->add_setting( 'logo-height', array( 'default' => '' ) );
	$wp_customize->add_setting( 'scroll-logo-height', array( 'default' => '' ) );

	//Section
	$wp_customize->add_section(
		'logo-height-settings',
		array(
			'title' => __( 'Logo height', '_s' ),
			'priority' => 30,
			'description' => __( 'Enter the logo height for top or scrolled screen', '_s' )
		)
	);

	//Control
	//Logo height
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'logo-height',
			array(
				'label' => __( 'Logo height', '_s' ),
				'section' => 'logo-height-settings',
				'settings' => 'logo-height'
			)
		)
	);
	//Scroll logo height
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'scroll-logo-height',
			array(
				'label' => __( 'Logo height (scrolled)', '_s' ),
				'section' => 'logo-height-settings',
				'settings' => 'scroll-logo-height'
			)
		)
	);
	
}
add_action('customize_register', 'wpctmz_logo_height');