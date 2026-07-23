<?php
/**
 * Template Name: Applications
 *
 * Hub page for SRJ Consulting applications.
 * Slug: applications
 *
 * v5 (July 13, 2026): LAUNCH + URL CORRECTION. Application 01 (The AI Audit)
 * flipped from "Launching Soon" to "Live". The Reports meta line no longer
 * names a delivery URL: the previous app.aiauditforcompanies.com subdomain was
 * WRONG. The canonical Tier 1 signup URL is
 * https://aiauditforcompanies.com/startaiaudit/ and it lives on page-ai-audit.php,
 * which is where the buy CTAs belong. This hub card keeps its "Learn more" link
 * to /ai-audit/ so the funnel stays one-hop. Do not reintroduce the subdomain.
 * NOTE: Type-4 hybrid, so copy also lives in post_content; check the Gutenberg
 * body for surviving app.aiauditforcompanies.com or "launching soon" strings.
 *
 * v4 (July 7, 2026): Application 02 flipped from "In Development" placeholder
 * to outcomestar (Live). Card links to the new child page at
 * /applications/outcomestar/. Description covers the K-12 family record,
 * five pillars, filled application drafts, and the free-K-5 mechanic.
 * outcomestar is family-owned by SRJ Consulting & Services LLC and delivered
 * via outcomestar.app; consumer copy and CTAs live on the child page, not
 * this hub. Same pass: intro paragraph rewritten to cover both AI applications
 * (added the college admissions officer as a decision-maker; kept the
 * "methodology has been published, application makes it operational" spine).
 *
 * v3 (June 28, 2026): aligned to single-step $399 funnel per
 * "/applications page edit instructions, 2026-06-28" (operator). Card 01
 * desc rewritten: removed "Free Tier 1 snapshot" and "$199 unlocks"
 * language; replaced with single $399 one-time mechanic. Reports meta
 * line now names the app.aiauditforcompanies.com subdomain delivery.
 *
 * v2 (June 27, 2026, late evening): converted to HYBRID (Type-4 per arch
 * doc Section 4.4). Page calls the_content() between the card grid and
 * the methodology block, so engineered Gutenberg content renders for
 * visitors AND populates post_content for Rank Math scoring. This is the
 * fix for the score-of-6 issue on Type-1 PHP templates: Rank Math reads
 * post_content, not rendered HTML.
 *
 * Operator-canonical tier architecture (re-stated here for next session):
 *   Tier 1 - Snapshot - $399 one-time (public price)
 *   Tier 2 - Assessment - Pricing on Request
 *   Tier 3 - Engagement - Pricing on Request
 *   Tier 4 - Standing Operations - OMIT from public site until launch
 *
 * Note: edits 2.2-2.5 from the instructions doc live in the WordPress
 * block editor (Gutenberg post_content), not in this template. Edit via
 * WP admin -> Pages -> Applications -> body editor.
 *
 * Brand: navy #201868, orange #F07800, gray #7A8A9E, cream #FFF6EC.
 * Lora headlines, Poppins body. Scoped styles under .srjapps- prefix.
 */
$GLOBALS['srj_current_nav'] = 'applications';
get_header();
?>

<?php srj_page_hero(
    'Applications',
    'Operationalized products from the discipline.',
    'Diagnostic and operating instruments built directly on The Operating Discipline for AI Library&trade;. Each application takes a methodology from the book series and packages it for leadership teams that want the diagnostic, the scoring, and the report without commissioning the full consulting engagement.'
); ?>

