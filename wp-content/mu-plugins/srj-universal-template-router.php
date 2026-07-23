<?php
/**
 * Plugin Name: SRJ Universal Template Router
 * Description: Repairs the theme-wide named-template registration failure.
 *
 *              THE BUG. WordPress has stopped registering `Template Name:`
 *              headers from this theme. The Page Attributes -> Template
 *              dropdown offers only "Default template" on every page: Book
 *              Detail, Industry Detail, Services Pillar, Service Detail, AI
 *              Governance Detail, Books Pillar, Books landing, Newsletter
 *              Welcome, and Newsletter Hub are all absent. Existing pages
 *              still render because their _wp_page_template meta was written
 *              back when the scan worked. Any page created after the failure
 *              silently falls back to page.php, which renders the hero, an
 *              empty the_content(), and the CTAs, but never the config body.
 *              There is no error and no admin signal. The page simply looks
 *              empty. This cost a full working day on
 *              /ai-governance/agency-enforcement/ before the cause was found.
 *
 *              THE FIX. Hook `template_include` at priority 99 and resolve the
 *              template ourselves, from the page's own slug and ancestry. This
 *              fires after the template hierarchy resolves and overrides
 *              everything: the dropdown, the _wp_page_template meta, and the
 *              filename match. It does not depend on the broken registry.
 *
 *              This mu-plugin SUPERSEDES srj-ai-governance-router.php, which
 *              covered /ai-governance/ only. Delete that file after deploying
 *              this one. The .srjgov-* stylesheet and the Rank Math TOC filter
 *              that lived in it are carried over here, so nothing is lost.
 *
 * Version: 1.0.0
 * Author: SRJ Consulting & Services LLC
 *
 * ROUTING RULES, in order of precedence:
 *   1. Explicit slug map (SRJ_TEMPLATE_MAP below) wins.
 *   2. Ancestry rules cover the config-driven trees, where the child slugs are
 *      many and change over time:
 *        under /ai-governance/  -> page-ai-governance-detail.php
 *        under /books/{pillar}/ -> page-book-detail.php
 *        under /books/          -> page-pillar.php   (a pillar page)
 *        under /industries/     -> page-industry-detail.php
 *        under /services/{pillar}/ -> the page's own page-{slug}.php if it
 *                                     exists, else page-service-detail.php
 *        under /services/       -> page-services-pillar.php
 *   3. Filename match: if page-{slug}.php exists in the theme, use it.
 *   4. Otherwise leave WordPress alone.
 *
 * Rule 3 is what makes this safe for the 20 Standard A single-file templates.
 * They already resolve by filename today; this just guarantees it rather than
 * relying on a registry that no longer works.
 *
 * DIAGNOSTICS: append ?srj_route_debug=1 to any page to see, in an HTML
 * comment, which rule fired and which template was chosen.
 *
 * ROOT CAUSE IS STILL UNFIXED. This is a workaround, not a repair. Something
 * on this host (Object Cache Pro is the prime suspect) is preventing
 * get_page_templates() from populating. Fixing that properly is still the
 * highest-value open item. Until then, this file is load-bearing: do not
 * delete it.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------------------------------------------------------------------------
 * Explicit slug -> template map. Highest precedence.
 * Add a line here whenever a page needs a template its slug does not imply.
 * ------------------------------------------------------------------------ */

function srj_template_map() {
    return array(
        // Hubs and landings
        'ai-governance'  => 'page-ai-governance.php',
        'books'          => 'page-books.php',
        'services'       => 'page-services.php',
        'industries'     => 'page-industries.php',
        'applications'   => 'page-applications.php',
        'ai-audit'       => 'page-ai-audit.php',

        // Newsletter
        'welcome'        => 'page-welcome.php',
        'newsletter'     => 'page-newsletter.php',

        // Books pillars
        'ai-business-services'        => 'page-pillar.php',
        'ai-risk-governance-security' => 'page-pillar.php',
        // NOTE: the Services pillars share these slugs' shape but sit under
        // /services/, so they are handled by the ancestry rules, not here.
    );
}

/* ---------------------------------------------------------------------------
 * The router.
 * ------------------------------------------------------------------------ */

