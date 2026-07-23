<?php
/**
 * Template Name: Services Hub
 *
 * Services Landing Page Template
 * Used for the page with slug "services".
 *
 * v4 (May 2026): updated for the Services pillar restructure. Service cards
 * now link to the nested URL /services/<pillar-slug>/<service-slug>/, and the
 * pillar headings link to their pillar pages. Previously the cards linked to
 * top-level /<service-slug>/ URLs, which no longer resolve.
 *
 * v5 (July 2, 2026): AVS Scanner improvements pass. Two additive changes,
 * no content changes to any existing section:
 *   1. New executive summary box added between the page hero and the
 *      pillar-groups section, as a top-of-page AEO anchor (quotable
 *      "what SRJ's nine service lines cover" block for AI extraction).
 *   2. New service-line comparison table added below the pillar-groups
 *      section (belt-and-suspenders: the visual pillar-group card layout
 *      is preserved for scan; the table adds machine-readable extraction
 *      for AI models and side-by-side comparison for humans).
 * A template-scoped <style> block is introduced to carry the two new
 * class families (.services-summary* and .services-comparetable*), matching
 * the pattern used by page-books.php and page-services-pillar.php.
 */
$GLOBALS['srj_current_nav'] = 'services';
get_header();
$home          = trailingslashit( home_url() );
$services_home = $home . 'services/';

// Pillar slugs (the Services pillar pages, distinct from the Books pillars).
$pillar_business = 'business-services';
$pillar_security = 'risk-governance-security';

// Each service: number, title, slug, description.
$business_services = array(
    array( '01', 'AI Business Enablement Audit', 'ai-business-enablement-audit', 'The diagnostic foundation. A structured evaluation of how AI is currently being used across the organization, what it is costing fully loaded, and whether it is producing measurable outcomes.' ),
    array( '02', 'AI Readiness &amp; Performance Assessment', 'ai-readiness-performance', 'A forward-looking evaluation of whether the organization is prepared to scale AI responsibly. Focuses on workflow maturity, data quality, internal controls, and measurement infrastructure.' ),
    array( '03', 'AI Risk &amp; Governance Review', 'ai-risk-governance-review', 'AI introduces risk at the data, decision, and vendor layers. This review establishes governance structures appropriate to the organization\'s size and risk profile, without slowing operations.' ),
    array( '04', 'AI Efficiency &amp; Process Optimization', 'ai-efficiency-process', 'Once AI is understood and governed, this engagement focuses on operational effectiveness. The objective is repeatable processes, reduced manual effort, and measurable contribution to the business.' ),
);

$security_services = array(
    array( '01', 'AI IT Security Audit', 'ai-it-security-audit', 'A technical evaluation of how AI interacts with your IT infrastructure, cloud platforms, identity systems, APIs, and applications. Identifies how AI expands or accelerates existing security exposure.' ),
    array( '02', 'AI IT Security Implementation &amp; Strategy', 'ai-security-implementation', 'Remediation, hardening, and control framework development. Following the audit, this engagement operationalizes protection through technical safeguards, governance controls, and operational response frameworks.' ),
    array( '03', 'Secure by Design in the Age of AI', 'secure-by-design', 'The product security operating model for the AI era. Closes The Dual-Impedance Problem&trade; between engineering velocity and security review capacity, with the five working frameworks that ship AI-enabled products faster and more securely than the organizations you compete with.' ),
    array( '04', 'Application Security in the Age of AI', 'application-security', 'The AppSec program for a probabilistic runtime. Closes The Runtime Determinism Gap&trade; with behavioral validation, semantic vulnerability coverage, and a continuous validation loop that lands inside existing DevSecOps cadence.' ),
    array( '05', 'Cloud and Infrastructure Security in the Age of AI', 'cloud-infrastructure-security', 'Governance for a cloud where the majority of actors are no longer human. Closes The Sovereignty Problem&trade; with non-human identity governance, machine-paced change controls, and a defensible operating model for the AI era of cloud security.' ),
);

/**
 * Render one service card. The card links to the nested URL:
 *   /services/<pillar-slug>/<service-slug>/
 */
