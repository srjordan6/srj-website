<?php
/**
 * Template Name: Homepage
 * Description: Custom homepage template using Gutenberg block editor.
 * Used when WordPress Settings > Reading > Homepage = "Home" page.
 *
 * @package SRJ_Consulting
 * @since 1.2.0
 */

get_header();
?>

<main id="primary" class="site-main homepage">

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'homepage-article' ); ?>>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

		</article>

		<?php
	endwhile;
	?>

</main>

<?php
get_footer();
