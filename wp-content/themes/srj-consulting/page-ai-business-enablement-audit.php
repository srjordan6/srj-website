<?php
/**
 * Template Name: AI Business Enablement Audit
 *
 * Service Detail Page Template: AI Business Enablement Audit
 * Slug: ai-business-enablement-audit
 *
 * v9 standard (matches page-ai-efficiency-process.php): four visual sections,
 * Executive Briefing CTA panel, three pillar cards, four-indicator panel,
 * six-instrument card grid. Eleven H2s, ~2,000 words, focus keyword
 * "AI Business Enablement Audit" distributed through six H2s.
 *
 * The 18-minute YouTube walkthrough (Elizabeth narration, script by Stephen)
 * is preserved as a full-width section above the v9 body. This is the only
 * Pillar I service page with that asset.
 *
 * Scoped styles under .srjvol1- prefix. Tech-debt note: extract to
 * assets/css/ai-business-enablement-audit-page.css on a later pass per
 * Convention #6.
 *
 * Focus keyword: AI Business Enablement Audit
 * Approved by Stephen, June 27, 2026 (v9 standard rollout, Pillar I).
 */
$GLOBALS['srj_current_nav'] = 'services';
get_header();
?>

<?php srj_page_hero(
    'AI Business Services &mdash; 01',
    'AI Business Enablement Audit&trade;',
    'The diagnostic foundation. A structured evaluation of how AI is currently being used across the organization, what it is costing fully loaded, and whether it is producing measurable outcomes.'
); ?>

<style>
  /* === Video embed section (Book 01 only) === */
  .video-embed-section { padding: 80px 0 70px; background: var(--paper); border-bottom: 1px solid var(--line); text-align: center; }
  .video-embed-section .label { justify-content: center; display: inline-flex; margin-bottom: 22px; }
  .video-embed-section h2 { font-size: clamp(30px, 3.6vw, 46px); line-height: 1.15; margin: 0 auto 22px; max-width: 22ch; }
  .video-embed-section h2 em { font-style: italic; color: var(--orange); }
  .video-embed-section .video-lede { color: var(--ink-soft); font-size: 17px; line-height: 1.65; max-width: 60ch; margin: 0 auto 44px; }
  .video-frame { position: relative; width: 100%; max-width: 960px; margin: 0 auto; padding-bottom: 56.25%; height: 0; overflow: hidden; background: var(--navy-deep); border-radius: 4px; box-shadow: 0 30px 80px -24px rgba(36, 24, 91, 0.35); }
  .video-frame iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; }
  .video-meta { margin-top: 30px; font-family: 'Inter', sans-serif; font-size: 12.5px; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); font-weight: 500; }
  @media (max-width: 720px) { .video-embed-section { padding: 60px 0 50px; } .video-embed-section .video-lede { margin-bottom: 32px; } }
</style>

<!-- ===== VIDEO: 18-minute walkthrough of the AI Business Enablement Audit framework ===== -->
<section class="video-embed-section">
  <div class="container">
    <div class="label">Watch the 18-Minute Walkthrough</div>
    <h2>The full audit framework, in <em>eighteen minutes.</em></h2>
    <p class="video-lede">A complete walkthrough of the AI Business Enablement Audit&trade; framework. The Shadow AI problem most leadership teams have not seen, the five-dimension audit, and what your business actually looks like twelve months after running it.</p>
    <div class="video-frame">
      <iframe
        src="https://www.youtube-nocookie.com/embed/z5lEB49HyNc?rel=0&modestbranding=1"
        title="The AI Business Enablement Audit Framework"
        loading="lazy"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin"
        allowfullscreen></iframe>
    </div>
    <div class="video-meta">Presented by Elizabeth &middot; Script by Stephen R. Jordan &middot; 18 minutes</div>
  </div>
</section>

<style>
/* === Volume I service page, scoped visual elements (v9 standard, srjvol1- prefix) === */

