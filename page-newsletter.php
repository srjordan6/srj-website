<?php
/**
 * Template Name: Newsletter Hub
 *
 * Landing page for The AI Operating System™ newsletter.
 * Designed to drive subscriptions to the Beehiiv-hosted form.
 *
 * URL: srjconsultingservices.com/newsletter/
 *
 * To deploy:
 *   1. SFTP this file to /wp-content/themes/srj-consulting/
 *   2. In WordPress admin, create a new Page titled "Newsletter"
 *   3. Set its URL slug to: newsletter
 *   4. Under Page Attributes, set Template to "Newsletter Hub"
 *   5. Click Publish
 *
 * @package SRJ_Consulting
 */

get_header(); ?>

<style>
/* ============================================
   SRJ Newsletter Hub Styles
   Scoped to .srj-newsletter to avoid bleed
   ============================================ */

.srj-newsletter {
    --srj-navy: #201868;
    --srj-orange: #F07800;
    --srj-gray: #7A8A9E;
    --srj-white: #FFFFFF;
    --srj-light: #F7F8FA;
    --srj-border: #E1E5EB;

    background: var(--srj-white);
    color: var(--srj-navy);
    font-family: 'Poppins', system-ui, -apple-system, sans-serif;
    padding: 0;
    margin: 0;
    width: 100%;
}

.srj-newsletter * {
    box-sizing: border-box;
}

.srj-newsletter__container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 32px;
    position: relative;
}

/* ============================================
   Hero Section
   ============================================ */
.srj-newsletter__hero {
    position: relative;
    padding: 96px 0 80px;
    background: var(--srj-white);
}

.srj-newsletter__bracket {
    position: absolute;
    width: 70px;
    height: 70px;
    border-color: var(--srj-navy);
    border-style: solid;
    border-width: 0;
    z-index: 1;
}
.srj-newsletter__bracket--tl { top: 32px; left: 32px; border-top-width: 3px; border-left-width: 3px; }
.srj-newsletter__bracket--tr { top: 32px; right: 32px; border-top-width: 3px; border-right-width: 3px; }

.srj-newsletter__eyebrow {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 14px;
    color: var(--srj-orange);
    letter-spacing: 2.4px;
    text-transform: uppercase;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.srj-newsletter__eyebrow::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--srj-border);
    max-width: 120px;
}

.srj-newsletter__headline {
    font-family: 'Lora', Georgia, serif;
    font-weight: 600;
    font-size: clamp(40px, 6vw, 68px);
    line-height: 1.05;
    color: var(--srj-navy);
    letter-spacing: -1.5px;
    margin: 0 0 28px;
    max-width: 880px;
}

.srj-newsletter__headline .accent {
    color: var(--srj-orange);
}

.srj-newsletter__subhead {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 20px;
    line-height: 1.55;
    color: var(--srj-navy);
    max-width: 720px;
    margin: 0 0 40px;
}

.srj-newsletter__meta {
    display: flex;
    align-items: center;
    gap: 24px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.srj-newsletter__meta-item {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 14px;
    color: var(--srj-gray);
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.srj-newsletter__meta-item .dot {
    width: 6px;
    height: 6px;
    background: var(--srj-orange);
    border-radius: 50%;
    display: inline-block;
}

.srj-newsletter__cta-row {
    display: flex;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
}

.srj-newsletter__cta {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--srj-navy);
    color: var(--srj-white);
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 17px;
    letter-spacing: 0.5px;
    padding: 18px 36px;
    border-radius: 4px;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 2px solid var(--srj-navy);
}

.srj-newsletter__cta:hover {
    background: var(--srj-orange);
    border-color: var(--srj-orange);
    color: var(--srj-white);
}

.srj-newsletter__cta-note {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14px;
    color: var(--srj-gray);
}

/* ============================================
   What You Get Section
   ============================================ */
.srj-newsletter__benefits {
    padding: 96px 0;
    background: var(--srj-light);
    position: relative;
}

.srj-newsletter__section-eyebrow {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 13px;
    color: var(--srj-orange);
    letter-spacing: 2.6px;
    text-transform: uppercase;
    margin-bottom: 16px;
}

.srj-newsletter__section-title {
    font-family: 'Lora', Georgia, serif;
    font-weight: 600;
    font-size: clamp(32px, 4vw, 48px);
    line-height: 1.1;
    color: var(--srj-navy);
    letter-spacing: -0.8px;
    margin: 0 0 24px;
    max-width: 720px;
}

.srj-newsletter__section-lead {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 18px;
    line-height: 1.55;
    color: var(--srj-navy);
    max-width: 680px;
    margin: 0 0 56px;
}

.srj-newsletter__benefits-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 32px;
}

