<?php
/**
 * Plugin Name:  SRJ AI Governance Database
 * Description:  Moves the AI Governance Reference Library out of
 *               inc/ai-governance-config.php and into wp_srj_governance.
 *               Serves every governance page from the database, with the
 *               PHP config retained as an automatic fallback.
 * Version:      1.0.0
 * Author:       SRJ Consulting & Services LLC
 *
 * WHY THIS EXISTS
 * ---------------
 * The library lives in a single 990KB PHP file. That file is the largest
 * standing risk in the stack:
 *
 *   - On 20 July 2026 an incomplete copy of it was deployed and blanked
 *     three live pages; a second wrong copy took the count to 19 of 27.
 *   - Editing one page means rewriting a 990KB artifact.
 *   - Every deploy ships the whole library to change one paragraph.
 *
 * Moving the content to a table removes all three.
 *
 * WHAT THIS DELIBERATELY DOES NOT DO
 * ----------------------------------
 * It does NOT move any page, change any URL, or alter the WordPress page
 * tree. All 61 governance pages keep their post IDs, slugs, parents, and
 * addresses. No redirects, no reindexing, no ranking exposure.
 *
 * A custom post type would have been the more orthodox WordPress answer,
 * but it would have put 61 indexed URLs through a rewrite-rule migration
 * to gain things this approach already delivers. Not a trade worth making
 * for an asset that is the practice's main authority surface.
 *
 * HOW IT WORKS
 * ------------
 * The theme loads $SRJ_GOVERNANCE from the config file as it always has.
 * On `init` this plugin stashes that array, and if the table has rows,
 * replaces the global with the database copy. Templates are untouched and
 * do not know the difference.
 *
 * FIDELITY
 * --------
 * Each row stores the COMPLETE original entry as JSON alongside the broken
 * out columns. Reads decode that JSON, so the array handed to templates is
 * identical to the config array, including keys this plugin has never
 * heard of. Nothing is lost in translation.
 *
 * FALLBACK
 * --------
 * Table missing or empty, or plugin removed, and the config file serves
 * exactly as it does today. There is no state where the library goes dark.
 *
 * @package srj-consulting
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SRJ_GOVDB_VERSION', '1.0.0' );
define( 'SRJ_GOVDB_DB_VERSION', 1 );

/**
 * Fully qualified table name.
 *
 * @return string
 */
function srj_govdb_table() {
	global $wpdb;
	return $wpdb->prefix . 'srj_governance';
}

/* ---------------------------------------------------------------------------
 * Schema
 * ------------------------------------------------------------------------- */

/**
 * Create or upgrade the governance table. Idempotent.
 */
function srj_govdb_install() {
	global $wpdb;

	$table   = srj_govdb_table();
	$collate = $wpdb->get_charset_collate();

	// entry_json is the source of truth for rendering. The broken out
	// columns exist so the table is queryable, reportable, and searchable
	// without decoding JSON on every row.
	$sql = "CREATE TABLE {$table} (
		id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		slug VARCHAR(190) NOT NULL DEFAULT '',
		title VARCHAR(255) NOT NULL DEFAULT '',
		subtitle TEXT NULL,
		short_desc TEXT NULL,
		parent_slug VARCHAR(190) NOT NULL DEFAULT '',
		focus_keyword VARCHAR(255) NOT NULL DEFAULT '',
		seo_title VARCHAR(255) NOT NULL DEFAULT '',
		meta_description TEXT NULL,
		body_html LONGTEXT NULL,
		entry_json LONGTEXT NULL,
		word_count INT UNSIGNED NOT NULL DEFAULT 0,
		sort_order INT NOT NULL DEFAULT 0,
		is_published TINYINT(1) NOT NULL DEFAULT 1,
		date_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		date_modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		UNIQUE KEY slug (slug),
		KEY parent_slug (parent_slug),
		KEY is_published (is_published)
	) {$collate};";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	update_option( 'srj_govdb_db_version', SRJ_GOVDB_DB_VERSION );
}

/**
 * Run the installer when the stored schema version is behind.
 */
