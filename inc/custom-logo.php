<?php
function mini_custom_logo_setup() {
	$defaults = array(
		'height'               => 512,
		'width'                => 512,
		'flex-height'          => true,
		'flex-width'           => true,
		'header-text'          => array( 'site-title', 'site-description' ),
		'unlink-homepage-logo' => false, 
	);
	add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'mini_custom_logo_setup' );