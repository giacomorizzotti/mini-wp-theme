<?php
/**
 * The sidebar for lesson posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mini
 */

if ( ! is_active_sidebar( 'lesson-sidebar' ) ) {
	return;
}
?>

<aside id="sidebar" class="box box-25 my-0 p-0 widget-area">
	<div class="boxes">
		<div class="box box-100 p-2">
			<?php dynamic_sidebar( 'lesson-sidebar' ); ?>
		</div>
	</div>
</aside><!-- #secondary -->
