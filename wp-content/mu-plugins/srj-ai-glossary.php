<?php
/**
 * Plugin Name:  SRJ AI Glossary
 * Description:  Database layer for the AI Glossary. Creates wp_srj_glossary,
 *               imports the seed terms, and exposes the query API the
 *               page-ai-glossary.php template renders from.
 * Version:      1.0.0
 * Author:       SRJ Consulting & Services LLC
 *
 * Phase 1 sibling of the SRJ AI Tools Inventory plugin, same design:
 * a must-use plugin, schema version-gated on an option and checked at
 * admin_init, manual-only import from a bundled seed file, and an admin
 * screen under Tools that reports status and drives the import.
 *
 * Unlike the tools catalog there is no static fallback: the glossary has
 * no config-driven predecessor, so the database is the only source. The
 * template renders an explanatory notice when the table is empty rather
 * than a blank page.
 *
 * @package srj-consulting
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SRJ_GLOSSARY_VERSION', '1.0.0' );
define( 'SRJ_GLOSSARY_DB_VERSION', 1 );

/**
 * Fully qualified table name.
 *
 * @return string
 */
function srj_glossary_table() {
	global $wpdb;
	return $wpdb->prefix . 'srj_glossary';
}

/* ---------------------------------------------------------------------------
 * Schema
 * ------------------------------------------------------------------------- */

/**
 * Create or upgrade the glossary table. Idempotent.
 */
function srj_glossary_install() {
	global $wpdb;

	$table   = srj_glossary_table();
	$collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE {$table} (
		id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		term VARCHAR(190) NOT NULL DEFAULT '',
		term_slug VARCHAR(190) NOT NULL DEFAULT '',
		category VARCHAR(190) NOT NULL DEFAULT '',
		definition TEXT NULL,
		example TEXT NULL,
		see_also VARCHAR(255) NOT NULL DEFAULT '',
		source_note VARCHAR(255) NOT NULL DEFAULT '',
		is_published TINYINT(1) NOT NULL DEFAULT 1,
		date_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		date_modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		UNIQUE KEY term_slug (term_slug),
		KEY category (category),
		KEY is_published (is_published)
	) {$collate};";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	update_option( 'srj_glossary_db_version', SRJ_GLOSSARY_DB_VERSION );
}

/**
 * Run the installer when the stored schema version is behind.
 */
function srj_glossary_maybe_install() {
	if ( (int) get_option( 'srj_glossary_db_version', 0 ) < SRJ_GLOSSARY_DB_VERSION ) {
		srj_glossary_install();
	}
}
add_action( 'admin_init', 'srj_glossary_maybe_install' );

/* ---------------------------------------------------------------------------
 * Import
 * ------------------------------------------------------------------------- */

/**
 * Import the bundled seed glossary.
 *
 * Upsert keyed on term_slug. Editorial columns (see_also, source_note) and
 * the published flag are left untouched on existing rows, so a re-import
 * refreshes definitions without discarding hand edits.
 *
 * @return array|WP_Error
 */
function srj_glossary_import_seed() {
	global $wpdb;

	$seed_file = __DIR__ . '/srj-ai-glossary-data.php';
	if ( ! file_exists( $seed_file ) ) {
		return new WP_Error( 'srj_no_seed', 'Seed file srj-ai-glossary-data.php not found in mu-plugins.' );
	}

	$rows = include $seed_file;
	if ( ! is_array( $rows ) || empty( $rows ) ) {
		return new WP_Error( 'srj_bad_seed', 'Seed file did not return a non-empty array.' );
	}

	srj_glossary_maybe_install();

	$table    = srj_glossary_table();
	$inserted = 0;
	$updated  = 0;
	$failed   = 0;

	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) || count( $row ) < 5 ) {
			$failed++;
			continue;
		}

		list( $term, $term_slug, $category, $definition, $example ) = $row;

		$existing_id = $wpdb->get_var(
			$wpdb->prepare( "SELECT id FROM {$table} WHERE term_slug = %s", $term_slug )
		);

		$data = array(
			'term'       => $term,
			'term_slug'  => $term_slug,
			'category'   => $category,
			'definition' => $definition,
			'example'    => $example,
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

	update_option( 'srj_glossary_last_import', current_time( 'mysql' ) );

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
 * Published terms grouped by category, categories and terms alphabetical.
 *
 * @return array category => array of row objects
 */
function srj_glossary_get_grouped() {
	global $wpdb;

	$table  = srj_glossary_table();
	$exists = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) );
	if ( $exists !== $table ) {
		return array();
	}

	$rows = $wpdb->get_results(
		"SELECT term, term_slug, category, definition, example
		 FROM {$table}
		 WHERE is_published = 1
		 ORDER BY category ASC, term ASC"
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
 * Count published terms.
 *
 * @return int
 */
function srj_glossary_count() {
	global $wpdb;
	$table  = srj_glossary_table();
	$exists = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) );
	if ( $exists !== $table ) {
		return 0;
	}
	return (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE is_published = 1" );
}

