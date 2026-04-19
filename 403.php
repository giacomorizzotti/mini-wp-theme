<?php
/**
 * The template for displaying 403 pages (forbidden / access denied)
 *
 * @package mini
 */

get_header();
?>

<main id="primary" class="site-main" template="404">
    <div class="container">
        <div class="boxes fh align-items-center">
            <div class="box-100">
                <p class="max black m-0">403</p>
                <h1 class="m-0 danger-text"><?php esc_html_e( 'Access denied', 'mini' ); ?></h1>
                <p class="L"><?php esc_html_e( "You don't have permission to view this page.", 'mini' ); ?></p>
                <div class="space-4"></div>
                <p class="m-0">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn L"><?php esc_html_e( 'Back to homepage', 'mini' ); ?></a>
					<?php if ( ! is_user_logged_in() ) : ?>
                    &nbsp;
                    <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="btn-invert L"><?php esc_html_e( 'Log in', 'mini' ); ?></a>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</main><!-- #primary -->

<?php
get_footer();
