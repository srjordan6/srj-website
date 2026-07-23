<?php
/**
 * Single Post Template
 *
 * v1.18 (May 2026): srj_breadcrumbs() added inside the hero container so
 * blog posts emit BreadcrumbList JSON-LD and show a visible trail, matching
 * every other inner page on the site.
 *
 * v1.6.0 (May 2026): added the page-hero--post and longform--post modifier
 * classes so assets/css/blog-post.css can style blog posts onto the brand
 * (Lora navy headlines, Poppins body, orange accents) without affecting any
 * other template that shares the .page-hero or .longform classes.
 */
$GLOBALS['srj_current_nav'] = 'insights';
get_header();
?>

<?php while ( have_posts() ) : the_post();
    $cats = get_the_category();
    $cat_name = ! empty( $cats ) ? esc_html( $cats[0]->name ) : 'Essay';
?>

<section class="page-hero page-hero--post">
  <div class="container">
    <?php srj_breadcrumbs(); ?>
    <div class="label"><?php echo $cat_name; ?> &mdash; <?php echo esc_html( get_the_date( 'F Y' ) ); ?></div>
    <h1><?php the_title(); ?></h1>
    <?php if ( has_excerpt() ) : ?>
      <p class="page-hero-lede"><?php echo esc_html( get_the_excerpt() ); ?></p>
    <?php endif; ?>
  </div>
</section>

<section class="longform longform--post">
  <div class="container">
    <?php the_content(); ?>

    <?php
    $author_id = get_the_author_meta( 'ID' );
    $author_name = get_the_author();
    $author_bio = get_the_author_meta( 'description' );
    if ( $author_bio ) :
    ?>
      <p style="margin-top:48px;color:var(--muted);font-size:14px"><em><?php echo esc_html( $author_name ); ?> &mdash; <?php echo esc_html( $author_bio ); ?></em></p>
    <?php endif; ?>
  </div>
</section>

<?php endwhile; ?>

<?php
// Related/recent posts
$recent = new WP_Query( array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'post__not_in' => array( get_the_ID() ),
    'post_status' => 'publish',
) );

if ( $recent->have_posts() ) :
?>
<section class="insights" style="background:var(--paper-warm)">
  <div class="container">
    <div class="insights-header">
      <div>
        <div class="label">More Insights</div>
        <h2>Other essays from <em>the practice.</em></h2>
      </div>
      <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="insights-link">View all writing <span class="arrow">&rarr;</span></a>
    </div>
    <div class="insights-grid">
      <?php
      while ( $recent->have_posts() ) : $recent->the_post();
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
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php srj_inline_cta( 'Want to talk through your AI posture? <em>Start with a conversation.</em>' ); ?>
<?php srj_final_cta(); ?>

<?php get_footer(); ?>
