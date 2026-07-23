<?php
/**
 * Helper functions for the SRJ Consulting theme.
 *
 * v1.7.0 (July 13, 2026): added site-search icon to srj_announce_bar(),
 * positioned between the email address (announce-left) and the Schedule
 * link (announce-right) via a new .announce-search wrapper. Icon is a
 * small magnifier SVG button (aria-labeled "Search") that triggers the
 * slide-down search panel rendered in header.php. Powered by Relevanssi
 * plus the srj-relevanssi-config-indexer mu-plugin. Results render at
 * /?s=query via search.php. The floating top-right toggle button that
 * was briefly deployed earlier the same day has been removed from
 * header.php; this announce-bar placement replaces it. The button ID
 * is "srj-search-toggle" so the existing header.php JS finds it without
 * change. Mobile: on <=980px viewports the announce-bar Schedule link
 * hides (existing behaviour) and the search icon also hides; mobile
 * search access is still available via a fallback bottom-right floating
 * icon injected from header.php on narrow viewports only.
 *
 * v1.8.0 (July 20, 2026): nav consolidation. "AI Governance" and
 * "Insights" are replaced by a single "Resources" item pointing at
 * /resources/, in both the desktop nav and the mobile slide-in panel.
 * Nine items drop to eight. No URL moves: /ai-governance/ and its 61
 * pages, and /insights/, keep their addresses and are reached from the
 * Resources page. Grouping only, so no redirects and no reindexing.
 *
 * v1.6.0 (July 13, 2026): added "AI Governance" nav item between Books
 * and Insights in srj_main_nav(), both the desktop nav and the mobile
 * slide-in panel. Links to /ai-governance/ (the AI Governance hub page,
 * which is a 15-category reference library backed by a Type-3
 * config-driven detail template). Also removed the "Schedule a Free
 * AI Consultation" CTA link from the desktop nav's <ul> to free up
 * horizontal space on the primary nav bar; the mobile-panel Schedule
 * CTA below the link list is retained since mobile has vertical space.
 * The announce-bar Schedule link (srj_announce_bar()) and every
 * page-level CTA (srj_inline_cta, srj_final_cta) are unchanged, so
 * scheduling remains prominently accessible throughout the site,
 * just not duplicated in the desktop primary nav.
 *
 * v1.5.0 (June 27, 2026): added "Applications" nav item between Services
 * and Industries in srj_main_nav(), both the desktop nav and the mobile
 * slide-in panel. Links to /applications/ (the Applications hub page).
 *
 * v1.4.0 (June 2026): added srj_get_scheduler_embed_url() helper for
 * the raw Zoom Scheduler URL. Used by both page-schedule-consultation.php
 * and page-contact.php to render the booking iframe, so the underlying
 * scheduler URL lives in exactly one place. The on-domain
 * srj_get_booking() helper (returns /schedule-consultation/) is unchanged
 * and remains the canonical site-wide CTA target.
 *
 * v1.3.0 (May 2026): srj_main_nav() rebuilt with a mobile hamburger
 * menu. Desktop nav markup is unchanged; below 980px the desktop nav
 * hides and a slide-in panel takes over. All other functions are
 * untouched.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Get phone number for display.
 */
function srj_get_phone() {
    return get_theme_mod( 'srj_phone_display', '(415) 413-7772' );
}

/**
 * Get phone number for tel: links.
 */
function srj_get_phone_tel() {
    return get_theme_mod( 'srj_phone_tel', '+14154137772' );
}

/**
 * Get email address.
 */
function srj_get_email() {
    return get_theme_mod( 'srj_email', 'info@srjconsultingservices.com' );
}

/**
 * Get the public booking page URL.
 *
 * Points at the on-domain booking page (/schedule-consultation/), not directly
 * at the third-party scheduler. The Zoom Scheduler iframe lives inside that
 * page (page-schedule-consultation.php). Routing every site CTA through the
 * on-domain URL keeps visitors on srjconsultingservices.com and means the
 * underlying scheduler can be swapped without touching every CTA again.
 *
 * Replaced srj_get_calendly() (still available as an alias below) when the
 * site moved from Calendly to Zoom Scheduler.
 */
function srj_get_booking() {
    return get_theme_mod( 'srj_booking_url', trailingslashit( home_url() ) . 'schedule-consultation/' );
}

/**
 * Backwards-compat alias for srj_get_calendly().
 *
 * Kept so any template, page, or include that still calls srj_get_calendly()
 * continues to work after the move from Calendly to Zoom Scheduler. New code
 * should call srj_get_booking() directly.
 */
