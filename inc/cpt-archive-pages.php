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
		<div class="boxes">
		<?php the_content(); ?>
		</div>
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
// Front-end: serve the CPT archive template when visiting the archive page URL
// ---------------------------------------------------------------------------

/**
 * When a visitor hits the URL of a page assigned as a CPT archive page,
 * transform the main WP_Query into a CPT archive query — exactly like
 * WordPress does for the "Posts page" (page_for_posts).
 *
 * Hooked at priority 1 so it runs before any other pre_get_posts callbacks.
 */
add_action( 'pre_get_posts', 'mini_cpt_archive_page_transform_query', 1 );

function mini_cpt_archive_page_transform_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_page ) {
		return;
	}

	// Resolve page_id from query vars (may be page_id or pagename depending
	// on how WP_Rewrite matched the request).
	$page_id = (int) $query->get( 'page_id' );
	if ( ! $page_id ) {
		$pagename = $query->get( 'pagename' );
		if ( $pagename ) {
			$page    = get_page_by_path( $pagename );
			$page_id = $page ? $page->ID : 0;
		}
	}

	if ( ! $page_id ) {
		return;
	}

	foreach ( array_keys( mini_cpt_archive_page_types() ) as $cpt ) {
		if ( mini_get_cpt_archive_page_id( $cpt ) !== $page_id ) {
			continue;
		}

		// Stash the CPT slug so template_include can load the right template.
		$GLOBALS['mini_cpt_archive_page_cpt'] = $cpt; // phpcs:ignore WordPress.WP.GlobalVariablesOverride

		// Transform the query into a CPT archive query.
		$query->set( 'post_type',      $cpt );
		$query->set( 'posts_per_page', (int) get_option( 'posts_per_page' ) );
		$query->set( 'page_id',        0 );
		$query->set( 'pagename',       '' );

		// Flip WP_Query flags so conditional tags work correctly in templates.
		$query->is_page              = false;
		$query->is_singular          = false;
		$query->is_archive           = true;
		$query->is_post_type_archive = true;
		break;
	}
}

/**
 * Load the CPT-specific archive template (archive-{$cpt}.php) when the
 * query was transformed above.
 */
add_filter( 'template_include', 'mini_cpt_archive_page_template_include' );

function mini_cpt_archive_page_template_include( $template ) {
	if ( empty( $GLOBALS['mini_cpt_archive_page_cpt'] ) ) {
		return $template;
	}

	$cpt          = $GLOBALS['mini_cpt_archive_page_cpt'];
	$cpt_template = locate_template( [ "archive-{$cpt}.php", 'archive.php' ] );

	return $cpt_template ?: $template;
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

// ---------------------------------------------------------------------------
// Front-end: article column class for archive grids
// ---------------------------------------------------------------------------

/**
 * Returns the CSS width class (box-100 / box-50 / box-33) to apply to each
 * article on an archive page.  Falls back to 'box-100' on singular views or
 * when no setting has been saved.
 *
 * The value is read from the post meta 'mini_archive_cols' stored on the page
 * assigned as the archive page (via Settings > Reading), mirroring how WP
 * handles the "Posts page" for the blog.
 *
 * @return string
 */
function mini_get_archive_col_class() {
	if ( is_singular() ) {
		return 'box-100';
	}

	if ( is_home() ) {
		$page_id = absint( get_option( 'page_for_posts', 0 ) );
	} elseif ( is_post_type_archive() ) {
		$page_id = mini_get_cpt_archive_page_id( get_post_type() );
	} else {
		return 'box-100';
	}

	if ( ! $page_id ) {
		return 'box-100';
	}

	$col     = get_post_meta( $page_id, 'mini_archive_cols', true );
	$allowed = [ 'box-100', 'box-50', 'box-33' ];
	return in_array( $col, $allowed, true ) ? $col : 'box-100';
}