.srj-newsletter__benefit {
    background: var(--srj-white);
    padding: 32px;
    border-radius: 4px;
    border-left: 4px solid var(--srj-orange);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.srj-newsletter__benefit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(32, 24, 104, 0.08);
}

.srj-newsletter__benefit-num {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 13px;
    color: var(--srj-orange);
    letter-spacing: 1.8px;
    text-transform: uppercase;
    margin-bottom: 12px;
}

.srj-newsletter__benefit-title {
    font-family: 'Lora', Georgia, serif;
    font-weight: 600;
    font-size: 22px;
    line-height: 1.25;
    color: var(--srj-navy);
    letter-spacing: -0.3px;
    margin: 0 0 12px;
}

.srj-newsletter__benefit-body {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 15px;
    line-height: 1.55;
    color: var(--srj-navy);
    margin: 0;
    opacity: 0.85;
}

/* ============================================
   Author Block
   ============================================ */
.srj-newsletter__author {
    padding: 96px 0;
    background: var(--srj-white);
}

.srj-newsletter__author-inner {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 64px;
    align-items: start;
    max-width: 1000px;
    margin: 0 auto;
}

.srj-newsletter__author-label {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 13px;
    color: var(--srj-orange);
    letter-spacing: 2.6px;
    text-transform: uppercase;
    margin-bottom: 16px;
}

.srj-newsletter__author-name {
    font-family: 'Lora', Georgia, serif;
    font-weight: 600;
    font-size: 32px;
    line-height: 1.15;
    color: var(--srj-navy);
    letter-spacing: -0.5px;
    margin: 0 0 8px;
}

.srj-newsletter__author-role {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 15px;
    color: var(--srj-gray);
    margin: 0;
}

.srj-newsletter__author-body p {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 17px;
    line-height: 1.65;
    color: var(--srj-navy);
    margin: 0 0 20px;
}

.srj-newsletter__author-body p:last-child {
    margin-bottom: 0;
}

/* ============================================
   Final CTA Section
   ============================================ */
.srj-newsletter__final {
    position: relative;
    padding: 96px 0 120px;
    background: var(--srj-navy);
    color: var(--srj-white);
    overflow: hidden;
}

.srj-newsletter__bracket--bl { bottom: 32px; left: 32px; border-bottom-width: 3px; border-left-width: 3px; border-color: var(--srj-white); }
.srj-newsletter__bracket--br { bottom: 32px; right: 32px; border-bottom-width: 3px; border-right-width: 3px; border-color: var(--srj-white); }

.srj-newsletter__final-inner {
    text-align: center;
    max-width: 720px;
    margin: 0 auto;
}

.srj-newsletter__final-eyebrow {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 13px;
    color: var(--srj-orange);
    letter-spacing: 2.6px;
    text-transform: uppercase;
    margin-bottom: 24px;
}

.srj-newsletter__final-headline {
    font-family: 'Lora', Georgia, serif;
    font-weight: 600;
    font-size: clamp(32px, 5vw, 52px);
    line-height: 1.1;
    color: var(--srj-white);
    letter-spacing: -1px;
    margin: 0 0 24px;
}

.srj-newsletter__final-headline .accent {
    color: var(--srj-orange);
}

.srj-newsletter__final-body {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 18px;
    line-height: 1.55;
    color: var(--srj-white);
    opacity: 0.9;
    margin: 0 0 40px;
}

.srj-newsletter__final-cta {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--srj-orange);
    color: var(--srj-white);
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 18px;
    letter-spacing: 0.5px;
    padding: 20px 44px;
    border-radius: 4px;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 2px solid var(--srj-orange);
}

.srj-newsletter__final-cta:hover {
    background: var(--srj-white);
    color: var(--srj-navy);
    border-color: var(--srj-white);
}

.srj-newsletter__final-note {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 13px;
    color: var(--srj-white);
    opacity: 0.7;
    margin-top: 24px;
    letter-spacing: 0.3px;
}

