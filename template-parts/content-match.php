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

<article id="post-<?php the_ID(); ?>" <?php post_class("box box-100 my-0 p-0"); ?>>

	<div class="container fw">
		<div class="container<?php if ( ! is_home() && ! is_archive() ) { echo ' ' . esc_attr( $layout['container_width'] ); } ?>">
			<div class="boxes">
				<header class="box box-100 entry-header">
					<div class="space"></div>
				<?php
					if ( is_singular() ) {
						the_title( '<h1 class="entry-title second-color-text">', '</h1>' );
					} else {
						the_title( '<h2 class="entry-title second-color-text"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="m-0 wh-text">', '</a></h2>' );
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
			!has_post_thumbnail() || is_archive()
		):
		?>
		<div class="boxes">
			<div class="box-zero-50 <?php if ( get_post_meta($post->ID, 'team_1_score')[0] ):?>box-sm-40<?php else: ?>box-sm-25<?php endif; ?>">
				<div class="boxes justify-content-between oh g-0<?php if ( get_post_meta($post->ID, 'team_1_score')[0] ):?> color-dark-bg<?php else: ?> fw-bg<?php endif; ?> b-rad-25" <?php /*style="border-top-left-radius: 25px; border-top-right-radius: 25px;"*/ ?>>
					<?php if ( get_post_meta($post->ID, 'team_1_logo')[0] ):?>
					<div class="<?php if ( get_post_meta($post->ID, 'team_1_score')[0] ):?>box-50<?php else: ?>box-100<?php endif; ?> p-15 pb-0 square order-zero-2 order-sm-1">
						<div class="p-15 wh-bg block h-100 box-shadow-light" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
							<div style="background-color: white; background-image: url('<?= get_post_meta($post->ID, 'team_1_logo')[0]?>'); background-position: center; background-size: contain; background-repeat: no-repeat; display: block; width: 100%; height: 100%;"></div>
						</div>
					</div>
					<?php endif; ?>
					<?php if ( get_post_meta($post->ID, 'team_1_score')[0] ):?>
					<div class="box-50 flex align-items-center justify-content-center order-zero-1 order-sm-2">
						<h3 class="huge center wh-text m-0"><?= get_post_meta($post->ID, 'team_1_score')[0] ?></h3>
					</div>
					<?php endif; ?>
					<div class="box-100 second-color-dark-bg box-shadow-dark order-3 px-15">
						<h2 class="XL wh-text m-0 center"><?= get_post_meta($post->ID, 'team_1')[0] ?></h2>
					</div>
				</div>
			</div>
			<div class="box-zero-50 <?php if ( get_post_meta($post->ID, 'team_2_score')[0] ):?>box-sm-40<?php else: ?>box-sm-25<?php endif; ?>">
				<div class="boxes justify-content-between oh g-0<?php if ( get_post_meta($post->ID, 'team_2_score')[0] ):?> color-dark-bg<?php else: ?> fw-bg<?php endif; ?> b-rad-25" <?php /*style="border-top-left-radius: 25px; border-top-right-radius: 25px;"*/ ?>>
					<?php if ( get_post_meta($post->ID, 'team_2_logo')[0] ):?>
					<div class="<?php if ( get_post_meta($post->ID, 'team_2_score')[0] ):?>box-50<?php else: ?>box-100<?php endif; ?> p-15 pb-0 square order-zero-2 order-sm-1">
						<div class="p-15 wh-bg block h-100 box-shadow-light" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
							<div style="background-color: white; background-image: url('<?= get_post_meta($post->ID, 'team_2_logo')[0]?>'); background-position: center; background-size: contain; background-repeat: no-repeat; display: block; width: 100%; height: 100%;"></div>
						</div>
					</div>
					<?php endif; ?>
					<?php if ( get_post_meta($post->ID, 'team_2_score')[0] ):?>
					<div class="box-50 flex align-items-center justify-content-center order-zero-1 order-sm-2">
						<h3 class="huge center wh-text m-0"><?= get_post_meta($post->ID, 'team_2_score')[0] ?></h3>
					</div>
					<?php endif; ?>
					<div class="box-100 second-color-dark-bg box-shadow-dark order-3 px-15">
						<h2 class="XL wh-text m-0 center"><?= get_post_meta($post->ID, 'team_2')[0] ?></h2>
					</div>
				</div>
			</div>
		</div>
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
			<div class="box-100 my-0">
				<div class="date-time-box flex flex-wrap">
					<div class="block flex w-100 flex-direction-row flex-wrap">
						<div class="flex">
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
							<p class="m-0" style="line-height: 1!important;">
								<span class="square flex align-items-center justify-content-center second-color-box huge black py-1 px-2 m-0" style="min-width: 140px;"><?= $date_day_number ?></span>
							</p>
							<div class="flex flex-direction-column">
								<div class="flex">
									<p class="m-0 up-case <?php if ( is_singular() ): ?>L<?php else: ?><?php endif; ?>">
										<span class="second-color-dark-box py-1 px-15 m-0"><?= ucfirst($date_day_name) ?></span>
									</p>
								</div>
								<div class="flex">
									<p class="m-0 bold XL">
										<span class="second-color-box p-15 m-0"><?= ucfirst($date_month) ?></span>
									</p>
									<p class="m-0 XL light">
										<span class="second-color-dark-box m-0 p-1"><?= $date_year ?></span>
									</p>
								</div>
								<?php 
									if (get_post_meta($post->ID, 'event_time')[0] != null) {
										$time = date('H:i', strtotime(get_post_meta($post->ID, 'event_time')[0]));
									}
								?>
								<div class="flex">
									<div class="time-box">
										<p class="m-0">
											<span class="second-color-dark-box wh-text px-15 XL bold"><i class="iconoir-clock S"></i> <?= $time ?></span>
										</p>
									</div>
								</div>
							</div>
						</div>
						<?php endif; ?>
						<?php
						if ( get_post_meta(get_the_ID(), 'location_name')[0] != null ):
						?>
							<h4 class="m-0 bold XL py-1 px-15 second-color-box">
								<?= get_post_meta(get_the_ID(), 'location_name')[0] ?>
							</h4>
							<div class="sep"></div>
							<?php endif; ?>
							<?php
							if ( get_post_meta(get_the_ID(), 'location_address')[0] != null ):
							?>
							<p class="m-0 p-1 second-color-dark-box">
								<?= get_post_meta(get_the_ID(), 'location_address')[0] ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( has_excerpt() || get_post()->post_content != '' ): ?>
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
			</div><!-- .entry-content -->
			<?php endif; ?>

			<?php if ( !is_singular() ): ?>
			<div class="box-100">
				<p class="m-0">
					<a href="<?=get_the_permalink()?>" class="second-color-btn b-rad-0 my-0"><?=esc_html__( 'Read more', 'mini' )?></a>
				</p>
			</div>
			<?php endif; ?>

			<footer class="box box-100 my-0 py-0 entry-footer">
				<p class="S"><?php mini_entry_footer(); ?></p>
			</footer><!-- .entry-footer -->
			
		</div>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