function srj_govdb_maybe_install() {
	if ( (int) get_option( 'srj_govdb_db_version', 0 ) < SRJ_GOVDB_DB_VERSION ) {
		srj_govdb_install();
	}
}
add_action( 'admin_init', 'srj_govdb_maybe_install' );

/**
 * Does the table exist?
 *
 * @return bool
 */
function srj_govdb_table_exists() {
	global $wpdb;
	$table = srj_govdb_table();
	return ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) === $table );
}

/**
 * Count published rows.
 *
 * @return int
 */
function srj_govdb_count() {
	global $wpdb;
	if ( ! srj_govdb_table_exists() ) {
		return 0;
	}
	return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . srj_govdb_table() . ' WHERE is_published = 1' );
}

/* ---------------------------------------------------------------------------
 * Serving
 *
 * The detail and hub templates `require` inc/ai-governance-config.php
 * themselves, at render time. That rules out swapping $SRJ_GOVERNANCE on an
 * early hook: the template's own require would overwrite it a moment later.
 *
 * So the config file carries a four-line guard at the top. When this plugin
 * is active and the table has rows, the guard assigns the database copy and
 * returns, and the 990KB of PHP below it never executes. Remove the plugin,
 * or empty the table, and the file runs exactly as it always has.
 * ------------------------------------------------------------------------- */

/**
 * Should the database serve, rather than the PHP config?
 *
 * False while the importer is reading the raw file, which is what stops an
 * import from feeding database content back into itself.
 *
 * @return bool
 */
function srj_govdb_has_rows() {
	if ( ! empty( $GLOBALS['srj_govdb_force_raw'] ) ) {
		return false;
	}
	static $has = null;
	if ( null === $has ) {
		$has = ( srj_govdb_count() > 0 );
	}
	return $has;
}

/**
 * Read every published entry, keyed by slug, in config shape.
 *
 * Result is held for the request. A governance page load calls this once.
 *
 * @return array
 */
function srj_govdb_get_all() {
	global $wpdb;

	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	if ( ! srj_govdb_table_exists() ) {
		$cache = array();
		return $cache;
	}

	$rows = $wpdb->get_results(
		'SELECT slug, entry_json FROM ' . srj_govdb_table() . '
		 WHERE is_published = 1
		 ORDER BY sort_order ASC, slug ASC'
	);

	$out = array();
	foreach ( (array) $rows as $row ) {
		$entry = json_decode( $row->entry_json, true );
		if ( is_array( $entry ) ) {
			$out[ $row->slug ] = $entry;
		}
	}

	$cache = $out;
	return $cache;
}

/**
 * Read one entry by slug.
 *
 * Single-row fetch. Decodes one JSON blob rather than all 63, which is the
 * difference between moving ~19KB and ~1.2MB to render one page.
 *
 * @param string $slug Page slug.
 * @return array|null
 */
function srj_govdb_get( $slug ) {
	global $wpdb;

	static $cache = array();
	if ( array_key_exists( $slug, $cache ) ) {
		return $cache[ $slug ];
	}

	if ( ! srj_govdb_table_exists() ) {
		$cache[ $slug ] = null;
		return null;
	}

	$json = $wpdb->get_var(
		$wpdb->prepare(
			'SELECT entry_json FROM ' . srj_govdb_table() . ' WHERE slug = %s AND is_published = 1',
			$slug
		)
	);

	$entry = $json ? json_decode( $json, true ) : null;
	$cache[ $slug ] = is_array( $entry ) ? $entry : null;

	return $cache[ $slug ];
}

/**
 * Read every published entry WITHOUT its body HTML.
 *
 * Columns only, no JSON decoding. Returns the shape templates expect for
 * navigation work: title, subtitle, short, parent, children. Bodies are
 * roughly 95 percent of the payload, so this is the query to use anywhere
 * the page is building links rather than rendering an article.
 *
 * `children` is derived from parent_slug rather than read from the stored
 * array. Verified equivalent across all entries: every declared child also
 * declares its parent, so the two are the same set, and deriving keeps the
 * result ordered by sort_order for free.
 *
 * @return array Keyed by slug.
 */
