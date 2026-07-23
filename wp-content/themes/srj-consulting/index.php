<?php
/**
 * Index Template (required WordPress fallback)
 */
get_header();
?>

<?php srj_page_hero(
    'Archive',
    is_archive() ? get_the_archive_title() : 'Recent Posts',
    is_archive() ? wp_strip_all_tags( get_the_archive_description() ) : ''
); ?>

<section class="insights-page">
  <div class="container">
    <div class="insights-grid">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
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
          <span class="insight-read">Read &rarr;</span>
        </a>
      <?php endwhile; else : ?>
        <p>Nothing found.</p>
      <?php endif; ?>
    </div>
    <?php the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => '&larr;', 'next_text' => '&rarr;' ) ); ?>
  </div>
</section>

<?php srj_final_cta(); ?>

<?php get_footer(); ?>
