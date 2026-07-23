<?php
/**
 * Plugin Name: SRJ AI Governance Schema + Quote Styles
 * Description: Emits structured data for the 49 AI Governance pages and styles
 *              the research-quote and how-to blocks.
 *
 *              SCHEMA EMITTED (JSON-LD, one graph per page):
 *                - Article, with `citation` nodes pointing at the two
 *                  peer-reviewed papers quoted on the page. This is the schema
 *                  expression of "attributed expert quotes" and it is what an
 *                  LLM or an AI search surface actually reads when deciding
 *                  whether a page is credible.
 *                - HowTo, built from the `howto` key in the config.
 *                - FAQPage, built by parsing the H3/paragraph pairs under the
 *                  page's "Frequently asked questions" heading.
 *
 *              A NOTE ON HowTo, because it matters. Google retired HowTo rich
 *              results in 2023, so this markup wins nothing in Google's SERPs.
 *              It is emitted for AI and LLM extraction, which is the actual
 *              goal. Critically, the HowTo markup describes content that is
 *              GENUINELY procedural: every governance page now carries a real
 *              numbered "how to comply" section written for that topic. We did
 *              not retrofit HowToStep markup onto explainer prose, which is
 *              schema spam and a manual-action risk. The markup describes the
 *              page honestly.
 *
 *              Rank Math remains the sole source of Organization, Place,
 *              WebSite, WebPage, and Person schema (architecture Section 11).
 *              This plugin adds Article, HowTo, and FAQPage only, on the
 *              governance pages only, and touches nothing else.
 *
 * Version: 1.1.0
 * Author: SRJ Consulting & Services LLC
 *
 * v1.1.0 (July 13, 2026): RENDERING FIX. The citation line in each research
 * quote was originally marked up with <footer>. The theme styles the bare
 * `footer` element with the navy site-footer background, so the citation
 * rendered navy-on-navy and was invisible. The config now uses
 * <div class="srjgov-cite"> instead, and this stylesheet resets background
 * and colour on it defensively. Separately, the CTA paragraph was losing a
 * specificity fight and rendering dark navy on the navy CTA panel; the CTA
 * colours are now !important. Do not reintroduce <footer> inside the quote.
 *
 * Ships alongside the ai-governance-config.php, which carries two new keys
 * per entry: `citations` (two papers, each with quote, author, journal, year,
 * url) and `howto` (name plus 5 steps).
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------------------------------------------------------------------------
 * Load the governance entry for the current page, or null.
 * ------------------------------------------------------------------------ */

function srj_gov_entry() {

    static $cache = null;
    if ( null !== $cache ) { return $cache; }

    $cache = false;

    if ( ! is_page() ) { return false; }

    $post = get_queried_object();
    if ( ! $post || empty( $post->post_name ) ) { return false; }

    $permalink = get_permalink( $post->ID );
    if ( false === strpos( $permalink, '/ai-governance/' ) ) { return false; }

    $config = get_stylesheet_directory() . '/inc/ai-governance-config.php';
    if ( ! file_exists( $config ) ) { return false; }

    $SRJ_GOVERNANCE = array();
    require $config;

    if ( isset( $SRJ_GOVERNANCE[ $post->post_name ] ) ) {
        $cache = $SRJ_GOVERNANCE[ $post->post_name ];
        $cache['_slug'] = $post->post_name;
        $cache['_url']  = $permalink;
    }

    return $cache;
}

/* ---------------------------------------------------------------------------
 * Emit the schema graph.
 * ------------------------------------------------------------------------ */

add_action( 'wp_head', 'srj_gov_emit_schema', 1 );

