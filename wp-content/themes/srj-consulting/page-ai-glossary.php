<?php
/**
 * Template Name: AI Glossary
 *
 * Renders /resources/ai-glossary/ from the wp_srj_glossary table.
 *
 * v1.0.0 (July 20, 2026): Initial build. 416 terms across 10 categories,
 * grouped by category with terms alphabetical inside each group.
 *
 * Navigation is two-layer and deliberate:
 *   - Category jump links scroll to a category block.
 *   - The A-Z bar FILTERS rather than jumps. Because the page is grouped
 *     by category, a given letter appears in many places, so a jump would
 *     land somewhere arbitrary. Filtering to a letter across all
 *     categories is what someone arriving with a word in mind wants.
 *   - A search box filters on term text as you type.
 * All three are progressive enhancement: with JavaScript off, every term
 * is present and readable, only the filtering is unavailable.
 *
 * There is no config fallback. The database is the only source, and when
 * the table is empty the page says so rather than rendering blank.
 */
$GLOBALS['srj_current_nav'] = 'resources';
get_header();

$srj_gl_grouped = function_exists( 'srj_glossary_get_grouped' ) ? srj_glossary_get_grouped() : array();
$srj_gl_letters = function_exists( 'srj_glossary_letters' ) ? srj_glossary_letters() : array();
$srj_gl_total   = 0;
foreach ( $srj_gl_grouped as $srj_gl_terms ) {
	$srj_gl_total += count( $srj_gl_terms );
}
?>

<?php srj_page_hero( 'AI Glossary', 'Resources' ); ?>

