<?php
/**
 * SRJ Consulting Theme Functions
 *
 * Version 1.6.9 (Homepage hero reconcile + Cost-of-Waiting band, June 2026)
 * SRJ_VERSION advances 1.6.8 -> 1.6.9 on this ship to cache-bust home-page.css,
 * which gained the three-point grid styles for the new Cost-of-Waiting band
 * inserted in front-page.php. Per Convention #2, CSS changes require a bump.
 * The constant resync history through v1.6.8 is preserved for the record:
 * 1.6.5 -> 1.6.8 happened on the column-spacing ship to realign the constant
 * with the header version, after the constant had skipped two PHP-only entries.
 *
 * v1.1.0 (May 2026): Phase 1 — Gutenberg About page migration.
 *   1. Conditional enqueue of about-page.css on the About page.
 *   2. Conditional include of inc/block-patterns.php (file_exists guarded).
 *
 * v1.2.0 (May 18, 2026): Phase 4 — Gutenberg Home page migration with
 * pain+savings copy ($250,000 hero hook).
 *   3. Conditional enqueue of home-page.css on the static front page.
 *
 * v1.2.1 (May 18, 2026): Brand standards typography fix.
 *   4. Added Lora (editorial serif, headlines) and Poppins (operational sans,
 *      body/labels/CTAs) to the Google Fonts URL. Previous version only loaded
 *      Alike, Open Sans, and Inter, which left brand fonts unavailable.
 *
 * v1.2.2 (May 20, 2026): Beehiiv newsletter integration.
 *   5. Conditional include of inc/beehiiv-integration.php (file_exists guarded).
 *      Pushes Fluent Forms newsletter signups to Beehiiv via the Create
 *      Subscription API. Works on free Fluent Forms and free Beehiiv Launch.
 *
 * v1.3.0 (May 2026): Mobile hamburger navigation.
 *   6. srj_main_nav() in inc/helpers.php rebuilt with a hamburger toggle and
 *      slide-in mobile panel for viewports at or below 980px. The desktop nav
 *      is unchanged. SRJ_VERSION bumped to 1.3.0 so the updated style.css is
 *      cache-busted. No new enqueue: the toggle script is inline in helpers.php.
 *
 * v1.3.1 (May 24, 2026): Schema consolidation (SEO Day 9).
 *   7. srj_structured_data() retired. Rank Math PRO now outputs the full
 *      schema graph (Organization, Place, WebSite, WebPage, Person), so the
 *      theme's standalone ProfessionalService block was a conflicting,
 *      stale-NAP duplicate. Function preserved, commented out. No CSS/JS
 *      change, so SRJ_VERSION was intentionally NOT bumped.
 *
 * v1.3.2 (May 25, 2026): Newsletter Welcome page (deliverability fix).
 *   8. Conditional enqueue of welcome-page.css on the Welcome page (slug
 *      "welcome"), which uses the page-welcome.php "Newsletter Welcome"
 *      template. The CSS was extracted from that template's former inline
 *      <style> block so page-specific styles live in a stylesheet
 *      (Convention #6). SRJ_VERSION bumped 1.3.0 -> 1.3.2 to cache-bust the
 *      new stylesheet; the constant skips 1.3.1 because that schema-only
 *      change deliberately did not bump it.
 *
 * v1.4.0 (May 2026): Industries section build.
 *   9. New config-driven template page-industry-detail.php serves the ten
 *      industry detail pages under /industries/, and page-industries.php was
 *      rewritten as the section hub. assets/css/style.css gained the industry
 *      hub-card and detail-page rules, so SRJ_VERSION is bumped to 1.4.0 to
 *      cache-bust the stylesheet. srj_create_default_pages() registers the ten
 *      Industries detail pages under the Industries parent with the "Industry
 *      Detail" template; $current_version bumped 4 -> 5.
 *      NOTE: this header was found documenting only through v1.3.2 with
 *      SRJ_VERSION still at 1.3.2, even though $current_version was already 4
 *      (the v1.6 Services work). No header entry or version bump had been
 *      recorded for the Books, Services, or contact-form revisions; the bump
 *      here from 1.3.2 also cache-busts any earlier un-busted style.css change.
 *
 * v1.4.1 (May 2026): Microsoft Clarity analytics added.
 *  10. New constant SRJ_CLARITY_PROJECT_ID near the top of this file holds
 *      the Clarity project ID (wxtqd3ud7i), so it can be rotated without
 *      touching the function body. New function srj_clarity_tracking() hooked
 *      to wp_head at priority 5 emits the standard Clarity async loader on
 *      every front-end page. Cookie consent for the script is gated by
 *      Complianz, which classifies Clarity under the "Statistics" category.
 *      SRJ_VERSION is NOT bumped because Clarity is an inline head injection,
 *      not an enqueued CSS or JS asset, so Convention #2 does not apply.
 *
 * v1.5.1 (May 2026): Industries section visual redesign (CSS only).
 *  11. assets/css/style.css industry rules rebuilt: the hub now uses discrete
 *      cards with an orange top-accent and hover lift instead of a bordered
 *      grid; industry detail pages gained numbered section eyebrows (01/02/03)
 *      and the six service lines render as a two-column card matrix. No template
 *      or markup changes, the redesign lives entirely in style.css. SRJ_VERSION
 *      is bumped 1.5.0 -> 1.5.1 to cache-bust the stylesheet (Convention #2).
 *
 * v1.5.2 (May 2026): Home Insights section restyle (CSS only).
 *  12. assets/css/style.css gained a consolidated "Home Insights section"
 *      block, moved out of Customizer Additional CSS so the stylesheet is the
 *      single source. It sets the home background white (body.home), renders
 *      the latest-posts titles in Lora navy 22px with an orange hover, sets the
 *      post dates in uppercase letter-spaced Poppins orange, adds a divider
 *      between posts, and adds a centered "Recent Insights" header above the
 *      list via a ::before on .srj-latest-insights. No template or markup
 *      changes, the restyle lives entirely in style.css. SRJ_VERSION is bumped
 *      1.5.1 -> 1.5.2 to cache-bust the stylesheet (Convention #2).
 *
 * v1.6.0 (May 2026): Blog post brand styling.
 *  13. New conditional stylesheet assets/css/blog-post.css, enqueued only
 *      on single posts by srj_enqueue_blog_post_styles() (is_singular('post')).
 *      It brings published and future Gutenberg blog posts onto the brand —
 *      Lora headlines in navy, Poppins body, orange accents, white page —
 *      scoped to the page-hero--post and longform--post modifier classes
 *      added to single.php, so no other template is affected. Exact brand
 *      hexes are used in the stylesheet rather than the drifted :root tokens.
 *      SRJ_VERSION bumped 1.5.2 -> 1.6.0 to cache-bust the new stylesheet
 *      (Convention #2).
 *
 * v1.6.1 (June 2026): Homepage pain-framework build (Path A).
 *  14. front-page.php rewritten with pain-forward hero copy, a new Four
 *      Questions block, an Executive Note callout, and a navy Cost-of-Waiting
 *      band carrying one sourced footnote (IBM Cost of a Data Breach Report
 *      2025). New sitewide srj_exec_note() helper in inc/helpers.php, styled by
 *      .srj-exec-note in assets/css/style.css; Home-scoped section styles added
 *      to assets/css/home-page.css. Stale srj_get_calendly()/$calendly usage in
 *      front-page.php migrated to srj_get_booking(). SRJ_VERSION bumped
 *      1.6.0 -> 1.6.1 to cache-bust style.css and home-page.css (Convention #2).
 *
 * v1.6.2 (June 2026): Homepage rebuilt from the canonical $670,000 copy held in
 *      the Notion "Homepage - Canonical Copy" master, rendered in the existing
 *      theme components. Sections: hero, four pain points, framework (two
 *      pillars), why operator-led, Highlights blog feed (latest 3 posts), final
 *      CTA, newsletter. Home-scoped styles extended in home-page.css.
 *
 * v1.6.3 (June 2026): Homepage brand-standard styling pass (copy unchanged).
 *  15. home-page.css now pins the official Brand Standard tokens (Navy #201868,
 *      Orange #F07800) in a homepage-scoped :root override. The file is enqueued
 *      only on the front page and after style.css, so the homepage renders the
 *      true brand navy/orange while the global legacy tokens (#24185b/#ef7c00)
 *      are left untouched for the separate sitewide reconciliation pass. The
 *      hero support line moved from washed --muted to --ink-soft for a more
 *      confident read. SRJ_VERSION bumped 1.6.2 -> 1.6.3 to cache-bust
 *      home-page.css (Convention #2). No markup or copy changes.
 *
 * v1.6.4 (June 2026): Hero spacing/size tweak (copy unchanged). Hero support
 *      line bumped 15px -> 16.5px for readability, and a 32px top margin added
 *      to .hero .hero-actions so the CTA buttons sit clear of the support line.
 *      Homepage-scoped in home-page.css. SRJ_VERSION 1.6.3 -> 1.6.4 to
 *      cache-bust. No markup or copy changes.
 *
 * v1.6.5 (June 2026): Highlights feed heading renamed to "Insights" and set
 *      italic (it was already brand orange). Text change in front-page.php,
 *      font-style:italic added to .home-highlights-title in home-page.css.
 *      SRJ_VERSION 1.6.4 -> 1.6.5 to cache-bust.
 *
 * v1.6.6 (June 2026): Author-identity unification (AI Visibility, GEO).
 *  16. Conditional include of inc/rank-math-schema.php (file_exists guarded).
 *      It hooks rank_math/json_ld to collapse Stephen R. Jordan's three Person
 *      nodes (About #schema-NNN, Organization founder #stephen, post author
 *      /author/...) onto the single canonical #stephen entity carrying the
 *      LinkedIn sameAs and "Founder & Principal Advisor" title, and points the
 *      Article author reference at that same id. Reshapes Rank Math's own
 *      output only; Rank Math stays the sole source of entity schema. No CSS/JS
 *      change, so SRJ_VERSION is intentionally NOT bumped (Convention #2).
 *
 * v1.6.7 (June 2026): Rank Math schema normalization (Ahrefs validation fix).
 *  17. inc/rank-math-schema.php gained a second filter at priority 100 that
 *      runs site-wide and cleans up four classes of strict-validator failures
 *      in Rank Math's own output: openingHours rewritten from long-form day
 *      names ("Monday,Tuesday,...") to schema.org 2-letter codes with range
 *      collapsing ("Mo-Fr"); whitespace trimmed from geo.latitude /
 *      geo.longitude; addressCountry "United States" rewritten to ISO "US"
 *      everywhere; ImageObject width / height coerced from numeric strings to
 *      ints. Reshapes Rank Math's own graph only; no new entity schema is
 *      introduced. functions.php itself is unchanged in v1.6.7 (the
 *      require_once for inc/rank-math-schema.php was already installed in
 *      v1.6.6); the header entry is recorded here to keep the running theme
 *      changelog continuous. No CSS/JS change, so SRJ_VERSION is
 *      intentionally NOT bumped (Convention #2).
 *
 * v1.6.8 (June 8, 2026): Gutenberg-column paragraph spacing fix.
 *  18. assets/css/style.css gained a single sibling-paragraph rule for content
 *      inside Gutenberg columns: .wp-block-column p + p { margin-top: 1em }.
 *      The theme's column styling was suppressing the default paragraph margin
 *      between consecutive <p> tags inside .wp-block-column, which collapsed
 *      the visible gap between the About page bio paragraphs after v1.24's
 *      pedigree-framing rewrite. The rule uses the adjacent-sibling selector
 *      so it only affects spacing between consecutive paragraphs and does not
 *      push the first paragraph away from the column's top edge. SRJ_VERSION
 *      bumped 1.6.5 -> 1.6.8 to cache-bust the stylesheet (Convention #2); the
 *      constant resyncs with the header version (see header note above). No
 *      template, markup, or content changes.
 *
 * v1.6.9 (June 8, 2026): Homepage hero reconcile + Cost-of-Waiting band.
 *  19. front-page.php and home-page.css both updated; two coordinated changes
 *      against the same canonical $670,000 dollar anchor. (1) Hero copy
 *      reconciled to Option C per Stephen's June 8 approval. The H1 keeps the
 *      $670,000 anchor but reframes it from "what your AI tools are costing
 *      you" (a waste claim, which conflated waste with breach) to "what
 *      unmanaged AI exposure is costing you" (an exposure claim). The lead
 *      paragraph attributes the $250K lower bound to recoverable waste
 *      (duplicated subscriptions + productivity drag) and attributes the $670K
 *      upper bound to IBM's 2025 Cost of a Data Breach Report finding on the
 *      shadow-AI breach premium. The hero carries a numbered superscript
 *      anchor that jumps down to the citation in the Cost-of-Waiting band.
 *      (2) New Cost-of-Waiting band inserted between the Four Pain Points and
 *      the Framework sections. Three points (subscription waste compounds,
 *      exposure compounds faster, the breach is no longer hypothetical), then
 *      a footnote carrying the verbatim IBM attribution: organizations with
 *      high levels of shadow AI experienced average breach costs of $4.74M
 *      versus $4.07M for organizations with low/no shadow AI ($670K delta).
 *      The band reuses the existing .home-cost shell (navy band, eyebrow, h2,
 *      foot) that was carried in home-page.css from the retired v1.6.1 build;
 *      new CSS in home-page.css adds .home-cost-grid (three columns desktop,
 *      stacked mobile), .home-cost-point title/body, an orange-accented
 *      separator above the footnote, and a small .hero-footnote-link rule for
 *      the in-hero superscript. SRJ_VERSION bumped 1.6.8 -> 1.6.9 to
 *      cache-bust home-page.css (Convention #2).
 *
 * Search for "PHASE 1", "PHASE 4", "v1.2.2", "v1.3.1", "v1.3.2", "v1.4.0",
 * "v1.4.1", "v1.5.1", "v1.5.2", "v1.6.0", "v1.6.1", "v1.6.3", "v1.6.6", "v1.6.7", "v1.6.8", or "v1.6.9" in this file to find the additions.
 *
 * @package SRJ_Consulting
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'SRJ_VERSION', '1.6.9' );
define( 'SRJ_PATH', get_stylesheet_directory() );
define( 'SRJ_URI', get_stylesheet_directory_uri() );
define( 'SRJ_CLARITY_PROJECT_ID', 'wxtqd3ud7i' );

/**
 * Enqueue parent + child theme styles and theme scripts.
 */
