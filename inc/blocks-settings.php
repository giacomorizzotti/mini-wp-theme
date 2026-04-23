<?php
/**
 * mini Blocks settings page
 *
 * Registers and renders the Blocks admin page under the mini menu.
 * All block enable/disable toggles live here in the theme.
 *
 * @package mini
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/* START - mini block category */

add_filter( 'block_categories_all', 'mini_register_block_categories', 10, 2 );
function mini_register_block_categories( $categories ) {
    return array_merge(
        [ [ 'slug' => 'mini', 'title' => 'mini', 'icon' => null ] ],
        $categories
    );
}

/* END - mini block category */

/* START - Blocks settings */

add_action( 'admin_init', 'mini_blocks_settings_init' );
function mini_blocks_settings_init() {
    register_setting( 'mini_blocks', 'mini_blocks_settings', [
        'sanitize_callback' => 'mini_blocks_sanitize_settings',
    ] );
    add_settings_section(
        'mini_blocks_section',
        __( 'mini Gutenberg blocks', 'mini' ),
        'mini_blocks_section_callback',
        'mini-blocks'
    );
}

function mini_blocks_sanitize_settings( $input ) {
    $sanitized    = [];
    $known_blocks = [
        // Layout
        'mini_section', 'mini_container', 'mini_boxes', 'mini_box',
        // Content
        'mini_news', 'mini_events', 'mini_courses', 'mini_matches',
        // UI
        'mini_button', 'mini_image',
        // Utilities
        'mini_sep', 'mini_space',
    ];
    foreach ( $known_blocks as $block ) {
        $sanitized[ $block ] = ! empty( $input[ $block ] ) ? 1 : 0;
    }
    return $sanitized;
}

