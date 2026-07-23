<?php
/**
 * Template Name: Terms of Service
 *
 * Terms of Use Template
 * Slug: terms
 *
 * v3 (July 10, 2026): Trademark list reconciled against the canonical
 * SRJ_Trademark_Portfolio_v1_1.csv (source of truth, 78 marks). Eight
 * corrections to the v2 §7 list: (1) Added "The" prefix to
 * The AI Efficiency & Process Optimization, The AI IT Security Audit,
 * The AI IT Security Implementation & Strategy, The AI Readiness &
 * Performance Assessment. (2) Reworded AI-to-Outcome Alignment Map to
 * Outcome Alignment Map. (3) Repunctuated Expand-Refine-Pause Decision
 * Protocol to Expand, Refine, or Pause Decision Protocol. (4) Removed
 * NEYR (Net Efficiency Yield Ratio) and OLF (Operational Leakage Factor)
 * as neither is in the canonical portfolio. (5) Added missing
 * Use Case Decision Record. Total marks now 78 matching CSV exactly.
 * Last updated string kept as July 7 2026 since the substantive legal
 * text is unchanged; only the mark list precision improved.
 *
 * v2 (July 7, 2026): Full lawyer-reviewed rewrite. Extended the July 4 2026
 * draft with binding arbitration + class action waiver + jury trial waiver
 * (Section 18), DMCA notice and takedown procedure (Section 13), AI-specific
 * disclaimers (Section 8), $100 aggregate liability cap (Section 15),
 * termination rights with survival list (Section 17), force majeure
 * (Section 19), assignment (Section 23), waiver (Section 24), survival
 * (Section 26), venue narrowed to Collin County, and CAN-SPAM electronic
 * communications consent (Section 10). Trademark list rebuilt from
 * operator-provided source of truth (75+ marks). Last updated string is now
 * hardcoded to the review-and-sign-off date rather than date('F Y'), which
 * previously rendered the current month every visit and was inconsistent
 * with legal-document convention. Reviewed and approved by operator (acting
 * as counsel) July 7 2026.
 *
 * v1 (June 22, 2026): Initial standard-practice draft.
 */
get_header();
?>

<?php srj_page_hero( 'Legal', 'Terms of Use' ); ?>

