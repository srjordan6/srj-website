<?php
/**
 * Template Name: Service Detail
 *
 * v1.36 (June 11, 2026): shared hybrid template for all nine service detail
 * pages, replacing the nine per-page templates (page-ai-*.php and the three
 * trilogy templates). Pattern: Type-4 hybrid, like page-services-pillar.php.
 *   - Hero, aside, and CTAs are config-driven here (URL-bearing/structural).
 *   - The longform body renders from the Gutenberg editor via the_content().
 * The old per-page template files remain on the server untouched; this
 * template wins via the _wp_page_template assignment. Rollback: delete the
 * _wp_page_template meta on a page and it snaps back to its old template.
 * Aside placeholders: {{BOOKING_URL}} -> srj_get_booking(), {{HOME}} -> home_url().
 */

$SRJ_SERVICE_DETAIL = array(
    'ai-business-enablement-audit' => array(
        'kicker'   => 'AI Business Services &mdash; 01',
        'title'    => 'AI Business Enablement Audit&trade;',
        'subtitle' => 'The diagnostic foundation. A structured evaluation of how AI is currently being used across the organization, what it is costing fully loaded, and whether it is producing measurable outcomes.',
        'cta'      => 'Ready to scope this engagement? <em>Start with a conversation.</em>',
        'aside_helper' => array('business', 'ai-business-enablement-audit')
    ),
    'ai-readiness-performance' => array(
        'kicker'   => 'AI Business Services &mdash; 02',
        'title'    => 'AI Readiness &amp; Performance Assessment',
        'subtitle' => 'A forward-looking evaluation of whether the organization is prepared to scale AI responsibly. Focuses on workflow maturity, data quality, internal controls, and the measurement infrastructure needed to make AI repeatable.',
        'cta'      => 'Ready to scope this engagement? <em>Start with a conversation.</em>',
        'aside_helper' => array('business', 'ai-readiness-performance')
    ),
    'ai-risk-governance-review' => array(
        'kicker'   => 'AI Business Services &mdash; 03',
        'title'    => 'AI Risk &amp; Governance Review',
        'subtitle' => 'AI introduces risk at the data, decision, and vendor layers. This review establishes governance structures appropriate to the organization\'s size and risk profile, without slowing operations.',
        'cta'      => 'Ready to scope this engagement? <em>Start with a conversation.</em>',
        'aside_helper' => array('business', 'ai-risk-governance-review')
    ),
    'ai-efficiency-process' => array(
        'kicker'   => 'AI Business Services &mdash; 04',
        'title'    => 'AI Efficiency &amp; Process Optimization',
        'subtitle' => 'Once AI is understood and governed, this engagement focuses on operational effectiveness. The objective is repeatable processes, reduced manual effort, and measurable contribution to the business.',
        'cta'      => 'Ready to scope this engagement? <em>Start with a conversation.</em>',
        'aside_helper' => array('business', 'ai-efficiency-process')
    ),
    'ai-it-security-audit' => array(
        'kicker'   => 'AI Risk Governance &amp; Security &mdash; 01',
        'title'    => 'AI IT Security Audit&trade;',
        'subtitle' => 'A CISO-grade audit of how AI expands the security exposure your organization already carries. The audit examines AI through the six domains a Chief Information Security Officer is already accountable for &mdash; governance, security operations, architecture, application security, third-party risk, and data protection &mdash; and produces a defensible exposure map, prioritized remediation plan, and executive briefing the team can present to the board, audit committee, or regulator without translation.',
        'cta'      => 'Ready to close the AI visibility gap across all six CISO domains? <em>Start with a conversation.</em>',
        'aside_html' => <<<'SRJASIDE'
<aside class="srj-svc-aside">
        <div class="srj-svc-aside-label">Engagement at a Glance</div>
        <h3>AI IT Security Audit</h3>
        <dl>
          <dt>Format</dt>
          <dd>Virtual working sessions with one on-site executive readout, or fully on-site by request</dd>

          <dt>Deliverables</dt>
          <dd>
            <ul>
              <li>Six-domain exposure map</li>
              <li>Prioritized remediation roadmap</li>
              <li>AI-specific incident response addendum</li>
              <li>Regulatory compliance crosswalk</li>
              <li>Baseline for post-remediation measurement</li>
              <li>Executive briefing presentation</li>
            </ul>
          </dd>

          <dt>Built for</dt>
          <dd>CISOs, CIOs, CROs, General Counsel, security architects, audit committees, and boards.</dd>

          <dt>Companion book</dt>
          <dd><a href="{{HOME}}/books/ai-risk-governance-security/the-ai-it-security-audit/"><em>The AI IT Security Audit</em></a> &mdash; forthcoming Book 05 of <em>The Operating Discipline for AI</em>.</dd>
        </dl>
        <a class="btn-aside" href="{{BOOKING_URL}}" target="_blank" rel="noopener">
          Schedule a Consultation <span class="arrow">&rarr;</span>
        </a>
      </aside>
SRJASIDE
    ),
    'ai-security-implementation' => array(
        'kicker'   => 'AI Risk Governance &amp; Security &mdash; 02',
        'title'    => 'AI IT Security Implementation &amp; Strategy&trade;',
        'subtitle' => 'The buildout of AI Governance, Risk Management, and Compliance &mdash; Domain 1 of the CISO portfolio, applied to AI. Following the AI IT Security Audit, this engagement establishes the operating framework, regulatory crosswalk, board reporting cadence, and risk-transfer posture that turn the audit\'s exposure map into a defensible operating discipline. The goal is a posture leadership can present to the board, an auditor, or a regulator without translation &mdash; sustained, not one-off.',
        'cta'      => 'Ready to build the AI governance discipline your CISO portfolio requires? <em>Start with a conversation.</em>',
        'aside_html' => <<<'SRJASIDE'
<aside class="srj-svc-aside">
        <div class="srj-svc-aside-label">Engagement at a Glance</div>
        <h3>AI Governance &amp; Strategy Buildout</h3>
        <dl>
          <dt>Format</dt>
          <dd>Virtual working sessions with one on-site executive readout, or fully on-site by request</dd>

          <dt>Deliverables</dt>
          <dd>
            <ul>
              <li>AI Governance Framework (ratified)</li>
              <li>AI risk register integration</li>
              <li>Regulatory compliance crosswalk</li>
              <li>Board &amp; audit committee reporting package</li>
              <li>Budget alignment &amp; risk transfer plan</li>
              <li>Operating cadence documentation</li>
            </ul>
          </dd>

          <dt>Built for</dt>
          <dd>CISOs, CROs, Chief Legal Officers, Chief Compliance Officers, audit committees, and boards.</dd>

          <dt>Companion book</dt>
          <dd><a href="{{HOME}}/books/ai-risk-governance-security/the-ai-it-security-implementation-strategy/"><em>The AI IT Security Implementation &amp; Strategy</em></a> &mdash; forthcoming Book 06 of <em>The Operating Discipline for AI</em>.</dd>
        </dl>
        <a class="btn-aside" href="{{BOOKING_URL}}" target="_blank" rel="noopener">
          Schedule a Consultation <span class="arrow">&rarr;</span>
        </a>
      </aside>
SRJASIDE
    ),
    'secure-by-design' => array(
        'kicker'   => 'AI Risk Governance &amp; Security &mdash; 03',
        'title'    => 'Secure by Design in the Age of AI&trade;',
        'subtitle' => 'Secure by Design has changed from a compliance posture into a capacity problem. Engineering velocity has increased by an order of magnitude. Security review capacity has not. At the same time, AI introduces a class of vulnerabilities that traditional, deterministic tools are structurally unable to detect. Most organizations are quietly shipping AI-enabled products faster than they can reasonably secure them, and learning about the gap from customers, regulators, or breach disclosures. This engagement closes it.',
        'cta'      => 'Ready to close The Dual-Impedance Problem&trade;? <em>Start with a conversation.</em>',
        'aside_html' => <<<'SRJASIDE'
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
          <dd><a href="{{HOME}}/books/ai-risk-governance-security/the-secure-by-design/"><em>Secure by Design in the Age of AI</em></a> &mdash; forthcoming Volume 1 of the <em>Security in the Age of AI</em> trilogy.</dd>
        </dl>
        <a class="btn-aside" href="{{BOOKING_URL}}" target="_blank" rel="noopener">
          Schedule a Consultation <span class="arrow">&rarr;</span>
        </a>
      </aside>
SRJASIDE
    ),
    'application-security' => array(
        'kicker'   => 'AI Risk Governance &amp; Security &mdash; 04',
        'title'    => 'Application Security in the Age of AI&trade;',
        'subtitle' => 'AI Application Security needs a reset. Every application security tool in production today was built on a quiet assumption: that an application produces the same output for the same input. AI features have invalidated that assumption, and most AppSec programs do not yet realize it. SAST, DAST, WAFs, penetration tests, bug bounties: each sees a fraction of the actual behavior of an AI-enabled application, and misses the rest. This engagement closes the gap.',
        'cta'      => 'Ready to close The Runtime Determinism Gap&trade;? <em>Start with a conversation.</em>',
        'aside_html' => <<<'SRJASIDE'
<aside class="srj-svc-aside">
        <div class="srj-svc-aside-label">Engagement at a Glance</div>
        <h3>AppSec Program Assessment</h3>
        <dl>
          <dt>Format</dt>
          <dd>Virtual working sessions with one on-site executive readout, or fully on-site by request</dd>

          <dt>Deliverables</dt>
          <dd>
            <ul>
              <li>AppSec Program Maturity Assessment</li>
              <li>Behavioral Attack Surface map</li>
              <li>Continuous Validation Loop reference architecture</li>
              <li>90-day pipeline integration plan</li>
              <li>Executive briefing presentation</li>
            </ul>
          </dd>

          <dt>Built for</dt>
          <dd>AppSec leaders, security architects, senior developers, DevSecOps and platform engineers, CISOs</dd>

          <dt>Companion book</dt>
          <dd><a href="{{HOME}}/books/ai-risk-governance-security/the-application-security/"><em>Application Security in the Age of AI</em></a> &mdash; forthcoming Volume 2 of the <em>Security in the Age of AI</em> trilogy.</dd>
        </dl>
        <a class="btn-aside" href="{{BOOKING_URL}}" target="_blank" rel="noopener">
          Schedule a Consultation <span class="arrow">&rarr;</span>
        </a>
      </aside>
SRJASIDE
    ),
    'cloud-infrastructure-security' => array(
        'kicker'   => 'AI Risk Governance &amp; Security &mdash; 05',
        'title'    => 'Cloud and Infrastructure Security in the Age of AI&trade;',
        'subtitle' => 'AI cloud security is operating on a broken assumption. Cloud security was built on a single premise: that every meaningful action could be traced to an accountable human. AI has broken that premise in three places at once: non-human identities now outnumber human ones by an order of magnitude, infrastructure changes happen at machine pace while approval and audit operate at human pace, and the audit chain no longer cleanly answers <em>who did this, on whose behalf, with what authorization.</em> The cloud security stack has not caught up. This engagement is the path to catching up.',
        'cta'      => 'Ready to close The Sovereignty Problem&trade;? <em>Start with a conversation.</em>',
        'aside_html' => <<<'SRJASIDE'
<aside class="srj-svc-aside">
        <div class="srj-svc-aside-label">Engagement at a Glance</div>
        <h3>Cloud Security Program Assessment</h3>
        <dl>
          <dt>Format</dt>
          <dd>Virtual working sessions with one on-site executive readout, or fully on-site by request</dd>

          <dt>Deliverables</dt>
          <dd>
            <ul>
              <li>Cloud Sovereignty Score&trade; maturity assessment</li>
              <li>Non-Human Identity Audit</li>
              <li>Agent Permission Policy Library</li>
              <li>Defensive Architecture Pattern Library</li>
              <li>Executive briefing presentation</li>
            </ul>
          </dd>

          <dt>Built for</dt>
          <dd>Cloud security architects, platform engineering leaders, IAM teams, CISOs with significant cloud footprint, audit and compliance leaders</dd>

          <dt>Companion book</dt>
          <dd><a href="{{HOME}}/books/ai-risk-governance-security/the-cloud-infrastructure-security/"><em>Cloud and Infrastructure Security in the Age of AI</em></a> &mdash; forthcoming Volume 3 of the <em>Security in the Age of AI</em> trilogy.</dd>
        </dl>
        <a class="btn-aside" href="{{BOOKING_URL}}" target="_blank" rel="noopener">
          Schedule a Consultation <span class="arrow">&rarr;</span>
        </a>
      </aside>
SRJASIDE
    )
);

