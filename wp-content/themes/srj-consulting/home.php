<?php
/**
 * Blog Posts Index Template (home.php)
 * Renders the Insights archive when "Posts page" is set to the Insights page.
 */
$GLOBALS['srj_current_nav'] = 'insights';
get_header();
?>

<?php srj_page_hero(
    'Insights &amp; Research',
    'Operator notes from <em>the AI frontier.</em>',
    'Essays, frameworks, and field notes on AI governance, performance, and security. Written for executives accountable for outcomes.'
); ?>

<section class="insights-page">
  <div class="container">
    <div class="insights-grid">
      <?php
      if ( have_posts() ) :
          while ( have_posts() ) : the_post();
              $cats = get_the_category();
              $cat_name = ! empty( $cats ) ? esc_html( $cats[0]->name ) : 'Essay';
      ?>
        <a href="<?php the_permalink(); ?>" class="insight" style="text-decoration:none;display:block">
          <div class="insight-meta">
            <span class="insight-category"><?php echo $cat_name; ?></span>
            <span class="insight-date"><?php echo esc_html( get_the_date( 'M Y' ) ); ?></span>
          </div>
          <h3><?php the_title(); ?></h3>
          <p class="insight-excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
          <span class="insight-read">Read the essay <span class="arrow">&rarr;</span></span>
        </a>
      <?php
          endwhile;
      else :
      ?>
        <div style="grid-column: 1 / -1; padding: 60px 0; text-align: center;">
          <p style="font-size:17px;color:var(--ink-soft)">No insights published yet. Check back soon.</p>
        </div>
      <?php endif; ?>
    </div>

    <?php
    // Pagination
    the_posts_pagination( array(
        'mid_size'  => 2,
        'prev_text' => '&larr; Older',
        'next_text' => 'Newer &rarr;',
    ) );
    ?>
  </div>
</section>

<?php srj_inline_cta( 'Want the next essay in your inbox? <em>Subscribe below.</em>' ); ?>
<?php srj_final_cta(); ?>

<?php get_footer(); ?>
