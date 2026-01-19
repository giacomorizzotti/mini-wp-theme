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
	//$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

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
	$wp_customize->add_setting( 'show-tagline', array( 'default' => true ) );
	$wp_customize->add_setting( 'logo-height', array( 'default' => '' ) );
	$wp_customize->add_setting( 'scroll-logo-height', array( 'default' => '' ) );
	$wp_customize->add_setting( 'menu-toggle-height', array( 'default' => '' ) );
	$wp_customize->add_setting( 'scroll-menu-toggle-height', array( 'default' => '' ) );

	// Control
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'show-tagline',
			array(
				'label' => __( 'Show tagline', 'mini' ),
				'section' => 'title_tagline',
				'settings' => 'show-tagline',
				'type' => 'checkbox',
			)
		)
	);
	// Logo height
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'logo-height',
			array(
				'label' => __( 'Logo height', 'mini' ),
				'section' => 'title_tagline',
				'settings' => 'logo-height',
				'description' => __( 'Enter the logo and menu toggle height for top or scrolled screen', 'mini' )
			)
		)
	);
	// Scroll logo height
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'scroll-logo-height',
			array(
				'label' => __( 'Logo height (scrolled)', 'mini' ),
				'section' => 'title_tagline',
				'settings' => 'scroll-logo-height'
			)
		)
	);
	// Menu toggle height
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'menu-toggle-height',
			array(
				'label' => __( 'Menu toggle height', 'mini' ),
				'section' => 'title_tagline',
				'settings' => 'menu-toggle-height'
			)
		)
	);
	// Scroll menu toggle height
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'scroll-menu-toggle-height',
			array(
				'label' => __( 'Menu toggle height (scrolled)', 'mini' ),
				'section' => 'title_tagline',
				'settings' => 'scroll-menu-toggle-height'
			)
		)
	);
	
}
add_action('customize_register', 'wpctmz_logo_height');



function wpctmz_color_palette( $wp_customize ){

	//Setting
	$wp_customize->add_setting( 'main-color', array( 'default' => '#1b9958' ) );
	$wp_customize->add_setting( 'main-color-dark', array( 'default' => '#155f39' ) );
	$wp_customize->add_setting( 'main-color-transp', array( 'default' => '#1b994725' ) );
	
	$wp_customize->add_setting( 'second-color', array( 'default' => '#025A5B' ) );
	$wp_customize->add_setting( 'second-color-dark', array( 'default' => '#003838' ) );
	
	$wp_customize->add_setting( 'third-color', array( 'default' => '#FF512C' ) );
	$wp_customize->add_setting( 'third-color-dark', array( 'default' => '#8D3522' ) );
	
	$wp_customize->add_setting( 'fourth-color', array( 'default' => '#5E0099' ) );
	$wp_customize->add_setting( 'fourth-color-dark', array( 'default' => '#2F004D' ) );
	
	$wp_customize->add_setting( 'link-color', array( 'default' => '#00C68F' ) );
	$wp_customize->add_setting( 'link-hover-color', array( 'default' => '#20896C' ) );
	
	$wp_customize->add_setting( 'menu-toggle-color', array( 'default' => '#141428' ) );
	
	$wp_customize->add_setting( 'theme-color', array( 'default' => '#1b9958' ) );
	
	$wp_customize->add_setting( 'semaphore-info-color', array( 'default' => '#4ba99f' ) );
	$wp_customize->add_setting( 'semaphore-success-color', array( 'default' => '#a5db67' ) );
	$wp_customize->add_setting( 'semaphore-warning-color', array( 'default' => '#ffbb6e' ) );
	$wp_customize->add_setting( 'semaphore-danger-color', array( 'default' => '#fb7467' ) );
	$wp_customize->add_setting( 'semaphore-bad-color', array( 'default' => '#eb3750' ) );
	//Section
	$wp_customize->add_section(
		'color-settings',
		array(
			'title' => __( 'Color settings', 'mini' ),
			'priority' => 30,
			'description' => __( 'Enter the custom colors', 'mini' )
		)
	);

	//Control
	//Main color
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'main-color',
			array(
				'label' => __( 'Main color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'main-color',
			)
		)
	);
	//Main color dark
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'main-color-dark',
			array(
				'label' => __( 'Main color dark', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'main-color-dark',
			)
		)
	);
	//Main color transparent
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'main-color-transp',
			array(
				'label' => __( 'Main color transparent', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'main-color-transp',
			)
		)
	);

	//Second color
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'second-color',
			array(
				'label' => __( 'Second color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'second-color',
			)
		)
	);
	//Second color dark
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'second-color-dark',
			array(
				'label' => __( 'Second color dark', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'second-color-dark',
			)
		)
	);

	//Third color
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'third-color',
			array(
				'label' => __( 'Third color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'third-color',
			)
		)
	);
	//Third color dark
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'third-color-dark',
			array(
				'label' => __( 'Third color dark', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'third-color-dark',
			)
		)
	);

	//Fourth color
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'fourth-color',
			array(
				'label' => __( 'Fourth color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'fourth-color',
			)
		)
	);
	//Fourth color dark
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'fourth-color-dark',
			array(
				'label' => __( 'Fourth color dark', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'fourth-color-dark',
			)
		)
	);

	//Link color
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'link-color',
			array(
				'label' => __( 'Link color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'link-color',
			)
		)
	);
	//Link hover color
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'link-hover-color',
			array(
				'label' => __( 'Link hover color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'link-hover-color',
			)
		)
	);

	//Sheet color
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'sheet-color',
			array(
				'label' => __( 'Sheet color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'sheet-color',
			)
		)
	);
	//Menu toggle color
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'menu-toggle-color',
			array(
				'label' => __( 'Menu toggle color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'menu-toggle-color',
			)
		)
	);

	//theme color
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'theme-color',
			array(
				'label' => __( 'Theme color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'theme-color',
			)
		)
	);

	/*
	
	//Semaphore color - Info
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'semaphore-info-color',
			array(
				'label' => __( 'Info color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'semaphore-info-color',
			)
		)
	);
	//Semaphore color - Success
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'semaphore-success-color',
			array(
				'label' => __( 'Success color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'semaphore-success-color',
			)
		)
	);
	//Semaphore color - Warning
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'semaphore-warning-color',
			array(
				'label' => __( 'Warning color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'semaphore-warning-color',
			)
		)
	);
	//Semaphore color - Danger
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'semaphore-danger-color',
			array(
				'label' => __( 'Danger color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'semaphore-danger-color',
			)
		)
	);
	//Semaphore color - Bad
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'semaphore-bad-color',
			array(
				'label' => __( 'Bad color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'semaphore-bad-color',
			)
		)
	);

	*/
	
}
add_action('customize_register', 'wpctmz_color_palette');

