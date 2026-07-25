<?php
/**
 * Template Name: Book Pillar
 *
 * Reusable pillar page for the Books section of
 * The Operating Discipline for AI Library&trade;. One template renders either
 * pillar, driven by the $SRJ_PILLARS config below, keyed by page slug.
 *
 * URL pattern: /books/<pillar-slug>/
 *   /books/ai-business-services/        — Pillar I (4 books)
 *   /books/ai-risk-governance-security/ — Pillar II (2 books)
 *
 * Each book card links to its own Book Detail page
 * (/books/<pillar-slug>/<book-slug>/). Only published books carry a live
 * "Buy on Amazon" button; forthcoming books show a neutral status and link
 * through to their detail page.
 *
 * To deploy:
 *   1. SFTP this file to /wp-content/themes/srj-consulting/
 *   2. Ensure the "Books" page exists (slug: books).
 *   3. Create the pillar Page, parent = Books, slug = ai-business-services
 *      (or ai-risk-governance-security), Template = "Book Pillar", Publish.
 *
 * SEO note: page meta title/description and any CollectionPage schema are
 * set in Rank Math (Rank Math is the single source of meta + schema on this
 * site). This template outputs no meta tags and no entity schema.
 *
 * @package SRJ_Consulting
 */

get_header();

/* =========================================================================
   PILLAR CONFIG — keyed by WordPress page slug.
   book 'slug' values must match the Book Detail page slugs.
   ========================================================================= */
