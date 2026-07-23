<?php
/**
 * Plugin Name: SRJ AI Governance Router + Styles
 * Description: Two jobs.
 *              (1) ROUTER: forces every page under /ai-governance/ to render
 *                  through page-ai-governance-detail.php (and the hub itself
 *                  through page-ai-governance.php) using the template_include
 *                  filter. This bypasses WordPress's Template Name registry,
 *                  which is not populating on this install (the Page Attributes
 *                  template dropdown is empty for every named template in the
 *                  theme, not just AI Governance). Without this, the governance
 *                  pages silently fall back to page.php, which renders the hero,
 *                  an empty the_content(), and the CTAs, but never the config
 *                  body. That is the "no content" symptom.
 *              (2) STYLES: ships the .srjgov-* stylesheet, which was never
 *                  written when the library was built. Even once the router
 *                  fixes the template, the body markup needs these rules.
 * Version: 1.1.0
 * Author: SRJ Consulting & Services LLC
 *
 * v1.1.0 (July 13, 2026): added (a) the Rank Math table-of-contents filter and
 * (b) styles for the jump-link TOC and lede paragraph that the v2 config now
 * emits on all 49 pages. Ship this alongside the v2 ai-governance-config.php.
 *
 * Diagnostics: append ?srj_gov_debug=1 to any /ai-governance/ URL to print an
 * HTML comment in the source showing which template was selected and why.
 *
 * Longer term: the router is a workaround for a broken theme template scan.
 * Worth investigating why get_page_templates() returns empty on this host.
 * The styles belong in assets/css/ai-governance.css with a conditional
 * enqueue in functions.php once that path is verified.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------------------------------------------------------------------------
 * PART 1: Template router.
 *
 * template_include is the last filter before WordPress loads the template
 * file. Returning a different path here overrides everything: the Page
 * Attributes dropdown, the _wp_page_template post meta, and the template
 * hierarchy. It is the correct hook for forcing a template when the normal
 * assignment mechanism is unavailable.
 * ------------------------------------------------------------------------ */

add_filter( 'template_include', 'srj_gov_route_template', 99 );

function srj_gov_route_template( $template ) {

    if ( ! is_page() ) {
        return $template;
    }

    $post = get_queried_object();
    if ( ! $post || ! isset( $post->ID ) ) {
        return $template;
    }

    $theme_dir = get_stylesheet_directory();
    $hub_slug  = 'ai-governance';

    // Is this the hub page itself?
    if ( $post->post_name === $hub_slug ) {
        $hub_template = $theme_dir . '/page-ai-governance.php';
        if ( file_exists( $hub_template ) ) {
            $GLOBALS['srj_gov_routed'] = 'hub -> page-ai-governance.php';
            return $hub_template;
        }
        return $template;
    }

    // Is this page a descendant of the hub?
    $hub = get_page_by_path( $hub_slug, OBJECT, 'page' );
    if ( ! $hub ) {
        return $template;
    }

    $ancestors = get_post_ancestors( $post->ID );
    if ( ! in_array( (int) $hub->ID, array_map( 'intval', $ancestors ), true ) ) {
        return $template;
    }

    $detail_template = $theme_dir . '/page-ai-governance-detail.php';
    if ( file_exists( $detail_template ) ) {
        $GLOBALS['srj_gov_routed'] = 'detail -> page-ai-governance-detail.php (slug: ' . $post->post_name . ')';
        return $detail_template;
    }

    return $template;
}

/* ---------------------------------------------------------------------------
 * PART 2: Rank Math, declare the table of contents.
 *
 * Rank Math's "content has a table of contents" check looks for a known TOC
 * plugin, finds none, and fails, even when a TOC is present. The v2 config
 * emits a genuine jump-link TOC (<nav class="srjgov-toc">) with an anchor to
 * every H2 on every one of the 49 pages, so declaring it here is accurate
 * rather than a workaround.
 * ------------------------------------------------------------------------ */

add_filter( 'rank_math/researches/toc_plugin', '__return_true' );

/* ---------------------------------------------------------------------------
 * PART 3: Diagnostics. Append ?srj_gov_debug=1 to see routing decisions.
 * ------------------------------------------------------------------------ */