<section class="longform">
  <div class="container">
    <p><em>Last updated: July 7, 2026</em></p>

    <h2>1. Acceptance of these terms</h2>
    <p>These Terms of Use (&ldquo;<strong>Terms</strong>&rdquo;) are a binding legal agreement between you and SRJ Consulting &amp; Services LLC (&ldquo;<strong>SRJ</strong>,&rdquo; &ldquo;<strong>we</strong>,&rdquo; &ldquo;<strong>us</strong>,&rdquo; &ldquo;<strong>our</strong>&rdquo;) governing your access to and use of the website located at srjconsultingservices.com and any associated pages, newsletters, publications, downloads, tools, and services we make available (collectively, the &ldquo;<strong>Website</strong>&rdquo;). By accessing, browsing, subscribing to, downloading from, or otherwise using the Website, you agree to be bound by these Terms and by our <a href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>">Privacy Policy</a> and <a href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>">Disclaimer</a>, each of which is incorporated by reference. <strong>If you do not agree to these Terms, do not access or use the Website.</strong></p>

    <h2>2. Who we are</h2>
    <p>SRJ Consulting &amp; Services LLC is a Texas limited liability company with its principal place of business at <?php echo esc_html( srj_get_address_line1() ); ?>, <?php echo esc_html( srj_get_address_line2() ); ?>, United States. SRJ is an advisory firm providing guidance to executives on the operational, governance, and security dimensions of artificial intelligence. References on the Website to our services describe the general nature of our work and are not an offer or guarantee of any specific engagement, outcome, or result.</p>

    <h2>3. Age, capacity, and authority</h2>
    <p>You represent and warrant that you are at least 18 years old and have the legal capacity to enter into a binding agreement. If you access or use the Website on behalf of an entity, you represent and warrant that you have the authority to bind that entity to these Terms, and &ldquo;you&rdquo; refers to both you individually and to the entity. The Website is not directed to children under 13, and we do not knowingly collect information from children under 13.</p>

    <h2>4. Permitted use of the Website</h2>
    <p>Subject to your compliance with these Terms, we grant you a limited, non-exclusive, non-transferable, non-sublicensable, revocable license to access and use the Website for lawful, personal, and legitimate business purposes, including learning about SRJ&rsquo;s services, methodology, and publications. You may share links to our content and may quote brief excerpts (typically 100 words or fewer) with clear attribution to SRJ Consulting &amp; Services LLC and a link back to the original page. All other use of the Website or its content requires our prior written permission.</p>

    <h2>5. Prohibited conduct</h2>
    <p>You agree not to, and not to permit any third party to:</p>
    <ul>
      <li>use the Website in any way that violates applicable federal, state, local, or international law or regulation;</li>
      <li>reproduce, republish, sell, license, rent, distribute, or commercially exploit any content from the Website without our prior written consent;</li>
      <li>attempt to gain unauthorized access to the Website, our servers, systems, databases, accounts, or any related network;</li>
      <li>introduce viruses, malware, ransomware, or any other malicious code, or attempt to disrupt the availability, security, integrity, or operation of the Website;</li>
      <li>use any automated system, including robots, spiders, scrapers, or offline readers, to access, copy, index, or collect content or data from the Website, except in compliance with our robots.txt file;</li>
      <li>use the Website or its content to train, fine-tune, or evaluate any machine-learning model without our prior written consent;</li>
      <li>misrepresent your identity, credentials, or affiliation with any person or entity, or impersonate SRJ, its principals, or its representatives;</li>
      <li>use the Website to harass, threaten, defame, defraud, or otherwise harm any person or entity;</li>
      <li>remove, obscure, or alter any copyright, trademark, or other proprietary notice on any content;</li>
      <li>reverse engineer, decompile, or attempt to derive source code from any software or system that supports the Website;</li>
      <li>interfere with or circumvent any security feature, access control, or usage limitation of the Website; or</li>
      <li>use the Website in a manner that could impose an unreasonable or disproportionately large load on our infrastructure.</li>
    </ul>

    <h2>6. Intellectual property</h2>
    <p>All content on the Website, including text, articles, book excerpts, frameworks, methodologies, checklists, worksheets, templates, graphics, logos, images, video, audio, code, and the selection, arrangement, and design of the Website (collectively, &ldquo;<strong>Content</strong>&rdquo;), is the property of SRJ Consulting &amp; Services LLC or its licensors and is protected by United States and international copyright, trademark, trade dress, and other intellectual property laws. Except for the limited license granted in Section 4, no right, title, or interest in or to any Content is transferred to you, and all rights not expressly granted are reserved by SRJ.</p>

    <h2>7. Trademarks</h2>
    <p>The following are trademarks or claimed common-law marks of SRJ Consulting &amp; Services LLC. Each is asserted through use in commerce; the &trade; symbol indicates a common-law claim and does not by itself indicate federal registration. These marks may not be used without our prior written permission.</p>
    <p>SRJ trademarks include:</p>
    <ul>
      <li>The 6-Step Review Process&trade;</li>
      <li>90-Day AI Decision Action Plan&trade;</li>
      <li>90-Day AI Readiness Roadmap&trade;</li>
      <li>90-Day Governance Launch Plan&trade;</li>
      <li>AI Accountability Matrix&trade;</li>
      <li>AI Adoption Decision Framework&trade;</li>
      <li>AI Adoption Pattern Map&trade;</li>
      <li>AI Board Reporting Package&trade;</li>
      <li>The AI Business Enablement Audit&trade;</li>
      <li>AI Business Services&trade;</li>
      <li>AI Communication Alignment Protocol&trade;</li>
      <li>AI Corrective Action Register&trade;</li>
      <li>AI Data Exposure Model&trade;</li>
      <li>AI Decision Accountability Framework&trade;</li>
      <li>The AI Efficiency &amp; Process Optimization&trade;</li>
      <li>The AI Efficiency Gap&trade;</li>
      <li>The AI Efficiency Scorecard&trade;</li>
      <li>The AI Efficiency Tax&trade;</li>
      <li>AI Friction Diagnostic&trade;</li>
      <li>AI Governance Framework Crosswalk&trade;</li>
      <li>AI Governance Matrix&trade;</li>
      <li>AI Governance Maturity Scale&trade;</li>
      <li>AI Governance Sign-Off Architecture&trade;</li>
      <li>AI Incident Response Framework&trade;</li>
      <li>AI Integration Checklist&trade;</li>
      <li>AI Internal Audit Workpaper Log&trade;</li>
      <li>The AI IT Security Audit&trade;</li>
      <li>The AI IT Security Implementation &amp; Strategy&trade;</li>
      <li>AI Literacy Framework&trade;</li>
      <li>AI Management Review Minutes Log&trade;</li>
      <li>AI Operating Calendar&trade;</li>
      <li>The AI Operating System&trade;</li>
      <li>AI Operational Risk Assessment&trade;</li>
      <li>AI Operational Risk Categories&trade;</li>
      <li>AI Output Review Exception Log&trade;</li>
      <li>AI Performance Governance&trade;</li>
      <li>AI Performance Scorecard&trade;</li>
      <li>The AI Readiness &amp; Performance Assessment&trade;</li>
      <li>AI Readiness Attestation Sheet&trade;</li>
      <li>AI Readiness Maturity Scale&trade;</li>
      <li>AI Refinement Register&trade;</li>
      <li>AI Risk &amp; Governance Review&trade;</li>
      <li>AI Risk Governance &amp; Security&trade;</li>
      <li>AI ROI Evaluation Framework&trade;</li>
      <li>The AI ROI Formula&trade;</li>
      <li>AI Stakeholder Communication Matrix&trade;</li>
      <li>AI Steering Committee Charter&trade;</li>
      <li>AI Third-Party Governance Statement&trade;</li>
      <li>AI Use Case Custodian Log&trade;</li>
      <li>AI Vendor Risk Inventory&trade;</li>
      <li>Outcome Alignment Map&trade;</li>
      <li>Application Security in the Age of AI&trade;</li>
      <li>Approved AI Tool Register&trade;</li>
      <li>Baseline Verification Standard&trade;</li>
      <li>Bi-Annual AI Readiness Reassessment Log&trade;</li>
      <li>Cloud and Infrastructure Security in the Age of AI&trade;</li>
      <li>Data Accountability and Remediation Checklist&trade;</li>
      <li>Data Reliability Checklist&trade;</li>
      <li>Decision Control Matrix&trade;</li>
      <li>Decision Influence Matrix&trade;</li>
      <li>Expand, Refine, or Pause Decision Protocol&trade;</li>
      <li>Expansion Authorization Profile&trade;</li>
      <li>Foundation Pause Mandate&trade;</li>
      <li>The Four Audit Outputs&trade;</li>
      <li>Governance Communication Cascade&trade;</li>
      <li>Master 90-Day Execution Matrix&trade;</li>
      <li>Master AI Readiness Scorecard&trade;</li>
      <li>The Operating Discipline for AI Library&trade;</li>
      <li>Operational Health Check&trade;</li>
      <li>Operational Integration &amp; Workflow Adoption&trade;</li>
      <li>Performance Reality Test&trade;</li>
      <li>Refinement Remediation Protocol&trade;</li>
      <li>Repeatable Governance Framework&trade;</li>
      <li>Secure by Design in the Age of AI&trade;</li>
      <li>Standing AI Adoption Policy&trade;</li>
      <li>Use Case Decision Record&trade;</li>
      <li>Weekly AI Operational Spot Check Log&trade;</li>
      <li>Workflow Readiness Review&trade;</li>
    </ul>
    <p>Other names, logos, and marks referenced on the Website are the property of their respective owners. The absence of a name or mark from this list does not constitute a waiver of any rights SRJ may hold in it. Nothing on the Website should be construed as granting any license or right to use any SRJ trademark without our prior written consent.</p>

    <h2>8. Artificial intelligence disclaimers</h2>
    <p>SRJ publishes methodology, frameworks, and educational content concerning the operational, governance, and security dimensions of artificial intelligence. <strong>You acknowledge and agree that:</strong></p>
    <ul>
      <li>artificial intelligence outputs, including outputs from third-party AI tools referenced on the Website, are probabilistic, may be inaccurate or incomplete, and require independent verification by qualified professionals before being relied upon;</li>
      <li>SRJ&rsquo;s frameworks and methodologies describe general operating principles and are not a substitute for engagement-specific advice tailored to your organization&rsquo;s facts;</li>
      <li>SRJ makes no warranty that application of any framework, methodology, worksheet, or tool published on the Website will produce any specific outcome, financial result, compliance posture, or risk reduction;</li>
      <li>references on the Website to third-party AI tools, platforms, standards, or frameworks, including but not limited to the NIST AI Risk Management Framework and ISO/IEC 42001, are for informational purposes only and do not constitute an endorsement, partnership, certification, or affiliation;</li>
      <li>regulatory requirements applicable to artificial intelligence are evolving; content on the Website reflects our understanding at the time of publication and may not reflect current law; and</li>
      <li>you are solely responsible for determining the suitability of any framework, methodology, or recommendation described on the Website for your specific circumstances, and for complying with all laws applicable to your use of artificial intelligence.</li>
    </ul>

    <h2>9. No professional advice; no client relationship</h2>
    <p>Content on the Website and in our newsletter is general educational information and does <strong>not</strong> constitute professional, business, legal, financial, accounting, tax, technical, cybersecurity, or regulatory-compliance advice. Use of the Website does not create a consulting, advisory, fiduciary, attorney-client, or client relationship of any kind between you and SRJ. A client relationship with SRJ is established only through a signed, written engagement agreement executed by an authorized SRJ representative. You should consult qualified professionals for advice tailored to your specific circumstances. Please also see our <a href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>">Disclaimer</a>.</p>

    <h2>10. Newsletter and electronic communications</h2>
    <p>If you subscribe to our newsletter or otherwise provide us with your email address, you consent to receive periodic email communications from SRJ, which may include newsletters, publications, announcements, invitations, and information about our services. We comply with the CAN-SPAM Act of 2003. Every commercial email from SRJ will identify itself as such, will include our physical postal address, and will provide a functioning unsubscribe mechanism. You may unsubscribe at any time by clicking the unsubscribe link in any email or by emailing <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>"><?php echo esc_html( srj_get_email() ); ?></a> with &ldquo;unsubscribe&rdquo; in the subject line. We will honor unsubscribe requests within ten business days. <strong>We are not responsible</strong> for any failure of delivery caused by your email provider, spam filters, security settings, or network issues on your side.</p>
    <p>You further consent to receive electronic communications from SRJ in connection with your use of the Website, including notices, agreements, disclosures, and other communications. You agree that all such electronic communications satisfy any legal requirement that such communications be in writing. You may withdraw consent to electronic communications at any time by contacting us at <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>"><?php echo esc_html( srj_get_email() ); ?></a>, but doing so may end your ability to use certain features of the Website.</p>

    <h2>11. User submissions and feedback</h2>
    <p>Any message, inquiry, comment, question, or material you send to us through the Website is <strong>not confidential</strong> unless we have a signed written agreement providing otherwise. Do not send SRJ any confidential, proprietary, or sensitive information through the Website or through our contact form or email; anything you send may be read, stored, and used by SRJ without obligation to you.</p>
    <p>By submitting any feedback, suggestion, idea, comment, review, or recommendation to SRJ concerning the Website, our methodology, or our services (&ldquo;<strong>Feedback</strong>&rdquo;), you grant SRJ a perpetual, irrevocable, worldwide, royalty-free, fully paid-up, non-exclusive, sublicensable, transferable license to use, reproduce, modify, adapt, publish, translate, distribute, display, and create derivative works of the Feedback in any medium, for any purpose, without attribution, notice, compensation, or obligation to you. You represent and warrant that you have the right to grant this license and that the Feedback does not infringe the rights of any third party.</p>

    <h2>12. Third-party links, tools, and resources</h2>
    <p>The Website may link to, embed, or reference third-party websites, tools, platforms, standards, frameworks, or resources for informational convenience, including but not limited to Amazon, YouTube, Google Analytics, Microsoft Clarity, Cloudflare Turnstile, Beehiiv, and outcomestar. We do not control, endorse, sponsor, or assume responsibility for the content, accuracy, privacy practices, security, products, or services of any third-party website, tool, or resource. Your use of any third-party website, tool, or resource is at your own risk and subject to the terms and privacy policies of that third party.</p>

    <h2>13. DMCA notice and takedown procedure</h2>
    <p>SRJ respects the intellectual property rights of others and expects users of the Website to do the same. If you believe in good faith that content on the Website infringes your copyright, you may submit a notice under the Digital Millennium Copyright Act (17 U.S.C. &sect; 512) to our designated agent below. Your notice must include all of the following:</p>
    <ul>
      <li>a physical or electronic signature of the copyright owner or a person authorized to act on the owner&rsquo;s behalf;</li>
      <li>identification of the copyrighted work claimed to have been infringed, or, if multiple works are covered, a representative list;</li>
      <li>identification of the material claimed to be infringing, with sufficient detail (including URL) to allow us to locate it;</li>
      <li>your contact information, including name, mailing address, telephone number, and email address;</li>
      <li>a statement that you have a good-faith belief that the use of the material is not authorized by the copyright owner, its agent, or the law; and</li>
      <li>a statement, under penalty of perjury, that the information in your notice is accurate and that you are the copyright owner or authorized to act on the owner&rsquo;s behalf.</li>
    </ul>
    <p><strong>Designated agent for DMCA notices:</strong><br />
    SRJ Consulting &amp; Services LLC<br />
    Attn: DMCA Agent<br />
    <?php echo esc_html( srj_get_address_line1() ); ?><br />
    <?php echo esc_html( srj_get_address_line2() ); ?><br />
    United States<br />
    Email: <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>"><?php echo esc_html( srj_get_email() ); ?></a></p>
    <p>We may remove or disable access to material in response to a valid DMCA notice. We may also terminate the access of users who are repeat infringers, in appropriate circumstances.</p>

    <h2>14. Disclaimer of warranties</h2>
    <p><strong>THE WEBSITE AND ALL CONTENT, MATERIALS, PRODUCTS, AND SERVICES ARE PROVIDED ON AN &ldquo;AS IS&rdquo; AND &ldquo;AS AVAILABLE&rdquo; BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, EITHER EXPRESS OR IMPLIED. TO THE FULLEST EXTENT PERMITTED BY APPLICABLE LAW, SRJ EXPRESSLY DISCLAIMS ALL WARRANTIES AND CONDITIONS, INCLUDING WITHOUT LIMITATION THE IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, TITLE, NON-INFRINGEMENT, ACCURACY, COMPLETENESS, QUIET ENJOYMENT, AND ANY WARRANTY ARISING FROM COURSE OF DEALING, USAGE, OR TRADE PRACTICE.</strong></p>
    <p>SRJ does not warrant that the Website will be uninterrupted, timely, secure, or error-free, that defects will be corrected, that any information will be accurate or reliable, or that the Website or its servers are free of viruses or other harmful components. No advice or information, whether oral or written, obtained by you from SRJ or through the Website, will create any warranty not expressly stated in these Terms.</p>
    <p>Some jurisdictions do not allow the exclusion of certain warranties; to the extent such an exclusion is not permitted, the disclaimed warranties will be limited to the maximum extent allowed by law.</p>

    <h2>15. Limitation of liability</h2>
    <p><strong>TO THE FULLEST EXTENT PERMITTED BY APPLICABLE LAW, IN NO EVENT WILL SRJ CONSULTING &amp; SERVICES LLC, ITS OWNER, MEMBERS, MANAGERS, OFFICERS, EMPLOYEES, CONTRACTORS, AGENTS, LICENSORS, OR REPRESENTATIVES (COLLECTIVELY, THE &ldquo;SRJ PARTIES&rdquo;) BE LIABLE TO YOU OR TO ANY THIRD PARTY FOR ANY INDIRECT, INCIDENTAL, CONSEQUENTIAL, SPECIAL, EXEMPLARY, OR PUNITIVE DAMAGES, INCLUDING LOST PROFITS, LOST REVENUE, LOST DATA, LOST GOODWILL, LOSS OF BUSINESS OPPORTUNITY, OR COST OF SUBSTITUTE SERVICES, ARISING OUT OF OR IN CONNECTION WITH YOUR USE OF, OR INABILITY TO USE, THE WEBSITE, ITS CONTENT, OUR NEWSLETTER, OR ANY THIRD-PARTY LINK OR RESOURCE, WHETHER BASED IN CONTRACT, TORT (INCLUDING NEGLIGENCE), STATUTE, STRICT LIABILITY, OR ANY OTHER THEORY, AND WHETHER OR NOT THE SRJ PARTIES HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.</strong></p>
    <p><strong>IN NO EVENT WILL THE AGGREGATE LIABILITY OF THE SRJ PARTIES ARISING OUT OF OR IN CONNECTION WITH THESE TERMS OR YOUR USE OF THE WEBSITE EXCEED ONE HUNDRED U.S. DOLLARS ($100.00).</strong> This limitation applies to all causes of action, in the aggregate, including breach of contract, breach of warranty, negligence, strict liability, misrepresentation, and any other tort. The parties agree that this limitation is a material part of the bargain between them.</p>
    <p>Some jurisdictions do not allow the exclusion or limitation of certain damages; to the extent such an exclusion or limitation is not permitted, the limitation will apply to the maximum extent allowed by law, and the total liability of the SRJ Parties will be limited to the minimum amount permitted by applicable law.</p>

    <h2>16. Indemnification</h2>
    <p>You agree to defend, indemnify, and hold harmless the SRJ Parties from and against any and all claims, demands, actions, suits, proceedings, losses, liabilities, damages, judgments, settlements, costs, and expenses, including reasonable attorneys&rsquo; fees and court costs, arising out of or relating to (a) your access to or use of the Website; (b) your violation of these Terms; (c) your violation of any applicable law or the rights of any third party; (d) any Feedback or other material you submit to us; or (e) any reliance you place on Content published on the Website. SRJ reserves the right, at your expense, to assume the exclusive defense and control of any matter otherwise subject to indemnification by you, in which case you agree to cooperate with our defense of that matter.</p>

    <h2>17. Termination</h2>
    <p>We may suspend, restrict, or terminate your access to the Website, in whole or in part, at any time, with or without notice or cause, in our sole discretion. Reasons for termination may include, without limitation, your breach of these Terms, our reasonable belief that your use exposes SRJ or other users to legal or security risk, or our decision to discontinue any feature of the Website. On termination, your right to use the Website ends immediately. Sections that by their nature should survive termination will survive, including Sections 6 (Intellectual property), 7 (Trademarks), 11 (User submissions and feedback), 14 (Disclaimer of warranties), 15 (Limitation of liability), 16 (Indemnification), 18 (Binding arbitration), 20 (Governing law), and 24 through 28.</p>

    <h2>18. Binding arbitration, class action waiver, and jury trial waiver</h2>
    <p><strong>PLEASE READ THIS SECTION CAREFULLY. IT AFFECTS YOUR LEGAL RIGHTS AND REQUIRES ARBITRATION OF DISPUTES ON AN INDIVIDUAL BASIS.</strong></p>

    <h3>18.1 Agreement to arbitrate</h3>
    <p>Except as provided in Section 18.5 below, you and SRJ agree that any dispute, claim, or controversy arising out of or relating to (a) these Terms, (b) the Website, (c) our newsletter, (d) our Content, or (e) the marketing or delivery of any of the foregoing, whether based in contract, tort, statute, fraud, misrepresentation, or any other legal theory, and whether arising before, during, or after the termination of these Terms (each, a &ldquo;<strong>Dispute</strong>&rdquo;), will be resolved exclusively by <strong>binding individual arbitration</strong> administered by JAMS under its Streamlined Arbitration Rules and Procedures (or, if the amount in controversy exceeds $250,000, its Comprehensive Arbitration Rules and Procedures), as then in effect. The arbitrator will have exclusive authority to resolve any Dispute, including any threshold question of arbitrability. The arbitration will take place in Collin County, Texas, unless you and SRJ mutually agree otherwise. Judgment on the arbitrator&rsquo;s award may be entered in any court of competent jurisdiction.</p>

    <h3>18.2 Class action and jury trial waiver</h3>
    <p><strong>YOU AND SRJ EACH WAIVE ANY RIGHT TO A JURY TRIAL AND ANY RIGHT TO PARTICIPATE IN A CLASS ACTION, CLASS ARBITRATION, PRIVATE ATTORNEY GENERAL ACTION, OR OTHER REPRESENTATIVE PROCEEDING WITH RESPECT TO ANY DISPUTE.</strong> Disputes must be brought in your or SRJ&rsquo;s individual capacity, and not as a plaintiff or class member in any purported class, consolidated, or representative proceeding. The arbitrator may not consolidate more than one person&rsquo;s claims and may not preside over any form of representative or class proceeding. If a court decides that applicable law precludes enforcement of any of the limitations in this Section 18.2 as to a particular claim, that claim (and only that claim) must be severed from the arbitration and brought in court, and all other claims will proceed in arbitration.</p>

    <h3>18.3 Fees and costs</h3>
    <p>The arbitrator will determine the fees and costs of the arbitration in accordance with the applicable JAMS rules and applicable law. Each party will bear its own attorneys&rsquo; fees and expenses, unless the arbitrator determines that a party is entitled to recovery of fees under applicable law.</p>

    <h3>18.4 30-day opt-out right</h3>
    <p>You may opt out of this Section 18 (the arbitration, class action waiver, and jury trial waiver provisions) by sending written notice of your decision to opt out to <strong>SRJ Consulting &amp; Services LLC, Attn: Arbitration Opt-Out, <?php echo esc_html( srj_get_address_line1() ); ?>, <?php echo esc_html( srj_get_address_line2() ); ?>, United States</strong>, or by emailing <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>"><?php echo esc_html( srj_get_email() ); ?></a> with subject line &ldquo;<strong>Arbitration Opt-Out</strong>,&rdquo; in each case within thirty (30) days after the date you first accept these Terms. Your notice must include your name, mailing address, email address, and a clear statement that you wish to opt out of arbitration. If you opt out, neither you nor SRJ will be required to arbitrate the Disputes covered by this Section 18, and you and SRJ instead will be bound by Section 20 (Governing law and venue).</p>

    <h3>18.5 Exceptions</h3>
    <p>Notwithstanding Section 18.1, either party may (a) bring an individual action in small-claims court in the county of the other party&rsquo;s principal residence or place of business; and (b) seek injunctive or other equitable relief in a court of competent jurisdiction to prevent or restrain infringement, misappropriation, or violation of that party&rsquo;s intellectual property rights, including copyrights, trademarks, trade secrets, and patents.</p>

    <h2>19. Force majeure</h2>
    <p>SRJ will not be liable for any failure or delay in performance under these Terms to the extent caused by circumstances beyond our reasonable control, including without limitation acts of God, natural disasters, pandemic, epidemic, war, terrorism, civil unrest, government action, labor disputes, power failures, internet or telecommunications failures, denial-of-service attacks, hosting or third-party service failures, and failures of our vendors, subcontractors, or content-delivery networks.</p>

    <h2>20. Governing law and venue</h2>
    <p>These Terms, and any Dispute not subject to Section 18 (Binding arbitration), are governed by the laws of the State of Texas, without regard to its conflict-of-law principles. The United Nations Convention on Contracts for the International Sale of Goods does not apply. Subject to Section 18, you and SRJ agree that any judicial proceeding to enforce or interpret these Terms will be brought exclusively in the state or federal courts located in <strong>Collin County, Texas</strong>, and each party consents to the personal jurisdiction and venue of those courts and waives any objection based on inconvenient forum.</p>

    <h2>21. Privacy</h2>
    <p>Your use of the Website is also governed by our <a href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>">Privacy Policy</a>, which describes how we collect, use, share, and protect information. The Privacy Policy is incorporated by reference into these Terms.</p>

    <h2>22. Changes to these terms</h2>
    <p>We may modify these Terms from time to time. When we do, we will update the &ldquo;last updated&rdquo; date at the top of these Terms and post the revised Terms on the Website. If we make material changes, we will provide reasonable notice, which may include a banner on the Website, an email to subscribers, or another reasonable method. <strong>Your continued access to or use of the Website after the effective date of the revised Terms constitutes your acceptance of the revised Terms.</strong> If you do not agree to the revised Terms, your only remedy is to stop using the Website. We encourage you to review these Terms periodically.</p>

    <h2>23. Assignment</h2>
    <p>You may not assign or transfer these Terms or any of your rights or obligations under these Terms, in whole or in part, by operation of law or otherwise, without our prior written consent, and any purported assignment without such consent is void. SRJ may freely assign or transfer these Terms and its rights and obligations, in whole or in part, without restriction and without notice.</p>

    <h2>24. Waiver</h2>
    <p>No failure or delay by SRJ in exercising any right, power, or remedy under these Terms will operate as a waiver of that right, power, or remedy, and no single or partial exercise will preclude further exercise or the exercise of any other right, power, or remedy. Any waiver by SRJ must be in a writing signed by an authorized SRJ representative to be effective.</p>

    <h2>25. Severability</h2>
    <p>If any provision of these Terms is held to be invalid, illegal, or unenforceable in any respect by a court of competent jurisdiction or arbitrator, the invalidity, illegality, or unenforceability will not affect any other provision, and these Terms will be construed as if the invalid, illegal, or unenforceable provision had never been contained herein, except that if Section 18.2 (class action and jury trial waiver) is held to be invalid, unenforceable, or unavailable as to a particular Dispute, all of Section 18 as to that Dispute will be unenforceable, and that Dispute will be resolved under Section 20.</p>

    <h2>26. Survival</h2>
    <p>The provisions of these Terms that by their nature should survive expiration or termination will so survive, including without limitation Sections 6, 7, 8, 11, 14, 15, 16, 17, 18, 20, 22, 23, 24, 25, this Section 26, 27, and 28.</p>

    <h2>27. Entire agreement</h2>
    <p>These Terms, together with our <a href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>">Privacy Policy</a>, <a href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>">Disclaimer</a>, and any other legal notices or agreements published by SRJ on the Website, constitute the entire agreement between you and SRJ concerning your access to and use of the Website, and supersede all prior or contemporaneous communications, understandings, and agreements, whether written or oral, on that subject. These Terms do not, and are not intended to, confer any rights or remedies on any person other than you and SRJ.</p>

    <h2>28. Contact</h2>
    <p>Questions about these Terms may be directed to <a href="mailto:<?php echo esc_attr( srj_get_email() ); ?>"><?php echo esc_html( srj_get_email() ); ?></a>, or by writing to SRJ Consulting &amp; Services LLC, <?php echo esc_html( srj_get_address_line1() ); ?>, <?php echo esc_html( srj_get_address_line2() ); ?>.</p>
  </div>
</section>

<?php get_footer(); ?>
