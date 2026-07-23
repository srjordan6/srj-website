<?php
/**
 * Template Name: Industries Hub
 *
 * Industries Page Template (Hub)
 * Slug: industries
 *
 * Landing page for the Industries section. Each card is itself a link to a
 * single-industry detail page at /industries/{slug}/, rendered by the
 * "Industry Detail" template (page-industry-detail.php).
 */
$GLOBALS['srj_current_nav'] = 'industries';
get_header();

$industries = array(
    array(
        'slug'  => 'aerospace-defense',
        'name'  => 'Aerospace & Defense',
        'blurb' => 'The highest AI adoption of any sector, and the highest stakes when a model cannot be explained.',
    ),
    array(
        'slug'  => 'technology-software',
        'name'  => 'Technology & Software',
        'blurb' => 'First to adopt AI, and now first to face the governance debt that early speed left behind.',
    ),
    array(
        'slug'  => 'agriculture',
        'name'  => 'Agriculture',
        'blurb' => 'Precision AI promises real gains on thin margins, if the return can actually be proven.',
    ),
    array(
        'slug'  => 'healthcare-life-sciences',
        'name'  => 'Healthcare & Life Sciences',
        'blurb' => 'AI adopted broadly, matured almost nowhere, and a sector full of pilots that never reach the floor.',
    ),
    array(
        'slug'  => 'media-telecom',
        'name'  => 'Media & Telecom',
        'blurb' => 'AI bolted on faster than it is governed, with content, networks, and brand trust all exposed.',
    ),
    array(
        'slug'  => 'manufacturing',
        'name'  => 'Manufacturing',
        'blurb' => 'Clear efficiency gains on the plant floor, paired with real risk on connected systems.',
    ),
    array(
        'slug'  => 'retail-ecommerce',
        'name'  => 'Retail & E-Commerce',
        'blurb' => 'Agentic commerce is reshaping who owns the customer relationship, and the data behind it.',
    ),
    array(
        'slug'  => 'insurance',
        'name'  => 'Insurance',
        'blurb' => 'A natural home for AI, where a model that cannot explain itself becomes a regulatory finding.',
    ),
    array(
        'slug'  => 'financial-services',
        'name'  => 'Financial Services & Banking',
        'blurb' => 'Heavy AI investment under a regulatory frame that is sharpening its focus by the quarter.',
    ),
    array(
        'slug'  => 'legal-services',
        'name'  => 'Legal Services',
        'blurb' => 'A cautious adopter for good reason, where one unchecked AI output becomes a public liability.',
    ),
);
?>

<?php srj_page_hero(
    'Industries Served',
    'Ten sectors. <em>One operating discipline.</em>',
    'AI adoption is now near-universal across industries. The operating discipline to govern, secure, and scale it is not. Select a sector to see where it stands, the tools in play, and how SRJ helps.'
); ?>

<section class="services-landing" style="padding-top:50px">
  <div class="container">
    <div class="industries-grid">
      <?php foreach ( $industries as $i => $industry ) : ?>
        <a class="industry-card" href="<?php echo esc_url( home_url( '/industries/' . $industry['slug'] . '/' ) ); ?>">
          <span class="industry-num"><?php echo sprintf( '%02d', $i + 1 ); ?></span>
          <h3><?php echo wp_kses_post( $industry['name'] ); ?></h3>
          <p><?php echo wp_kses_post( $industry['blurb'] ); ?></p>
          <span class="industry-card-link">Explore <?php echo wp_kses_post( $industry['name'] ); ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php srj_inline_cta( 'Sector not listed? <em>The framework still applies.</em>' ); ?>
<?php srj_final_cta(); ?>

<?php get_footer(); ?>