function srj_enqueue_assets() {
    // Google Fonts — now includes Lora and Poppins (brand standards typography).
    wp_enqueue_style(
        'srj-google-fonts',
        'https://fonts.googleapis.com/css2?family=Alike&family=Open+Sans:wght@300;400;500;600;700&family=Inter:wght@400;500;600&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=Poppins:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );

    // Parent (Kadence) stylesheet
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        SRJ_VERSION
    );

    // Our custom theme stylesheet
    wp_enqueue_style(
        'srj-style',
        SRJ_URI . '/assets/css/style.css',
        array( 'parent-style' ),
        SRJ_VERSION
    );

    // Our custom theme script (floating CTA behavior)
    wp_enqueue_script(
        'srj-theme',
        SRJ_URI . '/assets/js/theme.js',
        array(),
        SRJ_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'srj_enqueue_assets' );

/**
 * PHASE 1 ADDITION: Enqueue About-page-specific CSS only on the About page.
 *
 * Targets the Gutenberg-rendered About page introduced in Phase 1.
 * Does not load on any other page.
 */
function srj_enqueue_about_page_styles() {
    if ( is_page( 'about' ) ) {
        wp_enqueue_style(
            'srj-about-page',
            SRJ_URI . '/assets/css/about-page.css',
            array( 'srj-style' ),
            SRJ_VERSION
        );
    }
}
add_action( 'wp_enqueue_scripts', 'srj_enqueue_about_page_styles', 20 );

/**
 * PHASE 4 ADDITION: Enqueue Home-page-specific CSS only on the homepage.
 *
 * Targets the Gutenberg-rendered Home page introduced in Phase 4 with the
 * pain+savings copy ($250,000 hero hook). Uses is_front_page() to target
 * the static homepage set in Settings > Reading.
 */
function srj_enqueue_home_page_styles() {
    if ( is_front_page() ) {
        wp_enqueue_style(
            'srj-home-page',
            SRJ_URI . '/assets/css/home-page.css',
            array( 'srj-style' ),
            SRJ_VERSION
        );
    }
}
add_action( 'wp_enqueue_scripts', 'srj_enqueue_home_page_styles', 20 );

/**
 * v1.3.2 ADDITION: Enqueue Welcome-page-specific CSS only on the Welcome page.
 *
 * Targets the page with slug "welcome", which uses the page-welcome.php
 * "Newsletter Welcome" template (the post-signup landing page for the
 * newsletter deliverability fix). The CSS was extracted from that template's
 * former inline <style> block so page-specific styles live in a stylesheet
 * (Convention #6). Does not load on any other page.
 */
function srj_enqueue_welcome_page_styles() {
    if ( is_page( 'welcome' ) ) {
        wp_enqueue_style(
            'srj-welcome-page',
            SRJ_URI . '/assets/css/welcome-page.css',
            array( 'srj-style' ),
            SRJ_VERSION
        );
    }
}
add_action( 'wp_enqueue_scripts', 'srj_enqueue_welcome_page_styles', 20 );

/**
 * v1.5.0 ADDITION: Enqueue Contact-page CSS only on the Contact page.
 *
 * Targets the page with slug "contact" (page-contact.php). Hosts the new
 * QR-code + calendar-button block added in v1.5.0, plus any future
 * contact-page-specific styles. Keeps page-specific rules out of the
 * site-wide style.css. Does not load on any other page.
 */
function srj_enqueue_contact_page_styles() {
    if ( is_page( 'contact' ) ) {
        wp_enqueue_style(
            'srj-contact-page',
            SRJ_URI . '/assets/css/contact-page.css',
            array( 'srj-style' ),
            SRJ_VERSION
        );
    }
}
add_action( 'wp_enqueue_scripts', 'srj_enqueue_contact_page_styles', 20 );

/**
 * v1.5.0 ADDITION: Enqueue booking-page CSS only on the Schedule Consultation page.
 *
 * Targets the page with slug "schedule-consultation", which uses
 * page-schedule-consultation.php and hosts the Zoom Scheduler embed. The CSS
 * lives in its own stylesheet so the iframe wrapper, responsive sizing, and
 * supporting layout stay isolated from site-wide style.css. Does not load on
 * any other page.
 */
function srj_enqueue_schedule_consultation_styles() {
    if ( is_page( 'schedule-consultation' ) ) {
        wp_enqueue_style(
            'srj-schedule-consultation',
            SRJ_URI . '/assets/css/schedule-consultation.css',
            array( 'srj-style' ),
            SRJ_VERSION
        );
    }
}
add_action( 'wp_enqueue_scripts', 'srj_enqueue_schedule_consultation_styles', 20 );

/**
 * v1.6.0 ADDITION: Enqueue blog-post CSS only on single posts.
 *
 * Targets single blog posts (the Insights archive entries), which render
 * through single.php. The stylesheet brings posts onto the brand (Lora
 * headlines in navy, Poppins body, orange accents, white page) and is scoped
 * to the page-hero--post and longform--post modifier classes on single.php,
 * so it cannot affect any other template. is_singular('post') loads it on
 * posts only, not on pages or archives. Does not load on any other page.
 */
function srj_enqueue_blog_post_styles() {
    if ( is_singular( 'post' ) ) {
        wp_enqueue_style(
            'srj-blog-post',
            SRJ_URI . '/assets/css/blog-post.css',
            array( 'srj-style' ),
            SRJ_VERSION
        );
    }
}
add_action( 'wp_enqueue_scripts', 'srj_enqueue_blog_post_styles', 20 );

/**
 * Theme setup: support, menus, image sizes.
 */
function srj_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'responsive-embeds' );

    register_nav_menus( array(
        'primary' => __( 'Primary Navigation', 'srj-consulting' ),
        'footer'  => __( 'Footer Navigation', 'srj-consulting' ),
    ) );
}
add_action( 'after_setup_theme', 'srj_theme_setup' );

