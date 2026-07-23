<?php
/**
 * Template Name: Client Upload
 *
 * Client Secure Upload Page Template
 * Slug: client-upload
 *
 * Page template that hosts the WPForms Client Secure Upload form (form ID 31).
 * Includes framing copy, the HIPAA disclaimer architecture, and the upload form.
 */
$GLOBALS['srj_current_nav'] = '';
get_header();
?>

<?php srj_page_hero(
    'Client Resources',
    'Secure file upload <em>for active engagements.</em>',
    'A protected channel for sending engagement materials, supporting documents, and audit-prep files. For clients of SRJ Consulting & Services LLC.'
); ?>

<style>
  .upload-page-intro {
    padding: 70px 0 30px;
    background: var(--paper);
  }
  .upload-page-intro .container { max-width: 760px; }
  .upload-page-intro h2 {
    font-size: clamp(24px, 2.6vw, 30px);
    line-height: 1.25;
    margin-bottom: 16px;
  }
  .upload-page-intro p {
    color: var(--ink-soft);
    font-size: 16px;
    line-height: 1.7;
    margin-bottom: 16px;
  }
  .upload-page-intro ul {
    margin: 20px 0 24px;
    padding-left: 22px;
    color: var(--ink-soft);
    font-size: 15.5px;
    line-height: 1.7;
  }
  .upload-page-intro li { margin-bottom: 10px; }

  .upload-form-section {
    padding: 30px 0 90px;
    background: var(--paper);
  }
  .upload-form-section .container { max-width: 760px; }
  .upload-form-wrap {
    background: var(--white);
    border: 1px solid var(--line);
    padding: 48px 48px 40px;
    box-shadow: 0 20px 50px -24px rgba(36, 24, 91, 0.12);
  }
  .upload-form-wrap .form-label {
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--orange);
    font-weight: 600;
    margin-bottom: 14px;
    display: block;
  }
  .upload-form-wrap h3 {
    font-size: 24px;
    line-height: 1.25;
    margin-bottom: 24px;
  }

  .phi-callout {
    margin: 40px 0 0;
    padding: 24px 28px;
    background: var(--paper-warm);
    border-left: 3px solid var(--navy);
    font-size: 14px;
    line-height: 1.7;
    color: var(--ink-soft);
  }
  .phi-callout strong {
    display: block;
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--navy);
    margin-bottom: 8px;
  }
  .phi-callout a {
    color: var(--navy);
    text-decoration: underline;
  }

  @media (max-width: 720px) {
    .upload-form-wrap { padding: 32px 22px 28px; }
  }
</style>

<!-- INTRO + EXPECTATIONS -->
<section class="upload-page-intro">
  <div class="container">
    <h2>What this form is for</h2>
    <p>This is a private upload channel for clients of SRJ Consulting &amp; Services LLC. Use it to send engagement-related materials directly to Stephen, including:</p>
    <ul>
      <li>Existing AI tool inventories, license records, and vendor contracts</li>
      <li>AI governance policies, acceptable-use policies, and security standards</li>
      <li>Organizational charts, role definitions, and accountability matrices</li>
      <li>Audit prep documents, sample outputs, and process documentation</li>
      <li>Financial statements and budget documents relevant to the engagement</li>
      <li>Strategic plans, board materials, and leadership team artifacts</li>
    </ul>
    <p>All files are received directly by Stephen R. Jordan. They are not shared with third parties, indexed by search engines, or made accessible to other clients. Receipt is confirmed by email within one business day.</p>
  </div>
</section>

<!-- FORM SECTION -->
<section class="upload-form-section">
  <div class="container">
    <div class="upload-form-wrap">
      <span class="form-label">Client Secure Upload</span>
      <h3>Submit your files</h3>
      <?php echo do_shortcode( '[wpforms id="31"]' ); ?>
    </div>

    <div class="phi-callout">
      <strong>Healthcare clients and PHI</strong>
      This form is not configured for Protected Health Information (PHI), patient records, or other HIPAA-regulated data. If your engagement involves PHI, contact Stephen directly at <a href="mailto:info@srjconsultingservices.com">info@srjconsultingservices.com</a> or <a href="tel:+14154137772">(415) 413-7772</a> for a HIPAA-compliant transmission channel. Files sent through this form should not contain PHI.
    </div>
  </div>
</section>

<?php get_footer(); ?>
