<?php
/**
 * Template part for displaying posts
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

<article id="post-<?php the_ID(); ?>" <?php post_class("box-100 my-0 p-0"); ?> template="content-event">

	<?php if (!is_singular() || is_singular() && !has_post_thumbnail()): ?>
	<div class="container fw mb-2">
		<?php if ( has_post_thumbnail() && !is_singular()): ?><div class="fit" style="background-image: url('<?= get_the_post_thumbnail_url(get_the_ID(), 'full') ?>'); background-size: cover; background-position: center; border-top-left-radius: 20px; border-top-right-radius: 20px;"></div><?php endif; ?>
		<div class="container<?php if ( ! is_home() && ! is_archive() ) { echo ' ' . esc_attr( $layout['container_width'] ); } ?>">
			<div class="boxes<?php if ( has_post_thumbnail() && !is_singular()): ?> h25 align-items-end<?php endif; ?>">
				<header class="box-100 entry-header<?php if ( has_post_thumbnail() && !is_singular()): ?> p-2<?php endif; ?>">
				<?php
					if ( is_singular() ) {
						the_title( '<h1 class="entry-title big inline-block">', '</h1>' );
					} else {
						the_title( '<h2 class="entry-title m-0"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="' . ( has_post_thumbnail() && !is_singular() ? 'white-box' : 'black-text' ) . '">', '</a></h2>' );
						if ( has_post_thumbnail() && !is_singular()) { echo '<div class="space" style="height:calc( var(--margin) * 4 );"></div>';}
					}
					?>
				</header><!-- .entry-header -->
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="container<?php if ( ! is_home() && ! is_archive() ) { echo ' ' . esc_attr( $layout['container_width'] ); } ?>">

		<div class="boxes">
			<?php if ( get_post_meta(get_the_ID(), 'event_poster_id', true) ): ?>
			<div class="box-33 entry-content"<?php if ( has_post_thumbnail() && !is_singular()): ?> style="margin-top: calc( var(--margin) * 7 * -1 );"<?php endif; ?>>
				<img src="<?= wp_get_attachment_image_url(get_post_meta(get_the_ID(), 'event_poster_id', true), 'large') ?>" class="img p-15 fw-bg b-rad-10" style="max-width: 420px;" />
			</div>
			<?php endif; ?>
			<?php 
			if (
				get_post_meta($post->ID, 'event_date')[0] != null ||
				get_post_meta($post->ID, 'event_time')[0] != null ||
				get_post_meta($post->ID, 'location_name')[0] != null ||
				get_post_meta($post->ID, 'location_address')[0] != null
			):
			?>
			<div class="box-66 entry-content">
                <div class="flex flex-flow-column-wrap justify-content-start align-items-start">
					<?php 
						if ( get_post_meta($post->ID, 'event_date')[0] != null ) {
							$date = strtotime(get_post_meta($post->ID, 'event_date')[0]);
							$date_day_name = $it_date_day_name->format($date);
							$date_day_number = $it_date_day_number->format($date);
							$date_month = $it_date_month->format($date);
							$date_year = $it_date_year->format($date);
						}
					?>
					<?php if ( get_post_meta($post->ID, 'event_date')[0] != null ): ?>
					<div class="date-box">
						<div class="flex">
							<p class="m-0 huge black center" style="line-height: 1!important;">
								<span class="square flex align-items-center justify-content-center box-shadow white-box p-15 m-0" style="min-width: 140px;"><?= $date_day_number ?></span>
							</p>
							<div class="flex align-items-start flex-direction-column oh">
								<div>
									<p class="m-0 up-case <?php if ( is_singular() ): ?>L<?php else: ?><?php endif; ?>">
										<span class="fw-box m-0 py-1 px-15"><?= $date_day_name ?></span>
									</p>
								</div>
								<div class="flex align-items-start flex-direction-row">
									<span class="white-box bold XL m-0 py-05 px-15 box-shadow"><?= ucfirst($date_month) ?></span><span class="fw-box light m-0" style="vertical-align: bottom;"><?= $date_year ?></span>
								</div>
								<?php 
									if (get_post_meta($post->ID, 'event_time')[0] != null) {
										$time = date('H:i', strtotime(get_post_meta($post->ID, 'event_time')[0]));
									}
								?>
								<div class="time-box m-0">
									<p class="m-0 wh-text up-case bold" >
										<?php 
											if (get_post_meta($post->ID, 'event_end_time')[0] != null) {
												$end_time = date('H:i', strtotime(get_post_meta($post->ID, 'event_end_time')[0]));
											}
										?>
										<?php if ( get_post_meta($post->ID, 'event_time')[0] != null ): ?>
										<span class="fw-box m-0 py-1 px-15"><i class="iconoir-clock"></i>&nbsp;&nbsp;<?=$time?><?php if ( get_post_meta($post->ID, 'event_end_time')[0] != null ): ?> <span class="light">-</span> <?=$end_time?><?php endif; ?></span>
										<?php endif; ?>
									</p>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<?php
					if ( get_post_meta(get_the_ID(), 'location_name')[0] != null ):
					?>
					<div class="location-box">
						<div class="space-2"></div>
						<h4 class="m-0 bold XL">
							<?= get_post_meta(get_the_ID(), 'location_name')[0] ?>
						</h4>
						<?php endif; ?>
						<?php
						if ( get_post_meta(get_the_ID(), 'location_address')[0] != null ):
						?>
						<p class="mt-05">
							<i class="iconoir-map-pin" style="vertical-align: text-top;"></i>&nbsp;&nbsp;<?= get_post_meta(get_the_ID(), 'location_address')[0] ?>
						</p>
					</div>
					<?php endif; ?>
				</div>
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
			</div><!-- .entry-content -->

			<footer class="box-100 my-0 py-0 entry-footer">
				<p class="S"><?php mini_entry_footer(); ?></p>
			</footer><!-- .entry-footer -->

			<div class="space-3"></div>
			
		</div>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
