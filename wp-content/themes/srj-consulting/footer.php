<?php
/**
 * Footer template.
 * Renders the site footer, floating CTA, and closing body tags.
 *
 * v1.2.13 (July 20, 2026): AI Glossary added to the Resources group,
 * linking /resources/ai-glossary/.
 *
 * v1.2.12 (July 20, 2026): Industries and Books promoted from flat list
 * items to h5 section headers, matching Services, Applications, and
 * Resources. They are hub destinations in their own right, so they now
 * read at the same size and weight and sit flush left rather than
 * indented at list-item position.
 *
 * v1.2.11 (July 20, 2026): Resources group added to the Explore column,
 * below Industries and Books. Header links /resources/, with nested
 * sub-items for the AI Governance Library, the AI Tools Catalog, and
 * Insights. This is not cosmetic: the v1.8.0 nav consolidation replaced
 * the "AI Governance" and "Insights" nav items with a single "Resources"
 * item, which left the 61-page governance library and the Insights
 * archive with no sitewide internal link at all. The footer restores it.
 *
 * v1.2.10 (July 13, 2026): Office address in the Contact column now splits
 * the trailing country (United States / USA / etc.) onto its own line for
 * readability. Address helpers (srj_get_address_line1, srj_get_address_line2)
 * unchanged; the split is done in-template with a regex on line 2 so no
 * helpers.php touch is needed.
 *
 * v1.2.9 (July 13, 2026): Explore column restructured to grouped/nested
 * layout matching the pattern already used for the "Applications > AI Audit"
 * nesting in the Firm column. Two section h5 headers (Services and
 * Applications) each linked to their hub page, with their child pages
 * rendered as .footer-firm-sub <li>s (indent + rotated arrow marker).
 * Industries and Books remain as flat top-level links below the two
 * nested groups. Firm column stripped of six items now covered by the
 * Explore column (All Services, Applications, AI Audit, Industries Served,
 * Books, Insights) to eliminate duplication. Remaining Firm items:
 * About Stephen R. Jordan, Newsletter, FAQ, Press & Media Kit, Contact.
 * Client Resources sub-block is unchanged.
 *
 * v1.2.8 (July 13, 2026): Second column (was two pillar h5 headers with
 * nine nested service-detail sub-items) collapsed to a flat list of six
 * top-level links per operator direction (superseded by v1.2.9).
 *
 * v1.2.7 (June 29, 2026): Applied the same nested treatment to the services
 * column. All nine service-detail <li> items now carry the .footer-firm-sub
 * class (superseded by v1.2.8).
 *
 * v1.2.6 (June 29, 2026): Added "Applications" link to the Firm column
 * with a nested "AI Audit" sub-item. New .footer-firm-sub class for the
 * nested visual treatment (rotated-arrow marker, 18px indent, 0.92em font,
 * slightly dimmer opacity).
 *
 * v1.2.5 (May 31, 2026): Added "Press & Media Kit" link to the Firm column,
 * routing to the on-domain /press/ front door.
 *
 * v1.2.4 (May 22, 2026): Added Disclaimer link to the footer-bottom legal
 * links, alongside Privacy and Terms.
 *
 * v1.2.3 (May 20, 2026): Added newsletter signup band at top of footer for
 * sitewide promotion of The AI Operating System(TM) newsletter.
 */
$home = trailingslashit( home_url() );
?>

