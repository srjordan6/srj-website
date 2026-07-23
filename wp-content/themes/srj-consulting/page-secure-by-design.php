<?php
/**
 * Template Name: Secure by Design in the Age of AI
 *
 * Service Detail Page Template: Secure by Design in the Age of AI
 * Slug: secure-by-design
 *
 * v1.28 (June 11, 2026): new service detail page. Part of the "Security in
 * the Age of AI" series of consulting engagements. Companion book is the
 * forthcoming Volume 1 at /books/ai-risk-governance-security/the-secure-by-design/.
 *
 * Hero label uses local pillar numbering (03 = third service in the Risk
 * Governance & Security pillar), matching the existing audit (01) and
 * implementation (02) detail pages.
 */
$GLOBALS['srj_current_nav'] = 'services';
get_header();
?>

<?php srj_page_hero(
    'AI Risk Governance &amp; Security &mdash; 03',
    'Secure by Design in the Age of AI&trade;',
    'Secure by Design has changed from a compliance posture into a capacity problem. Engineering velocity has increased by an order of magnitude. Security review capacity has not. At the same time, AI introduces a class of vulnerabilities that traditional, deterministic tools are structurally unable to detect. Most organizations are quietly shipping AI-enabled products faster than they can reasonably secure them, and learning about the gap from customers, regulators, or breach disclosures. This engagement closes it.'
); ?>

