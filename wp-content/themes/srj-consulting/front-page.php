<?php
/**
 * Front Page (Homepage) Template
 * Renders when a static page is set as the front page in Settings > Reading.
 *
 * REBUILD (June 1, 2026): rebuilt from the canonical homepage copy held in the
 * Notion "Homepage - Canonical Copy" page (source of truth). Copy is verbatim
 * from that master, with the dollar anchor at $670,000 (range $250,000 to
 * $670,000) per Stephen's June 1 2026 decision. Rendered in the existing theme
 * component styles. Sections, in order: hero, four pain points, framework (two
 * pillars), why operator-led, Highlights blog feed, final CTA, newsletter.
 *
 * v1.26 (June 8, 2026): two changes, both copy-only on the existing Type-1
 * template. (1) Hero reconciled to Option C per Stephen's June 8 approval:
 * the $670,000 anchor is preserved but the framing is corrected. The lower
 * end of the range ($250K) is attributed to waste; the upper end ($670K) is
 * attributed verbatim to IBM's 2025 Cost of a Data Breach Report finding on
 * shadow-AI breach premium. (2) New Cost-of-Waiting band inserted between
 * the Four Pain Points and Framework sections. Three points (subscription
 * waste compounds, exposure compounds faster, the breach is no longer
 * hypothetical), terminating in a footnote that carries the verbatim IBM
 * attribution. Reuses the existing .home-cost band styling; small CSS
 * addition (.home-cost-grid + .home-cost-point) in home-page.css.
 *
 * Design notes for review:
 * - Hero uses the existing left-aligned .hero style ("use the same style").
 *   The prior stat strip is omitted to match the canonical page.
 * - The "Highlights" feed is new per Stephen's spec: centered orange title,
 *   latest 3 posts pulled dynamically and left-aligned, centered orange
 *   "View all Insights" link to /insights/.
 * - Header logo / Schedule-button edge crowding and overall sizing are a
 *   separate header/container pass, not addressed in this template.
 *
 * v1.28 (July 10, 2026): Trademark audit pass. Four surgical additions
 * of &trade; to canonical marks in the pillar section: Pillar I H3
 * "AI Business Services", Pillar I link text "Explore AI Business
 * Services", Pillar II H3 "AI Risk Governance & Security", Pillar II
 * link text "Explore AI Risk Governance & Security". No other content
 * changes. Source of truth: SRJ_Trademark_Portfolio_v1_1.csv.
 *
 * v1.27 (July 2, 2026): AVS Scanner improvements pass. Single additive
 * change, no content changes to any existing section: a new executive
 * summary box added between the Hero and the Four Pain Points sections
 * as a top-of-page AEO anchor (quotable "what SRJ does" block for AI
 * extraction). A template-scoped <style> block is introduced to carry
 * the new .home-summary* class family. Tech-debt note per Convention #6:
 * these rules should migrate to assets/css/home-page.css on a later
 * consolidation pass with an SRJ_VERSION bump for cache-bust.
 */
$GLOBALS['srj_current_nav'] = '';
get_header();
$booking = srj_get_booking();
$phone_tel = srj_get_phone_tel();
$phone_display = srj_get_phone();
$home = trailingslashit( home_url() );
?>

