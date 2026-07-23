<?php
/**
 * Template Name: Newsletter Welcome
 *
 * Post-signup confirmation page for The AI Operating System(TM) newsletter.
 * Shown after a visitor submits the Fluent Forms newsletter signup form.
 *
 * Delivers immediate value, sets expectations, and instructs subscribers
 * on how to whitelist the sender so future issues land in their inbox.
 *
 * The "whitelist this sender" box shows the newsletter's real Beehiiv
 * from-address (srj-consulting-services@mail.beehiiv.com) as a literal
 * string — deliberately NOT srj_get_email(), which returns the info@
 * contact address the newsletter does not send from.
 *
 * URL: srjconsultingservices.com/welcome/
 *
 * Page-specific styles live in assets/css/welcome-page.css and are
 * conditionally enqueued by srj_enqueue_welcome_page_styles() in
 * functions.php on the page with slug "welcome". This template carries
 * no inline <style> block, per theme Convention #6 (new CSS goes in a
 * stylesheet, not inline in PHP).
 *
 * To deploy — three files, uploaded together:
 *   1. SFTP page-welcome.php  -> /wp-content/themes/srj-consulting/
 *   2. SFTP welcome-page.css  -> /wp-content/themes/srj-consulting/assets/css/
 *   3. SFTP functions.php     -> /wp-content/themes/srj-consulting/
 *      (adds the conditional enqueue and bumps SRJ_VERSION)
 *   4. WordPress admin > Pages > Add New > Title "Welcome" > slug "welcome"
 *   5. Page Attributes > Template > Newsletter Welcome > Publish
 *      (the page body can be left empty — this template renders its own
 *      content and does not call the_content())
 *   6. Configure Fluent Forms (form ID 2) to redirect here after submission.
 *   7. Allow for PHP OPcache, purge the GoDaddy page cache (and Sucuri cache
 *      if enabled), then hard refresh to verify.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main srj-welcome">

    <!-- Hero -->
    <section class="srj-welcome__hero">
        <div class="srj-welcome__bracket srj-welcome__bracket--tl"></div>
        <div class="srj-welcome__bracket srj-welcome__bracket--tr"></div>
        <div class="srj-welcome__container">
            <?php if ( function_exists( 'srj_breadcrumbs' ) ) { srj_breadcrumbs(); } ?>
            <div class="srj-welcome__check">&#10003;</div>
            <p class="srj-welcome__eyebrow">Subscription Confirmed</p>
            <h1 class="srj-welcome__headline">You're in. <em>Your first issue is on its way.</em></h1>
            <p class="srj-welcome__lede">
                Thank you for subscribing to The AI Operating System&trade; &mdash; the
                biweekly newsletter for executives running AI as a business function,
                not a science experiment.
            </p>
        </div>
    </section>

    <!-- Whitelist notice -->
    <div class="srj-welcome__container">
        <div class="srj-welcome__notice">
            <h2 class="srj-welcome__notice-title">One 30-second step before you go</h2>
            <ol class="srj-welcome__steps">
                <li>Open your inbox and look for a confirmation email from us. Check your spam and promotions folders if it is not in your main inbox.</li>
                <li>If you find it outside your inbox, mark it "Not Spam" so future issues are delivered correctly.</li>
                <li>Add the sender below to your contacts. This is the single best way to make sure every issue reaches you.</li>
            </ol>
            <div class="srj-welcome__sender-card">
                <p class="srj-welcome__sender-label">Add this sender to your contacts</p>
                <!-- Literal Beehiiv free-plan sending address. NOT srj_get_email(),
                     which returns the info@ contact address the newsletter never
                     sends from. If a Beehiiv custom sending domain is added later,
                     update this string. -->
                <p class="srj-welcome__sender-addr">srj-consulting-services@mail.beehiiv.com</p>
            </div>
        </div>
    </div>

    <!-- What to expect -->
    <section class="srj-welcome__expect">
        <div class="srj-welcome__container">
            <p class="srj-welcome__section-eyebrow">What to Expect</p>
            <h2 class="srj-welcome__section-headline">What lands in your inbox, and what never will</h2>
            <div class="srj-welcome__grid">
                <div class="srj-welcome__card">
                    <h3 class="srj-welcome__card-title">Every other Tuesday</h3>
                    <p class="srj-welcome__card-body">A predictable biweekly cadence. No surprise sends, no flooding your inbox.</p>
                </div>
                <div class="srj-welcome__card">
                    <h3 class="srj-welcome__card-title">An 8 to 10 minute read</h3>
                    <p class="srj-welcome__card-body">Long enough to be substantive, short enough to finish before your next meeting.</p>
                </div>
                <div class="srj-welcome__card">
                    <h3 class="srj-welcome__card-title">Frameworks from real engagements</h3>
                    <p class="srj-welcome__card-body">Operating discipline drawn from active client work, with templates and worksheets you can use.</p>
                </div>
                <div class="srj-welcome__card">
                    <h3 class="srj-welcome__card-title">No vendor noise</h3>
                    <p class="srj-welcome__card-body">No software pitches, no affiliate links, no partnerships. Independent guidance, full stop.</p>
                </div>
                <div class="srj-welcome__card">
                    <h3 class="srj-welcome__card-title">Field notes</h3>
                    <p class="srj-welcome__card-body">What is genuinely working, and failing, in mid-market AI adoption right now.</p>
                </div>
                <div class="srj-welcome__card">
                    <h3 class="srj-welcome__card-title">Written for executives</h3>
                    <p class="srj-welcome__card-body">For owners, presidents, CFOs, and COOs accountable for AI producing real results.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- While you wait -->
    <section class="srj-welcome__wait">
        <div class="srj-welcome__container">
            <p class="srj-welcome__section-eyebrow">While You Wait</p>
            <h2 class="srj-welcome__section-headline">Start with the free resources</h2>
            <p class="srj-welcome__wait-body">
                Your first issue is on its way. Until then, explore the resource library:
                AI tool inventories, real cost mapping, and decision accountability
                frameworks. No email gate, no premium tier. The same artifacts that
                newsletter issues build on.
            </p>
            <a href="<?php echo esc_url( home_url( '/books/' ) ); ?>" class="srj-welcome__cta">
                Browse Free Resources <span class="arrow">&rarr;</span>
            </a>
        </div>
    </section>

    <!-- Final -->
    <section class="srj-welcome__final">
        <div class="srj-welcome__bracket srj-welcome__bracket--bl"></div>
        <div class="srj-welcome__bracket srj-welcome__bracket--br"></div>
        <div class="srj-welcome__container">
            <div class="srj-welcome__final-eyebrow">See You Soon</div>
            <h2 class="srj-welcome__final-headline">Your first issue lands in your inbox soon.</h2>
            <p class="srj-welcome__final-body">
                Until then, take 30 seconds to whitelist the sender above. It is the
                single highest-leverage action you can take to make sure operating
                discipline reaches you every other week.
            </p>
            <p class="srj-welcome__signoff">Talk soon,</p>
            <p class="srj-welcome__signoff-name">Stephen R. Jordan<br>Founder, SRJ Consulting &amp; Services</p>
        </div>
    </section>

</main>

<?php
get_footer();