$GLOBALS['srj_current_nav'] = 'services';
get_header();

$srj_slug = get_post_field( 'post_name' );
$svc = isset( $SRJ_SERVICE_DETAIL[ $srj_slug ] ) ? $SRJ_SERVICE_DETAIL[ $srj_slug ] : null;

if ( $svc ) {
    srj_page_hero( $svc['kicker'], $svc['title'], $svc['subtitle'] );
}
?>

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

  /* Domain block heading — H3 within the .longform body. */
  .longform .ciso-domain {
    font-family: 'Lora', serif; font-size: 22px; line-height: 1.3;
    font-weight: 500; color: var(--navy, #201868);
    margin: 36px 0 14px;
  }
  .longform .ciso-examines {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .18em; text-transform: uppercase;
    color: var(--orange, #F07800);
    margin: 18px 0 8px;
  }

  /* Buildout block heading — H3 within the .longform body. */
  .longform .ciso-domain {
    font-family: 'Lora', serif; font-size: 22px; line-height: 1.3;
    font-weight: 500; color: var(--navy, #201868);
    margin: 36px 0 14px;
  }
  .longform .ciso-builds {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .18em; text-transform: uppercase;
    color: var(--orange, #F07800);
    margin: 18px 0 8px;
  }
</style>

<section class="service-detail">
  <div class="container">
    <div class="service-detail-grid">
      <div class="longform" style="padding:0;background:transparent;border:none">
        <?php
        while ( have_posts() ) {
            the_post();
            the_content();
        }
        ?>
      </div>
      <?php
      if ( $svc ) {
          if ( ! empty( $svc['aside_html'] ) ) {
              echo strtr( $svc['aside_html'], array(
                  '{{BOOKING_URL}}' => esc_url( srj_get_booking() ),
                  '{{HOME}}'        => esc_url( untrailingslashit( home_url() ) ),
              ) );
          } elseif ( ! empty( $svc['aside_helper'] ) && function_exists( 'srj_render_service_aside' ) ) {
              srj_render_service_aside( $svc['aside_helper'][0], $svc['aside_helper'][1] );
          }
      }
      ?>
    </div>
  </div>
</section>

<?php if ( $svc && ! empty( $svc['cta'] ) ) { srj_inline_cta( $svc['cta'] ); } ?>
<?php srj_final_cta(); ?>

<?php get_footer(); ?>
