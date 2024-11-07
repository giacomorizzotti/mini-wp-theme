<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mini
 */

 $sidebar_presence = get_post_meta($post->ID, 'sidebar_presence', true);
if ( ! is_active_sidebar( 'sidebar-1' ) &&  $sidebar_presence != false ) {
	return;
}
?>

<aside id="sidebar" class="box box-25 my-0 p-0 widget-area">
	<div class="boxes">
		<div class="box box-100 p-2">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	</div>
</aside><!-- #secondary -->
