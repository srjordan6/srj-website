<?php
/**
 * Template Name: Services Pillar
 *
 * Reusable pillar page for the Services section. One template renders either
 * services pillar, driven by the $SRJ_SVC_PILLARS config below, keyed by
 * page slug.
 *
 * URL pattern: /services/<pillar-slug>/
 *   /services/business-services/        — Pillar I (4 services)
 *   /services/risk-governance-security/ — Pillar II (2 services)
 *
 * Each card links to an individual service-detail page, which lives one
 * level deeper at /services/<pillar-slug>/<service-slug>/. The service
 * detail pages keep their existing `page-{slug}.php` templates — WordPress
 * matches those by slug regardless of parent, so re-parenting the service
 * pages under a pillar does not change which template renders them.
 *
 * To deploy:
 *   1. SFTP this file to /wp-content/themes/srj-consulting/
 *   2. Ensure the "Services" page exists (slug: services).
 *   3. Create the pillar Page, parent = Services, slug = ai-business-services
 *      (or ai-risk-governance-security), Template = "Services Pillar".
 *
 * SEO note: meta title/description and any schema are set in Rank Math
 * (the single source of meta + schema on this site). This template outputs
 * no meta tags and no entity schema.
 *
 * @package SRJ_Consulting
 */

get_header();

/* =========================================================================
   SERVICES PILLAR CONFIG — keyed by WordPress page slug.
   Each service 'slug' must match the existing service-detail page slug.
   ========================================================================= */
$SRJ_SVC_PILLARS = array(

  'business-services' => array(
    'tag'      => 'Pillar I',
    'name'     => 'AI Business Services',         // &trade; appended in markup
    'eyebrow'  => 'SRJ Consulting & Services',
    'headline' => 'Operating discipline, measurable performance, financial visibility.',
    'intro'    => 'AI Business Services&trade; is the business-first half of the SRJ practice. It treats AI not as an engineering question but as a matter of executive control — the operating structure, financial visibility, and accountability a leadership team needs to apply AI with discipline. Four service lines take an organization from its first honest audit through full operating maturity.',
    'services' => array(
      array(
        'num' => 'Service 01', 'title' => 'AI Business Enablement Audit',
        'slug' => 'ai-business-enablement-audit',
        'summary' => 'The diagnostic foundation. A structured evaluation of how AI is currently used across the business, what it costs fully loaded, and whether it is producing measurable outcomes.',
      ),
      array(
        'num' => 'Service 02', 'title' => 'AI Readiness & Performance Assessment',
        'slug' => 'ai-readiness-performance',
        'summary' => 'A forward-looking assessment of whether the organization is prepared to scale AI responsibly — workflow maturity, data quality, internal controls, and performance measurement.',
      ),
      array(
        'num' => 'Service 03', 'title' => 'AI Risk & Governance Review',
        'slug' => 'ai-risk-governance-review',
        'summary' => 'Establishes governance structures proportionate to the organization\'s size and risk — usage policies, tool-approval processes, and data-access protocols — without slowing the work.',
      ),
      array(
        'num' => 'Service 04', 'title' => 'AI Efficiency & Process Optimization',
        'slug' => 'ai-efficiency-process',
        'summary' => 'Turns governed AI into operational results — repeatable processes, reduced manual rework, and labor savings that are genuinely captured and redirected to higher-value work.',
      ),
    ),
  ),

  'risk-governance-security' => array(
    'tag'      => 'Pillar II',
    'name'     => 'AI Risk Governance & Security',
    'eyebrow'  => 'SRJ Consulting & Services',
    'headline' => 'Identifying AI risk before it becomes loss.',
    'intro'    => 'AI Risk Governance &amp; Security&trade; is the protective half of the SRJ practice — a standalone executive program to identify, assess, and mitigate AI-driven technology risk at the data, decision, and vendor layers before it becomes financial loss, operational disruption, or reputational damage. Five service lines move from technical assessment of the AI attack surface and the remediation frameworks that operationalize protection, through the three security disciplines that AI has structurally changed: product security (Secure by Design), application security, and cloud and infrastructure security.',
    'services' => array(
      array(
        'num' => 'Service 05', 'title' => 'AI IT Security Audit',
        'slug' => 'ai-it-security-audit',
        'summary' => 'A technical evaluation of how AI interacts with IT infrastructure, cloud platforms, identity systems, APIs, and applications — identifying where AI expands the security exposure already present.',
      ),
      array(
        'num' => 'Service 06', 'title' => 'AI IT Security Implementation & Strategy',
        'slug' => 'ai-security-implementation',
        'summary' => 'The implementation counterpart to the security audit — technical safeguards, governance controls, and operational response frameworks that operationalize protection.',
      ),
      array(
        'num' => 'Service 07', 'title' => 'Secure by Design in the Age of AI',
        'slug' => 'secure-by-design',
        'summary' => 'A defensible review of how AI-enabled products are designed, built, shipped, and operated — closing The Dual-Impedance Problem&trade; between engineering velocity and security review capacity, with the operating model that ships AI products faster and more securely.',
      ),
      array(
        'num' => 'Service 08', 'title' => 'Application Security in the Age of AI',
        'slug' => 'application-security',
        'summary' => 'A defensible AppSec program review for applications that no longer behave deterministically — closing The Runtime Determinism Gap&trade; with behavioral validation, semantic vulnerability coverage, and the program model that lands inside existing DevSecOps cadence.',
      ),
      array(
        'num' => 'Service 09', 'title' => 'Cloud and Infrastructure Security in the Age of AI',
        'slug' => 'cloud-infrastructure-security',
        'summary' => 'A defensible cloud security program review for environments where the majority of actors are no longer human — closing The Sovereignty Problem&trade; with non-human identity governance, machine-paced change controls, and the operating model that catches up to the AI era.',
      ),
    ),
  ),
);