/**
 * Disable Kadence header/footer overrides on our custom templates.
 * Our templates render their own header and footer markup.
 */
function srj_remove_parent_header_footer() {
    // We control the entire layout. Keep this minimal hook for future use.
}
add_action( 'init', 'srj_remove_parent_header_footer' );

/**
 * Include modular theme files.
 */
require_once SRJ_PATH . '/inc/customizer.php';
require_once SRJ_PATH . '/inc/helpers.php';
require_once SRJ_PATH . '/inc/service-helpers.php';
require_once SRJ_PATH . '/inc/security.php';

/**
 * PHASE 1 ADDITION: Load the Gutenberg block patterns registration.
 *
 * Registers reusable patterns for the SRJ brand (Section Hero, Content Section,
 * Person Block, CTA Section). Available in the block inserter under
 * the "SRJ Consulting" category.
 *
 * Guarded with file_exists() so the theme does not crash if the patterns file
 * has not yet been uploaded.
 */
if ( file_exists( SRJ_PATH . '/inc/block-patterns.php' ) ) {
    require_once SRJ_PATH . '/inc/block-patterns.php';
}

/**
 * v1.2.2 ADDITION: Load the Beehiiv newsletter integration for Fluent Forms.
 *
 * Hooks into the Fluent Forms submission_inserted event and pushes new
 * subscribers to the Beehiiv API. Targets the newsletter signup form
 * (form ID configured inside beehiiv-integration.php).
 *
 * Guarded with file_exists() so the theme does not crash if the integration
 * file has not yet been uploaded.
 */