<style>
.srjgl-lead { max-width: 780px; margin: 0 auto 36px; font-size: 18px; line-height: 1.7; color: #1A1A2E; font-family: Poppins, sans-serif; text-align: center; }
.srjgl-lead strong { color: #201868; }

.srjgl-controls { max-width: 900px; margin: 0 auto 40px; }
.srjgl-search-wrap { text-align: center; margin: 0 0 22px; }
.srjgl-search { width: 100%; max-width: 460px; padding: 13px 16px; font-family: Poppins, sans-serif; font-size: 15px; border: 1px solid #C9C6BE; border-radius: 4px; color: #1A1A2E; }
.srjgl-search:focus { outline: none; border-color: #F07800; box-shadow: 0 0 0 3px rgba(240,120,0,0.14); }

.srjgl-azbar { display: flex; flex-wrap: wrap; gap: 6px; justify-content: center; margin: 0 0 20px; }
.srjgl-az { font-family: Poppins, sans-serif; font-size: 13px; font-weight: 600; letter-spacing: 0.4px; padding: 7px 11px; border: 1px solid #E4E2DC; border-radius: 3px; background: #fff; color: #201868; cursor: pointer; line-height: 1; }
.srjgl-az:hover { border-color: #F07800; color: #F07800; }
.srjgl-az.is-active { background: #201868; border-color: #201868; color: #fff; }

.srjgl-cats { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; padding: 18px 0 0; border-top: 1px solid #EDEBE5; }
.srjgl-cats a { font-family: Poppins, sans-serif; font-size: 13px; color: #201868; text-decoration: none; padding: 5px 10px; border-radius: 3px; background: #F6F5F1; }
.srjgl-cats a:hover { background: #FFF6EC; color: #F07800; }

.srjgl-status { text-align: center; font-family: Poppins, sans-serif; font-size: 14px; color: #7A8A9E; margin: 0 0 30px; }

.srjgl-group { margin: 0 0 48px; scroll-margin-top: 90px; }
.srjgl-group h2 { font-family: Lora, serif; font-size: 26px; color: #201868; margin: 0 0 4px; font-weight: 600; }
.srjgl-group-rule { width: 56px; height: 3px; background: #F07800; margin: 0 0 22px; }

.srjgl-term { padding: 16px 0; border-bottom: 1px solid #EDEBE5; scroll-margin-top: 90px; }
.srjgl-term:last-child { border-bottom: none; }
.srjgl-term h3 { font-family: Poppins, sans-serif; font-size: 17px; font-weight: 600; color: #201868; margin: 0 0 6px; }
.srjgl-term p { font-family: Poppins, sans-serif; font-size: 15px; line-height: 1.65; color: #3A3A45; margin: 0; }
.srjgl-term .srjgl-eg { display: block; margin-top: 5px; font-size: 14px; color: #7A8A9E; }
.srjgl-term .srjgl-eg em { color: #7A8A9E; }

.srjgl-empty { text-align: center; font-family: Poppins, sans-serif; color: #7A8A9E; padding: 40px 0; }

.srjgl-cta { background: #201868; color: #fff; padding: 48px 32px; border-radius: 6px; margin: 16px 0 0; text-align: center; font-family: Poppins, sans-serif; }
.srjgl-cta h2 { color: #fff !important; font-family: Lora, serif; margin: 0 0 12px !important; font-size: 28px; font-weight: 600; }
.srjgl-cta p { color: #FFF6EC; font-size: 17px; line-height: 1.6; margin: 0 auto 24px; max-width: 640px; }
.srjgl-cta a { display: inline-block; background: #F07800; color: #fff; padding: 16px 36px; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 16px; }
.srjgl-cta a:hover { background: #C86400; }
@media (max-width: 640px) { .srjgl-cta { padding: 36px 24px; } .srjgl-cta h2 { font-size: 24px; } }
</style>

<section class="longform">
  <div class="container">

    <p class="srjgl-lead">Plain-English definitions for the vocabulary that shows up in AI vendor pitches, board papers, and regulation. <strong><?php echo (int) $srj_gl_total; ?> terms</strong> across <?php echo (int) count( $srj_gl_grouped ); ?> categories, written so a non-technical executive can read a sentence once and know what was meant.</p>

<?php if ( empty( $srj_gl_grouped ) ) : ?>

    <p class="srjgl-empty">The glossary is being loaded and will appear here shortly. In the meantime, browse the <a href="<?php echo esc_url( home_url( '/ai-governance/' ) ); ?>">AI Governance Reference Library</a>.</p>

<?php else : ?>

    <div class="srjgl-controls">
      <div class="srjgl-search-wrap">
        <input type="search" id="srjgl-search" class="srjgl-search" placeholder="Search <?php echo (int) $srj_gl_total; ?> terms&hellip;" autocomplete="off">
      </div>

      <div class="srjgl-azbar" id="srjgl-azbar">
        <button type="button" class="srjgl-az is-active" data-letter="">All</button>
<?php foreach ( $srj_gl_letters as $srj_gl_letter ) : ?>
        <button type="button" class="srjgl-az" data-letter="<?php echo esc_attr( $srj_gl_letter ); ?>"><?php echo esc_html( $srj_gl_letter ); ?></button>
<?php endforeach; ?>
      </div>

      <div class="srjgl-cats">
<?php foreach ( $srj_gl_grouped as $srj_gl_cat => $srj_gl_terms ) : ?>
        <a href="#<?php echo esc_attr( srj_glossary_anchor( $srj_gl_cat ) ); ?>"><?php echo esc_html( $srj_gl_cat ); ?> (<?php echo (int) count( $srj_gl_terms ); ?>)</a>
<?php endforeach; ?>
      </div>
    </div>

    <p class="srjgl-status" id="srjgl-status"></p>

<?php foreach ( $srj_gl_grouped as $srj_gl_cat => $srj_gl_terms ) : ?>
    <div class="srjgl-group" id="<?php echo esc_attr( srj_glossary_anchor( $srj_gl_cat ) ); ?>" data-group>
      <h2><?php echo esc_html( $srj_gl_cat ); ?></h2>
      <div class="srjgl-group-rule"></div>
<?php foreach ( $srj_gl_terms as $srj_gl_t ) : ?>
      <div class="srjgl-term" id="term-<?php echo esc_attr( $srj_gl_t->term_slug ); ?>" data-term="<?php echo esc_attr( strtolower( $srj_gl_t->term ) ); ?>" data-letter="<?php echo esc_attr( strtoupper( substr( $srj_gl_t->term, 0, 1 ) ) ); ?>">
        <h3><?php echo esc_html( $srj_gl_t->term ); ?></h3>
        <p><?php echo esc_html( $srj_gl_t->definition ); ?>
<?php if ( ! empty( $srj_gl_t->example ) ) : ?>
          <span class="srjgl-eg"><em>Example: <?php echo esc_html( $srj_gl_t->example ); ?></em></span>
<?php endif; ?>
        </p>
      </div>
<?php endforeach; ?>
    </div>
<?php endforeach; ?>

<?php endif; ?>

    <div class="srjgl-cta">
      <h2>Knowing the words is not the same as governing the tools</h2>
      <p>The AI Business Enablement Audit&trade; measures your organization against every framework in the reference library and delivers a defensible governance dossier.</p>
      <a href="https://aiauditforcompanies.com/startaiaudit/" target="_blank" rel="noopener">Start or finish your AI Audit &rarr;</a>
    </div>

  </div>
</section>

<script>
(function () {
  var search = document.getElementById('srjgl-search');
  if (!search) { return; }
  var azbar  = document.getElementById('srjgl-azbar');
  var status = document.getElementById('srjgl-status');
  var terms  = Array.prototype.slice.call(document.querySelectorAll('.srjgl-term'));
  var groups = Array.prototype.slice.call(document.querySelectorAll('[data-group]'));
  var letter = '';

  function apply() {
    var q = search.value.trim().toLowerCase();
    var shown = 0;

    terms.forEach(function (el) {
      var okQ = !q || el.getAttribute('data-term').indexOf(q) !== -1;
      var okL = !letter || el.getAttribute('data-letter') === letter;
      var show = okQ && okL;
      el.style.display = show ? '' : 'none';
      if (show) { shown++; }
    });

    groups.forEach(function (g) {
      var any = g.querySelector('.srjgl-term:not([style*="display: none"])');
      g.style.display = any ? '' : 'none';
    });

    if (!q && !letter) {
      status.textContent = '';
    } else {
      status.textContent = shown + (shown === 1 ? ' term' : ' terms') + ' matching';
    }
  }

  search.addEventListener('input', apply);

  azbar.addEventListener('click', function (e) {
    var btn = e.target.closest('.srjgl-az');
    if (!btn) { return; }
    letter = btn.getAttribute('data-letter') || '';
    azbar.querySelectorAll('.srjgl-az').forEach(function (b) { b.classList.remove('is-active'); });
    btn.classList.add('is-active');
    apply();
  });
})();
</script>

<?php get_footer(); ?>
