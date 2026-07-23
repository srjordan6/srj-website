<?php
/**
 * Template Name: Industry Detail
 *
 * Single-industry detail page for the Industries section. One config-driven
 * template serves every page under /industries/. Page content is keyed by the
 * WordPress page slug in the $SRJ_INDUSTRIES array below; to add or edit an
 * industry, edit that array, no other file changes are needed.
 *
 * Deploy to:  /wp-content/themes/srj-consulting/page-industry-detail.php
 * Assign via: Page Attributes > Template > "Industry Detail", on each
 *             industry page created under the Industries parent.
 */
$GLOBALS['srj_current_nav'] = 'industries';

/* -------------------------------------------------------------------------
 * Service lines, in fixed display order. The six entries in each industry's
 * 'services' array below correspond, in order, to these six service lines.
 * ---------------------------------------------------------------------- */
$SRJ_INDUSTRY_SERVICES = array(
    'AI Business Enablement Audit',
    'AI Readiness & Performance Assessment',
    'AI Risk Governance Review',
    'AI Efficiency & Process Optimization',
    'AI IT Security Audit',
    'AI Security Implementation Strategy',
);

/* -------------------------------------------------------------------------
 * Industry content, keyed by WordPress page slug.
 * ---------------------------------------------------------------------- */
$SRJ_INDUSTRIES = array(

    'aerospace-defense' => array(
        'name'           => 'Aerospace & Defense',
        'subtitle'       => 'Adoption leads. <em>Governance must catch up.</em>',
        'intro'          => 'At roughly 85% adoption, aerospace and defense leads every industry in putting AI to work. That lead is exactly where the risk now lives.',
        'ai_state'       => "Aerospace and defense leads every industry in AI adoption, and that lead is precisely the problem. When roughly 85% of the sector already uses AI in design, sustainment, and autonomy, being a fast follower is no longer a position, it is a liability. Programs are under pressure to fold generative design and autonomous decision support into work that carries human lives, classified data, and decade-long certification cycles. The quieter truth most leaders feel: the technology is moving faster than the governance around it. A single unexamined model in a flight-critical or mission-critical path is not an efficiency story. It is an incident waiting for a hearing.",
        'tools'          => "The sector's AI work clusters into a few categories. Generative and AI-assisted design inside PLM environments such as Siemens NX and Autodesk cuts component weight and shortens iteration cycles. Predictive maintenance models read fleet and sensor data to pull a part before it fails rather than after. Data and decision platforms, with Palantir prominent among them, fuse intelligence and logistics signals into something a commander can act on. And autonomous systems, from Anduril's Lattice to a widening field of unmanned platforms, push machine decision-making toward the edge of the mission. Each delivers real value. Each also introduces a model whose reasoning must one day be explained to an auditor, a certifier, or a review board.",
        'services_intro' => "SRJ exists for the gap between AI adoption and AI discipline, and in aerospace and defense that gap is measured in consequence. Stephen R. Jordan's three decades in security, risk, and operations leadership at firms including Intel, McAfee, and Optiv are the exact background this sector demands. Every SRJ service line addresses a different part of the exposure:",
        'services'       => array(
            "Establishes a clear, program-level account of where AI already sits across design, sustainment, and autonomy, what it costs, and what it returns, so leadership decides from evidence rather than guesswork.",
            "Confirms whether the data, infrastructure, and teams can actually carry AI into flight-critical and mission-critical work, before that weight is placed on them.",
            "Gives program leadership a documented, defensible account of how each model is controlled and explained, the account a certifier or oversight committee will eventually require.",
            "Turns scattered AI pilots into a coordinated operating discipline, so investment compounds across programs instead of fragmenting into one-off experiments.",
            "Examines the data, models, and pipelines that adversaries actively probe, and surfaces the exposure before it becomes an incident and a hearing.",
            "Builds the forward plan to harden AI systems against a capable, motivated threat, so autonomy and decision support can scale without becoming the program's weakest point.",
        ),
    ),

    'technology-software' => array(
        'name'           => 'Technology & Software',
        'subtitle'       => 'First to adopt. <em>First to owe the governance debt.</em>',
        'intro'          => 'Technology firms adopted AI fastest, at roughly 83% of the sector. Speed bought capability, and a governance debt that is now compounding.',
        'ai_state'       => "Technology firms adopted AI first and fastest, and many are now discovering what early speed actually bought them. AI assistants write a large share of new code, engineering teams ship faster, and product roadmaps are crowded with AI features. Underneath the velocity, governance debt is compounding. Models reach production with no owner. Staff route company data through unsanctioned tools because nobody gave them an approved one. Boards ask what the AI spend is returning, and the honest answer is often a shrug. For a sector that sells competence in software, an AI footprint nobody can fully account for is more than an operational gap. It is a credibility risk.",
        'tools'          => "Software organizations run the broadest AI toolset of any industry. AI coding assistants such as GitHub Copilot, Cursor, and Claude Code now sit inside the daily developer workflow. Foundation-model APIs are embedded directly into products as features. Predictive models flag customer churn before it shows up in revenue, and AI-driven security tooling detects and responds to threats faster than human analysts can. The capability is not the constraint. The constraint is that this much AI, adopted this quickly, rarely arrives with the controls, ownership, and measurement that keep it from becoming a liability.",
        'services_intro' => "The technology sector's problem is not access to AI. It is operating discipline. SRJ helps software leaders convert a fast, messy AI footprint into a governed, compounding advantage, and every service line plays a part:",
        'services'       => array(
            "Establishes what the firm actually runs, what it costs, and what it returns, replacing the boardroom shrug with a defensible number.",
            "Measures whether the data foundation and engineering organization can support the AI roadmap being promised to customers and the board.",
            "Assigns ownership, control, and accountability to every model in production, and surfaces the shadow AI before a customer or regulator finds it first.",
            "Turns scattered experimentation into a deliberate operating system, so AI becomes a source of compounding leverage rather than accumulating cost.",
            "Examines the models, APIs, and data pipelines now woven through the product, the same surface attackers study, and identifies the exposure while it is still cheap to fix.",
            "Builds the controls and architecture to secure AI as it scales, so growth in capability does not quietly become growth in attack surface.",
        ),
    ),

    'agriculture' => array(
        'name'           => 'Agriculture',
        'subtitle'       => 'Real gains. <em>Only if you can prove them.</em>',
        'intro'          => 'Roughly 80% of agriculture now uses AI, because on thin margins every point of efficiency matters. The harder question is what it actually returns.',
        'ai_state'       => "Agriculture's AI adoption surprises people, until you remember the margins. When a season turns on weather, input costs, and yield, every point of efficiency matters, and roughly 80% of the sector now uses AI to find those points. Precision farming, crop monitoring, and yield prediction have moved from pilot fields to working operations. Yet the pressure underneath is real. Farm data is scattered across equipment brands, platforms, and spreadsheets that do not talk to each other, and the promised gains stay locked inside that fragmentation. Producers have invested in the technology and still cannot prove what it returned. In an industry with no room for waste, an AI investment you cannot measure is a quiet drain.",
        'tools'          => "The sector's AI runs on three layers. Autonomous and AI-guided equipment, from John Deere's See & Spray to a growing field of farming robots, applies inputs plant by plant and cuts chemical use sharply. Crop intelligence platforms such as Climate FieldView and Ecorobotix turn imagery and sensor data into decisions about irrigation, disease, and timing. And predictive analytics models forecast yields, pest outbreaks, and weather risk so producers can act early rather than react late. The tools are capable and proven. The recurring gap is integration, getting them to function as one system rather than a dozen disconnected ones.",
        'services_intro' => "SRJ helps agricultural operations turn AI from scattered spend into measurable return, on margins that leave no room for waste. Each service line addresses a different part of that work:",
        'services'       => array(
            "Maps every tool, platform, and data source already in use, and shows plainly where value is being created and where it is leaking away in fragmentation.",
            "Measures whether the operation's data foundation can actually support the decisions being asked of it, before more weight is placed on precision technology.",
            "Establishes clear control and accountability over the autonomous and predictive systems now making operational calls, so a drifted model does not quietly cost a season.",
            "Connects fragmented precision tools into a single operating discipline, so the technology delivers the yield and cost gains it always promised.",
            "Examines the connected equipment, sensors, and farm data that AI now depends on, and identifies exposure before it disrupts operations.",
            "Builds a practical plan to protect operational data and connected autonomous equipment, so growth in automation does not open the operation to new risk.",
        ),
    ),

    'healthcare-life-sciences' => array(
        'name'           => 'Healthcare & Life Sciences',
        'subtitle'       => 'Adopted broadly. <em>Matured almost nowhere.</em>',
        'intro'          => 'Around 78% of healthcare organizations use AI, yet only about 1% call it fully mature. The result is a sector full of pilots that never reach the floor.',
        'ai_state'       => "Healthcare has adopted AI broadly and matured it almost nowhere. Roughly 78% of organizations use it, yet only about 1% describe their AI as fully mature. The result is a sector full of pilots that never reach the floor, and clinicians who were promised relief still losing two to three hours a day to documentation. Beneath the optimism sits a rational fear: a diagnostic model that drifts, a patient-data exposure, an automation that fails quietly inside a legacy electronic health record. In an industry where the cost of being wrong is measured in patient harm and regulatory action, that fear is the reason so much healthcare AI stays frozen in the pilot phase.",
        'tools'          => "Healthcare AI concentrates in three areas. Ambient clinical documentation tools, including Nuance DAX, Abridge, Nabla, and Suki, listen during the visit and draft the note, giving clinicians their evenings back. Diagnostic AI such as PathAI in pathology and Viz.ai in stroke detection reaches specialist-level accuracy on narrow, time-critical tasks. And administrative AI automates medical coding, billing, and the data handoffs between the ten to fifteen disconnected systems a typical organization runs. Each tool addresses a genuine burden. Each also touches protected patient data and clinical decisions, which is exactly why adoption without governance stalls.",
        'services_intro' => "The barrier in healthcare is rarely the technology. It is trust, integration, and proof of control, the things that move AI from a stalled pilot to standard practice. Every SRJ service line addresses part of that barrier:",
        'services'       => array(
            "Establishes a clear account of where AI already sits across clinical, administrative, and operational workflows, what it costs, and what it returns.",
            "Confirms whether the data and often-legacy systems can carry the AI being asked of them, the gap that strands so many healthcare pilots.",
            "Gives clinical and compliance leadership a documented account of how each model is monitored, when a human stays in the loop, and how drift is caught.",
            "Turns disconnected point tools into a coherent operating discipline, so AI relieves clinician burden instead of adding another system to manage.",
            "Examines the protected health information and clinical models that make healthcare a permanent target, and surfaces exposure before it becomes a breach.",
            "Builds the forward plan to secure patient data and AI systems as adoption scales, so growth never arrives as a reportable incident.",
        ),
    ),

    'media-telecom' => array(
        'name'           => 'Media & Telecom',
        'subtitle'       => 'Built on AI. <em>Governed by very little.</em>',
        'intro'          => 'Media and telecom run on AI across content, network, and customer operations. In the rush, it gets bolted on faster than it is governed.',
        'ai_state'       => "Media and telecommunications companies sit on enormous data and real-time demands, and AI has become central to both. Recommendation engines drive engagement, generative tools accelerate content production, and machine learning predicts and prevents network outages before subscribers notice. The pressure is the pace. Audiences expect personalization that borders on prescience, networks must self-optimize against relentless load, and content has to be produced faster and cheaper every quarter. In the rush, AI gets bolted on rather than built in. The exposure is real and growing: generative content raises questions of accuracy, rights, and brand integrity, and a recommendation system optimized only for engagement can erode the trust it was meant to deepen.",
        'tools'          => "The sector's AI splits along its two halves. On the media side, recommendation and personalization engines decide what each viewer sees next, while generative tools such as Runway and Synthesia compress production timelines for video and creative work. On the telecom side, network-optimization AI predicts congestion and failures, automating fixes before outages occur, and AI-driven ad targeting sharpens audience segmentation. Customer service across both is increasingly handled by AI agents that resolve routine contact at scale. The capability is mature. What is often missing is a governing view of where AI touches the customer, the content, and the brand.",
        'services_intro' => "SRJ helps media and telecom leaders run AI as a deliberate operating function rather than a collection of fast bolt-ons. Each service line strengthens a different part of that system:",
        'services'       => array(
            "Establishes a clear, current picture of where AI sits across content, network, and customer operations, and what each deployment actually returns.",
            "Measures whether the data and infrastructure can support the personalization and network demands being placed on them.",
            "Addresses the exposures unique to this sector, content accuracy, rights, and the brand-trust cost of optimizing for the wrong signal.",
            "Turns scattered automation into a coherent system that compounds, instead of one that simply accumulates tools and cost.",
            "Examines the data, models, and customer-facing systems AI now runs through, and identifies exposure before it reaches the subscriber.",
            "Builds the controls to protect customer data and content pipelines as AI scales, so audience trust is strengthened rather than spent down.",
        ),
    ),

    'manufacturing' => array(
        'name'           => 'Manufacturing',
        'subtitle'       => 'Clear efficiency. <em>Real exposure.</em>',
        'intro'          => 'Manufacturing has one of the clearest AI cases of any sector. The catch is that much of that AI now runs on connected systems never built to be attacked.',
        'ai_state'       => "Manufacturing has a clearer AI case than almost any sector, and that clarity is its own trap. Predictive maintenance, computer-vision quality control, and demand forecasting deliver measurable gains, so plants adopt fast. The pressure builds where the factory floor meets the network. AI now reads sensor data and makes decisions on operational technology that was never designed to be connected, never designed to be attacked, and is expensive to take offline. Leaders feel the squeeze from both sides: stand still and competitors out-produce you, move carelessly and a single intrusion or a drifted model halts a line. The cost of unplanned downtime is immediate and unforgiving.",
        'tools'          => "Manufacturing AI concentrates on the plant floor. Predictive maintenance platforms such as Augury analyze equipment vibration and sensor data to schedule repairs before failures occur. Computer-vision systems, with Cognex among the established names, inspect products faster and more consistently than human inspectors. Digital twins, often built in Siemens environments, simulate production lines so changes can be tested before they touch real output. Demand-forecasting models tune inventory against actual signal rather than guesswork. The productivity gains are real, frequently in the range of 15 to 30%. The exposure is equally real, because much of this AI now runs on connected operational technology.",
        'services_intro' => "Manufacturing's AI question is twofold: capture the efficiency, and do not open the plant to the risk that comes with it. SRJ's service lines address both sides:",
        'services'       => array(
            "Gives leadership a grounded view of what the plant's AI actually returns across maintenance, quality, and the supply chain.",
            "Confirms whether the data and systems can support the AI being placed on the floor, before a failure stops a line.",
            "Establishes documented control over the models now making operational decisions, so a drifted system is caught before it halts production.",
            "Sharpens where AI is applied across the operation, so investment lands where it pays rather than where it merely looks modern.",
            "Examines the connected operational technology that predictive and vision systems depend on, the systems an attacker would target to stop a line.",
            "Builds the plan to secure AI-connected operational technology and plant data, so the pursuit of efficiency never becomes the source of the next shutdown.",
        ),
    ),

    'retail-ecommerce' => array(
        'name'           => 'Retail & E-Commerce',
        'subtitle'       => 'The customer relationship. <em>Now mediated by AI.</em>',
        'intro'          => 'Retail adopted AI across the customer journey, and agentic commerce is now reshaping who owns that relationship, and the data behind it.',
        'ai_state'       => "Retail adopted AI across the entire customer journey, and the ground is now shifting under it again. Personalization, demand forecasting, and dynamic pricing are established practice. The harder change is agentic commerce: AI agents that search, compare, and buy on the shopper's behalf, with AI platforms projected to drive a fast-growing share of online sales. For retail leaders, the anxiety is structural. The customer relationship, the data, and the storefront are all being mediated by AI systems the retailer does not own. Move too slowly and you become invisible to the agent doing the shopping. Move without discipline and you hand margin, pricing, and brand voice to a model with no loyalty to you.",
        'tools'          => "Retail AI spans front end and back. Recommendation and personalization engines, with platforms such as Voyado and Dynamic Yield among them, shape what each shopper sees and lift average order value. Demand-forecasting and inventory tools, Blue Yonder a familiar name, cut both stockouts and overstock. Dynamic pricing models adjust in real time against competitive and demand signal. And a new agentic layer, from OpenAI's Instant Checkout to Amazon's autonomous buying features, is reshaping discovery itself. The tooling is abundant. The strategic question, who controls the customer relationship as AI mediates it, is unresolved.",
        'services_intro' => "SRJ helps retail leaders meet the agentic shift with a plan rather than a scramble. Every service line addresses a part of holding the customer relationship as AI mediates it:",
        'services'       => array(
            "Establishes where AI sits across the customer journey today, what it costs, and what it returns, the baseline for any serious move.",
            "Measures whether the data and systems can support the personalization and agentic-commerce demands now reshaping the storefront.",
            "Addresses what agentic commerce puts at stake, pricing control, margin, customer data, and brand voice, with documented accountability.",
            "Turns a stack of point tools into a coherent operating system across personalization, inventory, and pricing.",
            "Examines the customer data and AI systems at the center of the retail relationship, and surfaces exposure before it costs trust.",
            "Builds the controls to protect customer data and commerce systems as AI scales, so growth into the agentic marketplace stays on the retailer's terms.",
        ),
    ),

    'insurance' => array(
        'name'           => 'Insurance',
        'subtitle'       => 'A natural fit. <em>Governance-first, or not at all.</em>',
        'intro'          => 'Insurance is a natural home for AI, and 2026 has drawn a sharp line between carriers deploying it with discipline and those rushing black-box models to market.',
        'ai_state'       => "Insurance is a natural home for AI, an industry built on risk assessment and document-heavy processing, and roughly 73% of the sector now uses it. Claims cycle faster, underwriting is more precise, and fraud is caught earlier. But 2026 has drawn a sharp line between insurers deploying AI thoughtfully and those rushing black-box models to market. That line matters, because an underwriting or claims model that cannot explain its decisions is not a competitive edge. It is a regulatory finding in waiting, and a reputational exposure the moment a denied claim becomes a headline. The leaders who feel this pressure most acutely are the ones who adopted fastest.",
        'tools'          => "Insurance AI concentrates in its core workflows. Claims-automation tools, including computer-vision platforms such as Tractable, assess damage and process routine claims at a fraction of the traditional cost. Underwriting AI prices risk against far more signal than a human can weigh. Fraud-detection models flag suspicious patterns before payment leaves the building. AI agents and voice systems increasingly handle policy inquiries and guide customers through claims. The efficiency is well documented, with routine claims costs falling 30 to 40% in fully automated operations. The unresolved question is governance, whether each model's decisions can be explained, audited, and defended.",
        'services_intro' => "In insurance, the right sequence is governance first, not an AI tool first and compliance afterward. SRJ's service lines support every part of that discipline:",
        'services'       => array(
            "Clarifies what the carrier's AI actually returns across claims, underwriting, and service, replacing assumption with evidence.",
            "Confirms the data foundation is sound before more weight is placed on automated claims and underwriting decisions.",
            "Gives leadership a documented, defensible account of how each model reaches its decisions and stays controlled, the account a regulator or a court will ask to see.",
            "Turns scattered automation into a coherent operating discipline, so efficiency gains hold up across the business rather than in isolated workflows.",
            "Examines the policyholder data and models that make a carrier a target, and identifies exposure before it becomes a breach or a finding.",
            "Builds the forward plan to secure customer data and AI systems as adoption scales, so growth never arrives as regulatory exposure in disguise.",
        ),
    ),

    'financial-services' => array(
        'name'           => 'Financial Services & Banking',
        'subtitle'       => 'Heavy investment. <em>Sharpening scrutiny.</em>',
        'intro'          => 'Financial services leads in AI investment. Every model that touches money also sits inside a regulatory frame that is sharpening its focus on AI.',
        'ai_state'       => "Financial services leads in AI investment, with a data-rich environment and clear returns making it a natural adopter. Fraud detection, algorithmic trading, credit scoring, and customer service are all reshaped by it. The weight on leaders here is regulatory and existential at once. Every model that touches a lending decision, a trade, or a customer's money sits inside a supervisory framework that is itself sharpening its focus on AI. A model that discriminates, drifts, or cannot be explained is not a technical defect. It is an enforcement action, a headline, and a hit to the one asset a financial institution cannot rebuild quickly: trust.",
        'tools'          => "The sector's AI runs through its highest-stakes functions. Fraud-detection systems monitor transactions in real time and stop suspicious activity before losses land. Algorithmic trading models, now used by a majority of hedge funds, read markets for patterns invisible to human analysts. Machine-learning credit models assess risk against far more signal than traditional scoring. AI assistants handle routine customer service and route the complex cases to people. The capability is mature and the spend is heavy. The recurring exposure is model risk, the chance that a system making consequential financial decisions cannot be explained, audited, or defended when it matters.",
        'services_intro' => "SRJ helps financial institutions run AI with the discipline their regulators, and their customers, already expect. Stephen R. Jordan's three decades in security and risk leadership, including years at Citi, are the foundation of this work. Each service line addresses a part of it:",
        'services'       => array(
            "Establishes what the institution's AI actually returns across fraud, lending, trading, and service, replacing assumption with a defensible number.",
            "Confirms whether the data and systems can support the AI being placed on consequential financial decisions.",
            "Establishes documented control over every model touching lending, trading, fraud, and customer money, with clear ownership and a full explainability trail.",
            "Turns scattered AI investment into a coherent operating discipline, so capability compounds rather than fragments across the institution.",
            "Examines the data and models at the center of a sector that is a permanent target, and surfaces exposure before an adversary does.",
            "Builds the plan to harden AI systems and customer data as adoption scales, protecting the trust that took generations to build.",
        ),
    ),

    'legal-services' => array(
        'name'           => 'Legal Services',
        'subtitle'       => 'Cautious for good reason. <em>Disciplined by necessity.</em>',
        'intro'          => 'Legal services adopted AI more cautiously than most, and the caution was earned. One unchecked output can become a malpractice exposure, and a public one.',
        'ai_state'       => "Legal services adopted AI more cautiously than most, and the caution was warranted. The work is document-intensive and ideal for automation, yet the profession has watched AI-related sanctioning orders make clear what a fabricated citation or an unchecked output can cost. In 2026 the market is consolidating around proven, well-integrated tools, and clients are raising their own expectations of how firms use AI. Procurement has effectively become the regulator: requests for proposal now demand proof of data boundaries, governance, and reviewable audit trails. For firm leadership, the pressure is unforgiving. Move too slowly and clients leave for faster firms. Move carelessly and a single AI error becomes a malpractice exposure and a public one.",
        'tools'          => "Legal AI concentrates on the document-heavy core of the work. Research and drafting platforms such as Harvey, CoCounsel, and Lexis+ AI find relevant authority and produce first drafts in a fraction of the manual time. Contract-analysis tools, Spellbook among them, flag risk and non-standard terms. E-discovery AI reviews vast document sets far faster than associates can. The tools that survived the market's recent flight to quality share two traits: they integrate cleanly into existing systems, often inside Word and Outlook, and they offer firm-specific controls. Generic, ungoverned tools are increasingly blocked, not adopted.",
        'services_intro' => "In legal services, AI without governance is not efficiency. It is liability. SRJ helps firms grow with AI on a foundation of demonstrable discipline, and every service line contributes:",
        'services'       => array(
            "Establishes what the firm's AI actually returns and where it should expand next, replacing impression with evidence.",
            "Confirms whether the firm's data and systems can support the AI being relied on in client-facing work.",
            "Gives firm leadership documented control over how AI is used, where data boundaries sit, and how outputs are verified, exactly what clients and their procurement teams now demand.",
            "Turns scattered tool adoption into a coherent operating discipline, so AI accelerates the work without multiplying the risk.",
            "Examines the privileged and confidential information AI systems now touch, and surfaces exposure before it threatens the client relationship.",
            "Builds the controls to protect client data and AI systems as adoption scales, so growth strengthens the firm's name rather than risking it.",
        ),
    ),

);