/* --- 1. Executive Briefing CTA panel --- */
.srjvol1-brief-cta {
  background: #201868;
  color: #FFFFFF;
  padding: 36px 38px;
  margin: 36px 0 40px;
  border-left: 4px solid #F07800;
}
.srjvol1-brief-eyebrow {
  font-family: 'Poppins', sans-serif;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: #F07800;
  margin-bottom: 14px;
}
.srjvol1-brief-title {
  font-family: 'Lora', serif;
  font-size: 26px;
  line-height: 1.25;
  font-weight: 500;
  color: #FFFFFF;
  margin-bottom: 10px;
}
.srjvol1-brief-meta {
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  letter-spacing: .14em;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.75);
  margin-bottom: 18px;
}
.srjvol1-brief-lede {
  font-family: 'Poppins', sans-serif;
  font-size: 15px;
  line-height: 1.6;
  color: rgba(255, 255, 255, 0.92);
  margin-bottom: 24px;
  max-width: 640px;
}
.srjvol1-brief-actions {
  display: flex;
  gap: 14px;
  flex-wrap: wrap;
}
/* Button base — increased specificity + !important on color/decoration to defeat theme link-color cascade */
.srjvol1-brief-cta a.srjvol1-btn-primary,
.srjvol1-brief-cta a.srjvol1-btn-outline {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 13px 26px;
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  text-decoration: none !important;
  color: #FFFFFF !important;
  transition: all .22s ease;
  border: 1.5px solid transparent;
}
.srjvol1-brief-cta a.srjvol1-btn-primary {
  background: #F07800;
  border-color: #F07800;
}
.srjvol1-brief-cta a.srjvol1-btn-primary:hover,
.srjvol1-brief-cta a.srjvol1-btn-primary:focus {
  background: #d96b00;
  border-color: #d96b00;
  color: #FFFFFF !important;
}
.srjvol1-brief-cta a.srjvol1-btn-outline {
  background: transparent;
  border-color: rgba(255, 255, 255, 0.6);
}
.srjvol1-brief-cta a.srjvol1-btn-outline:hover,
.srjvol1-brief-cta a.srjvol1-btn-outline:focus {
  border-color: #FFFFFF;
  background: rgba(255, 255, 255, 0.08);
  color: #FFFFFF !important;
}
.srjvol1-brief-cta a.srjvol1-btn-primary span,
.srjvol1-brief-cta a.srjvol1-btn-outline span { color: inherit !important; }

/* --- 2. Three-pillar callout grid --- */
.srjvol1-pillars {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 18px;
  margin: 32px 0 40px;
}
.srjvol1-pillar-card {
  background: #FFF6EC;
  border-left: 3px solid #F07800;
  padding: 22px 22px 24px;
}
.srjvol1-pillar-number {
  font-family: 'Poppins', sans-serif;
  font-size: 26px;
  font-weight: 700;
  color: #F07800;
  line-height: 1;
  margin-bottom: 10px;
}
.srjvol1-pillar-name {
  font-family: 'Lora', serif;
  font-size: 19px;
  line-height: 1.25;
  font-weight: 500;
  color: #201868;
  margin-bottom: 8px;
}
.srjvol1-pillar-desc {
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  line-height: 1.55;
  color: #4a4a4a;
}

/* --- 3. Four-question indicators panel --- */
.srjvol1-indicators {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 16px;
  margin: 28px 0 36px;
  padding: 28px 24px;
  background: #FFFFFF;
  border: 1px solid #E6E8EE;
}
.srjvol1-ind { padding: 0 6px; }
.srjvol1-ind-num {
  font-family: 'Poppins', sans-serif;
  font-size: 28px;
  font-weight: 700;
  color: #F07800;
  line-height: 1;
  margin-bottom: 8px;
}
.srjvol1-ind-label {
  font-family: 'Lora', serif;
  font-size: 18px;
  font-weight: 500;
  color: #201868;
  margin-bottom: 6px;
}
.srjvol1-ind-desc {
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  line-height: 1.5;
  color: #4a4a4a;
}

/* --- 4. Six-instrument card grid --- */
.srjvol1-instruments {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 14px;
  margin: 28px 0 36px;
}
.srjvol1-inst {
  background: #FFFFFF;
  border: 1px solid #E6E8EE;
  border-top: 3px solid #201868;
  padding: 20px 20px 22px;
  min-height: 130px;
}
.srjvol1-inst-name {
  font-family: 'Lora', serif;
  font-size: 17px;
  line-height: 1.25;
  font-weight: 500;
  color: #201868;
  margin-bottom: 8px;
}
.srjvol1-inst-desc {
  font-family: 'Poppins', sans-serif;
  font-size: 13.5px;
  line-height: 1.55;
  color: #4a4a4a;
}