add_filter( 'template_include', 'srj_universal_route_template', 99 );

function srj_universal_route_template( $template ) {

    if ( ! is_page() ) { return $template; }

    $post = get_queried_object();
    if ( ! $post || empty( $post->ID ) ) { return $template; }

    $dir  = get_stylesheet_directory();
    $slug = $post->post_name;

    $pick = function ( $file, $rule ) use ( $dir, $template ) {
        $path = $dir . '/' . $file;
        if ( file_exists( $path ) ) {
            $GLOBALS['srj_route'] = $rule . ' -> ' . $file;
            return $path;
        }
        $GLOBALS['srj_route'] = $rule . ' -> ' . $file . ' (FILE MISSING, fell through)';
        return null;
    };

    // ---- Rule 1: explicit map -------------------------------------------
    $map = srj_template_map();

    // Guard: the Books pillars and the Services pillars can collide by slug.
    // Only apply the Books-pillar mapping when the page actually sits under
    // /books/. Everything else in the map is unambiguous.
    $ancestor_slugs = srj_ancestor_slugs( $post->ID );

    if ( isset( $map[ $slug ] ) ) {
        $is_books_pillar_slug = in_array( $slug, array( 'ai-business-services', 'ai-risk-governance-security' ), true );
        if ( ! $is_books_pillar_slug || in_array( 'books', $ancestor_slugs, true ) ) {
            $r = $pick( $map[ $slug ], 'map[' . $slug . ']' );
            if ( $r ) { return $r; }
        }
    }

    // ---- Rule 2: ancestry ------------------------------------------------

    // AI Governance: every descendant of the hub is a detail page.
    if ( in_array( 'ai-governance', $ancestor_slugs, true ) ) {
        $r = $pick( 'page-ai-governance-detail.php', 'ancestry[ai-governance]' );
        if ( $r ) { return $r; }
    }

    // Books tree.
    if ( in_array( 'books', $ancestor_slugs, true ) ) {
        // Depth 2 under /books/ is a pillar; depth 3 is a book detail page.
        // ancestor_slugs is ordered nearest-first, so a book detail page has
        // its pillar at index 0 and 'books' at index 1.
        if ( count( $ancestor_slugs ) >= 2 ) {
            $r = $pick( 'page-book-detail.php', 'ancestry[books/pillar]' );
            if ( $r ) { return $r; }
        }
        $r = $pick( 'page-pillar.php', 'ancestry[books]' );
        if ( $r ) { return $r; }
    }

    // Industries tree.
    if ( in_array( 'industries', $ancestor_slugs, true ) ) {
        $r = $pick( 'page-industry-detail.php', 'ancestry[industries]' );
        if ( $r ) { return $r; }
    }

    // Services tree. A service-detail page prefers its OWN single-file
    // template (the v1.46/v1.47 Standard A pattern) and only falls back to
    // the shared hybrid if that file is absent.
    if ( in_array( 'services', $ancestor_slugs, true ) ) {
        if ( count( $ancestor_slugs ) >= 2 ) {
            // Detail page. Own file first.
            $own = 'page-' . $slug . '.php';
            if ( file_exists( $dir . '/' . $own ) ) {
                $r = $pick( $own, 'ancestry[services/pillar] own-file' );
                if ( $r ) { return $r; }
            }
            $r = $pick( 'page-service-detail.php', 'ancestry[services/pillar] shared-hybrid' );
            if ( $r ) { return $r; }
        }
        // Pillar page.
        $r = $pick( 'page-services-pillar.php', 'ancestry[services]' );
        if ( $r ) { return $r; }
    }

    // Applications tree (outcomestar and any siblings).
    if ( in_array( 'applications', $ancestor_slugs, true ) ) {
        $own = 'page-' . $slug . '.php';
        if ( file_exists( $dir . '/' . $own ) ) {
            $r = $pick( $own, 'ancestry[applications] own-file' );
            if ( $r ) { return $r; }
        }
    }

    // ---- Rule 3: filename match -----------------------------------------
    $own = 'page-' . $slug . '.php';
    if ( file_exists( $dir . '/' . $own ) ) {
        $r = $pick( $own, 'filename-match' );
        if ( $r ) { return $r; }
    }

    // ---- Rule 4: leave WordPress alone -----------------------------------
    $GLOBALS['srj_route'] = 'no rule matched, WordPress default: ' . basename( $template );
    return $template;
}

