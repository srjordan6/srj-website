<?php
/**
 * Template Name: Privacy Policy
 *
 * Privacy Policy Template
 * Slug: privacy
 *
 * v2 (July 10, 2026): Full ironclad rewrite. Expanded from 20 sections to
 * 36 sections. Adds: comprehensive CPRA disclosures (categories of PI,
 * sources, purposes, sharing, retention), specific service-provider
 * enumeration, Texas Data Privacy and Security Act (TDPSA) coverage,
 * appeal process for VCDPA/CPA/CTDPA/OCPA/TDPSA, Global Privacy Control
 * language, A2P 10DLC SMS compliance language for the WPForms contact
 * form, book-worksheet functional cookie disclosure (srj_worksheet_access,
 * 10-year), automated decision-making disclosure, "we do not train
 * third-party AI on your data" affirmative statement, data breach
 * notification framework, authorized agent procedures, sensitive PI
 * treatment, international data transfer basis (SCCs), legal bases for
 * GDPR processing, cross-references to Terms of Use (governing law,
 * dispute resolution, trademarks) and Disclaimer. Third-party
 * service-provider list enumerated: Cloudflare, GoDaddy, Sucuri,
 * Google Analytics G-WWP3BSKN5N, Microsoft Clarity wxtqd3ud7i, Fluent
 * Forms + Beehiiv newsletter pipeline, WPForms contact form ID 196,
 * Cloudflare Turnstile bot protection, WP Mail SMTP outbound delivery,
 * Zoom Phone telephony, and the srj-press Cloudflare Worker for the
 * on-demand press kit. Last updated: July 10, 2026. Reviewed and
 * approved by operator (acting as counsel) July 10 2026.
 *
 * v1 (May 2026): Initial standard-practice draft.
 */
get_header();
?>

<?php srj_page_hero( 'Legal', 'Privacy Policy' ); ?>

