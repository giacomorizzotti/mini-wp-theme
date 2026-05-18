<?php
/**
 * The sidebar for landing pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mini
 */

if ( ! is_active_sidebar( 'landing-page-sidebar' ) ) {
	return;
}
?>

<aside id="sidebar" class="box-25 my-0 p-0 widget-area">
	<div class="boxes">
		<div class="box-100 p-2">
			<?php dynamic_sidebar( 'landing-page-sidebar' ); ?>
		</div>
	</div>
</aside><!-- #secondary -->