/* ============================================
   Mobile Responsive
   ============================================ */
@media (max-width: 768px) {
    .srj-newsletter__container { padding: 0 20px; }
    .srj-newsletter__hero { padding: 64px 0 56px; }
    .srj-newsletter__bracket { width: 50px; height: 50px; }
    .srj-newsletter__bracket--tl { top: 20px; left: 20px; }
    .srj-newsletter__bracket--tr { top: 20px; right: 20px; }
    .srj-newsletter__bracket--bl { bottom: 20px; left: 20px; }
    .srj-newsletter__bracket--br { bottom: 20px; right: 20px; }
    .srj-newsletter__benefits-grid { grid-template-columns: 1fr; gap: 20px; }
    .srj-newsletter__benefit { padding: 24px; }
    .srj-newsletter__benefits { padding: 64px 0; }
    .srj-newsletter__author { padding: 64px 0; }
    .srj-newsletter__author-inner { grid-template-columns: 1fr; gap: 32px; }
    .srj-newsletter__final { padding: 64px 0 80px; }
    .srj-newsletter__cta-row { flex-direction: column; align-items: flex-start; gap: 16px; }
    .srj-newsletter__meta { gap: 16px; }
}

/* Hide Kadence default page title if present */
.entry-header.page-title-wrap,
.entry-header-wrap,
.page .entry-header {
    display: none !important;
}

/* Remove default content padding */
.content-container.site-container,
.content-container,
.entry-content {
    padding: 0 !important;
    margin: 0 !important;
    max-width: 100% !important;
}

