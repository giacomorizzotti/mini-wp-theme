<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class("box box-100 my-0 p-0"); ?>>

	<div class="container fw">
		<div class="container">
			<div class="boxes">
				<?php if (has_post_thumbnail()): ?>
				<div class="box-66">
				<?php
					if ( !is_singular() ):
				?>
					<a href="<?=get_the_permalink()?>">
						<img src="<?=get_the_post_thumbnail_url(); ?>" class="img"/>
					</a>
				<?php
					else:
				?>
					<img src="<?=get_the_post_thumbnail_url(); ?>" class="img"/>
				<?php
					endif;
				?>
				</div>
				<?php endif; ?>
				<header class="box box-100 my-0 entry-header">
					<p class="grey-text">
						<?= get_the_date() ?>
					</p>
				<?php
					if ( is_singular() ) {
						the_title( '<h1 class="entry-title m-0">', '</h1>' );
					} else {
						the_title( '<h2 class="entry-title m-0"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="m-0 bk-text">', '</a></h2>' );
					}
					?>
				</header><!-- .entry-header -->
			</div>
		</div>
	</div>
	
	<div class="container">

		<div class="boxes">

			<div class="box box-100 entry-content">
				<?php
				if ( !is_singular() && has_excerpt() ) {
					the_excerpt();
				} else {
					the_content(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'mini' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							wp_kses_post( get_the_title() )
						)
					);
				}
				if ( !is_singular() ):
				?>
				<p class="">
					<a href="<?=get_the_permalink()?>" class="btn"><?=esc_html__( 'Read more', 'mini' )?></a>
				</p>
				<?php
				endif;
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mini' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->
			<div class="sep-10 bk-bg mx-1" style="width: 10px;"></div>
			<footer class="box box-100 my-0 entry-footer">
				<p class="S"><?php mini_entry_footer(); ?></p>
			</footer><!-- .entry-footer -->
		</div>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
