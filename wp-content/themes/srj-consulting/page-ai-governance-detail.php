<?php
/**
 * Template Name: AI Governance Detail
 *
 * Renders one category or subcategory page under /ai-governance/{...}/,
 * driven by the $SRJ_GOVERNANCE config keyed by page slug. Serves both
 * categories (15 pages) and subcategories (34 pages) with the same shape:
 * Pain, Detail, Why it matters, CTA. If the entry has children (a
 * category with subs), a "Deep dives in this category" block is
 * appended before the CTA.
 *
 * The template does the config lookup by the current page's post_name,
 * so any page under /ai-governance/ that carries this template will
 * auto-render if a matching entry exists in $SRJ_GOVERNANCE. No manual
 * routing needed beyond assigning the template on each page.
 *
 * Rank Math meta: each entry's focus_keyword, seo_title, and
 * meta_description are pushed into Rank Math via post meta at page
 * creation time by srj_create_default_pages() (see functions.php on
 * next current_version bump). Alternatively, set them manually in the
 * Rank Math sidebar per page. Both approaches yield an 80+ score
 * because the body_html is written to satisfy the checklist.
 *
 * v1 (July 10, 2026): Initial build. Config lookup by slug; renders
 * hero, TL;DR (from body_html), body, children block (conditional),
 * CTA to https://aiauditforcompanies.com/startaiaudit/.
 */
$GLOBALS['srj_current_nav'] = 'ai-governance';
get_header();

// Resolve the entry. Database first: one row for this page, plus a
// body-less index used only for the parent eyebrow and the child links.
// Rendering one page used to require the whole 1.2MB config and decode
// all 63 rows; this moves roughly 19KB instead. The PHP config is still
// the fallback, exactly as srj-ai-governance-db.php has always promised,
// and is loaded only when the database has no rows to serve.
$slug  = get_post_field( 'post_name', get_post() );
$entry = null;
$nav   = array();

if ( function_exists( 'srj_govdb_has_rows' ) && srj_govdb_has_rows() ) {
    $entry = srj_govdb_get( $slug );
    $nav   = srj_govdb_get_lite();
} else {
    $config_path = get_stylesheet_directory() . '/inc/ai-governance-config.php';
    if ( file_exists( $config_path ) ) {
        require $config_path;
    }
    if ( isset( $SRJ_GOVERNANCE ) && is_array( $SRJ_GOVERNANCE ) ) {
        $entry = isset( $SRJ_GOVERNANCE[ $slug ] ) ? $SRJ_GOVERNANCE[ $slug ] : null;
        $nav   = $SRJ_GOVERNANCE;
    }
}

if ( ! $entry ) {
    // Fallback: render a graceful placeholder rather than blank
    ?>
    <?php srj_page_hero( 'AI Governance', 'Page not yet configured' ); ?>
    <section class="longform"><div class="container">
      <p>This page is registered in the AI Governance library but its content has not been published yet. Please check back soon.</p>
      <p><a href="<?php echo esc_url( home_url( '/ai-governance/' ) ); ?>">&larr; Back to the AI Governance library</a></p>
    </div></section>
    <?php
    get_footer();
    return;
}

// Determine parent (for hero eyebrow) and children (for below-body block)
$parent_slug  = isset( $entry['parent'] ) ? $entry['parent'] : 'ai-governance';
$parent_title = 'AI Governance';
if ( $parent_slug !== 'ai-governance' && isset( $nav[ $parent_slug ] ) ) {
    $parent_title = $nav[ $parent_slug ]['title'];
}
$children = ( isset( $entry['children'] ) && is_array( $entry['children'] ) ) ? $entry['children'] : array();
?>

<?php srj_page_hero( $parent_title, $entry['title'] ); ?>

<section class="longform">
  <div class="container">

    <?php if ( ! empty( $entry['subtitle'] ) ) : ?>
      <p style="font-family:Poppins,sans-serif;font-size:18px;font-style:italic;color:#7A8A9E;margin:0 0 32px;max-width:760px;"><?php echo esc_html( $entry['subtitle'] ); ?></p>
    <?php endif; ?>

    <?php if ( ! empty( $entry['body_html'] ) ) : ?>
      <div class="srjgov-detail-body">
        <?php
        /**
         * Filter the governance body HTML before output.
         *
         * Seam for database-backed content. The SRJ AI Tools Inventory
         * mu-plugin uses it to swap the static catalog region on the
         * ai-tools page for output rendered from wp_srj_ai_tools. With no
         * filter attached, the config HTML renders exactly as before.
         *
         * @param string $body_html Body HTML from the governance config.
         * @param string $slug      Governance page slug.
         */
        echo apply_filters( 'srj_governance_body_html', $entry['body_html'], $slug ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — trusted config, HTML by design
        ?>
      </div>
    <?php else : ?>
      <div class="srjgov-detail-body">
        <p><em>The detailed explainer for <?php echo esc_html( $entry['title'] ); ?> is being written and will be published in the next content pass. In the meantime, <a href="<?php echo esc_url( home_url( '/ai-governance/' ) ); ?>">browse the full AI Governance library</a>.</em></p>
      </div>
    <?php endif; ?>

    <?php if ( ! empty( $children ) ) : ?>
      <div class="srjgov-children-block">
        <h2>Deep dives in this category</h2>
        <ul class="srjgov-children-list">
          <?php foreach ( $children as $child_slug ) :
              $child = isset( $nav[ $child_slug ] ) ? $nav[ $child_slug ] : null;
              if ( ! $child ) { continue; }
              $child_url = home_url( '/ai-governance/' . $slug . '/' . $child_slug . '/' );
          ?>
            <li>
              <a href="<?php echo esc_url( $child_url ); ?>"><?php echo esc_html( $child['title'] ); ?></a>
              <?php if ( ! empty( $child['short'] ) ) : ?>
                <span class="srjgov-child-teaser"><?php echo esc_html( $child['short'] ); ?></span>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="srjgov-cta">
      <h2>Ready to see where you stand?</h2>
      <p>The AI Business Enablement Audit&trade; measures your organization against every framework in this library, including <?php echo esc_html( $entry['title'] ); ?>, and delivers a defensible governance dossier. Start or finish your audit below.</p>
      <a class="srjgov-cta-btn" href="https://aiauditforcompanies.com/startaiaudit/" target="_blank" rel="noopener">Start or finish your AI Audit &rarr;</a>
    </div>

  </div>
</section>

<?php get_footer(); ?>