function srj_govdb_get_lite() {
	global $wpdb;

	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	if ( ! srj_govdb_table_exists() ) {
		$cache = array();
		return $cache;
	}

	$rows = $wpdb->get_results(
		'SELECT slug, title, subtitle, short_desc, parent_slug FROM ' . srj_govdb_table() . '
		 WHERE is_published = 1
		 ORDER BY sort_order ASC, slug ASC'
	);

	$out = array();
	foreach ( (array) $rows as $row ) {
		$out[ $row->slug ] = array(
			'title'    => $row->title,
			'subtitle' => $row->subtitle,
			'short'    => $row->short_desc,
			'parent'   => $row->parent_slug ? $row->parent_slug : null,
			'children' => array(),
		);
	}

	foreach ( $out as $slug => $entry ) {
		$parent = $entry['parent'];
		if ( $parent && isset( $out[ $parent ] ) ) {
			$out[ $parent ]['children'][] = $slug;
		}
	}

	$cache = $out;
	return $cache;
}

/**
 * Load $SRJ_GOVERNANCE from the PHP config file, bypassing the guard.
 *
 * This is the importer's source and the admin screen's comparison copy.
 *
 * @return array
 */
function srj_govdb_load_raw_config() {
	$path = get_stylesheet_directory() . '/inc/ai-governance-config.php';
	if ( ! file_exists( $path ) ) {
		return array();
	}

	$GLOBALS['srj_govdb_force_raw'] = true;

	$SRJ_GOVERNANCE = array();
	require $path;

	unset( $GLOBALS['srj_govdb_force_raw'] );

	return ( isset( $SRJ_GOVERNANCE ) && is_array( $SRJ_GOVERNANCE ) ) ? $SRJ_GOVERNANCE : array();
}

/* ---------------------------------------------------------------------------
 * Import
 * ------------------------------------------------------------------------- */

/**
 * Import the config array into the table.
 *
 * Source is the stashed config copy, never the live global, so running this
 * twice cannot round-trip database content back through itself.
 *
 * Upsert on slug. Re-importing refreshes content and leaves sort_order and
 * is_published alone, so hand ordering and unpublishing survive.
 *
 * @return array|WP_Error
 */
