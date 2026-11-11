<?php
/**
 * Example Override: Custom Single Post Template
 * 
 * This is an example of how to override the single.php template.
 * 
 * To use:
 * 1. Copy this file and rename it (e.g., single.php)
 * 2. Remove the .example extension
 * 3. Customize as needed
 * 
 * This template will be used instead of the core theme's single.php
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        while (have_posts()) :
            the_post();
            
            // You can customize this to use different template parts
            // or create your own content structure
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php
                    if (is_singular()) :
                        the_title('<h1 class="entry-title">', '</h1>');
                    else :
                        the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                    endif;
                    ?>
                    
                    <div class="entry-meta">
                        <!-- Custom meta information -->
                        <span class="posted-on">
                            <?php echo get_the_date(); ?>
                        </span>
                        <span class="byline">
                            <?php echo __('by', 'mini') . ' ' . get_the_author(); ?>
                        </span>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php
                    the_content();
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'mini'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <footer class="entry-footer">
                    <?php
                    // Custom footer content
                    the_tags('<span class="tags-links">', ', ', '</span>');
                    ?>
                </footer>
            </article>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;

        endwhile; // End of the loop.
        ?>

    </main>
</div>

<?php
get_sidebar();
get_footer();
