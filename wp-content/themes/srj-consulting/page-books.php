<?php
/**
 * Template Name: Books Hub
 *
 * Landing page for The Operating Discipline for AI Library&trade;.
 * Two pillars, nine books. Each book is a card linking to its own detail
 * page; the worksheet and chapter-graphics libraries live on the individual
 * book pages (page-book-detail.php), not here.
 *
 * URL: /books/
 *
 * Page hierarchy this template expects:
 *   Books  (this page, slug: books)
 *   |- AI Business Services            (slug: ai-business-services)        — Book Pillar (4 books)
 *   |  |- The AI Business Enablement Audit                — Book Detail   (Book 01)
 *   |  |- The AI Readiness & Performance Assessment       — Book Detail   (Book 02)
 *   |  |- The AI Risk & Governance Review                 — Book Detail   (Book 03)
 *   |  |- The AI Efficiency & Process Optimization        — Book Detail   (Book 04)
 *   |- AI Risk Governance & Security   (slug: ai-risk-governance-security) — Book Pillar (5 books)
 *      |- The AI IT Security Audit                        — Book Detail   (Book 05)
 *      |- The AI IT Security Implementation & Strategy    — Book Detail   (Book 06)
 *      |- Secure by Design in the Age of AI               — Book Detail   (Book 07)
 *      |- Application Security in the Age of AI           — Book Detail   (Book 08)
 *      |- Cloud and Infrastructure Security in the Age of AI — Book Detail (Book 09)
 *
 * History: prior to v1.4 this template held Book 1 as a large inline card
 * with its full worksheet + chapter-graphics library. That library moved to
 * the Book 1 detail page when the Books section was restructured into the
 * pillar / book-page hierarchy. This page is now a pure landing page.
 * v1.28 expanded Pillar II to five books (Books 05-09).
 * June 18 2026: Book 02 flipped from forthcoming to available on the Volume II
 * launch day. No template logic change, single-line config flip.
 *
 * v1.29 (July 2, 2026): AVS Scanner improvements pass. Single additive
 * change, no content changes to any existing section: a new executive
 * summary box added between the books-hero and the pillar sections, as
 * a top-of-page AEO anchor (quotable "what The Operating Discipline for
 * AI Library&trade; is" block for AI extraction). Uses a new .books-summary*
 * class family added to the existing template-scoped &lt;style&gt; block.
 *
 * SEO note: meta title/description and any CollectionPage schema are set in
 * Rank Math (the single source of meta + schema on this site). This template
 * outputs no meta tags and no entity schema.
 *
 * To deploy: SFTP to /wp-content/themes/srj-consulting/. The "Books" page
 * with slug "books" uses this "Books Hub" template.
 *
 * @package SRJ_Consulting
 */

get_header();

/* =========================================================================
   SERIES CONFIG — the two pillars and their books.
   Book 'slug' values must match the Book Detail page slugs; pillar 'slug'
   values must match the Book Pillar page slugs. URLs are derived from these.
   ========================================================================= */
