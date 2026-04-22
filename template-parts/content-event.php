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

<article id="post-<?php the_ID(); ?>" <?php post_class("box-100 my-0 p-0 white-bg"); ?> template="content-event">

	<?php if ( !is_singular() || ( is_singular() && !empty( $args['is_shortcode'] ) ) || ( is_singular() && empty( $args['is_shortcode'] ) && !has_post_thumbnail() ) ): ?>
	<div class="container fw mb-2">
		<?php if ( has_post_thumbnail() ): ?><div class="fit" style="background-image: url('<?= get_the_post_thumbnail_url(get_the_ID(), 'full') ?>'); background-size: cover; background-position: center; border-top-left-radius: 20px; border-top-right-radius: 20px;"></div><?php endif; ?>
		<div class="container<?= ' ' . esc_attr( $layout['container_width'] ) ?>">
			<div class="boxes <?php if ( has_post_thumbnail() ): ?><?php if ( is_singular() ): ?>h25<?php else: ?>h33<?php endif; ?><?php endif; ?> align-items-end">
				<header class="box-100 p-2 entry-header">
				<?php
					if ( is_singular() && empty( $args['is_shortcode'] ) ) {
						the_title( '<h1 class="entry-title inline-block m-0 white-box">', '</h1>' );
					} else {
						the_title( '<h2 class="entry-title inline-block m-0 white-box"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="black-text">', '</a></h2>' );
					}
						if ( has_post_thumbnail() && get_post_meta(get_the_ID(), 'event_poster_id', true)) { echo '<div class="space" style="height:calc( var(--margin) * 4 );"></div>';}
					?>
				</header><!-- .entry-header -->
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="container<?= ' ' . esc_attr( $layout['container_width'] ) ?>">
		<div class="boxes">
			<?php if ( get_post_meta(get_the_ID(), 'event_poster_id', true) ): ?>
			<div class="box-33 entry-content ps-2 pe-0"<?php if ( has_post_thumbnail()): ?> style="margin-top: calc( var(--margin) * <?php if ( is_singular() && empty( $args['is_shortcode'] ) ): ?>10<?php else: ?>7<?php endif; ?> * -1 );"<?php endif; ?>>
				<img src="<?= wp_get_attachment_image_url(get_post_meta(get_the_ID(), 'event_poster_id', true), 'large') ?>" class="img p-1 white-bg b-rad-5 box-shadow" style="max-width: 420px;" />
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
			<div class="box-66 entry-content px-2">
                <div class="flex flex-flow-column-wrap justify-content-start align-items-start relative">
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
					<div class="date-box w-100" style="max-width: 100%;">
						<div class="flex">
							<p class="m-0 huge black center relative z-1" style="line-height: 1!important;">
								<span class="square flex align-items-center justify-content-center box-shadow white-box p-15 m-0 b-rad-10" style="min-width: <?php if ( is_singular() && empty( $args['is_shortcode'] ) ): ?>120px<?php else: ?>100px<?php endif; ?>;"><?= $date_day_number ?></span>
							</p>
							<div class="flex align-items-start flex-direction-column" style="flex-grow: 1;">
								<div>
									<p class="m-0 up-case <?php if ( is_singular() && empty( $args['is_shortcode'] ) ): ?>L<?php else: ?><?php endif; ?>">
										<span class="inline-block py-05 px-15"><?= $date_day_name ?></span>
									</p>
								</div>
								<div class="flex align-items-start flex-direction-row relative">
									<span class="white-box bold <?php if ( is_singular() && empty( $args['is_shortcode'] ) ): ?>XXL py-05<?php else: ?>XL<?php endif; ?> m-0 py-0 px-15 box-shadow"><?= ucfirst($date_month) ?></span>
									<span class="absolute light flag black-box b-rad-5 px-05" style="right: 0; transform: translate(75%, -50%);"><?= $date_year ?></span>
								</div>
								<?php 
									if (get_post_meta($post->ID, 'event_time')[0] != null) {
										$time = date('H:i', strtotime(get_post_meta($post->ID, 'event_time')[0]));
									}
								?>
								<div class="time-box m-0">
									<p class="m-0 up-case bold" >
										<?php 
											if (get_post_meta($post->ID, 'event_end_time')[0] != null) {
												$end_time = date('H:i', strtotime(get_post_meta($post->ID, 'event_end_time')[0]));
											}
										?>
										<?php if ( get_post_meta($post->ID, 'event_time')[0] != null ): ?>
										<span class="inline-block py-05 px-15"><i class="iconoir-clock"></i>&nbsp;&nbsp;<?=$time?><?php if ( get_post_meta($post->ID, 'event_end_time')[0] != null ): ?> <span class="light">-</span> <?=$end_time?><?php endif; ?></span>
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
				if ( !is_singular() || !empty( $args['is_shortcode'] ) ) {
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
			
		</div>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