function srj_govdb_import_from_config() {
	global $wpdb;

	$source = srj_govdb_load_raw_config();

	if ( ! is_array( $source ) || empty( $source ) ) {
		return new WP_Error(
			'srj_govdb_no_source',
			'The config array is empty. Confirm inc/ai-governance-config.php is present and loaded by the theme.'
		);
	}

	srj_govdb_maybe_install();

	$table    = srj_govdb_table();
	$inserted = 0;
	$updated  = 0;
	$failed   = 0;
	$order    = 0;

	foreach ( $source as $slug => $entry ) {
		$order++;

		if ( ! is_array( $entry ) ) {
			$failed++;
			continue;
		}

		$body = isset( $entry['body_html'] ) ? (string) $entry['body_html'] : '';

		$json = wp_json_encode( $entry, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
		if ( false === $json ) {
			$failed++;
			continue;
		}

		// Round-trip check. A row that will not decode back into the same
		// shape is worse than no row, so it is refused rather than stored.
		$check = json_decode( $json, true );
		if ( ! is_array( $check ) || count( $check ) !== count( $entry ) ) {
			$failed++;
			continue;
		}

		$data = array(
			'slug'             => $slug,
			'title'            => isset( $entry['title'] ) ? (string) $entry['title'] : '',
			'subtitle'         => isset( $entry['subtitle'] ) ? (string) $entry['subtitle'] : '',
			'short_desc'       => isset( $entry['short'] ) ? (string) $entry['short'] : '',
			'parent_slug'      => ( isset( $entry['parent'] ) && $entry['parent'] ) ? (string) $entry['parent'] : '',
			'focus_keyword'    => isset( $entry['focus_keyword'] ) ? (string) $entry['focus_keyword'] : '',
			'seo_title'        => isset( $entry['seo_title'] ) ? (string) $entry['seo_title'] : '',
			'meta_description' => isset( $entry['meta_description'] ) ? (string) $entry['meta_description'] : '',
			'body_html'        => $body,
			'entry_json'       => $json,
			'word_count'       => $body ? str_word_count( wp_strip_all_tags( $body ) ) : 0,
		);

		$existing_id = $wpdb->get_var(
			$wpdb->prepare( "SELECT id FROM {$table} WHERE slug = %s", $slug )
		);

		if ( $existing_id ) {
			$result = $wpdb->update( $table, $data, array( 'id' => $existing_id ) );
			if ( false === $result ) {
				$failed++;
			} else {
				$updated++;
			}
		} else {
			$data['sort_order'] = $order;
			$result = $wpdb->insert( $table, $data );
			if ( false === $result ) {
				$failed++;
			} else {
				$inserted++;
			}
		}
	}

	update_option( 'srj_govdb_last_import', current_time( 'mysql' ) );

	return array(
		'inserted' => $inserted,
		'updated'  => $updated,
		'failed'   => $failed,
		'total'    => count( $source ),
	);
}

/* ---------------------------------------------------------------------------
 * Admin
 * ------------------------------------------------------------------------- */

/**
 * Register the admin screen under Tools.
 */
function srj_govdb_admin_menu() {
	add_management_page(
		'AI Governance Database',
		'AI Governance DB',
		'manage_options',
		'srj-governance-db',
		'srj_govdb_admin_page'
	);
}
add_action( 'admin_menu', 'srj_govdb_admin_menu' );

/**
 * Admin screen: status, verification, import.
 */
function srj_govdb_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Insufficient permissions.' );
	}

	global $wpdb;
	$table  = srj_govdb_table();
	$notice = '';

	if (
		isset( $_POST['srj_govdb_import'] )
		&& check_admin_referer( 'srj_govdb_import_action', 'srj_govdb_nonce' )
	) {
		$result = srj_govdb_import_from_config();
		if ( is_wp_error( $result ) ) {
			$notice = '<div class="notice notice-error"><p>Import failed: '
				. esc_html( $result->get_error_message() ) . '</p></div>';
		} else {
			$notice = '<div class="notice notice-success"><p>Import complete. '
				. sprintf(
					'%d inserted, %d updated, %d failed, %d entries in config.',
					(int) $result['inserted'],
					(int) $result['updated'],
					(int) $result['failed'],
					(int) $result['total']
				)
				. ' Now add the guard to the top of the config file, if it is not already there.</p></div>';
		}
	}

	$raw_config   = srj_govdb_load_raw_config();
	$config_count = count( $raw_config );
	$db_count     = srj_govdb_count();
	// Read a generous head of the file: the guard sits after the docblock and
	// the first section banner, roughly 3KB in. An earlier 2KB window produced
	// a false negative. Position matters as much as presence, so the guard is
	// only counted as live if it appears BEFORE the first entry assignment.
	$cfg_head    = (string) @file_get_contents( get_stylesheet_directory() . '/inc/ai-governance-config.php', false, null, 0, 32768 );
	$guard_pos   = strpos( $cfg_head, 'srj_govdb_has_rows' );
	$first_entry = strpos( $cfg_head, '$SRJ_GOVERNANCE[' );
	$guard_live  = ( false !== $guard_pos && ( false === $first_entry || $guard_pos < $first_entry ) );
	$serving      = ( $db_count > 0 && $guard_live ) ? 'database' : 'PHP config (fallback)';
	$last_import  = get_option( 'srj_govdb_last_import', 'never' );

	echo '<div class="wrap">';
	echo '<h1>AI Governance Database</h1>';
	echo wp_kses_post( $notice );

	echo '<h2>Status</h2><table class="widefat striped" style="max-width:760px"><tbody>';
	printf(
		'<tr><td style="width:240px"><strong>Table</strong></td><td><code>%s</code> %s</td></tr>',
		esc_html( $table ),
		srj_govdb_table_exists() ? 'exists' : '<strong style="color:#b32d2e">missing</strong>'
	);
	printf( '<tr><td><strong>Entries in PHP config</strong></td><td>%d</td></tr>', (int) $config_count );
	printf( '<tr><td><strong>Entries in database</strong></td><td>%d</td></tr>', (int) $db_count );
	printf(
		'<tr><td><strong>Guard in config file</strong></td><td>%s</td></tr>',
		$guard_live
			? sprintf( 'present, at byte %s, ahead of the first entry', number_format( (int) $guard_pos ) )
			: '<strong style="color:#b32d2e">NOT present, or positioned after the first entry</strong> &mdash; the guard must sit above the first $SRJ_GOVERNANCE[ line'
	);
	printf( '<tr><td><strong>Pages are served from</strong></td><td><strong>%s</strong></td></tr>', esc_html( $serving ) );
	printf( '<tr><td><strong>Last import</strong></td><td>%s</td></tr>', esc_html( $last_import ) );
	echo '</tbody></table>';

	// Parity check. Every config slug must exist in the table before the
	// config file can be considered retired.
	if ( $db_count > 0 && $config_count > 0 ) {
		$config_slugs = array_keys( $raw_config );
		$db_slugs     = $wpdb->get_col( "SELECT slug FROM {$table}" );
		$missing      = array_diff( $config_slugs, (array) $db_slugs );
		$extra        = array_diff( (array) $db_slugs, $config_slugs );

		echo '<h2>Parity check</h2>';
		if ( empty( $missing ) && empty( $extra ) ) {
			echo '<div class="notice notice-success inline" style="max-width:760px"><p>'
				. 'Every config entry is present in the database, and the database holds nothing the config does not. '
				. 'Slug sets match exactly.</p></div>';
		} else {
			if ( ! empty( $missing ) ) {
				echo '<div class="notice notice-error inline" style="max-width:760px"><p><strong>In config but NOT in database ('
					. count( $missing ) . '):</strong> ' . esc_html( implode( ', ', $missing ) )
					. '<br>These pages would go blank if the config file were removed. Re-run the import.</p></div>';
			}
			if ( ! empty( $extra ) ) {
				echo '<div class="notice notice-warning inline" style="max-width:760px"><p><strong>In database but NOT in config ('
					. count( $extra ) . '):</strong> ' . esc_html( implode( ', ', $extra ) )
					. '<br>Expected if an entry was removed from the config after import.</p></div>';
			}
		}
	}

	echo '<h2>Import</h2>';
	echo '<p>Reads <code>$SRJ_GOVERNANCE</code> as loaded from <code>inc/ai-governance-config.php</code> and writes it to the table. '
		. 'Existing rows are matched on slug and have their content refreshed. Sort order and published state are never overwritten, '
		. 'so hand ordering survives a re-import.</p>';
	echo '<p>Safe to run repeatedly. The config file stays in place as the fallback, so this cannot take the library offline.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'srj_govdb_import_action', 'srj_govdb_nonce' );
	submit_button( 'Import config into database', 'primary', 'srj_govdb_import' );
	echo '</form>';

	if ( $db_count > 0 ) {
		$rows = $wpdb->get_results(
			"SELECT slug, title, parent_slug, word_count, LENGTH(body_html) AS body_bytes
			 FROM {$table} WHERE is_published = 1
			 ORDER BY parent_slug ASC, sort_order ASC"
		);
		echo '<h2>Rows (' . count( $rows ) . ')</h2>';
		echo '<table class="widefat striped" style="max-width:900px"><thead><tr>'
			. '<th>Slug</th><th>Title</th><th>Parent</th><th style="width:90px">Words</th><th style="width:110px">Body bytes</th>'
			. '</tr></thead><tbody>';
		foreach ( $rows as $r ) {
			printf(
				'<tr><td><code>%s</code></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
				esc_html( $r->slug ),
				esc_html( $r->title ),
				$r->parent_slug ? esc_html( $r->parent_slug ) : '<em>top level</em>',
				number_format( (int) $r->word_count ),
				number_format( (int) $r->body_bytes )
			);
		}
		echo '</tbody></table>';
	}

	echo '</div>';
}
