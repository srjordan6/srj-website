<?php
/**
 * Template Name: FAQ
 *
 * FAQ Page Template
 * Slug: faq
 */
get_header();

$faqs = array(
    array(
        'q' => 'What services does SRJ Consulting &amp; Services LLC provide?',
        'a' => 'SRJ Consulting &amp; Services LLC is an executive AI advisory firm. We operate two practice areas. AI Business Services&trade; covers the AI Business Enablement Audit&trade;, AI Readiness &amp; Performance Assessment&trade;, AI Risk &amp; Governance Review&trade;, and AI Efficiency &amp; Process Optimization&trade;. AI Risk Governance &amp; Security&trade; covers the AI IT Security Audit&trade; and AI IT Security Implementation &amp; Strategy&trade;. Every engagement is grounded in our framework, The AI Operating System&trade;.',
    ),
    array(
        'q' => 'Are you an AI tool vendor or reseller?',
        'a' => 'No. We are not affiliated with any AI vendor, platform, or software reseller. We remain tool-agnostic so our recommendations stay free of commission bias, platform dependency, and upsell pressure. We advise leadership, not software.',
    ),
    array(
        'q' => 'Who do you typically work with?',
        'a' => 'Senior leaders, executive teams, boards, and operators across financial services, healthcare, legal, manufacturing, technology, energy, real estate, hospitality, nonprofits, retail, and government contractors. Our work is most valuable to organizations where AI is already being adopted informally and leadership wants structure, governance, and measurable outcomes.',
    ),
    array(
        'q' => 'Do you only serve clients in Texas?',
        'a' => 'No. SRJ Consulting &amp; Services LLC is based in Frisco, Texas and serves clients across the United States. Engagements are conducted through secure video collaboration, structured documentation, and onsite work when the engagement calls for it.',
    ),
    array(
        'q' => 'How is your work different from a typical consulting firm?',
        'a' => 'Most consulting firms staff junior analysts and deliver theoretical frameworks. We are operator-led. Stephen R. Jordan brings 30 years of senior leadership experience at Citi, Intel, McAfee, and Optiv directly to every engagement. You work with the senior operator, not a staffing pyramid.',
    ),
    array(
        'q' => 'What is The AI Operating System&trade;?',
        'a' => 'The AI Operating System&trade; is our proprietary framework for structuring AI adoption across an organization. It addresses executive alignment, governance, risk containment, measurement, and accountability as a single integrated system rather than a series of disconnected projects. Every engagement maps to this framework so your AI adoption is structured, governed, and measurable from day one.',
    ),
    array(
        'q' => 'What is an AI Business Enablement Audit&trade;?',
        'a' => 'A structured assessment of where AI can create real business value in your organization. We examine workflows, decision points, talent capacity, and existing AI usage to identify high-leverage opportunities. The deliverable is a prioritized roadmap tied to financial outcomes, not a list of tools to buy.',
    ),
    array(
        'q' => 'What is an AI Readiness &amp; Performance Assessment&trade;?',
        'a' => 'An evaluation of whether your organization is structurally ready to adopt AI at scale. We assess leadership alignment, data quality, infrastructure readiness, change management capacity, and current performance baselines. The deliverable identifies gaps that would derail adoption and a phased plan to close them.',
    ),
    array(
        'q' => 'What is an AI Risk &amp; Governance Review&trade;?',
        'a' => 'A review of how AI is currently being used in your organization and what governance structures are in place. We examine data exposure, model accountability, regulatory alignment, third-party risk, and executive visibility. The deliverable is a governance framework that fits your organization&rsquo;s risk posture and regulatory environment.',
    ),
    array(
        'q' => 'What is AI Efficiency &amp; Process Optimization&trade;?',
        'a' => 'A targeted engagement to identify and implement AI-driven efficiency gains in core operational processes. We focus on measurable outcomes such as cycle time reduction, error rate improvement, and capacity gains, with safeguards to prevent quality degradation or compliance drift.',
    ),
    array(
        'q' => 'What is an AI IT Security Audit&trade;?',
        'a' => 'A technical and governance assessment of how AI expands your organization&rsquo;s attack surface. We examine identity and access exposure, API and integration risk, model inversion and data leakage paths, and the security posture of AI tools already in use. The deliverable quantifies exposure before it becomes a financial event.',
    ),
    array(
        'q' => 'What is AI IT Security Implementation &amp; Strategy&trade;?',
        'a' => 'The implementation engagement that follows an AI IT Security Audit&trade;. We work alongside your IT and security leadership to harden identity controls, implement governance frameworks, secure AI integrations, and establish executive-level visibility into AI risk.',
    ),
    array(
        'q' => 'How long does an engagement typically take?',
        'a' => 'Engagement length depends on scope. An audit or assessment typically runs four to eight weeks. Implementation engagements run three to six months. We scope each engagement before we begin so timelines and deliverables are clear from the start.',
    ),
    array(
        'q' => 'How much do your services cost?',
        'a' => 'Engagements are scoped and priced individually based on organization size, complexity, and scope. We do not publish standard rates because every engagement is structured for the specific business. Schedule a consultation and we will provide a written scope and fee proposal within a few business days.',
    ),
    array(
        'q' => 'Do you require a long-term contract?',
        'a' => 'No. Engagements are scoped to specific outcomes with clear start and end points. Many clients continue to work with us across multiple engagements, but only because the results justify it.',
    ),
    array(
        'q' => 'How do we get started?',
        'a' => 'Schedule a free 30-minute AI consultation. We will discuss your current state, what is driving the conversation, and whether SRJ Consulting &amp; Services LLC is the right fit. If we are, we will scope an engagement. If we are not, we will tell you that directly and point you toward better options.',
    ),
    array(
        'q' => 'Can you guarantee a return on investment?',
        'a' => 'No. Anyone who guarantees ROI on an advisory engagement is selling you something. What we can commit to is rigorous scoping, measurable deliverables, and honest assessment of whether the work is producing the outcomes you need. If it is not, we say so.',
    ),
    array(
        'q' => 'How do you handle confidentiality?',
        'a' => 'Every engagement begins with a mutual non-disclosure agreement. Engagement materials, findings, and deliverables are handled with the same discipline expected at the board level. Stephen R. Jordan has held senior security and risk roles at Fortune 100 firms and applies the same standards to client work.',
    ),
    array(
        'q' => 'Are AI advisory services a good fit for my organization?',
        'a' => 'If you are asking whether AI is structured correctly in your organization, whether leadership is aligned, whether you are exposed at the infrastructure level, whether adoption is measurable and governed, or whether you are increasing margin or increasing risk, the conversation is worth having. Schedule a consultation and we will tell you honestly whether we can help.',
    ),
);