<!-- HERO -->
<section class="hero">
  <div class="container">
    <div class="hero-grid">
      <div class="hero-text">
        <div class="label hero-eyebrow">Operator-Led AI Advisory</div>
        <h1>$670,000 is what unmanaged AI exposure <span class="accent">is costing you.</span></h1>
        <p class="lead">Most mid-market companies bleed between $250,000 and $670,000 a year to unauthorized AI. The lower end is duplicated subscriptions and productivity drag &mdash; recoverable with discipline. The upper end is what a shadow-AI breach costs on top, per IBM&rsquo;s 2025 Cost of a Data Breach Report.<sup><a href="#ibm-cobd-2025" class="hero-footnote-link">1</a></sup></p>
        <p class="hero-support">SRJ Consulting &amp; Services surfaces the waste, contains the exposure, and recovers the margin. Audits typically pay for themselves before they surface a single risk finding.</p>
        <div class="hero-actions">
          <a href="<?php echo esc_url( $booking ); ?>" target="_blank" rel="noopener" class="btn btn-primary">Schedule a Free 30-Minute Consultation <span class="arrow">&rarr;</span></a>
          <a href="#framework" class="btn btn-ghost">See the framework</a>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  /* v1.27 &mdash; Executive Summary box (top-of-page AEO anchor). Scoped to .home-summary*. */
  .home-summary { max-width: 1200px; margin: 24px auto 8px; padding: 0 32px; }
  .home-summary-inner { background: #FFF6EC; border-left: 4px solid #F07800; padding: 26px 30px 28px; }
  .home-summary-label { font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: .18em; text-transform: uppercase; color: #F07800; margin-bottom: 10px; }
  .home-summary p { font-family: 'Poppins', sans-serif; font-size: 15.5px; line-height: 1.65; color: #201868; margin: 0; }
  .home-summary p strong { color: #201868; font-weight: 600; }
</style>

<?php /* v1.27 &mdash; Executive Summary box (top-of-page AEO anchor). */ ?>
<div class="home-summary">
  <div class="home-summary-inner">
    <div class="home-summary-label">What SRJ Consulting &amp; Services does</div>
    <p><strong>SRJ Consulting &amp; Services is an operator-led AI advisory firm that surfaces unmanaged AI waste, contains AI-driven risk exposure, and puts what remains under executive control.</strong> Nine service lines across two operating pillars. No software resale, no vendor partnerships, no implementation revenue, only the advisory itself.</p>
  </div>
</div>

<!-- FOUR PAIN POINTS -->
<section class="home-questions">
  <div class="container">
    <div class="home-questions-head">
      <div class="label">What You Cannot See Is Costing You</div>
      <h2>The four ways unmanaged AI <em>quietly erodes your margin.</em></h2>
      <p class="home-questions-intro">Most mid-market companies have between 8 and 24 AI tools running inside their business right now. Leadership can typically name three or four. The gap between what you know is happening and what is actually happening is where the cost lives.</p>
    </div>

    <div class="home-questions-grid">
      <div class="hq-card">
        <h3>Duplicated Subscriptions</h3>
        <p>Sales bought a ChatGPT Enterprise contract. Marketing has a separate Jasper subscription. Legal added Harvey. Finance is paying Microsoft Copilot per seat for everyone, including the teams already running the other three. Mid-market companies routinely pay for the same capability four times before anyone consolidates.</p>
      </div>
      <div class="hq-card">
        <h3>Shadow AI Exposure</h3>
        <p>Employees signing up for free AI tools on personal accounts. Customer data, financial records, and proprietary work flowing through systems your security team has never reviewed. The exposure compounds quietly until something breaks, at which point it becomes a board issue.</p>
      </div>
      <div class="hq-card">
        <h3>Wrong-Tool Productivity Drag</h3>
        <p>Departments selecting AI tools based on demos rather than fit. Teams spending six months trying to get value from a tool that was never going to work for their use case. The cost is the productivity that should have been gained but wasn't, plus the switching cost when leadership finally pulls the plug.</p>
      </div>
      <div class="hq-card">
        <h3>Vendor Leverage Lost</h3>
        <p>Without a unified view of AI spend, finance cannot negotiate. Every contract gets renewed at list price. Every per-seat commitment gets locked in for another year. Procurement leverage that would save $30,000 to $150,000 annually gets left on the table because nobody has the consolidated data.</p>
      </div>
    </div>
  </div>
</section>

<!-- COST OF WAITING (v1.26) -->
<section class="home-cost" id="cost-of-waiting">
  <div class="container">
    <div class="home-cost-eyebrow">The Cost of Waiting</div>
    <h2>Waiting <em>compounds the cost.</em></h2>

    <div class="home-cost-grid">
      <div class="home-cost-point">
        <h3>Subscription waste compounds.</h3>
        <p>Mid-market AI sprawl doesn&rsquo;t stay flat. Every quarter another team adds another tool. The eight to twenty-four tools running today become twelve to forty next year. Recoverable waste grows by 30 to 50 percent per year of inaction.</p>
      </div>
      <div class="home-cost-point">
        <h3>Exposure compounds faster.</h3>
        <p>Shadow AI in the environment doesn&rsquo;t just sit there. It touches more data, more customers, more vendors with every month that passes. The longer the lag between deployment and governance, the wider the surface.</p>
      </div>
      <div class="home-cost-point">
        <h3>The breach is no longer hypothetical.</h3>
        <p>IBM&rsquo;s 2025 Cost of a Data Breach Report found organizations with high levels of shadow AI paid <strong>$670,000 more</strong> per breach than organizations with low levels or none.<sup>1</sup></p>
      </div>
    </div>

    <p class="home-cost-foot" id="ibm-cobd-2025"><sup>1</sup> IBM Security, <em>Cost of a Data Breach Report 2025</em>. Organizations with high levels of shadow AI experienced average breach costs of $4.74 million &mdash; $670,000 higher than organizations with low levels or no shadow AI ($4.07 million).</p>
  </div>
</section>

<!-- FRAMEWORK -->
<section class="pillars" id="framework">
  <div class="container">
    <div class="pillars-header">
      <div>
        <div class="label">The AI Operating System&trade;</div>
        <h2>Nine service lines. <em>Two operating pillars.</em></h2>
      </div>
      <div class="intro">
        The framework puts AI under management discipline without slowing the business down. It begins with surfacing what you cannot currently see, prices what you didn&rsquo;t know you were paying for, and builds the governance structure that prevents the waste from returning next quarter.
      </div>
    </div>

    <div class="pillar-grid">
      <div class="pillar">
        <span class="pillar-num">&mdash; Pillar I</span>
        <h3>AI Business Services&trade;</h3>
        <p class="pillar-question">Is AI making the business stronger?</p>
        <p class="pillar-desc">Four service lines that audit, assess, govern, and optimize how AI produces value inside the organization. Most engagements begin with the AI Business Enablement Audit&trade;, which typically recovers six figures in subscription consolidation alone.</p>
        <a href="<?php echo esc_url( $home . 'services/business-services/' ); ?>" class="pillar-link">Explore AI Business Services&trade; &rarr;</a>
      </div>

      <div class="pillar">
        <span class="pillar-num">&mdash; Pillar II</span>
        <h3>AI Risk Governance &amp; Security&trade;</h3>
        <p class="pillar-question">Is AI exposing the business to harm?</p>
        <p class="pillar-desc">Five service lines that identify, contain, and remediate AI-driven security exposure across governance, product, application, and cloud. Traditional risk frameworks were not designed for how AI changes the attack surface. These engagements fill that gap.</p>
        <a href="<?php echo esc_url( $home . 'services/risk-governance-security/' ); ?>" class="pillar-link">Explore AI Risk Governance &amp; Security&trade; &rarr;</a>
      </div>
    </div>
  </div>
</section>

<!-- WHY OPERATOR-LED -->
<section class="approach">
  <div class="container">
    <div class="approach-header">
      <div class="label">Not a Vendor, Not a Software Shop</div>
      <h2>The advisory <em>is the product.</em></h2>
      <p class="intro">SRJ Consulting &amp; Services was founded by Stephen R. Jordan after three decades of senior leadership at Citi, Intel, McAfee, and Optiv. The practice was built on a deliberate constraint: no software sales, no vendor partnerships, no implementation revenue. The advisory itself is what clients buy, which means there is no commercial reason to recommend anything other than what is actually right for the business.</p>
    </div>

    <div class="principle-grid">
      <div class="principle">
        <h4>Operator Credentials</h4>
        <p>Thirty years inside Fortune 500 operations, security, and risk programs at Citi, Intel, McAfee, and Optiv before founding the AI advisory firm. The frameworks come from running things, not from studying things.</p>
      </div>
      <div class="principle">
        <h4>No Vendor Conflicts</h4>
        <p>No software resold, no implementation partnerships, no kickbacks. Recommendations are aligned to your business outcomes, not a partner channel.</p>
      </div>
      <div class="principle">
        <h4>Six-Figure Findings, Defensible Analysis</h4>
        <p>Every audit produces a written deliverable a CFO can review and a board can act on. The numbers are sourced, the methodology is documented, the recommendations are prioritized by recoverable value.</p>
      </div>
    </div>

    <div class="approach-foot">
      <a href="<?php echo esc_url( $home . 'about/' ); ?>" class="pillar-link">Read about Stephen R. Jordan &rarr;</a>
    </div>
  </div>
</section>

<!-- HIGHLIGHTS (blog feed) -->
<section class="home-highlights">
  <div class="container">
    <h2 class="home-highlights-title">Insights</h2>

    <div class="home-highlights-list">
      <?php
      $highlight_posts = new WP_Query( array(
          'post_type'      => 'post',
          'posts_per_page' => 3,
          'post_status'    => 'publish',
      ) );

      if ( $highlight_posts->have_posts() ) :
          while ( $highlight_posts->have_posts() ) : $highlight_posts->the_post();
              $cats = get_the_category();
              $cat_name = ! empty( $cats ) ? esc_html( $cats[0]->name ) : 'Analysis';
      ?>
        <a href="<?php the_permalink(); ?>" class="hh-post">
          <div class="hh-meta">
            <span class="hh-cat"><?php echo $cat_name; ?></span>
            <span class="hh-date"><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
          </div>
          <h3 class="hh-title"><?php the_title(); ?></h3>
          <p class="hh-excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
        </a>
      <?php
          endwhile;
          wp_reset_postdata();
      else :
          /* Fallback if no posts are published yet. */
          $hh_fallback = array(
              array( 'Security',   'May 29, 2026', 'Shadow AI Breaches Cost $670K More. Most Companies Still Cannot Say Where Their Agents Live.' ),
              array( 'Operations', 'May 27, 2026', 'You Are Not Behind on AI. You Are Running It Without a System.' ),
              array( 'Analysis',   'May 21, 2026', 'Why AI Pilots Stall: The $1B Signal from EY &amp; Microsoft' ),
          );
          foreach ( $hh_fallback as $p ) :
      ?>
        <a href="<?php echo esc_url( $home . 'insights/' ); ?>" class="hh-post">
          <div class="hh-meta">
            <span class="hh-cat"><?php echo esc_html( $p[0] ); ?></span>
            <span class="hh-date"><?php echo esc_html( $p[1] ); ?></span>
          </div>
          <h3 class="hh-title"><?php echo wp_kses_post( $p[2] ); ?></h3>
        </a>
      <?php
          endforeach;
      endif;
      ?>
    </div>

    <div class="home-highlights-foot">
      <a href="<?php echo esc_url( $home . 'insights/' ); ?>">View all Insights</a>
    </div>
  </div>
</section>

<!-- FINAL CTA -->
<section class="cta" id="contact">
  <div class="container-narrow">
    <div class="label">Where to Begin</div>
    <h2>Find out what unmanaged AI <em>is costing your business.</em></h2>
    <p>Most executives find six figures in recoverable waste in the first thirty minutes of conversation. The consultation is free. There is no deck, no pitch, no sales process. A structured conversation about where your organization currently stands and what the right next step looks like.</p>
    <div class="cta-actions">
      <a href="<?php echo esc_url( $booking ); ?>" target="_blank" rel="noopener" class="btn btn-primary">Schedule a Free 30-Minute Consultation <span class="arrow">&rarr;</span></a>
    </div>
    <div class="cta-phone-row">
      <span class="cta-phone-divider">or call</span>
      <a href="tel:<?php echo esc_attr( $phone_tel ); ?>" class="cta-phone-num"><?php echo esc_html( $phone_display ); ?></a>
    </div>
  </div>
</section>

<!-- NEWSLETTER -->
<section class="home-newsletter">
  <div class="container-narrow">
    <div class="label">The AI Operating System&trade;</div>
    <h2>Get operating discipline for AI, <em>every other Tuesday.</em></h2>
    <p>Biweekly framework analysis, new templates, and field notes from active client engagements. Free, no software pitches, unsubscribe anytime.</p>
    <div class="home-newsletter-actions">
      <a href="<?php echo esc_url( $home . 'newsletter/' ); ?>" class="btn btn-primary">Subscribe Free <span class="arrow">&rarr;</span></a>
      <a href="<?php echo esc_url( $home . 'newsletter/' ); ?>" class="btn btn-ghost">Learn more about the newsletter</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
