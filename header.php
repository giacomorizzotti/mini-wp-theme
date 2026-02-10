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

// Get header styling for current page
$header_styling = mini_get_header_styling();
$header_top_style = $header_styling['top'];
$header_scroll_style = $header_styling['scroll'];

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico">

	<?php wp_head(); ?>

    <?php if ( mini_check_option( 'mini_colors_options', 'mini_theme_color' ) ): ?>
		<meta name="theme-color" content="<?php echo esc_attr( mini_get_option( 'mini_colors_options', 'mini_theme_color' ) ); ?>" />
	<?php endif; ?>

	<style>
		:root {
		<?php
		mini_css_variable( 'mini_colors_options', 'mini_semaphore_color_info', '--info' );
		mini_css_variable( 'mini_colors_options', 'mini_semaphore_color_success', '--success' );
		mini_css_variable( 'mini_colors_options', 'mini_semaphore_color_warning', '--warning' );
		mini_css_variable( 'mini_colors_options', 'mini_semaphore_color_danger', '--danger' );
		mini_css_variable( 'mini_colors_options', 'mini_semaphore_color_bad', '--bad' );
		mini_css_variable( 'mini_colors_options', 'mini_blacks_color_black', '--black' );
		mini_css_variable( 'mini_colors_options', 'mini_blacks_color_false_black', '--false-black' );
		mini_css_variable( 'mini_colors_options', 'mini_blacks_color_dark_grey', '--dark-grey' );
		mini_css_variable( 'mini_colors_options', 'mini_blacks_color_grey', '--grey' );
		mini_css_variable( 'mini_colors_options', 'mini_blacks_color_light_grey', '--light-grey' );
		mini_css_variable( 'mini_colors_options', 'mini_blacks_color_false_white', '--false-white' );
		mini_css_variable( 'mini_colors_options', 'mini_blacks_color_false_white_transp', '--false-white-transp' );
		mini_css_variable( 'mini_colors_options', 'mini_blacks_color_white', '--white' );
		mini_css_variable( 'mini_colors_options', 'mini_blacks_color_transp', '--transp' );
		
		// Font usage variables that reference the base font variables
		mini_css_variable( 'mini_font_options', 'mini_most_used_font', '--font-main', true );
		mini_css_variable( 'mini_font_options', 'mini_most_used_font', '--text-font', true );
		?>
		--font: var(--font-main);
		<?php
		mini_css_variable( 'mini_font_options', 'mini_title_font', '--title-font', true );

		if ( get_theme_mod( 'logo-height' ) ) { 
			echo esc_html( '--logo-height:' . get_theme_mod( 'logo-height' ) . ';' ); 
		}
		if ( get_theme_mod( 'scroll-logo-height' ) ) { 
			echo esc_html( '--scroll-logo-height:' . get_theme_mod( 'scroll-logo-height' ) . ';' ); 
		}
		if ( get_theme_mod( 'menu-toggle-height' ) ) { 
			echo esc_html( '--menu-toggle-height:' . get_theme_mod( 'menu-toggle-height' ) . ';' ); 
		}
		if ( get_theme_mod( 'scroll-menu-toggle-height' ) ) { 
			echo esc_html( '--scroll-menu-toggle-height:' . get_theme_mod( 'scroll-menu-toggle-height' ) . ';' ); 
		}
		
		mini_css_variable( 'mini_colors_options', 'mini_main_color', '--main-color' );
		mini_css_variable( 'mini_colors_options', 'mini_main_color_dark', '--main-color-dark' );
		mini_css_variable( 'mini_colors_options', 'mini_main_color_transp', '--main-color-transp' );
		if ( get_theme_mod( 'main-color' ) ) { 
			echo esc_html( '--main-color:' . get_theme_mod( 'main-color' ) . ';' ); 
		}
		if ( get_theme_mod( 'main-color-dark' ) ) { 
			echo esc_html( '--main-color-dark:' . get_theme_mod( 'main-color-dark' ) . ';' ); 
		}
		if ( get_theme_mod( 'main-color-transp' ) ) {
			$color = get_theme_mod( 'main-color-transp' );
			$opacity = get_theme_mod( 'main-color-transp-opacity', 25 );
			// Convert hex to RGB and add opacity
			$hex = str_replace('#', '', $color);
			$r = hexdec(substr($hex, 0, 2));
			$g = hexdec(substr($hex, 2, 2));
			$b = hexdec(substr($hex, 4, 2));
			$alpha = $opacity / 100;
			echo esc_html( '--main-color-transp:rgba(' . $r . ', ' . $g . ', ' . $b . ', ' . $alpha . ');' );
		}
		
		mini_css_variable( 'mini_colors_options', 'mini_second_color', '--second-color' );
		mini_css_variable( 'mini_colors_options', 'mini_second_color_dark', '--second-color-dark' );
		if ( get_theme_mod( 'second-color' ) ) { 
			echo esc_html( '--second-color:' . get_theme_mod( 'second-color' ) . ';' ); 
		}
		if ( get_theme_mod( 'second-color-dark' ) ) { 
			echo esc_html( '--second-color-dark:' . get_theme_mod( 'second-color-dark' ) . ';' ); 
		}
		
		mini_css_variable( 'mini_colors_options', 'mini_third_color', '--third-color' );
		mini_css_variable( 'mini_colors_options', 'mini_third_color_dark', '--third-color-dark' );
		if ( get_theme_mod( 'third-color' ) ) { 
			echo esc_html( '--third-color:' . get_theme_mod( 'third-color' ) . ';' ); 
		}
		if ( get_theme_mod( 'third-color-dark' ) ) { 
			echo esc_html( '--third-color-dark:' . get_theme_mod( 'third-color-dark' ) . ';' ); 
		}
		
		mini_css_variable( 'mini_colors_options', 'mini_fourth_color', '--fourth-color' );
		mini_css_variable( 'mini_colors_options', 'mini_fourth_color_dark', '--fourth-color-dark' );
		if ( get_theme_mod( 'fourth-color' ) ) { 
			echo esc_html( '--fourth-color:' . get_theme_mod( 'fourth-color' ) . ';' ); 
		}
		if ( get_theme_mod( 'fourth-color-dark' ) ) { 
			echo esc_html( '--fourth-color-dark:' . get_theme_mod( 'fourth-color-dark' ) . ';' ); 
		}
		
		mini_css_variable( 'mini_colors_options', 'mini_link_color', '--link-color' );
		mini_css_variable( 'mini_colors_options', 'mini_link_hover_color', '--link-hover-color' );
		if ( get_theme_mod( 'link-color' ) ) { 
			echo esc_html( '--link-color:' . get_theme_mod( 'link-color' ) . ';' ); 
		}
		if ( get_theme_mod( 'link-hover-color' ) ) { 
			echo esc_html( '--link-hover-color:' . get_theme_mod( 'link-hover-color' ) . ';' ); 
		}
		
		mini_css_variable( 'mini_colors_options', 'mini_menu_toggle_color', '--menu-toggle-color' );
		if ( get_theme_mod( 'menu-toggle-color' ) ) { 
			echo esc_html( '--menu-toggle-color:' . get_theme_mod( 'menu-toggle-color' ) . ';' ); 
		}

		?>
		}
	</style>

