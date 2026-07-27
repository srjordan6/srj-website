<?php
/**
 * Template Name: AI Governance Hub
 *
 * Renders the /ai-governance/ landing page as a full directory of all
 * destinations (25 top-level categories + their subcategories) in a
 * 3-column masonry layout. Every destination is visible without clicking.
 * Matches the site-footer navigation pattern: uppercase category
 * eyebrow header linking to the category page, followed by indented
 * subcategory links with a ↳ arrow marker.
 *
 * v2 (July 13, 2026): Redesign from card grid to directory-style
 * masonry. The card grid required one click to reveal what was inside
 * each category, forcing users to dig. Executives coming to this page
 * for AI governance reference want to find their framework fast, not
 * hunt through cards. New layout puts every category header AND every
 * subcategory link on the same screen. Uses CSS multi-column layout
 * for automatic vertical balancing across variable-height categories.
 *
 * v1 (July 10, 2026): Initial card-grid build.
 *
 * v1.63 (July 14, 2026): Tier 2 additions. Four new top-level
 * categories added to $order after 'dora': nydfs-part-500,
 * federal-contractor-ai, state-privacy-laws, coe-framework-convention.
 * FERPA and FINRA register as children of sector-rules in the config,
 * so they surface under that category without a $order entry. Library
 * goes 53 -> 59 pages (23 top-level categories, 36 subcategories).
 *
 * v1.65 (July 17, 2026): Added china-ai-regulation as a top-level
 * category after coe-framework-convention. China coverage is always
 * top-level. Library 59 -> 60 pages (24 top-level categories,
 * 36 subcategories). Corrects the widespread conflation of China's
 * May 8 2026 intelligent-agent Opinions with the separate July 15 2026
 * anthropomorphic-services rule that drove the Doubao/Qwen shutdowns.
 *
 * v1.67 (July 17, 2026): Added global-ai-laws as a top-level category
 * after china-ai-regulation. Ten jurisdictions beyond the EU, US, and
 * China: KR, JP, SG, IN, CA, BR, UK, AE, SA, AU. Library 60 -> 61
 * pages (25 top-level categories, 36 subcategories). Correction angle:
 * only South Korea has a binding comprehensive AI act in force; the
 * binding layer in most jurisdictions is privacy law, not an AI act.
 *
 * v1.68 (July 17, 2026): Added sources as the final top-level entry,
 * a consolidated bibliography (Sources & References) listing all 74
 * primary sources and 44 peer-reviewed research works cited across
 * the library, grouped like a book reference section. Companion
 * reference page: the framework-page count stays 61; the hub shows
 * 26 category tiles.
 *
 * v1.69 (July 19, 2026): Added ai-tools as a top-level category
 * before sources. Reference catalog of 317 AI tools across 23
 * categories from the SRJ AI Tool Inventory Tracker, each with
 * vendor, HQ jurisdiction, and a governance note. Companion
 * reference page like sources: framework-page count stays 61;
 * the hub shows 27 category tiles.
 */
$GLOBALS['srj_current_nav'] = 'ai-governance';
get_header();

// Resolve the directory. The hub only ever renders titles, subtitles and
// links, never article bodies, so it reads the body-less index: columns
// only, no JSON decoding, roughly 95 percent smaller than the full set.
// The PHP config remains the fallback when the database has no rows.
$nav = array();

if ( function_exists( 'srj_govdb_has_rows' ) && srj_govdb_has_rows() ) {
    $nav = srj_govdb_get_lite();
} else {
    $config_path = get_stylesheet_directory() . '/inc/ai-governance-config.php';
    if ( file_exists( $config_path ) ) {
        require $config_path;
    }
    if ( isset( $SRJ_GOVERNANCE ) && is_array( $SRJ_GOVERNANCE ) ) {
        $nav = $SRJ_GOVERNANCE;
    }
}

// Display order for the 15 categories, grouped by conceptual affinity
// (standards, laws by geography, enforcement, reporting, vendor/data).
$order = array(
    'iso-42001',
    'iso-22989',
    'nist-ai-rmf',
    'eu-ai-act',
    'eu-cyber-resilience-act',
    'eu-product-liability',
    'nis2',
    'dora',
    'nydfs-part-500',
    'federal-contractor-ai',
    'state-privacy-laws',
    'coe-framework-convention',
    'china-ai-regulation', 'global-ai-laws',
    'nyc-ai-laws',
    'state-ai-laws',
    'federal-ai-legislation',
    'sr-11-7',
    'agency-enforcement',
    'sector-rules',
    'financial-reporting',
    'director-oversight',
    'general-business-governance',
    'vendor-disclosure',
    'data-management-frameworks',
    'ai-tools',
    'sources',
);
?>