if ( file_exists( SRJ_PATH . '/inc/beehiiv-integration.php' ) ) {
    require_once SRJ_PATH . '/inc/beehiiv-integration.php';
}

/**
 * v1.6.6 ADDITION: Load the Rank Math author-identity unification filter.
 *
 * Hooks rank_math/json_ld to collapse Stephen R. Jordan's three separate
 * Person nodes (About page, Organization founder, post author) onto the single
 * canonical #stephen entity carrying the LinkedIn sameAs, so search engines and
 * AI assistants read one consistent author identity site-wide. It only reshapes
 * Rank Math's own output; Rank Math remains the sole source of entity schema.
 *
 * Guarded with file_exists() so the theme does not crash if the integration
 * file has not yet been uploaded.
 */
if ( file_exists( SRJ_PATH . '/inc/rank-math-schema.php' ) ) {
    require_once SRJ_PATH . '/inc/rank-math-schema.php';
}

/**
 * Set Insights as the default posts page on theme activation.
 * Also create core pages if they don't exist.
 */
function srj_create_default_pages() {
    // Version-based check: bump $current_version when adding new pages so theme re-activation
    // creates only the new ones (existing pages are preserved via get_page_by_path check below).
    //
    // v3 (May 2026): Books section restructured into a pillar / book-page
    // hierarchy. Adds the /books/ landing page, two pillar pages, and six
    // book detail pages, each with its page template assigned. As of v3 the
    // routine actually applies the 'template' key (earlier versions ignored it).
    //
    // v4 (May 2026): Services section restructured to mirror Books. Two
    // services pillar pages (slugs business-services, risk-governance-security)
    // sit under Services; the six existing service-detail pages were
    // re-parented from `services` to the appropriate pillar. NOTE: re-parenting
    // changes the URL of pages that already exist — for an existing site this
    // routine does NOT move them (it only creates pages that are absent). The
    // re-parenting was done by hand in WordPress and the six service URLs
    // changed from /services/{slug}/ to /services/{pillar}/{slug}/, with 301
    // redirects added. This config records the intended final structure.
    //
    // v5 (May 2026): Industries section restructured into a hub / detail-page
    // hierarchy. The Industries landing page becomes a hub; ten industry
    // detail pages sit beneath it, each using page-industry-detail.php (the
    // "Industry Detail" named template, set via _wp_page_template meta below).
    // As with Books and Services, the ten pages were also created by hand for
    // the live site; this routine records the intended structure and recreates
    // it correctly on a future theme re-activation.
    // v6 (May 2026): Booking system moved from Calendly to Zoom Scheduler.
    // A new on-domain page, /schedule-consultation/, hosts the Zoom Scheduler
    // iframe so every site CTA can keep visitors on srjconsultingservices.com
    // rather than handing them off to a third-party booking page. Uses
    // page-schedule-consultation.php (Type-1, slug-matched).
    $current_version = 6;
    $stored_version = (int) get_option( 'srj_pages_version', 0 );

    // Migrate from old flag if present
    if ( get_option( 'srj_pages_created' ) && $stored_version === 0 ) {
        $stored_version = 1;
        update_option( 'srj_pages_version', 1 );
        delete_option( 'srj_pages_created' );
    }

    if ( $stored_version >= $current_version ) {
        return;
    }

    $pages = array(
        array( 'title' => 'Home', 'slug' => 'home', 'template' => '' ),
        array( 'title' => 'About', 'slug' => 'about', 'template' => '' ),
        array( 'title' => 'Services', 'slug' => 'services', 'template' => '' ),

        /* ---- Services section (v4) — pillar / service-page hierarchy ----
         * Two pillar pages sit under Services; the six service-detail pages
         * are children of a pillar. The service pages keep their existing
         * page-{slug}.php templates (WordPress matches those by slug
         * regardless of parent). Resulting URLs:
         *   /services/business-services/
         *   /services/business-services/ai-business-enablement-audit/  ...etc
         */
        array( 'title' => 'AI Business Services', 'slug' => 'business-services', 'template' => 'page-services-pillar.php', 'parent' => 'services' ),
        array( 'title' => 'AI Business Enablement Audit', 'slug' => 'ai-business-enablement-audit', 'template' => '', 'parent' => 'business-services' ),
        array( 'title' => 'AI Readiness & Performance Assessment', 'slug' => 'ai-readiness-performance', 'template' => '', 'parent' => 'business-services' ),
        array( 'title' => 'AI Risk & Governance Review', 'slug' => 'ai-risk-governance-review', 'template' => '', 'parent' => 'business-services' ),
        array( 'title' => 'AI Efficiency & Process Optimization', 'slug' => 'ai-efficiency-process', 'template' => '', 'parent' => 'business-services' ),

        array( 'title' => 'AI Risk Governance & Security', 'slug' => 'risk-governance-security', 'template' => 'page-services-pillar.php', 'parent' => 'services' ),
        array( 'title' => 'AI IT Security Audit', 'slug' => 'ai-it-security-audit', 'template' => '', 'parent' => 'risk-governance-security' ),
        array( 'title' => 'AI Security Implementation', 'slug' => 'ai-security-implementation', 'template' => '', 'parent' => 'risk-governance-security' ),
        array( 'title' => 'Industries', 'slug' => 'industries', 'template' => '' ),
        array( 'title' => 'Insights', 'slug' => 'insights', 'template' => '' ),
        array( 'title' => 'FAQ', 'slug' => 'faq', 'template' => '' ),
        array( 'title' => 'Contact', 'slug' => 'contact', 'template' => '' ),
        array( 'title' => 'Schedule a Consultation', 'slug' => 'schedule-consultation', 'template' => '' ),
        array( 'title' => 'Privacy Policy', 'slug' => 'privacy', 'template' => '' ),
        array( 'title' => 'Terms of Use', 'slug' => 'terms', 'template' => '' ),

        /* ---- Books section (v3) — pillar / book-page hierarchy ----
         * The 'template' value is the page-template filename and is applied
         * via the _wp_page_template meta below. The 'parent' value is the
         * slug of the parent page; it is resolved against pages created in
         * this run AND pages that already exist, so ordering is forgiving.
         * Resulting URLs:
         *   /books/
         *   /books/ai-business-services/
         *   /books/ai-business-services/ai-business-enablement-audit/   ...etc
         */
        array( 'title' => 'Books', 'slug' => 'books', 'template' => 'page-books.php' ),

        // Pillar I
        array( 'title' => 'AI Business Services', 'slug' => 'ai-business-services', 'template' => 'page-pillar.php', 'parent' => 'books' ),
        array( 'title' => 'The AI Business Enablement Audit', 'slug' => 'the-ai-business-enablement-audit', 'template' => 'page-book-detail.php', 'parent' => 'ai-business-services' ),
        array( 'title' => 'The AI Readiness & Performance Assessment', 'slug' => 'the-ai-readiness-performance-assessment', 'template' => 'page-book-detail.php', 'parent' => 'ai-business-services' ),
        array( 'title' => 'The AI Risk & Governance Review', 'slug' => 'the-ai-risk-governance-review', 'template' => 'page-book-detail.php', 'parent' => 'ai-business-services' ),
        array( 'title' => 'The AI Efficiency & Process Optimization', 'slug' => 'the-ai-efficiency-process-optimization', 'template' => 'page-book-detail.php', 'parent' => 'ai-business-services' ),

        // Pillar II
        array( 'title' => 'AI Risk Governance & Security', 'slug' => 'ai-risk-governance-security', 'template' => 'page-pillar.php', 'parent' => 'books' ),
        array( 'title' => 'The AI IT Security Audit', 'slug' => 'the-ai-it-security-audit', 'template' => 'page-book-detail.php', 'parent' => 'ai-risk-governance-security' ),
        array( 'title' => 'The AI IT Security Implementation & Strategy', 'slug' => 'the-ai-it-security-implementation-strategy', 'template' => 'page-book-detail.php', 'parent' => 'ai-risk-governance-security' ),

        /* ---- Industries section (v5) — hub / detail-page hierarchy ----
         * The Industries landing page (created above) becomes a hub; ten
         * industry detail pages sit beneath it, each served by the
         * config-driven page-industry-detail.php "Industry Detail" template.
         * That is a named template, so it is set via _wp_page_template meta
         * below. Resulting URLs:
         *   /industries/
         *   /industries/aerospace-defense/   ...etc
         */
        array( 'title' => 'Aerospace & Defense', 'slug' => 'aerospace-defense', 'template' => 'page-industry-detail.php', 'parent' => 'industries' ),
        array( 'title' => 'Technology & Software', 'slug' => 'technology-software', 'template' => 'page-industry-detail.php', 'parent' => 'industries' ),
        array( 'title' => 'Agriculture', 'slug' => 'agriculture', 'template' => 'page-industry-detail.php', 'parent' => 'industries' ),
        array( 'title' => 'Healthcare & Life Sciences', 'slug' => 'healthcare-life-sciences', 'template' => 'page-industry-detail.php', 'parent' => 'industries' ),
        array( 'title' => 'Media & Telecom', 'slug' => 'media-telecom', 'template' => 'page-industry-detail.php', 'parent' => 'industries' ),
        array( 'title' => 'Manufacturing', 'slug' => 'manufacturing', 'template' => 'page-industry-detail.php', 'parent' => 'industries' ),
        array( 'title' => 'Retail & E-Commerce', 'slug' => 'retail-ecommerce', 'template' => 'page-industry-detail.php', 'parent' => 'industries' ),
        array( 'title' => 'Insurance', 'slug' => 'insurance', 'template' => 'page-industry-detail.php', 'parent' => 'industries' ),
        array( 'title' => 'Financial Services & Banking', 'slug' => 'financial-services', 'template' => 'page-industry-detail.php', 'parent' => 'industries' ),
        array( 'title' => 'Legal Services', 'slug' => 'legal-services', 'template' => 'page-industry-detail.php', 'parent' => 'industries' ),
    );

    $created = array();

    foreach ( $pages as $page ) {
        if ( get_page_by_path( $page['slug'] ) ) {
            continue;
        }

        // Resolve the parent: first a page created earlier in this run,
        // then fall back to an already-existing page with that slug. This
        // lets child pages nest correctly even when the parent predates
        // this routine (e.g. a "Books" page that already exists).
        $parent_id = 0;
        if ( ! empty( $page['parent'] ) ) {
            if ( isset( $created[ $page['parent'] ] ) ) {
                $parent_id = $created[ $page['parent'] ];
            } else {
                $existing_parent = get_page_by_path( $page['parent'] );
                if ( $existing_parent ) {
                    $parent_id = $existing_parent->ID;
                }
            }
        }

        $page_id = wp_insert_post( array(
            'post_title'   => $page['title'],
            'post_name'    => $page['slug'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_author'  => 1,
            'post_parent'  => $parent_id,
            'post_content' => '',
        ) );

        if ( $page_id && ! is_wp_error( $page_id ) ) {
            $created[ $page['slug'] ] = $page_id;

            // Apply the page template, if one is specified. Earlier versions
            // of this routine carried a 'template' key but never used it;
            // named templates (page-books.php, page-pillar.php,
            // page-book-detail.php) do not match a page slug, so the
            // template must be set explicitly via _wp_page_template meta.
            if ( ! empty( $page['template'] ) ) {
                update_post_meta( $page_id, '_wp_page_template', $page['template'] );
            }
        }
    }

    // Set Home as front page, Insights as posts page
    if ( isset( $created['home'] ) ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $created['home'] );
    }
    if ( isset( $created['insights'] ) ) {
        update_option( 'page_for_posts', $created['insights'] );
    }

    // Set permalink structure to /%postname%/
    if ( get_option( 'permalink_structure' ) === '' ) {
        update_option( 'permalink_structure', '/%postname%/' );
    }

    update_option( 'srj_pages_version', $current_version );
}
add_action( 'after_switch_theme', 'srj_create_default_pages' );