<footer>
  <div class="container">

    <!-- Newsletter signup band - sitewide CTA for The AI Operating System(TM) -->
    <div class="footer-newsletter">
      <div class="footer-newsletter-text">
        <div class="footer-newsletter-eyebrow">The AI Operating System&trade;</div>
        <h4 class="footer-newsletter-headline">Get operating discipline for AI, every other Tuesday.</h4>
        <p class="footer-newsletter-sub">Biweekly framework analysis, new templates, and field notes from active client engagements. Free, no software pitches, unsubscribe anytime.</p>
      </div>
      <div class="footer-newsletter-action">
        <a href="https://srj-consulting-services.beehiiv.com" target="_blank" rel="noopener noreferrer" class="footer-newsletter-btn">Subscribe Free <span class="arrow">&rarr;</span></a>
        <a href="<?php echo esc_url( $home . 'newsletter/' ); ?>" class="footer-newsletter-learn">Learn more about the newsletter</a>
      </div>
    </div>

    <div class="footer-grid">
      <div>
        <div class="logo-mark">SRJ Consulting<span class="amp">&amp;</span>Services</div>
        <p class="footer-about">Operator-led AI advisory for executives accountable for AI outcomes. Governance, performance, and security frameworks built from three decades of senior leadership at Citi, Intel, McAfee, and Optiv.</p>

        <div class="footer-social" aria-label="Connect with SRJ Consulting">
          <a class="icon-linkedin" href="https://www.linkedin.com/in/stephenrjordan/" target="_blank" rel="noopener noreferrer" aria-label="Stephen R. Jordan on LinkedIn" title="Stephen R. Jordan on LinkedIn">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <a class="icon-linkedin" href="https://www.linkedin.com/company/srjconsultingandservices/" target="_blank" rel="noopener noreferrer" aria-label="SRJ Consulting on LinkedIn" title="SRJ Consulting on LinkedIn">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <a class="icon-youtube" href="https://www.youtube.com/@srjconsvcs" target="_blank" rel="noopener noreferrer" aria-label="SRJ Consulting on YouTube" title="SRJ Consulting on YouTube">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
          </a>
          <a class="icon-google" href="https://maps.app.goo.gl/gPJgc2nvcHRdtvJM7" target="_blank" rel="noopener noreferrer" aria-label="SRJ Consulting on Google" title="SRJ Consulting on Google">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
          </a>
        </div>
      </div>

      <div>
        <h5><a href="<?php echo esc_url( $home . 'services/' ); ?>" style="color:inherit;text-decoration:none">Services</a></h5>
        <ul>
          <li class="footer-firm-sub"><a href="<?php echo esc_url( $home . 'services/business-services/' ); ?>">AI Business Services</a></li>
          <li class="footer-firm-sub"><a href="<?php echo esc_url( $home . 'services/risk-governance-security/' ); ?>">AI Risk Governance &amp; Security</a></li>
        </ul>
        <h5 style="margin-top:24px"><a href="<?php echo esc_url( $home . 'applications/' ); ?>" style="color:inherit;text-decoration:none">Applications</a></h5>
        <ul>
          <li class="footer-firm-sub"><a href="<?php echo esc_url( $home . 'ai-audit/' ); ?>">AI Audit</a></li>
          <li class="footer-firm-sub"><a href="<?php echo esc_url( $home . 'applications/outcomestar/' ); ?>">Outcomestar</a></li>
        </ul>
        <h5 style="margin-top:24px"><a href="<?php echo esc_url( $home . 'industries/' ); ?>" style="color:inherit;text-decoration:none">Industries</a></h5>
        <h5 style="margin-top:24px"><a href="<?php echo esc_url( $home . 'books/' ); ?>" style="color:inherit;text-decoration:none">Books</a></h5>
        <h5 style="margin-top:24px"><a href="<?php echo esc_url( $home . 'resources/' ); ?>" style="color:inherit;text-decoration:none">Resources</a></h5>
        <ul>
          <li class="footer-firm-sub"><a href="<?php echo esc_url( $home . 'ai-governance/' ); ?>">AI Governance Library</a></li>
          <li class="footer-firm-sub"><a href="<?php echo esc_url( $home . 'ai-governance/ai-tools/' ); ?>">AI Tools Catalog</a></li>
          <li class="footer-firm-sub"><a href="<?php echo esc_url( $home . 'resources/ai-glossary/' ); ?>">AI Glossary</a></li>
          <li class="footer-firm-sub"><a href="<?php echo esc_url( $home . 'insights/' ); ?>">Insights</a></li>
        </ul>
      </div>

      <div>
        <h5>Firm</h5>
        <ul>
          <li><a href="<?php echo esc_url( $home . 'about/' ); ?>">About Stephen R. Jordan</a></li>
          <li><a href="<?php echo esc_url( $home . 'newsletter/' ); ?>">Newsletter</a></li>
          <li><a href="<?php echo esc_url( $home . 'faq/' ); ?>">FAQ</a></li>
          <li><a href="<?php echo esc_url( $home . 'press/' ); ?>">Press &amp; Media Kit</a></li>
          <li><a href="<?php echo esc_url( $home . 'contact/' ); ?>">Contact</a></li>
        </ul>
        <h5 style="margin-top:30px">Client Resources</h5>
        <ul>
          <li><a href="<?php echo esc_url( $home . 'client-upload/' ); ?>">Secure File Upload</a></li>
        </ul>
      </div>

      <div>
        <h5>Contact</h5>
        <div class="footer-contact-item">
          <strong>Phone</strong>
          <a href="tel:<?php echo esc_attr( srj_get_phone_tel() ); ?>" class="footer-phone-link"><?php echo esc_html( srj_get_phone() ); ?></a>
        </div>
        <div class="footer-contact-item">
          <strong>Email</strong>
          <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>"><?php echo esc_html( srj_get_email() ); ?></a>
        </div>
        <div class="footer-contact-item">
          <strong>Office</strong>
          <?php
          // Split trailing country onto its own line for readability.
          // Address helpers unchanged; the split happens here only.
          $addr_line2 = srj_get_address_line2();
          $addr_line3 = '';
          if ( preg_match( '/^(.+?)\s+(United States of America|United States|USA|U\.S\.A\.|U\.S\.|United Kingdom|UK|Canada)$/i', $addr_line2, $addr_m ) ) {
              $addr_line2 = trim( $addr_m[1] );
              $addr_line3 = trim( $addr_m[2] );
          }
          ?>
          <?php echo esc_html( srj_get_address_line1() ); ?><br>
          <?php echo esc_html( $addr_line2 ); ?><?php if ( '' !== $addr_line3 ) : ?><br><?php echo esc_html( $addr_line3 ); endif; ?>
        </div>
        <a href="<?php echo esc_url( srj_get_calendly() ); ?>" target="_blank" rel="noopener" class="footer-schedule-btn">Schedule a Free AI Consultation <span class="arrow">&rarr;</span></a>
      </div>
    </div>

    <div class="footer-bottom">
      <div>&copy; <?php echo date( 'Y' ); ?> SRJ Consulting &amp; Services LLC. All rights reserved.</div>
      <div>
        <a href="<?php echo esc_url( $home . 'privacy/' ); ?>">Privacy</a> &nbsp;&middot;&nbsp;
        <a href="<?php echo esc_url( $home . 'terms/' ); ?>">Terms</a> &nbsp;&middot;&nbsp;
        <a href="<?php echo esc_url( $home . 'disclaimer/' ); ?>">Disclaimer</a> &nbsp;&middot;&nbsp;
        <a href="<?php echo esc_url( $home . 'contact/' ); ?>">Contact</a>
      </div>
    </div>
  </div>
