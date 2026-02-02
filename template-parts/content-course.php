<?php
/**
 * Template part for displaying course posts
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
				get_post_meta($post->ID, 'event_date') != null ||
				get_post_meta($post->ID, 'event_time') != null ||
				get_post_meta($post->ID, 'location_name') != null ||
				get_post_meta($post->ID, 'location_address') != null
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
					if ( get_post_meta($post->ID, 'event_end_date') != null ) {
						$end_date = strtotime(get_post_meta($post->ID, 'event_end_date')[0]);
						$end_date_day_name = $it_date_day_name->format($end_date);
						$end_date_day_number = $it_date_day_number->format($end_date);
						$end_date_month = $it_date_month->format($end_date);
						$end_date_year = $it_date_year->format($end_date);
					}
				?>
				<?php if ( get_post_meta($post->ID, 'event_date') != null ): ?>
				<div class="date-box">
					<h3 class="m-0 label regular"><?= __( 'Date', 'mini' ) ?></h3>
					<div class="space"></div>
					<p class="XL m-0">
						<span class="bold third-color-text"><?= ucfirst($date_day_name) ?></span><br/>
						<span class="bold third-color-box b-rad-5"><?= $date_day_number ?>&nbsp;<?= ucfirst($date_month) ?>&nbsp;<span class="h5 light false-white-text"><?= $date_year ?></span></span>
						
					</p>
					<?php if ( get_post_meta($post->ID, 'event_end_date') != null ): ?>
					<div class="space-2"></div>
					<h3 class="m-0 label regular"><?= __( 'End date', 'mini' ) ?></h3>
					<div class="space"></div>
					<p class="XL m-0">
						<span class="bold third-color-text"><?= ucfirst($end_date_day_name) ?></span><br/>
						<span class="bold third-color-box b-rad-5"><?= $end_date_day_number ?>&nbsp;<?= ucfirst($end_date_month) ?>&nbsp;<span class="h5 light false-white-text"><?= $end_date_year ?></span></span>
					</p>
					<?php endif; ?>
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
					<a href="<?=get_the_permalink()?>" class="btn fourth-color-btn"><?=esc_html__( 'Read more', 'mini' )?></a>
				</p>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<?php if ( has_post_thumbnail() ): ?>
				<div class="box-40">
					<img src="<?=get_the_post_thumbnail_url(); ?>" class="img" />
				</div>
			<?php endif; ?><!-- .entry-content -->

			<?php if ( is_singular() ): ?>
				<?php
				// Get all lessons for this course
				$lessons = new WP_Query([
					'post_type' => 'lesson',
					'meta_key' => 'parent_course_id',
					'meta_value' => get_the_ID(),
					'orderby' => 'date',
					'order' => 'ASC',
					'posts_per_page' => -1,
					'post_status' => 'publish'
				]);
				
				if ( $lessons->have_posts() ): ?>
				<div class="box box-100 my-2">
					<h3 class="label regular"><?php echo esc_html__( 'Lessons in this course', 'mini' ); ?></h3>
					<div class="space"></div>
					<div class="boxes">
					<?php while ( $lessons->have_posts() ) : $lessons->the_post(); ?>
						<div class="box-20 box-shadow-light b-rad-5 p-15">
							<p class="bold L">
								<a href="<?php the_permalink(); ?>" class="fourth-color-text">
									<?php the_title(); ?>
								</a>
							</p>
							<?php
							$lesson_date = get_post_meta(get_the_ID(), 'event_date', true);
							if ($lesson_date) {
								echo '<p class="S m-0 third-color-box">' . date_i18n(get_option('date_format'), strtotime($lesson_date)) . '</p>';
							}
							?>
							<?php if ( has_excerpt() ): ?>
								<p class="S"><?= get_the_excerpt(); ?></p>
							<?php endif; ?>
						</div>
					<?php endwhile; ?>
					</div>
					<?php wp_reset_postdata(); ?>
				</div>
				<?php endif; ?>
			<?php endif; ?>

			<footer class="box box-100 my-0 py-0 entry-footer">
				<p class="S"><?php mini_entry_footer(); ?></p>
			</footer><!-- .entry-footer -->
			
		</div>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