$SRJ_SERIES = array(

  array(
    'tag'   => 'Pillar I',
    'slug'  => 'ai-business-services',
    'name'  => 'AI Business Services',            // &trade; appended in markup
    'blurb' => 'Operating discipline, measurable performance, and financial visibility. Business-first, not technology-first. Four books that take a leadership team from its first AI audit through full operating maturity.',
    'books' => array(
      array(
        'series' => 'The Operating Discipline for AI Library&trade;',
        'num' => 'Book 01', 'title' => 'The AI Business Enablement Audit',
        'slug' => 'the-ai-business-enablement-audit',
        'status' => 'available', 'status_label' => 'Available Now',
        'summary' => 'The diagnostic foundation of the series. A structured, plain-English evaluation of how AI is operating across a business, what it is costing fully loaded, and whether it is producing measurable outcomes.',
      ),
      array(
        'series' => 'The Operating Discipline for AI Library&trade;',
        'num' => 'Book 02', 'title' => 'The AI Readiness &amp; Performance Assessment',
        'slug' => 'the-ai-readiness-performance-assessment',
        'status' => 'available', 'status_label' => 'Available Now',
        'summary' => 'A forward-looking evaluation of whether the organization is prepared to scale AI responsibly — workflow maturity, data quality, internal controls, and the measurement infrastructure that AI depends on.',
      ),
      array(
        'series' => 'The Operating Discipline for AI Library&trade;',
        'num' => 'Book 03', 'title' => 'The AI Risk &amp; Governance Review',
        'slug' => 'the-ai-risk-governance-review',
        'status' => 'available', 'status_label' => 'Available Now',
        'summary' => 'The governance discipline of the Library. A 6-Step Review that turns AI use cases into a per-use-case dossier a regulator, an acquirer, a carrier, or a board can read in one sitting. The AI Governance Framework Crosswalk maps the artifacts to ISO/IEC 42001, the NIST AI RMF, the EU AI Act, NYC Local Law 144, and SR 11-7. Plain English; no background in AI law or formal standards required.',
      ),
      array(
        'series' => 'The Operating Discipline for AI Library&trade;',
        'num' => 'Book 04', 'title' => 'The AI Efficiency &amp; Process Optimization',
        'slug' => 'the-ai-efficiency-process-optimization',
        'status' => 'forthcoming', 'status_label' => 'Forthcoming',
        'summary' => 'Once AI is understood and governed, this book turns to operational effectiveness — repeatable processes, reduced manual effort, and labor savings that are genuinely captured. The closing volume of Pillar I.',
      ),
    ),
  ),

  array(
    'tag'   => 'Pillar II',
    'slug'  => 'ai-risk-governance-security',
    'name'  => 'AI Risk Governance &amp; Security',
    'blurb' => 'Protection and exposure management. Books 05 through 09 of the canon cover the audit, the governance machinery, and the three security disciplines AI has structurally changed: product, application, and cloud.',
    'books' => array(
      array(
        'series' => 'The Operating Discipline for AI Library&trade;',
        'num' => 'Book 05', 'title' => 'The AI IT Security Audit',
        'slug' => 'the-ai-it-security-audit',
        'status' => 'forthcoming', 'status_label' => 'Forthcoming',
        'summary' => 'A CISO-grade audit framework for proving AI exposure is known, controlled, and governed &mdash; an exposure map, remediation roadmap, regulatory crosswalk, and board briefing across the six domains.',
      ),
      array(
        'series' => 'The Operating Discipline for AI Library&trade;',
        'num' => 'Book 06', 'title' => 'The AI IT Security Implementation &amp; Strategy',
        'slug' => 'the-ai-it-security-implementation-strategy',
        'status' => 'forthcoming', 'status_label' => 'Forthcoming',
        'summary' => 'The operating manual for proving AI risk is governed — ratified policies, an integrated risk register, a regulatory crosswalk, and board reporting that survives the question. A discipline to operate, not a project to complete.',
      ),

      /* v1.28 — Books 07/08/09 of Pillar II (Security in the Age of AI). */
      array(
        'series' => 'The Operating Discipline for AI Library&trade;',
        'num' => 'Book 07', 'title' => 'Secure by Design in the Age of AI',
        'slug' => 'the-secure-by-design',
        'status' => 'forthcoming', 'status_label' => 'Forthcoming',
        'summary' => 'Engineering velocity is up an order of magnitude. Security review capacity is not. The Dual-Impedance Problem and the five-framework operating model that closes it for organizations shipping AI-enabled products.',
      ),
      array(
        'series' => 'The Operating Discipline for AI Library&trade;',
        'num' => 'Book 08', 'title' => 'Application Security in the Age of AI',
        'slug' => 'the-application-security',
        'status' => 'forthcoming', 'status_label' => 'Forthcoming',
        'summary' => 'Every AppSec tool was built on the premise that an application produces the same output for the same input. AI invalidated that. The Runtime Determinism Gap and the AppSec program model for applications that no longer behave deterministically.',
      ),
      array(
        'series' => 'The Operating Discipline for AI Library&trade;',
        'num' => 'Book 09', 'title' => 'Cloud and Infrastructure Security in the Age of AI',
        'slug' => 'the-cloud-infrastructure-security',
        'status' => 'forthcoming', 'status_label' => 'Forthcoming',
        'summary' => 'Cloud security was built on the premise that every meaningful action could be traced to an accountable human. AI broke that. The Sovereignty Problem and the cloud security operating model for an era where most actors are not human.',
      ),
    ),
  ),
);

