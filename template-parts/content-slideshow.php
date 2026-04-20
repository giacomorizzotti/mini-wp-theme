<?php
/**
 * Template part for displaying a slideshow with its child slides.
 *
 * @package mini
 */

$slideshow_id = get_the_ID();
$slideshow_layout = mini_get_page_layout( $slideshow_id );
$container_class = 'container';
if ( $slideshow_layout['container_width'] ) {
	$container_class .= ' ' . esc_attr( $slideshow_layout['container_width'] );
}

$slides = get_posts([
	'post_type'      => 'slide',
	'posts_per_page' => -1,
	'post_parent'    => $slideshow_id,
	'post_status'    => 'publish',
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
]);

if ( empty( $slides ) ) return;
?>
<?php $has_multiple_slides = count( $slides ) > 1; ?>
<div class="<?php echo $container_class; ?>" template="content-slideshow">
    <div class="slider-wrapper">
        <?php if ( $has_multiple_slides ) : ?>
        <i class="iconoir-arrow-left-circle slider-controls" id="slider-prev-<?php echo esc_attr( $slideshow_id ); ?>"></i>
        <?php endif; ?>

        <ul class="slider fh" id="slider-<?php echo esc_attr( $slideshow_id ); ?>">
            <?php foreach ( $slides as $slide ) :
                setup_postdata( $GLOBALS['post'] = $slide );
                get_template_part( 'template-parts/content', 'slide', [ 'slideshow_id' => $slideshow_id ] );
            endforeach;
            wp_reset_postdata();
            ?>
        </ul>

        <?php if ( $has_multiple_slides ) : ?>
        <i class="iconoir-arrow-right-circle slider-controls" id="slider-next-<?php echo esc_attr( $slideshow_id ); ?>"></i>
        <?php endif; ?>
    </div>
</div>
<script>
(function() {
    var header = document.getElementById('header');
    if ( ! header ) return;

    // Capture the page-level top-* class before any slide overrides it
    var topClasses = ['top-wh','top-bk','top-col','top-inv'];
    var pageTopClass = topClasses.find(function(c) { return header.classList.contains(c); }) || '';

    function getActiveHeaderTop(slider) {
        var center = slider.scrollLeft + slider.offsetWidth / 2;
        var closest = null, minDist = Infinity;
        Array.from(slider.children).forEach(function(slide) {
            var dist = Math.abs((slide.offsetLeft + slide.offsetWidth / 2) - center);
            if ( dist < minDist ) { minDist = dist; closest = slide; }
        });
        return closest ? (closest.dataset.headerTop || '') : '';
    }

    function applyHeaderTop(value) {
        topClasses.forEach(function(c) { header.classList.remove(c); });
        var cls = value !== '' ? value : pageTopClass;
        if ( cls ) header.classList.add(cls);
    }

    var slider = document.getElementById('slider-<?php echo esc_js( (string) $slideshow_id ); ?>');
    if ( ! slider ) return;

    var scrollTimer;
    slider.addEventListener('scroll', function() {
        clearTimeout(scrollTimer);
        scrollTimer = setTimeout(function() {
            applyHeaderTop( getActiveHeaderTop(slider) );
        }, 80);
    });

    // Apply immediately for the first slide
    applyHeaderTop( getActiveHeaderTop(slider) );
}());
</script>