/**
 * Ancestor slugs, nearest first. ['ai-business-services', 'books'] for a book
 * detail page.
 */
function srj_ancestor_slugs( $post_id ) {
    $out = array();
    foreach ( get_post_ancestors( $post_id ) as $aid ) {
        $p = get_post( $aid );
        if ( $p ) { $out[] = $p->post_name; }
    }
    return $out;
}

/* ---------------------------------------------------------------------------
 * Rank Math: declare the table of contents.
 * The AI Governance config emits a real <nav class="srjgov-toc"> with an
 * anchor to every H2 on all 49 pages, so this is accurate, not a workaround.
 * ------------------------------------------------------------------------ */

add_filter( 'rank_math/researches/toc_plugin', '__return_true' );

/* ---------------------------------------------------------------------------
 * Diagnostics: ?srj_route_debug=1
 * ------------------------------------------------------------------------ */

add_action( 'wp_head', function () {

    if ( ! isset( $_GET['srj_route_debug'] ) ) { return; }

    echo "\n<!-- SRJ_ROUTE_DEBUG_BEGIN\n";

    if ( is_page() ) {
        $post = get_queried_object();
        echo "  post ID:   " . $post->ID . "\n";
        echo "  post_name: " . $post->post_name . "\n";
        echo "  ancestors: " . implode( ' < ', srj_ancestor_slugs( $post->ID ) ) . "\n";
        echo "  _wp_page_template meta: '" . get_post_meta( $post->ID, '_wp_page_template', true ) . "'\n";
        echo "  ROUTE:     " . ( isset( $GLOBALS['srj_route'] ) ? $GLOBALS['srj_route'] : 'router did not run' ) . "\n";
        echo "\n  Registry health check (the underlying bug):\n";
        $tpls = wp_get_theme()->get_page_templates( null, 'page' );
        echo "  get_page_templates() returned " . count( $tpls ) . " templates\n";
        if ( empty( $tpls ) ) {
            echo "  ^^ EMPTY. This is the bug. The dropdown has nothing to show.\n";
        } else {
            foreach ( $tpls as $file => $name ) {
                echo "     {$file} => {$name}\n";
            }
            echo "  ^^ NON-EMPTY. The registry may have healed; consider retiring this router.\n";
        }
    }

    echo "SRJ_ROUTE_DEBUG_END -->\n\n";
}, 1 );

/* ---------------------------------------------------------------------------
 * AI Governance stylesheet (carried over from srj-ai-governance-router.php).
 * ------------------------------------------------------------------------ */

add_action( 'wp_head', function () {
    ?>
<style id="srj-ai-governance-styles">
.longform { background: #ffffff; padding: 56px 0 72px; }
.longform .container { max-width: 860px; }

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

.srjgov-children-block { margin: 56px 0 0; padding: 32px 0 0; border-top: 1px solid #e4e2dc; }
.srjgov-children-block h2 { font-family: 'Lora','Alike',serif; font-size: 26px; color: #1a1146; margin: 0 0 22px; }
.srjgov-children-list { list-style: none; margin: 0; padding: 0; }
.srjgov-children-list li { padding: 18px 0; border-bottom: 1px solid #efede7; margin: 0; }
.srjgov-children-list li:last-child { border-bottom: 0; }
.srjgov-children-list a {
  display: block; font-family: 'Lora','Alike',serif; font-size: 19px;
  color: #24185b; text-decoration: none; margin-bottom: 5px; transition: color .18s ease;
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
  line-height: 1.6; color: rgba(255,255,255,0.82); margin: 0 auto 24px; max-width: 620px;
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
  border-color: #ef7c00; box-shadow: 0 6px 22px rgba(20,20,40,0.08); transform: translateY(-2px);
}
.srjgov-hub-card h3 { font-family: 'Lora','Alike',serif; font-size: 20px; line-height: 1.28; margin: 0 0 8px; }
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
