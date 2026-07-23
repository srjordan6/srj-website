<?php
/**
 * Template Name: AI Audit
 *
 * Marketing landing page for The AI Audit application.
 * Slug: ai-audit
 *
 * v4 (June 29, 2026), complete rebuild. The v3 deploy was truncated mid
 * Section 3 and missing Sections 4 through 8 plus get_footer(), causing
 * the footer to not render on /ai-audit/. This v4 file is the complete
 * page per the v3 single-step $399 funnel spec, with all eight sections
 * present and get_footer() at end. v3's docblock, hero, style block, and
 * Sections 1, 2, 3 are preserved unchanged.
 *
 * Source of truth: "AI Audit Page Edit Instructions, 2026-06-28" (operator),
 * which supersedes the v2.0 copy doc and any earlier pricing language.
 *
 * Canonical Tier 1 customer journey:
 *   1. Customer signs up at https://aiauditforcompanies.com/startaiaudit/
 *   2. Pays $399 one-time
 *   3. Completes the 35-minute, 127-question questionnaire
 *   4. Receives The Four Audit Outputs&trade; inside their account
 *
 * There is no free tier. There is no "unlock" step. Tier 1 is one
 * transactional product at $399.
 *
 * Tier architecture (visible on this page = Tiers 1, 2, 3):
 *   Tier 1 - Snapshot - $399 one-time (public price)
 *   Tier 2 - Assessment - Pricing on Request
 *   Tier 3 - Engagement - Pricing on Request
 *   Tier 4 - Standing Operations - OMITTED from public site until launch
 *
 * v7 (July 13, 2026): LAUNCH. The AI Audit is LIVE. Two changes, both
 * operator-directed.
 *   1. URL CORRECTED. The canonical Tier 1 signup URL is
 *      https://aiauditforcompanies.com/startaiaudit/ (a path on the apex
 *      domain). The previous app.aiauditforcompanies.com subdomain was
 *      wrong and is retired: it appeared in 8 places in this file, in 2
 *      places in page-applications.php, and in llms.txt. Every one has been
 *      repointed. Do not reintroduce the subdomain.
 *   2. PRE-LAUNCH LANGUAGE REMOVED. "The Snapshot launches soon" and
 *      "Launching Soon" are retired throughout; the product is live and the
 *      CTAs now say so.
 * NOTE: this page is a Type-4 hybrid (arch doc Section 4.4), so copy lives
 * in BOTH this template AND post_content. Check the Gutenberg body for any
 * surviving app.aiauditforcompanies.com or "launching soon" strings; a
 * template edit alone does not reach them.
 *
 * Canonical signup URL: https://aiauditforcompanies.com/startaiaudit/
 *
 * Section structure:
 *   1. Hero CTA stack (injected into page hero area)
 *   1.5. Executive Summary box (v5, top-of-page AEO anchor)
 *   2. The Pain (six callouts + cumulative $670K block)
 *   3. The Value (three-tier grid with parallel 3-step structure + mid-CTA
 *      + tier comparison table added in v5)
 *   4. Detailed Capabilities (four-block accordion)
 *   5. Methodology Authority (Volume I-IV)
 *   6. Who This Is For (ten sectors + persona list)
 *   6.5. Body content (the_content for Rank Math scoring)
 *   7. Final CTA panel
 *   8. Trademark footer
 *
 * Scoped styles under .srjaiaudit- prefix. Tech debt note: extract to
 * assets/css/ai-audit-page.css on a later pass per Convention #6.
 *
 * Original creation: June 27, 2026. v3 funnel pivot: June 28, 2026.
 * v4 complete rebuild: June 29, 2026.
 *
 * v6 (July 10, 2026): Trademark audit pass. Four surgical additions:
 * (1) &trade; added to "Performance Reality Test" in §4.1 Performance
 * dimension body. (2) &trade; added to "Workflow Readiness Review" in
 * §4.2 Volume II report body. (3) Both marks added to the §8 trademark
 * footer. (4) ASCII "(TM)" in the docblock corrected to &trade;. No
 * other content changes. Source of truth: SRJ_Trademark_Portfolio_v1_1.csv.
 *
 * v5 (July 2, 2026): AVS Scanner improvements pass. Two additive changes,
 * no content changes to any existing section:
 *   1. New executive summary box added between Section 1 and Section 2,
 *      as a top-of-page AEO anchor (quotable "what this page delivers"
 *      block for AI extraction).
 *   2. New tier comparison table added below the existing three-tier grid
 *      in Section 3 (belt-and-suspenders: the visual tier grid is
 *      preserved for scan; the table adds machine-readable extraction
 *      for AI models and side-by-side comparison for humans).
 * Two new scoped CSS class families: .srjaiaudit-summary* and
 * .srjaiaudit-comparetable*, both under the existing .srjaiaudit- prefix.
 */
$GLOBALS['srj_current_nav'] = 'applications';
get_header();
?>

<?php srj_page_hero(
    'Applications &mdash; 01',
    'Find your <em>$670K</em>.',
    'Your company is running more AI than you think, in more places than you know, costing more than you can defend. The AI audit ends the guessing. Built on three decades of operator experience and four published volumes of methodology.'
); ?>

<style>
/* === The AI Audit marketing page, scoped under .srjaiaudit- prefix === */

