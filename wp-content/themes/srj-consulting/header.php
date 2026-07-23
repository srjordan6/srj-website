<?php
/**
 * Header template.
 * Renders <head>, opening body, announce bar, primary nav, and the
 * site-search slide-down panel.
 *
 * Page templates pass $args['current_page'] via get_header() the WordPress way:
 *   get_header( 'page-name' ); // uses header-page-name.php
 * Or set $GLOBALS['srj_current_nav'] before calling get_header().
 *
 * v1.2 (July 13, 2026): the search-toggle button moved from a floating
 * top-right position into the announce bar (see helpers.php v1.7.0
 * srj_announce_bar). This file now renders only the slide-down search
 * panel and the toggle JS. The JS finds the toggle button by ID
 * ("srj-search-toggle") regardless of where it lives.
 *
 * v1.1 (July 13, 2026): added floating site-search toggle icon and
 * slide-down search field below the nav (superseded by v1.2, above).
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="profile" href="https://gmpg.org/xfn/11" />

<?php /* Meta description removed May 2026 - Rank Math SEO is now the single source. Removed to fix duplicate meta description tags. */ ?>

<?php /* Canonical tag removed May 2026 (v1.4) - Rank Math SEO outputs the
         canonical for every page. The theme previously also emitted one here,
         producing two <link rel="canonical"> tags per page (flagged as
         "Multiple Canonicals" on 23 URLs in the SEO audit). Rank Math is the
         single source of canonicals, consistent with it being the single
         source of meta tags and schema. */ ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
srj_announce_bar();
$current_nav = isset( $GLOBALS['srj_current_nav'] ) ? $GLOBALS['srj_current_nav'] : '';
srj_main_nav( $current_nav );
?>

<?php /* -----------------------------------------------------------------
       SITE SEARCH slide-down panel (v1.2, July 13, 2026).

       The toggle button lives in the announce bar (helpers.php
       srj_announce_bar()). Clicking it opens this panel, a full-width
       slide-down bar containing the search form. Submitting sends the
       visitor to /?s=<query> where search.php renders results
       (Relevanssi-powered).

       Mobile fallback: on <=980px viewports the announce-bar search
       toggle is hidden by CSS (announce-search.hide-mobile). A small
       floating bottom-right toggle is provided below for mobile access.

       Relevanssi Live Ajax Search will auto-decorate the input if the
       plugin's target selector in WP admin includes:
         .srj-search-panel input[name="s"], .srj-search-form-hero input[name="s"]
   ----------------------------------------------------------------- */ ?>
<div class="srj-search-panel" id="srj-site-search-panel" aria-hidden="true" role="search">
  <div class="container">
    <form method="get" class="srj-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
      <label for="srj-site-search-input" class="screen-reader-text">Search</label>
      <input
        type="search"
        id="srj-site-search-input"
        name="s"
        value="<?php echo esc_attr( is_search() ? get_search_query() : '' ); ?>"
        placeholder="Search books, services, AI governance topics, insights..."
        autocomplete="off"
      />
      <button type="submit" class="srj-search-submit">Search</button>
      <button type="button" class="srj-search-close" id="srj-search-close" aria-label="Close search">&times;</button>
    </form>
  </div>
</div>

<?php /* Mobile-only floating search toggle. Hidden on desktop by CSS.
        Uses the same ID pattern by adding a second element with the
        same id? No, IDs must be unique. Instead, this button uses
        id="srj-search-toggle-mobile" and the JS below listens on it
        as an additional trigger. */ ?>
<button type="button" class="srj-search-toggle-mobile" id="srj-search-toggle-mobile"
        aria-label="Search the site" aria-expanded="false" aria-controls="srj-site-search-panel">
  <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" focusable="false">
    <circle cx="11" cy="11" r="7" fill="none" stroke="currentColor" stroke-width="2"/>
    <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>
</button>

<script>
(function () {
  // Toggle button in the announce bar (desktop) and mobile fallback.
  var toggleA = document.getElementById('srj-search-toggle');
  var toggleB = document.getElementById('srj-search-toggle-mobile');
  var panel   = document.getElementById('srj-site-search-panel');
  var input   = document.getElementById('srj-site-search-input');
  var closeBtn = document.getElementById('srj-search-close');

  if ( ! panel || ! input ) { return; }

  function setOpen( open ) {
    panel.classList.toggle('is-open', open);
    panel.setAttribute('aria-hidden', open ? 'false' : 'true');
    if ( toggleA ) { toggleA.setAttribute('aria-expanded', open ? 'true' : 'false'); }
    if ( toggleB ) { toggleB.setAttribute('aria-expanded', open ? 'true' : 'false'); }
    if ( open ) {
      setTimeout( function () { input.focus(); input.select(); }, 60 );
    }
  }

  function bindToggle( btn ) {
    if ( ! btn ) { return; }
    btn.addEventListener('click', function ( e ) {
      e.preventDefault();
      setOpen( ! panel.classList.contains('is-open') );
    });
  }
  bindToggle( toggleA );
  bindToggle( toggleB );

  if ( closeBtn ) {
    closeBtn.addEventListener('click', function () { setOpen(false); });
  }

  // Escape closes the panel.
  document.addEventListener('keydown', function (e) {
    if ( e.key === 'Escape' && panel.classList.contains('is-open') ) { setOpen(false); }
  });

  // Click outside the panel closes it (excluding the two toggles).
  document.addEventListener('click', function (e) {
    if ( ! panel.classList.contains('is-open') ) { return; }
    if ( panel.contains(e.target) ) { return; }
    if ( toggleA && toggleA.contains(e.target) ) { return; }
    if ( toggleB && toggleB.contains(e.target) ) { return; }
    setOpen(false);
  });
})();
</script>