</footer>

<!-- Floating sticky CTA (hides near footer, hidden on mobile) -->
<style>
  /* Hide floating CTA on mobile devices, where it overlaps body content.
     Desktop visitors still get the persistent CTA. */
  @media (max-width: 768px) {
    .floating-cta { display: none !important; }
  }

  /* Footer social icons - brand colors */
  .footer-social {
    display: flex;
    gap: 10px;
    margin-top: 20px;
  }
  .footer-social a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 8px;
    transition: all 0.2s ease;
    text-decoration: none;
    color: #ffffff;
  }
  .footer-social a.icon-linkedin {
    background: #0A66C2;
  }
  .footer-social a.icon-youtube {
    background: #FF0000;
  }
  .footer-social a.icon-google {
    background: #ffffff;
    border: 1px solid #dadce0;
  }
  .footer-social a:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.18);
  }
  .footer-social a svg {
    width: 20px;
    height: 20px;
    display: block;
  }

  /* ============================================
     Firm column nested sub-item (v1.2.6)
     Used for "AI Audit" nested under "Applications"
     and Explore column nested items (v1.2.9)
     ============================================ */
  .footer-firm-sub {
    padding-left: 18px;
    position: relative;
    font-size: 0.92em;
  }
  .footer-firm-sub::before {
    content: "\21B3"; /* downwards arrow with tip rightwards */
    position: absolute;
    left: 2px;
    top: 0;
    color: rgba(255, 255, 255, 0.55);
    font-size: 0.95em;
    line-height: inherit;
  }
  .footer-firm-sub a {
    opacity: 0.85;
  }
  .footer-firm-sub a:hover {
    opacity: 1;
  }

  /* ============================================
     Footer Newsletter Signup Band (v1.2.3)
     The AI Operating System(TM) sitewide CTA
     ============================================ */
  .footer-newsletter {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 48px;
    padding: 36px 0 36px;
    margin-bottom: 36px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.12);
  }
  .footer-newsletter-text {
    flex: 1;
    max-width: 640px;
  }
  .footer-newsletter-eyebrow {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 12px;
    letter-spacing: 2.4px;
    text-transform: uppercase;
    color: #F07800;
    margin-bottom: 10px;
  }
  .footer-newsletter-headline {
    font-family: 'Lora', Georgia, serif;
    font-weight: 600;
    font-size: 24px;
    line-height: 1.25;
    color: #ffffff;
    margin: 0 0 10px;
    letter-spacing: -0.3px;
  }
  .footer-newsletter-sub {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14px;
    line-height: 1.55;
    color: rgba(255, 255, 255, 0.78);
    margin: 0;
    max-width: 600px;
  }
  .footer-newsletter-action {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px;
    flex-shrink: 0;
  }
  .footer-newsletter-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #F07800;
    color: #ffffff !important;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 15px;
    letter-spacing: 0.4px;
    padding: 14px 28px;
    border-radius: 4px;
    text-decoration: none !important;
    transition: all 0.2s ease;
    border: 2px solid #F07800;
    white-space: nowrap;
  }
  .footer-newsletter-btn:hover {
    background: #ffffff;
    color: #201868 !important;
    border-color: #ffffff;
    transform: translateY(-1px);
  }
  .footer-newsletter-btn .arrow {
    margin-left: 8px;
    transition: transform 0.2s ease;
  }
  .footer-newsletter-btn:hover .arrow {
    transform: translateX(2px);
  }
  .footer-newsletter-learn {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 12px;
    color: rgba(255, 255, 255, 0.65) !important;
    text-decoration: none;
    letter-spacing: 0.3px;
    transition: color 0.2s ease;
  }
  .footer-newsletter-learn:hover {
    color: #F07800 !important;
    text-decoration: underline;
  }

  @media (max-width: 768px) {
    .footer-newsletter {
      flex-direction: column;
      align-items: flex-start;
      gap: 24px;
      padding: 28px 0;
    }
    .footer-newsletter-action {
      align-items: flex-start;
      width: 100%;
    }
    .footer-newsletter-btn {
      width: 100%;
      box-sizing: border-box;
    }
    .footer-newsletter-headline {
      font-size: 20px;
    }
  }
</style>
<div class="floating-cta" id="floatingCta">
  <a href="<?php echo esc_url( srj_get_calendly() ); ?>" target="_blank" rel="noopener">
    Schedule a Free AI Consultation <span class="arrow">&rarr;</span>
  </a>
</div>

<?php wp_footer(); ?>
</body>
</html>