function srj_get_calendly() {
    return srj_get_booking();
}

/**
 * Get the raw Zoom Scheduler embed URL.
 *
 * Returns the third-party scheduler URL itself, NOT the on-domain booking
 * page. Used to render the actual booking iframe. The iframe currently lives
 * on /schedule-consultation/ (page-schedule-consultation.php) and on
 * /contact/ (page-contact.php, below the WPForms shortcode).
 *
 * The embedStyle buttonColor (#F07800, brand orange) and the origin parameter
 * (srjconsultingservices.com, which restricts Zoom's postMessage to this
 * domain) are baked into the URL. To swap the underlying scheduler later,
 * replace the default value here in one place, or override it from the
 * Customizer (Appearance → Customize → "srj_scheduler_embed_url"). Site
 * CTAs continue to use srj_get_booking() and remain unaffected.
 *
 * @return string Raw scheduler URL, unescaped. Callers must escape on output
 *                (e.g. esc_url() inside an iframe src attribute).
 */
function srj_get_scheduler_embed_url() {
    $default = 'https://scheduler.zoom.us/stephen-jordan-tbny1a/30-mins-with-srj-consulting-services?embedStyle=%7B%22buttonColor%22%3A%22%23f07800%22%7D&origin=srjconsultingservices.com&embed=true';
    return get_theme_mod( 'srj_scheduler_embed_url', $default );
}

/**
 * Get office address parts.
 */
function srj_get_address_line1() {
    return get_theme_mod( 'srj_address_line1', '13054 Cinderella Ln' );
}

function srj_get_address_line2() {
    return get_theme_mod( 'srj_address_line2', 'Frisco, TX' );
}

function srj_get_office_short() {
    return get_theme_mod( 'srj_office_short', 'Frisco, TX' );
}

/**
 * Render the announcement bar (top dark strip with phone, email, search, schedule link).
 *
 * v1.7.0 (July 13, 2026): search icon added between the email address and
 * the Schedule link. Button ID "srj-search-toggle" matches the JS in
 * header.php that opens the slide-down search panel.
 */
function srj_announce_bar() {
    ?>
    <div class="announce">
      <div class="container row">
        <div class="announce-left">
          <span class="loc"><?php echo esc_html( srj_get_office_short() ); ?></span>
          <a href="tel:<?php echo esc_attr( srj_get_phone_tel() ); ?>"><span class="pip">&#9679;</span> <?php echo esc_html( srj_get_phone() ); ?></a>
          <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>" class="hide-mobile"><?php echo esc_html( srj_get_email() ); ?></a>
        </div>
        <div class="announce-right">
          <button type="button" class="announce-search hide-mobile" id="srj-search-toggle"
                  aria-label="Search the site" aria-expanded="false" aria-controls="srj-site-search-panel">
            <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false">
              <circle cx="11" cy="11" r="7" fill="none" stroke="currentColor" stroke-width="2"/>
              <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span class="announce-search-label">Search</span>
          </button>
          <a href="<?php echo esc_url( srj_get_calendly() ); ?>" target="_blank" rel="noopener">Schedule a Free AI Consultation <span class="arrow">&rarr;</span></a>
        </div>
      </div>
    </div>
    <?php
}

/**
 * Render the primary navigation header.
 *
 * Desktop nav (>980px) is unchanged. Below 980px the desktop nav is
 * hidden by CSS and a hamburger button opens a slide-in mobile panel.
 * The toggle script is inline and self-contained, so nothing needs to
 * be enqueued. Mobile menu styling lives in assets/css/style.css under
 * the "MOBILE NAVIGATION" section.
 *
 * @param string $current_page Slug of current page for active state.
 */
