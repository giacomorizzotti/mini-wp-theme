<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package mini
 */

get_header();
?>

<main id="primary" class="site-main" template="404">
    <div class="container">
        <div class="boxes fh align-items-center">
            <div class="box-100">
                <p class="max black m-0">404</p>
                <h1 class="m-0 danger-text"><?php esc_html_e( 'Page not found', 'mini' ); ?></h1>
                <p class="L"><?php esc_html_e( "The page you're looking for doesn't exist or has been moved.", 'mini' ); ?></p>
                <div class="space-4"></div>
                <p class="m-0">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn L"><?php esc_html_e( 'Back to homepage', 'mini' ); ?></a>
                </p>
            </div>
        </div>
    </div>
</main><!-- #primary -->

<?php
get_footer();