/**
 * Remove default WordPress emoji scripts (cleaner head).
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * v1.4.1 ADDITION: Microsoft Clarity analytics (heatmaps + session recordings).
 *
 * Loads the Clarity tag asynchronously into <head> on every front-end page.
 * Cookie consent is gated by Complianz, which classifies Clarity under the
 * "Statistics" cookie category. Project ID lives in SRJ_CLARITY_PROJECT_ID
 * near the top of this file, so the ID can be rotated without touching the
 * function body. Returns early if the constant is empty or undefined, so the
 * site keeps rendering cleanly even if the constant is removed.
 *
 * Hooked at priority 5 so Clarity loads early in <head>, before most other
 * wp_head injections, which gives more accurate page-view capture.
 */
function srj_clarity_tracking() {
    if ( ! defined( 'SRJ_CLARITY_PROJECT_ID' ) || empty( SRJ_CLARITY_PROJECT_ID ) ) {
        return;
    }
    ?>
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "<?php echo esc_js( SRJ_CLARITY_PROJECT_ID ); ?>");
    </script>
    <?php
}
add_action( 'wp_head', 'srj_clarity_tracking', 5 );

/**
 * Open Graph and Twitter meta tags.
 *
 * DISABLED May 2026: Rank Math SEO now outputs all Open Graph, Twitter,
 * and meta description tags. Running this function alongside Rank Math
 * produced duplicate og:description and twitter:description tags
 * (flagged by site audit). Rank Math is the single source of meta tags.
 * Function retained, commented out, in case Rank Math is ever removed.
 */