<style>
  .srj-svc-aside {
    background: var(--paper, #FAFAFA);
    border: 1px solid var(--gray-light, #E8ECF1);
    padding: 32px 30px;
    font-family: 'Poppins', sans-serif;
  }
  .srj-svc-aside-label {
    font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase;
    color: var(--orange, #F07800);
    margin-bottom: 18px;
  }
  .srj-svc-aside h3 {
    font-family: 'Lora', serif; font-size: 22px; line-height: 1.25;
    font-weight: 500; color: var(--navy, #201868);
    margin: 0 0 22px;
  }
  .srj-svc-aside dl { margin: 0 0 28px; }
  .srj-svc-aside dt {
    font-size: 11px; font-weight: 600;
    letter-spacing: .14em; text-transform: uppercase;
    color: var(--navy, #201868);
    margin-bottom: 4px;
  }
  .srj-svc-aside dd {
    font-size: 14.5px; line-height: 1.55;
    color: var(--ink, #1A1A2E);
    margin: 0 0 18px;
  }
  .srj-svc-aside dd:last-child { margin-bottom: 0; }
  .srj-svc-aside ul {
    margin: 0; padding-left: 18px;
    font-size: 14.5px; line-height: 1.55;
    color: var(--ink, #1A1A2E);
  }
  .srj-svc-aside ul li { margin-bottom: 6px; }
  .srj-svc-aside .btn-aside {
    display: inline-flex; align-items: center; gap: 10px;
    width: 100%; justify-content: center;
    padding: 14px 22px; background: var(--navy, #201868); color: #FFFFFF;
    font-size: 12.5px; font-weight: 600;
    letter-spacing: .1em; text-transform: uppercase;
    text-decoration: none; transition: background .25s ease;
  }
  .srj-svc-aside .btn-aside:hover { background: #150f47; color: #FFFFFF; }
  .srj-svc-aside .btn-aside .arrow { transition: transform .2s ease; }
  .srj-svc-aside .btn-aside:hover .arrow { transform: translateX(3px); }
</style>

<section class="service-detail">
  <div class="container">
    <div class="service-detail-grid">

      <div class="longform" style="padding:0;background:transparent;border:none">

        <h2>The Dual-Impedance Problem &mdash; Why Secure by Design Now Means Capacity, Not Compliance</h2>
        <p>AI has changed product security from a quality function into a capacity problem. Two forces compound at once: a widening velocity gap between how fast products are built and how fast they can be reasonably secured, layered on a fundamental shift from deterministic to probabilistic risk. The engagement names this combined condition The Dual-Impedance Problem&trade; and treats it as the strategic context every AI-enabled product organization now operates inside.</p>
        <p>Organizations that solve it use AI to close the security capacity gap <em>and</em> build structural boundaries around AI's new failure modes. Organizations that do not ship faster, accumulate undetected risk, and learn about it from the outside.</p>

        <h2>What the Secure by Design Engagement Covers</h2>
        <p>The Secure by Design engagement is a defensible review of how AI-enabled products are designed, built, shipped, and operated inside the organization. It is anchored on the <a href="https://www.cisa.gov/securebydesign" target="_blank" rel="noopener">CISA Secure by Design program</a> and aligned with <a href="https://owasp.org/www-project-top-10-for-large-language-model-applications/" target="_blank" rel="noopener">OWASP LLM Top 10</a>, NIST SSDF, and emerging AI regulation. It is conducted against five working frameworks introduced in the forthcoming book of the same name:</p>
        <ul>
          <li><strong>The Product Attack Surface Taxonomy&trade;</strong> &mdash; where product risk lives across seven layers, extended to include AI-native components: language inputs, retrieval paths, output renderers, agent boundaries, model artifacts, prompt libraries, and embedding stores.</li>
          <li><strong>The AI-Caused Vulnerability Model&trade;</strong> &mdash; the seven sources of AI-introduced risk, scored against the organization's actual product stack.</li>
          <li><strong>The Action Boundary Model&trade;</strong> &mdash; a four-tier classification of what an AI system may <em>read</em>, <em>decide</em>, <em>recommend</em>, and <em>execute</em>, applied to every agent and AI feature in production.</li>
          <li><strong>The AI Product Security Lifecycle&trade;</strong> &mdash; the integrated operating model that merges existing SDLC and DevSecOps activities with AI-specific controls, phase by phase.</li>
          <li><strong>The Secure AI Release Gate&trade;</strong> &mdash; the release-readiness artifact and Product Security Evidence File that consolidates threat model, output validation, prompt injection coverage, agent boundary documentation, model provenance, and incident response readiness.</li>
        </ul>

        <div class="pull">The engagement produces decisions <em>defensible to a board, an auditor, or a regulator.</em></div>

        <h2>What You Get From the Secure by Design Assessment</h2>
        <ul>
          <li>A scored AI Product Security Maturity Assessment across the eight lifecycle phases (Assess, Architect, Design, Develop, Test, Ship, Operate, Improve), with evidence and remediation guidance for each.</li>
          <li>A Product Security Evidence File template, populated for at least one in-flight AI feature so the team has a worked example, not a blank form.</li>
          <li>A one-page RACI for AI product decisions &mdash; who approves AI features, who approves models, who approves data use, who accepts risk through exceptions, who responds to AI-caused incidents.</li>
          <li>A 90-day remediation roadmap sequenced into three thirty-day phases, executable without additional headcount.</li>
          <li>An executive briefing presentation, board-ready, defensible against regulator and customer scrutiny.</li>
        </ul>

        <h2>Who the Secure by Design Engagement Is For</h2>
        <p>CISOs, CTOs, VPs of Engineering and Product, security architects, board members, and compliance officers in organizations shipping AI-enabled products to enterprise customers or regulated industries. Mid-market through large multinational. No technical background required for the executive deliverables; engineering-grade depth available for the architects and senior engineers who will own the implementation.</p>

        <h2>Why Secure by Design, Now</h2>
        <p>CISA's Secure by Design program is reshaping procurement expectations. Enterprise customers are adding AI vendor risk to their questionnaires. Regulators are converging on evidence-based release criteria. The window for organizations to get ahead of this curve is roughly eighteen to twenty-four months. Engagements scheduled in that window establish the operating discipline before it becomes a compliance scramble.</p>

      </div>

      <?php /* Engagement at a Glance &mdash; inline aside (srj_render_service_aside not used; see v1.28 changelog) */ ?>
      <aside class="srj-svc-aside">
        <div class="srj-svc-aside-label">Engagement at a Glance</div>
        <h3>Secure by Design Assessment</h3>
        <dl>
          <dt>Format</dt>
          <dd>Virtual working sessions with one on-site executive readout, or fully on-site by request</dd>

          <dt>Deliverables</dt>
          <dd>
            <ul>
              <li>AI Product Security Maturity Assessment</li>
              <li>Product Security Evidence File</li>
              <li>RACI for AI product decisions</li>
              <li>90-day remediation roadmap</li>
              <li>Executive briefing presentation</li>
            </ul>
          </dd>

          <dt>Built for</dt>
          <dd>CISOs, CTOs, VPs Engineering &amp; Product, security architects, boards and audit committees</dd>

          <dt>Companion book</dt>
          <dd><a href="<?php echo esc_url( home_url( '/books/ai-risk-governance-security/the-secure-by-design/' ) ); ?>"><em>Secure by Design in the Age of AI</em></a> &mdash; forthcoming Volume 1 of the <em>Security in the Age of AI</em> trilogy.</dd>
        </dl>
        <a class="btn-aside" href="<?php echo esc_url( srj_get_booking() ); ?>" target="_blank" rel="noopener">
          Schedule a Consultation <span class="arrow">&rarr;</span>
        </a>
      </aside>

    </div>
  </div>
</section>

<?php srj_inline_cta( 'Ready to close The Dual-Impedance Problem&trade;? <em>Start with a conversation.</em>' ); ?>
<?php srj_final_cta(); ?>

<?php get_footer(); ?>
