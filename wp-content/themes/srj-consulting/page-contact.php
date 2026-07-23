<?php
/**
 * Template Name: Contact
 *
 * Contact Page Template
 * Slug: contact
 */
$GLOBALS['srj_current_nav'] = 'contact';
get_header();
?>

<?php srj_page_hero(
    'Contact',
    'Four ways <em>to begin.</em>',
    'Every engagement begins with a thirty-minute conversation. No deck, no pitch, no obligation. Pick the channel that suits you.'
); ?>

<section class="contact-page" id="contact">
  <div class="container">
    <div class="contact-grid">
      <div>
        <div class="contact-method contact-method-schedule">
          <span class="contact-method-label">Schedule directly</span>
          <h3>Book a free 30-minute AI consultation</h3>
          <p>The fastest path. Pick a time on the calendar. No back and forth, no qualifying call.</p>
          <div class="schedule-row">
            <a href="<?php echo esc_url( srj_get_booking() ); ?>" target="_blank" rel="noopener" class="big-link">Open the calendar &rarr;</a>
            <div class="schedule-qr">
              <img src="<?php echo esc_url( SRJ_URI . '/assets/images/srj-booking-qr.png' ); ?>" alt="QR code, scan with your phone camera to open the booking page" width="120" height="120" loading="lazy" />
              <span class="schedule-qr-caption">Scan from your phone</span>
            </div>
          </div>
        </div>

        <div class="contact-method">
          <span class="contact-method-label">Phone</span>
          <h3>Speak directly</h3>
          <p>Most calls reach Stephen during business hours. If not, voicemail is returned same day.</p>
          <a href="tel:<?php echo esc_attr( srj_get_phone_tel() ); ?>" class="big-link"><?php echo esc_html( srj_get_phone() ); ?></a>
        </div>

        <div class="contact-method">
          <span class="contact-method-label">Email</span>
          <h3>Write</h3>
          <p>For detailed questions, a brief paragraph describing your situation works well.</p>
          <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>" class="big-link"><?php echo esc_html( srj_get_email() ); ?></a>
        </div>

        <div class="contact-method">
          <span class="contact-method-label">Office</span>
          <h3>Frisco, Texas</h3>
          <p><?php echo esc_html( srj_get_address_line1() ); ?><br><?php echo esc_html( srj_get_address_line2() ); ?></p>
        </div>
      </div>

      <aside class="contact-aside">
        <h3>What to expect from <em>the first conversation.</em></h3>
        <p>The first call is not a pitch. It is a structured thirty-minute conversation to establish where your organization currently stands and which, if any, of the nine service lines matches the question your leadership team needs answered.</p>
        <p>You will leave the call with a clear read on whether the practice is the right fit. We will leave it with a clear read on whether we can produce the outcome you need. If either answer is no, the call ends there. No follow-up sequence, no nurture flow.</p>
        <a href="<?php echo esc_url( srj_get_booking() ); ?>" target="_blank" rel="noopener" class="contact-aside-btn">Schedule a Free AI Consultation <span class="arrow">&rarr;</span></a>
      </aside>
    </div>
  </div>
</section>

<section class="contact-form-section" id="send-a-message">
  <div class="container">
    <div class="contact-form-wrap">
      <span class="contact-method-label">Send a message</span>
      <h2>Prefer to <em>write it out?</em></h2>
      <p class="contact-form-intro">Share a brief paragraph on where your organization stands with AI and what your leadership team needs answered. Stephen responds within one business day.</p>
      <?php echo do_shortcode( '[wpforms id="196"]' ); ?>
    </div>
  </div>
</section>

<section class="contact-form-section" id="book-a-time">
  <div class="container">
    <div class="contact-form-wrap">
      <span class="contact-method-label">Or book a time</span>
      <h2>Prefer to <em>book directly?</em> Pick a time below.</h2>
      <div class="booking-frame-wrap" aria-label="Booking calendar">
        <iframe
          src="<?php echo esc_url( srj_get_scheduler_embed_url() ); ?>"
          title="Schedule a thirty-minute consultation with SRJ Consulting &amp; Services"
          loading="lazy"
          referrerpolicy="strict-origin-when-cross-origin"
        ></iframe>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