$SRJ_PILLARS = array(

  'ai-business-services' => array(
    'tag'      => 'Pillar I',
    'name'     => 'AI Business Services',         // &trade; appended in markup
    'eyebrow'  => 'SRJ Consulting &middot; Books',
    'headline' => 'From AI activity to measurable business performance.',
    'intro'    => 'Many organizations have come to treat the presence of AI as proof of its performance. Vendor dashboards report productivity gains, platforms log thousands of prompts, and subscriptions accumulate across departments. Yet when leadership asks the ordinary financial questions — faster than what baseline, at what margin impact, with what liability exposure — the answers are often unavailable. AI Business Services&trade; addresses that gap. It treats AI not as an engineering question but as a matter of executive control: the operating structure, financial visibility, and accountability a leadership team needs to apply AI with discipline. Clarity before expansion is not caution for its own sake; it is how durable operating decisions get made.',
    'series_note' => 'This pillar is developed across four books, each written for non-technical business leaders and built to be used in the room — the matrices, scorecards, and control logs are meant to be brought into the meeting, not admired from a distance.',
    'books' => array(
      array(
        'series'   => 'The Operating Discipline for AI Library&trade;',
        'num'      => 'Book 01',
        'title'    => 'The AI Business Enablement Audit',
        'tagline'  => 'Running AI as a permanent business function.',
        'summary'  => 'The diagnostic foundation of the series. Before committing capital to scale AI, a leadership team needs an honest map of its current exposure. This book provides a plain-English internal-control method to inventory every AI tool in use, surface the spending that is scattered and unaccounted across departments, and measure the distance between general AI adoption and actual business intent.',
        'slug'     => 'the-ai-business-enablement-audit',
        'status'   => 'available',
        'status_label' => 'Available Now',
        'buy_url'  => 'https://www.amazon.com/dp/B0H5M4BSYR',
      ),
      array(
        'series'   => 'The Operating Discipline for AI Library&trade;',
        'num'      => 'Book 02',
        'title'    => 'The AI Readiness &amp; Performance Assessment',
        'tagline'  => 'Evidence over hype: the expand, refine, or pause decision.',
        'summary'  => 'A capable tool placed inside an unstable operation simply produces errors faster. This book introduces the AI Readiness Maturity Scale, a 1-to-5 measure applied across six dimensions of the business: workflow clarity, data reliability, people readiness, leadership accountability, performance measurement, and operational friction. The result is an objective readiness baseline, established before the decision to scale rather than after.',
        'slug'     => 'the-ai-readiness-performance-assessment',
        'status'   => 'available',
        'status_label' => 'Available Now',
        'buy_url'  => 'https://www.amazon.com/dp/B0H5X83K31',
      ),
      array(
        'series'   => 'The Operating Discipline for AI Library&trade;',
        'num'      => 'Book 03',
        'title'    => 'The AI Risk &amp; Governance Review',
        'tagline'  => 'Operational compliance controls that do not stall the business.',
        'summary'  => 'Shadow AI is not an IT problem; it is an internal-control failure. When an automated system operates without explicit human oversight, the organization still owns the financial, legal, and regulatory consequences. This book sets out how to establish the three governance boundaries every business needs — usage policies, tool-approval processes, and data-access protocols — in a form proportionate to the organization\'s size and risk, without slowing the work that depends on AI.',
        'slug'     => 'the-ai-risk-governance-review',
        'status'   => 'available',
        'status_label' => 'Available Now',
        'buy_url'  => 'https://www.amazon.com/dp/B0H7DB6TBV',
      ),
      array(
        'series'   => 'The Operating Discipline for AI Library&trade;',
        'num'      => 'Book 04',
        'title'    => 'The AI Efficiency &amp; Process Optimization',
        'tagline'  => 'Eliminating rework debt and capturing real efficiency.',
        'summary'  => 'Drafting speed counts for little if managers spend the saved time correcting inconsistent output. This book teaches leadership to run the Performance Reality Test and apply the Net Efficiency Yield Ratio — tracing friction back to its operational root causes, removing the workarounds employees adopt quietly, and confirming that labor savings are genuinely captured and redirected to higher-value work.',
        'slug'     => 'the-ai-efficiency-process-optimization',
        'status'   => 'available',
        'status_label' => 'Available Now',
        'buy_url'  => 'https://www.amazon.com/dp/B0HBFVM7DG',
      ),
    ),
  ),

  'ai-risk-governance-security' => array(
    'tag'      => 'Pillar II',
    'name'     => 'AI Risk Governance &amp; Security',
    'eyebrow'  => 'SRJ Consulting &middot; Books',
    'headline' => 'Identifying AI risk before it becomes loss.',
    'intro'    => 'AI introduces exposure at the data, decision, and vendor layers — and that exposure becomes financial loss, operational disruption, or reputational damage only when it is left unmanaged. AI Risk Governance &amp; Security&trade; is the protective discipline of the SRJ practice: a standalone executive program to identify, assess, and mitigate AI-driven technology risk before it reaches the balance sheet.',
    'series_note' => 'This pillar hosts Books 05 through 09 of <em>The Operating Discipline for AI Library&trade;</em>. Books 05 and 06 move from technical assessment of the AI attack surface to the governance machinery that proves AI risk is controlled. Books 07 through 09 extend the work into product security, application security, and cloud and infrastructure security: the three security disciplines that AI has structurally changed.',
    'books' => array(
      array(
        'series'   => 'The Operating Discipline for AI Library&trade;',
        'num'      => 'Book 05',
        'title'    => 'The AI IT Security Audit',
        'tagline'  => 'The exposure your dashboards cannot see.',
        'summary'  => 'A CISO-grade audit framework for proving AI exposure is known, controlled, and governed. Built on The Visibility Triangle and the six domains of the modern security portfolio, it produces an exposure map, a remediation roadmap, a regulatory crosswalk, and a board briefing that survives scrutiny.',
        'slug'     => 'the-ai-it-security-audit',
        'status'   => 'forthcoming',
        'status_label' => 'Forthcoming',
        'buy_url'  => '',
      ),
      array(
        'series'   => 'The Operating Discipline for AI Library&trade;',
        'num'      => 'Book 06',
        'title'    => 'The AI IT Security Implementation &amp; Strategy',
        'tagline'  => 'The question your board will ask. The proof you don&rsquo;t have yet.',
        'summary'  => 'The operating manual for proving AI risk is governed: ratified policies, an integrated risk register, a regulatory crosswalk, and board reporting that works at a glance. Following the audit&rsquo;s exposure map, this book builds the governance machinery — a discipline to operate, not a project to complete.',
        'slug'     => 'the-ai-it-security-implementation-strategy',
        'status'   => 'forthcoming',
        'status_label' => 'Forthcoming',
        'buy_url'  => '',
      ),

      /* v1.28: Books 07/08/09 (Security in the Age of AI) added to this pillar. */
      array(
        'series'   => 'The Operating Discipline for AI Library&trade;',
        'num'      => 'Book 07',
        'title'    => 'Secure by Design in the Age of AI',
        'tagline'  => 'Closing the velocity gap before regulators do.',
        'summary'  => 'Engineering velocity is up an order of magnitude. Security review capacity is not. At the same time, AI introduces vulnerabilities that deterministic tooling cannot reliably find. This book introduces The Dual-Impedance Problem and the five working frameworks that produce a defensible Secure by Design operating model for AI-enabled products.',
        'slug'     => 'the-secure-by-design',
        'status'   => 'forthcoming',
        'status_label' => 'Forthcoming',
        'buy_url'  => '',
      ),
      array(
        'series'   => 'The Operating Discipline for AI Library&trade;',
        'num'      => 'Book 08',
        'title'    => 'Application Security in the Age of AI',
        'tagline'  => 'AppSec for applications that no longer behave deterministically.',
        'summary'  => 'Every AppSec tool in production was built on the assumption that an application produces the same output for the same input. AI invalidated that assumption. This book introduces The Runtime Determinism Gap and the AppSec program model executives need when scans pass and applications still fail in production.',
        'slug'     => 'the-application-security',
        'status'   => 'forthcoming',
        'status_label' => 'Forthcoming',
        'buy_url'  => '',
      ),
      array(
        'series'   => 'The Operating Discipline for AI Library&trade;',
        'num'      => 'Book 09',
        'title'    => 'Cloud and Infrastructure Security in the Age of AI',
        'tagline'  => 'Governance for a cloud where most actors are not human.',
        'summary'  => 'Cloud security was built on the premise that every meaningful action could be traced to an accountable human. The identity ratio inverted, infrastructure pace outran governance pace, and the audit chain stopped answering its own question. This book introduces The Sovereignty Problem and the operating model cloud security leaders need to catch up.',
        'slug'     => 'the-cloud-infrastructure-security',
        'status'   => 'forthcoming',
        'status_label' => 'Forthcoming',
        'buy_url'  => '',
      ),
    ),
  ),
);

