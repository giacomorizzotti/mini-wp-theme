<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

$container_width = get_post_meta($post->ID, 'page_container', true);
$title_presence = get_post_meta($post->ID, 'title_presence', true);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class("box box-100 my-0 p-0"); ?>>

	<?php if ($title_presence == true && !has_post_thumbnail()): ?>
	<div class="container fw forced"
		<?php if ( has_post_thumbnail() ): ?>style="background-image: url('<?=get_the_post_thumbnail_url(); ?>'); background-size: cover; background-position: center center;"<?php endif; ?>
		>
		<div class="container<?php if ($container_width!='fw'): ?><?=' '.$container_width?><?php endif; ?>">
			<div class="boxes space-top<?php if ( has_post_thumbnail() ): ?> hfh align-content-end<?php endif; ?>">
				<div class="box box-100 my-2">
					<header class="entry-header">
						<?php if ( has_post_thumbnail() ): ?>
						<?php the_title( '<h1 class="entry-title wh-box m-0">', '</h1>' ); ?>
						<?php else: ?>
						<?php the_title( '<h1 class="entry-title m-0">', '</h1>' ); ?>
						<?php endif; ?>
					</header><!-- .entry-header -->
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="container <?=$container_width?>">

		<div class="entry-content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mini' ),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->
		
		<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'mini' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<div class="container"><span class="edit-link">',
				'</span></div>'
			);
			?>
		</footer><!-- .entry-footer -->
		<?php endif; ?>

	</div>
</article><!-- #post-<?php the_ID(); ?> -->
