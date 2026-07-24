<?php
/**
 * Template Name: Resources
 *
 * Renders /resources/ as the single entry point to everything SRJ
 * publishes free: the AI Governance Reference Library, the AI Tools
 * catalog, the Sources & References bibliography, the AI Audit,
 * Insights, the newsletter, and the press kit.
 *
 * v1.71 (July 20, 2026): Initial build. Resources replaces AI Governance
 * and Insights in the primary nav, which drops the nav from nine items
 * to eight. NOTHING MOVES: every destination keeps its existing URL.
 * /ai-governance/ and its 61 pages, /insights/, /newsletter/, and
 * /press/ are all unchanged, so no redirects are needed and no
 * indexed URL is disturbed. This page groups; it does not rehome.
 *
 * v1.72 (July 20, 2026): AI Glossary card added to the Free tools
 * column, third position, between the AI Tools Catalog and Sources.
 * The glossary is a new page at /resources/ai-glossary/, rendered from
 * the wp_srj_glossary table by page-ai-glossary.php.
 *
 * v1.83 (July 24, 2026): Stale counts fixed and made self-maintaining.
 * The governance page count, tools count, and glossary term/category
 * counts are now queried live from the srj_governance, srj_ai_tools,
 * and srj_glossary tables, with the July 24 numbers (63 / 320 / 500 in
 * 12 categories) as static fallbacks if a table is empty or missing.
 * This page can no longer drift when the libraries grow.
 *
 * Styling follows the page-ai-governance.php pattern (inline <style>
 * scoped to srjres-* classes). Migrates to assets/css/ on the next
 * consolidation pass, same as the governance hub.
 */
$GLOBALS['srj_current_nav'] = 'resources';
get_header();

$srj_res_audit_url = 'https://aiauditforcompanies.com/startaiaudit/';

// Live counts with static fallbacks (v1.83). Suppressed errors: a missing
// table returns null and the fallback number is used.
global $wpdb;
$srj_res_gov_count   = (int) @$wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}srj_governance WHERE is_published = 1" );
$srj_res_tools_count = (int) @$wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}srj_ai_tools WHERE is_published = 1" );
$srj_res_gl_count    = (int) @$wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}srj_glossary WHERE is_published = 1" );
$srj_res_gl_cats     = (int) @$wpdb->get_var( "SELECT COUNT(DISTINCT category) FROM {$wpdb->prefix}srj_glossary WHERE is_published = 1" );
if ( $srj_res_gov_count < 1 )   { $srj_res_gov_count = 63; }
if ( $srj_res_tools_count < 1 ) { $srj_res_tools_count = 320; }
if ( $srj_res_gl_count < 1 )    { $srj_res_gl_count = 500; }
if ( $srj_res_gl_cats < 1 )     { $srj_res_gl_cats = 12; }
?>

<?php srj_page_hero( 'Resources', 'Reference Material' ); ?>