/*
function srj_meta_tags() {
    if ( is_singular() ) {
        global $post;
        $title = get_the_title();
        $description = wp_strip_all_tags( get_the_excerpt() );
        if ( empty( $description ) ) {
            $description = 'Operator-led AI advisory for executives accountable for AI outcomes.';
        }
        $url = get_permalink();

        echo '<meta property="og:type" content="article" />' . "\n";
        echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr( $description ) . '" />' . "\n";
        echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
        echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '" />' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '" />' . "\n";
    }
}
add_action( 'wp_head', 'srj_meta_tags' );
*/

/**
 * Organization / ProfessionalService JSON-LD structured data.
 *
 * DISABLED May 24, 2026 (v1.3.1, SEO Day 9): Rank Math PRO now outputs the
 * full schema graph — Organization, Place, WebSite, WebPage, and Person —
 * connected by @id reference. Running this function alongside Rank Math
 * produced a second, standalone ProfessionalService entity on the homepage
 * that did not reference Rank Math's Organization node and carried a stale
 * NAP (street "Ln" vs "Lane", no postal code, phone in a different format).
 * Rank Math is the single source of schema. The only schema still generated
 * by the theme is the BreadcrumbList JSON-LD in srj_breadcrumbs().
 * Function retained, commented out, in case Rank Math is ever removed.
 */