add_action( 'wp_head', function () {

    if ( ! isset( $_GET['srj_gov_debug'] ) ) { return; }

    echo "\n<!-- SRJ_GOV_DEBUG_BEGIN\n";

    if ( is_page() ) {
        $post = get_queried_object();
        echo "  is_page: yes\n";
        echo "  post ID: " . ( isset( $post->ID ) ? $post->ID : 'n/a' ) . "\n";
        echo "  post_name: " . ( isset( $post->post_name ) ? $post->post_name : 'n/a' ) . "\n";
        echo "  _wp_page_template meta: '" . get_post_meta( $post->ID, '_wp_page_template', true ) . "'\n";

        $hub = get_page_by_path( 'ai-governance', OBJECT, 'page' );
        echo "  hub found: " . ( $hub ? 'yes (ID ' . $hub->ID . ')' : 'NO' ) . "\n";

        if ( $hub ) {
            $anc = get_post_ancestors( $post->ID );
            echo "  ancestors: " . ( empty( $anc ) ? '(none)' : implode( ', ', $anc ) ) . "\n";
            echo "  hub in ancestors: " . ( in_array( (int) $hub->ID, array_map( 'intval', $anc ), true ) ? 'yes' : 'no' ) . "\n";
        }

        $detail = get_stylesheet_directory() . '/page-ai-governance-detail.php';
        echo "  detail template exists: " . ( file_exists( $detail ) ? 'yes' : 'NO' ) . "\n";
        echo "  detail template path: {$detail}\n";

        $config = get_stylesheet_directory() . '/inc/ai-governance-config.php';
        echo "  config exists: " . ( file_exists( $config ) ? 'yes (' . filesize( $config ) . ' bytes)' : 'NO' ) . "\n";

        echo "  ROUTED: " . ( isset( $GLOBALS['srj_gov_routed'] ) ? $GLOBALS['srj_gov_routed'] : 'NOT ROUTED (fell through to default)' ) . "\n";
    } else {
        echo "  is_page: no\n";
    }

    echo "SRJ_GOV_DEBUG_END -->\n\n";
}, 1 );

/* ---------------------------------------------------------------------------
 * PART 4: The stylesheet.
 * ------------------------------------------------------------------------ */

