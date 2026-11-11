<?php
/**
 * Example Override: Custom Content Part
 * 
 * This is an example of how to override a template part from template-parts/
 * 
 * To use:
 * 1. Rename this file to match the part you want to override
 *    (e.g., content-news.php, content-page.php)
 * 2. Remove the .example extension
 * 3. Customize as needed
 */
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
        
        <!-- Custom instance-specific header content -->
        <div class="entry-meta custom-meta">
            <span class="posted-on">
                <i class="icon-calendar"></i>
                <time datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo get_the_date(); ?>
                </time>
            </span>
            
            <span class="author">
                <i class="icon-user"></i>
                <?php the_author_posts_link(); ?>
            </span>
            
            <?php if (has_category()) : ?>
                <span class="categories">
                    <i class="icon-folder"></i>
                    <?php the_category(', '); ?>
                </span>
            <?php endif; ?>
        </div>
    </header>

    <?php if (has_post_thumbnail() && !is_singular()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium_large'); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        if (is_singular()) :
            the_content();
        else :
            the_excerpt();
        endif;
        ?>
        
        <?php if (!is_singular()) : ?>
            <a href="<?php the_permalink(); ?>" class="read-more-link">
                <?php _e('Read More', 'mini'); ?> &rarr;
            </a>
        <?php endif; ?>
    </div>

    <?php if (is_singular()) : ?>
        <footer class="entry-footer">
            <?php
            // Tags
            if (has_tag()) :
                the_tags('<div class="tags-list"><strong>' . __('Tags:', 'mini') . '</strong> ', ', ', '</div>');
            endif;
            
            // Share buttons (example)
            ?>
            <div class="share-buttons">
                <strong><?php _e('Share:', 'mini'); ?></strong>
                <!-- Add your social sharing buttons here -->
            </div>
        </footer>
    <?php endif; ?>
</article>
