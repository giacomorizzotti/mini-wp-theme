<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mini
 */

$container_width = get_post_meta($post->ID, 'page_container', true);
get_header();
$args = array(
	'post_type' => 'match',
	'meta_key'	=> 'event_date',
	'orderby'	=> 'meta_value',
	'order'		=> 'DESC',
);
$the_query = new WP_Query( $args );

?>

	<main id="primary" class="site-main" template="archive">
		<div class="container fw">
			<div class="container">
				<div class="boxes space-top-bot">
					<div class="box-75 my-0<?php if($container_width=='fw'): ?> p-0<?php endif; ?>">
						<div class="boxes">
							<?php if ( $the_query->have_posts() ) : ?>
								<header class="page-header box-100">
									<h1 class="m-0"> <span class="italic light-grey-text light m-0"><?= esc_html__( 'Matches', 'mini') ?></span></h1>
								</header>
							<?php
								/* Start the Loop */
								while ( $the_query->have_posts() ) :
									$the_query->the_post();
									get_template_part( 'template-parts/content', get_post_type() );
								endwhile;
								the_posts_navigation();
							else :
								get_template_part( 'template-parts/content', 'none' );
							endif;
							?>
						</div>
					</div>
					<div class="box-25 p-2">
						<h4 class=""><?=esc_html__( 'Monthly archive', 'mini' )?>:</h4>
						<ul>
						<?php wp_get_archives( array( 'post_type' => 'match', 'type' => 'monthly' ) ); ?>
						</ul>
						<div class="sep-1 light-grey-bg my-2"></div>
					</div>
				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
