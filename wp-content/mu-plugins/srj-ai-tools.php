<?php
/**
 * Plugin Name:  SRJ AI Tools Inventory
 * Description:  Database layer for the AI tool inventory. Creates wp_srj_ai_tools,
 *               imports the seed catalog, and renders the AI Tools catalog page
 *               from the table instead of static config HTML.
 * Version:      1.0.0
 * Author:       SRJ Consulting & Services LLC
 *
 * Phase 1 of moving the AI Governance Reference Library out of
 * inc/ai-governance-config.php and into the database.
 *
 * Design notes
 * ------------
 * - Must-use plugin: loads before the theme, no activation hook available,
 *   so the schema is version-gated on an option and checked on admin_init.
 * - The static catalog HTML in ai-governance-config.php is the FALLBACK.
 *   If this plugin is removed, or the table is empty, the page renders the
 *   static list exactly as before. Nothing breaks.
 * - Rendering swaps only the region between the two HTML comment markers
 *   SRJ_TOOLS_CATALOG_START / SRJ_TOOLS_CATALOG_END in the ai-tools entry.
 * - Import runs only when explicitly triggered from the admin screen. It
 *   never runs on a page load.
 *
 * @package srj-consulting
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SRJ_AI_TOOLS_VERSION', '1.0.0' );
define( 'SRJ_AI_TOOLS_DB_VERSION', 1 );

/**
 * Fully qualified table name.
 *
 * @return string
 */
function srj_ai_tools_table() {
	global $wpdb;
	return $wpdb->prefix . 'srj_ai_tools';
}

/* ---------------------------------------------------------------------------
 * Schema
 * ------------------------------------------------------------------------- */

/**
 * Create or upgrade the tools table. Idempotent, safe to call repeatedly.
 */
function srj_ai_tools_install() {
	global $wpdb;

	$table   = srj_ai_tools_table();
	$collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE {$table} (
		id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		tool_name VARCHAR(190) NOT NULL DEFAULT '',
		category VARCHAR(190) NOT NULL DEFAULT '',
		vendor VARCHAR(190) NOT NULL DEFAULT '',
		vendor_hq VARCHAR(120) NOT NULL DEFAULT '',
		governance_notes TEXT NULL,
		in_use TINYINT(1) NOT NULL DEFAULT 0,
		owner VARCHAR(190) NOT NULL DEFAULT '',
		department VARCHAR(190) NOT NULL DEFAULT '',
		monthly_cost_usd DECIMAL(10,2) NULL,
		approved_by VARCHAR(190) NOT NULL DEFAULT '',
		approval_date DATE NULL,
		data_types_accessed TEXT NULL,
		contract_on_file TINYINT(1) NOT NULL DEFAULT 0,
		dpa_signed TINYINT(1) NOT NULL DEFAULT 0,
		soc2_iso_verified TINYINT(1) NOT NULL DEFAULT 0,
		decision_influence_tier VARCHAR(60) NOT NULL DEFAULT '',
		last_reviewed DATE NULL,
		notes TEXT NULL,
		is_published TINYINT(1) NOT NULL DEFAULT 1,
		date_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		date_modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		UNIQUE KEY tool_vendor (tool_name, vendor),
		KEY category (category),
		KEY vendor_hq (vendor_hq),
		KEY is_published (is_published)
	) {$collate};";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	update_option( 'srj_ai_tools_db_version', SRJ_AI_TOOLS_DB_VERSION );
}

/**
 * Run the installer when the stored schema version is behind.
 */
function srj_ai_tools_maybe_install() {
	if ( (int) get_option( 'srj_ai_tools_db_version', 0 ) < SRJ_AI_TOOLS_DB_VERSION ) {
		srj_ai_tools_install();
	}
}
add_action( 'admin_init', 'srj_ai_tools_maybe_install' );

/* ---------------------------------------------------------------------------
 * Import
 * ------------------------------------------------------------------------- */

/**
 * Import the bundled seed catalog into the table.
 *
 * Upsert by (tool_name, vendor): existing rows have their catalog fields
 * refreshed, and the operational tracking columns (owner, approval, cost)
 * are left untouched, so a re-import never destroys client-entered data.
 *
 * @return array|WP_Error Counts on success.
 */