/**
 * Distinct first letters present in the published set, uppercase.
 *
 * @return array
 */
function srj_glossary_letters() {
	global $wpdb;
	$table  = srj_glossary_table();
	$exists = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) );
	if ( $exists !== $table ) {
		return array();
	}
	$letters = $wpdb->get_col(
		"SELECT DISTINCT UPPER(LEFT(term, 1)) FROM {$table} WHERE is_published = 1 ORDER BY 1 ASC"
	);
	return array_values( array_filter( (array) $letters ) );
}

/**
 * Slugify a category name for anchor ids.
 *
 * @param string $category Category name.
 * @return string
 */
function srj_glossary_anchor( $category ) {
	$slug = strtolower( $category );
	$slug = str_replace( '&', 'and', $slug );
	$slug = preg_replace( '/[^a-z0-9]+/', '-', $slug );
	return trim( $slug, '-' );
}

/* ---------------------------------------------------------------------------
 * Admin
 * ------------------------------------------------------------------------- */

/**
 * Register the admin screen under Tools.
 */
function srj_glossary_admin_menu() {
	add_management_page(
		'AI Glossary',
		'AI Glossary',
		'manage_options',
		'srj-ai-glossary',
		'srj_glossary_admin_page'
	);
}
add_action( 'admin_menu', 'srj_glossary_admin_menu' );

/**
 * Admin screen: status, category breakdown, import trigger.
 */
function srj_glossary_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Insufficient permissions.' );
	}

	global $wpdb;
	$table  = srj_glossary_table();
	$notice = '';

	if (
		isset( $_POST['srj_glossary_import'] )
		&& check_admin_referer( 'srj_glossary_import_action', 'srj_glossary_nonce' )
	) {
		$result = srj_glossary_import_seed();
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

	$count       = srj_glossary_count();
	$last_import = get_option( 'srj_glossary_last_import', 'never' );
	$table_ok    = ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) === $table );

	$by_cat = array();
	if ( $table_ok && $count > 0 ) {
		$by_cat = $wpdb->get_results(
			"SELECT category, COUNT(*) AS n FROM {$table}
			 WHERE is_published = 1 GROUP BY category ORDER BY category ASC"
		);
	}

	echo '<div class="wrap">';
	echo '<h1>AI Glossary</h1>';
	echo wp_kses_post( $notice );

	echo '<h2>Status</h2><table class="widefat striped" style="max-width:640px"><tbody>';
	printf(
		'<tr><td><strong>Table</strong></td><td><code>%s</code> %s</td></tr>',
		esc_html( $table ),
		$table_ok ? 'exists' : '<strong>missing</strong>'
	);
	printf( '<tr><td><strong>Published terms</strong></td><td>%d</td></tr>', (int) $count );
	printf( '<tr><td><strong>Categories</strong></td><td>%d</td></tr>', count( $by_cat ) );
	printf( '<tr><td><strong>Last import</strong></td><td>%s</td></tr>', esc_html( $last_import ) );
	echo '</tbody></table>';

	echo '<h2>Import</h2>';
	echo '<p>Imports <code>srj-ai-glossary-data.php</code> from the mu-plugins directory. '
		. 'Existing terms are matched on slug and have term, category, definition, and example refreshed. '
		. 'Editorial columns (see also, source note) and the published flag are never overwritten.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'srj_glossary_import_action', 'srj_glossary_nonce' );
	submit_button( 'Import seed glossary', 'primary', 'srj_glossary_import' );
	echo '</form>';

	if ( ! empty( $by_cat ) ) {
		echo '<h2>Breakdown by category</h2>';
		echo '<table class="widefat striped" style="max-width:640px"><thead><tr>'
			. '<th>Category</th><th style="width:90px">Terms</th></tr></thead><tbody>';
		foreach ( $by_cat as $cat ) {
			printf( '<tr><td>%s</td><td>%d</td></tr>', esc_html( $cat->category ), (int) $cat->n );
		}
		echo '</tbody></table>';
	}

	echo '</div>';
}