function mini_blocks_section_callback( $args ) {
    $opts = get_option( 'mini_blocks_settings', [] );
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>" class="grey-text">
        <?php esc_html_e( 'Enable or disable individual mini Gutenberg blocks. Disabled blocks will not be registered and will not appear in the block inserter.', 'mini' ); ?>
    </p>

    <?php /* Layout blocks */ ?>
    <div class="boxes mb-2">
        <div class="box-100 p-2 white-bg b-rad-5 box-shadow">
            <h4 class="m-0"><?php esc_html_e( 'Layout', 'mini' ); ?></h4>
            <p class="m-0 grey-text S"><?php esc_html_e( 'Structural blocks for building page layouts with the mini grid system.', 'mini' ); ?></p>
            <div class="space-2"></div>
            <div class="boxes">
                <?php
                $layout_blocks = [
                    'mini_section'   => [ 'Section',   'mini/section',   'Page section with anchor id, extra classes and page-menu label. Supports InnerBlocks.' ],
                    'mini_container' => [ 'Container', 'mini/container', 'Wraps content in a .container with size variants (default, fw, wide, thin). Supports InnerBlocks.' ],
                    'mini_boxes'     => [ 'Boxes',     'mini/boxes',     'A .boxes flex-grid row. Add Box blocks inside to create columns. Supports InnerBlocks.' ],
                    'mini_box'       => [ 'Box',       'mini/box',       'A .box-N column. Must be placed inside a Boxes block. Width: 10–100%. Supports InnerBlocks.' ],
                ];
                foreach ( $layout_blocks as $key => $block ) :
                    list( $title, $slug, $desc ) = $block;
                ?>
                <div class="box-25 p-2 border light-grey-border b-rad-5">
                    <label for="mini_block_<?php echo esc_attr( $key ); ?>" class="bold bk-text">
                        <input type="checkbox" id="mini_block_<?php echo esc_attr( $key ); ?>" name="mini_blocks_settings[<?php echo esc_attr( $key ); ?>]" value="1" <?php checked( ! empty( $opts[ $key ] ) ); ?> class="me-1">
                        <?php echo esc_html( $title ); ?>
                    </label>
                    <p class="S grey-text mt-0 mb-0"><?php echo esc_html( $desc ); ?></p>
                    <p class="S mt-05 mb-0"><code class="XS"><?php echo esc_html( $slug ); ?></code></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php /* Content query blocks */ ?>
    <div class="boxes mb-2">
        <div class="box-100 p-2 white-bg b-rad-5 box-shadow">
            <h4 class="m-0"><?php esc_html_e( 'Content', 'mini' ); ?></h4>
            <p class="m-0 grey-text S"><?php esc_html_e( 'Query blocks that display custom post types. Requires the corresponding content type to be enabled.', 'mini' ); ?></p>
            <div class="space-2"></div>
            <div class="boxes">
                <?php
                $content_blocks = [
                    'mini_news'    => [ 'News',    'mini/news',    'Display a grid of news articles. Requires the News content type.' ],
                    'mini_events'  => [ 'Events',  'mini/events',  'Display a list of events with date and location. Requires the Event content type.' ],
                    'mini_courses' => [ 'Courses', 'mini/courses', 'Display a grid of courses. Requires the Course content type.' ],
                    'mini_matches' => [ 'Matches', 'mini/matches', 'Display a grid of matches. Requires the Match content type.' ],
                ];
                foreach ( $content_blocks as $key => $block ) :
                    list( $title, $slug, $desc ) = $block;
                ?>
                <div class="box-25 p-2 border light-grey-border b-rad-5">
                    <label for="mini_block_<?php echo esc_attr( $key ); ?>" class="bold bk-text">
                        <input type="checkbox" id="mini_block_<?php echo esc_attr( $key ); ?>" name="mini_blocks_settings[<?php echo esc_attr( $key ); ?>]" value="1" <?php checked( ! empty( $opts[ $key ] ) ); ?> class="me-1">
                        <?php echo esc_html( $title ); ?>
                    </label>
                    <p class="S grey-text mt-0 mb-0"><?php echo esc_html( $desc ); ?></p>
                    <p class="S mt-05 mb-0"><code class="XS"><?php echo esc_html( $slug ); ?></code></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php /* UI blocks */ ?>
    <div class="boxes mb-2">
        <div class="box-100 p-2 white-bg b-rad-5 box-shadow">
            <h4 class="m-0"><?php esc_html_e( 'UI', 'mini' ); ?></h4>
            <p class="m-0 grey-text S"><?php esc_html_e( 'Interface elements styled with mini CSS.', 'mini' ); ?></p>
            <div class="space-2"></div>
            <div class="boxes">
                <div class="box-25 p-2 border light-grey-border b-rad-5">
                    <label for="mini_block_mini_button" class="bold bk-text">
                        <input type="checkbox" id="mini_block_mini_button" name="mini_blocks_settings[mini_button]" value="1" <?php checked( ! empty( $opts['mini_button'] ) ); ?> class="me-1">
                        <?php esc_html_e( 'Button', 'mini' ); ?>
                    </label>
                    <p class="S grey-text mt-0 mb-0"><?php esc_html_e( 'A mini-styled button link with color, size and target options.', 'mini' ); ?></p>
                    <p class="S mt-05 mb-0"><code class="XS">mini/button</code></p>
                </div>
                <div class="box-25 p-2 border light-grey-border b-rad-5">
                    <label for="mini_block_mini_image" class="bold bk-text">
                        <input type="checkbox" id="mini_block_mini_image" name="mini_blocks_settings[mini_image]" value="1" <?php checked( ! empty( $opts['mini_image'] ) ); ?> class="me-1">
                        <?php esc_html_e( 'Image', 'mini' ); ?>
                    </label>
                    <p class="S grey-text mt-0 mb-0"><?php esc_html_e( 'A plain &lt;img&gt; with the mini img class. No wrapper divs, optional link and extra classes.', 'mini' ); ?></p>
                    <p class="S mt-05 mb-0"><code class="XS">mini/image</code></p>
                </div>
            </div>
        </div>
    </div>

    <?php /* Utility blocks */ ?>
    <div class="boxes">
        <div class="box-100 p-2 white-bg b-rad-5 box-shadow">
            <h4 class="m-0"><?php esc_html_e( 'Utilities', 'mini' ); ?></h4>
            <p class="m-0 grey-text S"><?php esc_html_e( 'Spacing and divider helpers.', 'mini' ); ?></p>
            <div class="space-2"></div>
            <div class="boxes">
                <div class="box-25 p-2 border light-grey-border b-rad-5">
                    <label for="mini_block_mini_sep" class="bold bk-text">
                        <input type="checkbox" id="mini_block_mini_sep" name="mini_blocks_settings[mini_sep]" value="1" <?php checked( ! empty( $opts['mini_sep'] ) ); ?> class="me-1">
                        <?php esc_html_e( 'Sep', 'mini' ); ?>
                    </label>
                    <p class="S grey-text mt-0 mb-0"><?php esc_html_e( 'A horizontal separator using .sep classes with optional height and border color.', 'mini' ); ?></p>
                    <p class="S mt-05 mb-0"><code class="XS">mini/sep</code></p>
                </div>
                <div class="box-25 p-2 border light-grey-border b-rad-5">
                    <label for="mini_block_mini_space" class="bold bk-text">
                        <input type="checkbox" id="mini_block_mini_space" name="mini_blocks_settings[mini_space]" value="1" <?php checked( ! empty( $opts['mini_space'] ) ); ?> class="me-1">
                        <?php esc_html_e( 'Space', 'mini' ); ?>
                    </label>
                    <p class="S grey-text mt-0 mb-0"><?php esc_html_e( 'A blank vertical spacer using .space classes sized in baseline multiples.', 'mini' ); ?></p>
                    <p class="S mt-05 mb-0"><code class="XS">mini/space</code></p>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/* END - Blocks settings */

/* START - Blocks settings page HTML */

function mini_blocks_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error( 'mini_messages', 'mini_message', __( 'Settings Saved', 'mini' ), 'updated' );
    }
    settings_errors( 'mini_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <form action="options.php" method="post">
            <?php
            settings_fields( 'mini_blocks' );
            do_settings_sections( 'mini-blocks' );
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

/* END - Blocks settings page HTML */
