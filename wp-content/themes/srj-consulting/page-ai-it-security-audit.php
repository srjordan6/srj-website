<?php
/**
 * Template Name: AI IT Security Audit
 *
 * Service Detail Page Template: AI IT Security Audit
 * Slug: ai-it-security-audit
 *
 * v1.29 (June 11, 2026): full rebuild from the original Type-1 hardcoded
 * page. Content restructured around the six CISO domains (Governance & Risk
 * Management, SecOps, Architecture & Engineering, Application & Product
 * Security, Third-Party & Supply Chain Risk, Data Protection & Privacy)
 * so the page reads against the actual operating structure of a CISO portfolio.
 * SEO authority externals added (SEC, NIST AI RMF, NIST SP 800-207, OWASP LLM
 * Top 10). Regulatory crosswalk added to deliverables. "Why now" closing
 * section added. Inline aside (no srj_render_service_aside dependency).
 *
 * The pre-v1.29 file should be retained on the server as
 * `page-ai-it-security-audit.php.pre-v129.bak` per Convention #7.
 */
$GLOBALS['srj_current_nav'] = 'services';
get_header();
?>

<?php srj_page_hero(
    'AI Risk Governance &amp; Security &mdash; 01',
    'AI IT Security Audit&trade;',
    'A CISO-grade audit of how AI expands the security exposure your organization already carries. The audit examines AI through the six domains a Chief Information Security Officer is already accountable for &mdash; governance, security operations, architecture, application security, third-party risk, and data protection &mdash; and produces a defensible exposure map, prioritized remediation plan, and executive briefing the team can present to the board, audit committee, or regulator without translation.'
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
</style>

<section class="service-detail">
  <div class="container">
    <div class="service-detail-grid">

      <div class="longform" style="padding:0;background:transparent;border:none">

        <h2>Why the AI IT Security Audit exists</h2>
        <p>AI does not invent new attack surfaces from scratch. It accelerates existing ones, lowers the cost of attacks that used to require expertise, and introduces a class of vulnerability &mdash; prompt injection, model poisoning, training data exposure, agent privilege escalation &mdash; that traditional security tooling does not detect. The result is a posture that looks healthy on every existing dashboard while the actual exposure profile of the business drifts somewhere the program cannot see.</p>
        <p>The AI IT Security Audit closes that visibility gap. It is conducted against the six core domains every CISO is responsible for, with an AI-specific lens applied to each. The output is technical clarity, exposure identification, and a prioritized remediation roadmap &mdash; sized to the organization, defensible to a board, an auditor, or a regulator.</p>

        <h2>The six domains the audit covers</h2>
        <p>The audit follows the operating structure of a modern CISO portfolio. Each domain receives the same treatment: assessment against current maturity, identification of AI-introduced exposure, and remediation recommendations aligned to the organization's risk appetite and budget envelope.</p>

        <h3 class="ciso-domain">1. Security Governance &amp; Risk Management</h3>
        <p>Where AI fits inside the broader cybersecurity strategy and risk register. The audit examines whether AI usage is captured in board-level reporting, whether AI-specific risks are reflected in the risk appetite statement, and whether the cybersecurity budget is allocated against AI exposure rather than against last year's threat model. Regulatory compliance is treated as an integrated thread &mdash; SEC cybersecurity disclosure rules, GDPR, HIPAA, state-level AI legislation, and emerging industry frameworks &mdash; not a separate workstream.</p>
        <div class="ciso-examines">What gets examined</div>
        <ul>
          <li>AI exposure in the enterprise risk register and board reporting cadence</li>
          <li>Cybersecurity budget alignment against AI-related risk</li>
          <li>Insurance and risk-transfer posture for AI-specific incidents</li>
          <li>Regulatory crosswalk against <a href="https://www.sec.gov/news/press-release/2023-139" target="_blank" rel="noopener">SEC cybersecurity disclosure rules</a>, GDPR, HIPAA, and state-level AI legislation</li>
          <li>Alignment to the <a href="https://www.nist.gov/itl/ai-risk-management-framework" target="_blank" rel="noopener">NIST AI Risk Management Framework</a> and applicable industry frameworks</li>
        </ul>

        <h3 class="ciso-domain">2. Security Operations (SecOps)</h3>
        <p>How the Security Operations Center handles AI-amplified threats and AI-native incidents. The audit reviews SOC tooling for coverage of AI-enabled phishing, deepfake-enabled social engineering, prompt injection attacks, AI-amplified ransomware targeting, and AI-driven reconnaissance. Threat intelligence sources are assessed for AI-specific coverage, and incident response playbooks are evaluated against AI scenarios the existing IR plan does not contemplate.</p>
        <div class="ciso-examines">What gets examined</div>
        <ul>
          <li>SOC detection coverage for AI-enabled phishing and deepfake-enabled social engineering</li>
          <li>Threat intelligence inputs for AI-specific adversary tradecraft</li>
          <li>Incident response playbook coverage for AI-native incidents (prompt injection, model exfiltration, agent compromise)</li>
          <li>Disaster recovery and business continuity posture for AI workloads, model artifacts, and AI-dependent processes</li>
          <li>AI-accelerated exploit window assessment for known vulnerabilities</li>
        </ul>

        <h3 class="ciso-domain">3. Architecture &amp; Engineering</h3>
        <p>Whether the foundational security architecture has adapted to AI workloads and AI consumption patterns. The audit reviews Zero Trust implementation against AI-specific traffic patterns &mdash; agent-to-agent calls, model API consumption, retrieval-augmented generation pipelines, and embedding store access. Identity and Access Management is assessed across both human and non-human identities, including agent identities, service principals for AI workloads, and the proliferation of MCP server credentials. Network, endpoint, and hybrid cloud security controls are evaluated for AI-related blind spots.</p>
        <div class="ciso-examines">What gets examined</div>
        <ul>
          <li>Zero Trust architecture coverage of AI traffic patterns, against <a href="https://nvlpubs.nist.gov/nistpubs/SpecialPublications/NIST.SP.800-207.pdf" target="_blank" rel="noopener">NIST SP 800-207</a></li>
          <li>IAM coverage of non-human identities (agents, service principals, workload identities)</li>
          <li>Network, endpoint, and hybrid cloud control coverage of AI workloads</li>
          <li>MFA resilience and credential exposure pathways in the presence of AI-enabled credential attacks</li>
          <li>Shadow AI detection across enterprise systems</li>
        </ul>

        <h3 class="ciso-domain">4. Application &amp; Product Security</h3>
        <p>How the software development lifecycle handles AI-enabled features and how MLOps practices govern internal and commercial AI models. The audit examines DevSecOps integration for AI components, evaluates SAST/DAST coverage gaps against AI behavior, reviews MLOps governance for model approval, deployment, and retirement, and assesses the organization's exposure to prompt injection, output validation gaps, and agent boundary failures.</p>
        <div class="ciso-examines">What gets examined</div>
        <ul>
          <li>DevSecOps pipeline integration for AI-enabled features and AI-generated code</li>
          <li>MLOps governance for model approval, deployment, retirement, and incident response</li>
          <li>Exposure to the <a href="https://owasp.org/www-project-top-10-for-large-language-model-applications/" target="_blank" rel="noopener">OWASP LLM Top 10</a> vulnerability classes</li>
          <li>Prompt injection coverage, output validation, and agent boundary controls</li>
          <li>API security review for AI vendor integrations and internal AI service endpoints</li>
        </ul>

        <h3 class="ciso-domain">5. Third-Party &amp; Supply Chain Risk</h3>
        <p>The AI vendor risk picture, end to end. The audit inventories the organization's AI vendor footprint &mdash; foundation model providers, AI SaaS platforms, embedded AI features inside existing tools, AI-enabled libraries inside the codebase &mdash; and assesses vendor security posture, data handling practices, and contractual protections. Open-source AI dependencies are evaluated for provenance, maintenance, and known vulnerabilities.</p>
        <div class="ciso-examines">What gets examined</div>
        <ul>
          <li>AI vendor inventory: foundation model providers, AI SaaS platforms, AI features inside existing SaaS</li>
          <li>Open-source AI dependency provenance, maintenance posture, and known vulnerabilities</li>
          <li>Vendor security questionnaire coverage of AI-specific risks</li>
          <li>Contractual protections for AI-related data handling, breach notification, and model training rights</li>
          <li>AI model supply chain exposure (model weights, training data provenance, fine-tuning pipelines)</li>
        </ul>

        <h3 class="ciso-domain">6. Data Protection &amp; Privacy</h3>
        <p>How data flows into and out of AI systems, and whether the protections that exist for traditional data flows have been extended to AI flows. The audit examines data classification for AI training and inference data, lifecycle and retention controls for AI-related data including prompts and outputs, encryption posture across AI workloads, and data leakage prevention through generative AI tools &mdash; both sanctioned and shadow.</p>
        <div class="ciso-examines">What gets examined</div>
        <ul>
          <li>Data classification coverage for AI training data, inference inputs, prompts, and outputs</li>
          <li>Lifecycle and retention controls for AI-related data</li>
          <li>Encryption posture across AI workloads, including model artifacts and embedding stores</li>
          <li>Data loss prevention coverage of generative AI tools (sanctioned and shadow)</li>
          <li>Privacy compliance posture for AI under GDPR, CCPA, and applicable state-level frameworks</li>
        </ul>

        <div class="pull">A posture that looks healthy on every existing dashboard can still hide <em>the actual exposure profile of the business.</em></div>

        <h2>What the engagement produces</h2>
        <ul>
          <li>A CISO-grade exposure map across all six domains, with named gaps, evidence, and severity ratings.</li>
          <li>A prioritized remediation roadmap, sequenced for execution, ranked by exploitability, business impact, and remediation cost.</li>
          <li>An AI-specific incident response addendum aligned to the organization's existing IR plan.</li>
          <li>A regulatory compliance crosswalk identifying gaps against SEC cybersecurity disclosure rules, GDPR, HIPAA, and applicable state-level AI legislation.</li>
          <li>A baseline against which post-remediation posture can be measured at the next assessment.</li>
          <li>An executive briefing presentation, board-ready, defensible against auditor and regulator scrutiny.</li>
        </ul>

        <h2>Who sponsors this engagement</h2>
        <p>The AI IT Security Audit is typically sponsored by the Chief Information Security Officer, the Chief Information Officer, the Chief Risk Officer, or the General Counsel. It is most often initiated in response to a board-level question about AI exposure, an inbound enterprise customer security questionnaire that the team cannot answer cleanly, a regulatory inquiry, or a near-miss incident. It is sized for mid-market through large multinational organizations and is appropriate before &mdash; and ideally well before &mdash; an AI-driven incident, audit finding, or regulatory examination forces the work to happen on an unfavorable timeline.</p>

        <h2>Why now</h2>
        <p>Three forces are converging. SEC cybersecurity disclosure rules now require organizations to surface material cyber risk, and AI exposure increasingly qualifies. Enterprise customers are expanding security questionnaires to cover AI vendor risk. Regulators across jurisdictions are converging on evidence-based release criteria for AI systems. Organizations that establish a defensible AI security posture in the next twelve to eighteen months do so on their own timeline. Organizations that wait inherit the timeline of whoever asks the question first.</p>

      </div>

      <?php /* Engagement at a Glance &mdash; inline aside */ ?>
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
          <dd><a href="<?php echo esc_url( home_url( '/books/ai-risk-governance-security/the-ai-it-security-audit/' ) ); ?>"><em>The AI IT Security Audit</em></a> &mdash; forthcoming Book 05 of <em>The Operating Discipline for AI</em>.</dd>
        </dl>
        <a class="btn-aside" href="<?php echo esc_url( srj_get_booking() ); ?>" target="_blank" rel="noopener">
          Schedule a Consultation <span class="arrow">&rarr;</span>
        </a>
      </aside>

    </div>
  </div>
</section>

<?php srj_inline_cta( 'Ready to close the AI visibility gap across all six CISO domains? <em>Start with a conversation.</em>' ); ?>
<?php srj_final_cta(); ?>

<?php get_footer(); ?>