$books_home = home_url( '/books/' );
?>

<style>
  :root {
    --navy: #201868; --orange: #F07800; --white: #FFFFFF;
    --paper: #FAFAFA; --gray: #7A8A9E; --gray-light: #E8ECF1;
    --gray-fill: #F5F5F7; --ink: #1A1A2E;
  }
  .books-page { background: var(--white); color: var(--ink); }
  .books-page .container { max-width: 1200px; margin: 0 auto; padding: 0 32px; }

  /* HERO */
  .books-hero { padding: 96px 0 64px; border-bottom: 1px solid var(--gray-light); }
  .books-hero .eyebrow {
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: .18em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 28px;
  }
  .books-hero h1 {
    font-family: 'Lora', serif; font-size: 52px; line-height: 1.07;
    font-weight: 500; color: var(--navy); margin: 0 0 24px; max-width: 880px;
  }
  .books-hero h1 em { font-style: italic; color: var(--orange); font-weight: 500; }
  .books-hero .lede {
    font-family: 'Poppins', sans-serif; font-size: 19px; line-height: 1.55;
    color: var(--ink); max-width: 720px; margin: 0;
  }

  /* PILLAR SECTION */
  .pillar-section { padding: 76px 0 0; }
  .pillar-section .tag {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--gray);
    margin-bottom: 14px;
  }
  .pillar-section h2 {
    font-family: 'Lora', serif; font-size: 36px; line-height: 1.15;
    font-weight: 500; color: var(--navy); margin: 0 0 16px;
  }
  .pillar-section h2 em { font-style: italic; color: var(--orange); font-weight: 500; }
  .pillar-section .pillar-blurb {
    font-family: 'Poppins', sans-serif; font-size: 16px; line-height: 1.6;
    color: var(--ink); max-width: 720px; margin: 0 0 36px;
  }

  /* BOOK CARDS */
  .books-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
  @media (max-width: 820px) { .books-grid { grid-template-columns: 1fr; } }

  .book-card {
    position: relative; display: flex; flex-direction: column;
    background: var(--white); padding: 36px 32px 30px;
    border: 1px solid var(--gray-light);
    text-decoration: none; color: var(--ink);
    transition: border-color .25s ease, transform .25s ease, box-shadow .25s ease;
  }
  .book-card::before, .book-card::after {
    content: ''; position: absolute; width: 20px; height: 20px;
    border: 2px solid var(--navy);
  }
  .book-card::before { top: -1px; left: -1px; border-right: 0; border-bottom: 0; }
  .book-card::after  { bottom: -1px; right: -1px; border-left: 0; border-top: 0; }
  .book-card:hover {
    border-color: var(--orange); transform: translateY(-2px);
    box-shadow: 0 10px 28px -12px rgba(32,24,104,.18); color: var(--ink);
  }
  .book-card.forthcoming { background: var(--paper); }
  .book-card.forthcoming::before, .book-card.forthcoming::after { border-color: var(--gray); }

  .book-card .bc-num {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 12px;
  }
  .book-card.forthcoming .bc-num { color: var(--gray); }

  /* v1.28: per-card series eyebrow (multi-series pillar). */
  .book-card .bc-series {
    font-family: 'Poppins', sans-serif; font-size: 10.5px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 6px;
  }
  .book-card.forthcoming .bc-series { color: var(--gray); }
  .book-card h3 {
    font-family: 'Lora', serif; font-size: 24px; line-height: 1.25;
    font-weight: 500; color: var(--navy); margin: 0 0 14px;
  }
  .book-card .bc-status {
    display: inline-block; align-self: flex-start;
    font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 600;
    letter-spacing: .12em; text-transform: uppercase;
    padding: 5px 11px; margin-bottom: 18px;
  }
  .book-card .bc-status.available   { background: var(--orange); color: var(--white); }
  .book-card .bc-status.forthcoming { background: var(--gray-light); color: var(--gray); }
  .book-card .bc-summary {
    font-family: 'Poppins', sans-serif; font-size: 14.5px; line-height: 1.6;
    color: var(--ink); margin: 0 0 22px;
  }
  .book-card.forthcoming .bc-summary { color: var(--gray); }
  .book-card .bc-cta {
    margin-top: auto;
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: .08em; text-transform: uppercase; color: var(--navy);
  }
  .book-card:hover .bc-cta { color: var(--orange); }
  .book-card .bc-cta .arrow { transition: transform .2s ease; display: inline-block; }
  .book-card:hover .bc-cta .arrow { transform: translateX(3px); }

  /* PILLAR LINK ROW */
  .pillar-foot { padding: 28px 0 0; }
  .pillar-foot a {
    font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600;
    letter-spacing: .06em; color: var(--navy); text-decoration: none;
    border-bottom: 1px solid var(--navy); padding-bottom: 2px;
    transition: color .2s ease, border-color .2s ease;
  }
  .pillar-foot a:hover { color: var(--orange); border-bottom-color: var(--orange); }

  /* SERIES CTA */
  .series-cta { padding: 92px 0; background: var(--paper); margin-top: 80px;
    border-top: 1px solid var(--gray-light); border-bottom: 1px solid var(--gray-light); }
  .series-cta .label {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 18px;
  }
  .series-cta h2 {
    font-family: 'Lora', serif; font-size: 40px; line-height: 1.15;
    font-weight: 500; color: var(--navy); margin: 0 0 20px; max-width: 700px;
  }
  .series-cta h2 em { font-style: italic; color: var(--orange); }
  .series-cta p {
    font-family: 'Poppins', sans-serif; font-size: 17px; line-height: 1.6;
    color: var(--ink); margin: 0 0 34px; max-width: 620px;
  }
  .cta-buttons { display: flex; gap: 16px; flex-wrap: wrap; }
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

  /* v1.29 &mdash; Executive Summary box (top-of-page AEO anchor). */
  .books-summary { padding: 32px 0 0; }
  .books-summary-inner { background: #FFF6EC; border-left: 4px solid var(--orange); padding: 26px 30px 28px; }
  .books-summary-label {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .18em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 10px;
  }
  .books-summary p {
    font-family: 'Poppins', sans-serif; font-size: 15.5px; line-height: 1.65;
    color: var(--navy); margin: 0;
  }
  .books-summary p strong { color: var(--navy); font-weight: 600; }

  @media (max-width: 720px) {
    .books-hero h1 { font-size: 36px; }
    .books-hero .lede { font-size: 17px; }
    .pillar-section h2 { font-size: 29px; }
    .series-cta h2 { font-size: 30px; }
  }
</style>

<main class="books-page">

  <!-- HERO -->
  <section class="books-hero">
    <div class="container">
      <?php if ( function_exists( 'srj_breadcrumbs' ) ) { srj_breadcrumbs(); } ?>
      <div class="eyebrow">SRJ Consulting &middot; Books</div>
      <h1>Nine books on running AI with <em>operating discipline.</em></h1>
      <p class="lede">Nine books. One operating system. <em>The Operating Discipline for AI Library&trade;</em> is the nine-book series behind the AI Operating System &mdash; the complete framework for bringing AI under business control, from enablement through governance to the three security disciplines AI has structurally changed. Each book maps to one of the nine service lines at SRJ Consulting &amp; Services, with the frameworks, case patterns, and working templates a leadership team uses to bring AI under operating control.</p>
    </div>
  </section>

  <?php /* v1.29 &mdash; Executive Summary box (top-of-page AEO anchor). */ ?>
  <section class="books-summary">
    <div class="container">
      <div class="books-summary-inner">
        <div class="books-summary-label">What The Operating Discipline for AI Library&trade; is</div>
        <p><strong>Nine books mapped one-to-one against the nine service lines at SRJ Consulting &amp; Services.</strong> Each book is a working methodology, not a survey, the frameworks, case patterns, and templates a leadership team uses to bring AI under operating control. Volumes I and II are available now; Volumes III through IX are forthcoming.</p>
      </div>
    </div>
  </section>

  <?php foreach ( $SRJ_SERIES as $pillar ) :
    $pillar_url = trailingslashit( $books_home . $pillar['slug'] );
  ?>
  <!-- PILLAR -->
  <section class="pillar-section">
    <div class="container">
      <div class="tag"><?php echo esc_html( $pillar['tag'] ); ?></div>
      <h2><?php echo wp_kses_post( $pillar['name'] ); ?><em>&trade;</em></h2>
      <p class="pillar-blurb"><?php echo wp_kses_post( $pillar['blurb'] ); ?></p>

      <div class="books-grid">
        <?php foreach ( $pillar['books'] as $b ) :
          $is_available = ( 'available' === $b['status'] );
          $book_url     = trailingslashit( $pillar_url . $b['slug'] );
        ?>
        <a class="book-card <?php echo $is_available ? 'available' : 'forthcoming'; ?>"
           href="<?php echo esc_url( $book_url ); ?>">
          <?php if ( ! empty( $b['series'] ) ) : ?>
          <div class="bc-series"><?php echo esc_html( $b['series'] ); ?></div>
          <?php endif; ?>
          <div class="bc-num"><?php echo esc_html( $b['num'] ); ?></div>
          <h3><?php echo wp_kses_post( $b['title'] ); ?>&trade;</h3>
          <span class="bc-status <?php echo esc_attr( $b['status'] ); ?>">
            <?php echo esc_html( $b['status_label'] ); ?>
          </span>
          <p class="bc-summary"><?php echo wp_kses_post( $b['summary'] ); ?></p>
          <span class="bc-cta">
            <?php echo $is_available ? 'View the book' : 'Read more'; ?>
            <span class="arrow">&rarr;</span>
          </span>
        </a>
        <?php endforeach; ?>
      </div>

      <div class="pillar-foot">
        <a href="<?php echo esc_url( $pillar_url ); ?>">
          Explore <?php echo wp_kses_post( $pillar['name'] ); ?>&trade; &rarr;
        </a>
      </div>
    </div>
  </section>
  <?php endforeach; ?>

  <!-- SERIES CTA -->
  <section class="series-cta">
    <div class="container">
      <div class="label">Stay Informed</div>
      <h2>Get notified when each book <em>launches.</em></h2>
      <p>Subscribe to The AI Operating System&trade; newsletter for launch announcements, advance excerpts, and the methodology refinements that shape each book in the series. Bi-weekly. Operator-led. No software pitches.</p>
      <div class="cta-buttons">
        <a class="btn-primary" href="https://srj-consulting-services.beehiiv.com" target="_blank" rel="noopener noreferrer">
          Subscribe to the Newsletter <span class="arrow">&rarr;</span>
        </a>
        <a class="btn-secondary" href="<?php echo esc_url( srj_get_calendly() ); ?>" target="_blank" rel="noopener">
          Schedule a Consultation
        </a>
      </div>
    </div>
  </section>

</main>

<?php
get_footer();