add_action( 'wp_head', function () {
    ?>
<style id="srj-ai-governance-styles">
.longform { background: #ffffff; padding: 56px 0 72px; }
.longform .container { max-width: 860px; }

/* -------- Jump-link table of contents (v1.1.0) -------- */
.srjgov-toc {
  background: #fafaf6; border: 1px solid #e4e2dc; border-radius: 8px;
  padding: 22px 26px; margin: 0 0 36px;
}
.srjgov-toc-label {
  font-family: 'Poppins','Inter',sans-serif; font-size: 11px; font-weight: 700;
  letter-spacing: .16em; text-transform: uppercase; color: #b96000;
  margin: 0 0 12px !important;
}
.srjgov-toc ul { list-style: none; margin: 0; padding: 0; }
.srjgov-toc li { margin: 0 0 8px; padding: 0; }
.srjgov-toc li:last-child { margin-bottom: 0; }
.srjgov-toc a {
  font-family: 'Poppins','Open Sans',sans-serif; font-size: 14.5px; line-height: 1.45;
  color: #24185b; text-decoration: none; border-bottom: 1px solid transparent;
  transition: color .18s ease, border-color .18s ease;
}
.srjgov-toc a:hover { color: #ef7c00; border-bottom-color: #ef7c00; }

.srjgov-lede {
  font-family: 'Poppins','Open Sans',sans-serif; font-size: 18px;
  line-height: 1.6; color: #3a3a45; margin: 0 0 28px;
}

.srjgov-detail-body {
  font-family: 'Poppins','Open Sans',sans-serif;
  font-size: 17px; line-height: 1.72; color: #3a3a45;
}
.srjgov-detail-body p { margin: 0 0 20px; }
.srjgov-detail-body h2 {
  font-family: 'Lora','Alike',serif; font-size: 28px; line-height: 1.25;
  color: #1a1146; margin: 44px 0 18px; letter-spacing: -0.01em;
  scroll-margin-top: 100px;
}
.srjgov-detail-body h2:first-child { margin-top: 0; }
.srjgov-detail-body h3 {
  font-family: 'Lora','Alike',serif; font-size: 21px; line-height: 1.3;
  color: #24185b; margin: 30px 0 12px;
}
.srjgov-detail-body strong { color: #1a1146; font-weight: 600; }
.srjgov-detail-body em { font-style: italic; }
.srjgov-detail-body a {
  color: #24185b; text-decoration: underline; text-underline-offset: 2px;
  text-decoration-color: rgba(36,24,91,0.3);
  transition: color .18s ease, text-decoration-color .18s ease;
}
.srjgov-detail-body a:hover { color: #ef7c00; text-decoration-color: #ef7c00; }
.srjgov-detail-body ul, .srjgov-detail-body ol { margin: 0 0 22px; padding-left: 24px; }
.srjgov-detail-body li { margin-bottom: 10px; padding-left: 4px; }
.srjgov-detail-body ul li::marker { color: #ef7c00; }

.srjgov-tldr {
  background: #f5f2e9; border-left: 4px solid #ef7c00;
  border-radius: 0 6px 6px 0; padding: 24px 28px; margin: 0 0 40px;
}
.srjgov-tldr-label {
  font-family: 'Poppins','Inter',sans-serif; font-size: 11px; font-weight: 700;
  letter-spacing: 0.16em; text-transform: uppercase; color: #b96000;
  margin: 0 0 10px !important;
}
.srjgov-tldr p:last-child {
  margin-bottom: 0 !important; font-size: 17px; line-height: 1.65; color: #15151a;
}
.srjgov-tldr strong { color: #1a1146; font-weight: 600; }

.srjgov-children-block {
  margin: 56px 0 0; padding: 32px 0 0; border-top: 1px solid #e4e2dc;
}
.srjgov-children-block h2 {
  font-family: 'Lora','Alike',serif; font-size: 26px; color: #1a1146; margin: 0 0 22px;
}
.srjgov-children-list { list-style: none; margin: 0; padding: 0; }
.srjgov-children-list li {
  padding: 18px 0; border-bottom: 1px solid #efede7; margin: 0;
}
.srjgov-children-list li:last-child { border-bottom: 0; }
.srjgov-children-list a {
  display: block; font-family: 'Lora','Alike',serif; font-size: 19px;
  color: #24185b; text-decoration: none; margin-bottom: 5px;
  transition: color .18s ease;
}
.srjgov-children-list a:hover { color: #ef7c00; }
.srjgov-child-teaser {
  display: block; font-family: 'Poppins','Open Sans',sans-serif;
  font-size: 14.5px; line-height: 1.55; color: #6b6b78;
}

.srjgov-cta {
  margin: 56px 0 0; padding: 36px 40px; background: #1a1146;
  border-radius: 8px; text-align: center;
}
.srjgov-cta h2 {
  font-family: 'Lora','Alike',serif; font-size: 26px; line-height: 1.25;
  color: #ffffff; margin: 0 0 14px;
}
.srjgov-cta p {
  font-family: 'Poppins','Open Sans',sans-serif; font-size: 15.5px;
  line-height: 1.6; color: rgba(255,255,255,0.82);
  margin: 0 auto 24px; max-width: 620px;
}
.srjgov-cta-btn {
  display: inline-block; background: #ef7c00; color: #ffffff !important;
  font-family: 'Poppins','Open Sans',sans-serif; font-weight: 600; font-size: 15px;
  letter-spacing: 0.03em; padding: 14px 30px; border-radius: 4px;
  text-decoration: none !important; border: 2px solid #ef7c00;
  transition: background .18s ease, color .18s ease, transform .18s ease;
}
.srjgov-cta-btn:hover {
  background: #ffffff; color: #1a1146 !important; border-color: #ffffff;
  transform: translateY(-1px);
}

.srjgov-hub-grid {
  display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 24px; margin: 40px 0 0;
}
.srjgov-hub-card {
  background: #ffffff; border: 1px solid #e4e2dc; border-radius: 8px;
  padding: 26px 26px 24px;
  transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
}
.srjgov-hub-card:hover {
  border-color: #ef7c00; box-shadow: 0 6px 22px rgba(20,20,40,0.08);
  transform: translateY(-2px);
}
.srjgov-hub-card h3 {
  font-family: 'Lora','Alike',serif; font-size: 20px; line-height: 1.28; margin: 0 0 8px;
}
.srjgov-hub-card h3 a { color: #1a1146; text-decoration: none; transition: color .18s ease; }
.srjgov-hub-card:hover h3 a { color: #ef7c00; }
.srjgov-hub-card-subtitle {
  font-family: 'Poppins','Open Sans',sans-serif; font-size: 13px;
  font-style: italic; color: #6b6b78; margin: 0 0 12px;
}
.srjgov-hub-card-short {
  font-family: 'Poppins','Open Sans',sans-serif; font-size: 14.5px;
  line-height: 1.6; color: #3a3a45; margin: 0;
}

@media (max-width: 860px) {
  .longform { padding: 40px 0 56px; }
  .srjgov-detail-body { font-size: 16px; }
  .srjgov-detail-body h2 { font-size: 24px; margin: 36px 0 14px; }
  .srjgov-detail-body h3 { font-size: 19px; }
  .srjgov-tldr { padding: 20px 22px; margin-bottom: 32px; }
  .srjgov-toc { padding: 18px 20px; }
  .srjgov-cta { padding: 28px 24px; }
  .srjgov-cta h2 { font-size: 22px; }
  .srjgov-hub-grid { grid-template-columns: 1fr; }
}
</style>
    <?php
}, 1 );
