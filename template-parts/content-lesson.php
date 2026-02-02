<?php
/**
 * Template part for displaying lesson posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

// Get page layout settings if not already set
if ( ! isset( $layout ) ) {
	$layout = mini_get_page_layout();
}
$it_date_month = new IntlDateFormatter(
    'it_IT',
    IntlDateFormatter::FULL,
    IntlDateFormatter::FULL,
    'Europe/Rome',
    IntlDateFormatter::GREGORIAN,
	'MMMM'
);
$it_date_day_name = new IntlDateFormatter(
    'it_IT',
    IntlDateFormatter::FULL,
    IntlDateFormatter::FULL,
    'Europe/Rome',
    IntlDateFormatter::GREGORIAN,
	'EEEE'
);
$it_date_day_number = new IntlDateFormatter(
    'it_IT',
    IntlDateFormatter::FULL,
    IntlDateFormatter::FULL,
    'Europe/Rome',
    IntlDateFormatter::GREGORIAN,
	'dd'
);
$it_date_year = new IntlDateFormatter(
    'it_IT',
    IntlDateFormatter::FULL,
    IntlDateFormatter::FULL,
    'Europe/Rome',
    IntlDateFormatter::GREGORIAN,
	'yyyy'
);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class("box box-100 my-0 p-0"); ?>>

	<div class="container fw">
		<div class="container<?php if ( ! is_home() && ! is_archive() ) { echo ' ' . esc_attr( $layout['container_width'] ); } ?>">
			<div class="boxes">
				<header class="box box-100 entry-header">
				<?php
					// Show parent course breadcrumb for singular lesson view
					if ( is_singular() && $post->post_parent ) {
						$parent = get_post( $post->post_parent );
						if ( $parent && $parent->post_type === 'course' ) {
							echo '<p class="S m-0 mb-1">';
							echo '<a href="' . esc_url( get_permalink( $parent->ID ) ) . '" class="second-color-text">';
							echo '← ' . esc_html__( 'Back to', 'mini' ) . ' ' . esc_html( $parent->post_title );
							echo '</a>';
							echo '</p>';
						}
					}
					
					if ( is_singular() ) {
						the_title( '<h1 class="entry-title big inline-block">', '</h1>' );
					} else {
						the_title( '<h2 class="entry-title inline-block"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="m-0 bk-text">', '</a></h2>' );
					}
					?>
				</header><!-- .entry-header -->
			</div>
		</div>
	</div>
	
	<div class="container<?php if ( ! is_home() && ! is_archive() ) { echo ' ' . esc_attr( $layout['container_width'] ); } ?>">

		<div class="boxes justify-content-between">
			<?php 
			if (
				get_post_meta($post->ID, 'event_date')[0] != null ||
				get_post_meta($post->ID, 'event_time')[0] != null ||
				get_post_meta($post->ID, 'location_name')[0] != null ||
				get_post_meta($post->ID, 'location_address')[0] != null
			):
			?>
			<div class="<?php if ( has_post_thumbnail() ) echo 'box-50'; else echo 'box-100'; ?> entry-content">
				<?php 
					if ( get_post_meta($post->ID, 'event_date') != null ) {
						$date = strtotime(get_post_meta($post->ID, 'event_date')[0]);
						$date_day_name = $it_date_day_name->format($date);
						$date_day_number = $it_date_day_number->format($date);
						$date_month = $it_date_month->format($date);
						$date_year = $it_date_year->format($date);
					}
				?>
				<?php if ( get_post_meta($post->ID, 'event_date') != null ): ?>
				<div class="date-box">
					<h3 class="m-0 label regular"><?= __( 'Date', 'mini' ) ?></h3>
					<div class="space"></div>
					<p class="XL m-0">
						<span class=""><?= ucfirst($date_day_name) ?></span><br/>
						<span class="bold third-color-box b-rad-5"><?= $date_day_number ?>&nbsp;<?= ucfirst($date_month) ?>&nbsp;<span class="false-white-text h5 light"><?= $date_year ?></span></span>
						
					</p>
				</div>
				<div class="space-2"></div>
				<?php endif; ?>
				<?php 
					if ( get_post_meta($post->ID, 'event_time') != null ) {
						$time = strtotime(get_post_meta($post->ID, 'event_time')[0]);
						$time_hour = date('H', $time);
						$time_minute = date('i', $time);
					}
					if ( get_post_meta($post->ID, 'event_end_time') != null ) {
						$end_time = strtotime(get_post_meta($post->ID, 'event_end_time')[0]);
						$end_time_hour = date('H', $end_time);
						$end_time_minute = date('i', $end_time);
					}
				?>
				<?php if ( get_post_meta($post->ID, 'event_time') != null ): ?>
				<div class="time-box">
					<h3 class="m-0 label regular"><?= __( 'Time', 'mini' ) ?></h3>
					<div class="space"></div>
					<p class="XL m-0">
						<span class="bold third-color-box b-rad-5">
							<?= $time_hour ?>:<?= $time_minute ?>
						</span><?php if ( get_post_meta($post->ID, 'event_end_time') != null ): ?>&nbsp;-&nbsp;<span class="bold third-color-box b-rad-5"><?= $end_time_hour ?>:<?= $end_time_minute ?></span>
						<?php endif; ?>	
					</p>
				</div>
				<div class="space-2"></div>
				<?php endif; ?>
				<?php
				if ( get_post_meta(get_the_ID(), 'location_name')[0] != null ):
				?>
				<div class="location-box">
					<h3 class="m-0 label regular"><?= __( 'Location', 'mini' ) ?></h3>
					<div class="space"></div>
					<p class="m-0 bold XL">
						<?= get_post_meta(get_the_ID(), 'location_name')[0] ?>
					</p>
					<?php
					if ( get_post_meta(get_the_ID(), 'location_address')[0] != null ):
					?>
					<p class="m-0">
						<?= get_post_meta(get_the_ID(), 'location_address')[0] ?>
					</p>
					<?php endif; ?>
				</div>
				<div class="space-2"></div>
				<?php endif; ?>
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
			</div>
			<?php endif; ?>

			<?php if ( has_post_thumbnail() ): ?>
				<div class="box-40 entry-content">
					<img src="<?=get_the_post_thumbnail_url(); ?>" class="img" />
				</div>
			<?php endif; ?>
			</div><!-- .entry-content -->

			<footer class="box-100 my-0 py-0 entry-footer">
				<p class="S"><?php mini_entry_footer(); ?></p>
			</footer><!-- .entry-footer -->
			
		</div>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
