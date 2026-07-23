<?php
/**
 * Plugin Name: SRJ Relevanssi Config Indexer + Search Styles
 * Description: (1) feeds body_html from config-driven templates into
 *              Relevanssi's search index; (2) prints inline CSS for
 *              the announce-bar search icon and slide-down panel.
 * Version: 1.2.0
 * Author: SRJ Consulting & Services LLC
 *
 * v1.2.0 (July 20, 2026): governance detection no longer relies on
 * _wp_page_template. On this host the template registry is dead and the
 * universal router resolves governance pages by ancestry, so
 * get_page_template_slug() returns '' for them and this indexer was
 * silently skipping their body_html. Found when /ai-governance/ai-tools/
 * returned no search hits for tool names it plainly contains. Detection
 * is now: template slug matches, OR the page has ai-governance as an
 * ancestor, which is exactly the router's own rule.
 *
 * v1.1.1 (July 13, 2026): wp_head hook priority lowered from 100 to 1
 * to match the pattern of srj-mu-test.php (which fired successfully at
 * priority 1). At priority 100 the callback was being registered but
 * not executed on this host. Callback also converted to an anonymous
 * function so nothing about the registration differs from the working
 * test pattern. !important flags on every rule prevent later CSS
 * overrides even though we now output first.
 *
 * v1.1.0 (July 13, 2026): CSS moved inline from the appended style.css
 * block so search UI cannot fail to load. High-specificity selectors
 * plus !important on the properties Kadence's button defaults were
 * overriding.
 *
 * v1.0.0 (July 13, 2026): initial deploy alongside Relevanssi plugin.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_head', function () {
    echo "\n<!-- srj-search-ui-inline block begin -->\n";
    ?>
<style id="srj-search-ui-inline">
.announce .announce-right { display: inline-flex !important; align-items: center !important; gap: 18px !important; }
.announce .announce-search {
  display: inline-flex !important; align-items: center !important; gap: 6px !important;
  background: transparent !important; border: 1px solid rgba(255,255,255,0.28) !important;
  border-radius: 4px !important; padding: 5px 10px !important; color: #ffffff !important;
  font-family: 'Poppins', 'Open Sans', sans-serif !important; font-size: 13px !important;
  line-height: 1 !important; cursor: pointer !important;
  transition: background .15s ease, border-color .15s ease !important;
  box-shadow: none !important; text-transform: none !important; letter-spacing: 0 !important;
  min-width: 0 !important; height: auto !important;
}
.announce .announce-search:hover, .announce .announce-search:focus-visible {
  background: rgba(255,255,255,0.14) !important; border-color: rgba(255,255,255,0.45) !important;
  outline: none !important;
}
.announce .announce-search[aria-expanded="true"] {
  background: #F07800 !important; border-color: #F07800 !important; color: #ffffff !important;
}
.announce .announce-search svg { display: block !important; width: 14px !important; height: 14px !important; }
.announce .announce-search .announce-search-label { display: inline-block !important; font: inherit !important; color: inherit !important; }
@media (max-width: 720px) { .announce .announce-search.hide-mobile { display: none !important; } }

.srj-search-panel {
  position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important;
  background: #ffffff !important; border-bottom: 1px solid #e4e2dc !important;
  padding: 22px 0 !important; transform: translateY(-100%) !important;
  transition: transform .28s ease !important; z-index: 9990 !important;
  box-shadow: 0 6px 22px rgba(20,20,40,0.08) !important; visibility: hidden;
}
.srj-search-panel.is-open { transform: translateY(0) !important; visibility: visible; }
.srj-search-panel .srj-search-form { display: flex !important; align-items: center !important; gap: 10px !important; margin: 0 !important; }
.srj-search-panel input[type="search"] {
  flex: 1 1 auto !important; border: 1px solid #e4e2dc !important; border-radius: 6px !important;
  padding: 12px 16px !important; font-family: 'Poppins', 'Open Sans', sans-serif !important;
  font-size: 16px !important; color: #15151a !important; background: #f5f2e9 !important;
  outline: none !important; box-shadow: none !important; height: auto !important;
}
.srj-search-panel input[type="search"]:focus { border-color: #F07800 !important; background: #ffffff !important; }
.srj-search-panel .srj-search-submit {
  border: none !important; background: #201868 !important; color: #ffffff !important;
  padding: 12px 22px !important; border-radius: 6px !important;
  font-family: 'Poppins', 'Open Sans', sans-serif !important; font-weight: 600 !important;
  font-size: 15px !important; line-height: 1.2 !important; cursor: pointer !important;
  transition: background .18s ease !important; box-shadow: none !important;
  text-transform: none !important; letter-spacing: 0 !important;
  min-width: 0 !important; height: auto !important;
}
.srj-search-panel .srj-search-submit:hover { background: #F07800 !important; }
.srj-search-panel .srj-search-close {
  border: none !important; background: transparent !important; color: #6b6b78 !important;
  font-size: 28px !important; line-height: 1 !important; cursor: pointer !important;
  padding: 6px 10px !important; box-shadow: none !important; height: auto !important; min-width: 0 !important;
}
.srj-search-panel .srj-search-close:hover { color: #F07800 !important; }

.srj-search-toggle-mobile {
  display: none !important; position: fixed !important; bottom: 20px !important; right: 20px !important;
  width: 48px !important; height: 48px !important; border-radius: 50% !important;
  border: 1px solid #e4e2dc !important; background: #ffffff !important; color: #201868 !important;
  align-items: center !important; justify-content: center !important; cursor: pointer !important;
  z-index: 9989 !important; box-shadow: 0 4px 14px rgba(20,20,40,0.18) !important; padding: 0 !important;
}
.srj-search-toggle-mobile:hover, .srj-search-toggle-mobile:focus-visible {
  background: #F07800 !important; color: #ffffff !important; border-color: #F07800 !important; outline: none !important;
}
.srj-search-toggle-mobile svg { display: block !important; }
@media (max-width: 980px) { .srj-search-toggle-mobile { display: inline-flex !important; } }

.srj-search-page { background: #fafaf6; }
.srj-search-hero { padding: 64px 0 32px; background: #ffffff; border-bottom: 1px solid #e4e2dc; }
.srj-search-title { font-family: 'Lora', 'Alike', serif; color: #1a1146; font-size: 34px; line-height: 1.2; margin: 6px 0 22px; }
.srj-search-form-hero { display: flex; gap: 10px; max-width: 640px; }
.srj-search-form-hero input[type="search"] { flex: 1 1 auto; border: 1px solid #e4e2dc; border-radius: 6px; padding: 12px 16px; font-family: 'Poppins', 'Open Sans', sans-serif; font-size: 16px; background: #f5f2e9; }
.srj-search-form-hero input[type="search"]:focus { border-color: #F07800; background: #ffffff; outline: none; }
.srj-search-form-hero button { border: none; background: #201868; color: #fff; padding: 12px 22px; border-radius: 6px; font-family: 'Poppins', 'Open Sans', sans-serif; font-weight: 600; font-size: 15px; cursor: pointer; }
.srj-search-form-hero button:hover { background: #F07800; }
.srj-search-results { padding: 40px 0 80px; }
.srj-search-list { list-style: none; padding: 0; margin: 0; }
.srj-search-item { border-bottom: 1px solid #e4e2dc; padding: 22px 0; }
.srj-search-item:last-child { border-bottom: 0; }
.srj-search-item-link { display: block; text-decoration: none; color: inherit; }
.srj-search-item-link:hover .srj-search-item-title { color: #F07800; }
.srj-search-item-title { font-family: 'Lora', 'Alike', serif; color: #201868; font-size: 22px; line-height: 1.25; margin: 0 0 4px; transition: color .18s ease; }
.srj-search-item-url { font-family: 'Poppins', 'Open Sans', sans-serif; font-size: 13px; color: #6b6b78; margin: 0 0 8px; word-break: break-all; }
.srj-search-item-excerpt { font-size: 15px; color: #3a3a45; margin: 0; line-height: 1.55; }
.srj-search-item-excerpt strong, .srj-search-item-excerpt em.rlv_highlight, .srj-search-item-excerpt .rlv_highlight { color: #F07800; font-weight: 700; font-style: normal; background: transparent; }
.srj-search-pager { display: flex; gap: 8px; flex-wrap: wrap; justify-content: center; margin-top: 40px; font-family: 'Poppins', 'Open Sans', sans-serif; }
.srj-search-pager .page-numbers { display: inline-block; padding: 8px 14px; border: 1px solid #e4e2dc; border-radius: 4px; color: #201868; text-decoration: none; font-size: 14px; background: #fff; }
.srj-search-pager .page-numbers:hover { background: #201868; color: #fff; border-color: #201868; }
.srj-search-pager .page-numbers.current { background: #F07800; color: #fff; border-color: #F07800; font-weight: 600; }
.srj-search-empty { padding: 40px 0 80px; font-family: 'Poppins', 'Open Sans', sans-serif; color: #3a3a45; }
.srj-search-empty p { font-size: 16px; margin: 0 0 18px; }
.srj-search-hub-list { list-style: none; padding: 0; margin: 0; }
.srj-search-hub-list li { padding: 8px 0; border-bottom: 1px solid #e4e2dc; }
.srj-search-hub-list li:last-child { border-bottom: 0; }
.srj-search-hub-list a { color: #201868; text-decoration: none; font-weight: 600; font-size: 16px; }
.srj-search-hub-list a:hover { color: #F07800; }

.screen-reader-text { position: absolute !important; clip: rect(1px, 1px, 1px, 1px); clip-path: inset(50%); height: 1px; width: 1px; overflow: hidden; white-space: nowrap; }

.relevanssi-live-search-results { border: 1px solid #e4e2dc; border-radius: 6px; box-shadow: 0 6px 22px rgba(20,20,40,0.14); background: #fff; margin-top: 6px; font-family: 'Poppins', 'Open Sans', sans-serif; }
.relevanssi-live-search-results .rlv-item, .relevanssi-live-search-results a { padding: 10px 14px; border-bottom: 1px solid #efede7; color: #201868; text-decoration: none; font-size: 14px; display: block; }
.relevanssi-live-search-results .rlv-item:last-child, .relevanssi-live-search-results a:last-child { border-bottom: 0; }
.relevanssi-live-search-results .rlv-item:hover, .relevanssi-live-search-results a:hover { background: #f5f2e9; color: #F07800; }
</style>
    <?php
    echo "\n<!-- srj-search-ui-inline block end -->\n";
}, 1 );

/* ---------------------------------------------------------------------------
 * Relevanssi content indexer.
 * ------------------------------------------------------------------------ */

