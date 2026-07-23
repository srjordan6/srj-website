<?php
/**
 * Search results template.
 *
 * Deploy to: /wp-content/themes/srj-consulting/search.php
 *
 * Renders results returned by Relevanssi (Relevanssi transparently replaces
 * the default WP_Query for search queries). Falls back cleanly if Relevanssi
 * is inactive.
 *
 * Related files:
 *   - mu-plugins/srj-relevanssi-config-indexer.php  (feeds config-page body_html
 *                                                    into the Relevanssi index)
 *   - header.php                                    (renders the nav search icon
 *                                                    and slide-down search form)
 *   - assets/css/style.css                          (search icon + results styles,
 *                                                    section labeled "Search")
 *
 * v1.0.0 (July 13, 2026): initial deploy alongside Relevanssi plugin.
 */

$GLOBALS['srj_current_nav'] = '';
get_header();

$q     = get_search_query();
$found = (int) $GLOBALS['wp_query']->found_posts;
?>

<main class="srj-search-page">

  <section class="srj-search-hero">
    <div class="container-narrow">
      <p class="label">Search</p>
      <h1 class="srj-search-title">
        <?php
        if ( '' === $q ) {
            echo 'Search the SRJ site';
        } elseif ( 0 === $found ) {
            printf( 'No results for &ldquo;%s&rdquo;', esc_html( $q ) );
        } else {
            printf(
                '%d result%s for &ldquo;%s&rdquo;',
                $found,
                ( 1 === $found ) ? '' : 's',
                esc_html( $q )
            );
        }
        ?>
      </h1>

      <form role="search" method="get" class="srj-search-form srj-search-form-hero" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <label for="srj-search-hero-input" class="screen-reader-text">Search</label>
        <input
          type="search"
          id="srj-search-hero-input"
          name="s"
          value="<?php echo esc_attr( $q ); ?>"
          placeholder="Try &ldquo;Colorado AI Act&rdquo;, &ldquo;HIPAA&rdquo;, &ldquo;bias audit&rdquo;..."
          autocomplete="off"
        />
        <button type="submit" aria-label="Search">Search</button>
      </form>
    </div>
  </section>

  <?php if ( have_posts() ) : ?>

    <section class="srj-search-results">
      <div class="container-narrow">
        <ol class="srj-search-list">
          <?php while ( have_posts() ) : the_post(); ?>
            <li class="srj-search-item">
              <a class="srj-search-item-link" href="<?php the_permalink(); ?>">
                <h2 class="srj-search-item-title"><?php the_title(); ?></h2>
                <p class="srj-search-item-url"><?php echo esc_html( str_replace( home_url(), '', get_permalink() ) ); ?></p>
                <?php
                // Relevanssi's contextual excerpts land in the standard
                // get_the_excerpt() output when the "excerpts" option is on
                // in Relevanssi settings. If it is off, fall back to a plain
                // trim of the post title / content.
                $excerpt = get_the_excerpt();
                if ( '' !== trim( $excerpt ) ) {
                    echo '<p class="srj-search-item-excerpt">' . wp_kses_post( $excerpt ) . '</p>';
                }
                ?>
              </a>
            </li>
          <?php endwhile; ?>
        </ol>

        <?php
        // Pagination. Relevanssi respects paged=<n> via the normal query.
        $paged_links = paginate_links( array(
            'total'     => $GLOBALS['wp_query']->max_num_pages,
            'current'   => max( 1, get_query_var( 'paged' ) ),
            'prev_text' => '&larr; Previous',
            'next_text' => 'Next &rarr;',
            'type'      => 'array',
        ) );

        if ( ! empty( $paged_links ) ) : ?>
          <nav class="srj-search-pager" aria-label="Search results pagination">
            <?php foreach ( $paged_links as $link ) { echo $link; } ?>
          </nav>
        <?php endif; ?>
      </div>
    </section>

  <?php elseif ( '' !== $q ) : ?>

    <section class="srj-search-empty">
      <div class="container-narrow">
        <p>Nothing matched that query. Try a shorter or different phrase, or start from one of these hubs:</p>
        <ul class="srj-search-hub-list">
          <li><a href="<?php echo esc_url( home_url( '/ai-governance/' ) ); ?>">AI Governance Reference Library</a></li>
          <li><a href="<?php echo esc_url( home_url( '/books/' ) ); ?>">The Operating Discipline for AI Library</a></li>
          <li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Services</a></li>
          <li><a href="<?php echo esc_url( home_url( '/industries/' ) ); ?>">Industries</a></li>
          <li><a href="<?php echo esc_url( home_url( '/insights/' ) ); ?>">Insights</a></li>
        </ul>
      </div>
    </section>

  <?php else : ?>

    <section class="srj-search-empty">
      <div class="container-narrow">
        <p>Enter a term above to search across the site: books, services, industries, AI governance topics, and insights.</p>
      </div>
    </section>

  <?php endif; ?>

</main>

<?php get_footer(); ?>