.srjaiaudit-section { margin: 48px auto; max-width: 880px; padding: 0 20px; }
.srjaiaudit-eyebrow { font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: .18em; text-transform: uppercase; color: #F07800; margin-bottom: 14px; }
.srjaiaudit-section h2 { font-family: 'Lora', serif; font-size: 30px; line-height: 1.25; font-weight: 500; color: #201868; margin: 0 0 22px; }
.srjaiaudit-section h2 em { color: #F07800; font-style: italic; }
.srjaiaudit-section p { font-family: 'Poppins', sans-serif; font-size: 16px; line-height: 1.7; color: #4a4a4a; margin: 0 0 18px; max-width: 720px; }

.srjaiaudit-hero-cta { margin: 24px 0 0; display: flex; flex-wrap: wrap; gap: 16px; align-items: center; }
.srjaiaudit-btn-primary, .srjaiaudit-btn-outline { display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; text-decoration: none !important; transition: all .22s ease; border: 1.5px solid transparent; }
.srjaiaudit-btn-primary { background: #F07800; border-color: #F07800; color: #FFFFFF !important; }
.srjaiaudit-btn-primary:hover, .srjaiaudit-btn-primary:focus { background: #d96b00; border-color: #d96b00; color: #FFFFFF !important; }
.srjaiaudit-btn-outline { background: transparent; border-color: #201868; color: #201868 !important; }
.srjaiaudit-btn-outline:hover, .srjaiaudit-btn-outline:focus { background: #201868; color: #FFFFFF !important; }
.srjaiaudit-trust { margin-top: 18px; font-family: 'Poppins', sans-serif; font-size: 12.5px; line-height: 1.55; color: #7A8A9E; max-width: 640px; }

.srjaiaudit-pains { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; margin: 30px 0 28px; }
.srjaiaudit-pain { background: #FFF6EC; border-left: 3px solid #F07800; padding: 20px 22px 22px; }
.srjaiaudit-pain-name { font-family: 'Lora', serif; font-size: 18px; font-weight: 500; color: #201868; margin: 0 0 8px; }
.srjaiaudit-pain-desc { font-family: 'Poppins', sans-serif; font-size: 14px; line-height: 1.55; color: #4a4a4a; margin: 0; }
.srjaiaudit-cumulative { background: #201868; color: #FFFFFF; padding: 28px 30px; margin: 24px 0 8px; border-left: 4px solid #F07800; }
.srjaiaudit-cumulative p { font-family: 'Poppins', sans-serif; font-size: 16px; line-height: 1.6; color: #FFFFFF; margin: 0; max-width: none; }
.srjaiaudit-cumulative .srjaiaudit-bignum { font-family: 'Lora', serif; font-size: 32px; font-weight: 600; color: #F07800; }
.srjaiaudit-cumulative-note { font-family: 'Poppins', sans-serif; font-style: italic; font-size: 13.5px; line-height: 1.6; color: #7A8A9E; margin: 18px 0 0; padding: 14px 18px; background: #F7F4F0; border-left: 2px solid #E6E8EE; }

.srjaiaudit-tiers { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; margin: 24px 0 32px; }
.srjaiaudit-tier { background: #FFFFFF; border: 1px solid #E6E8EE; border-top: 3px solid #201868; padding: 24px 24px 22px; display: flex; flex-direction: column; }
.srjaiaudit-tier-label { font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: .14em; text-transform: uppercase; color: #F07800; margin-bottom: 6px; }
.srjaiaudit-tier-price { font-family: 'Lora', serif; font-size: 22px; font-weight: 500; color: #201868; margin: 0 0 12px; }
.srjaiaudit-tier p { font-family: 'Poppins', sans-serif; font-size: 14px; line-height: 1.6; color: #4a4a4a; margin: 0 0 12px; max-width: none; }
.srjaiaudit-tier p:last-child { margin-bottom: 0; }
.srjaiaudit-tier ol { font-family: 'Poppins', sans-serif; font-size: 14px; line-height: 1.6; color: #4a4a4a; padding-left: 22px; margin: 0; }
.srjaiaudit-tier ol li { margin-bottom: 8px; }
.srjaiaudit-tier ol li:last-child { margin-bottom: 0; }
.srjaiaudit-tier ol li strong { color: #201868; }

.srjaiaudit-midcta { background: #FFF6EC; padding: 28px 32px; margin: 32px 0; border-left: 4px solid #F07800; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 18px; }
.srjaiaudit-midcta-text { font-family: 'Lora', serif; font-size: 19px; font-weight: 500; color: #201868; margin: 0; flex: 1 1 280px; }

.srjaiaudit-accordion { margin: 28px 0 32px; }
.srjaiaudit-acc { background: #FFFFFF; border: 1px solid #E6E8EE; margin-bottom: 12px; padding: 0; }
.srjaiaudit-acc summary { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px; cursor: pointer; list-style: none; font-family: 'Lora', serif; font-size: 19px; font-weight: 500; color: #201868; transition: background .15s ease; }
.srjaiaudit-acc summary::-webkit-details-marker { display: none; }
.srjaiaudit-acc summary::after { content: '+'; font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 400; color: #F07800; margin-left: 16px; flex-shrink: 0; transition: transform .2s ease; }
.srjaiaudit-acc[open] summary::after { content: '\2212'; }
.srjaiaudit-acc summary:hover { background: #FFF6EC; }
.srjaiaudit-acc-body { padding: 6px 26px 26px; border-top: 1px solid #E6E8EE; }
.srjaiaudit-acc-body h3 { font-family: 'Lora', serif; font-size: 17px; font-weight: 500; color: #201868; margin: 22px 0 10px; }
.srjaiaudit-acc-body h3:first-child { margin-top: 18px; }
.srjaiaudit-acc-body p, .srjaiaudit-acc-body li { font-family: 'Poppins', sans-serif; font-size: 14px; line-height: 1.65; color: #4a4a4a; margin: 0 0 10px; max-width: none; }
.srjaiaudit-acc-body ul { margin: 0 0 14px 0; padding: 0 0 0 22px; }
.srjaiaudit-acc-body ul li { margin-bottom: 6px; }
.srjaiaudit-acc-body .srjaiaudit-acc-volume { font-family: 'Poppins', sans-serif; font-style: italic; font-size: 12.5px; color: #7A8A9E; margin-bottom: 10px; }

.srjaiaudit-sectors { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px 24px; margin: 24px 0 28px; list-style: none; padding: 0; }
.srjaiaudit-sectors li { font-family: 'Poppins', sans-serif; font-size: 15px; color: #201868; padding: 14px 0; border-bottom: 1px solid #E6E8EE; display: flex; align-items: baseline; gap: 14px; }
.srjaiaudit-sectors li span.num { font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 700; color: #F07800; letter-spacing: .08em; min-width: 28px; }
.srjaiaudit-personas { margin: 18px 0 6px; padding: 0; list-style: none; }
.srjaiaudit-personas li { font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 1.65; color: #4a4a4a; margin: 0 0 12px; padding-left: 22px; position: relative; }
.srjaiaudit-personas li::before { content: '\2192'; position: absolute; left: 0; top: 0; color: #F07800; font-weight: 700; }

.srjaiaudit-final { background: #201868; color: #FFFFFF; padding: 48px 40px; margin: 48px 0 0; text-align: center; }
.srjaiaudit-final h2 { font-family: 'Lora', serif; font-size: 36px; font-weight: 500; color: #FFFFFF; margin: 0 0 14px; }
.srjaiaudit-final h2 em { color: #F07800; font-style: italic; }
.srjaiaudit-final p { font-family: 'Poppins', sans-serif; font-size: 16px; line-height: 1.65; color: rgba(255,255,255,0.85); margin: 0 auto 28px; max-width: 560px; }
.srjaiaudit-final .srjaiaudit-btn-primary { background: #F07800; border-color: #F07800; }
.srjaiaudit-final .srjaiaudit-btn-outline { border-color: rgba(255,255,255,0.7); color: #FFFFFF !important; }
.srjaiaudit-final .srjaiaudit-btn-outline:hover { background: rgba(255,255,255,0.1); border-color: #FFFFFF; color: #FFFFFF !important; }
.srjaiaudit-final-cta-stack { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }

.srjaiaudit-tm-footer { margin: 36px auto 0; padding: 22px 28px; max-width: 880px; background: #F7F4F0; border-left: 2px solid #E6E8EE; font-family: 'Poppins', sans-serif; font-size: 11.5px; line-height: 1.65; color: #7A8A9E; }

/* v5 — Executive Summary box (Section 1.5, top-of-page AEO anchor) */
.srjaiaudit-summary { background: #FFF6EC; border-left: 4px solid #F07800; padding: 26px 30px 28px; margin: 20px auto 40px; max-width: 880px; }
.srjaiaudit-summary-label { font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: .18em; text-transform: uppercase; color: #F07800; margin-bottom: 10px; }
.srjaiaudit-summary p { font-family: 'Poppins', sans-serif; font-size: 15.5px; line-height: 1.65; color: #201868; margin: 0; max-width: none; }
.srjaiaudit-summary p strong { color: #201868; font-weight: 600; }

/* v5 — Tier comparison table (Section 3, below the tier grid) */
.srjaiaudit-comparetable-wrap { margin: 0 0 28px; overflow-x: auto; }
.srjaiaudit-comparetable-eyebrow { font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: .18em; text-transform: uppercase; color: #F07800; margin-bottom: 12px; }
.srjaiaudit-comparetable { width: 100%; border-collapse: collapse; font-family: 'Poppins', sans-serif; font-size: 14px; }
.srjaiaudit-comparetable caption { font-family: 'Lora', serif; font-size: 20px; font-weight: 500; color: #201868; text-align: left; padding-bottom: 14px; }
.srjaiaudit-comparetable th, .srjaiaudit-comparetable td { border: 1px solid #E6E8EE; padding: 12px 14px; text-align: left; vertical-align: top; line-height: 1.55; }
.srjaiaudit-comparetable thead th { background: #201868; color: #FFFFFF; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; }
.srjaiaudit-comparetable tbody th { background: #F7F4F0; color: #201868; font-family: 'Lora', serif; font-size: 15px; font-weight: 500; }
.srjaiaudit-comparetable tbody td { color: #4a4a4a; }
@media (max-width: 700px) { .srjaiaudit-comparetable { font-size: 13px; } .srjaiaudit-comparetable th, .srjaiaudit-comparetable td { padding: 10px 10px; } }

@media (max-width: 1100px) { .srjaiaudit-tiers { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 900px) { .srjaiaudit-pains { grid-template-columns: 1fr; } .srjaiaudit-tiers { grid-template-columns: 1fr; } .srjaiaudit-sectors { grid-template-columns: 1fr; } }
@media (max-width: 600px) { .srjaiaudit-section h2 { font-size: 24px; } .srjaiaudit-final h2 { font-size: 28px; } .srjaiaudit-final { padding: 36px 24px; } .srjaiaudit-midcta { padding: 22px 22px; } .srjaiaudit-hero-cta { flex-direction: column; align-items: stretch; } .srjaiaudit-btn-primary, .srjaiaudit-btn-outline { justify-content: center; } }

.srjaiaudit-body { background: #FFFFFF; padding: 60px 48px; margin: 0 auto 40px; border: 1px solid #E6E8EE; border-top: 4px solid #201868; }
.srjaiaudit-body > * { max-width: 760px; margin-left: auto; margin-right: auto; }
.srjaiaudit-body h2 { font-family: 'Lora', serif; font-size: 26px; font-weight: 500; color: #201868; margin: 36px auto 14px; scroll-margin-top: 80px; line-height: 1.3; }
.srjaiaudit-body h2:first-of-type { margin-top: 0; }
.srjaiaudit-body h3 { font-family: 'Lora', serif; font-size: 20px; font-weight: 500; color: #201868; margin: 24px auto 10px; }
.srjaiaudit-body p, .srjaiaudit-body li { font-family: 'Poppins', sans-serif; font-size: 16px; line-height: 1.7; color: #4a4a4a; margin: 0 auto 16px; }
.srjaiaudit-body ul, .srjaiaudit-body ol { padding-left: 24px; margin-bottom: 18px; }
.srjaiaudit-body a { color: #F07800; text-decoration: underline; }
.srjaiaudit-body a:hover { color: #d96b00; }
.srjaiaudit-body img { max-width: 100%; height: auto; margin: 12px 0; display: block; }
.srjaiaudit-body figure { margin: 18px 0; }
@media (max-width: 700px) { .srjaiaudit-body { padding: 36px 24px; } .srjaiaudit-body h2 { font-size: 22px; } }
</style>

<?php /* SECTION 1 — Hero CTA stack */ ?>
<div class="srjaiaudit-section" style="margin-top:-28px;">
  <div class="srjaiaudit-hero-cta">
    <a href="https://aiauditforcompanies.com/startaiaudit/" target="_blank" rel="noopener" class="srjaiaudit-btn-primary">Start Your AI Audit &mdash; $399 <span>&rarr;</span></a>
    <a href="<?php echo esc_url( home_url( '/schedule-consultation/' ) ); ?>" class="srjaiaudit-btn-outline">Schedule a 30-Minute Walkthrough <span>&rarr;</span></a>
  </div>
  <p class="srjaiaudit-trust">Built by SRJ Consulting &amp; Services LLC &middot; Stephen R. Jordan, three decades of senior leadership at Citi, Intel, McAfee, and Optiv &middot; Methodology published across four volumes of <em>The Operating Discipline for AI Library&trade;</em></p>
</div>

<?php /* SECTION 1.5 — Executive Summary (v5, top-of-page AEO anchor) */ ?>
<div class="srjaiaudit-summary">
  <div class="srjaiaudit-summary-label">What this page delivers</div>
  <p><strong>The AI Business Enablement Audit&trade; is a structured, executive-grade evaluation of how AI is currently operating across a business, what it is costing fully loaded, and whether it is producing measurable outcomes.</strong> Three engagement tiers, priced from a single-operator $399 diagnostic through a six-figure custom recovery program. Most audits pay for themselves before they surface a single risk finding.</p>
</div>

<?php /* SECTION 2 — The Pain */ ?>
<section class="srjaiaudit-section">
  <div class="srjaiaudit-eyebrow">What's actually happening in your company right now</div>
  <h2>The number on the contract is not the number.</h2>

  <p>You signed a contract for one AI tool. You're paying for four.</p>
  <p>The first one is on the master invoice. The second one is on your marketing director's corporate card. The third one is on a free-tier account someone in operations set up "just to test" eighteen months ago. The fourth one was bundled into your CRM upgrade and you didn't read the changelog.</p>
  <p>That's the inventory problem. It compounds into the cost problem, which compounds into the performance problem, which compounds into the risk problem, which compounds into the governance problem. Every one of them is happening in your company right now. You just can't see them, because nobody has ever counted.</p>
  <p>Here's what the research says is happening across mid-market operators with twenty-five or more employees:</p>

  <div class="srjaiaudit-pains">
    <div class="srjaiaudit-pain">
      <div class="srjaiaudit-pain-name">Duplicated subscriptions</div>
      <p class="srjaiaudit-pain-desc">Finance procured one tool. Marketing procured another. Engineering procured Copilot and Cursor. Sales procured a Gong add-on. HR procured an AI screening tool. None of them know about the others. The consolidated invoice would be 30 to 40 percent lower if any one person owned the consolidation.</p>
    </div>
    <div class="srjaiaudit-pain">
      <div class="srjaiaudit-pain-name">Shadow AI exposure</div>
      <p class="srjaiaudit-pain-desc">Employees pasting proposals, contracts, client lists, M&amp;A documents, source code, internal memos, and HR complaints into consumer chatbots, every day, with no logging, no DLP controls, no record. Each paste is a future incident waiting for a regulator, a plaintiff, an acquirer's diligence team, or a journalist.</p>
    </div>
    <div class="srjaiaudit-pain">
      <div class="srjaiaudit-pain-name">Wrong-tool productivity drag</div>
      <p class="srjaiaudit-pain-desc">Your people reach for whichever AI tool is loudest on LinkedIn this quarter. The tool is rarely the right fit for the task. The cost shows up as half-finished workflows, abandoned pilots, and a quiet erosion of trust in the technology, which means the AI investments you should make get blocked too.</p>
    </div>
    <div class="srjaiaudit-pain">
      <div class="srjaiaudit-pain-name">Vendor leverage lost</div>
      <p class="srjaiaudit-pain-desc">Every uncoordinated AI purchase weakens your position at renewal. Consolidation is leverage. Fragmentation is the opposite. Most companies are negotiating from the worst possible position and do not know it.</p>
    </div>
    <div class="srjaiaudit-pain">
      <div class="srjaiaudit-pain-name">Decision accountability gaps</div>
      <p class="srjaiaudit-pain-desc">Your AI tools are making hiring recommendations, pricing decisions, customer communications, and content choices. Nobody has written down who is accountable when one of them is wrong. When the wrong thing happens, and it will, the answer to "who approved this?" is "nobody, exactly."</p>
    </div>
    <div class="srjaiaudit-pain">
      <div class="srjaiaudit-pain-name">Regulatory blind spots</div>
      <p class="srjaiaudit-pain-desc">The EU AI Act, the Colorado AI Act, NYC Local Law 144, SEC AI marketing guidance, FTC enforcement actions, OCC SR 11-7, NIST AI RMF, ISO 42001. Your company is in scope for at least three of these. You may not know which three.</p>
    </div>
  </div>

  <div class="srjaiaudit-cumulative">
    <p>The cumulative cost of these six failure modes across mid-market operators is roughly <span class="srjaiaudit-bignum">$670,000</span> per year. Your number is different. It might be lower. It is almost certainly higher. The audit tells you which.</p>
  </div>

  <p class="srjaiaudit-cumulative-note">A note on the $670K figure: the benchmark is drawn from SRJ's current advisory research across mid-market operators. As the audit platform completes its first hundred engagements, it will produce its own peer-distribution benchmarks, your number compared against actual industry data rather than against a single calculated average. Until then, the $670K is the right starting reference.</p>
</section>

<?php /* SECTION 3 — The Value (three-tier grid, parallel 3-step structure) */ ?>
<section class="srjaiaudit-section">
  <div class="srjaiaudit-eyebrow">What the audit does</div>
  <h2>One questionnaire. Five dimensions. Four reports. A list of exactly what to fix.</h2>

  <p>The AI audit is not a survey. It is not a maturity model dressed up as a quiz. It is an operational diagnostic, the same instrument SRJ uses in its six-figure consulting engagements, made available at the lowest tier as a one-time $399 product for a single operator.</p>

  <div class="srjaiaudit-tiers">
    <div class="srjaiaudit-tier">
      <div class="srjaiaudit-tier-label">Tier 1 &middot; $399 One-Time</div>
      <div class="srjaiaudit-tier-price">The Snapshot</div>
      <p>One-time payment, 35-minute questionnaire, four framework-attached reports delivered to your account.</p>
      <ol>
        <li><strong>Sign up and pay $399</strong> at <a href="https://aiauditforcompanies.com/startaiaudit/" target="_blank" rel="noopener">aiauditforcompanies.com</a>.</li>
        <li><strong>Answer the questionnaire</strong>, about 35 minutes, 127 questions across five dimensions, for a senior operator who knows the business.</li>
        <li><strong>Receive your findings</strong>, The Four Audit Outputs&trade;, four framework-attached reports inside your account. Each names a gap, ranks it, and ties it to a documented recommended action with the relevant framework or template attached.</li>
      </ol>
    </div>
    <div class="srjaiaudit-tier">
      <div class="srjaiaudit-tier-label">Tier 2 &middot; Pricing on Request</div>
      <div class="srjaiaudit-tier-price">The Assessment</div>
      <p>The audit extended across your team, with variance analysis between what leadership thinks is happening and what the front line is actually doing.</p>
      <ol>
        <li><strong>Multi-respondent rollout</strong> across your team, up to 25 respondents with confidential individual links.</li>
        <li><strong>Variance analysis</strong>, the leadership view compared against the front-line view, with the gap surfaced and named.</li>
        <li><strong>90-minute findings call with Stephen</strong>, evidence-attached findings, document review of contracts and policies you choose to attach.</li>
      </ol>
    </div>
    <div class="srjaiaudit-tier">
      <div class="srjaiaudit-tier-label">Tier 3 &middot; Pricing on Request</div>
      <div class="srjaiaudit-tier-price">The Engagement</div>
      <p>A custom advisory engagement, scoped to your industry and your operating reality, with board-ready outputs and a named implementation roadmap.</p>
      <ol>
        <li><strong>Discovery</strong>, on-site or remote, scoped to your business and your sector.</li>
        <li><strong>Custom risk modeling</strong> and board-ready briefing materials tailored to your regulatory and operating context.</li>
        <li><strong>Six-month implementation roadmap</strong> with named owners, milestones, and review cadence.</li>
      </ol>
    </div>
  </div>

  <?php /* v5 &mdash; Tier comparison table (added below the tier grid for AI extraction and side-by-side scan). */ ?>
  <div class="srjaiaudit-comparetable-wrap">
    <div class="srjaiaudit-comparetable-eyebrow">Three tiers, side by side</div>
    <table class="srjaiaudit-comparetable">
      <caption>The audit at three commitment levels.</caption>
      <thead>
        <tr>
          <th scope="col">Tier</th>
          <th scope="col">Price</th>
          <th scope="col">What you get</th>
          <th scope="col">Delivery</th>
          <th scope="col">Best for</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">Tier 1: The Snapshot</th>
          <td>$399 one-time</td>
          <td>Four framework-attached reports (The Four Audit Outputs&trade;)</td>
          <td>35-minute self-service questionnaire, results delivered to your account</td>
          <td>A single operator who needs to see what is actually happening now</td>
        </tr>
        <tr>
          <th scope="row">Tier 2: The Assessment</th>
          <td>Pricing on request</td>
          <td>Multi-respondent rollout, variance analysis, 90-minute findings call</td>
          <td>Up to 25 confidential respondent links; document review; live call with Stephen</td>
          <td>A leadership team that suspects a gap between what they think is happening and what the front line is doing</td>
        </tr>
        <tr>
          <th scope="row">Tier 3: The Engagement</th>
          <td>Pricing on request</td>
          <td>Discovery, custom risk modeling, board-ready briefing, six-month implementation roadmap</td>
          <td>Custom advisory engagement scoped to your industry and operating reality</td>
          <td>An organization ready to fund an operating-model change with named owners and milestones</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="srjaiaudit-midcta">
    <p class="srjaiaudit-midcta-text">The Snapshot is live. Start now, or schedule a walkthrough first.</p>
    <a href="https://aiauditforcompanies.com/startaiaudit/" target="_blank" rel="noopener" class="srjaiaudit-btn-primary">Start Your AI Audit <span>&rarr;</span></a>
  </div>
</section>

<?php /* SECTION 4 — Detailed Product Capabilities (accordion, four collapsible blocks) */ ?>
<section class="srjaiaudit-section">
  <div class="srjaiaudit-eyebrow">Exactly what you get, exactly what it does</div>
  <h2>Here is what the audit produces for you, in detail.</h2>

  <p>The audit is built on five dimensions of operational exposure. Each dimension produces a 0-100 score. The five dimensions feed four cross-cutting framework reports, <strong>The Four Audit Outputs&trade;</strong>, that map to the four-volume <em>Operating Discipline for AI Library&trade;</em>. What follows is the specific deliverable list: every score, every report, every template, every recommended action that lands in your account when you complete the audit.</p>

  <div class="srjaiaudit-accordion">

    <details class="srjaiaudit-acc">
      <summary>4.1 &middot; The Five Dimensions Scored</summary>
      <div class="srjaiaudit-acc-body">
        <p>Every audit produces a score, a maturity bracket (Critical / Concerning / Developing / Sound / Mature), and a named gap list across these five dimensions:</p>

        <h3>1. Tool Inventory</h3>
        <ul>
          <li>Total count of AI tools active in your stack, official, unofficial, vendor-bundled, and personal</li>
          <li>Per-tool ownership: who is accountable for each tool, or whether the tool has no owner at all</li>
          <li>Per-tool purpose: what business problem each tool was acquired to solve</li>
          <li>Per-tool data sensitivity: what categories of company data each tool can access</li>
          <li>Shadow tool exposure: tools running on personal accounts, free tiers, or browser plugins outside IT visibility</li>
          <li>Vendor-bundled AI: AI features quietly enabled inside your existing tools (Microsoft Copilot, Salesforce Einstein, Adobe Firefly, HubSpot AI, Notion AI, Slack AI, Google Workspace AI, and forty-plus more)</li>
        </ul>

        <h3>2. Cost Mapping</h3>
        <ul>
          <li>Total monthly AI spend across the company, consolidated across all departments and all payment methods</li>
          <li>Duplicate spend identified by name and dollar amount</li>
          <li>Underutilized seats: tools paid for and not used</li>
          <li>Hidden cost vectors: API overages, per-seat creep, automatic plan upgrades, expired-trial conversions</li>
          <li>Consolidation opportunity: estimated dollar savings from consolidating overlapping vendors</li>
          <li>Vendor leverage assessment: which contracts you can renegotiate now versus which require waiting for renewal</li>
        </ul>

        <h3>3. Performance Measurement</h3>
        <ul>
          <li>Per-tool outcome tracking: whether each tool is actually moving the metric it was bought to move</li>
          <li>Adoption rate per tool: percentage of intended users actually using each tool weekly</li>
          <li>Workflow integration depth: whether AI is bolted on, partially integrated, or fully embedded in the operating workflow</li>
          <li>ROI defensibility: which tools you can defend to the board with measurable outcomes, and which you cannot</li>
          <li>The Performance Reality Test&trade;: a structured comparison of what the vendor promised against what your team is actually getting</li>
        </ul>

        <h3>4. Risk Exposure</h3>
        <ul>
          <li>Data leakage exposure: which tools have access to regulated data (PHI, PII, financial records, customer data, IP) and whether that access is logged</li>
          <li>Vendor dependency risk: which vendors you could not replace within 90 days without operational disruption</li>
          <li>Regulatory exposure mapped to your specific frameworks: NIST AI RMF, ISO 42001, EU AI Act, Colorado AI Act, NYC Local Law 144, SR 11-7, SOC 2, HIPAA, FERPA, state AI laws where applicable</li>
          <li>Decision accountability gaps: AI-influenced decisions with no named human accountable</li>
          <li>Incident readiness: whether your incident response plan covers AI-specific failure modes (hallucination, prompt injection, training data leakage, model drift, vendor outage, biased output)</li>
          <li>Contract risk: AI-related indemnification, liability caps, data-use clauses, and termination rights across your vendor portfolio</li>
        </ul>

        <h3>5. Governance Gaps</h3>
        <ul>
          <li>Policy presence: whether a Standing AI Adoption Policy&trade; exists and whether it has been ratified</li>
          <li>Board awareness: whether the board has been briefed on AI exposure and on what cadence</li>
          <li>Operating cadence: whether an AI Operating Calendar&trade; exists with named owners and recurring review milestones</li>
          <li>Decision authority: who can approve a new AI tool, at what spend thresholds, with what review</li>
          <li>Training and acceptable use: whether employees have been trained, whether acceptable-use rules exist, whether anyone has signed an attestation</li>
          <li>Audit trail: whether AI-influenced decisions are logged in a way that survives regulatory or legal scrutiny</li>
        </ul>
      </div>
    </details>

    <details class="srjaiaudit-acc">
      <summary>4.2 &middot; The Four Framework Reports You Receive</summary>
      <div class="srjaiaudit-acc-body">
        <p>Each of the five dimensions feeds into four cross-cutting reports, <strong>The Four Audit Outputs&trade;</strong>, each tied to a published volume of methodology:</p>

        <h3>The AI Business Enablement Audit&trade; Report</h3>
        <div class="srjaiaudit-acc-volume">Volume I methodology, the five-dimension scorecard</div>
        <ul>
          <li>Five dimension scores with bracket assignment (Critical / Concerning / Developing / Sound / Mature)</li>
          <li>A ranked list of the top 10 specific gaps across all five dimensions</li>
          <li>Estimated dollar exposure for each top-tier gap</li>
          <li>Recommended sequence for closure with effort-to-impact assessment</li>
          <li>Industry comparison once enough peer data exists in the platform</li>
        </ul>

        <h3>The AI Readiness &amp; Performance Assessment&trade; Report</h3>
        <div class="srjaiaudit-acc-volume">Volume II methodology, six-module readiness score</div>
        <ul>
          <li>Six module scores: Workflow, Data, People, Leadership, Performance, Operational Friction</li>
          <li>Per-module maturity assignment on the Ad hoc &rarr; Emerging &rarr; Defined &rarr; Managed &rarr; Optimizing scale</li>
          <li>The Cumulative Readiness Index, a single number that tells you where your overall AI operating maturity sits</li>
          <li>A "next bracket" map: what specifically would move each module up one maturity level</li>
          <li>The Workflow Readiness Review&trade;, workflow-by-workflow assessment of where AI is helping versus where it is creating drag</li>
        </ul>

        <h3>AI Risk &amp; Governance Review&trade; Report</h3>
        <div class="srjaiaudit-acc-volume">Volume III methodology, six-step process</div>
        <ul>
          <li>Governance maturity scored across six steps: Data Exposure, Decision Accountability, Vendor Risk, Regulatory Crosswalk, Incident Readiness, Board Reporting Cadence</li>
          <li>Maturity scale assignment: Absent &rarr; Reactive &rarr; Defined &rarr; Integrated &rarr; Continuous</li>
          <li>Regulatory crosswalk: your exposure mapped specifically to NIST AI RMF, ISO 42001, EU AI Act, Colorado AI Act, NYC LL 144, SR 11-7, SOC 2, and sector-specific regimes (HIPAA, FERPA, GLBA, FDA where applicable)</li>
          <li>Cross-cutting signal flags: any of the six review steps where your score indicates immediate executive attention</li>
          <li>A specific list of governance artifacts you do not have but should: policies, calendars, attestations, decision logs, board briefing templates</li>
        </ul>

        <h3>The AI Efficiency &amp; Process Optimization&trade; Report</h3>
        <div class="srjaiaudit-acc-volume">Cross-volume methodology, operational efficiency overlay</div>
        <ul>
          <li>Outcome alignment scoring: which AI investments are aligned to a stated business outcome versus which are operating without a tied outcome</li>
          <li>Process redesign assessment: where AI has been bolted on versus where workflows have been actually redesigned to take advantage of AI</li>
          <li>Friction inventory: the specific operational friction points where AI is making work harder, not easier</li>
          <li>AI theater identification: where AI is generating activity that looks productive but produces no measurable outcome</li>
          <li>The 90-day operational sequence: the three highest-leverage process changes you can make in the next quarter</li>
        </ul>
      </div>
    </details>

    <details class="srjaiaudit-acc">
      <summary>4.3 &middot; Plus, Every Report Includes:</summary>
      <div class="srjaiaudit-acc-body">
        <p>These are not extras. They are integral to the deliverable, operationally usable artifacts that turn the diagnostic into action:</p>
        <ul>
          <li>An <strong>Outcome Alignment Map&trade;</strong> for the top three gaps, showing the specific business outcome each gap is blocking and the line between fixing the gap and unlocking the outcome</li>
          <li>A draft <strong>Standing AI Adoption Policy&trade;</strong> customized to your stated decision-making style (consensus-driven, executive-led, board-mediated), ready to ratify or edit</li>
          <li>A populated <strong>AI Integration Checklist&trade;</strong> for whatever's next on your roadmap, adapted from the audit findings to your specific adoption sequence</li>
          <li>An <strong>AI Performance Scorecard&trade;</strong> template you can run against in 90 days to validate whether the recommended actions actually moved the metric</li>
          <li>An <strong>AI Operating Calendar&trade;</strong> outline showing the recurring governance cadence your company should be running: quarterly board briefing, monthly executive review, weekly operating standup</li>
          <li>A regulatory crosswalk document mapping your specific exposure to each applicable framework, usable as evidence in audits, due diligence, board materials, or regulatory responses</li>
        </ul>
      </div>
    </details>

    <details class="srjaiaudit-acc">
      <summary>4.4 &middot; Operational Mechanics</summary>
      <div class="srjaiaudit-acc-body">
        <p>The boring details that matter for actually using the platform:</p>
        <ul>
          <li><strong>Time commitment:</strong> roughly 35 minutes for a senior respondent who knows the business. Save-and-resume supported across multiple sessions.</li>
          <li><strong>Skip logic:</strong> the questionnaire adapts to your role and your answers. A CFO sees different questions than a CISO, and answers in one section gate or unlock questions in later sections. You will not be asked things that do not apply.</li>
          <li><strong>Honesty mechanics:</strong> "Don't know" is a valid answer and scores neutrally rather than negatively. The system is built to surface uncertainty, not punish it.</li>
          <li><strong>Multi-respondent (Tier 2 and above):</strong> up to 25 respondents on a single audit depending on company size. Each respondent gets a confidential link. Their individual answers are not visible to other respondents or to leadership, only the aggregated, anonymized findings appear in the report.</li>
          <li><strong>Evidence attachments (Tier 2 and above):</strong> you can attach existing documents (vendor contracts, policies, board materials, system inventories) which SRJ reviews and integrates into the findings.</li>
          <li><strong>Storage:</strong> all reports are stored in your account for re-download for 12 months. PDFs can be exported and shared with your board, your auditors, or your acquirer's due-diligence team.</li>
          <li><strong>Trademark protection:</strong> every framework name in your report is properly attributed. You can cite the methodology by name in board materials and the citations will reference published work.</li>
        </ul>
      </div>
    </details>

  </div>
</section>

<?php /* SECTION 5 — Methodology Authority */ ?>
<section class="srjaiaudit-section">
  <div class="srjaiaudit-eyebrow">The methodology authority</div>
  <h2>Every score traces to a published page. Every recommendation traces to a written framework.</h2>

  <p>The AI audit is not a black box. Every dimension, every score, every recommended action traces directly to a numbered chapter in <em>The Operating Discipline for AI Library&trade;</em>, SRJ's published four-volume methodology authored by Stephen R. Jordan, drawing on three decades of senior leadership at Citi, Intel, McAfee, and Optiv.</p>

  <ul style="font-family:'Poppins',sans-serif;font-size:15px;line-height:1.7;color:#4a4a4a;padding-left:22px;margin:18px 0;">
    <li><strong>Volume I</strong> establishes the five-dimension framework for The AI Business Enablement Audit&trade; and defines the scoring brackets.</li>
    <li><strong>Volume II</strong> defines the six-module structure for The AI Readiness &amp; Performance Assessment&trade; and the maturity scale.</li>
    <li><strong>Volume III</strong> specifies the six-step process for AI Risk &amp; Governance Review&trade;, including cross-cutting signals: data exposure, decision accountability, vendor risk, regulatory crosswalk, incident readiness, board reporting cadence.</li>
    <li><strong>Volume IV</strong> operationalizes the efficiency overlay for The AI Efficiency &amp; Process Optimization&trade;, converting governance findings into measurable operational savings and closing Pillar I.</li>
  </ul>

  <p>If your report says you score <em>Concerning</em> on governance, you can open the relevant volume and read precisely what <em>Concerning</em> means, what <em>Developing</em> would look like, and what the operational moves are between the two.</p>
  <p>This is the difference between an opinion and an audit.</p>
</section>

<?php /* SECTION 6 — Who This Is For */ ?>
<section class="srjaiaudit-section">
  <div class="srjaiaudit-eyebrow">Ten sectors. One operating discipline.</div>
  <h2>Built for executives accountable for AI outcomes, across every sector where AI has entered the workflow.</h2>

  <p>SRJ Consulting serves ten sectors. The audit instrument operates the same way in each, because the five dimensions are universal. The contextual mapping (which regulations apply, which AI patterns are emerging in your industry, which risks are sector-specific) adapts automatically based on your responses.</p>

  <ul class="srjaiaudit-sectors">
    <li><span class="num">01</span> Aerospace &amp; Defense</li>
    <li><span class="num">02</span> Technology &amp; Software</li>
    <li><span class="num">03</span> Agriculture</li>
    <li><span class="num">04</span> Healthcare &amp; Life Sciences</li>
    <li><span class="num">05</span> Media &amp; Telecom</li>
    <li><span class="num">06</span> Manufacturing</li>
    <li><span class="num">07</span> Retail &amp; E-Commerce</li>
    <li><span class="num">08</span> Insurance</li>
    <li><span class="num">09</span> Financial Services &amp; Banking</li>
    <li><span class="num">10</span> Legal Services</li>
  </ul>

  <p><strong>Sector not listed?</strong> The framework still applies. The audit scores against universal dimensions (tool inventory, cost, performance, risk, governance) that operate the same way in any industry where AI has entered the workflow.</p>

  <p style="margin-top:24px;">Specifically, the audit is the right instrument if you are any of the following:</p>

  <ul class="srjaiaudit-personas">
    <li>A <strong>founder or CEO</strong> who has approved AI spending in three different departments and has no consolidated view of what's actually running</li>
    <li>A <strong>CFO</strong> staring at the line item for software subscriptions and seeing three different AI charges that may or may not be from the same vendor</li>
    <li>A <strong>board member or audit committee chair</strong> who has been told the company "is using AI" and wants something more substantive than a memo for the minutes</li>
    <li>A <strong>general counsel or CISO</strong> who has been asked to sign off on an AI policy and wants a defensible baseline mapped to recognized frameworks</li>
    <li>A <strong>private equity operator or due diligence team</strong> evaluating the AI exposure of a target before close</li>
    <li>An <strong>insurer or auditor</strong> who needs structured evidence of AI governance maturity before issuing coverage or signing off</li>
  </ul>
</section>

<?php /* SECTION 6.5 — Body content (the_content) for Rank Math scoring (hybrid Type-4 pattern) */ ?>
<section class="srjaiaudit-section srjaiaudit-body">
  <?php
  if ( have_posts() ) :
      while ( have_posts() ) : the_post();
          the_content();
      endwhile;
  endif;
  ?>
</section>

<?php /* SECTION 7 — Final CTA (v3 single-step funnel) */ ?>
<section class="srjaiaudit-final">
  <h2>Find your <em>$670,000</em>.</h2>
  <p>Or whatever your specific number turns out to be. The Snapshot is live, $399 one-time. The advisory is there if you need it.</p>
  <div class="srjaiaudit-final-cta-stack">
    <a href="https://aiauditforcompanies.com/startaiaudit/" target="_blank" rel="noopener" class="srjaiaudit-btn-primary">Start Your AI Audit &mdash; $399 <span>&rarr;</span></a>
    <a href="<?php echo esc_url( home_url( '/schedule-consultation/' ) ); ?>" class="srjaiaudit-btn-outline">Schedule a 30-Minute Walkthrough <span>&rarr;</span></a>
  </div>
</section>

<?php /* SECTION 8 — Trademark Footer */ ?>
<div class="srjaiaudit-tm-footer">
  AI Adoption Decision Framework&trade;, The AI Business Enablement Audit&trade;, AI Business Services&trade;, AI Decision Accountability Framework&trade;, The AI Efficiency &amp; Process Optimization&trade;, AI Integration Checklist&trade;, The AI IT Security Audit&trade;, The AI IT Security Implementation &amp; Strategy&trade;, AI Operating Calendar&trade;, The AI Operating System&trade;, AI Operational Risk Assessment&trade;, AI Operational Risk Categories&trade;, AI Performance Governance&trade;, AI Performance Scorecard&trade;, The AI Readiness &amp; Performance Assessment&trade;, AI Risk &amp; Governance Review&trade;, AI Risk Governance &amp; Security&trade;, AI ROI Evaluation Framework&trade;, Application Security in the Age of AI&trade;, Cloud and Infrastructure Security in the Age of AI&trade;, The Four Audit Outputs&trade;, The Operating Discipline for AI Library&trade;, Operational Health Check&trade;, Operational Integration &amp; Workflow Adoption&trade;, Outcome Alignment Map&trade;, Performance Reality Test&trade;, Secure by Design in the Age of AI&trade;, Standing AI Adoption Policy&trade;, and Workflow Readiness Review&trade; are trademarks of SRJ Consulting &amp; Services LLC.
</div>

<?php get_footer(); ?>