add_filter( 'relevanssi_content_to_index', 'srj_relevanssi_add_config_content', 10, 2 );
function srj_relevanssi_add_config_content( $content, $post ) {

    if ( ! is_object( $post ) || 'page' !== $post->post_type ) {
        return $content;
    }

    $template = get_page_template_slug( $post->ID );
    $slug     = $post->post_name;
    $add      = '';

    if ( srj_relevanssi_is_governance_page( $post->ID, $template ) ) {
        $config_file = get_stylesheet_directory() . '/inc/ai-governance-config.php';
        if ( file_exists( $config_file ) ) {
            $SRJ_GOVERNANCE = array();
            include $config_file;
            if ( isset( $SRJ_GOVERNANCE[ $slug ] ) && is_array( $SRJ_GOVERNANCE[ $slug ] ) ) {
                $entry = $SRJ_GOVERNANCE[ $slug ];
                foreach ( array( 'title', 'subtitle', 'short', 'focus_keyword', 'body_html' ) as $field ) {
                    if ( isset( $entry[ $field ] ) && is_string( $entry[ $field ] ) ) {
                        $add .= ' ' . $entry[ $field ];
                    }
                }
            }
        }
    }

    if ( 'page-book-detail.php' === $template ) {
        $template_file = get_stylesheet_directory() . '/page-book-detail.php';
        $add .= ' ' . srj_relevanssi_extract_from_template( $template_file, $slug, array( 'title', 'subtitle', 'summary', 'body_html' ) );
    }

    if ( 'page-industry-detail.php' === $template ) {
        $template_file = get_stylesheet_directory() . '/page-industry-detail.php';
        $add .= ' ' . srj_relevanssi_extract_from_template( $template_file, $slug, array( 'name', 'subtitle', 'intro', 'ai_state', 'tools', 'services_intro' ) );
    }

    if ( '' === trim( $add ) ) { return $content; }

    $add = html_entity_decode( wp_strip_all_tags( $add ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
    return trim( $content . ' ' . $add );
}

/**
 * Is this page driven by the AI Governance config?
 *
 * Checks the template slug first, then falls back to ancestry, because
 * pages routed by the universal template router carry no
 * _wp_page_template meta at all.
 *
 * @param int    $post_id  Page ID.
 * @param string $template Template slug from get_page_template_slug().
 * @return bool
 */
function srj_relevanssi_is_governance_page( $post_id, $template ) {
    if ( 'page-ai-governance-detail.php' === $template ) {
        return true;
    }
    foreach ( get_post_ancestors( $post_id ) as $ancestor_id ) {
        if ( 'ai-governance' === get_post_field( 'post_name', $ancestor_id ) ) {
            return true;
        }
    }
    return false;
}

function srj_relevanssi_extract_from_template( $file_path, $slug, $fields ) {
    if ( ! file_exists( $file_path ) || ! is_readable( $file_path ) ) { return ''; }
    $text = @file_get_contents( $file_path );
    if ( false === $text || '' === $text ) { return ''; }

    $slug_q  = preg_quote( $slug, '/' );
    $pattern = "/'" . $slug_q . "'\s*=>\s*array\s*\(\s*(.*?)\n\s*\)\s*,/s";
    if ( ! preg_match( $pattern, $text, $matches ) ) { return ''; }

    $entry = $matches[1];
    $out   = array();

    foreach ( $fields as $field ) {
        $field_q = preg_quote( $field, '/' );
        $nowdoc = "/'" . $field_q . "'\s*=>\s*<<<'([A-Z0-9_]+)'\s*\n(.*?)\n\s*\\1/s";
        if ( preg_match( $nowdoc, $entry, $m ) ) { $out[] = $m[2]; continue; }
        $sq = "/'" . $field_q . "'\s*=>\s*'((?:[^'\\\\]|\\\\.)*)'/s";
        if ( preg_match( $sq, $entry, $m ) ) {
            $out[] = str_replace( array( "\\'", '\\"' ), array( "'", '"' ), $m[1] );
            continue;
        }
        $dq = '/\'' . $field_q . '\'\s*=>\s*"((?:[^"\\\\]|\\\\.)*)"/s';
        if ( preg_match( $dq, $entry, $m ) ) {
            $out[] = str_replace( array( '\\"', "\\'" ), array( '"', "'" ), $m[1] );
        }
    }
    return implode( ' ', $out );
}

add_filter( 'document_title_parts', 'srj_relevanssi_search_title', 20 );
function srj_relevanssi_search_title( $parts ) {
    if ( is_search() ) {
        $q = get_search_query();
        $parts['title'] = ( '' !== $q ) ? sprintf( 'Search: %s', $q ) : 'Search';
    }
    return $parts;
}