function srj_ai_tools_import_seed() {
	global $wpdb;

	$seed_file = __DIR__ . '/srj-ai-tools-data.php';
	if ( ! file_exists( $seed_file ) ) {
		return new WP_Error( 'srj_no_seed', 'Seed file srj-ai-tools-data.php not found in mu-plugins.' );
	}

	$rows = include $seed_file;
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return new WP_Error( 'srj_bad_seed', 'Seed file did not return a non-empty array.' );
	}

	srj_ai_tools_maybe_install();

	$table    = srj_ai_tools_table();
	$inserted = 0;
	$updated  = 0;
	$failed   = 0;

	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) || count( $row ) < 5 ) {
			$failed++;
			continue;
		}

		list( $tool_name, $category, $vendor, $vendor_hq, $governance_notes ) = $row;

		$existing_id = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT id FROM {$table} WHERE tool_name = %s AND vendor = %s",
				$tool_name,
				$vendor
			)
		);

		$data = array(
			'tool_name'        => $tool_name,
			'category'         => $category,
			'vendor'           => $vendor,
			'vendor_hq'        => $vendor_hq,
			'governance_notes' => $governance_notes,
		);

		if ( $existing_id ) {
			$result = $wpdb->update( $table, $data, array( 'id' => $existing_id ) );
			if ( false === $result ) {
				$failed++;
			} else {
				$updated++;
			}
		} else {
			$result = $wpdb->insert( $table, $data );
			if ( false === $result ) {
				$failed++;
			} else {
				$inserted++;
			}
		}
	}

	update_option( 'srj_ai_tools_last_import', current_time( 'mysql' ) );

	return array(
		'inserted' => $inserted,
		'updated'  => $updated,
		'failed'   => $failed,
		'total'    => count( $rows ),
	);
}

/* ---------------------------------------------------------------------------
 * Query
 * ------------------------------------------------------------------------- */

/**
 * Fetch published tools grouped by category, both alphabetical.
 *
 * @return array category => array of row objects
 */
function srj_ai_tools_get_grouped() {
	global $wpdb;

	$table = srj_ai_tools_table();

	// Table may not exist yet on a fresh deploy; fail quiet, caller falls back.
	$exists = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) );
	if ( $exists !== $table ) {
		return array();
	}

	// Mixed sort is deliberate: BINARY on category reproduces the case-sensitive
	// section order the table of contents was built with, while the default
	// case-insensitive collation on tool_name reproduces the within-category
	// order. Together they make the database render byte-identical to the
	// static catalog HTML it replaces.
	$rows = $wpdb->get_results(
		"SELECT tool_name, category, vendor, vendor_hq, governance_notes
		 FROM {$table}
		 WHERE is_published = 1
		 ORDER BY BINARY category ASC, tool_name ASC"
	);

	if ( empty( $rows ) ) {
		return array();
	}

	$grouped = array();
	foreach ( $rows as $row ) {
		$grouped[ $row->category ][] = $row;
	}

	return $grouped;
}

/**
 * Count published tools.
 *
 * @return int
 */
function srj_ai_tools_count() {
	global $wpdb;
	$table  = srj_ai_tools_table();
	$exists = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) );
	if ( $exists !== $table ) {
		return 0;
	}
	return (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE is_published = 1" );
}

/* ---------------------------------------------------------------------------
 * Render
 * ------------------------------------------------------------------------- */

/**
 * Slugify a category name into the same anchor ids the static HTML used,
 * so the page table of contents keeps working.
 *
 * @param string $category Category name.
 * @return string
 */
function srj_ai_tools_anchor( $category ) {
	$slug = strtolower( $category );
	$slug = str_replace( '&', 'and', $slug );
	$slug = preg_replace( '/[^a-z0-9]+/', '-', $slug );
	return trim( $slug, '-' );
}

/**
 * Build the catalog HTML from the table.
 *
 * @return string Empty string when the table has no rows.
 */
function srj_ai_tools_render_catalog() {
	$grouped = srj_ai_tools_get_grouped();
	if ( empty( $grouped ) ) {
		return '';
	}

	$html = '';
	foreach ( $grouped as $category => $tools ) {
		$html .= sprintf(
			'<h2 id="%s">%s</h2>' . "\n<ul>\n",
			esc_attr( srj_ai_tools_anchor( $category ) ),
			esc_html( $category )
		);

		foreach ( $tools as $tool ) {
			$hq = trim( (string) $tool->vendor_hq );
			// House convention: "Open Source" renders lowercase in the parenthetical.
			if ( 0 === strcasecmp( $hq, 'Open Source' ) ) {
				$hq = 'open source';
			}

			$note = trim( (string) $tool->governance_notes );
			$note = rtrim( $note, '.' );

			$html .= sprintf(
				'  <li><strong>%s</strong> (%s, %s) &mdash; %s.</li>' . "\n",
				esc_html( $tool->tool_name ),
				esc_html( $tool->vendor ),
				esc_html( $hq ),
				esc_html( $note )
			);
		}

		$html .= "</ul>\n\n";
	}

	return $html;
}

/**
 * Swap the static catalog region for table-rendered output.
 *
 * Hooked to a filter added in page-ai-governance-detail.php. If the filter
 * is not present, or the markers are missing, or the table is empty, the
 * static HTML from the config renders untouched.
 *
 * @param string $body_html Body HTML from the governance config.
 * @param string $slug      Governance page slug.
 * @return string
 */