/* --- Responsive --- */
@media (max-width: 900px) {
  .srjvol1-pillars { grid-template-columns: 1fr; }
  .srjvol1-indicators { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .srjvol1-instruments { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 600px) {
  .srjvol1-brief-cta { padding: 28px 24px; }
  .srjvol1-brief-title { font-size: 22px; }
  .srjvol1-brief-actions { flex-direction: column; align-items: stretch; }
  .srjvol1-btn-primary, .srjvol1-btn-outline { justify-content: center; }
  .srjvol1-indicators { grid-template-columns: 1fr; }
  .srjvol1-instruments { grid-template-columns: 1fr; }
}
</style>

<section class="service-detail">
  <div class="container">
    <div class="service-detail-grid">
      <div class="longform" style="padding:0;background:transparent;border:none">

        <p class="lede"><em>The AI Business Enablement Audit&trade; engagement is how a leadership team finds out what AI is actually running inside the business, what it is costing fully loaded, and whether anyone is accountable for the outcomes. The audit runs against your actual tool footprint, your actual usage, your actual spend, and your existing operating cadence, in a defined timeline, with no separate project organization and no new headcount.</em></p>

        <!-- ===== 1. EXECUTIVE BRIEFING CTA PANEL ===== -->
        <div class="srjvol1-brief-cta">
          <div class="srjvol1-brief-eyebrow">Executive Briefing</div>
          <div class="srjvol1-brief-title">Read the AI Business Enablement Audit Executive Briefing</div>
          <div class="srjvol1-brief-meta">PDF &middot; 25 Pages &middot; 10-minute read</div>
          <div class="srjvol1-brief-lede">A condensed visual companion to Volume I. The four operating pillars, the Hidden Number behind every AI spend, the Shadow AI exposure most leadership teams have not seen, and the five elements every AI function needs to be defensible. Built for board distribution and leadership team review.</div>
          <div class="srjvol1-brief-actions">
            <a href="https://srjconsultingservices.com/wp-content/uploads/AI_Business_Enablement_Audit_Executive_Briefing.pdf" target="_blank" rel="noopener" class="srjvol1-btn-primary">View Briefing <span>&rarr;</span></a>
            <a href="https://srjconsultingservices.com/wp-content/uploads/AI_Business_Enablement_Audit_Executive_Briefing.pdf" download class="srjvol1-btn-outline">Download PDF</a>
          </div>
        </div>

        <h2>The pain the AI Business Enablement Audit is built to fix</h2>
        <p>AI is already inside the business. Most mid-market and enterprise organizations have multiple AI tools in active use across at least three departments. Some are licensed and tracked. Many are not. Embedded AI features inside existing tools, Microsoft, Google, Salesforce, accounting platforms, customer relationship management systems, get switched on quietly without anyone briefing leadership.</p>
        <p>The question is no longer whether to adopt AI. It is whether anyone in leadership can answer a few basic questions about what is already running. Most teams cannot. The recurring software bill is real. The usage reports look full. And no one on the executive team can defend, in numbers, what the business has actually purchased.</p>
        <p>The AI Business Enablement Audit is built for that exact gap. It does not advocate for more AI. It does not advocate for less AI. It produces a defensible operating picture leadership can stand behind in front of a board, an auditor, or an acquirer.</p>

        <h2>The Hidden Number, what most leadership teams have not seen</h2>
        <p>Most organizations underestimate their fully loaded AI cost by two to four times. Direct subscriptions show up on the P&amp;L. The other three cost layers usually do not. Variable usage charges, token costs, and overage fees expand without explicit approval. Integration overhead absorbs engineering and operations time that never gets allocated back to AI. The labor cost of review, correction, and rework is buried inside salaried roles and rarely shows up on any AI line item.</p>
        <p>The AI Business Enablement Audit calculates all four cost layers against the organization's own loaded labor rate, vendor invoices, and contractual exposure. The result is a number leadership can defend. The number is rarely the one that appears on the budget worksheet, and that is the point.</p>

        <h2>The Governance Gap, where AI risk and waste accumulate</h2>
        <p>Most companies have adopted AI tools without adopting AI governance. The gap is where risk and waste accumulate together, quietly and predictably. Use is fragmented across departments. Hidden cost does not appear on any single report. Ownership and accountability are unclear, or genuinely unassigned. Data exposure has occurred that leadership has never been briefed on. Vendor dependency is harder to unwind every quarter, and the contractual exit terms are getting worse, not better.</p>
        <p>None of this is anyone's fault. It is the predictable result of treating AI as a series of tool purchases rather than a function the business is now running. The AI Business Enablement Audit names the gap, sizes it against the operating reality of the business, and produces the inventory and ownership map leadership needs to close it.</p>

        <!-- ===== 2. THREE-PILLAR CALLOUT GRID ===== -->
        <div class="srjvol1-pillars">
          <div class="srjvol1-pillar-card">
            <div class="srjvol1-pillar-number">01</div>
            <div class="srjvol1-pillar-name">The Governance Gap</div>
            <div class="srjvol1-pillar-desc">Most companies adopted AI tools without adopting AI governance. Fragmented use, hidden cost, unclear ownership, undisclosed data exposure, and worsening vendor dependency, all in one quiet stack.</div>
          </div>
          <div class="srjvol1-pillar-card">
            <div class="srjvol1-pillar-number">02</div>
            <div class="srjvol1-pillar-name">Function, Not Project</div>
            <div class="srjvol1-pillar-desc">Projects end. Functions persist. AI runs inside the business with the same operating discipline already applied to finance, HR, IT, and vendor risk. Named owner, defined budget, documented controls, recurring review, clear exit criteria.</div>
          </div>
          <div class="srjvol1-pillar-card">
            <div class="srjvol1-pillar-number">03</div>
            <div class="srjvol1-pillar-name">Performative vs Operational</div>
            <div class="srjvol1-pillar-desc">Activity is not the same as productivity. Logins, demos, pilots, and quarterly slide refreshes are not business metrics. Margin, cycle time, error rate, and revenue per employee are.</div>
          </div>
        </div>

        <h2>Shadow AI, the exposure inside the gap</h2>
        <p>Shadow AI is AI being used by employees, contractors, and embedded vendor features without leadership approval, security review, or governance oversight. What leadership sees is the approved tool inventory, the tracked subscriptions, and the reviewed vendor contracts. What is actually running is broader, often by a wide margin.</p>
        <p>The Shadow AI surface includes personal accounts employees signed up for on their own, AI features quietly switched on inside Microsoft, Google, and Salesforce platforms the business already owns, and vendor APIs running on company data without explicit contractual review. Each of those is a control gap. Together, they are usually the single biggest exposure surface the AI Business Enablement Audit surfaces, and they are also the easiest to close once they are named and inventoried.</p>

        <h2>Function, not project, what the AI Business Enablement Audit installs</h2>
        <p>AI is not a project. It is a function. Treat it like one. Projects end. Functions persist. The AI Operating System&trade; treats AI as a permanent business function with the same operating discipline the business already applies to finance, human resources, information technology, and vendor risk.</p>
        <p>That means a named human accountable for outcomes, not a committee. A visible budget, not spend hidden across departments. Written, enforceable, and reviewable controls. A recurring review on the operating calendar, not an afterthought. Clear exit criteria, when the business stops, when it pivots, and when it retires a use case. The AI Business Enablement Audit is how those five elements get installed against the organization's actual operating reality.</p>

        <h2>The four questions every leadership team should be able to answer</h2>
        <p>The audit produces defensible answers to the four questions executives are now being asked, by their board, their auditor, their carrier, and increasingly their customers and acquirers. The questions are short. The answers, in most businesses, are not yet available.</p>

        <!-- ===== 3. FOUR-INDICATORS PANEL ===== -->
        <div class="srjvol1-indicators">
          <div class="srjvol1-ind">
            <div class="srjvol1-ind-num">01</div>
            <div class="srjvol1-ind-label">Tools running</div>
            <div class="srjvol1-ind-desc">What AI tools is the business using right now?</div>
          </div>
          <div class="srjvol1-ind">
            <div class="srjvol1-ind-num">02</div>
            <div class="srjvol1-ind-label">Loaded cost</div>
            <div class="srjvol1-ind-desc">What is the fully loaded cost across all four layers?</div>
          </div>
          <div class="srjvol1-ind">
            <div class="srjvol1-ind-num">03</div>
            <div class="srjvol1-ind-label">Outcomes</div>
            <div class="srjvol1-ind-desc">What is AI producing against the baseline?</div>
          </div>
          <div class="srjvol1-ind">
            <div class="srjvol1-ind-num">04</div>
            <div class="srjvol1-ind-label">Accountability</div>
            <div class="srjvol1-ind-desc">Who is accountable when something goes wrong?</div>
          </div>
        </div>

        <p>The AI Business Enablement Audit produces a written answer to each of these questions, backed by evidence the business can point at, dated, and signed by a named owner. The answers are not aspirational. They are the operating reality, as found.</p>

        <h2>The three signs your AI is performative, not operational</h2>
        <p>There are three signs that surface in nearly every diagnostic, and each one tells the leadership team something specific about where to look first. When no one in the room can name the owner accountable for AI outcomes, AI is unowned. When the metrics being reported are activity metrics, logins, approvals, hours saved, meetings held, and not outcome metrics, margin, cycle time, error rate, revenue per employee, AI is being measured wrong. When the AI strategy lives only in a quarterly slide refresh that never converts into operating discipline, the business has strategy theater, not an operating function.</p>
        <p>None of these are character indictments of the team. They are the predictable shape of a function that was never formally installed. The AI Business Enablement Audit names which of the three is most pronounced in this business, and it sequences the work needed to convert performative AI into operational AI.</p>

        <h2>What the AI Business Enablement Audit engagement produces</h2>
        <p>A defensible operating picture, plus the measurement and governance infrastructure to keep maintaining it without re-engaging the firm. The engagement runs against the business's own tool inventory, vendor contracts, usage data, and operating cadence. The leadership team walks away with six named instruments, scored against the organization's own reality, sequenced for a lean leadership team to run inside the operating rhythm already in place.</p>

        <!-- ===== 4. SIX-INSTRUMENT CARD GRID ===== -->
        <div class="srjvol1-instruments">
          <div class="srjvol1-inst">
            <div class="srjvol1-inst-name">AI Tool Inventory</div>
            <div class="srjvol1-inst-desc">A documented inventory of formal and informal AI usage across every function, including the Shadow AI surface.</div>
          </div>
          <div class="srjvol1-inst">
            <div class="srjvol1-inst-name">Fully Loaded Cost Map</div>
            <div class="srjvol1-inst-desc">All four cost layers calculated against the business's own contracts and loaded labor rate.</div>
          </div>
          <div class="srjvol1-inst">
            <div class="srjvol1-inst-name">Shadow AI Surface</div>
            <div class="srjvol1-inst-desc">The unapproved tools, embedded vendor features, and personal accounts touching company data, all named.</div>
          </div>
          <div class="srjvol1-inst">
            <div class="srjvol1-inst-name">Governance Gap Analysis</div>
            <div class="srjvol1-inst-desc">A gap analysis benchmarked against the organization's size, sector, and risk profile, not a generic checklist.</div>
          </div>
          <div class="srjvol1-inst">
            <div class="srjvol1-inst-name">Performative vs Operational Diagnostic</div>
            <div class="srjvol1-inst-desc">Where AI is producing operational results and where it is producing slide-deck strategy, scored side by side.</div>
          </div>
          <div class="srjvol1-inst">
            <div class="srjvol1-inst-name">Standing AI Adoption Policy&trade;</div>
            <div class="srjvol1-inst-desc">Named owner, defined budget, documented controls, recurring review, and exit criteria, on one signed page.</div>
          </div>
        </div>

        <p>No separate project organization. No new headcount. No parallel reporting structure. The engagement aligns with the management-system requirements in <a href="https://www.iso.org/standard/81230.html" rel="noopener">ISO/IEC 42001</a> and the risk-management discipline in the <a href="https://www.nist.gov/itl/ai-risk-management-framework" rel="noopener">NIST AI Risk Management Framework</a>. It does not produce a certification against either. It produces the operating evidence those frameworks expect a mature business to put on the table.</p>

        <h2>Who needs the AI Business Enablement Audit first</h2>
        <p>A two-hundred-person accounting firm, eighteen months into AI adoption, with Copilot rolled out firmwide, three drafting tools in active use, and embedded AI features inside the practice-management platform that nobody on the leadership team can name. The managing partner cannot answer the audit committee's questions about AI exposure with confidence, and the carrier has started attaching AI questions to the annual professional liability renewal.</p>
        <p>The engagement runs against the firm's actual tool footprint. It inventories formal and informal usage across the practice. It calculates the fully loaded cost against the firm's actual contracts and loaded labor rate. It surfaces the Shadow AI exposure inside Microsoft 365 and the practice-management platform. It produces the governance gap analysis benchmarked against the firm's size, sector, and client mix. Three months in, the managing partner has a defensible answer for the audit committee and a Standing AI Adoption Policy the firm operates.</p>
        <p>The same shape applies to a six-hundred-person manufacturer running embedded AI inside the ERP system and the production-planning tool, a regional bank running AI inside the loan-origination platform, a mid-market healthcare provider running AI inside the electronic health record, and any mid-market distributor running AI inside the customer relationship management system. The methodology travels. The numbers underneath it are always the business's own.</p>

        <h2>How the book and the AI Business Enablement Audit engagement work together</h2>
        <p>The engagement is the consulting application of <a href="<?php echo esc_url( home_url( '/books/ai-business-services/the-ai-business-enablement-audit/' ) ); ?>">Volume I</a> of <a href="<?php echo esc_url( home_url( '/books/' ) ); ?>">The Operating Discipline for AI Library&trade;</a>. The book is the methodology, written for leadership teams that want to run the discipline themselves. The engagement is the execution, designed for leadership teams that want the inventory built, the cost map calculated, the Shadow AI surfaced, and the Standing AI Adoption Policy drafted and signed inside a defined timeline, not learned, drafted, and refined over six months of internal effort.</p>
        <p>Teams that want the discipline in book form work from the book. Teams that want the AI Tool Inventory built from their own systems, the Fully Loaded Cost Map calculated against their own contracts, the Shadow AI surface mapped against their own platforms, and the policy drafted to be signed by their own accountable executive, work directly with the firm.</p>

        <h2>Where the AI Business Enablement Audit sits in the AI Operating System</h2>
        <p>The AI Business Enablement Audit is Volume I of <em>The Operating Discipline for AI Library&trade;</em> and the opening engagement of Pillar I, AI Business Services&trade;. It installs the operating picture that the rest of the AI Operating System&trade; acts on. The <a href="<?php echo esc_url( home_url( '/services/business-services/ai-readiness-performance/' ) ); ?>">AI Readiness &amp; Performance Assessment&trade;</a> makes the expand-refine-pause decisions. The <a href="<?php echo esc_url( home_url( '/services/business-services/ai-risk-governance-review/' ) ); ?>">AI Risk &amp; Governance Review&trade;</a> installs the governance record. The <a href="<?php echo esc_url( home_url( '/services/business-services/ai-efficiency-process/' ) ); ?>">AI Efficiency &amp; Process Optimization&trade;</a> converts all of it into measurable operating performance. You cannot govern what you have not measured, and you cannot optimize what you cannot see. The AI Business Enablement Audit is where the seeing starts.</p>

        <h2>Start the AI Business Enablement Audit engagement</h2>
        <p><a href="<?php echo esc_url( home_url( '/schedule-consultation/' ) ); ?>">Schedule a consultation</a> to discuss whether this engagement fits the operating reality inside your business right now.</p>

      </div>
      <?php srj_render_service_aside( 'business', 'ai-business-enablement-audit' ); ?>
    </div>
  </div>
</section>

<?php srj_inline_cta( 'Ready to scope this engagement? <em>Start with a conversation.</em>' ); ?>
<?php srj_final_cta(); ?>

<?php get_footer(); ?>