/* Load Lora and Poppins from Google Fonts if not already loaded */
.srj-newsletter { font-family: 'Poppins', system-ui, sans-serif; }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<main class="srj-newsletter" role="main">

    <!-- ============================================
         Hero Section
         ============================================ -->
    <section class="srj-newsletter__hero">
        <div class="srj-newsletter__bracket srj-newsletter__bracket--tl"></div>
        <div class="srj-newsletter__bracket srj-newsletter__bracket--tr"></div>

        <div class="srj-newsletter__container">
            <div class="srj-newsletter__eyebrow">The AI Operating System&trade;</div>

            <h1 class="srj-newsletter__headline">
                Operating Discipline for Executives <span class="accent">Running AI.</span>
            </h1>

            <p class="srj-newsletter__subhead">
                Biweekly framework analysis, new templates, and field notes from active client engagements. Written for owners, presidents, CFOs, and COOs at organizations from 20 to 1,000 employees.
            </p>

            <div class="srj-newsletter__meta">
                <span class="srj-newsletter__meta-item"><span class="dot"></span>Biweekly</span>
                <span class="srj-newsletter__meta-item"><span class="dot"></span>Free</span>
                <span class="srj-newsletter__meta-item"><span class="dot"></span>No software pitches</span>
                <span class="srj-newsletter__meta-item"><span class="dot"></span>Unsubscribe anytime</span>
            </div>

            <div class="srj-newsletter__cta-row">
                <a href="https://srj-consulting-services.beehiiv.com" class="srj-newsletter__cta" target="_blank" rel="noopener noreferrer">
                    Subscribe Free &rarr;
                </a>
                <span class="srj-newsletter__cta-note">Takes 15 seconds. Two-click signup.</span>
            </div>
        </div>
    </section>

    <!-- ============================================
         What You Get Section
         ============================================ -->
    <section class="srj-newsletter__benefits">
        <div class="srj-newsletter__container">
            <div class="srj-newsletter__section-eyebrow">What You Get</div>
            <h2 class="srj-newsletter__section-title">
                Operator-grade content, not vendor marketing.
            </h2>
            <p class="srj-newsletter__section-lead">
                Every issue is written from inside active client engagements. The frameworks, templates, and field notes are the same materials shaping real executive decisions on AI governance, cost, and accountability.
            </p>

            <div class="srj-newsletter__benefits-grid">
                <div class="srj-newsletter__benefit">
                    <div class="srj-newsletter__benefit-num">01 &middot; Framework Analysis</div>
                    <h3 class="srj-newsletter__benefit-title">Framework analysis from active engagements</h3>
                    <p class="srj-newsletter__benefit-body">Walkthroughs of how governance, cost, and accountability frameworks land in real organizations. What works, what fails, why.</p>
                </div>

                <div class="srj-newsletter__benefit">
                    <div class="srj-newsletter__benefit-num">02 &middot; New Templates</div>
                    <h3 class="srj-newsletter__benefit-title">New templates and worksheets as they are built</h3>
                    <p class="srj-newsletter__benefit-body">Subscribers get early access to new artifacts before they are added to the public resource library at /books/.</p>
                </div>

                <div class="srj-newsletter__benefit">
                    <div class="srj-newsletter__benefit-num">03 &middot; Field Notes</div>
                    <h3 class="srj-newsletter__benefit-title">Field notes on what is working in mid-market AI</h3>
                    <p class="srj-newsletter__benefit-body">What owners, CFOs, and COOs are actually doing with AI. Patterns from the conversations happening inside engagements.</p>
                </div>

                <div class="srj-newsletter__benefit">
                    <div class="srj-newsletter__benefit-num">04 &middot; No Vendor Noise</div>
                    <h3 class="srj-newsletter__benefit-title">No software pitches, no vendor partnerships</h3>
                    <p class="srj-newsletter__benefit-body">SRJ Consulting &amp; Services is operator-led and tool-agnostic. The newsletter follows the same posture, no sponsored content, no affiliate links.</p>
                </div>

                <div class="srj-newsletter__benefit">
                    <div class="srj-newsletter__benefit-num">05 &middot; Designed for Skim</div>
                    <h3 class="srj-newsletter__benefit-title">8 to 10 minute read, biweekly</h3>
                    <p class="srj-newsletter__benefit-body">Structured for executives. Front-loaded findings, bulleted action items, no padding. Read in full or scan the takeaways.</p>
                </div>

                <div class="srj-newsletter__benefit">
                    <div class="srj-newsletter__benefit-num">06 &middot; Free, No Upsell</div>
                    <h3 class="srj-newsletter__benefit-title">Free, with no upsell layer</h3>
                    <p class="srj-newsletter__benefit-body">The newsletter is fully free. No premium tier, no paywalled archives. Consulting engagements are a separate conversation, not the next funnel step.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         Author Block
         ============================================ -->
    <section class="srj-newsletter__author">
        <div class="srj-newsletter__container">
            <div class="srj-newsletter__author-inner">
                <div class="srj-newsletter__author-meta">
                    <div class="srj-newsletter__author-label">Written By</div>
                    <h2 class="srj-newsletter__author-name">Stephen R. Jordan</h2>
                    <p class="srj-newsletter__author-role">Founder, SRJ Consulting &amp; Services</p>
                </div>

                <div class="srj-newsletter__author-body">
                    <p>Stephen R. Jordan founded SRJ Consulting &amp; Services to give executives the operating discipline to run AI as a managed business function rather than a scattered set of tools. The firm works with owners, presidents, CFOs, and COOs at organizations from 20 to 1,000 employees.</p>
                    <p>His three-decade career spans senior security and operations leadership at Citi, Intel, McAfee, and Optiv. He is the author of <em>The AI Business Enablement Audit</em>, Volume I of the six-volume Operating Discipline for AI Library, and is based in Frisco, Texas.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         Final CTA Section
         ============================================ -->
    <section class="srj-newsletter__final">
        <div class="srj-newsletter__bracket srj-newsletter__bracket--bl"></div>
        <div class="srj-newsletter__bracket srj-newsletter__bracket--br"></div>

        <div class="srj-newsletter__container">
            <div class="srj-newsletter__final-inner">
                <div class="srj-newsletter__final-eyebrow">Subscribe Free</div>
                <h2 class="srj-newsletter__final-headline">
                    Get The AI Operating System&trade; <span class="accent">every other Tuesday.</span>
                </h2>
                <p class="srj-newsletter__final-body">
                    Join executives who are running AI as a managed business function, not a scattered experiment. Two-click signup. Unsubscribe anytime.
                </p>
                <a href="https://srj-consulting-services.beehiiv.com" class="srj-newsletter__final-cta" target="_blank" rel="noopener noreferrer">
                    Subscribe Now &rarr;
                </a>
                <p class="srj-newsletter__final-note">
                    No spam. No software pitches. Your email is never shared.
                </p>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