<?php if ( mini_check_option( 'mini_ext_lib_options', 'mini_iconoir' ) ): ?>
	<link href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css" rel="stylesheet">
<?php endif; ?>

<?php if ( mini_check_option( 'mini_ext_lib_options', 'mini_aos' ) ): ?>
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<?php endif; ?>

<?php
if ( 
	mini_check_option( 'mini_analytics_options', 'mini_google_analytics' ) &&
	mini_check_option( 'mini_analytics_options', 'mini_google_analytics_code' )
) {
	$ga_code = mini_get_option( 'mini_analytics_options', 'mini_google_analytics_code' );
?>
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga_code ); ?>"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', '<?php echo esc_js( $ga_code ); ?>');
	</script>
<?php
}
?>

</head>

<body <?php body_class('mini'); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'mini' ); ?></a>
    <div class="loader"></div>
    <div id="top"></div>
    <a href="#top"><div class="top-link"><p class=""><i class="iconoir-dot-arrow-up"></i></p></div></a>

	<div id="sheet" class="grad-second"><?php /* starting .sheet div */ ?>

		<header id="header" class="header <?php echo esc_attr( $header_top_style ); ?> <?php echo esc_attr( $header_scroll_style ); ?>">
			<div class="container">
				<div class="boxes p-1 flex-flow-row-nowrap align-items-center justify-content-between">
					<div class="box brand px-1">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="" rel="home">
							<?php if ( has_custom_logo() ): ?>
								<?php the_custom_logo(); ?>
							<?php else: ?>
								<img src="<?php if ( mini_check_option( 'mini_cdn_options', 'cdn_dev' ) ): ?>https://serversaur.doingthings.space/mini/img/brand/mini_emblem.svg<?php else: ?>https://mini.uwa.agency/img/brand/mini_emblem.svg<?php endif; ?>" class="logo emblem me-1" alt="emblem"/>
							<?php endif; ?>
						</a>
						<?php
						$mini_title = get_bloginfo( 'name', 'display' );
						$mini_description = get_bloginfo( 'description', 'display' );
						
						if ( ( $mini_title && get_theme_mod( 'header_text' ) == 1 ) || is_customize_preview() ):
						?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="" rel="home">
								<h3 class="site-title"><?php bloginfo( 'name' ); ?></h3>
							</a>
						<?php endif; ?>
						
						<?php if ( ( $mini_description && get_theme_mod( 'header_text' ) == 1 && get_theme_mod( 'show-tagline', true ) ) || is_customize_preview() ): ?>
							<div class="sep"></div>
							<div class="space-05"></div>
							<p class="site-description m-0"><?php echo esc_html( $mini_description ); ?></p>
						<?php endif; ?>
					</div>
					<div class="box menus px-2">
						<div id="menu-toggle"><div class="line"></div><div class="line"></div><div class="line"></div></div>
						<div id="head-menu" class="head-menu">
							<nav id="page-menu" class="menu page-menu">
								<ul class="menu page-menu m-0">
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</header>
		
		<aside id="side-right" class="">
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