// Select the pillar by current page slug.
$srj_slug   = get_post_field( 'post_name', get_queried_object_id() );
$pillar     = isset( $SRJ_PILLARS[ $srj_slug ] ) ? $SRJ_PILLARS[ $srj_slug ] : null;
$books_home = home_url( '/books/' );
?>

<style>
  :root {
    --navy: #201868; --orange: #F07800; --white: #FFFFFF;
    --paper: #FAFAFA; --gray: #7A8A9E; --gray-light: #E8ECF1;
    --gray-fill: #F5F5F7; --ink: #1A1A2E;
  }
  .pillar-page { background: var(--white); color: var(--ink); }
  .pillar-page .container { max-width: 1200px; margin: 0 auto; padding: 0 32px; }

  /* HERO */
  .pillar-hero { padding: 88px 0 56px; border-bottom: 1px solid var(--gray-light); }
  .pillar-hero .eyebrow {
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: .18em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 22px;
  }
  .pillar-hero .tag {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--gray);
    margin-bottom: 14px;
  }
  .pillar-hero h1 {
    font-family: 'Lora', serif; font-size: 46px; line-height: 1.1;
    font-weight: 500; color: var(--navy); margin: 0 0 14px; max-width: 860px;
  }
  .pillar-hero h1 em { font-style: italic; color: var(--orange); font-weight: 500; }
  .pillar-hero .pillar-name {
    font-family: 'Lora', serif; font-size: 21px; font-weight: 500;
    color: var(--navy); margin: 0 0 24px;
  }
  .pillar-hero .intro {
    font-family: 'Poppins', sans-serif; font-size: 17px; line-height: 1.65;
    color: var(--ink); max-width: 760px; margin: 0 0 20px;
  }
  .pillar-hero .series-note {
    font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 1.6;
    color: var(--gray); max-width: 720px; margin: 0;
  }

  /* BOOKS LIST */
  .pillar-books { padding: 56px 0 16px; }
  .pillar-books .section-label {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--navy);
    margin-bottom: 26px;
  }
  .pbooks-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
  @media (max-width: 820px) { .pbooks-grid { grid-template-columns: 1fr; } }

  .pbook-card {
    position: relative; display: flex; flex-direction: column;
    background: var(--white); padding: 38px 34px 32px;
    border: 1px solid var(--gray-light);
    transition: border-color .25s ease, transform .25s ease;
  }
  .pbook-card::before, .pbook-card::after {
    content: ''; position: absolute; width: 20px; height: 20px;
    border: 2px solid var(--navy);
  }
  .pbook-card::before { top: -1px; left: -1px; border-right: 0; border-bottom: 0; }
  .pbook-card::after  { bottom: -1px; right: -1px; border-left: 0; border-top: 0; }
  .pbook-card.forthcoming { background: var(--paper); }
  .pbook-card.forthcoming::before, .pbook-card.forthcoming::after { border-color: var(--gray); }

  .pbook-card .pb-num {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 12px;
  }
  .pbook-card.forthcoming .pb-num { color: var(--gray); }
  .pbook-card h3 {
    font-family: 'Lora', serif; font-size: 25px; line-height: 1.25;
    font-weight: 500; color: var(--navy); margin: 0 0 8px;
  }
  .pbook-card .pb-tagline {
    font-family: 'Lora', serif; font-size: 16px; font-style: italic;
    color: var(--gray); margin: 0 0 16px;
  }
  .pbook-card .pb-status {
    display: inline-block;
    font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 600;
    letter-spacing: .12em; text-transform: uppercase;
    padding: 5px 11px; margin-bottom: 18px; align-self: flex-start;
  }
  .pbook-card .pb-status.available   { background: var(--orange); color: var(--white); }
  .pbook-card .pb-status.forthcoming { background: var(--gray-light); color: var(--gray); }
  .pbook-card .pb-summary {
    font-family: 'Poppins', sans-serif; font-size: 14.5px; line-height: 1.6;
    color: var(--ink); margin: 0 0 24px;
  }
  .pbook-card.forthcoming .pb-summary { color: var(--gray); }

  /* v1.28: per-card series eyebrow (multi-series pillar). */
  .pbook-card .pb-series {
    font-family: 'Poppins', sans-serif; font-size: 10.5px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 6px;
  }

  .pbook-card .pb-actions {
    margin-top: auto; display: flex; gap: 14px; flex-wrap: wrap; align-items: center;
  }
  .pb-link {
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: .08em; text-transform: uppercase; text-decoration: none;
    color: var(--navy); border-bottom: 1px solid var(--navy);
    padding-bottom: 2px; transition: color .2s ease, border-color .2s ease;
  }
  .pb-link:hover { color: var(--orange); border-bottom-color: var(--orange); }
  .pb-buy {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 22px; background: var(--orange); color: var(--white);
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: .1em; text-transform: uppercase;
    text-decoration: none; transition: background .25s ease;
  }
  .pb-buy:hover { background: #d96b00; color: var(--white); }
  .pb-buy .arrow, .pb-link .arrow { transition: transform .2s ease; }
  .pb-buy:hover .arrow { transform: translateX(3px); }

  /* CTA */
  .pillar-cta { padding: 88px 0; background: var(--paper); margin-top: 64px;
    border-top: 1px solid var(--gray-light); border-bottom: 1px solid var(--gray-light); }
  .pillar-cta .label {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 18px;
  }
  .pillar-cta h2 {
    font-family: 'Lora', serif; font-size: 38px; line-height: 1.15;
    font-weight: 500; color: var(--navy); margin: 0 0 20px; max-width: 680px;
  }
  .pillar-cta h2 em { font-style: italic; color: var(--orange); }
  .pillar-cta p {
    font-family: 'Poppins', sans-serif; font-size: 16px; line-height: 1.6;
    color: var(--ink); margin: 0 0 32px; max-width: 620px;
  }
  .pillar-cta .cta-buttons { display: flex; gap: 16px; flex-wrap: wrap; }
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
    .pillar-hero h1 { font-size: 32px; }
    .pillar-cta h2 { font-size: 28px; }
  }
