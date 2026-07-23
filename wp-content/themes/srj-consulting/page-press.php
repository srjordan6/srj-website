<?php
/**
 * Template Name: Press
 *
 * page-press.php — Press & Media Kit (front door)
 *
 * A lightweight on-domain page that introduces the press materials and links
 * to the live, Notion-driven press kit rendered by the SRJ Cloudflare Worker.
 *
 * ARCHITECTURE NOTE: the live kit is served by an external Cloudflare Worker
 * that reads the Notion "SRJ Personal Brand System" master. The WordPress theme
 * makes NO runtime Notion call; this page only links out to the Worker. That
 * keeps the site fast and independent and honors the one-way Notion -> website
 * content protocol (architecture doc, Section 16).
 *
 * RENDERS AT /press/ by slug match — the WordPress page slug must be exactly
 * "press" (page-press.php auto-matches a page with that slug; no Template Name
 * header, so no manual template assignment is required).
 *
 * SELF-CONTAINED: uses get_header()/get_footer() plus inline styles, so it needs
 * no functions.php enqueue and depends on no theme helper signatures. The inline
 * CSS is a deliberate, documented deviation from Convention #6 to keep this a
 * single drop-in file; it can be moved to assets/css/press-page.css with a
 * conditional enqueue later.
 *
 * @package srj-consulting
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Single place to update the kit URL (e.g. when moving to press.srjconsultingservices.com).
$srj_press_kit_url = 'https://srj-press.srjordan.workers.dev/';

get_header();
?>

<main id="primary" class="srj-press">

	<section class="srj-press__hero">
		<div class="srj-press__inner">
			<nav class="srj-press__crumbs" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
				<span aria-hidden="true">/</span>
				<span>Press &amp; Media Kit</span>
			</nav>
			<h1 class="srj-press__title">Press &amp; Media Kit</h1>
			<p class="srj-press__subtitle">
				Bios, fact sheet, and downloadable assets for Stephen R. Jordan
				and SRJ Consulting &amp; Services LLC.
			</p>
		</div>
	</section>

	<section class="srj-press__body">
		<div class="srj-press__inner">
			<p class="srj-press__lead">
				For media inquiries and ready-to-use materials, the live press kit
				includes the executive and short bios, a company fact sheet, the book
				details, headshots, logos, and the book cover, all downloadable as
				individual files or a single archive.
			</p>

			<div class="srj-press__cta">
				<a class="srj-press__btn"
				   href="<?php echo esc_url( $srj_press_kit_url ); ?>"
				   target="_blank" rel="noopener">
					View the Press Kit &rarr;
				</a>
			</div>

			<p class="srj-press__contact">
				Press contact:
				<a href="tel:+14154137772">415-413-7772</a>
				<span aria-hidden="true">&middot;</span>
				<a href="mailto:info@srjconsultingservices.com">info@srjconsultingservices.com</a>
			</p>
		</div>
	</section>

</main>

<style>
/* Press & Media Kit front door. Brand tokens: Navy #201868, Orange #F07800,
   Gray #7A8A9E, Lora (headings), Poppins (body). Scoped to .srj-press. */
.srj-press__inner { max-width: 760px; margin: 0 auto; padding: 0 24px; }
.srj-press__hero { background: #201868; padding: 56px 0 48px; text-align: center; }
.srj-press__crumbs {
	font-family: 'Poppins', sans-serif; font-size: 13px; letter-spacing: .04em;
	text-transform: uppercase; color: rgba(255,255,255,.66); margin-bottom: 18px;
}
.srj-press__crumbs a { color: rgba(255,255,255,.66); text-decoration: none; }
.srj-press__crumbs a:hover { color: #F07800; }
.srj-press__crumbs span { margin: 0 8px; }
.srj-press__title {
	font-family: 'Lora', Georgia, serif; color: #fff; font-size: 40px;
	line-height: 1.15; margin: 0;
}
.srj-press__subtitle {
	font-family: 'Poppins', sans-serif; color: rgba(255,255,255,.85);
	font-size: 17px; line-height: 1.6; max-width: 560px; margin: 16px auto 0;
}
.srj-press__body { background: #fff; padding: 56px 0 64px; }
.srj-press__lead {
	font-family: 'Poppins', sans-serif; color: #2a2a33; font-size: 18px;
	line-height: 1.7; text-align: center; margin: 0 auto; max-width: 640px;
}
.srj-press__cta { text-align: center; margin: 34px 0 26px; }
.srj-press__btn {
	display: inline-block; background: #F07800; color: #fff;
	font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 17px;
	padding: 16px 40px; border-radius: 8px; text-decoration: none;
	box-shadow: 0 6px 18px rgba(240,120,0,.28);
	transition: transform .15s ease, box-shadow .15s ease, background .15s ease;
}
.srj-press__btn:hover {
	background: #d96d00; transform: translateY(-1px);
	box-shadow: 0 8px 22px rgba(240,120,0,.34); color: #fff;
}
.srj-press__contact {
	font-family: 'Poppins', sans-serif; color: #7A8A9E; font-size: 14px;
	text-align: center; margin: 0;
}
.srj-press__contact a { color: #7A8A9E; text-decoration: none; }
.srj-press__contact a:hover { color: #F07800; }
.srj-press__contact span { margin: 0 8px; }
@media (max-width: 600px) {
	.srj-press__title { font-size: 30px; }
	.srj-press__hero { padding: 40px 0 36px; }
	.srj-press__body { padding: 40px 0 48px; }
}
</style>

<script type="application/ld+json">
{
	"@context": "https://schema.org",
	"@type": "BreadcrumbList",
	"itemListElement": [
		{ "@type": "ListItem", "position": 1, "name": "Home", "item": "<?php echo esc_url( home_url( '/' ) ); ?>" },
		{ "@type": "ListItem", "position": 2, "name": "Press & Media Kit", "item": "<?php echo esc_url( get_permalink() ); ?>" }
	]
}
</script>

<?php
get_footer();