<section class="longform">
  <div class="container">
    <p><em>Last updated: July 10, 2026</em></p>

    <p>SRJ Consulting &amp; Services LLC (&ldquo;<strong>SRJ</strong>,&rdquo; &ldquo;<strong>we</strong>,&rdquo; &ldquo;<strong>us</strong>,&rdquo; &ldquo;<strong>our</strong>&rdquo;) respects your privacy. This Privacy Policy (&ldquo;<strong>Policy</strong>&rdquo;) explains what Personal Information we collect, how we use and share it, how long we keep it, the choices and rights you have, and how to contact us. This Policy applies to <a href="<?php echo esc_url( home_url( '/' ) ); ?>">srjconsultingservices.com</a>, our newsletter, our downloadable publications and worksheets, our on-demand press kit, and any related pages, tools, and communications (collectively, the &ldquo;<strong>Website</strong>&rdquo;). <strong>By using the Website or providing information to us, you agree to the practices described in this Policy.</strong></p>

    <h2>1. Relationship to our other legal documents</h2>
    <p>This Policy is a companion to our <a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>">Terms of Use</a> and <a href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>">Disclaimer</a>. Each is incorporated into this Policy by reference. Capitalized terms not defined here have the meanings given to them in the Terms of Use.</p>

    <h2>2. Who we are</h2>
    <p>SRJ Consulting &amp; Services LLC is a Texas limited liability company with its principal place of business at <?php echo esc_html( srj_get_address_line1() ); ?>, <?php echo esc_html( srj_get_address_line2() ); ?>, United States. SRJ is the &ldquo;controller&rdquo; of Personal Information collected through the Website under applicable European and United Kingdom law, and the &ldquo;business&rdquo; that collects Personal Information under the California Consumer Privacy Act as amended by the California Privacy Rights Act (together, the &ldquo;<strong>CCPA/CPRA</strong>&rdquo;). Our contact information appears in Section 36.</p>

    <h2>3. Scope of this Policy</h2>
    <p>This Policy covers Personal Information that SRJ collects through the Website, our newsletter, our contact forms, our scheduling tools, our secure file upload facility, our downloadable worksheets and books, our on-demand press kit, and any direct communication with SRJ. This Policy does not apply to: (a) websites, tools, or services operated by third parties, even if linked from the Website, which are subject to their own privacy policies; (b) Personal Information you provide directly to a third-party vendor whose service you access from the Website (for example, Amazon for book purchases or Beehiiv for newsletter subscription management); or (c) Personal Information that SRJ handles under a signed engagement agreement, which is governed by that agreement.</p>

    <h2>4. Key definitions</h2>
    <ul>
      <li><strong>&ldquo;Personal Information&rdquo;</strong> means any information that identifies, relates to, describes, is reasonably capable of being associated with, or could reasonably be linked, directly or indirectly, with a particular consumer or household, as further defined by applicable law. In the European Union and United Kingdom, this concept is referred to as &ldquo;personal data.&rdquo;</li>
      <li><strong>&ldquo;Sensitive Personal Information&rdquo;</strong> means the categories of Personal Information designated as sensitive under the CCPA/CPRA, the General Data Protection Regulation, and analogous laws, such as government identifiers, precise geolocation, and financial account information.</li>
      <li><strong>&ldquo;Process&rdquo;</strong> means any operation performed on Personal Information, whether or not by automated means, including collection, recording, organization, storage, adaptation, retrieval, consultation, use, disclosure, dissemination, restriction, erasure, or destruction.</li>
      <li><strong>&ldquo;Sell&rdquo;</strong> and <strong>&ldquo;Share&rdquo;</strong> have the meanings given to those terms under the CCPA/CPRA. As described in Section 10, <strong>SRJ does not sell your Personal Information and does not share it for cross-context behavioral advertising.</strong></li>
      <li><strong>&ldquo;Service Provider&rdquo;</strong> means a third party that processes Personal Information on SRJ&rsquo;s behalf under a written contract, as described in Section 11.</li>
    </ul>

    <h2>5. Personal Information we collect</h2>

    <h3>5.1 Information you provide to us</h3>
    <p>We collect Personal Information you provide directly, including when you:</p>
    <ul>
      <li><strong>Complete our contact form</strong> (WPForms form ID 196): name, business email address, telephone number, organization name, job title, message content, and (if you opt in) consent to receive SMS text messages related to your inquiry;</li>
      <li><strong>Subscribe to our newsletter</strong> (Fluent Forms, form ID 2): email address and any name you provide;</li>
      <li><strong>Schedule a consultation:</strong> name, email, phone number, organization, meeting time preferences, and any information you share when preparing for or during the consultation;</li>
      <li><strong>Request access to gated worksheets</strong> (Fluent Forms, form ID 4, the &ldquo;<strong>Book Worksheet Access</strong>&rdquo; form): email address and any optional first name;</li>
      <li><strong>Use the secure file upload facility:</strong> your name, contact information, the files you upload, and any accompanying message;</li>
      <li><strong>Purchase our books through third-party vendors:</strong> we do not receive Personal Information from Amazon or other book vendors beyond aggregated sales reports; the vendor is the controller of that data;</li>
      <li><strong>Correspond with us by email, telephone, SMS, or postal mail:</strong> the content of your communications and any Personal Information you choose to share.</li>
    </ul>

    <h3>5.2 Information collected automatically</h3>
    <p>When you visit the Website, SRJ and its Service Providers automatically collect certain technical information, which may include your IP address, browser type and version, device type, operating system, screen resolution, language preference, time zone, referring website, pages viewed, links clicked, search terms entered on the Website, session duration, mouse movements and clicks (via Microsoft Clarity, if you consent), and the dates and times of your visits. This information is used for analytics, site performance, security, fraud prevention, and abuse detection.</p>

    <h3>5.3 Information from third parties</h3>
    <p>We may receive limited information from third parties, including: (a) our Service Providers who help us operate the Website (for example, hosting logs and error reports); (b) analytics platforms that aggregate visitor behavior; (c) our newsletter platform Beehiiv, which reports subscription events and email engagement metrics; and (d) publicly available sources, such as LinkedIn profiles or company websites, which may be consulted for context in preparing an engagement.</p>

    <h2>6. Categories of Personal Information collected (CCPA/CPRA disclosure)</h2>
    <p>For purposes of the CCPA/CPRA, in the preceding twelve months SRJ has collected the following categories of Personal Information:</p>
    <ul>
      <li><strong>Identifiers</strong>: name, email address, telephone number, IP address, and account identifiers.</li>
      <li><strong>Customer records</strong> (Cal. Civ. Code &sect; 1798.80(e) categories): name, contact information, business title, employer, and communication content.</li>
      <li><strong>Commercial information</strong>: services inquired about, engagement history, and content downloaded.</li>
      <li><strong>Internet or other electronic network activity information</strong>: browsing history on the Website, pages viewed, referring URLs, search terms, session recordings and heatmaps (via Microsoft Clarity, subject to consent), and clickstream data.</li>
      <li><strong>Geolocation data</strong> (non-precise, derived from IP): country, state, and city-level location for analytics and security.</li>
      <li><strong>Professional or employment-related information</strong>: employer, title, role, industry, and information you share in the course of a consultation or engagement inquiry.</li>
      <li><strong>Inferences</strong>: characteristics inferred from the categories above to understand your interests in our services and content.</li>
      <li><strong>Audio and visual information</strong>: recordings of scheduled calls or webinars only where you are notified in advance and provide consent.</li>
    </ul>
    <p><strong>We do not collect Sensitive Personal Information</strong> as defined by the CCPA/CPRA in the ordinary course of Website use. If you voluntarily provide Sensitive Personal Information in a message to us, we will treat it consistent with this Policy and applicable law.</p>

    <h2>7. Sources of Personal Information</h2>
    <p>We collect Personal Information from the following sources: (a) directly from you, when you interact with the Website; (b) automatically, through cookies, tracking technologies, and server logs; (c) from Service Providers that assist us in operating the Website; (d) from publicly available sources, as described in Section 5.3; and (e) from third parties who refer you to us or introduce us with your consent.</p>

    <h2>8. How we use Personal Information (business and commercial purposes)</h2>
    <p>We use Personal Information for the following business and commercial purposes:</p>
    <ul>
      <li>To respond to inquiries, questions, and requests;</li>
      <li>To schedule and conduct consultations, and to prepare for and deliver our advisory services;</li>
      <li>To operate, maintain, secure, monitor, and improve the Website and our services;</li>
      <li>To deliver, personalize, and measure our newsletter and other email communications to subscribers who have opted in;</li>
      <li>To deliver the free worksheets and downloadable resources that accompany our books, subject to the email-verification unlock described in Section 17;</li>
      <li>To deliver SMS text messages related to your inquiry, only if you have expressly consented on the contact form (see Section 15);</li>
      <li>To analyze use of the Website, measure the effectiveness of our content, and understand which resources are most useful to readers;</li>
      <li>To detect, investigate, prevent, and respond to fraud, abuse, security incidents, and violations of our Terms of Use;</li>
      <li>To comply with legal obligations, respond to legal process, and enforce our legal rights;</li>
      <li>To evaluate, negotiate, and, if applicable, conduct a merger, acquisition, financing, reorganization, or sale of assets;</li>
      <li>To de-identify or aggregate Personal Information for internal analysis, research, and improvement of our methodology.</li>
    </ul>

    <h2>9. Legal bases for processing (EEA, UK, and Swiss residents)</h2>
    <p>If you are located in the European Economic Area, the United Kingdom, or Switzerland, we process your Personal Information on the following legal bases under the General Data Protection Regulation and the UK GDPR:</p>
    <ul>
      <li><strong>Consent</strong>: where you have given us specific, informed consent to process Personal Information for a defined purpose, such as newsletter subscription or analytics cookies. You may withdraw consent at any time; withdrawal does not affect the lawfulness of prior processing.</li>
      <li><strong>Contract</strong>: where processing is necessary to respond to a request that leads to or forms part of a contractual relationship (for example, scheduling a consultation).</li>
      <li><strong>Legitimate interests</strong>: where processing is necessary for our legitimate business interests, such as operating and securing the Website, improving our content, and preventing fraud, and where those interests are not overridden by your fundamental rights.</li>
      <li><strong>Legal obligation</strong>: where processing is necessary to comply with a legal obligation to which we are subject.</li>
    </ul>

    <h2>10. How we share Personal Information</h2>
    <p><strong>We do not sell your Personal Information, and we do not share your Personal Information for cross-context behavioral advertising, as those terms are defined by the CCPA/CPRA.</strong> We disclose Personal Information only in the following circumstances:</p>
    <ul>
      <li><strong>Service Providers.</strong> With third parties who perform services on our behalf, such as website hosting, security, email and newsletter delivery, contact-form processing, analytics, scheduling, outbound email delivery, telephony, and payment processing, and only to the extent necessary to perform those services and subject to written contracts that limit their use of the information.</li>
      <li><strong>Legal requirements.</strong> When required by law, regulation, subpoena, court order, or other legal process, or to protect the rights, property, safety, or security of SRJ, our clients, our personnel, or the public.</li>
      <li><strong>Enforcement.</strong> To enforce our Terms of Use, this Policy, or any other agreement with you, including in connection with billing, collection, and dispute resolution.</li>
      <li><strong>Business transfers.</strong> In connection with a merger, acquisition, financing, reorganization, bankruptcy, receivership, or sale of some or all of our assets, in which case Personal Information may be transferred as part of that transaction, subject to reasonable safeguards.</li>
      <li><strong>With your consent.</strong> Any other disclosure will be made only with your consent or at your direction.</li>
    </ul>
    <p><strong>SMS opt-in data carve-out.</strong> No mobile information or SMS opt-in data is shared with third parties or affiliates for marketing or promotional purposes. Text-messaging originator opt-in data and consent are excluded from all sharing categories above and will not be sold, rented, shared, or transferred to any third party for any purpose other than to deliver the text messages you have consented to receive.</p>

    <h2>11. Third-party Service Providers</h2>
    <p>The Website relies on the following categories of Service Providers, each of which processes Personal Information only under contract, only for the purposes we authorize, and only as necessary to provide their service. This list is representative, not exhaustive, and may change:</p>
    <ul>
      <li><strong>Hosting and content delivery:</strong> GoDaddy Managed WordPress (hosting); Cloudflare (edge network, content delivery, and Turnstile bot protection); Sucuri (web application firewall).</li>
      <li><strong>Analytics:</strong> Google Analytics 4 (measurement ID G-WWP3BSKN5N); Microsoft Clarity (project ID wxtqd3ud7i, session recordings and heatmaps).</li>
      <li><strong>Forms and consent management:</strong> WPForms (contact form ID 196); Fluent Forms (newsletter form ID 2 and worksheet-access form ID 4); Complianz (cookie consent banner and disclosure).</li>
      <li><strong>Email delivery and newsletter:</strong> WP Mail SMTP (transactional email delivery); Beehiiv (newsletter platform).</li>
      <li><strong>Telephony:</strong> Zoom Phone (voice and SMS delivery).</li>
      <li><strong>Scheduling:</strong> the booking system used for consultations, currently a WordPress-hosted scheduler.</li>
      <li><strong>Press kit:</strong> the srj-press Cloudflare Worker, which renders the on-demand press kit from source data held in our Notion workspace; no visitor Personal Information is stored by the Worker.</li>
      <li><strong>File uploads:</strong> the secure file-upload facility used for confidential client documents, which stores files in encrypted storage.</li>
    </ul>
    <p>Each Service Provider processes information under its own privacy policy. We select Service Providers we consider reputable and require contractual privacy and security protections.</p>

    <h2>12. Cookies and similar technologies</h2>
    <p>The Website uses cookies, pixels, local storage, and similar technologies. Cookies are managed through the Complianz consent management platform, which classifies cookies into these categories:</p>
    <ul>
      <li><strong>Functional (always active):</strong> cookies strictly necessary for the Website to operate, including session cookies, load balancing, security tokens, and the &ldquo;<code>srj_worksheet_access</code>&rdquo; cookie, which remembers that you have completed the email verification to access free book worksheets (see Section 17). Functional cookies do not require your consent.</li>
      <li><strong>Statistics (consent required):</strong> analytics cookies from Google Analytics and Microsoft Clarity, which measure Website usage and behavior.</li>
      <li><strong>Marketing (consent required):</strong> we do not currently place marketing or advertising cookies. If we ever do so, they will require your consent through the banner.</li>
      <li><strong>Preferences (consent required):</strong> cookies that remember choices you have made, such as language or display preferences.</li>
    </ul>
    <p>The Complianz banner appears on your first visit and lets you accept all, reject non-essential, or customize per category. You can withdraw or change your consent at any time through the cookie preferences link at the footer of the Website or by visiting <a href="<?php echo esc_url( home_url( '/opt-out-preferences/' ) ); ?>">Opt-Out Preferences</a>. You can also control cookies through your browser settings; disabling cookies may limit some features.</p>

    <h2>13. Global Privacy Control and Do Not Track</h2>
    <p>The Website respects the Global Privacy Control (GPC) browser signal, an opt-out preference signal recognized under the CCPA/CPRA. When our systems detect a valid GPC signal from your browser, we treat that signal as a request to opt out of the sale or sharing of Personal Information for cross-context behavioral advertising. Because we do not sell Personal Information or share it for cross-context behavioral advertising in any event, the practical effect is that we honor your GPC preference on arrival.</p>
    <p>Because there is no consistent industry standard for responding to the older &ldquo;Do Not Track&rdquo; browser signal, the Website does not currently respond to that signal differently.</p>

    <h2>14. Newsletter and email communications</h2>
    <p>If you subscribe to our newsletter, we collect your email address and any name you provide, and we deliver newsletter content through Beehiiv. Every newsletter email identifies itself as commercial, contains our physical postal address, and provides a functioning unsubscribe link. You may opt out at any time by clicking the unsubscribe link in any newsletter email or by emailing <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>"><?php echo esc_html( srj_get_email() ); ?></a> with &ldquo;unsubscribe&rdquo; in the subject line. Unsubscribing from the newsletter does not affect other communications related to services you have specifically requested. We comply with the CAN-SPAM Act of 2003.</p>

    <h2>15. SMS text messaging and A2P 10DLC compliance</h2>
    <p>The WPForms contact form (form ID 196) offers an optional SMS-consent checkbox. If you check that box and provide your phone number, you consent to receive SMS text messages from SRJ related to your inquiry. Message frequency varies. Message and data rates may apply. Reply <strong>STOP</strong> to any message to opt out; reply <strong>HELP</strong> for help. Contact us at <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>"><?php echo esc_html( srj_get_email() ); ?></a> or by telephone for support.</p>
    <p>SRJ&rsquo;s SMS program is registered as a compliant A2P 10DLC campaign with U.S. wireless carriers. Consent to receive text messages is <strong>not</strong> a condition of any purchase, service, or communication. Mobile information and SMS opt-in data are not shared with third parties or affiliates for marketing or promotional purposes and are not sold, rented, or transferred to any third party for any purpose other than to deliver the messages you have consented to receive.</p>

    <h2>16. Website analytics and session recording</h2>
    <p>SRJ uses Google Analytics 4 (measurement ID G-WWP3BSKN5N) to understand aggregate Website use and Microsoft Clarity (project ID wxtqd3ud7i) to view session recordings and heatmaps that help us diagnose usability issues. Both tools are gated behind the Complianz consent banner under the &ldquo;Statistics&rdquo; category and do not run until you provide consent. Session recordings are masked by default to reduce collection of typed input; we do not intentionally record passwords, credit-card numbers, or other sensitive fields. Microsoft Clarity retains session data on its own schedule described at <a href="https://learn.microsoft.com/en-us/clarity/faq" rel="nofollow noopener" target="_blank">Microsoft Clarity FAQ</a>. You can opt out of both tools by rejecting the &ldquo;Statistics&rdquo; category in the consent banner or by using a browser extension that blocks tracking.</p>

    <h2>17. Book worksheet gate and the functional cookie</h2>
    <p>Downloadable worksheets that accompany our books are gated behind a lightweight email-verification step: you enter an email address, we send a one-time confirmation email with a signed unlock link, and clicking the link sets a first-party functional cookie named &ldquo;<code>srj_worksheet_access</code>&rdquo; that remembers the unlock for 10 years, path <code>/</code>, SameSite Lax. The cookie contains only a numeric marker; no email address, name, or identifying content is stored inside the cookie. The email address you enter is used <strong>solely</strong> for delivery of the confirmation email and is <strong>not</strong> enrolled in the newsletter or any marketing automation unless you separately opt in. You can clear the cookie at any time through your browser.</p>

    <h2>18. AI use in our operations</h2>
    <p>SRJ advises executives on the disciplined, accountable use of artificial intelligence. Consistent with that work, we use AI tools in our own operations, including in the production of written content, editorial support, research, analysis, and graphics across the Website, our newsletter, our books, and related publications. Every piece of content is reviewed, edited, and approved by <strong>Stephen R. Jordan</strong> before publication. Please see our <a href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>">Disclaimer</a> for further detail.</p>

    <h2>19. How we do NOT use your Personal Information with artificial intelligence</h2>
    <p>Because we advise on responsible AI, we hold ourselves to a specific commitment about your Personal Information and artificial intelligence:</p>
    <ul>
      <li><strong>We do not sell or license your Personal Information for AI model training</strong> by any third party.</li>
      <li><strong>We do not use content you send us through the contact form, newsletter, or worksheet gate to train any public, foundation, or fine-tuned model.</strong></li>
      <li><strong>We do not use recordings of consultations, if any are made with your consent, to train any AI model</strong> beyond the internal transcription and summarization tools used to prepare our own notes for that engagement.</li>
      <li>If we ever change any of these positions, we will update this Policy and notify subscribers before the change takes effect.</li>
    </ul>

    <h2>20. Data retention</h2>
    <p>We retain Personal Information only for as long as necessary to fulfill the purposes described in this Policy, to maintain reasonable business records, and to comply with legal obligations. Retention periods vary by category:</p>
    <ul>
      <li><strong>Contact-form submissions:</strong> retained for up to 24 months from last contact, then archived or deleted.</li>
      <li><strong>Newsletter subscribers:</strong> retained for as long as you remain subscribed. On unsubscribe, we retain a suppression record indefinitely to honor your unsubscribe request; the record contains only the email address plus the fact of unsubscribe.</li>
      <li><strong>Worksheet-gate confirmations:</strong> the email address is retained for up to 90 days for support purposes, then deleted from operational storage. The unlock cookie on your device persists for 10 years unless you clear it.</li>
      <li><strong>Consultation records:</strong> retained for the life of the engagement and for a reasonable period after (typically seven years) to satisfy professional record-keeping obligations.</li>
      <li><strong>Analytics data:</strong> retained per the retention settings of Google Analytics 4 and Microsoft Clarity, generally 14 months to 26 months.</li>
      <li><strong>Server logs:</strong> retained for security and diagnostic purposes for up to 12 months.</li>
      <li><strong>Financial records:</strong> retained per applicable tax, corporate, and professional-standards requirements, generally seven years.</li>
    </ul>
    <p>When Personal Information is no longer required, we take reasonable steps to delete or de-identify it.</p>

    <h2>21. Data security</h2>
    <p>We take reasonable administrative, technical, and organizational measures to protect Personal Information transmitted to and held by us. These measures include: TLS encryption in transit for all Website traffic (HTTPS enforced by HSTS); the Sucuri web application firewall filtering inbound traffic; Cloudflare Turnstile bot protection on the contact form; strong administrator authentication with multi-factor authentication; role-based access control; monthly patch and update cycles for the WordPress core, theme, and plugins; regular backups; and a small, deliberate plugin footprint to limit attack surface.</p>
    <p>Despite these measures, <strong>no method of transmission over the internet or method of electronic storage is completely secure, and we cannot guarantee absolute security.</strong> You provide information to us at your own risk. You are responsible for maintaining the security of any account credentials you use to access services related to the Website.</p>

    <h2>22. Data breach notification</h2>
    <p>If SRJ becomes aware of a breach of security that compromises the confidentiality, integrity, or availability of your Personal Information, we will investigate promptly, take reasonable steps to contain and remediate the incident, and notify affected individuals and applicable regulators as required by law. Notifications may be delivered by email, by prominent notice on the Website, or by other means reasonably designed to reach affected individuals.</p>

    <h2>23. Children&rsquo;s privacy</h2>
    <p>The Website and our services are directed to business professionals, not children. We do not knowingly collect Personal Information from children under 13, and we do not knowingly market to children or teenagers. If you believe a child under 13 has provided Personal Information to us, please contact us at <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>"><?php echo esc_html( srj_get_email() ); ?></a> and we will take reasonable steps to delete the information. We comply with the Children&rsquo;s Online Privacy Protection Act (COPPA).</p>

    <h2>24. Your privacy choices and rights</h2>
    <p>Subject to applicable law and to identity verification, you have the following choices with respect to your Personal Information:</p>
    <ul>
      <li>You may <strong>unsubscribe</strong> from our newsletter at any time using the link in any newsletter email.</li>
      <li>You may <strong>opt out of SMS text messages</strong> at any time by replying STOP to any message.</li>
      <li>You may <strong>reject or withdraw consent for non-essential cookies</strong> through the Complianz banner or the Opt-Out Preferences page.</li>
      <li>You may <strong>request access, correction, deletion, restriction, portability, or objection</strong> with respect to your Personal Information by using the contact information in Section 36.</li>
      <li>You may <strong>designate an authorized agent</strong> to submit a request on your behalf, subject to verification of the agent&rsquo;s authority.</li>
    </ul>
    <p>The specific rights available to you depend on your state or country of residence, as described in Sections 25 through 27.</p>

    <h2>25. California residents: CCPA and CPRA rights</h2>
    <p>If you are a California resident, the CCPA/CPRA gives you the following rights:</p>
    <ul>
      <li><strong>Right to know</strong> what Personal Information we collect, use, disclose, and (if applicable) sell or share, including the specific pieces of Personal Information we hold about you and the categories of sources, purposes, and recipients described in Sections 5 through 11.</li>
      <li><strong>Right to correct</strong> inaccurate Personal Information we hold about you.</li>
      <li><strong>Right to delete</strong> Personal Information we have collected from you, subject to statutory exceptions.</li>
      <li><strong>Right to opt out of sale and sharing.</strong> <strong>SRJ does not sell Personal Information and does not share Personal Information for cross-context behavioral advertising.</strong> The Website recognizes the Global Privacy Control (GPC) signal as described in Section 13.</li>
      <li><strong>Right to limit use of Sensitive Personal Information.</strong> Because SRJ does not use Sensitive Personal Information for purposes other than those permitted by CCPA regulations, no separate limitation option applies.</li>
      <li><strong>Right to non-discrimination</strong> for exercising your rights.</li>
      <li><strong>Right to designate an authorized agent</strong> to submit requests on your behalf.</li>
    </ul>
    <p>To exercise any of these rights, contact us using the details in Section 36. We will verify your identity before responding. We will respond within the timeframes required by law (generally 45 days, with a possible 45-day extension). If we deny a request, you may appeal by replying to our response.</p>
    <p><strong>Notice of financial incentives.</strong> SRJ does not offer any financial incentive tied to the collection, retention, sale, or sharing of Personal Information.</p>

    <h2>26. Other U.S. state privacy rights</h2>
    <p>Depending on your state of residence, you may have additional rights under the following state privacy laws:</p>
    <ul>
      <li>The <strong>Texas Data Privacy and Security Act</strong> (TDPSA), effective July 1, 2024;</li>
      <li>The <strong>Virginia Consumer Data Protection Act</strong> (VCDPA);</li>
      <li>The <strong>Colorado Privacy Act</strong> (CPA);</li>
      <li>The <strong>Connecticut Data Privacy Act</strong> (CTDPA);</li>
      <li>The <strong>Utah Consumer Privacy Act</strong> (UCPA);</li>
      <li>The <strong>Oregon Consumer Privacy Act</strong> (OCPA);</li>
      <li>The <strong>Montana Consumer Data Privacy Act</strong>;</li>
      <li>Additional state laws that come into effect from time to time.</li>
    </ul>
    <p>Depending on your state, these rights generally include the right to confirm processing and access your Personal Information, the right to correct inaccurate Personal Information, the right to delete Personal Information, the right to obtain a portable copy of your Personal Information, the right to opt out of targeted advertising, sale of Personal Information, and certain profiling, and the right to appeal our denial of a request. As stated above, <strong>SRJ does not sell Personal Information and does not use it for targeted advertising or profiling that produces legal or similarly significant effects.</strong> To exercise any right, contact us using the details in Section 36.</p>

    <h2>27. EEA, UK, and Swiss residents: GDPR rights</h2>
    <p>If you are located in the European Economic Area, the United Kingdom, or Switzerland, you have the following rights with respect to your personal data:</p>
    <ul>
      <li>The right of <strong>access</strong> to your personal data;</li>
      <li>The right to <strong>rectification</strong> of inaccurate or incomplete personal data;</li>
      <li>The right to <strong>erasure</strong> (&ldquo;right to be forgotten&rdquo;), subject to statutory exceptions;</li>
      <li>The right to <strong>restriction</strong> of processing in certain circumstances;</li>
      <li>The right to <strong>data portability</strong>, to receive your personal data in a structured, commonly used, machine-readable format and to transmit it to another controller;</li>
      <li>The right to <strong>object</strong> to processing based on legitimate interests or direct marketing;</li>
      <li>The right to <strong>withdraw consent</strong> at any time, where processing is based on consent;</li>
      <li>The right to <strong>lodge a complaint</strong> with your local data protection authority.</li>
    </ul>
    <p>To exercise these rights, contact us using the details in Section 36. We will respond within one month, subject to statutory extensions where the request is complex.</p>

    <h2>28. International data transfers</h2>
    <p>SRJ is based in the United States, and our Service Providers may process Personal Information in the United States or in other jurisdictions. If you access the Website from outside the United States, you understand that your information may be transferred to, stored in, and processed in the United States and in other countries where our Service Providers operate, and that data-protection laws in those countries may differ from those in your jurisdiction.</p>
    <p>Where required for transfers of personal data out of the EEA, the United Kingdom, or Switzerland, we rely on appropriate safeguards such as the European Commission&rsquo;s Standard Contractual Clauses, the UK International Data Transfer Addendum, and the Swiss-U.S. Data Privacy Framework, as applicable. You may request more information about these safeguards by contacting us.</p>

    <h2>29. Automated decision-making and profiling</h2>
    <p><strong>SRJ does not make decisions that produce legal or similarly significant effects on you by solely automated means, and does not engage in automated profiling of individuals for purposes that produce such effects.</strong> The Website uses automated analytics and heatmaps to understand aggregate visitor behavior, but these do not produce individualized decisions about you.</p>

    <h2>30. How to exercise your rights</h2>
    <p>To exercise any right described in Sections 24 through 27, please send a request to <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>"><?php echo esc_html( srj_get_email() ); ?></a> with a clear subject line such as &ldquo;Privacy Rights Request.&rdquo; Please include: (a) your full name; (b) the email address, phone number, or account identifier associated with your Personal Information; (c) the state or country in which you reside; (d) a clear statement of the right you are exercising and, where relevant, the Personal Information at issue; and (e) any additional information needed to verify your identity.</p>
    <p>We will use the information you provide to verify your identity. If we cannot verify your identity to a level of certainty appropriate to the sensitivity of the information or the risk of harm from unauthorized disclosure, we may decline to fulfill your request and will explain why. We respond as promptly as we can, in any event within the timeframes required by applicable law.</p>
    <p><strong>Authorized agents.</strong> You may designate an authorized agent to submit a request on your behalf. We require the agent to provide a signed authorization or a valid power of attorney, and we may require you to verify your identity directly and to confirm to us that you have authorized the agent to submit the request.</p>

    <h2>31. Appeals</h2>
    <p>If we decline a privacy rights request in whole or in part, you may appeal our decision by replying to our response within 60 days of receipt, or by sending a new email to <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>"><?php echo esc_html( srj_get_email() ); ?></a> with the subject line &ldquo;Privacy Rights Appeal.&rdquo; We will review the appeal and respond within the timeframe required by applicable law (generally 45 days). If your appeal is denied, you may submit a complaint to your state attorney general or, if applicable, your data-protection supervisory authority.</p>

    <h2>32. Non-discrimination</h2>
    <p>We will not deny you goods or services, charge you different prices, provide a different level or quality of service, or retaliate against you for exercising a privacy right described in this Policy.</p>

    <h2>33. Sale of business, mergers, and acquisitions</h2>
    <p>If SRJ enters into a merger, acquisition, financing, reorganization, bankruptcy, receivership, or sale of some or all of its assets, Personal Information may be part of the transferred assets. Any acquirer will be required to honor the commitments in this Policy with respect to Personal Information collected before the transfer, and material changes to privacy practices going forward will be notified to affected individuals.</p>

    <h2>34. Links to other websites</h2>
    <p>The Website may contain links to third-party websites, including Amazon (for book purchases), Beehiiv (for newsletter subscription management), LinkedIn (for professional profile), YouTube (for embedded video), and other services referenced in our content. We are not responsible for the privacy practices or content of any third-party website. We encourage you to review the privacy policy of any third-party website you visit.</p>

    <h2>35. Changes to this Policy</h2>
    <p>We may update this Policy from time to time. When we do, we will update the &ldquo;last updated&rdquo; date at the top of this Policy and post the revised Policy on the Website. If we make material changes, we will provide reasonable notice, which may include a banner on the Website, an email to subscribers, or another reasonable method. <strong>Your continued use of the Website after the effective date of the revised Policy constitutes your acceptance of the revised Policy.</strong> If you do not agree, your only remedy is to stop using the Website and to unsubscribe from any communications you had previously requested.</p>

    <h2>36. Contact and privacy inquiries</h2>
    <p>Questions, comments, requests, or complaints regarding this Policy or our privacy practices may be directed to:</p>
    <p>SRJ Consulting &amp; Services LLC<br />
    Attn: Privacy Officer<br />
    <?php echo esc_html( srj_get_address_line1() ); ?><br />
    <?php echo esc_html( srj_get_address_line2() ); ?><br />
    United States<br />
    Email: <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>"><?php echo esc_html( srj_get_email() ); ?></a></p>
    <p>Dispute resolution for matters arising from this Policy is governed by the arbitration and venue provisions in <a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>">Sections 18 and 20 of the Terms of Use</a> (JAMS binding arbitration; venue: Collin County, Texas; governing law: Texas).</p>
  </div>
</section>

<?php get_footer(); ?>