/*
function srj_structured_data() {
    if ( ! is_front_page() ) {
        return;
    }
    $data = array(
        '@context' => 'https://schema.org',
        '@type'    => 'ProfessionalService',
        'name'     => 'SRJ Consulting & Services LLC',
        'description' => 'Operator-led AI advisory for executives accountable for AI outcomes.',
        'url'      => home_url(),
        'telephone' => srj_get_phone(),
        'email'    => srj_get_email(),
        'address'  => array(
            '@type' => 'PostalAddress',
            'streetAddress' => '13054 Cinderella Ln',
            'addressLocality' => 'Frisco',
            'addressRegion' => 'TX',
            'addressCountry' => 'US',
        ),
        'founder'  => array(
            '@type' => 'Person',
            'name'  => 'Stephen R. Jordan',
            'jobTitle' => 'Founder & Principal Advisor',
        ),
        'areaServed' => 'United States',
    );
    echo '<script type="application/ld+json">' . wp_json_encode( $data ) . '</script>' . "\n";
}
add_action( 'wp_head', 'srj_structured_data' );
*/

/**
 * Excerpt length for insights cards.
 */
function srj_excerpt_length( $length ) {
    return 32;
}
add_filter( 'excerpt_length', 'srj_excerpt_length' );

function srj_excerpt_more( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'srj_excerpt_more' );
