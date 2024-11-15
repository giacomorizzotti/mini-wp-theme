<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

$container_width = get_post_meta($post->ID, 'page_container', true);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class("box box-100 my-0 p-0"); ?>>

	<div class="container fw">
		<div class="container<?php if ( !is_home() && !is_archive() ){echo ' '.$container_width;}?>">
			<div class="boxes">
				<header class="box box-100 my-0 entry-header">
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
	
	<div class="container<?php if ( !is_home() && !is_archive() ){echo ' '.$container_width;}?>">

		<div class="boxes">
			<?php
			if ( 
				get_post_meta(get_the_ID(), 'location_name') != null ||
				get_post_meta(get_the_ID(), 'location_address') != null
			):
			?>
			<div class="box-100 my-0">
				<?php
				if ( get_post_meta(get_the_ID(), 'location_name') != null ):
				?>
				<h4 class="m-0 bold XL '.$text_color.'">
					<?= get_post_meta(get_the_ID(), 'location_name')[0] ?>
				</h4>
				<?php endif; ?>
				<?php
				if ( get_post_meta(get_the_ID(), 'location_address') != null ):
				?>
				<p class="m-0 L '.$text_color.'">
					<?= get_post_meta(get_the_ID(), 'location_address')[0] ?>
				</p>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<?php if ( has_post_thumbnail() ): ?>
				<div class="box box-50 entry-content">
					<img src="<?=get_the_post_thumbnail_url(); ?>" class="img" />
				</div>
			<?php endif; ?>
			<?php 
				if (
					get_post_meta($post->ID, 'event_date') != null ||
					get_post_meta($post->ID, 'event_time') != null
				):
			?>
			<div class="box box-33">
                <div class="flex flex-flow-column-wrap justify-content-start align-items-start">
				<?php 
					if ( get_post_meta($post->ID, 'event_date') != null ) {
						$event_date = strtotime(get_post_meta($post->ID, 'event_date')[0]);
						$event_date_day_name = date('l', $event_date);
						$event_date_day = date('j', $event_date);
						$event_date_month = date('F', $event_date);
						$event_date_year = date('Y', $event_date);
					}
				?>
					<div class="date-box <?php if ( is_singular() ): ?>p-2<?php else: ?>p-1<?php endif; ?> color-bg pe-4">
						<p class="m-0 wh-text up-case light <?php if ( is_singular() ): ?>L<?php else: ?><?php endif; ?>" style="line-height: 1.4!important;">
						<?= $event_date_day_name ?>
						</p>
						<p class="m-0 wh-text bold <?php if ( is_singular() ): ?>XXL<?php else: ?>XL<?php endif; ?>" style="line-height: 1!important;">
						<?= $event_date_day ?>
						</p>
						<p class="m-0 wh-text bold <?php if ( is_singular() ): ?>XXL<?php else: ?>XL<?php endif; ?>" style="line-height: 1.2!important;">
						<?= $event_date_month ?>
						</p>
						<p class="m-0 wh-text <?php if ( is_singular() ): ?><?php else: ?>S<?php endif; ?>">
						<?= $event_date_year ?>
						</p>
					</div>
				<?php 
                    if (get_post_meta($post->ID, 'event_time') != null) {
                        $event_time = date('H:i', strtotime(get_post_meta($post->ID, 'event_date')[0]));
					}
				?>
					<div class="time-box <?php if ( is_singular() ): ?>py-1 px-2<?php else: ?>py-05 px-1<?php endif; ?> color-dark-bg">
						<p class="m-0 wh-text up-case <?php if ( is_singular() ): ?>L<?php else: ?><?php endif; ?>" >
							<?= esc_html__( 'Time', 'mini' ).': '.$event_time ?>
						</p>
					</div>
				<?php 
                    if (
                        get_post_meta($post->ID, 'event_end_date') != null || 
                        get_post_meta($post->ID, 'event_end_time') != null
                    ):
				?>
					<div class="day-box <?php if ( is_singular() ): ?>py-1 px-2<?php else: ?>py-05 px-1<?php endif; ?> light-grey-bg">
						<p class="m-0 dark-grey-text up-case <?php if ( is_singular() ): ?><?php else: ?>S<?php endif; ?>">
							<?= esc_html__( 'End', 'mini' ).': ' ?>
				<?php
					if ( get_post_meta($post->ID, 'event_end_date') != null ) {
						$event_end_date = date('j F Y', strtotime(get_post_meta($post->ID, 'event_end_date')[0]));
						echo $event_end_date;
					}
				?>
				<?php
					if (
						get_post_meta($post->ID, 'event_end_date') != null && 
						get_post_meta($post->ID, 'event_end_time') != null
					):
				?>
				&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
				<?php endif; ?>
				<?php
					if ( get_post_meta($post->ID, 'event_end_time') != null ) {
						$event_end_time = date('H:i', strtotime(get_post_meta($post->ID, 'event_date')[0]));
						echo $event_end_time;
					}
				?>
						</p>
					</div>
				<?php endif; ?>
				</div>
        
			</div>
			<?php endif; ?>

			<div class="box box-66 entry-content">
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
				
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mini' ),
						'after'  => '</div>',
					)
				);
				?>
				<?php if ( !is_singular() ): ?>
				<p class="">
					<a href="<?=get_the_permalink()?>" class="btn btn-bg"><?=esc_html__( 'Read more', 'mini' )?></a>
				</p>
				<?php endif; ?>
			</div><!-- .entry-content -->

			<footer class="box box-100 my-0 py-0 entry-footer">
				<p class="S"><?php mini_entry_footer(); ?></p>
			</footer><!-- .entry-footer -->

			<div class="sep-1 light-grey-bg m-2"></div>
			
		</div>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