function srj_ai_tools_filter_body( $body_html, $slug = '' ) {
	if ( 'ai-tools' !== $slug ) {
		return $body_html;
	}

	$start = strpos( $body_html, '<!--SRJ_TOOLS_CATALOG_START-->' );
	$end   = strpos( $body_html, '<!--SRJ_TOOLS_CATALOG_END-->' );
	if ( false === $start || false === $end || $end <= $start ) {
		return $body_html;
	}

	$catalog = srj_ai_tools_render_catalog();
	if ( '' === $catalog ) {
		return $body_html;
	}

	$before = substr( $body_html, 0, $start );
	$after  = substr( $body_html, $end + strlen( '<!--SRJ_TOOLS_CATALOG_END-->' ) );

	return $before . $catalog . $after;
}
add_filter( 'srj_governance_body_html', 'srj_ai_tools_filter_body', 10, 2 );

/* ---------------------------------------------------------------------------
 * Admin
 * ------------------------------------------------------------------------- */

/**
 * Register the admin screen under Tools.
 */
function srj_ai_tools_admin_menu() {
	add_management_page(
		'AI Tools Inventory',
		'AI Tools Inventory',
		'manage_options',
		'srj-ai-tools',
		'srj_ai_tools_admin_page'
	);
}
add_action( 'admin_menu', 'srj_ai_tools_admin_menu' );

/**
 * Admin screen: status, category breakdown, and the import trigger.
 */
function srj_ai_tools_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Insufficient permissions.' );
	}

	global $wpdb;
	$table  = srj_ai_tools_table();
	$notice = '';

	if (
		isset( $_POST['srj_ai_tools_import'] )
		&& check_admin_referer( 'srj_ai_tools_import_action', 'srj_ai_tools_nonce' )
	) {
		$result = srj_ai_tools_import_seed();
		if ( is_wp_error( $result ) ) {
			$notice = '<div class="notice notice-error"><p>Import failed: '
				. esc_html( $result->get_error_message() ) . '</p></div>';
		} else {
			$notice = '<div class="notice notice-success"><p>Import complete. '
				. sprintf(
					'%d inserted, %d updated, %d failed, %d rows in seed.',
					(int) $result['inserted'],
					(int) $result['updated'],
					(int) $result['failed'],
					(int) $result['total']
				)
				. '</p></div>';
		}
	}

	$count       = srj_ai_tools_count();
	$last_import = get_option( 'srj_ai_tools_last_import', 'never' );
	$table_ok    = ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) === $table );

	$by_cat = array();
	if ( $table_ok && $count > 0 ) {
		$by_cat = $wpdb->get_results(
			"SELECT category, COUNT(*) AS n FROM {$table}
			 WHERE is_published = 1 GROUP BY category ORDER BY category ASC"
		);
	}

	echo '<div class="wrap">';
	echo '<h1>AI Tools Inventory</h1>';
	echo wp_kses_post( $notice );

	echo '<h2>Status</h2><table class="widefat striped" style="max-width:640px"><tbody>';
	printf(
		'<tr><td><strong>Table</strong></td><td><code>%s</code> %s</td></tr>',
		esc_html( $table ),
		$table_ok ? 'exists' : '<strong>missing</strong>'
	);
	printf( '<tr><td><strong>Published tools</strong></td><td>%d</td></tr>', (int) $count );
	printf( '<tr><td><strong>Categories</strong></td><td>%d</td></tr>', count( $by_cat ) );
	printf( '<tr><td><strong>Last import</strong></td><td>%s</td></tr>', esc_html( $last_import ) );
	printf(
		'<tr><td><strong>Catalog page source</strong></td><td>%s</td></tr>',
		$count > 0 ? 'database' : 'static config HTML (fallback)'
	);
	echo '</tbody></table>';

	echo '<h2>Import</h2>';
	echo '<p>Imports <code>srj-ai-tools-data.php</code> from the mu-plugins directory. '
		. 'Existing rows are matched on tool name plus vendor and have their catalog fields refreshed. '
		. 'Operational columns (owner, department, cost, approval, review dates) are never overwritten.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'srj_ai_tools_import_action', 'srj_ai_tools_nonce' );
	submit_button( 'Import seed catalog', 'primary', 'srj_ai_tools_import' );
	echo '</form>';

	if ( ! empty( $by_cat ) ) {
		echo '<h2>Breakdown by category</h2>';
		echo '<table class="widefat striped" style="max-width:640px"><thead><tr>'
			. '<th>Category</th><th style="width:90px">Tools</th></tr></thead><tbody>';
		foreach ( $by_cat as $cat ) {
			printf(
				'<tr><td>%s</td><td>%d</td></tr>',
				esc_html( $cat->category ),
				(int) $cat->n
			);
		}
		echo '</tbody></table>';
	}

	echo '</div>';
}
