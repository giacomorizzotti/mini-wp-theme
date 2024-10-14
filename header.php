<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mini
 */


?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

	<style>
		:root {<?php
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_main_color', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_main_color'] != null 
		) {
			echo '--main-color:'.get_option( 'mini_colors_options' )['mini_main_color'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_main_color_dark', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_main_color_dark'] != null 
		) {
			echo '--main-color-dark:'.get_option( 'mini_colors_options' )['mini_main_color_dark'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_main_color_transp', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_main_color_transp'] != null 
		) {
			echo '--main-color-transp:'.get_option( 'mini_colors_options' )['mini_main_color_transp'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_second_color', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_second_color'] != null 
		) {
			echo '--second-color:'.get_option( 'mini_colors_options' )['mini_second_color'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_second_color_dark', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_second_color_dark'] != null 
		) {
			echo '--second-color-dark:'.get_option( 'mini_colors_options' )['mini_second_color_dark'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_third_color', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_third_color'] != null 
		) {
			echo '--third-color:'.get_option( 'mini_colors_options' )['mini_third_color'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_third_color_dark', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_third_color_dark'] != null 
		) {
			echo '--third-color-dark:'.get_option( 'mini_colors_options' )['mini_third_color_dark'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_fourth_color', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_fourth_color'] != null 
		) {
			echo '--fourth-color:'.get_option( 'mini_colors_options' )['mini_fourth_color'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_second_color', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_second_color'] != null 
		) {
			echo '--second-color:'.get_option( 'mini_colors_options' )['mini_second_color'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_second_color_dark', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_second_color_dark'] != null 
		) {
			echo '--second-color-dark:'.get_option( 'mini_colors_options' )['mini_second_color_dark'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_fourth_color_dark', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_fourth_color_dark'] != null 
		) {
			echo '--fourth-color-dark:'.get_option( 'mini_colors_options' )['mini_fourth_color_dark'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_link_color', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_link_color'] != null 
		) {
			echo '--link-color:'.get_option( 'mini_colors_options' )['mini_link_color'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_link_hover_color', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_link_hover_color'] != null 
		) {
			echo '--link-hover-color:'.get_option( 'mini_colors_options' )['mini_link_hover_color'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_sheet_color', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_sheet_color'] != null 
		) {
			echo '--sheet-color:'.get_option( 'mini_colors_options' )['mini_sheet_color'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_menu_toggle_color', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_menu_toggle_color'] != null 
		) {
			echo '--menu-toggle-color:'.get_option( 'mini_colors_options' )['mini_menu_toggle_color'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_semaphore_color_info', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_semaphore_color_info'] != null 
		) {
			echo '--info:'.get_option( 'mini_colors_options' )['mini_semaphore_color_info'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_semaphore_color_success', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_semaphore_color_success'] != null 
		) {
			echo '--success:'.get_option( 'mini_colors_options' )['mini_semaphore_color_success'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_semaphore_color_warning', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_semaphore_color_warning'] != null 
		) {
			echo '--warning:'.get_option( 'mini_colors_options' )['mini_semaphore_color_warning'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_semaphore_color_danger', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_semaphore_color_danger'] != null 
		) {
			echo '--danger:'.get_option( 'mini_colors_options' )['mini_semaphore_color_danger'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_semaphore_color_bad', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_semaphore_color_bad'] != null 
		) {
			echo '--bad:'.get_option( 'mini_colors_options' )['mini_semaphore_color_bad'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_blacks_color_black', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_blacks_color_black'] != null 
		) {
			echo '--black:'.get_option( 'mini_colors_options' )['mini_blacks_color_black'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_blacks_color_false_black', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_blacks_color_false_black'] != null 
		) {
			echo '--false-black:'.get_option( 'mini_colors_options' )['mini_blacks_color_false_black'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_blacks_color_dark_grey', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_blacks_color_dark_grey'] != null 
		) {
			echo '--dark-grey:'.get_option( 'mini_colors_options' )['mini_blacks_color_dark_grey'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_blacks_color_grey', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_blacks_color_grey'] != null 
		) {
			echo '--grey:'.get_option( 'mini_colors_options' )['mini_blacks_color_grey'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_blacks_color_light_grey', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_blacks_color_light_grey'] != null 
		) {
			echo '--light-grey:'.get_option( 'mini_colors_options' )['mini_blacks_color_light_grey'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_blacks_color_false_white', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_blacks_color_false_white'] != null 
		) {
			echo '--false-white:'.get_option( 'mini_colors_options' )['mini_blacks_color_false_white'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_blacks_color_false_white_transp', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_blacks_color_false_white_transp'] != null 
		) {
			echo '--false-white-transp:'.get_option( 'mini_colors_options' )['mini_blacks_color_false_white_transp'].';';
		}
		if ( 
			is_array(get_option( 'mini_colors_options' )) && 
			array_key_exists('mini_blacks_color_white', get_option( 'mini_colors_options' ) ) && 
			get_option( 'mini_colors_options' )['mini_blacks_color_white'] != null 
		) {
			echo '--white:'.get_option( 'mini_colors_options' )['mini_blacks_color_white'].';';
		}
		?>}
	</style>
</head>

<body <?php body_class('mini'); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'mini' ); ?></a>
    <div class="loader"></div>
    <div id="top"></div>
    <a href="#top"><div class="top-link"><p class=""><i class="iconoir-dot-arrow-up"></i></p></div></a>

	<header id="header" class="header">
        <div class="container">
            <div class="boxes align-items-center justify-content-between">
                <div class="box brand px-2">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="" retl="home">
						<?php if (has_custom_logo()): ?>
                        <?php the_custom_logo(); ?>
                        <?php else: ?>
							<img src="https://mini.uwa.agency/img/brand/mini_emblem.svg" class="logo emblem me-1" alt="emblem"/>
						<?php endif; ?>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="" retl="home"><h3 class="site-title"><?php bloginfo( 'name' ); ?></h3></a>
					<?php /*
					$mini_description = get_bloginfo( 'description', 'display' );
					if ( $mini_description || is_customize_preview() ) :
					?>
						<p class="site-description"><?php echo $mini_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<?php endif; */?>
                </div>
                <div class="box menus px-2">
                    <div id="menu-toggle"><div class="line"></div><div class="line"></div><div class="line"></div></div>
                    <div id="head-menu" class="head-menu">
                        <nav class="menu page-menu">
                            <ul id="page-menu" class="menu page-menu">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

	<div class="sheet"><?php /* starting .sheet div */ ?>

		<aside id="side-menu" class="">
			<nav class="menu main-menu">
				<?php
				wp_nav_menu(
					array(
						'menu'           => 'main-menu',
						'theme_location' => 'main-menu',
						'container'		 => 'ul',
						'menu_id'        => 'main-menu',
						'menu_class'     => 'menu main-menu',
					)
				);
				?>
			</nav>
			<nav class="menu user-menu">
				<?php
				wp_nav_menu(
					array(
						'menu'           => 'user-menu',
						'theme_location' => 'user-menu',
						'container'		 => 'ul',
						'menu_id'        => 'user-menu',
						'menu_class'     => 'menu user-menu',
					)
				);
				?>
			</nav>
		</aside>