// Select the pillar by current page slug.
$srj_slug      = get_post_field( 'post_name', get_queried_object_id() );
$pillar        = isset( $SRJ_SVC_PILLARS[ $srj_slug ] ) ? $SRJ_SVC_PILLARS[ $srj_slug ] : null;
$services_home = home_url( '/services/' );
?>

<style>
  :root {
    --navy: #201868; --orange: #F07800; --white: #FFFFFF;
    --paper: #FAFAFA; --gray: #7A8A9E; --gray-light: #E8ECF1;
    --gray-fill: #F5F5F7; --ink: #1A1A2E;
  }
  .svc-pillar-page { background: var(--white); color: var(--ink); }
  .svc-pillar-page .container { max-width: 1200px; margin: 0 auto; padding: 0 32px; }

  /* HERO */
  .svc-pillar-hero { padding: 88px 0 56px; border-bottom: 1px solid var(--gray-light); }
  .svc-pillar-hero .eyebrow {
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: .18em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 22px;
  }
  .svc-pillar-hero .tag {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--gray);
    margin-bottom: 14px;
  }
  .svc-pillar-hero h1 {
    font-family: 'Lora', serif; font-size: 46px; line-height: 1.1;
    font-weight: 500; color: var(--navy); margin: 0 0 14px; max-width: 860px;
  }
  .svc-pillar-hero .pillar-name {
    font-family: 'Lora', serif; font-size: 21px; font-weight: 500;
    color: var(--navy); margin: 0 0 24px;
  }
  .svc-pillar-hero .intro {
    font-family: 'Poppins', sans-serif; font-size: 17px; line-height: 1.65;
    color: var(--ink); max-width: 760px; margin: 0;
  }

  /* EDITABLE CONTENT ZONE (Gutenberg) */
  .svc-pillar-content { padding: 64px 0 8px; }
  .svc-pillar-content .container > * { max-width: 820px; }
  .svc-pillar-content h2 {
    font-family: 'Lora', serif; font-size: 32px; line-height: 1.2;
    font-weight: 500; color: var(--navy); margin: 48px 0 16px;
  }
  .svc-pillar-content h2:first-child { margin-top: 0; }
  .svc-pillar-content h3 {
    font-family: 'Lora', serif; font-size: 23px; line-height: 1.25;
    font-weight: 500; color: var(--navy); margin: 32px 0 12px;
  }
  .svc-pillar-content p {
    font-family: 'Poppins', sans-serif; font-size: 17px; line-height: 1.7;
    color: var(--ink); margin: 0 0 18px;
  }
  .svc-pillar-content ul, .svc-pillar-content ol {
    font-family: 'Poppins', sans-serif; font-size: 17px; line-height: 1.7;
    color: var(--ink); margin: 0 0 18px; padding-left: 24px;
  }
  .svc-pillar-content li { margin-bottom: 8px; }
  .svc-pillar-content a { color: var(--orange); }

  /* SERVICES LIST */
  .svc-pillar-list { padding: 56px 0 16px; }
  .svc-pillar-list .section-label {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--navy);
    margin-bottom: 26px;
  }
  .svc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
  @media (max-width: 820px) { .svc-grid { grid-template-columns: 1fr; } }

  .svc-card {
    position: relative; display: flex; flex-direction: column;
    background: var(--white); padding: 38px 34px 32px;
    border: 1px solid var(--gray-light); text-decoration: none; color: var(--ink);
    transition: border-color .25s ease, transform .25s ease, box-shadow .25s ease;
  }
  .svc-card::before, .svc-card::after {
    content: ''; position: absolute; width: 20px; height: 20px;
    border: 2px solid var(--navy);
  }
  .svc-card::before { top: -1px; left: -1px; border-right: 0; border-bottom: 0; }
  .svc-card::after  { bottom: -1px; right: -1px; border-left: 0; border-top: 0; }
  .svc-card:hover {
    border-color: var(--orange); transform: translateY(-2px);
    box-shadow: 0 10px 28px -12px rgba(32,24,104,.18); color: var(--ink);
  }
  .svc-card .sc-num {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 12px;
  }
  .svc-card h3 {
    font-family: 'Lora', serif; font-size: 25px; line-height: 1.25;
    font-weight: 500; color: var(--navy); margin: 0 0 14px;
  }
  .svc-card .sc-summary {
    font-family: 'Poppins', sans-serif; font-size: 14.5px; line-height: 1.6;
    color: var(--ink); margin: 0 0 24px;
  }
  .svc-card .sc-cta {
    margin-top: auto;
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: .08em; text-transform: uppercase; color: var(--navy);
  }
  .svc-card:hover .sc-cta { color: var(--orange); }
  .svc-card .sc-cta .arrow { transition: transform .2s ease; display: inline-block; }
  .svc-card:hover .sc-cta .arrow { transform: translateX(3px); }

  /* CTA */
  .svc-pillar-cta { padding: 88px 0; background: var(--paper); margin-top: 64px;
    border-top: 1px solid var(--gray-light); border-bottom: 1px solid var(--gray-light); }
  .svc-pillar-cta .label {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 18px;
  }
  .svc-pillar-cta h2 {
    font-family: 'Lora', serif; font-size: 38px; line-height: 1.15;
    font-weight: 500; color: var(--navy); margin: 0 0 20px; max-width: 680px;
  }
  .svc-pillar-cta h2 em { font-style: italic; color: var(--orange); }
  .svc-pillar-cta p {
    font-family: 'Poppins', sans-serif; font-size: 16px; line-height: 1.6;
    color: var(--ink); margin: 0 0 32px; max-width: 620px;
  }
  .svc-pillar-cta .cta-buttons { display: flex; gap: 16px; flex-wrap: wrap; }
  .btn-primary {
    display: inline-flex; align-items: center; gap: 10px;
    padding: 15px 28px; background: var(--navy); color: var(--white);
    font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600;
    letter-spacing: .1em; text-transform: uppercase;
    text-decoration: none; transition: background .25s ease;
  }
  .btn-primary:hover { background: #150f47; color: var(--white); }
  .btn-secondary {
    display: inline-flex; align-items: center; gap: 10px;
    padding: 15px 28px; background: transparent; color: var(--navy);
    font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600;
    letter-spacing: .1em; text-transform: uppercase;
    border: 1px solid var(--navy); text-decoration: none; transition: all .25s ease;
  }
  .btn-secondary:hover { background: var(--navy); color: var(--white); }

  @media (max-width: 720px) {
    .svc-pillar-hero h1 { font-size: 32px; }
    .svc-pillar-cta h2 { font-size: 28px; }
  }
</style>

<main class="svc-pillar-page">

  <?php if ( $pillar ) : ?>

  <!-- HERO -->
  <section class="svc-pillar-hero">
    <div class="container">
      <?php if ( function_exists( 'srj_breadcrumbs' ) ) { srj_breadcrumbs(); } ?>
      <div class="eyebrow"><?php echo esc_html( $pillar['eyebrow'] ); ?></div>
      <div class="tag"><?php echo esc_html( $pillar['tag'] ); ?></div>
      <h1><?php echo esc_html( $pillar['headline'] ); ?></h1>
      <p class="pillar-name"><?php echo wp_kses_post( $pillar['name'] ); ?>&trade;</p>
      <p class="intro"><?php echo wp_kses_post( $pillar['intro'] ); ?></p>
    </div>
  </section>

  <?php
  /* ===== EDITABLE CONTENT ZONE (Gutenberg) =====
     Everything typed into the WordPress block editor for this page renders
     here, between the hero and the service-line cards. This is the
     hybrid model: prose sections are editable in WordPress; the service
     cards below remain template-generated so their nested URLs stay correct.
     If the editor body is empty, this section outputs nothing. */
  if ( trim( get_the_content() ) !== '' ) :
  ?>
  <section class="svc-pillar-content">
    <div class="container">
      <?php
      while ( have_posts() ) :
        the_post();
        the_content();
      endwhile;
      ?>
    </div>
  </section>
  <?php endif; ?>

  <!-- SERVICES -->
  <section class="svc-pillar-list">
    <div class="container">
      <div class="section-label">Service lines in this pillar</div>
      <div class="svc-grid">
        <?php foreach ( $pillar['services'] as $s ) :
          $service_url = trailingslashit( $services_home . $srj_slug ) . $s['slug'] . '/';
        ?>
        <a class="svc-card" href="<?php echo esc_url( $service_url ); ?>">
          <div class="sc-num"><?php echo esc_html( $s['num'] ); ?></div>
          <h3><?php echo wp_kses_post( $s['title'] ); ?>&trade;</h3>
          <p class="sc-summary"><?php echo wp_kses_post( $s['summary'] ); ?></p>
          <span class="sc-cta">Read the service brief <span class="arrow">&rarr;</span></span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="svc-pillar-cta">
    <div class="container">
      <div class="label">SRJ Consulting &amp; Services</div>
      <h2>Bring AI under <em>operating control.</em></h2>
      <p>Every engagement begins with a conversation about where AI actually stands in your business. Browse all services, or schedule a consultation directly.</p>
      <div class="cta-buttons">
        <a class="btn-primary" href="<?php echo esc_url( $services_home ); ?>">
          All Services <span class="arrow">&rarr;</span>
        </a>
        <a class="btn-secondary" href="<?php echo esc_url( srj_get_calendly() ); ?>" target="_blank" rel="noopener">
          Schedule a Consultation
        </a>
      </div>
    </div>
  </section>

  <?php else : ?>
  <section class="svc-pillar-hero">
    <div class="container">
      <?php if ( function_exists( 'srj_breadcrumbs' ) ) { srj_breadcrumbs(); } ?>
      <h1><?php the_title(); ?></h1>
      <p class="intro">This pillar page is being prepared.</p>
    </div>
  </section>
  <?php endif; ?>

</main>

<?php
get_footer();
