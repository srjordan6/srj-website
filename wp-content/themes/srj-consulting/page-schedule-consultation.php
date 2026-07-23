<?php
/**
 * Template Name: Schedule Consultation
 *
 * Schedule a Consultation Page Template
 * Slug: schedule-consultation
 *
 * v1.5.0 (May 2026): New page introduced when the booking system moved from
 * Calendly to Zoom Scheduler. Every site CTA now routes through this page
 * rather than handing visitors off to a third-party booking host. The Zoom
 * Scheduler iframe lives here and on /contact/ (below the WPForms shortcode).
 * Site-wide booking CTAs use srj_get_booking() (in inc/helpers.php), which
 * returns this page's URL.
 *
 * v1.5.1 (June 2026): the iframe src is now pulled from
 * srj_get_scheduler_embed_url() rather than hardcoded, so the raw scheduler
 * URL lives in exactly one place (inc/helpers.php) and is shared with
 * page-contact.php's booking section.
 *
 * The iframe's `origin=srjconsultingservices.com` parameter restricts Zoom's
 * postMessage communications to this domain. The buttonColor query parameter
 * brands the calendar button orange (#F07800) to match the rest of the site.
 *
 * Complianz: the Zoom Scheduler iframe is categorized as Functional under
 * Complianz Services, so it loads without consent gating. A visitor who
 * navigates to /schedule-consultation/ is here to book; placing a consent
 * placeholder over the calendar would defeat the page's only purpose. The
 * same Functional categorization covers the embed instance on /contact/.
 */
$GLOBALS['srj_current_nav'] = 'contact';
get_header();
?>

<?php srj_page_hero(
    'Schedule a Consultation',
    'Pick a time that <em>works for you.</em>',
    'A focused thirty-minute conversation about where AI fits in your business, what it is costing you, and where it can deliver measurable results. No deck, no pitch, no obligation.'
); ?>

<section class="booking-page" id="book">
  <div class="container">

    <div class="booking-frame-wrap" aria-label="Booking calendar">
      <iframe
        src="<?php echo esc_url( srj_get_scheduler_embed_url() ); ?>"
        title="Schedule a thirty-minute consultation with SRJ Consulting &amp; Services"
        loading="lazy"
        referrerpolicy="strict-origin-when-cross-origin"
      ></iframe>
    </div>

    <div class="booking-fallback">
      <p class="booking-fallback-eyebrow">Prefer not to schedule online?</p>
      <p>Call <a href="tel:<?php echo esc_attr( srj_get_phone_tel() ); ?>"><?php echo esc_html( srj_get_phone() ); ?></a> during business hours, or email <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>"><?php echo esc_html( srj_get_email() ); ?></a>. Stephen responds within one business day.</p>
    </div>

  </div>
</section>

<?php get_footer(); ?>
