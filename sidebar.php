<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mini
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="sidebar" class="box box-25 my-0 p-0 widget-area">
	<div class="boxes space-top-bot">
		<div class="box box-100 p-2">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	</div>
</aside><!-- #secondary -->
