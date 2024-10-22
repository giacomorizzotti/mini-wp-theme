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
	$wp_customize->add_setting( 'logo-height', array( 'default' => '' ) );
	$wp_customize->add_setting( 'scroll-logo-height', array( 'default' => '' ) );

	//Section
	$wp_customize->add_section(
		'logo-height-settings',
		array(
			'title' => __( 'Logo height', '_s' ),
			'priority' => 30,
			'description' => __( 'Enter the logo height for top or scrolled screen', 'mini' )
		)
	);

	//Control
	//Logo height
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'logo-height',
			array(
				'label' => __( 'Logo height', 'mini' ),
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
				'label' => __( 'Logo height (scrolled)', 'mini' ),
				'section' => 'logo-height-settings',
				'settings' => 'scroll-logo-height'
			)
		)
	);
	
}
add_action('customize_register', 'wpctmz_logo_height');



function wpctmz_color_palette( $wp_customize ){

	//Setting
	$wp_customize->add_setting( 'main-color', array( 'default' => 'rgb( 60 90 255 / 100% )' ) );
	$wp_customize->add_setting( 'main-color-dark', array( 'default' => 'rgb( 50 75 180 / 100% )' ) );
	$wp_customize->add_setting( 'main-color-transp', array( 'default' => 'rgb( 60 90 255 / 20% )' ) );
	
	$wp_customize->add_setting( 'second-color', array( 'default' => 'rgb( 50 75 180 / 100% )' ) );
	$wp_customize->add_setting( 'second-color-dark', array( 'default' => 'rgb( 37 56 133 / 100% )' ) );
	
	$wp_customize->add_setting( 'third-color', array( 'default' => 'rgb( 60 30 99 / 100% )' ) );
	$wp_customize->add_setting( 'third-color-dark', array( 'default' => 'rgb( 34 15 61 / 100% )' ) );
	
	$wp_customize->add_setting( 'fourth-color', array( 'default' => 'rgb( 220 230 0 / 100% )' ) );
	$wp_customize->add_setting( 'fourth-color-dark', array( 'default' => 'rgb( 180 190 0 / 100% )' ) );
	
	$wp_customize->add_setting( 'link-color', array( 'default' => 'rgb(121 48 238 / 100% )' ) );
	$wp_customize->add_setting( 'link-hover-color', array( 'default' => 'rgb(72 34 176 / 100% )' ) );
	
	$wp_customize->add_setting( 'sheet-color', array( 'default' => 'rgb( 20 10 40 / 100% )' ) );
	$wp_customize->add_setting( 'menu-toggle-color', array( 'default' => 'rgb( 20 10 40 / 100% )' ) );
	
	$wp_customize->add_setting( 'theme-color', array( 'default' => 'rgb( 60 90 255 / 100% )' ) );
	
	/*
	$wp_customize->add_setting( 'semaphore-info-color', array( 'default' => 'rgb( 113 202 189 )' ) );
	$wp_customize->add_setting( 'semaphore-success-color', array( 'default' => 'rgb( 160 220 110 )' ) );
	$wp_customize->add_setting( 'semaphore-warning-color', array( 'default' => 'rgb( 248 187 83 )' ) );
	$wp_customize->add_setting( 'semaphore-danger-color', array( 'default' => 'rgb( 255 111 97 )' ) );
	$wp_customize->add_setting( 'semaphore-bad-color', array( 'default' => 'rgb( 235 55 80 )' ) );
	*/

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
		new WP_Customize_Control(
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
		new WP_Customize_Control(
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
		new WP_Customize_Control(
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
		new WP_Customize_Control(
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
		new WP_Customize_Control(
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
		new WP_Customize_Control(
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
		new WP_Customize_Control(
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
		new WP_Customize_Control(
			$wp_customize, 'fourth-color',
			array(
				'label' => __( 'Third color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'fourth-color',
			)
		)
	);
	//Fourth color dark
	$wp_customize->add_control(
		new WP_Customize_Control(
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
		new WP_Customize_Control(
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
		new WP_Customize_Control(
			$wp_customize, 'link-hover-color',
			array(
				'label' => __( 'Link hover color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'link-hover-color',
			)
		)
	);

	//Link color
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, 'sheet-color',
			array(
				'label' => __( 'Sheet color', 'mini' ),
				'section' => 'color-settings',
				'settings' => 'sheet-color',
			)
		)
	);
	//Link hover color
	$wp_customize->add_control(
		new WP_Customize_Control(
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
		new WP_Customize_Control(
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