// Build FAQPage JSON-LD. Valid Schema.org type; retained for structured-data
// hygiene and non-Google consumers. Note: Google retired FAQ rich results for
// most sites in May 2026, so this no longer produces a Google rich snippet.
// Validate with validator.schema.org, not Google's Rich Results Test.
$schema_questions = array();
foreach ( $faqs as $faq ) {
    $schema_questions[] = array(
        '@type' => 'Question',
        'name' => wp_strip_all_tags( html_entity_decode( $faq['q'] ) ),
        'acceptedAnswer' => array(
            '@type' => 'Answer',
            'text' => wp_strip_all_tags( html_entity_decode( $faq['a'] ) ),
        ),
    );
}
$schema = array(
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => $schema_questions,
);
?>

<script type="application/ld+json">
<?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?>
</script>

<?php srj_page_hero( 'Frequently Asked Questions', 'Answers for leaders evaluating AI advisory.' ); ?>

<section class="longform faq-section">
  <div class="container">
    <p class="faq-intro">If your question is not answered here, schedule a free 30-minute consultation and we will discuss your situation directly.</p>

    <div class="faq-list">
      <?php foreach ( $faqs as $i => $faq ) : ?>
        <div class="faq-item">
          <h3 class="faq-q"><?php echo $faq['q']; ?></h3>
          <div class="faq-a">
            <p><?php echo $faq['a']; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php srj_inline_cta( 'Still have questions?', 'Schedule a free 30-minute AI consultation. We will discuss your situation and tell you honestly whether we can help.' ); ?>

<?php srj_final_cta(); ?>

<?php get_footer(); ?>