/* -------------------------------------------------------------------------
 * Resolve the current page to its industry config by slug.
 * ---------------------------------------------------------------------- */
$srj_slug    = '';
$srj_queried = get_queried_object();
if ( $srj_queried instanceof WP_Post ) {
    $srj_slug = $srj_queried->post_name;
}
$ind = isset( $SRJ_INDUSTRIES[ $srj_slug ] ) ? $SRJ_INDUSTRIES[ $srj_slug ] : null;

get_header();

if ( $ind ) :

    srj_page_hero( $ind['name'], $ind['subtitle'], $ind['intro'] );
    ?>

    <section class="services-landing industry-detail" style="padding-top:50px">
      <div class="container">

        <div class="industry-section">
          <h2>The Current State of AI in <?php echo esc_html( $ind['name'] ); ?></h2>
          <?php echo wpautop( wp_kses_post( $ind['ai_state'] ) ); ?>
        </div>

        <div class="industry-section">
          <h2>The Tools in Use Today</h2>
          <?php echo wpautop( wp_kses_post( $ind['tools'] ) ); ?>
        </div>

        <div class="industry-section">
          <h2>How SRJ Consulting &amp; Services Helps</h2>
          <?php echo wpautop( wp_kses_post( $ind['services_intro'] ) ); ?>
          <ul class="industry-service-list">
            <?php foreach ( $SRJ_INDUSTRY_SERVICES as $srj_i => $srj_service_name ) : ?>
              <li>
                <strong><?php echo esc_html( $srj_service_name ); ?>:</strong>
                <?php
                $srj_desc = isset( $ind['services'][ $srj_i ] ) ? $ind['services'][ $srj_i ] : '';
                echo ' ' . wp_kses_post( $srj_desc );
                ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

      </div>
    </section>

    <?php
    srj_inline_cta( 'Putting AI to work is the easy part. <em>Putting discipline behind it is ours.</em>' );
    srj_final_cta();

else :

    srj_page_hero(
        get_the_title(),
        'Industry overview',
        'Detailed content for this industry is being prepared.'
    );
    srj_final_cta();

endif;

get_footer();
