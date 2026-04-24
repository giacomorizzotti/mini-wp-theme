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

<article id="post-<?php the_ID(); ?>" <?php post_class( mini_get_archive_col_class() . ' my-0 p-0' ); ?> template="content-match">

	<div class="container fw">
		<div class="container<?php if ( ! is_home() && ! is_archive() ) { echo ' ' . esc_attr( $layout['container_width'] ); } ?>">
			<div class="boxes">
				<header class="box-100 entry-header">
				<?php
					if ( is_singular() && empty( $args['is_shortcode'] ) ) {
						the_title( '<h1 class="entry-title">', '</h1>' );
					} else {
						the_title( '<h2 class="entry-title m-0"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="black-text">', '</a></h2>' );
					}
					?>
					<div class="space"></div>
				</header><!-- .entry-header -->
			</div>
		</div>
	</div>
	
	<div class="container<?php if ( ! is_home() && ! is_archive() ) { echo ' ' . esc_attr( $layout['container_width'] ); } ?>">

		<?php
		if (
			get_post_meta($post->ID, 'team_1') != null && 
			get_post_meta($post->ID, 'team_2') != null
		):
		if (
			(is_singular() && !empty( $args['is_shortcode'] )) || (is_singular() && empty( $args['is_shortcode'] ) && !has_post_thumbnail()) || is_archive() || is_home()
		):
		?>
		<div class="boxes">
			<div class="box-zero-50 <?php if ( get_post_meta($post->ID, 'team_1_score')[0] ):?>box-sm-40<?php else: ?>box-sm-25<?php endif; ?>">
				<div class="boxes justify-content-between oh g-0<?php if ( get_post_meta($post->ID, 'team_1_score')[0] ):?> fw-bg<?php else: ?> fw-bg<?php endif; ?> b-rad-25 box-shadow border light-grey-border">
					<?php if ( get_post_meta($post->ID, 'team_1_logo')[0] ):?>
					<div class="<?php if ( get_post_meta($post->ID, 'team_1_score')[0] ):?>box-50<?php else: ?>box-100<?php endif; ?> p-15 pb-0 square order-zero-2 order-sm-1">
						<div class="p-15 wh-bg block h-100 box-shadow-light" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
							<div style="background-color: white; background-image: url('<?= get_post_meta($post->ID, 'team_1_logo')[0]?>'); background-position: center; background-size: contain; background-repeat: no-repeat; display: block; width: 100%; height: 100%;"></div>
						</div>
					</div>
					<?php endif; ?>
					<?php if ( get_post_meta($post->ID, 'team_1_score')[0] ):?>
					<div class="box-50 flex align-items-center justify-content-center order-zero-1 order-sm-2">
						<h3 class="huge center m-0"><?= get_post_meta($post->ID, 'team_1_score')[0] ?></h3>
					</div>
					<?php endif; ?>
					<div class="box-100 black-bg box-shadow-dark order-3 px-15">
						<h2 class="XL white-text m-0 center"><?= get_post_meta($post->ID, 'team_1')[0] ?></h2>
					</div>
				</div>
			</div>
			<div class="box-zero-50 <?php if ( get_post_meta($post->ID, 'team_2_score')[0] ):?>box-sm-40<?php else: ?>box-sm-25<?php endif; ?>">
				<div class="boxes justify-content-between oh g-0<?php if ( get_post_meta($post->ID, 'team_2_score')[0] ):?> fw-bg<?php else: ?> fw-bg<?php endif; ?> b-rad-25 box-shadow border light-grey-border">
					<?php if ( get_post_meta($post->ID, 'team_2_logo')[0] ):?>
					<div class="<?php if ( get_post_meta($post->ID, 'team_2_score')[0] ):?>box-50<?php else: ?>box-100<?php endif; ?> p-15 pb-0 square order-zero-2 order-sm-1">
						<div class="p-15 wh-bg block h-100 box-shadow-light" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
							<div style="background-color: white; background-image: url('<?= get_post_meta($post->ID, 'team_2_logo')[0]?>'); background-position: center; background-size: contain; background-repeat: no-repeat; display: block; width: 100%; height: 100%;"></div>
						</div>
					</div>
					<?php endif; ?>
					<?php if ( get_post_meta($post->ID, 'team_2_score')[0] ):?>
					<div class="box-50 flex align-items-center justify-content-center order-zero-1 order-sm-2">
						<h3 class="huge center m-0"><?= get_post_meta($post->ID, 'team_2_score')[0] ?></h3>
					</div>
					<?php endif; ?>
					<div class="box-100 black-bg box-shadow-dark order-3 px-15">
						<h2 class="XL white-text m-0 center"><?= get_post_meta($post->ID, 'team_2')[0] ?></h2>
					</div>
				</div>
			</div>
		</div>
		<div class="space-2"></div>
		<?php endif; ?>
		<?php endif; ?>
		<?php 
		if (
			get_post_meta($post->ID, 'event_date')[0] != null ||
			get_post_meta($post->ID, 'event_time')[0] != null ||
			get_post_meta($post->ID, 'location_name')[0] != null ||
			get_post_meta($post->ID, 'location_address')[0] != null
		):
		?>
		<div class="boxes align-items-start align-content-start">
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
				<?php if ( !is_singular() || (is_singular() && !empty( $args['is_shortcode'] )) ): ?>
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
