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

$header_top_style = get_post_meta($post->ID, 'header_styling_top', true);
$header_scroll_style = get_post_meta($post->ID, 'header_styling_scroll', true);
$custom_logo = get_custom_logo();

function variable_from_option($options_group, $option, $variable_name, $var_refer=false) {
	$options = get_option( $options_group );
	if ( 
		is_array($options) && 
		array_key_exists($option, $options) && 
		$options[$option] != null 
	) {
		if ($var_refer==true) {
			$variable = $variable_name.':var('.$options[$option].');';
		} else {
			$variable = $variable_name.':'.$options[$option].';';
		}
		echo $variable;
	}
}
function check_variable_from_option($options_group, $option) {
	$options = get_option( $options_group );
	if ( 
		is_array($options) && 
		array_key_exists($option, $options) && 
		$options[$option] != null 
	) {
		return true;
	} else {
		return false;
	}
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

    <?php if ( check_variable_from_option('mini_colors_options','mini_semaphore_color_info') == true ): ?>
		<?php if (get_theme_mod( 'sheet-color' )): ?>
			<meta name="theme-color" content="<?= get_theme_mod( 'sheet-color' ) ?>" />
		<?php else: ?>
			<meta name="theme-color" content="<?= get_option('mini_colors_options')['mini_theme_color'] ?>" />
		<?php endif; ?>
	<?php endif; ?>

	<style>
		:root {
		<?php
		variable_from_option('mini_colors_options','mini_semaphore_color_info','--info');
		variable_from_option('mini_colors_options','mini_semaphore_color_success','--success');
		variable_from_option('mini_colors_options','mini_semaphore_color_warning','--warning');
		variable_from_option('mini_colors_options','mini_semaphore_color_danger','--danger');
		variable_from_option('mini_colors_options','mini_semaphore_color_bad','--bad');
		variable_from_option('mini_colors_options','mini_blacks_color_black','--black');
		variable_from_option('mini_colors_options','mini_blacks_color_false_black','--false-black');
		variable_from_option('mini_colors_options','mini_blacks_color_dark_grey','--dark-grey');
		variable_from_option('mini_colors_options','mini_blacks_color_grey','--grey');
		variable_from_option('mini_colors_options','mini_blacks_color_light_grey','--light-grey');
		variable_from_option('mini_colors_options','mini_blacks_color_false_white','--false-white');
		variable_from_option('mini_colors_options','mini_blacks_color_false_white_transp','--false-white-transp');
		variable_from_option('mini_colors_options','mini_blacks_color_white','--white');
		variable_from_option('mini_colors_options','mini_blacks_color_transp','--transp');
		variable_from_option('mini_font_options','mini_title_font','--title-font', true);
		variable_from_option('mini_font_options','mini_most_used_font','--font', true);

		//variable_from_option('mini_size_options','mini_logo_height','--logo-height');
		//variable_from_option('mini_size_options','mini_scroll_logo_height','--scroll-logo-height');
		if (get_theme_mod( 'logo-height' )) { echo '--logo-height:'.get_theme_mod( 'logo-height' ).';'; }
		if (get_theme_mod( 'scroll-logo-height' )) { echo '--scroll-logo-height:'.get_theme_mod( 'scroll-logo-height' ).';'; }
		
		variable_from_option('mini_colors_options','mini_main_color','--main-color');
		variable_from_option('mini_colors_options','mini_main_color_dark','--main-color-dark');
		variable_from_option('mini_colors_options','mini_main_color_transp','--main-color-transp');
		if (get_theme_mod( 'main-color' )) { echo '--main-color:'.get_theme_mod( 'main-color' ).';'; }
		if (get_theme_mod( 'main-color-dark' )) { echo '--main-color-dark:'.get_theme_mod( 'main-color-dark' ).';'; }
		if (get_theme_mod( 'main-color-transp' )) { echo '--main-color-transp:'.get_theme_mod( 'main-color-transp' ).';'; }
		
		variable_from_option('mini_colors_options','mini_second_color','--second-color');
		variable_from_option('mini_colors_options','mini_second_color_dark','--second-color-dark');
		if (get_theme_mod( 'second-color' )) { echo '--second-color:'.get_theme_mod( 'second-color' ).';'; }
		if (get_theme_mod( 'second-color-dark' )) { echo '--second-color-dark:'.get_theme_mod( 'second-color-dark' ).';'; }
		
		variable_from_option('mini_colors_options','mini_third_color','--third-color');
		variable_from_option('mini_colors_options','mini_third_color_dark','--third-color-dark');
		if (get_theme_mod( 'third-color' )) { echo '--third-color:'.get_theme_mod( 'third-color' ).';'; }
		if (get_theme_mod( 'third-color-dark' )) { echo '--third-color-dark:'.get_theme_mod( 'third-color-dark' ).';'; }
		
		variable_from_option('mini_colors_options','mini_fourth_color','--fourth-color');
		variable_from_option('mini_colors_options','mini_fourth_color_dark','--fourth-color-dark');
		if (get_theme_mod( 'fourth-color' )) { echo '--fourth-color:'.get_theme_mod( 'fourth-color' ).';'; }
		if (get_theme_mod( 'fourth-color-dark' )) { echo '--fourth-color-dark:'.get_theme_mod( 'fourth-color-dark' ).';'; }
		
		variable_from_option('mini_colors_options','mini_link_color','--link-color');
		variable_from_option('mini_colors_options','mini_link_hover_color','--link-hover-color');
		if (get_theme_mod( 'link-color' )) { echo '--link-color:'.get_theme_mod( 'link-color' ).';'; }
		if (get_theme_mod( 'link-hover-color' )) { echo '--link-hover-color:'.get_theme_mod( 'link-hover-color' ).';'; }
		
		variable_from_option('mini_colors_options','mini_sheet_color','--sheet-color');
		variable_from_option('mini_colors_options','mini_menu_toggle_color','--menu-toggle-color');
		if (get_theme_mod( 'sheet-color' )) { echo '--sheet-color:'.get_theme_mod( 'sheet-color' ).';'; }
		if (get_theme_mod( 'menu-toggle-color' )) { echo '--menu-toggle-color:'.get_theme_mod( 'menu-toggle-color' ).';'; }

		?>
		}
	</style>

<?php
	if ( 
		is_array(get_option( 'mini_ext_lib_options' )) && 
		array_key_exists('mini_iconoir', get_option( 'mini_ext_lib_options' ) ) && 
		get_option( 'mini_ext_lib_options' )['mini_iconoir'] != null 
	) {
	?>
<link href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css" rel="stylesheet">
<?php
	}
?>
<?php
	if ( 
		is_array(get_option( 'mini_ext_lib_options' )) && 
		array_key_exists('mini_fontawesome', get_option( 'mini_ext_lib_options' ) ) && 
		get_option( 'mini_ext_lib_options' )['mini_fontawesome'] != null 
	) {
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" />
<?php
	}
?>
<?php
	if ( 
		is_array(get_option( 'mini_ext_lib_options' )) && 
		array_key_exists('mini_aos', get_option( 'mini_ext_lib_options' ) ) && 
		get_option( 'mini_ext_lib_options' )['mini_aos'] != null 
	) {
?>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<?php
	}
?>

<?php
	if ( 
		get_variable('mini_analytics_options','mini_google_analytics') != false &&
		get_variable('mini_analytics_options','mini_google_analytics_code') != false
	) {
?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?=get_variable('mini_analytics_options','mini_google_analytics_code')?>"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag("js", new Date());
	gtag("config", "<?=get_variable('mini_analytics_options','mini_google_analytics_code')?>");
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

	<header id="header" class="header <?=$header_top_style?> <?=$header_scroll_style?>">
        <div class="container">
            <div class="boxes flex-flow-row-nowrap align-items-center justify-content-between">
                <div class="box brand px-2">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="" rel="home">
						<?php if (has_custom_logo()): ?>
                        <?= $custom_logo ?>
                        <?php else: ?>
							<img src="https://mini.uwa.agency/img/brand/mini_emblem.svg" class="logo emblem me-1" alt="emblem"/>
						<?php endif; ?>
                    </a>
					<?php
					$mini_title = get_bloginfo( 'name', 'display' );
					$mini_description = get_bloginfo( 'description', 'display' );
					?>
					<?php
					if ( ( $mini_title && get_theme_mod('header_text') == 1 ) || ( is_customize_preview() && get_theme_mod('header_text') == 1 ) ) :
					?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="" retl="home"><h3 class="site-title"><?php bloginfo( 'name' ); ?></h3></a>
					<?php endif; ?>
					<?php
					if ( ( $mini_description && get_theme_mod('header_text') == 1 ) || ( is_customize_preview() && get_theme_mod('header_text') == 1 ) ) :
					?>
						<div class="sep"></div>
						<div class="space-05"></div>
						<p class="site-description m-0"><?= $mini_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<?php endif; ?>
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
