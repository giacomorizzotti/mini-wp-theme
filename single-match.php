<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package mini
 */

$container_width = get_post_meta($post->ID, 'page_container', true);

get_header();

?>
	<main id="primary" class="site-main" template="single">

		<?php if ( has_post_thumbnail() ): ?>
			<div class="container fw" style="background-image: url('<?=get_the_post_thumbnail_url(); ?>'); background-position: center; background-size: cover; background-repeat: no-repeat;">
				<div clasS="container">
					<div class="boxes space-top align-items-end" style="min-height: 75vh;">
						<?php
							if (
								get_post_meta($post->ID, 'team_1') != null && 
								get_post_meta($post->ID, 'team_2') != null
							):
						?>			
						<div class="box-zero-50 <?php if ( get_post_meta($post->ID, 'team_1_score')[0] ):?>box-sm-40<?php else: ?>box-sm-25<?php endif; ?> pb-0">
							<div class="boxes justify-content-between oh g-0<?php if ( get_post_meta($post->ID, 'team_1_score')[0] ):?> color-dark-bg<?php else: ?> fw-bg<?php endif; ?>" style="border-top-left-radius: 25px; border-top-right-radius: 25px;">
								<?php if ( get_post_meta($post->ID, 'team_1_logo')[0] ):?>
								<div class="<?php if ( get_post_meta($post->ID, 'team_1_score')[0] ):?>box-50<?php else: ?>box-100<?php endif; ?> p-15 pb-0 square order-zero-2 order-sm-1">
									<div class="p-15 wh-bg block h-100 box-shadow-light" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
										<div style="background-color: white; background-image: url('<?= get_post_meta($post->ID, 'team_1_logo')[0]?>'); background-position: center; background-size: contain; background-repeat: no-repeat; display: block; width: 100%; height: 100%;"></div>
									</div>
								</div>
								<?php endif; ?>
								<?php if ( get_post_meta($post->ID, 'team_1_score')[0] ):?>
								<div class="box-50 flex align-items-center justify-content-center square order-zero-1 order-sm-2">
									<h3 class="huge center wh-text"><?= get_post_meta($post->ID, 'team_1_score')[0] ?></h3>
								</div>
								<?php endif; ?>
								<div class="box-100 second-color-dark-bg box-shadow-dark order-3 px-15">
									<h2 class="XXL wh-text m-0 center"><?= get_post_meta($post->ID, 'team_1')[0] ?></h2>
								</div>
							</div>
						</div>
						<div class="box-zero-50 <?php if ( get_post_meta($post->ID, 'team_2_score')[0] ):?>box-sm-40<?php else: ?>box-sm-25<?php endif; ?> pb-0">
							<div class="boxes justify-content-between oh g-0<?php if ( get_post_meta($post->ID, 'team_2_score')[0] ):?> color-dark-bg<?php else: ?> fw-bg<?php endif; ?>" style="border-top-left-radius: 25px; border-top-right-radius: 25px;">
								<?php if ( get_post_meta($post->ID, 'team_2_logo')[0] ):?>
								<div class="<?php if ( get_post_meta($post->ID, 'team_2_score')[0] ):?>box-50<?php else: ?>box-100<?php endif; ?> p-15 pb-0 square order-zero-2 order-sm-1">
									<div class="p-15 wh-bg block h-100 box-shadow-light" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
										<div style="background-color: white; background-image: url('<?= get_post_meta($post->ID, 'team_2_logo')[0]?>'); background-position: center; background-size: contain; background-repeat: no-repeat; display: block; width: 100%; height: 100%;"></div>
									</div>
								</div>
								<?php endif; ?>
								<?php if ( get_post_meta($post->ID, 'team_2_score')[0] ):?>
								<div class="box-50 flex align-items-center justify-content-center square order-zero-1 order-sm-2">
									<h3 class="huge center wh-text"><?= get_post_meta($post->ID, 'team_2_score')[0] ?></h3>
								</div>
								<?php endif; ?>
								<div class="box-100 second-color-dark-bg box-shadow-dark order-3 px-15">
									<h2 class="XXL wh-text m-0 center"><?= get_post_meta($post->ID, 'team_2')[0] ?></h2>
								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="container fw">
			<div class="container <?=$container_width?>">
				
				<div class="boxes<?php if ( !has_post_thumbnail() ): ?> space-top-bot<?php else: ?> pt-2<?php endif; ?>">
					
					<div class="box my-0 box-75">
						<div class="boxes">
							<?php
							while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/content', get_post_type() );
							?>
							<div class="box-zero-50 fw-bg">
								<p class=""><?php previous_post_link(); ?></p>
							</div>
							<div class="box-zero-50 fw-bg">
								<p class=""><?php next_post_link(); ?></p>
							</div>
							<?php
							endwhile; // End of the loop.
							?>
						</div>
					</div>

					<?php  /*

					<div class="box-25 p-2 fw-bg">
						<h4 class=""><?=esc_html__( 'Monthly archive:', 'mini' )?></h4>
						<ul>
						<?php wp_get_archives( array( 'post_type' => 'event', 'type' => 'monthly' ) ); ?>
						</ul>
						<div class="sep-1 light-grey-bg my-2"></div>
					</div>

					*/ ?>

				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
