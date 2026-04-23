<?php
/**
 * CPT Archive Pages
 *
 * Allows assigning a WordPress page to each CPT archive,
 * mirroring how WordPress handles the "Posts page" setting.
 * The assigned page is editable in the Gutenberg editor and
 * its content is injected into the archive template.
 *
 * @package mini
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the list of CPTs that support an editable archive page.
 * Filterable so child themes / plugins can extend it.
 *
 * @return array  Keyed by CPT slug, value is the admin label.
 */
function mini_cpt_archive_page_types() {
	return apply_filters( 'mini_cpt_archive_page_types', array(
		'news'   => __( 'News Archive Page', 'mini' ),
		'event'  => __( 'Events Archive Page', 'mini' ),
		'course' => __( 'Courses Archive Page', 'mini' ),
		'lesson' => __( 'Lessons Archive Page', 'mini' ),
		'match'  => __( 'Matches Archive Page', 'mini' ),
	) );
}

/**
 * Returns the page ID assigned to the given CPT archive.
 *
 * @param  string $cpt  Post type slug.
 * @return int          Page ID, or 0 if none is assigned.
 */
function mini_get_cpt_archive_page_id( $cpt ) {
	return absint( get_option( 'mini_page_for_' . $cpt, 0 ) );
}

/**
 * Outputs the content of the page assigned to a CPT archive.
 * Call this inside the archive template, between the header and the loop.
 *
 * @param string $cpt  Post type slug.
 */
function mini_cpt_archive_page_header( $cpt ) {
	$page_id = mini_get_cpt_archive_page_id( $cpt );
	if ( ! $page_id ) {
		return;
	}

	$page = get_post( $page_id );
	if ( ! $page || 'publish' !== $page->post_status ) {
		return;
	}

	// Temporarily set global $post so blocks and shortcodes work correctly.
	global $post;
	$original_post = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
	$post = $page;          // phpcs:ignore WordPress.WP.GlobalVariablesOverride
	setup_postdata( $post );
	?>
	<div class="archive-page-content box-100">
		<?php the_content(); ?>
	</div>
	<?php
	$post = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
	wp_reset_postdata();
}

// ---------------------------------------------------------------------------
// Admin: register settings and add fields to Settings > Reading
// ---------------------------------------------------------------------------

add_action( 'admin_init', 'mini_cpt_archive_pages_register_settings' );

function mini_cpt_archive_pages_register_settings() {
	$types = mini_cpt_archive_page_types();

	// Register one option per CPT under the 'reading' settings group.
	foreach ( array_keys( $types ) as $cpt ) {
		register_setting( 'reading', 'mini_page_for_' . $cpt, array(
			'type'              => 'integer',
			'sanitize_callback' => 'absint',
			'default'           => 0,
		) );
	}

	// Add a dedicated section at the bottom of Settings > Reading.
	add_settings_section(
		'mini_cpt_archive_pages_section',
		__( 'CPT Archive Pages', 'mini' ),
		'mini_cpt_archive_pages_section_cb',
		'reading'
	);

	// Add one dropdown field per CPT.
	foreach ( $types as $cpt => $label ) {
		add_settings_field(
			'mini_page_for_' . $cpt,
			$label,
			'mini_cpt_archive_page_field_cb',
			'reading',
			'mini_cpt_archive_pages_section',
			array( 'cpt' => $cpt )
		);
	}
}

function mini_cpt_archive_pages_section_cb() {
	echo '<p>' . esc_html__( 'Select a page whose content will appear above the posts on each CPT archive. The page is fully editable in the block editor.', 'mini' ) . '</p>';
}

function mini_cpt_archive_page_field_cb( $args ) {
	$cpt         = $args['cpt'];
	$option_name = 'mini_page_for_' . $cpt;
	$current     = mini_get_cpt_archive_page_id( $cpt );

	wp_dropdown_pages( array(
		'name'              => $option_name,
		'id'                => $option_name,
		'show_option_none'  => __( '&mdash; Select &mdash;', 'mini' ),
		'option_none_value' => '0',
		'selected'          => $current,
	) );

	if ( $current ) {
		printf(
			' <a href="%s" target="_blank">%s</a>',
			esc_url( get_edit_post_link( $current ) ),
			esc_html__( 'Edit page', 'mini' )
		);
	}
}

// ---------------------------------------------------------------------------
// Admin: label the assigned pages in the Pages list, just like WP does for
// the "Posts page" and "Front page".
// ---------------------------------------------------------------------------

add_filter( 'display_post_states', 'mini_cpt_archive_page_states', 10, 2 );

function mini_cpt_archive_page_states( $states, $post ) {
	foreach ( mini_cpt_archive_page_types() as $cpt => $label ) {
		if ( $post->ID === mini_get_cpt_archive_page_id( $cpt ) ) {
			$states[] = $label;
		}
	}
	return $states;
}