<?php srj_page_hero( 'Reference Library', 'AI Governance' ); ?>

<style>
/* AI Governance directory layout. Multi-column masonry so all 15
   categories (each with 0-8 children) fit onscreen without digging.
   Migrates to assets/css/ai-governance.css on consolidation pass. */
.srjgov-lead { max-width: 760px; margin: 0 auto 40px; font-size: 18px; line-height: 1.7; color: #1A1A2E; font-family: Poppins, sans-serif; text-align: center; }
.srjgov-lead strong { color: #201868; }
.srjgov-lead a { color: #F07800; text-decoration: none; }
.srjgov-lead a:hover { text-decoration: underline; }

.srjgov-tldr { background: #FFF6EC; border-left: 4px solid #F07800; padding: 24px 28px; margin: 32px auto; font-family: Poppins, sans-serif; max-width: 820px; }
.srjgov-tldr-label { font-size: 12px; letter-spacing: 2px; text-transform: uppercase; color: #F07800; font-weight: 600; margin: 0 0 10px; }
.srjgov-tldr p:not(.srjgov-tldr-label) { margin: 0; font-size: 17px; line-height: 1.65; color: #1A1A2E; }
.srjgov-tldr strong { color: #201868; }

.srjgov-dir { column-count: 3; column-gap: 44px; margin: 48px 0; }
@media (max-width: 960px) { .srjgov-dir { column-count: 2; column-gap: 36px; } }
@media (max-width: 600px) { .srjgov-dir { column-count: 1; } }

.srjgov-dir-cat { break-inside: avoid; page-break-inside: avoid; -webkit-column-break-inside: avoid; display: block; margin-bottom: 36px; }
.srjgov-dir-cat-title { font-family: Poppins, sans-serif; font-size: 12px; letter-spacing: 2.2px; text-transform: uppercase; font-weight: 700; margin: 0 0 6px; line-height: 1.3; }
.srjgov-dir-cat-title a { color: #201868; text-decoration: none; border-bottom: 2px solid transparent; padding-bottom: 2px; transition: border-color 0.15s ease, color 0.15s ease; }
.srjgov-dir-cat-title a:hover { color: #F07800; border-bottom-color: #F07800; }
.srjgov-dir-cat-sub { font-family: Poppins, sans-serif; font-size: 13px; line-height: 1.5; color: #7A8A9E; margin: 0 0 12px; font-style: italic; }

.srjgov-dir-children { list-style: none !important; padding: 0 !important; margin: 8px 0 0 !important; }
.srjgov-dir-children li { padding: 6px 0; font-family: Poppins, sans-serif; font-size: 15px; line-height: 1.45; list-style: none !important; }
.srjgov-dir-children a { color: #201868; text-decoration: none; font-weight: 500; }
.srjgov-dir-children a:hover { color: #F07800; text-decoration: underline; }

.srjgov-updates { max-width: 820px; margin: 40px auto 8px; font-family: Poppins, sans-serif; border: 1px solid #E4E2DC; border-radius: 6px; padding: 26px 30px; background: #FAFAF8; }
.srjgov-updates-head { display: flex; align-items: baseline; gap: 12px; flex-wrap: wrap; margin: 0 0 4px; }
.srjgov-updates-label { font-size: 12px; letter-spacing: 2px; text-transform: uppercase; color: #F07800; font-weight: 700; margin: 0; }
.srjgov-updates-date { font-size: 12px; color: #7A8A9E; margin: 0; }
.srjgov-updates-intro { font-size: 15px; line-height: 1.6; color: #3A3A45; margin: 10px 0 18px; }
.srjgov-updates ul { list-style: none !important; margin: 0 !important; padding: 0 !important; }
.srjgov-updates li { list-style: none !important; padding: 12px 0; border-top: 1px solid #EFEDE7; font-size: 15px; line-height: 1.6; color: #3A3A45; }
.srjgov-updates li:first-child { border-top: 0; padding-top: 0; }
.srjgov-updates li strong { color: #201868; }
.srjgov-updates li a { color: #201868; text-decoration: underline; text-underline-offset: 2px; text-decoration-color: rgba(32,24,104,0.3); }
.srjgov-updates li a:hover { color: #F07800; text-decoration-color: #F07800; }
.srjgov-flag { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; padding: 2px 7px; border-radius: 3px; margin-right: 8px; vertical-align: 1px; }
.srjgov-flag.is-repealed { background: #FBE9E7; color: #B3261E; }
.srjgov-flag.is-superseded { background: #FFF6EC; color: #B96000; }
.srjgov-flag.is-final { background: #E8F0E9; color: #2E6B3E; }
.srjgov-flag.is-new { background: #EDEBF5; color: #201868; }

.srjgov-cta { background: #201868; color: #fff; padding: 48px 32px; border-radius: 6px; margin: 48px 0 0; text-align: center; font-family: Poppins, sans-serif; }
.srjgov-cta h2 { color: #fff !important; font-family: Lora, serif; margin: 0 0 12px !important; font-size: 28px; font-weight: 600; }
.srjgov-cta p { color: #FFF6EC; font-size: 17px; line-height: 1.6; margin: 0 auto 24px; max-width: 620px; }
.srjgov-cta a.srjgov-cta-btn { display: inline-block; background: #F07800; color: #fff; padding: 16px 36px; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 16px; letter-spacing: 0.3px; }
.srjgov-cta a.srjgov-cta-btn:hover { background: #C86400; }
@media (max-width: 640px) {
  .srjgov-cta { padding: 36px 24px; }
  .srjgov-cta h2 { font-size: 24px; }
}
</style>

<section class="longform">
  <div class="container">

    <div class="srjgov-tldr">
      <p class="srjgov-tldr-label">The one-paragraph answer</p>
      <p><strong>AI governance</strong> is the discipline of running artificial intelligence in a way you can defend to a board, a buyer, an insurer, a regulator, or a court. It is not one law. It is fifteen overlapping frameworks, standards, and rules that all point at the same question: <em>&ldquo;Do you have an AI management system?&rdquo;</em> This library answers that question one framework at a time, in plain English, checked against the primary sources rather than against other people's summaries. Where a law has been repealed or a standard superseded, we say so on the page rather than quietly deleting it.</p>
    </div>

    <p class="srjgov-lead">The line-by-line mapping between these frameworks and SRJ's operating artifacts is Appendix L of <a href="<?php echo esc_url( home_url( '/books/ai-business-services/the-ai-risk-governance-review/' ) ); ?>"><em>The AI Risk &amp; Governance Review</em>&trade;</a>, Volume III of <a href="<?php echo esc_url( home_url( '/books/' ) ); ?>"><em>The Operating Discipline for AI Library</em>&trade;</a>.</p>

    <div class="srjgov-updates">
      <div class="srjgov-updates-head">
        <p class="srjgov-updates-label">What changed</p>
        <p class="srjgov-updates-date">Reviewed 14 July 2026</p>
      </div>
      <p class="srjgov-updates-intro">This library is reviewed against primary sources, not secondary summaries. Seven changes since the last pass are material enough that a compliance roadmap built on the old position is now aimed at the wrong target.</p>
      <ul>
        <li>
          <span class="srjgov-flag is-repealed">Repealed</span>
          <strong>The Colorado AI Act is gone.</strong> SB 24-205 was repealed by SB 26-189 on 14 May 2026 and <em>never took effect</em>. The duty of care, the impact assessments, and the rebuttable presumption for NIST AI RMF alignment are all removed. A narrower disclosure regime takes effect 1 January 2027. <a href="<?php echo esc_url( home_url( '/ai-governance/state-ai-laws/colorado-ai-act/' ) ); ?>">Read what replaced it</a>.
        </li>
        <li>
          <span class="srjgov-flag is-superseded">Superseded</span>
          <strong>SR 11-7 is no longer the model risk standard.</strong> On 17 April 2026 the Federal Reserve, OCC, and FDIC issued revised interagency guidance (SR 26-2 and OCC Bulletin 2026-13), rescinding OCC Bulletin 2011-12. The new guidance is explicitly non-enforceable, states relevance above $30bn in assets, and narrows the definition of a model to <em>complex</em> methods. <a href="<?php echo esc_url( home_url( '/ai-governance/sr-11-7/' ) ); ?>">Read what changed</a>.
        </li>
        <li>
          <span class="srjgov-flag is-final">Now final</span>
          <strong>The EU AI Act Digital Omnibus was adopted.</strong> The Council gave final approval on 29 June 2026. Annex III high-risk obligations move to 2 December 2027, embedded-product high-risk to 2 August 2028. Article 50 transparency still applies from 2 August 2026. A new Article 5 prohibition on AI-generated intimate imagery starts 2 December 2026. <a href="<?php echo esc_url( home_url( '/ai-governance/eu-ai-act/' ) ); ?>">Read the revised timeline</a>.
        </li>
        <li>
          <span class="srjgov-flag is-repealed">Deadline</span>
          <strong>Your AI becomes a product on 9 December 2026.</strong> The revised EU Product Liability Directive makes software and AI systems <em>strictly liable products</em>. And AI Act non-compliance creates a <em>presumption that your product was defective</em>. The Digital Omnibus deferred the AI Act's obligations to 2027 and 2028. It did not move this deadline. <a href="<?php echo esc_url( home_url( '/ai-governance/eu-product-liability/' ) ); ?>">Read what changes in December</a>.
        </li>
        <li>
          <span class="srjgov-flag is-new">New pages</span>
          <strong>NIS2 and DORA now covered.</strong> The EU stack is complete: the AI Act, the Cyber Resilience Act, Product Liability, <a href="<?php echo esc_url( home_url( '/ai-governance/nis2/' ) ); ?>">NIS2</a> (where directors can be personally banned from management), and <a href="<?php echo esc_url( home_url( '/ai-governance/dora/' ) ); ?>">DORA</a> (which reaches AI vendors through their financial-services customers).
        </li>
        <li>
          <span class="srjgov-flag is-new">Correction</span>
          <strong>&ldquo;High-risk AI&rdquo; does not mean an external audit.</strong> EU AI Act Article 43(2) routes Annex III points 2 to 8, which is critical infrastructure, education, employment, credit scoring, law enforcement, migration, and justice, to <em>self-assessment</em> under Annex VI, expressly without a notified body. A notified body is required only for biometrics, and only where the harmonised standards are not fully applied. Most published guidance implies otherwise. <a href="<?php echo esc_url( home_url( '/ai-governance/eu-ai-act/' ) ); ?>">Read which route applies to you</a>.
        </li>
        <li>
          <span class="srjgov-flag is-new">New page</span>
          <strong>The EU Cyber Resilience Act is now covered.</strong> Its reporting duty bites on 11 September 2026 and reaches products already on the market. Its Article 12 route to deemed compliance with EU AI Act Article 15 covers the <em>cybersecurity</em> limb only: accuracy and robustness remain live and must be evidenced independently. Almost every summary of that provision drops the opening clause. <a href="<?php echo esc_url( home_url( '/ai-governance/eu-cyber-resilience-act/' ) ); ?>">Read the Article 12 trap</a>.
        </li>
        <li>
          <span class="srjgov-flag is-new">New</span>
          <strong>Three NIST efforts are frequently confused.</strong> The Cyber AI Profile (NIST IR 8596), COSAiS (SP 800-53 control overlays), and the AI RMF Critical Infrastructure Profile are different documents doing different jobs. <a href="<?php echo esc_url( home_url( '/ai-governance/nist-ai-rmf/' ) ); ?>">Read how they fit together</a>. The House Science Committee also advanced ten AI bills on 25 June 2026; <a href="<?php echo esc_url( home_url( '/ai-governance/federal-ai-legislation/' ) ); ?>">four matter</a>, and none is law.
        </li>
      </ul>
    </div>

    <div class="srjgov-dir">
      <?php foreach ( $order as $slug ) :
          if ( ! isset( $nav[ $slug ] ) ) continue;
          $entry = $nav[ $slug ];
          $url   = home_url( '/ai-governance/' . $slug . '/' );
          $children = ( isset( $entry['children'] ) && is_array( $entry['children'] ) ) ? $entry['children'] : array();
      ?>
        <div class="srjgov-dir-cat">
          <p class="srjgov-dir-cat-title">
            <a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $entry['title'] ); ?></a>
          </p>
          <?php if ( ! empty( $entry['subtitle'] ) ) : ?>
            <p class="srjgov-dir-cat-sub"><?php echo esc_html( $entry['subtitle'] ); ?></p>
          <?php endif; ?>
          <?php if ( ! empty( $children ) ) : ?>
            <ul class="srjgov-dir-children">
              <?php foreach ( $children as $child_slug ) :
                  if ( ! isset( $nav[ $child_slug ] ) ) continue;
                  $child = $nav[ $child_slug ];
                  $child_url = home_url( '/ai-governance/' . $slug . '/' . $child_slug . '/' );
              ?>
                <li>
                  <a href="<?php echo esc_url( $child_url ); ?>"><?php echo esc_html( $child['title'] ); ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="srjgov-cta">
      <h2>Ready to see where you stand?</h2>
      <p>The AI Business Enablement Audit&trade; measures your organization against every framework in this library and delivers a defensible governance dossier. Start or finish your audit below.</p>
      <a class="srjgov-cta-btn" href="https://aiauditforcompanies.com/startaiaudit/" target="_blank" rel="noopener">Start or finish your AI Audit &rarr;</a>
    </div>

  </div>
</section>

<?php get_footer(); ?>
