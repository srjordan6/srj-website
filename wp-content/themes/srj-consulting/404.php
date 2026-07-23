<?php
/**
 * 404 Not Found Template
 */
get_header();
?>

<?php srj_page_hero(
    'Page Not Found',
    'This page <em>has moved or never existed.</em>',
    'Try the navigation, or head back to the homepage.'
); ?>

<section class="longform" style="text-align:center">
  <div class="container">
    <a href="<?php echo esc_url( home_url() ); ?>" class="btn btn-primary" style="display:inline-flex;margin-top:20px">Return Home <span class="arrow">&rarr;</span></a>
  </div>
</section>

<?php srj_final_cta(); ?>

<?php get_footer(); ?>