<style>
.srjres-lead { max-width: 760px; margin: 0 auto 44px; font-size: 18px; line-height: 1.7; color: #1A1A2E; font-family: Poppins, sans-serif; text-align: center; }
.srjres-lead strong { color: #201868; }

.srjres-group { margin: 0 0 56px; }
.srjres-group-label { font-family: Poppins, sans-serif; font-size: 12px; letter-spacing: 2.2px; text-transform: uppercase; font-weight: 700; color: #F07800; margin: 0 0 6px; }
.srjres-group-rule { width: 56px; height: 3px; background: #F07800; margin: 0 0 26px; }

.srjres-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
@media (max-width: 780px) { .srjres-grid { grid-template-columns: 1fr; } }

.srjres-card { border: 1px solid #E4E2DC; border-radius: 6px; padding: 26px 28px; background: #FFFFFF; transition: border-color 0.15s ease, box-shadow 0.15s ease; }
.srjres-card:hover { border-color: #F07800; box-shadow: 0 3px 14px rgba(32,24,104,0.08); }
.srjres-card h3 { font-family: Lora, serif; font-size: 21px; font-weight: 600; margin: 0 0 10px; line-height: 1.3; }
.srjres-card h3 a { color: #201868; text-decoration: none; }
.srjres-card h3 a:hover { color: #F07800; }
.srjres-card p { font-family: Poppins, sans-serif; font-size: 15px; line-height: 1.65; color: #3A3A45; margin: 0; }

.srjres-cta { background: #201868; color: #fff; padding: 48px 32px; border-radius: 6px; margin: 8px 0 0; text-align: center; font-family: Poppins, sans-serif; }
.srjres-cta h2 { color: #fff !important; font-family: Lora, serif; margin: 0 0 12px !important; font-size: 28px; font-weight: 600; }
.srjres-cta p { color: #FFF6EC; font-size: 17px; line-height: 1.6; margin: 0 auto 24px; max-width: 620px; }
.srjres-cta a.srjres-cta-btn { display: inline-block; background: #F07800; color: #fff; padding: 16px 36px; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 16px; letter-spacing: 0.3px; }
.srjres-cta a.srjres-cta-btn:hover { background: #C86400; }
@media (max-width: 640px) {
  .srjres-cta { padding: 36px 24px; }
  .srjres-cta h2 { font-size: 24px; }
}
</style>

<section class="longform">
  <div class="container">

    <p class="srjres-lead">Everything here is free, maintained against primary sources, and written for people who have to <strong>defend a decision</strong> rather than describe a technology. The reference library is checked on a recurring cadence, and where a law has been repealed or a standard superseded, the page says so instead of quietly deleting the entry.</p>

    <div class="srjres-group">
      <p class="srjres-group-label">Free tools</p>
      <div class="srjres-group-rule"></div>
      <div class="srjres-grid">

        <div class="srjres-card">
          <h3><a href="<?php echo esc_url( home_url( '/ai-governance/' ) ); ?>">AI Governance Reference Library</a></h3>
          <p><?php echo esc_html( $srj_res_gov_count ); ?> pages covering every framework, law, agency enforcement posture, and sector rule that governs AI in the US and EU, plus China and ten further jurisdictions. Corrections included where the field is confidently wrong.</p>
        </div>

        <div class="srjres-card">
          <h3><a href="<?php echo esc_url( home_url( '/ai-governance/ai-tools/' ) ); ?>">AI Tools Catalog</a></h3>
          <p><?php echo esc_html( $srj_res_tools_count ); ?> AI tools across 23 categories, each with vendor, headquarters jurisdiction, and the governance flag it raises. The working list behind an AI tool inventory.</p>
        </div>

        <div class="srjres-card">
          <h3><a href="<?php echo esc_url( home_url( '/resources/ai-glossary/' ) ); ?>">AI Glossary</a></h3>
          <p><?php echo esc_html( $srj_res_gl_count ); ?> terms across <?php echo esc_html( $srj_res_gl_cats ); ?> categories, defined in plain English. The vocabulary that shows up in vendor pitches, board papers, and regulation, with a live search and an A to Z filter.</p>
        </div>

        <div class="srjres-card">
          <h3><a href="<?php echo esc_url( home_url( '/ai-governance/sources/' ) ); ?>">Sources &amp; References</a></h3>
          <p>The complete bibliography: 78 primary sources and 45 peer-reviewed research works, maintained the way a book maintains its reference section.</p>
        </div>

        <div class="srjres-card">
          <h3><a href="<?php echo esc_url( $srj_res_audit_url ); ?>" target="_blank" rel="noopener">AI Audit</a></h3>
          <p>Measure your organization against every framework in the library and produce a defensible governance dossier.</p>
        </div>

      </div>
    </div>

    <div class="srjres-group">
      <p class="srjres-group-label">Reading and updates</p>
      <div class="srjres-group-rule"></div>
      <div class="srjres-grid">

        <div class="srjres-card">
          <h3><a href="<?php echo esc_url( home_url( '/insights/' ) ); ?>">Insights</a></h3>
          <p>Field notes from active client engagements, framework analysis, and the reasoning behind the operating discipline.</p>
        </div>

        <div class="srjres-card">
          <h3><a href="<?php echo esc_url( home_url( '/newsletter/' ) ); ?>">The AI Operating System&trade; newsletter</a></h3>
          <p>Biweekly framework analysis, new templates, and field notes. No software pitches.</p>
        </div>

        <div class="srjres-card">
          <h3><a href="<?php echo esc_url( home_url( '/press/' ) ); ?>">Press &amp; media kit</a></h3>
          <p>Bios, company fact sheet, and brand assets, generated on demand.</p>
        </div>

        <div class="srjres-card">
          <h3><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>">Frequently asked questions</a></h3>
          <p>Direct answers on how the practice works, what an engagement looks like, and where AI governance obligations actually bite.</p>
        </div>

      </div>
    </div>

    <div class="srjres-cta">
      <h2>Ready to see where you stand?</h2>
      <p>The AI Business Enablement Audit&trade; measures your organization against every framework in this library and delivers a defensible governance dossier. Start or finish your audit below.</p>
      <a class="srjres-cta-btn" href="<?php echo esc_url( $srj_res_audit_url ); ?>" target="_blank" rel="noopener">Start or finish your AI Audit &rarr;</a>
    </div>

  </div>
</section>

<?php get_footer(); ?>