function srj_main_nav( $current_page = '' ) {
    $home = trailingslashit( home_url() );

    // Adds class="is-active" to the matching desktop link.
    $is_active = function( $slug ) use ( $current_page ) {
        return $slug === $current_page ? ' class="is-active"' : '';
    };
    // Adds aria-current="page" to the matching mobile-panel link.
    $is_current = function( $slug ) use ( $current_page ) {
        return $slug === $current_page ? ' aria-current="page"' : '';
    };
    ?>
    <header class="nav">
      <div class="container nav-inner">
        <a href="<?php echo esc_url( $home ); ?>" class="logo" style="text-decoration:none">
          <div class="logo-mark">SRJ Consulting<span class="amp">&amp;</span>Services</div>
          <div class="logo-tag">The Operating Discipline for AI Library&trade;</div>
        </a>

        <?php /* Desktop navigation. Visible above 980px only. */ ?>
        <nav class="primary">
          <ul>
            <li><a href="<?php echo esc_url( $home . 'about/' ); ?>"<?php echo $is_active( 'about' ); ?>>About</a></li>
            <li><a href="<?php echo esc_url( $home . 'services/' ); ?>"<?php echo $is_active( 'services' ); ?>>Services</a></li>
            <li><a href="<?php echo esc_url( $home . 'applications/' ); ?>"<?php echo $is_active( 'applications' ); ?>>Applications</a></li>
            <li><a href="<?php echo esc_url( $home . 'industries/' ); ?>"<?php echo $is_active( 'industries' ); ?>>Industries</a></li>
            <li><a href="<?php echo esc_url( $home . 'books/' ); ?>"<?php echo $is_active( 'books' ); ?>>Books</a></li>
            <li><a href="<?php echo esc_url( $home . 'resources/' ); ?>"<?php echo $is_active( 'resources' ); ?>>Resources</a></li>
            <li><a href="<?php echo esc_url( $home . 'faq/' ); ?>"<?php echo $is_active( 'faq' ); ?>>FAQ</a></li>
            <li><a href="<?php echo esc_url( $home . 'contact/' ); ?>"<?php echo $is_active( 'contact' ); ?>>Contact</a></li>
          </ul>
        </nav>

        <?php /* Hamburger toggle. Visible below 980px only (CSS-controlled). */ ?>
        <button class="srj-nav-toggle" id="srj-nav-toggle" type="button"
                aria-label="Open menu" aria-expanded="false" aria-controls="srj-mobile-panel">
          <span class="srj-nav-toggle-bars" aria-hidden="true">
            <span></span><span></span><span></span>
          </span>
        </button>
      </div>
    </header>

    <?php /* Mobile menu: scrim + slide-in panel. Rendered at page level,
            OUTSIDE the sticky <header>, so it is not trapped in the
            header's stacking context and can layer above all content. */ ?>
    <div class="srj-mobile-scrim" id="srj-mobile-scrim"></div>
    <nav class="srj-mobile-panel" id="srj-mobile-panel" aria-label="Mobile navigation" aria-hidden="true">
      <div class="srj-mobile-panel-head">
        <span class="srj-mobile-panel-label">Menu</span>
        <button class="srj-mobile-close" id="srj-mobile-close" type="button" aria-label="Close menu">&#215;</button>
      </div>
      <ul class="srj-mobile-links">
        <li><a href="<?php echo esc_url( $home . 'about/' ); ?>"<?php echo $is_current( 'about' ); ?>>About</a></li>
        <li><a href="<?php echo esc_url( $home . 'services/' ); ?>"<?php echo $is_current( 'services' ); ?>>Services</a></li>
        <li><a href="<?php echo esc_url( $home . 'applications/' ); ?>"<?php echo $is_current( 'applications' ); ?>>Applications</a></li>
        <li><a href="<?php echo esc_url( $home . 'industries/' ); ?>"<?php echo $is_current( 'industries' ); ?>>Industries</a></li>
        <li><a href="<?php echo esc_url( $home . 'books/' ); ?>"<?php echo $is_current( 'books' ); ?>>Books</a></li>
        <li><a href="<?php echo esc_url( $home . 'resources/' ); ?>"<?php echo $is_current( 'resources' ); ?>>Resources</a></li>
        <li><a href="<?php echo esc_url( $home . 'faq/' ); ?>"<?php echo $is_current( 'faq' ); ?>>FAQ</a></li>
        <li><a href="<?php echo esc_url( $home . 'contact/' ); ?>"<?php echo $is_current( 'contact' ); ?>>Contact</a></li>
      </ul>
      <a href="<?php echo esc_url( srj_get_calendly() ); ?>" target="_blank" rel="noopener" class="srj-mobile-cta">Schedule a Free AI Consultation</a>
    </nav>

    <?php /* Toggle behaviour. Self-contained vanilla JS, no enqueue required. */ ?>
    <script>
    (function () {
      var toggle = document.getElementById('srj-nav-toggle');
      var panel  = document.getElementById('srj-mobile-panel');
      var scrim  = document.getElementById('srj-mobile-scrim');
      var closeBtn = document.getElementById('srj-mobile-close');
      if ( ! toggle || ! panel || ! scrim ) { return; }

      function setOpen( open ) {
        panel.classList.toggle('is-open', open);
        scrim.classList.toggle('is-open', open);
        toggle.classList.toggle('is-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        panel.setAttribute('aria-hidden', open ? 'false' : 'true');
        document.body.classList.toggle('srj-menu-open', open);
      }

      // Hamburger toggles the panel.
      toggle.addEventListener('click', function () {
        setOpen( ! panel.classList.contains('is-open') );
      });

      // Tapping the scrim closes it.
      scrim.addEventListener('click', function () { setOpen(false); });

      // The dedicated close (X) button inside the panel.
      if ( closeBtn ) {
        closeBtn.addEventListener('click', function () { setOpen(false); });
      }

      // Tapping any link inside the panel closes it.
      panel.addEventListener('click', function (e) {
        if ( e.target.closest('a') ) { setOpen(false); }
      });

      // Escape closes it.
      document.addEventListener('keydown', function (e) {
        if ( e.key === 'Escape' && panel.classList.contains('is-open') ) { setOpen(false); }
      });

      // Reset if the viewport grows back to desktop while open.
      window.addEventListener('resize', function () {
        if ( window.innerWidth > 980 && panel.classList.contains('is-open') ) { setOpen(false); }
      });
    })();
    </script>
    <?php
}

/**
 * Render an inline CTA strip.
 * @param string $text The headline text. Can include <em> tags.
 */
function srj_inline_cta( $text ) {
    ?>
    <div class="inline-cta">
      <div class="container">
        <div class="inline-cta-row">
          <div class="inline-cta-text"><?php echo wp_kses_post( $text ); ?></div>
          <div class="inline-cta-actions">
            <a href="tel:<?php echo esc_attr( srj_get_phone_tel() ); ?>" class="btn-inline-phone"><?php echo esc_html( srj_get_phone() ); ?></a>
            <a href="<?php echo esc_url( srj_get_calendly() ); ?>" target="_blank" rel="noopener" class="btn-inline-schedule">Schedule a Free AI Consultation <span class="arrow">&rarr;</span></a>
          </div>
        </div>
      </div>
    </div>
    <?php
}

/**
 * Render an Executive Note: a brand-styled pain callout.
 *
 * The sitewide "pain everywhere" device. One per major page (Home, the two
 * service pillars, the six service details, the ten industry pages). Speaks in
 * the operator voice and ties a concrete cost observation to a governance
 * signal. Styled by .srj-exec-note in assets/css/style.css. The canonical copy
 * lives in the Notion "Messaging & Pain Framework" page; tailor per page but
 * keep the structure (a cost observation, then the governance implication).
 *
 * @param string $text The note body. May include <em> for orange emphasis.
 */
function srj_exec_note( $text ) {
    ?>
    <section class="srj-exec-note-wrap">
      <div class="container">
        <aside class="srj-exec-note" role="note">
          <span class="srj-exec-note-label">Executive Note</span>
          <p class="srj-exec-note-body"><?php echo wp_kses_post( $text ); ?></p>
        </aside>
      </div>
    </section>
    <?php
}

/**
 * Render the final CTA section before footer.
 */
function srj_final_cta( $headline = 'Bring AI under <em>operating control.</em>', $subtext = '' ) {
    if ( empty( $subtext ) ) {
        $subtext = 'A 30-minute consultation to scope the question your leadership team needs answered. No deck, no pitch. A conversation about where your organization currently stands and what the right next step looks like.';
    }
    ?>
    <section class="cta" id="contact">
      <div class="container-narrow">
        <div class="label">Begin the Engagement</div>
        <h2><?php echo wp_kses_post( $headline ); ?></h2>
        <p><?php echo esc_html( $subtext ); ?></p>
        <div class="cta-actions">
          <a href="<?php echo esc_url( srj_get_calendly() ); ?>" target="_blank" rel="noopener" class="btn btn-primary">Schedule a Free AI Consultation <span class="arrow">&rarr;</span></a>
        </div>
        <div class="cta-phone-row">
          <span class="cta-phone-divider">or speak directly</span>
          <a href="tel:<?php echo esc_attr( srj_get_phone_tel() ); ?>" class="cta-phone-num"><?php echo esc_html( srj_get_phone() ); ?></a>
          <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>" class="cta-email"><?php echo esc_html( srj_get_email() ); ?></a>
        </div>
      </div>
    </section>
    <?php
}

/**
 * Render a compact page hero (for inner pages).
 */
function srj_page_hero( $label, $headline, $lede = '' ) {
    ?>
    <section class="page-hero">
      <div class="container">
        <?php srj_breadcrumbs(); ?>
        <div class="label"><?php echo wp_kses_post( $label ); ?></div>
        <h1><?php echo wp_kses_post( $headline ); ?></h1>
        <?php if ( $lede ) : ?>
        <p class="page-hero-lede"><?php echo wp_kses_post( $lede ); ?></p>
        <?php endif; ?>
      </div>
    </section>
    <?php
}

/**
 * Render breadcrumbs: visible trail + BreadcrumbList JSON-LD schema.
 *
 * Added May 2026 (SEO Day 7). Called automatically inside srj_page_hero(),
 * so every inner page using the standard hero gets breadcrumbs. Skips the
 * front page. To add breadcrumbs to a template that does not use the hero
 * (e.g. single.php), call srj_breadcrumbs() directly inside a container.
 */
function srj_breadcrumbs() {

    // No breadcrumbs on the homepage.
    if ( is_front_page() ) {
        return;
    }

    $crumbs = array();
    $crumbs[] = array( 'name' => 'Home', 'url' => home_url( '/' ) );

    if ( is_page() ) {
        global $post;
        $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
        foreach ( $ancestors as $ancestor_id ) {
            $crumbs[] = array(
                'name' => get_the_title( $ancestor_id ),
                'url'  => get_permalink( $ancestor_id ),
            );
        }
        $crumbs[] = array( 'name' => get_the_title( $post->ID ), 'url' => '' );

    } elseif ( is_singular( 'post' ) ) {
        $posts_page_id = (int) get_option( 'page_for_posts' );
        if ( $posts_page_id ) {
            $crumbs[] = array(
                'name' => get_the_title( $posts_page_id ),
                'url'  => get_permalink( $posts_page_id ),
            );
        }
        $crumbs[] = array( 'name' => get_the_title(), 'url' => '' );

    } elseif ( is_home() ) {
        $crumbs[] = array( 'name' => single_post_title( '', false ), 'url' => '' );

    } elseif ( is_category() || is_tag() || is_tax() ) {
        $crumbs[] = array( 'name' => single_term_title( '', false ), 'url' => '' );

    } elseif ( is_search() ) {
        $crumbs[] = array( 'name' => 'Search Results', 'url' => '' );

    } elseif ( is_404() ) {
        $crumbs[] = array( 'name' => 'Page Not Found', 'url' => '' );

    } elseif ( is_archive() ) {
        $crumbs[] = array( 'name' => wp_strip_all_tags( get_the_archive_title() ), 'url' => '' );

    } else {
        $crumbs[] = array( 'name' => wp_get_document_title(), 'url' => '' );
    }

    // Print the breadcrumb CSS once per page request.
    static $css_printed = false;
    if ( ! $css_printed ) {
        $css_printed = true;
        ?>
        <style>
          .breadcrumbs { margin: 0 0 18px; }
          .breadcrumbs ol {
            list-style: none; margin: 0; padding: 0;
            display: flex; flex-wrap: wrap; align-items: center;
            font-family: 'Poppins', sans-serif; font-size: 13px; line-height: 1.4;
          }
          .breadcrumbs li { display: flex; align-items: center; }
          .breadcrumbs li:not(:last-child)::after {
            content: '/'; margin: 0 8px; color: #7A8A9E;
          }
          .breadcrumbs a { color: #7A8A9E; text-decoration: none; transition: color .15s ease; }
          .breadcrumbs a:hover { color: #F07800; }
          .breadcrumbs span[aria-current] { color: #201868; font-weight: 600; }
        </style>
        <?php
    }

    // Visible breadcrumb trail.
    $last = count( $crumbs ) - 1;
    echo '<nav class="breadcrumbs" aria-label="Breadcrumb"><ol>';
    foreach ( $crumbs as $i => $crumb ) {
        echo '<li>';
        if ( $i !== $last && ! empty( $crumb['url'] ) ) {
            echo '<a href="' . esc_url( $crumb['url'] ) . '">' . esc_html( $crumb['name'] ) . '</a>';
        } else {
            echo '<span aria-current="page">' . esc_html( $crumb['name'] ) . '</span>';
        }
        echo '</li>';
    }
    echo '</ol></nav>';

    // BreadcrumbList JSON-LD structured data.
    $items = array();
    $position = 1;
    foreach ( $crumbs as $crumb ) {
        $item = array(
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => $crumb['name'],
        );
        if ( ! empty( $crumb['url'] ) ) {
            $item['item'] = $crumb['url'];
        }
        $items[] = $item;
        $position++;
    }
    $schema = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    );
    echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
}