function srj_gov_emit_schema() {

    $e = srj_gov_entry();
    if ( ! $e ) { return; }

    $url   = $e['_url'];
    $title = isset( $e['seo_title'] ) ? $e['seo_title'] : $e['title'];
    $desc  = isset( $e['meta_description'] ) ? $e['meta_description'] : '';
    $kw    = isset( $e['focus_keyword'] ) ? $e['focus_keyword'] : '';

    $graph = array();

    /* ---- Article, with citations ------------------------------------- */
    $citations = array();
    if ( ! empty( $e['citations'] ) && is_array( $e['citations'] ) ) {
        foreach ( $e['citations'] as $c ) {
            $citations[] = array(
                '@type'           => 'ScholarlyArticle',
                'name'            => isset( $c['journal'] ) ? $c['journal'] : '',
                'author'          => array(
                    '@type' => 'Person',
                    'name'  => isset( $c['author'] ) ? $c['author'] : '',
                ),
                'datePublished'   => isset( $c['year'] ) ? $c['year'] : '',
                'url'             => isset( $c['url'] ) ? $c['url'] : '',
                'isPartOf'        => array(
                    '@type' => 'Periodical',
                    'name'  => isset( $c['journal'] ) ? $c['journal'] : '',
                ),
            );
        }
    }

    $article = array(
        '@type'            => 'Article',
        '@id'              => $url . '#article',
        'headline'         => $title,
        'description'      => $desc,
        'about'            => $kw,
        'keywords'         => $kw,
        'inLanguage'       => 'en-US',
        'mainEntityOfPage' => array( '@type' => 'WebPage', '@id' => $url ),
        'author'           => array(
            '@type' => 'Person',
            '@id'   => 'https://srjconsultingservices.com/#stephen',
            'name'  => 'Stephen R. Jordan',
        ),
        'publisher'        => array(
            '@type' => 'Organization',
            'name'  => 'SRJ Consulting & Services LLC',
            'url'   => 'https://srjconsultingservices.com/',
        ),
    );
    if ( $citations ) {
        $article['citation'] = $citations;
    }
    $graph[] = $article;

    /* ---- HowTo -------------------------------------------------------- */
    if ( ! empty( $e['howto']['steps'] ) && is_array( $e['howto']['steps'] ) ) {
        $steps = array();
        $n = 1;
        foreach ( $e['howto']['steps'] as $s ) {
            $steps[] = array(
                '@type'    => 'HowToStep',
                'position' => $n,
                'name'     => isset( $s['name'] ) ? $s['name'] : '',
                'text'     => isset( $s['text'] ) ? wp_strip_all_tags( $s['text'] ) : '',
                'url'      => $url . '#step-' . $n,
            );
            $n++;
        }
        $graph[] = array(
            '@type'       => 'HowTo',
            '@id'         => $url . '#howto',
            'name'        => isset( $e['howto']['name'] ) ? $e['howto']['name'] : ( 'How to comply with ' . $kw ),
            'description' => 'A practical sequence for bringing an organization into compliance with ' . $kw . '.',
            'step'        => $steps,
        );
    }

    /* ---- FAQPage, parsed from the body's FAQ section -------------------- */
    $faq = srj_gov_extract_faq( isset( $e['body_html'] ) ? $e['body_html'] : '' );
    if ( $faq ) {
        $graph[] = array(
            '@type'      => 'FAQPage',
            '@id'        => $url . '#faq',
            'mainEntity' => $faq,
        );
    }

    if ( ! $graph ) { return; }

    $out = array( '@context' => 'https://schema.org', '@graph' => $graph );

    echo "\n<!-- SRJ AI Governance structured data -->\n";
    echo '<script type="application/ld+json" id="srj-gov-schema">'
       . wp_json_encode( $out, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
       . "</script>\n";
}

/**
 * Pull Question/Answer pairs out of the FAQ section of a body_html block.
 * The pattern in every governance page is: an H2 whose text begins
 * "Frequently asked questions", then repeating H3 (question) + P (answer).
 */
function srj_gov_extract_faq( $body ) {

    if ( '' === $body ) { return array(); }

    $pos = false;
    if ( preg_match( '/<h2[^>]*>\s*Frequently asked questions/i', $body, $m, PREG_OFFSET_CAPTURE ) ) {
        $pos = $m[0][1];
    }
    if ( false === $pos ) { return array(); }

    $tail = substr( $body, $pos );

    // Stop at the next H2 that is not the FAQ heading itself.
    $parts = preg_split( '/<h2[^>]*>/i', $tail );
    // $parts[0] is empty, $parts[1] is the FAQ block up to the next H2.
    if ( count( $parts ) < 2 ) { return array(); }
    $block = $parts[1];

    $out = array();
    if ( preg_match_all( '/<h3[^>]*>(.*?)<\/h3>\s*<p>(.*?)<\/p>/is', $block, $mm, PREG_SET_ORDER ) ) {
        foreach ( $mm as $pair ) {
            $q = trim( wp_strip_all_tags( $pair[1] ) );
            $a = trim( wp_strip_all_tags( $pair[2] ) );
            if ( '' === $q || '' === $a ) { continue; }
            $out[] = array(
                '@type'          => 'Question',
                'name'           => $q,
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => $a,
                ),
            );
        }
    }

    return $out;
}

/* ---------------------------------------------------------------------------
 * Styles for the research-quote and how-to blocks.
 * ------------------------------------------------------------------------ */

