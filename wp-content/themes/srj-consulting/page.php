<?php
/**
 * Default Page Template (fallback)
 * Used for any page that doesn't have a specific page-{slug}.php template.
 */
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<?php srj_page_hero( 'SRJ Consulting', get_the_title() ); ?>

<section class="longform">
  <div class="container">
    <?php the_content(); ?>
  </div>
</section>

<?php endwhile; ?>

<?php srj_inline_cta( 'Ready to begin? <em>Schedule a free consultation.</em>' ); ?>
<?php srj_final_cta(); ?>

<?php get_footer(); ?>
