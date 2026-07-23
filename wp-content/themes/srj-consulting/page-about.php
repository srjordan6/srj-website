<?php
/**
 * Template Name: About
 *
 * The template for displaying the About page.
 *
 * MIGRATION NOTES (Phase 1, 2026-05-17)
 * -----------------------------------------
 * This template was migrated from a fully hardcoded PHP layout to a
 * Gutenberg-driven layout. Page content now lives in the WordPress page
 * editor (Pages -> About) rather than in this file.
 *
 * The previous version of this file is preserved as
 *   page-about.php.pre-migration.bak
 * If you need to roll back, rename the .bak file back to page-about.php
 * via SFTP and the old layout returns immediately.
 *
 * VOLUME II LAUNCH CALLOUT (2026-06-18)
 * -----------------------------------------
 * A book-launch callout is injected between the breadcrumbs and the
 * Gutenberg content area to announce Volume II of The Operating Discipline
 * for AI Library. This is an interim hardcoded block. It can be migrated
 * to a reusable Gutenberg block in the future without breaking anything,
 * the_content() below is unchanged.
 *
 * @package SRJ_Consulting
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main about-page about-page-gutenberg">

    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'about-article' ); ?>>
            <?php if ( function_exists( 'srj_breadcrumbs' ) ) : ?>
            <div class="container" style="padding-top:24px;padding-bottom:4px;">
                <?php srj_breadcrumbs(); ?>
            </div>
            <?php endif; ?>

            <style>
              .book-cta { padding: 60px 0 70px; background: var(--paper); border-bottom: 1px solid var(--line); }
              .book-cta-card { max-width: 880px; margin: 0 auto; background: var(--navy-deep); border-radius: 4px; padding: 0; display: grid; grid-template-columns: 1.4fr 1fr; gap: 0; align-items: stretch; box-shadow: 0 30px 60px -28px rgba(36, 24, 91, 0.28); overflow: hidden; position: relative; }
              .book-cta-card::before { content: ''; position: absolute; top: 0; right: 0; width: 38%; height: 100%; background: radial-gradient(ellipse at 70% 30%, rgba(239,124,0,.22), transparent 65%); pointer-events: none; }
              .book-cta-content { padding: 52px 48px; color: var(--paper); position: relative; }
              .book-cta-content .label { color: rgba(245,160,78,.85); margin-bottom: 18px; font-family: 'Inter', sans-serif; font-size: 10.5px; letter-spacing: .24em; text-transform: uppercase; font-weight: 600; }
              .book-cta-content h2 { font-family: 'Alike', serif; font-size: clamp(26px, 2.8vw, 34px); line-height: 1.2; margin-bottom: 18px; color: var(--paper); }
              .book-cta-content h2 em { font-style: italic; color: var(--orange); }
              .book-cta-content p { color: rgba(250,250,246,.78); font-size: 15.5px; line-height: 1.7; margin-bottom: 28px; }
              .book-cta-actions { display: flex; gap: 14px; flex-wrap: wrap; align-items: center; }
              .btn-book-buy { display: inline-flex; align-items: center; gap: 10px; padding: 14px 26px; background: var(--orange); color: var(--paper); font-family: 'Inter', sans-serif; font-size: 12.5px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; transition: all .25s ease; border: 1px solid var(--orange); text-decoration: none; }
              .btn-book-buy:hover { background: #d96a00; border-color: #d96a00; transform: translateY(-1px); }
              .btn-book-detail { display: inline-flex; align-items: center; gap: 10px; padding: 14px 26px; background: transparent; color: var(--paper); font-family: 'Inter', sans-serif; font-size: 12.5px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; transition: all .25s ease; border: 1px solid rgba(250,250,246,.4); text-decoration: none; }
              .btn-book-detail:hover { border-color: var(--paper); background: rgba(250,250,246,.06); }
              .btn-book-buy .arrow, .btn-book-detail .arrow { transition: transform .25s ease; }
              .btn-book-buy:hover .arrow, .btn-book-detail:hover .arrow { transform: translateX(4px); }
              .book-cta-meta { background: rgba(0,0,0,.18); padding: 44px 32px; display: flex; flex-direction: column; justify-content: center; align-items: center; position: relative; border-left: 1px solid rgba(250,250,246,.08); }
              .book-cta-meta .book-cover { display: block; width: 100%; max-width: 240px; height: auto; box-shadow: 0 18px 36px -8px rgba(0,0,0,.55), 0 6px 12px -4px rgba(0,0,0,.4); border-radius: 2px; margin-bottom: 22px; }
              .book-cta-meta .book-meta-strip { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; justify-content: center; font-family: 'Inter', sans-serif; font-size: 11px; letter-spacing: .14em; text-transform: uppercase; }
              .book-cta-meta .meta-item { color: rgba(250,250,246,.85); font-weight: 500; }
              .book-cta-meta .meta-item.tag-available { background: var(--orange); color: var(--paper); padding: 5px 10px; font-weight: 600; letter-spacing: .14em; }
              .book-cta-meta .meta-divider { color: rgba(250,250,246,.3); }
              @media (max-width: 820px) {
                .book-cta-card { grid-template-columns: 1fr; }
                .book-cta-content { padding: 40px 32px; }
                .book-cta-meta { padding: 32px; border-left: none; border-top: 1px solid rgba(250,250,246,.08); }
                .book-cta-meta .book-cover { max-width: 200px; }
              }
            </style>

            <!-- VOLUME II LAUNCH CALLOUT -->
            <section class="book-cta">
              <div class="container">
                <div class="book-cta-card">
                  <div class="book-cta-content">
                    <div class="label">Now Available</div>
                    <h2>Volume II is in print: <em>The AI Readiness Assessment.</em></h2>
                    <p><em>The AI Readiness &amp; Performance Assessment&trade;</em>, Volume II of <em>The Operating Discipline for AI Library&trade;</em>, is the practical operating discipline for scaling AI in small and mid-sized businesses. It scores six readiness conditions on a five-point scale and drives one central decision the practice is built around: expand, refine, or pause.</p>
                    <div class="book-cta-actions">
                      <a href="https://www.amazon.com/dp/B0H5X83K31" target="_blank" rel="noopener" class="btn-book-buy">
                        Buy on Amazon <span class="arrow">&rarr;</span>
                      </a>
                      <a href="<?php echo esc_url( home_url( '/books/ai-business-services/the-ai-readiness-performance-assessment/' ) ); ?>" class="btn-book-detail">
                        Book Detail <span class="arrow">&rarr;</span>
                      </a>
                    </div>
                  </div>
                  <div class="book-cta-meta">
                    <img class="book-cover"
                         src="<?php echo esc_url( home_url( '/wp-content/uploads/2560px-x-1600px-kindle-cover-rgb.jpg' ) ); ?>"
                         alt="The AI Readiness &amp; Performance Assessment book cover, Volume II of The Operating Discipline for AI Library"
                         width="1600"
                         height="2560"
                         loading="lazy" />
                    <div class="book-meta-strip">
                      <span class="meta-item">Volume II</span>
                      <span class="meta-divider">&middot;</span>
                      <span class="meta-item tag-available">Available Now</span>
                      <span class="meta-divider">&middot;</span>
                      <span class="meta-item">331 Pages</span>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <div class="about-content entry-content">
                <?php the_content(); ?>
            </div>
        </article>

    <?php endwhile; ?>

</main>

<?php
get_footer();