</style>

<main class="pillar-page">

  <?php if ( $pillar ) : ?>

  <!-- HERO -->
  <section class="pillar-hero">
    <div class="container">
      <?php if ( function_exists( 'srj_breadcrumbs' ) ) { srj_breadcrumbs(); } ?>
      <div class="eyebrow"><?php echo esc_html( $pillar['eyebrow'] ); ?></div>
      <div class="tag"><?php echo esc_html( $pillar['tag'] ); ?></div>
      <h1><?php echo esc_html( $pillar['headline'] ); ?></h1>
      <p class="pillar-name"><?php echo wp_kses_post( $pillar['name'] ); ?>&trade;</p>
      <p class="intro"><?php echo wp_kses_post( $pillar['intro'] ); ?></p>
      <p class="series-note"><?php echo wp_kses_post( $pillar['series_note'] ); ?></p>
    </div>
  </section>

  <!-- BOOKS -->
  <section class="pillar-books">
    <div class="container">
      <div class="section-label">Books in this pillar</div>
      <div class="pbooks-grid">
        <?php foreach ( $pillar['books'] as $b ) :
          $is_available = ( 'available' === $b['status'] );
          $book_url     = trailingslashit( $books_home . $srj_slug ) . $b['slug'] . '/';
        ?>
        <article class="pbook-card <?php echo $is_available ? 'available' : 'forthcoming'; ?>">
          <?php if ( ! empty( $b['series'] ) ) : ?>
          <div class="pb-series"><?php echo esc_html( $b['series'] ); ?></div>
          <?php endif; ?>
          <div class="pb-num"><?php echo esc_html( $b['num'] ); ?></div>
          <h3><?php echo wp_kses_post( $b['title'] ); ?>&trade;</h3>
          <p class="pb-tagline"><?php echo esc_html( $b['tagline'] ); ?></p>
          <span class="pb-status <?php echo esc_attr( $b['status'] ); ?>">
            <?php echo esc_html( $b['status_label'] ); ?>
          </span>
          <p class="pb-summary"><?php echo wp_kses_post( $b['summary'] ); ?></p>
          <div class="pb-actions">
            <a class="pb-link" href="<?php echo esc_url( $book_url ); ?>">
              <?php echo $is_available ? 'View the book' : 'Read more'; ?>
              <span class="arrow">&rarr;</span>
            </a>
            <?php if ( $is_available && ! empty( $b['buy_url'] ) ) : ?>
              <a class="pb-buy" href="<?php echo esc_url( $b['buy_url'] ); ?>" target="_blank" rel="noopener">
                Buy on Amazon <span class="arrow">&rarr;</span>
              </a>
            <?php endif; ?>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="pillar-cta">
    <div class="container">
      <div class="label">SRJ Consulting &amp; Services</div>
      <h2>Build the foundation <em>before</em> you scale.</h2>
      <p>Browse the full library across both series, or speak with us directly about applying the frameworks in your organization.</p>
      <div class="cta-buttons">
        <a class="btn-primary" href="<?php echo esc_url( $books_home ); ?>">
          All Books <span class="arrow">&rarr;</span>
        </a>
        <a class="btn-secondary" href="<?php echo esc_url( srj_get_calendly() ); ?>" target="_blank" rel="noopener">
          Schedule a Consultation
        </a>
      </div>
    </div>
  </section>

  <?php else : ?>
  <section class="pillar-hero">
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