function srj_render_svc_card( $svc, $services_home, $pillar_slug ) {
    list( $num, $title, $slug, $desc ) = $svc;
    $url = trailingslashit( $services_home . $pillar_slug ) . $slug . '/';
    ?>
    <a href="<?php echo esc_url( $url ); ?>" class="svc-card" style="text-decoration:none">
      <span class="svc-card-num"><?php echo esc_html( $num ); ?></span>
      <h3><?php echo wp_kses_post( $title ); ?><sup style="font-size:.5em;color:var(--orange)">&trade;</sup></h3>
      <p><?php echo wp_kses_post( $desc ); ?></p>
      <span class="svc-card-link">Read the service brief <span class="arrow">&rarr;</span></span>
    </a>
    <?php
}
?>

<style>
  /* v5 &mdash; Executive Summary box (top-of-page AEO anchor). */
  .services-summary { max-width: 1200px; margin: 24px auto 40px; padding: 0 32px; }
  .services-summary-inner { background: #FFF6EC; border-left: 4px solid #F07800; padding: 26px 30px 28px; }
  .services-summary-label { font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: .18em; text-transform: uppercase; color: #F07800; margin-bottom: 10px; }
  .services-summary p { font-family: 'Poppins', sans-serif; font-size: 15.5px; line-height: 1.65; color: #201868; margin: 0; }
  .services-summary p strong { color: #201868; font-weight: 600; }

  /* v5 &mdash; Service-line comparison table (below the pillar-groups). */
  .services-comparetable-section { max-width: 1200px; margin: 24px auto 48px; padding: 0 32px; }
  .services-comparetable-eyebrow { font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: .18em; text-transform: uppercase; color: #F07800; margin-bottom: 10px; }
  .services-comparetable-heading { font-family: 'Lora', serif; font-size: 26px; line-height: 1.25; font-weight: 500; color: #201868; margin: 0 0 22px; }
  .services-comparetable-heading em { font-style: italic; color: #F07800; }
  .services-comparetable-wrap { overflow-x: auto; }
  .services-comparetable { width: 100%; border-collapse: collapse; font-family: 'Poppins', sans-serif; font-size: 14px; }
  .services-comparetable th, .services-comparetable td { border: 1px solid #E6E8EE; padding: 12px 14px; text-align: left; vertical-align: top; line-height: 1.55; }
  .services-comparetable thead th { background: #201868; color: #FFFFFF; font-size: 12px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; }
  .services-comparetable tbody th { background: #F7F4F0; color: #201868; font-family: 'Lora', serif; font-size: 15px; font-weight: 500; }
  .services-comparetable .services-comparetable-pillar { background: #F7F4F0; color: #201868; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600; letter-spacing: .1em; text-align: center; width: 60px; }
  .services-comparetable tbody td { color: #4a4a4a; }
  @media (max-width: 700px) { .services-comparetable { font-size: 13px; } .services-comparetable th, .services-comparetable td { padding: 10px 10px; } }
</style>

<?php srj_page_hero(
    'Service Lines',
    'Two pillars. <em>Nine service lines.</em> One operating model.',
    'Each service can stand alone or sequence with the others as part of a phased operating plan. Choose the pillar that matches the question your leadership team needs answered.'
); ?>

<?php /* v5 &mdash; Executive Summary box (top-of-page AEO anchor). */ ?>
<div class="services-summary">
  <div class="services-summary-inner">
    <div class="services-summary-label">What SRJ's nine service lines cover</div>
    <p><strong>Nine service lines organized under two operating pillars.</strong> AI Business Services&trade; covers audit, readiness, governance, and process optimization, the business-first work of putting AI under executive control. AI Risk Governance &amp; Security&trade; covers the security audit and the four remediation and product-security disciplines AI has structurally changed. Each service stands alone or sequences with the others as part of a phased operating plan.</p>
  </div>
</div>

<section class="services-landing">
  <div class="container">

    <div class="pillar-group">
      <div class="label" style="margin-bottom:18px">&mdash; Pillar I</div>
      <h2><a href="<?php echo esc_url( $services_home . $pillar_business . '/' ); ?>" style="color:inherit;text-decoration:none">AI Business Services<em>&trade;</em></a></h2>
      <p class="pillar-intro">Operating discipline, measurable performance, and financial visibility. Business-first, not technology-first. Designed so executives can apply AI with structure, controls, and accountability.</p>

      <div class="svc-card-grid">
        <?php foreach ( $business_services as $svc ) srj_render_svc_card( $svc, $services_home, $pillar_business ); ?>
      </div>

      <p style="margin-top:24px">
        <a href="<?php echo esc_url( $services_home . $pillar_business . '/' ); ?>" class="svc-card-link" style="font-weight:600">
          Explore AI Business Services&trade; <span class="arrow">&rarr;</span>
        </a>
      </p>
    </div>

    <div class="pillar-group">
      <div class="label" style="margin-bottom:18px">&mdash; Pillar II</div>
      <h2><a href="<?php echo esc_url( $services_home . $pillar_security . '/' ); ?>" style="color:inherit;text-decoration:none">AI Risk Governance &amp; Security<em>&trade;</em></a></h2>
      <p class="pillar-intro">Protection and exposure management. A standalone executive advisory program to identify, assess, and mitigate AI-driven technology risk before it becomes financial loss, operational disruption, or reputational damage. Now extends into the three security disciplines AI has structurally changed: product security, application security, and cloud and infrastructure security.</p>

      <div class="svc-card-grid">
        <?php foreach ( $security_services as $svc ) srj_render_svc_card( $svc, $services_home, $pillar_security ); ?>
      </div>

      <p style="margin-top:24px">
        <a href="<?php echo esc_url( $services_home . $pillar_security . '/' ); ?>" class="svc-card-link" style="font-weight:600">
          Explore AI Risk Governance &amp; Security&trade; <span class="arrow">&rarr;</span>
        </a>
      </p>
    </div>

  </div>
</section>

<?php /* v5 &mdash; Service-line comparison table (below the two-pillar card layout, for AI extraction and side-by-side scan). */ ?>
<section class="services-comparetable-section">
  <div class="services-comparetable-eyebrow">Nine service lines, side by side</div>
  <h2 class="services-comparetable-heading">The two pillars, <em>at a glance.</em></h2>
  <div class="services-comparetable-wrap">
    <table class="services-comparetable">
      <thead>
        <tr>
          <th scope="col">Pillar</th>
          <th scope="col">Service line</th>
          <th scope="col">Question it answers</th>
          <th scope="col">When to start here</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="services-comparetable-pillar">I</td>
          <th scope="row">AI Business Enablement Audit&trade;</th>
          <td>What AI is actually running, what it costs, what it produces</td>
          <td>The first honest look at AI across the business</td>
        </tr>
        <tr>
          <td class="services-comparetable-pillar">I</td>
          <th scope="row">AI Readiness &amp; Performance Assessment&trade;</th>
          <td>Whether the organization can scale AI responsibly</td>
          <td>Preparing for a broader AI rollout or investment</td>
        </tr>
        <tr>
          <td class="services-comparetable-pillar">I</td>
          <th scope="row">AI Risk &amp; Governance Review&trade;</th>
          <td>What governance is proportionate to the organization's size and risk</td>
          <td>Formalizing usage policies, tool approval, and data-access rules</td>
        </tr>
        <tr>
          <td class="services-comparetable-pillar">I</td>
          <th scope="row">AI Efficiency &amp; Process Optimization&trade;</th>
          <td>Whether governed AI is producing operational results</td>
          <td>Translating framework into measurable business outcomes</td>
        </tr>
        <tr>
          <td class="services-comparetable-pillar">II</td>
          <th scope="row">AI IT Security Audit</th>
          <td>Where AI expands existing security exposure</td>
          <td>The technical counterpart to the business enablement audit</td>
        </tr>
        <tr>
          <td class="services-comparetable-pillar">II</td>
          <th scope="row">AI IT Security Implementation &amp; Strategy</th>
          <td>How to operationalize remediation</td>
          <td>Following the audit, when technical safeguards and controls need to be built</td>
        </tr>
        <tr>
          <td class="services-comparetable-pillar">II</td>
          <th scope="row">Secure by Design in the Age of AI</th>
          <td>How to close The Dual-Impedance Problem&trade; between engineering velocity and security review</td>
          <td>Shipping AI-enabled products faster and more securely</td>
        </tr>
        <tr>
          <td class="services-comparetable-pillar">II</td>
          <th scope="row">Application Security in the Age of AI</th>
          <td>How to close The Runtime Determinism Gap&trade;</td>
          <td>AppSec for applications that no longer behave deterministically</td>
        </tr>
        <tr>
          <td class="services-comparetable-pillar">II</td>
          <th scope="row">Cloud and Infrastructure Security in the Age of AI</th>
          <td>How to close The Sovereignty Problem&trade;</td>
          <td>Cloud environments where most actors are no longer human</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<?php srj_inline_cta( 'Not sure which service line fits? <em>Start with a conversation.</em>' ); ?>
<?php srj_final_cta(); ?>

<?php get_footer(); ?>