add_action( 'wp_head', function () {
    ?>
<style id="srj-gov-quote-styles">
/* -----------------------------------------------------------------------
   Research quote block.

   NOTE: the citation line uses <div class="srjgov-cite">, NOT <footer>.
   The theme styles the bare `footer` element with the navy site-footer
   background, so a <footer> inside a blockquote rendered navy-on-navy and
   was invisible. Do not reintroduce <footer> here.

   Colours are !important because Kadence and the theme both set p/blockquote
   colour at a specificity this block would otherwise lose to.
   ----------------------------------------------------------------------- */
.srjgov-detail-body blockquote.srjgov-quote,
.srjgov-quote {
  margin: 28px 0 !important;
  padding: 24px 28px !important;
  background: #fafaf6 !important;
  border-left: 4px solid #24185b !important;
  border-radius: 0 6px 6px 0 !important;
  color: #1a1146 !important;
  box-shadow: none !important;
}
.srjgov-quote > p {
  font-family: 'Lora','Alike',serif !important;
  font-size: 19px !important;
  line-height: 1.55 !important;
  color: #1a1146 !important;
  font-style: italic !important;
  background: transparent !important;
  margin: 0 0 14px !important;
  padding: 0 !important;
}

/* Citation line. Explicitly reset anything the theme's footer rules might
   have applied, in case a selector still reaches it. */
.srjgov-quote .srjgov-cite {
  background: transparent !important;
  background-color: transparent !important;
  background-image: none !important;
  color: #6b6b78 !important;
  font-family: 'Poppins','Open Sans',sans-serif !important;
  font-size: 13.5px !important;
  line-height: 1.45 !important;
  font-style: normal !important;
  margin: 0 !important;
  padding: 0 !important;
  border: 0 !important;
  display: block !important;
  width: auto !important;
}
.srjgov-quote .srjgov-cite cite {
  font-style: normal !important;
  color: #6b6b78 !important;
  background: transparent !important;
}
.srjgov-quote .srjgov-cite a {
  color: #6b6b78 !important;
  background: transparent !important;
  text-decoration: none !important;
  border-bottom: 1px solid #e4e2dc !important;
  transition: color .18s ease, border-color .18s ease !important;
}
.srjgov-quote .srjgov-cite a:hover {
  color: #ef7c00 !important;
  border-bottom-color: #ef7c00 !important;
}
.srjgov-quote .srjgov-cite em { font-style: italic !important; }

/* -------- Numbered how-to steps -------- */
.srjgov-howto {
  counter-reset: srjstep;
  list-style: none !important;
  margin: 28px 0 !important;
  padding: 0 !important;
}
.srjgov-howto li {
  counter-increment: srjstep;
  position: relative;
  padding: 0 0 0 52px !important;
  margin: 0 0 22px !important;
  min-height: 36px;
  list-style: none !important;
}
.srjgov-howto li::marker { content: none !important; }
.srjgov-howto li::before {
  content: counter(srjstep);
  position: absolute;
  left: 0;
  top: 0;
  width: 34px;
  height: 34px;
  border-radius: 50%;
  background: #ef7c00;
  color: #ffffff;
  font-family: 'Poppins','Open Sans',sans-serif;
  font-weight: 700;
  font-size: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.srjgov-howto li strong { color: #1a1146; font-weight: 600; }

/* -------- CTA: force the light-on-navy colours -------- --------------------
   The CTA paragraph was rendering dark navy text on the navy CTA panel. The
   theme sets paragraph colour at a specificity that was beating the plain
   .srjgov-cta p rule, so these are !important.
   ----------------------------------------------------------------------- */
.srjgov-cta { background: #1a1146 !important; }
.srjgov-cta h2 { color: #ffffff !important; }
.srjgov-cta p,
.srjgov-cta p * {
  color: rgba(255,255,255,0.86) !important;
}
.srjgov-cta a.srjgov-cta-btn,
.srjgov-cta a.srjgov-cta-btn * {
  color: #ffffff !important;
  background: #ef7c00 !important;
}
.srjgov-cta a.srjgov-cta-btn:hover,
.srjgov-cta a.srjgov-cta-btn:hover * {
  color: #1a1146 !important;
  background: #ffffff !important;
}

@media (max-width: 860px) {
  .srjgov-quote { padding: 20px 22px !important; }
  .srjgov-quote > p { font-size: 17px !important; }
  .srjgov-howto li { padding-left: 44px !important; }
  .srjgov-howto li::before { width: 30px; height: 30px; font-size: 14px; }
}
</style>
    <?php
}, 1 );