<style>
/* === Applications hub, scoped under .srjapps- prefix === */
.srjapps-intro { margin: 36px auto 24px; max-width: 760px; text-align: center; padding: 0 20px; }
.srjapps-intro p { font-family: 'Poppins', sans-serif; font-size: 16px; line-height: 1.65; color: #4a4a4a; margin: 0; }
.srjapps-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; margin: 36px 0 48px; }
.srjapps-card { background: #FFFFFF; border: 1px solid #E6E8EE; border-top: 4px solid #F07800; padding: 32px 30px 30px; display: flex; flex-direction: column; transition: box-shadow .25s ease, transform .25s ease; }
.srjapps-card:hover { box-shadow: 0 10px 28px rgba(32, 24, 104, 0.10); transform: translateY(-2px); }
.srjapps-card-eyebrow { font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: .18em; text-transform: uppercase; color: #F07800; margin-bottom: 10px; }
.srjapps-card-status { display: inline-block; font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 600; letter-spacing: .14em; text-transform: uppercase; padding: 3px 10px; border-radius: 2px; margin-bottom: 16px; }
.srjapps-card-status.is-prelaunch { background: #FFF6EC; color: #F07800; border: 1px solid #F07800; }
.srjapps-card-status.is-live { background: #201868; color: #FFFFFF; }
.srjapps-card-status.is-soon { background: #F7F4F0; color: #7A8A9E; border: 1px solid #E6E8EE; }
.srjapps-card-title { font-family: 'Lora', serif; font-size: 24px; line-height: 1.25; font-weight: 500; color: #201868; margin: 0 0 14px; }
.srjapps-card-desc { font-family: 'Poppins', sans-serif; font-size: 14.5px; line-height: 1.6; color: #4a4a4a; margin: 0 0 22px; flex-grow: 1; }
.srjapps-card-meta { display: flex; flex-wrap: wrap; gap: 6px 18px; margin-bottom: 22px; padding-top: 16px; border-top: 1px solid #E6E8EE; font-family: 'Poppins', sans-serif; font-size: 12px; color: #7A8A9E; }
.srjapps-card-meta span strong { color: #201868; font-weight: 600; }
.srjapps-card-cta { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: #F07800; color: #FFFFFF !important; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; text-decoration: none !important; transition: background .22s ease; align-self: flex-start; }
.srjapps-card-cta:hover, .srjapps-card-cta:focus { background: #d96b00; color: #FFFFFF !important; }
.srjapps-card.is-placeholder { background: #FFF6EC; border: 1px dashed #E6E8EE; border-top: 4px solid #E6E8EE; }
.srjapps-card.is-placeholder .srjapps-card-eyebrow, .srjapps-card.is-placeholder .srjapps-card-title { color: #7A8A9E; }
.srjapps-methodology { background: #FFF6EC; padding: 36px 38px; margin: 0 0 48px; border-left: 4px solid #201868; }
.srjapps-methodology h2 { font-family: 'Lora', serif; font-size: 22px; line-height: 1.3; font-weight: 500; color: #201868; margin: 0 0 12px; }
.srjapps-methodology p { font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 1.65; color: #4a4a4a; margin: 0 0 8px; }
.srjapps-methodology p:last-child { margin-bottom: 0; }

/* --- Body content (the_content) styling --- */
.srjapps-body { max-width: 760px; margin: 0 auto 48px; padding: 0 20px; }
.srjapps-body h2 { font-family: 'Lora', serif; font-size: 26px; font-weight: 500; color: #201868; margin: 36px 0 14px; scroll-margin-top: 80px; }
.srjapps-body h2:first-of-type { margin-top: 0; }
.srjapps-body h3 { font-family: 'Lora', serif; font-size: 20px; font-weight: 500; color: #201868; margin: 24px 0 10px; }
.srjapps-body p, .srjapps-body li { font-family: 'Poppins', sans-serif; font-size: 16px; line-height: 1.7; color: #4a4a4a; margin: 0 0 16px; }
.srjapps-body ul, .srjapps-body ol { padding-left: 24px; margin-bottom: 18px; }
.srjapps-body a { color: #F07800; text-decoration: underline; }
.srjapps-body a:hover { color: #d96b00; }
.srjapps-body img { max-width: 100%; height: auto; margin: 12px 0; }

@media (max-width: 900px) { .srjapps-grid { grid-template-columns: 1fr; } }
@media (max-width: 600px) {
  .srjapps-card { padding: 26px 22px 24px; }
  .srjapps-card-title { font-size: 21px; }
  .srjapps-methodology { padding: 26px 22px; }
}
</style>

<section class="service-detail">
  <div class="container">

    <div class="srjapps-intro">
      <p>A structured questionnaire, scored against a published framework. A report you can put in front of the decision-maker who asked, a board, an auditor, an acquirer, a carrier, or a college admissions officer. The methodology has been published. The application is what makes it operational.</p>
    </div>

    <!-- CARD GRID -->
    <div class="srjapps-grid">
      <article class="srjapps-card">
        <div class="srjapps-card-eyebrow">Application 01</div>
        <span class="srjapps-card-status is-live">Live</span>
        <h2 class="srjapps-card-title">The AI Audit</h2>
        <p class="srjapps-card-desc">A five-dimension diagnostic that surfaces what unmanaged AI is silently costing the business. Tool inventory, cost mapping, performance measurement, risk exposure, and governance gaps, scored together. Tier 1 Snapshot &mdash; $399 one-time. Sign up, complete the questionnaire, receive The Four Audit Outputs&trade;.</p>
        <div class="srjapps-card-meta">
          <span><strong>Methodology:</strong> Volumes I, II, III, IV</span>
          <span><strong>Time:</strong> ~35 minutes</span>
          <span><strong>Reports:</strong> 4 PDFs delivered to your account</span>
        </div>
        <a href="<?php echo esc_url( home_url( '/ai-audit/' ) ); ?>" class="srjapps-card-cta">Learn more <span>&rarr;</span></a>
      </article>

      <article class="srjapps-card">
        <div class="srjapps-card-eyebrow">Application 02</div>
        <span class="srjapps-card-status is-live">Live</span>
        <h2 class="srjapps-card-title">outcomestar</h2>
        <p class="srjapps-card-desc">A family-owned college outcomes platform that captures, curates, and controls a full Pre-K through senior-year record of the student. Five pillars, twelve years, one account per family. Filled application drafts, recommendation workflow, verified transcript intake, and the searchable directory of all 6,073 Title IV US institutions. K&ndash;5 is free. Need-based scholarship pricing available on a sliding scale down to $0.</p>
        <div class="srjapps-card-meta">
          <span><strong>Grade bands:</strong> Pre-K through Grade 12 and beyond</span>
          <span><strong>Pricing:</strong> Free K&ndash;5, tiered thereafter</span>
          <span><strong>Delivery:</strong> outcomestar.app</span>
        </div>
        <a href="<?php echo esc_url( home_url( '/applications/outcomestar/' ) ); ?>" class="srjapps-card-cta">Learn more <span>&rarr;</span></a>
      </article>
    </div>

    <!-- BODY CONTENT (the_content) -- engineered for Rank Math scoring -->
    <div class="srjapps-body">
      <?php
      if ( have_posts() ) :
          while ( have_posts() ) : the_post();
              the_content();
          endwhile;
      endif;
      ?>
    </div>

    <div class="srjapps-methodology">
      <h2>Every application traces to a published page.</h2>
      <p>The applications listed here are not standalone software products. Each is the operating expression of methodology written in <em>The Operating Discipline for AI Library&trade;</em>. Every score traces to a numbered chapter. Every recommendation traces to a written framework. Every framework name in the report is properly attributed to its published source.</p>
      <p>This is the difference between an opinion and an audit, and the difference between a survey and an operating diagnostic.</p>
    </div>

  </div>
</section>

<?php srj_inline_cta( 'Want to discuss which application fits your operating reality? <em>Start with a conversation.</em>' ); ?>
<?php srj_final_cta(); ?>

<?php get_footer(); ?>