<?php
/**
 * SRJ AI Governance config, AI Tools entry (v1.70, July 20 2026).
 *
 * Holds the single 'ai-tools' entry: the 317-tool reference catalog.
 * Kept in its own file rather than spliced into the 990KB main config so
 * the block stays byte-identical to the verified original, and so the
 * main config is never rewritten to add it.
 *
 * The two HTML comment markers SRJ_TOOLS_CATALOG_START / _END delimit the
 * catalog region. The SRJ AI Tools Inventory mu-plugin replaces that region
 * with output rendered from wp_srj_ai_tools when the table has rows, and
 * leaves the static list in place when it does not.
 *
 * Required from the bottom of ai-governance-config.php, so it runs in the
 * same scope and appends to the existing $SRJ_GOVERNANCE array.
 * Both files must be deployed together.
 *
 * Retired by Phase 2, when the library moves to a custom post type.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! isset( $SRJ_GOVERNANCE ) || ! is_array( $SRJ_GOVERNANCE ) ) { $SRJ_GOVERNANCE = array(); }

// =======================================================================
// AI TOOLS — CATEGORY (v1.69, July 19 2026)
// Reference catalog of 317 AI tools across 23 categories, generated
// from SRJ_AI_Tool_Inventory_Tracker.csv. Top-level category page.
// =======================================================================
$SRJ_GOVERNANCE['ai-tools'] = array(
    'title'            => 'AI Tools',
    'subtitle'         => 'The Reference Catalog Behind an AI Tool Inventory',
    'short'            => 'A working catalog of 317 AI tools across 23 categories, each with what it does and the governance flag it raises.',
    'parent'           => null,
    'children'         => array(),
    'focus_keyword'    => 'AI tool inventory',
    'seo_title'        => 'AI Tool Inventory: 317 AI Tools by Category | SRJ',
    'meta_description' => 'A reference catalog of 317 AI tools across 23 categories with vendor, jurisdiction, and the governance flag each raises. The first artifact of AI governance.',
    'body_html'        => <<<'SRJBODY'
<nav class="srjgov-toc" aria-label="On this page">
  <p class="srjgov-toc-label">On this page</p>
  <ul>
    <li><a href="#the-pain-an-ai-tool-inventory-is-solving">The pain an AI tool inventory is solving</a></li>
    <li><a href="#how-to-use-this-catalog">How to use this catalog</a></li>
    <li><a href="#ai-governance-and-risk-management-platforms">AI Governance &amp; Risk Management Platforms</a></li>
    <li><a href="#automation-and-agents">Automation &amp; Agents</a></li>
    <li><a href="#chat-and-general-llms">Chat &amp; General LLMs</a></li>
    <li><a href="#chinese-foundation-models">Chinese Foundation Models</a></li>
    <li><a href="#cloud-ai-services-and-model-apis">Cloud AI Services &amp; Model APIs</a></li>
    <li><a href="#coding-and-developer-tools">Coding &amp; Developer Tools</a></li>
    <li><a href="#data-and-analytics-ai">Data &amp; Analytics AI</a></li>
    <li><a href="#erp-and-business-application-ai">ERP &amp; Business Application AI</a></li>
    <li><a href="#education-and-research-ai">Education &amp; Research AI</a></li>
    <li><a href="#emerging-frontier-ai">Emerging / Frontier AI</a></li>
    <li><a href="#enterprise-ai-platforms-and-agent-orchestration">Enterprise AI Platforms &amp; Agent Orchestration</a></li>
    <li><a href="#finance-and-legal-ai">Finance &amp; Legal AI</a></li>
    <li><a href="#hr-and-talent-ai">HR &amp; Talent AI</a></li>
    <li><a href="#healthcare-and-life-sciences-ai">Healthcare &amp; Life Sciences AI</a></li>
    <li><a href="#image-and-graphic-design">Image &amp; Graphic Design</a></li>
    <li><a href="#notes-knowledge-and-meetings">Notes, Knowledge &amp; Meetings</a></li>
    <li><a href="#open-source-and-self-hosted-models">Open Source &amp; Self-Hosted Models</a></li>
    <li><a href="#search-research-translation-and-other">Search, Research, Translation &amp; Other</a></li>
    <li><a href="#security-and-identity-ai">Security &amp; Identity AI</a></li>
    <li><a href="#slides-and-presentations">Slides &amp; Presentations</a></li>
    <li><a href="#video-generation-and-editing">Video Generation &amp; Editing</a></li>
    <li><a href="#voice-and-audio">Voice &amp; Audio</a></li>
    <li><a href="#writing-and-editing">Writing &amp; Editing</a></li>
  </ul>
</nav>

<div class="srjgov-tldr">
  <p class="srjgov-tldr-label">The one-paragraph answer</p>
  <p>An <strong>AI tool inventory</strong> is the first artifact of AI governance: a written record of every AI tool and embedded AI feature the business touches, who makes it, where the vendor sits, and what governance question each one raises. This page is a working reference catalog of <strong>317 AI tools across 23 categories</strong>, each with a short note on what it does and the governance issue it carries, from recording consent to source-code exposure to cross-border data review. If a tool is in your business and not on your inventory, it is ungoverned.</p>
</div>

<h2 id="the-pain-an-ai-tool-inventory-is-solving">The pain an <strong>AI tool inventory</strong> is solving</h2>

<p>Most executives can name five AI tools their company uses. Most companies are running forty or more, because AI no longer arrives as a purchase decision. It arrives as a feature switched on inside software already deployed: the meeting recorder that started summarizing, the CRM that started drafting, the design tool that started generating. Nobody approved these as AI. Nobody inventoried them. That gap between the tools leadership can name and the tools actually running is shadow AI, and it is where the governance failures live: the transcript nobody consented to, the source code pasted into a public model, the customer data flowing through a vendor no one vetted.</p>

<p>Every governance framework worth aligning to, from <a href="/ai-governance/iso-42001/">ISO/IEC 42001</a> to the NIST AI RMF, starts from the same prerequisite: you cannot govern what you have not listed. The inventory comes first. This catalog exists to make that first step faster, it is the reference list we work from when building an <a href="/services/business-services/ai-business-enablement-audit/">AI tool inventory for a client</a>, and the discipline behind it is the subject of <a href="/books/ai-business-services/the-ai-business-enablement-audit/">Volume I of The Operating Discipline for AI Library</a>.</p>

<h2 id="how-to-use-this-catalog">How to use this catalog</h2>

<p>Tools are grouped by category and listed with vendor, vendor headquarters, and a short note on what the tool does plus the governance flag it most often raises. Vendor headquarters is listed because jurisdiction is a governance fact: it determines which data-transfer, privacy, and cross-border rules apply. Notes reading &ldquo;cross-border data review advised&rdquo; mark tools from vendors whose home jurisdiction warrants a data-flow review before business data touches them. This is a reference catalog, not an endorsement list; presence here means a tool is common enough in the field that it belongs on an inventory checklist, nothing more.</p>

<!--SRJ_TOOLS_CATALOG_START-->
<h2 id="ai-governance-and-risk-management-platforms">AI Governance &amp; Risk Management Platforms</h2>
<ul>
  <li><strong>Arize AI</strong> (Arize AI, US) &mdash; ML observability; LLM tracing; evaluation framework; prompt monitoring.</li>
  <li><strong>Arthur AI</strong> (Arthur AI, US) &mdash; Model monitoring and governance; bias mitigation; fairness metrics; compliance reporting.</li>
  <li><strong>Credo AI</strong> (Credo AI, US) &mdash; Purpose-built AI governance; policy packs for EU AI Act, NIST AI RMF; clean interface; fast deployment.</li>
  <li><strong>Fiddler AI</strong> (Fiddler, US) &mdash; Model performance management; explainability; bias detection; drift monitoring; LLM observability.</li>
  <li><strong>Holistic AI</strong> (Holistic AI, UK) &mdash; Bias auditing, risk management, compliance; strong technical depth; mid-market focus.</li>
  <li><strong>IBM OpenPages with Watson</strong> (IBM, US) &mdash; Full GRC platform with AI-specific modules; risk assessment; regulatory mapping; Watson AI automated documentation.</li>
  <li><strong>Monitaur</strong> (Monitaur, US) &mdash; Model monitoring with built-in governance; unified monitoring + governance platform.</li>
  <li><strong>OneTrust AI Governance</strong> (OneTrust, US) &mdash; Privacy-first approach; strong data governance; compliance automation; good for privacy-primary orgs.</li>
  <li><strong>ServiceNow AI Governance</strong> (ServiceNow, US) &mdash; Built into Now Platform; model inventory; risk scoring; approval workflows; best for existing ServiceNow shops.</li>
  <li><strong>WhyLabs</strong> (WhyLabs, US) &mdash; Data-centric AI observability; statistical profiling; privacy-preserving monitoring.</li>
</ul>

<h2 id="automation-and-agents">Automation &amp; Agents</h2>
<ul>
  <li><strong>Apify</strong> (Apify, Czech Republic) &mdash; Web scraping platform; actor marketplace; automation; EU-hosted; GDPR.</li>
  <li><strong>Automation Anywhere</strong> (Automation Anywhere, US) &mdash; Intelligent automation platform; AI-powered bots; control room governance; credential vault.</li>
  <li><strong>Bardeen</strong> (Bardeen, US) &mdash; Browser automation AI; web scraping; personal productivity; data exposure risk.</li>
  <li><strong>Blue Prism</strong> (SS&amp;C Blue Prism, UK) &mdash; Enterprise RPA; digital workforce; centralized control; UK-hosted; GDPR relevant.</li>
  <li><strong>Browse AI</strong> (Browse AI, Canada) &mdash; Web scraping automation; data extraction; monitoring; terms-of-service compliance risk.</li>
  <li><strong>Make (Integromat) AI</strong> (Make, Czech Republic) &mdash; Visual automation platform; AI integrations; EU-hosted options; GDPR workflow compliance.</li>
  <li><strong>Manus</strong> (Manus AI, Singapore) &mdash; Autonomous agent; high decision-influence.</li>
  <li><strong>Microsoft Power Automate AI</strong> (Microsoft, US) &mdash; Enterprise workflow automation; Copilot integration; M365 data access; DLP integration.</li>
  <li><strong>n8n</strong> (n8n, Germany) &mdash; Workflow automation; agentic actions.</li>
  <li><strong>UiPath AI</strong> (UiPath, US) &mdash; RPA + AI platform; document understanding; process mining; enterprise automation governance.</li>
  <li><strong>Zapier AI</strong> (Zapier, US) &mdash; Workflow automation with AI; 7000+ app integrations; data flow governance; cross-app exposure.</li>
  <li><strong>Zapier Central</strong> (Zapier, US) &mdash; Workflow automation; agentic actions.</li>
</ul>

<h2 id="chat-and-general-llms">Chat &amp; General LLMs</h2>
<ul>
  <li><strong>01.AI Yi</strong> (01.AI, China) &mdash; Chinese open-source LLM; Kai-Fu Lee founded; cross-border data review advised.</li>
  <li><strong>AI2 OLMo</strong> (Allen Institute for AI, US) &mdash; Open-source language model; fully open training data; research transparency; nonprofit.</li>
  <li><strong>Aleph Alpha</strong> (Aleph Alpha, Germany) &mdash; European sovereign LLM; EU-hosted; GDPR-first; multilingual; Luminous model family.</li>
  <li><strong>Apple Intelligence</strong> (Apple, US) &mdash; On-device LLM; Private Cloud Compute; Apple silicon; minimal data exposure; privacy-first.</li>
  <li><strong>Baichuan</strong> (Baichuan AI, China) &mdash; Chinese open-source LLM; medical and legal fine-tunes; cross-border data review advised.</li>
  <li><strong>Cerebras</strong> (Cerebras, US) &mdash; Wafer-scale AI compute; inference API; on-prem options; high-performance computing.</li>
  <li><strong>Character.ai</strong> (Character.AI, US) &mdash; Persona chat; HR/appropriate-use risk.</li>
  <li><strong>ChatGPT</strong> (OpenAI, US) &mdash; General LLM assistant.</li>
  <li><strong>Claude</strong> (Anthropic, US) &mdash; General LLM assistant.</li>
  <li><strong>Cohere Coral</strong> (Cohere, Canada) &mdash; Enterprise chat AI; RAG-native; data privacy focus; Canadian vendor.</li>
  <li><strong>Databricks DBRX</strong> (Databricks, US) &mdash; Open-source general LLM; Mixture-of-Experts; enterprise training; already noted in Data &amp; Analytics.</li>
  <li><strong>DeepSeek</strong> (DeepSeek AI, China) &mdash; Open-weight MoE; cross-border data review advised.</li>
  <li><strong>Falcon (TII)</strong> (Technology Innovation Institute, UAE) &mdash; UAE-hosted open-source LLM; sovereign AI; Apache 2.0; Middle East data residency.</li>
  <li><strong>Fireworks AI</strong> (Fireworks AI, US) &mdash; Fast inference API; open-source models; enterprise deployment; cost optimization.</li>
  <li><strong>Gemini</strong> (Google, US) &mdash; General LLM assistant.</li>
  <li><strong>Grok</strong> (xAI, US) &mdash; General LLM assistant.</li>
  <li><strong>Huawei PanGu</strong> (Huawei, China) &mdash; Chinese foundation model; cross-border data review advised; Ascend chip optimization.</li>
  <li><strong>HyperWrite</strong> (HyperWrite, US) &mdash; Writing assistant + agent.</li>
  <li><strong>iFlytek Spark</strong> (iFlytek, China) &mdash; Chinese voice+language AI; speech recognition; cross-border data review advised.</li>
  <li><strong>InternLM (Shanghai AI Lab)</strong> (Shanghai AI Laboratory, China) &mdash; Chinese open-source LLM; academic research; cross-border data review advised.</li>
  <li><strong>JAIS (G42 / Inception)</strong> (G42 / Inception, UAE) &mdash; Arabic-centric LLM; UAE sovereign AI; cultural alignment; Middle East data governance.</li>
  <li><strong>Janitor AI</strong> (Janitor AI, US) &mdash; Persona chat; HR/appropriate-use risk.</li>
  <li><strong>Kimi</strong> (Moonshot AI, China) &mdash; Long-context reasoning; cross-border data review advised.</li>
  <li><strong>Llama (Meta)</strong> (Meta, US) &mdash; Open-weight model family; often self-hosted.</li>
  <li><strong>LMSYS Arena Models</strong> (LMSYS, US) &mdash; Model evaluation platform; crowdsourced benchmarking; research transparency; no production use.</li>
  <li><strong>Microsoft Copilot</strong> (Microsoft, US) &mdash; Embedded across M365.</li>
  <li><strong>Mistral / Le Chat</strong> (Mistral AI, France) &mdash; EU-hosted option; GDPR relevant.</li>
  <li><strong>Notion AI</strong> (Notion Labs, US) &mdash; Embedded in workspace/knowledge base.</li>
  <li><strong>NVIDIA Nemotron</strong> (NVIDIA, US) &mdash; Enterprise LLM family; synthetic data generation; GPU-optimized; self-hosted options.</li>
  <li><strong>Perplexity AI</strong> (Perplexity, US) &mdash; Search-augmented LLM.</li>
  <li><strong>Pi</strong> (Inflection AI, US) &mdash; Conversational assistant.</li>
  <li><strong>Poe</strong> (Quora, US) &mdash; Multi-model aggregator.</li>
  <li><strong>Replicate</strong> (Replicate, US) &mdash; Model hosting and inference API; open-source models; community models; content policy.</li>
  <li><strong>SambaNova</strong> (SambaNova Systems, US) &mdash; Enterprise AI hardware+software; DataScale platform; on-prem deployment; sovereign AI.</li>
  <li><strong>Samsung Gauss</strong> (Samsung, South Korea) &mdash; On-device LLM; Galaxy AI; personal data processing; Korean vendor; local processing.</li>
  <li><strong>SaulLM (Saul)</strong> (Saul, France) &mdash; French legal-domain LLM; specialized training; EU data governance.</li>
  <li><strong>SenseTime SenseChat</strong> (SenseTime, China) &mdash; Chinese multimodal LLM; computer vision integration; cross-border data review advised.</li>
  <li><strong>Slack AI</strong> (Salesforce, US) &mdash; Embedded in messaging; message-corpus exposure.</li>
  <li><strong>Snowflake Arctic</strong> (Snowflake, US) &mdash; Enterprise-focused LLM; Apache 2.0 license; data cloud integration; commercial use.</li>
  <li><strong>Together AI</strong> (Together AI, US) &mdash; Decentralized cloud for open models; inference API; model hub; data residency options.</li>
  <li><strong>You.com</strong> (You.com, US) &mdash; Search-augmented LLM.</li>
  <li><strong>Zoom AI Companion</strong> (Zoom, US) &mdash; Meeting summarization; recording consent relevant.</li>
</ul>

<h2 id="chinese-foundation-models">Chinese Foundation Models</h2>
<ul>
  <li><strong>Doubao / Seed (ByteDance)</strong> (ByteDance, China) &mdash; Cross-border data review advised.</li>
  <li><strong>ERNIE (Baidu)</strong> (Baidu, China) &mdash; Cross-border data review advised.</li>
  <li><strong>GLM / Z.AI (Zhipu AI)</strong> (Zhipu AI, China) &mdash; Cross-border data review advised.</li>
  <li><strong>Hunyuan (Tencent)</strong> (Tencent, China) &mdash; Cross-border data review advised.</li>
  <li><strong>MiMo (Xiaomi)</strong> (Xiaomi, China) &mdash; Cross-border data review advised.</li>
  <li><strong>MiniMax</strong> (MiniMax, China) &mdash; Cross-border data review advised.</li>
  <li><strong>Qwen / Tongyi Qianwen (Alibaba)</strong> (Alibaba Cloud, China) &mdash; Cross-border data review advised.</li>
</ul>

<h2 id="cloud-ai-services-and-model-apis">Cloud AI Services &amp; Model APIs</h2>
<ul>
  <li><strong>AI21 Labs API</strong> (AI21 Labs, Israel) &mdash; Jurassic models; enterprise API; data retention controls; compliance-focused.</li>
  <li><strong>Amazon SageMaker</strong> (Amazon Web Services, US) &mdash; Full ML lifecycle management; model monitoring; bias detection; explainability tools.</li>
  <li><strong>AWS Bedrock</strong> (Amazon Web Services, US) &mdash; Managed foundation model API service; IAM integration; VPC support; model evaluation tools; AgentCore for agent orchestration.</li>
  <li><strong>Azure Machine Learning</strong> (Microsoft, US) &mdash; MLOps platform; AutoML; model registry; responsible AI toolkit integration.</li>
  <li><strong>Azure OpenAI Service</strong> (Microsoft, US) &mdash; OpenAI models in Azure regions; enterprise content filtering; Entra ID integration; data residency controls.</li>
  <li><strong>Cohere API</strong> (Cohere, Canada) &mdash; Enterprise-focused LLM API; strong on data privacy; RAG-optimized; multi-language support.</li>
  <li><strong>Google Vertex AI</strong> (Google Cloud, US) &mdash; Unified ML platform; Model Garden; AutoML; MLOps lifecycle; BigQuery integration; TPU support.</li>
  <li><strong>IBM watsonx</strong> (IBM, US) &mdash; Enterprise AI platform; watsonx.governance for agent inventory, behavior monitoring, hallucination detection; model-agnostic.</li>
  <li><strong>NVIDIA NIM</strong> (NVIDIA, US) &mdash; Inference microservices for deploying foundation models; enterprise GPU optimization; self-hosted options.</li>
</ul>

<h2 id="coding-and-developer-tools">Coding &amp; Developer Tools</h2>
<ul>
  <li><strong>Anthropic Console</strong> (Anthropic, US) &mdash; API management console; prompt testing; evaluation tools; usage monitoring; cost controls.</li>
  <li><strong>AutoGen (Microsoft)</strong> (Microsoft, US) &mdash; Multi-agent conversation framework; agent orchestration; code generation; Microsoft Research.</li>
  <li><strong>Bolt.new</strong> (StackBlitz, US) &mdash; App generation.</li>
  <li><strong>Chroma</strong> (Chroma, US) &mdash; Open-source embedding database; local-first; lightweight RAG; self-hosted option.</li>
  <li><strong>Claude Code</strong> (Anthropic, US) &mdash; Agentic coding; source-code exposure.</li>
  <li><strong>Comet ML</strong> (Comet, US) &mdash; ML experiment management; model monitoring; production tracking; team collaboration.</li>
  <li><strong>CrewAI</strong> (CrewAI, US) &mdash; Multi-agent framework; agent collaboration; task delegation; emerging governance patterns.</li>
  <li><strong>Cursor</strong> (Anysphere, US) &mdash; AI IDE; source-code exposure.</li>
  <li><strong>Dify</strong> (Dify, China) &mdash; LLM app development platform; workflow orchestration; open-source; cross-border data review advised.</li>
  <li><strong>DSPy</strong> (Stanford NLP, US) &mdash; Prompt optimization framework; Stanford research; systematic prompt engineering; reproducibility.</li>
  <li><strong>Flowise</strong> (Flowise, open source) &mdash; Visual LLM workflow builder; low-code RAG; self-hosted; no-code agent building.</li>
  <li><strong>GitHub Copilot</strong> (Microsoft/GitHub, US) &mdash; Code completion; source-code exposure.</li>
  <li><strong>Google AI Studio</strong> (Google, US) &mdash; Model prototyping.</li>
  <li><strong>Hugging Face</strong> (Hugging Face, US) &mdash; Model hub; supply-chain/AIBOM relevant.</li>
  <li><strong>LangChain</strong> (LangChain, US) &mdash; LLM application framework; agent orchestration; supply-chain risk; rapid breaking changes.</li>
  <li><strong>LlamaIndex</strong> (LlamaIndex, US) &mdash; RAG framework; data connectors; indexing strategies; enterprise RAG governance.</li>
  <li><strong>Lovable</strong> (Lovable, Sweden) &mdash; App generation.</li>
  <li><strong>Neptune.ai</strong> (Neptune, Poland) &mdash; ML metadata store; experiment tracking; model registry; EU-hosted options.</li>
  <li><strong>OpenAI API / GPT models</strong> (OpenAI, US) &mdash; Direct API; usage-based cost escalation risk.</li>
  <li><strong>OpenAI Playground / Dashboard</strong> (OpenAI, US) &mdash; API testing environment; fine-tuning; usage tracking; team management; cost escalation risk.</li>
  <li><strong>Pinecone</strong> (Pinecone, US) &mdash; Vector database; RAG infrastructure; data residency options; enterprise security.</li>
  <li><strong>Relevance AI</strong> (Relevance AI, Australia) &mdash; No-code AI workforce; agent teams; task automation; APAC data residency.</li>
  <li><strong>Replit Agent</strong> (Replit, US) &mdash; Agentic coding; source-code exposure.</li>
  <li><strong>Stack AI</strong> (Stack AI, US) &mdash; No-code AI app builder; enterprise deployment; workflow automation; data connector governance.</li>
  <li><strong>Tabnine</strong> (Tabnine, Israel) &mdash; Code completion; self-host option.</li>
  <li><strong>v0 (Vercel)</strong> (Vercel, US) &mdash; UI generation.</li>
  <li><strong>Voiceflow</strong> (Voiceflow, Canada) &mdash; Conversational AI design; voice/chat agent builder; enterprise team features.</li>
  <li><strong>Weaviate</strong> (Weaviate, Netherlands) &mdash; Open-source vector DB; GraphQL interface; EU-hosted; GDPR; hybrid search.</li>
  <li><strong>Weights &amp; Biases</strong> (Weights &amp; Biases, US) &mdash; ML experiment tracking; model registry; artifact lineage; MLOps governance.</li>
  <li><strong>Windsurf</strong> (Cognition, US) &mdash; AI IDE; source-code exposure.</li>
</ul>

<h2 id="data-and-analytics-ai">Data &amp; Analytics AI</h2>
<ul>
  <li><strong>Alteryx AI</strong> (Alteryx, US) &mdash; Analytics automation with AI; data blending; workflow governance; self-service analytics risk.</li>
  <li><strong>Databricks AI / DBRX</strong> (Databricks, US) &mdash; Lakehouse AI; DBRX open model; MLflow governance; Unity Catalog data governance; strong lineage tracking.</li>
  <li><strong>Dataiku</strong> (Dataiku, France) &mdash; Collaborative data science platform; MLOps; governance workflows; EU-hosted options; GDPR relevant.</li>
  <li><strong>Palantir AIP</strong> (Palantir, US) &mdash; Enterprise AI platform; Ontology-based governance; defense/intel focus; high-stakes decision influence.</li>
  <li><strong>Snowflake Cortex</strong> (Snowflake, US) &mdash; Native AI in data cloud; LLM functions; vector search; data residency controls; governance via Snowflake Horizon.</li>
  <li><strong>Tableau AI (Einstein)</strong> (Salesforce, US) &mdash; BI embedded AI; natural language queries; CRM data integration; Trust Layer governance.</li>
</ul>

<h2 id="erp-and-business-application-ai">ERP &amp; Business Application AI</h2>
<ul>
  <li><strong>Oracle Fusion AI</strong> (Oracle, US) &mdash; Embedded AI across ERP, HCM, SCM; autonomous database; enterprise data governance.</li>
  <li><strong>SAP Joule</strong> (SAP, Germany) &mdash; ERP copilot across S/4HANA, SuccessFactors, Ariba; Joule Studio for custom agents; Knowledge Graph integration; ledger-modification risk.</li>
  <li><strong>ServiceNow Now Assist</strong> (ServiceNow, US) &mdash; ITSM/HRSD embedded AI; workflow automation; enterprise process governance.</li>
  <li><strong>Workday AI</strong> (Workday, US) &mdash; HR and finance AI; skills-based talent; predictive analytics; sensitive HR data exposure.</li>
</ul>

<h2 id="education-and-research-ai">Education &amp; Research AI</h2>
<ul>
  <li><strong>CheggMate</strong> (Chegg, US) &mdash; Study AI assistant; academic help; student data; content accuracy; honor code implications.</li>
  <li><strong>Grammarly for Education</strong> (Grammarly, US) &mdash; Institutional writing support; student data; FERPA compliance; generative AI features.</li>
  <li><strong>Khanmigo (Khan Academy)</strong> (Khan Academy, US) &mdash; Educational AI tutor; student interaction data; COPPA compliance; pedagogical bias.</li>
  <li><strong>Turnitin AI Detection</strong> (Turnitin, US) &mdash; AI writing detection; academic integrity; false positive risk; student data privacy (FERPA).</li>
</ul>

<h2 id="emerging-frontier-ai">Emerging / Frontier AI</h2>
<ul>
  <li><strong>Cohere Command R+</strong> (Cohere, Canada) &mdash; Enterprise RAG-optimized model; tool use; autonomous retrieval; data grounding verification.</li>
  <li><strong>Computer Use (Anthropic)</strong> (Anthropic, US) &mdash; Computer control agent; desktop automation; system access; high-privilege operation risk.</li>
  <li><strong>Devin (Cognition)</strong> (Cognition, US) &mdash; Autonomous software engineer; full codebase access; high decision-influence; security critical.</li>
  <li><strong>Figure AI</strong> (Figure AI, US) &mdash; Humanoid robotics AI; physical world interaction; safety-critical; embodied AI governance.</li>
  <li><strong>Mistral Large 2</strong> (Mistral AI, France) &mdash; Advanced EU-hosted LLM; multilingual; GDPR-first design; sovereign AI option.</li>
  <li><strong>Operator (OpenAI)</strong> (OpenAI, US) &mdash; Autonomous web agent; browser control; credential exposure; action authorization risk.</li>
  <li><strong>Physical Intelligence (pi0)</strong> (Physical Intelligence, US) &mdash; General-purpose robot AI; physical task learning; safety-critical; emerging governance standards.</li>
  <li><strong>Tesla Optimus</strong> (Tesla, US) &mdash; Humanoid robot; factory automation; physical safety; worker interaction; liability.</li>
</ul>

<h2 id="enterprise-ai-platforms-and-agent-orchestration">Enterprise AI Platforms &amp; Agent Orchestration</h2>
<ul>
  <li><strong>Aisera</strong> (Aisera, US) &mdash; AI service management platform; autonomous service desk; enterprise governance features.</li>
  <li><strong>Cognigy</strong> (Cognigy, Germany) &mdash; Conversational AI platform for customer service; GDPR-compliant; EU-hosted options.</li>
  <li><strong>Decagon</strong> (Decagon, US) &mdash; Customer support agent platform; omnichannel; model-agnostic; Watchtower monitoring.</li>
  <li><strong>Glean</strong> (Glean, US) &mdash; Enterprise knowledge search AI; 100+ connectors; permission-aware retrieval; data access governance.</li>
  <li><strong>Kore.ai</strong> (Kore.ai, US) &mdash; Enterprise agentic AI platform; multi-agent orchestration; comprehensive governance dashboard with audit logs, RBAC, and guardrails; 400+ Fortune 2000 customers.</li>
  <li><strong>Moveworks</strong> (Moveworks, US) &mdash; Employee support automation; IT service desk agent; enterprise-grade access controls.</li>
  <li><strong>Sierra</strong> (Sierra, US) &mdash; Conversational AI for customer experience; enterprise agent platform.</li>
  <li><strong>Vellum</strong> (Vellum, US) &mdash; Personal AI assistant; on-device Mac app or cloud; cross-app memory; privacy-first design.</li>
</ul>

<h2 id="finance-and-legal-ai">Finance &amp; Legal AI</h2>
<ul>
  <li><strong>AlphaSense</strong> (AlphaSense, US) &mdash; Market intelligence AI; financial research; insider information risk; MNPI controls needed.</li>
  <li><strong>Bloomberg GPT</strong> (Bloomberg, US) &mdash; Finance-specific LLM; market data integration; proprietary data handling; trading decision risk.</li>
  <li><strong>CoCounsel (Casetext)</strong> (Thomson Reuters, US) &mdash; Legal research AI; litigation support; Westlaw integration; attorney work product risk.</li>
  <li><strong>Harvey AI</strong> (Harvey, US) &mdash; Legal AI assistant; contract drafting; case research; law firm data exposure; privilege concerns.</li>
  <li><strong>Kira Systems</strong> (Litera, US) &mdash; Contract analysis AI; legal document review; attorney-client privilege risk; confidential data.</li>
  <li><strong>Vanta</strong> (Vanta, US) &mdash; Security compliance automation; SOC 2, ISO 27001; continuous monitoring; audit automation.</li>
</ul>

<h2 id="hr-and-talent-ai">HR &amp; Talent AI</h2>
<ul>
  <li><strong>Beamery</strong> (Beamery, UK) &mdash; Talent lifecycle management AI; skills ontology; DEI analytics; UK-hosted; GDPR relevant.</li>
  <li><strong>Eightfold AI</strong> (Eightfold, US) &mdash; Talent intelligence platform; skills matching; DEI bias risk; high-stakes employment decisions.</li>
  <li><strong>HireVue</strong> (HireVue, US) &mdash; Video interviewing AI; facial analysis controversy; algorithmic hiring bias; regulatory scrutiny.</li>
  <li><strong>LinkedIn Recruiter AI</strong> (Microsoft/LinkedIn, US) &mdash; Talent acquisition AI; candidate matching; bias risk in hiring; GDPR for EU candidates.</li>
  <li><strong>Paradox (Olivia)</strong> (Paradox, US) &mdash; Conversational recruiting AI; candidate screening; automated scheduling; hiring bias risk.</li>
</ul>

<h2 id="healthcare-and-life-sciences-ai">Healthcare &amp; Life Sciences AI</h2>
<ul>
  <li><strong>Epic AI (SlicerDicer, etc.)</strong> (Epic Systems, US) &mdash; Clinical decision support; patient data exposure; HIPAA critical; FDA SaMD considerations.</li>
  <li><strong>Google Med-PaLM / MedLM</strong> (Google, US) &mdash; Medical LLM; clinical reasoning; healthcare data; HIPAA BAA required; diagnostic liability.</li>
  <li><strong>Insilico Medicine</strong> (Insilico Medicine, Hong Kong) &mdash; Drug discovery AI; molecular design; IP generation; cross-border data (China/HK).</li>
  <li><strong>Merative (formerly Watson Health)</strong> (Merative, US) &mdash; Healthcare data analytics; clinical AI; population health; PHI governance.</li>
  <li><strong>Tempus AI</strong> (Tempus, US) &mdash; Precision medicine AI; genomic data; clinical trial matching; genetic privacy (GINA).</li>
</ul>

<h2 id="image-and-graphic-design">Image &amp; Graphic Design</h2>
<ul>
  <li><strong>Adobe Express AI</strong> (Adobe, US) &mdash; Lightweight design AI; quick content creation; Adobe Firefly integration; commercial-safe.</li>
  <li><strong>Adobe Firefly</strong> (Adobe, US) &mdash; Image generation; commercial-safe training claim.</li>
  <li><strong>Blender AI Add-ons</strong> (Blender Foundation, Netherlands) &mdash; 3D creation AI plugins; open-source; local processing; model provenance varies by plugin.</li>
  <li><strong>Canva AI</strong> (Canva, Australia) &mdash; Design generation.</li>
  <li><strong>Clipdrop (Stability AI)</strong> (Stability AI, UK) &mdash; Image editing AI suite; Stability AI ecosystem; open-weight tools; commercial licensing.</li>
  <li><strong>DALL-E (OpenAI)</strong> (OpenAI, US) &mdash; Image generation; IP provenance relevant.</li>
  <li><strong>DeepAI</strong> (DeepAI, US) &mdash; Image generation.</li>
  <li><strong>Figma AI</strong> (Figma, US) &mdash; Design AI; auto-layout; content generation; design system governance; Adobe acquisition context.</li>
  <li><strong>Freepik AI</strong> (Freepik, Spain) &mdash; Stock image AI generation; commercial licensing; EU-hosted; content moderation.</li>
  <li><strong>Ideogram</strong> (Ideogram, Canada) &mdash; Text-in-image generation; typography AI; commercial use; IP and copyright considerations.</li>
  <li><strong>Jasper Art</strong> (Jasper, US) &mdash; Marketing image generation; brand asset creation; commercial use; same vendor as Jasper copy.</li>
  <li><strong>Krita AI</strong> (Krita Foundation, Netherlands) &mdash; Open-source digital art; local AI plugins; no cloud dependency; community governance.</li>
  <li><strong>Leonardo.ai</strong> (Canva, Australia) &mdash; Image generation.</li>
  <li><strong>Microsoft Designer</strong> (Microsoft, US) &mdash; Image/design generation.</li>
  <li><strong>Midjourney</strong> (Midjourney, US) &mdash; Image generation; IP provenance relevant.</li>
  <li><strong>Miro AI</strong> (Miro, US) &mdash; Collaborative whiteboard AI; diagram generation; sticky note synthesis; creative IP risk.</li>
  <li><strong>Photoroom</strong> (Photoroom, France) &mdash; AI photo editing; background removal; e-commerce focus; EU data handling.</li>
  <li><strong>Recraft</strong> (Recraft, UK) &mdash; Vector image generation; brand consistency; commercial design; UK-hosted.</li>
  <li><strong>Remove.bg</strong> (Canva, Australia) &mdash; Image processing.</li>
  <li><strong>Sketch AI</strong> (Sketch, Netherlands) &mdash; Design tool AI; macOS native; local processing option; EU design data.</li>
  <li><strong>Stable Diffusion</strong> (Stability AI, UK) &mdash; Open-weight image model.</li>
</ul>

<h2 id="notes-knowledge-and-meetings">Notes, Knowledge &amp; Meetings</h2>
<ul>
  <li><strong>Asana AI</strong> (Asana, US) &mdash; Work management AI; goal tracking; team productivity analytics; data residency options.</li>
  <li><strong>Avoma</strong> (Avoma, US) &mdash; Meeting intelligence AI; conversation analytics; coaching; revenue team data.</li>
  <li><strong>Box AI</strong> (Box, US) &mdash; Enterprise content AI; metadata; governance; compliance; retention policies.</li>
  <li><strong>Cisco Webex AI</strong> (Cisco, US) &mdash; Meeting intelligence; real-time translation; noise removal; enterprise security.</li>
  <li><strong>ClickUp AI</strong> (ClickUp, US) &mdash; All-in-one productivity AI; document generation; task automation; broad data access.</li>
  <li><strong>Coda AI</strong> (Coda, US) &mdash; All-in-one doc AI; automation; team data; enterprise governance features.</li>
  <li><strong>Confluence AI</strong> (Atlassian, Australia) &mdash; Team wiki AI; smart links; automation; Atlassian Cloud governance.</li>
  <li><strong>Dropbox AI</strong> (Dropbox, US) &mdash; Cloud storage AI; document summaries; team data; sharing controls.</li>
  <li><strong>Fathom</strong> (Fathom, US) &mdash; Meeting notetaker AI; auto-summaries; CRM sync; consent and privacy.</li>
  <li><strong>Fireflies.ai</strong> (Fireflies.ai, US) &mdash; Meeting transcription; consent relevant.</li>
  <li><strong>Gong</strong> (Gong, US) &mdash; Revenue intelligence AI; call analysis; deal coaching; sensitive sales data exposure.</li>
  <li><strong>Google Drive AI</strong> (Google, US) &mdash; Cloud storage AI; Gemini integration; Workspace data; sharing governance.</li>
  <li><strong>Google Meet AI</strong> (Google, US) &mdash; Meeting summaries; live captions; note-taking; Google Workspace data.</li>
  <li><strong>Grain</strong> (Grain, US) &mdash; Meeting recording AI; highlight clips; CRM integration; consent and sharing.</li>
  <li><strong>Logseq AI</strong> (Logseq, open source) &mdash; Open-source knowledge base; local-first; graph database; privacy-focused.</li>
  <li><strong>Mem</strong> (Mem Labs, US) &mdash; Personal knowledge base.</li>
  <li><strong>Microsoft Teams AI</strong> (Microsoft, US) &mdash; Meeting recaps; intelligent recap; Copilot integration; M365 data exposure.</li>
  <li><strong>Monday.com AI</strong> (monday.com, Israel) &mdash; Work OS AI; project automation; cross-functional data; Israeli data transfer considerations.</li>
  <li><strong>NotebookLM</strong> (Google, US) &mdash; Document grounding; ingests uploaded corpora.</li>
  <li><strong>Notion Q&amp;A</strong> (Notion Labs, US) &mdash; Knowledge base AI Q&amp;A; workspace corpus access; permission-aware but broad exposure risk.</li>
  <li><strong>Obsidian AI</strong> (Obsidian, Canada) &mdash; Local-first knowledge AI; plugins; privacy-focused; no cloud dependency.</li>
  <li><strong>Otter.ai</strong> (Otter.ai, US) &mdash; Meeting transcription; consent relevant.</li>
  <li><strong>Read.ai</strong> (Read, US) &mdash; Meeting analytics AI; engagement scoring; wellness insights; behavioral data privacy.</li>
  <li><strong>SharePoint AI</strong> (Microsoft, US) &mdash; Enterprise content AI; Copilot integration; M365 governance; DLP.</li>
  <li><strong>Supernormal</strong> (Supernormal, US) &mdash; Meeting notes AI; action items; CRM sync; team productivity data.</li>
  <li><strong>tl;dv</strong> (tl;dv, Germany) &mdash; Meeting recorder AI; timestamped notes; EU-hosted; GDPR; consent management.</li>
  <li><strong>Trello AI (Atlassian)</strong> (Atlassian, Australia) &mdash; Project management AI; workflow automation; team data exposure; Atlassian Cloud governance.</li>
</ul>

<h2 id="open-source-and-self-hosted-models">Open Source &amp; Self-Hosted Models</h2>
<ul>
  <li><strong>Hugging Face Transformers</strong> (Hugging Face, US) &mdash; Model hub and inference library; supply-chain/AIBOM critical; model card verification; security scanning.</li>
  <li><strong>llama.cpp</strong> (Georgi Gerganov, open source) &mdash; Lightweight LLM inference; C++ implementation; edge deployment; model provenance tracking.</li>
  <li><strong>Ollama</strong> (Ollama, US) &mdash; Local LLM runner; self-hosted; no data exfiltration; model supply-chain verification needed.</li>
  <li><strong>PyTorch</strong> (Meta / Linux Foundation, US) &mdash; Deep learning framework; model checkpoint governance; TorchServe deployment; research-to-production lineage.</li>
  <li><strong>TensorFlow / Keras</strong> (Google, US) &mdash; ML framework; model serialization risks; custom model governance; TensorFlow Extended (TFX) for MLOps.</li>
  <li><strong>vLLM</strong> (UC Berkeley / vLLM Team, US) &mdash; High-throughput inference engine; open-source; self-hosted; no external data sharing.</li>
</ul>

<h2 id="search-research-translation-and-other">Search, Research, Translation &amp; Other</h2>
<ul>
  <li><strong>Connected Papers</strong> (Connected Papers, Israel) &mdash; Visual paper graph; literature discovery; academic research; Israeli vendor.</li>
  <li><strong>Consensus</strong> (Consensus, US) &mdash; Research search.</li>
  <li><strong>DeepL</strong> (DeepL, Germany) &mdash; Translation; EU-hosted.</li>
  <li><strong>Elicit</strong> (Elicit, US) &mdash; Research assistant AI; paper analysis; systematic review; academic integrity.</li>
  <li><strong>Groq</strong> (Groq, US) &mdash; Inference acceleration.</li>
  <li><strong>Lokalise AI</strong> (Lokalise, UK) &mdash; Localization AI; continuous translation; developer workflow; UK-hosted.</li>
  <li><strong>Perplexity Enterprise Pro</strong> (Perplexity, US) &mdash; Enterprise search AI; internal knowledge search; data indexing; SSO; audit logs.</li>
  <li><strong>Phrase (Memsource)</strong> (Phrase, Czech Republic) &mdash; Enterprise localization AI; TMS; machine translation; EU-hosted; GDPR.</li>
  <li><strong>ResearchRabbit</strong> (ResearchRabbit, US) &mdash; Research discovery AI; paper recommendations; collaboration features; academic data.</li>
  <li><strong>Salesforce Einstein / Agentforce</strong> (Salesforce, US) &mdash; CRM-embedded AI + agents.</li>
  <li><strong>Scite</strong> (Scite, US) &mdash; Smart citation analysis; claim verification; research quality; academic trust.</li>
  <li><strong>Semantic Scholar</strong> (Allen Institute for AI, US) &mdash; Academic search AI; paper summaries; citation graphs; nonprofit research focus.</li>
  <li><strong>Smartcat</strong> (Smartcat, US) &mdash; Translation management AI; CAT tool; vendor marketplace; translation memory governance.</li>
  <li><strong>Unbabel</strong> (Unbabel, Portugal) &mdash; AI-human translation; quality estimation; enterprise localization; EU vendor.</li>
  <li><strong>Wayground</strong> (Wayground, US) &mdash; Education tooling.</li>
  <li><strong>You.com Enterprise</strong> (You.com, US) &mdash; Private search AI; no tracking; enterprise deployment; data privacy focus.</li>
</ul>

<h2 id="security-and-identity-ai">Security &amp; Identity AI</h2>
<ul>
  <li><strong>CrowdStrike Charlotte AI</strong> (CrowdStrike, US) &mdash; Security operations AI; threat detection; autonomous response; high-privilege access.</li>
  <li><strong>Darktrace</strong> (Darktrace, UK) &mdash; Self-learning AI security; anomaly detection; autonomous response; UK-hosted; GDPR relevant.</li>
  <li><strong>Okta AI</strong> (Okta, US) &mdash; Identity AI; risk-based authentication; privileged access; identity threat detection.</li>
  <li><strong>Palo Alto Networks Precision AI</strong> (Palo Alto Networks, US) &mdash; Network security AI; Zero Trust integration; autonomous threat response; critical infrastructure.</li>
  <li><strong>SentinelOne Purple AI</strong> (SentinelOne, US) &mdash; Endpoint security AI; autonomous response; XDR platform; kill-switch capabilities.</li>
  <li><strong>Zscaler AI</strong> (Zscaler, US) &mdash; Cloud security AI; SSE platform; data loss prevention; AI traffic inspection.</li>
</ul>

<h2 id="slides-and-presentations">Slides &amp; Presentations</h2>
<ul>
  <li><strong>Beautiful.ai</strong> (Beautiful.ai, US) &mdash; Presentation generation.</li>
  <li><strong>Decktopus</strong> (Decktopus, US) &mdash; AI presentation maker; automated design; content generation; data exposure.</li>
  <li><strong>Gamma</strong> (Gamma, US) &mdash; Presentation generation.</li>
  <li><strong>Pitch AI</strong> (Pitch, Germany) &mdash; Presentation software AI; collaboration; template generation; EU-hosted.</li>
  <li><strong>Presentations.AI</strong> (Presentations.AI, US) &mdash; Text-to-presentation AI; automated layouts; brand templates; content governance.</li>
  <li><strong>SlidesAI</strong> (SlidesAI, India) &mdash; Presentation generation.</li>
  <li><strong>Tome</strong> (Tome, US) &mdash; AI storytelling; presentation generation; narrative design; creative IP.</li>
</ul>

<h2 id="video-generation-and-editing">Video Generation &amp; Editing</h2>
<ul>
  <li><strong>2short.ai</strong> (2short, US) &mdash; YouTube shorts AI; clip extraction; content automation; platform dependency.</li>
  <li><strong>CapCut</strong> (ByteDance, China) &mdash; Video editing; cross-border data review advised.</li>
  <li><strong>Captions AI</strong> (Captions, US) &mdash; AI video editing; eye contact correction; dubbing; likeness manipulation consent.</li>
  <li><strong>Colossyan</strong> (Colossyan, UK) &mdash; AI video avatars; enterprise training; consent management; UK-hosted.</li>
  <li><strong>D-ID</strong> (D-ID, Israel) &mdash; Talking head AI; photo animation; likeness rights; deepfake risk; Israeli vendor.</li>
  <li><strong>DaVinci Resolve AI</strong> (Blackmagic Design, Australia) &mdash; Professional video AI; color grading; facial recognition; local processing option.</li>
  <li><strong>Descript</strong> (Descript, US) &mdash; Audio/video editing + voice cloning.</li>
  <li><strong>Elai.io</strong> (Elai, US) &mdash; AI avatar video; text-to-video; multilingual; enterprise training; consent.</li>
  <li><strong>Filmora AI</strong> (Wondershare, China) &mdash; Video editing.</li>
  <li><strong>Final Cut Pro AI</strong> (Apple, US) &mdash; Mac video editing AI; on-device processing; privacy-first; Apple silicon optimization.</li>
  <li><strong>Fliki</strong> (Fliki, US) &mdash; Video + voice generation.</li>
  <li><strong>Hailuo AI (MiniMax)</strong> (MiniMax, China) &mdash; Video generation; cross-border data review advised; same vendor as MiniMax LLM.</li>
  <li><strong>Headliner</strong> (Headliner, US) &mdash; Podcast/video promotion; audiogram generation; social media; content marketing.</li>
  <li><strong>HeyGen</strong> (HeyGen, US) &mdash; AI avatars; likeness/consent risk.</li>
  <li><strong>Hour One</strong> (Hour One, Israel) &mdash; AI avatar video; virtual presenters; enterprise video; likeness consent; Israeli vendor.</li>
  <li><strong>iMovie AI</strong> (Apple, US) &mdash; Consumer video editing; trailer templates; on-device; Apple privacy.</li>
  <li><strong>InShot AI</strong> (InShot, China) &mdash; Mobile video editing AI; social content; cross-border data review advised.</li>
  <li><strong>InVideo</strong> (InVideo, India) &mdash; Video generation.</li>
  <li><strong>Kling AI (Kuaishou)</strong> (Kuaishou, China) &mdash; Video generation model; cross-border data review advised; content moderation; Chinese vendor.</li>
  <li><strong>Krea AI</strong> (Krea, US) &mdash; Real-time video generation; creative tool; content moderation; emerging platform.</li>
  <li><strong>Loom AI</strong> (Loom, US) &mdash; Async video AI; auto-chapters; summaries; transcription; Atlassian acquisition context.</li>
  <li><strong>Luma AI</strong> (Luma AI, US) &mdash; 3D/video generation.</li>
  <li><strong>Lumen5</strong> (Lumen5, Canada) &mdash; Video generation.</li>
  <li><strong>Microsoft Clipchamp AI</strong> (Microsoft, US) &mdash; Video editing AI; M365 integration; auto-caption; text-to-speech; enterprise data.</li>
  <li><strong>Munch</strong> (Munch, Israel) &mdash; Content repurposing AI; auto-editing; social clips; trend analysis; Israeli vendor.</li>
  <li><strong>OpusClip</strong> (OpusClip, US) &mdash; Video repurposing.</li>
  <li><strong>Pictory</strong> (Pictory, US) &mdash; Video generation.</li>
  <li><strong>Pika Labs</strong> (Pika Labs, US) &mdash; Video generation; meme/creative focus; content policy; IP provenance.</li>
  <li><strong>Premiere Pro AI (Adobe)</strong> (Adobe, US) &mdash; Professional video AI; generative extend; color match; commercial-safe training.</li>
  <li><strong>Repurpose.io</strong> (Repurpose, US) &mdash; Content distribution automation; multi-platform; workflow automation; API access.</li>
  <li><strong>Runway</strong> (Runway, US) &mdash; Video generation.</li>
  <li><strong>Sora (OpenAI)</strong> (OpenAI, US) &mdash; Video generation; provenance/disclosure relevant.</li>
  <li><strong>Splice</strong> (Splice, US) &mdash; Mobile video editing; music licensing; content creation; GoPro ownership.</li>
  <li><strong>Submagic</strong> (Submagic, France) &mdash; Auto-caption AI; video subtitles; emoji/sticker automation; EU vendor.</li>
  <li><strong>Synthesia</strong> (Synthesia, UK) &mdash; AI avatars; likeness/consent risk.</li>
  <li><strong>Veed.io AI</strong> (Veed, UK) &mdash; Online video editing AI; auto-subtitle; text-to-speech; UK-hosted.</li>
  <li><strong>Videoleap</strong> (Lightricks, Israel) &mdash; Mobile video editing AI; effects; templates; Israeli vendor.</li>
  <li><strong>Vidu (Tsinghua / Shengshu)</strong> (Shengshu Technology, China) &mdash; Video generation model; academic spin-off; cross-border data review advised.</li>
  <li><strong>Vizard AI</strong> (Vizard, US) &mdash; Video repurposing; auto-clipping; social media; content strategy AI.</li>
  <li><strong>Wavve</strong> (Wavve, US) &mdash; Audio-to-video AI; podcast clips; waveform videos; social media content.</li>
  <li><strong>Wistia</strong> (Wistia, US) &mdash; Video hosting AI; analytics; marketing video; data privacy; engagement tracking.</li>
  <li><strong>Wondershare Virbo</strong> (Wondershare, China) &mdash; AI avatar video; cross-border data review advised; likeness consent; Chinese vendor.</li>
  <li><strong>Zeemo</strong> (Zeemo, US) &mdash; Video captioning AI; translation; subtitle styling; content accessibility.</li>
</ul>

<h2 id="voice-and-audio">Voice &amp; Audio</h2>
<ul>
  <li><strong>Adobe Podcast AI</strong> (Adobe, US) &mdash; Audio enhancement AI; speech enhancement; microphone check; commercial-safe training claim.</li>
  <li><strong>AIVA</strong> (AIVA Technologies, Luxembourg) &mdash; Classical music AI composer; copyright assignment; EU-hosted; commercial licensing.</li>
  <li><strong>Altered</strong> (Altered, UK) &mdash; Professional voice editing; voice morphing; dubbing; consent management; UK-hosted.</li>
  <li><strong>AssemblyAI</strong> (AssemblyAI, US) &mdash; Speech AI API; transcription; summarization; PII redaction; enterprise security.</li>
  <li><strong>Deepgram</strong> (Deepgram, US) &mdash; Speech recognition API; real-time transcription; model customization; on-prem option.</li>
  <li><strong>Descript Overdub</strong> (Descript, US) &mdash; Voice cloning for editing; consent recording required; deepfake risk; media integrity.</li>
  <li><strong>ElevenLabs</strong> (ElevenLabs, US) &mdash; Voice cloning; likeness/consent risk.</li>
  <li><strong>Krisp</strong> (Krisp, US) &mdash; Audio processing.</li>
  <li><strong>Lovo (Genny)</strong> (Lovo, US) &mdash; Voice cloning and synthesis; likeness consent; commercial voiceover; synthetic media disclosure.</li>
  <li><strong>Murf.ai</strong> (Murf, India) &mdash; Voice synthesis.</li>
  <li><strong>Play.ht</strong> (PlayAI, US) &mdash; Voice synthesis.</li>
  <li><strong>Resemble AI</strong> (Resemble AI, US) &mdash; Voice cloning; likeness/consent risk.</li>
  <li><strong>Respeecher</strong> (Respeecher, Ukraine) &mdash; Voice cloning for media; entertainment focus; likeness rights; Ukrainian vendor.</li>
  <li><strong>Rev AI</strong> (Rev, US) &mdash; Speech-to-text API; transcription; captioning; human + AI hybrid; data confidentiality.</li>
  <li><strong>Soundraw</strong> (Soundraw, Japan) &mdash; Royalty-free AI music; commercial license; JASRAC considerations for Japan use.</li>
  <li><strong>Speechmatics</strong> (Speechmatics, UK) &mdash; Speech-to-text; real-time translation; accent-agnostic; UK-hosted; GDPR.</li>
  <li><strong>Suno</strong> (Suno, US) &mdash; Music generation; IP provenance relevant.</li>
  <li><strong>Udio</strong> (Udio, US) &mdash; AI music generation; copyright risk; likeness in vocals; RIAA litigation context.</li>
  <li><strong>Voicemod</strong> (Voicemod, Spain) &mdash; Real-time voice changing; gaming/streaming; content moderation; EU vendor.</li>
  <li><strong>Whisper API (OpenAI)</strong> (OpenAI, US) &mdash; Speech recognition; transcription; translation; API data retention policy.</li>
</ul>

<h2 id="writing-and-editing">Writing &amp; Editing</h2>
<ul>
  <li><strong>Anyword</strong> (Anyword, US) &mdash; Predictive performance AI copy; marketing optimization; data-driven; performance claims.</li>
  <li><strong>Clearscope</strong> (Clearscope, US) &mdash; Content optimization AI; readability scoring; competitor content analysis.</li>
  <li><strong>Copy.ai</strong> (Copy.ai, US) &mdash; Marketing copy / GTM workflows.</li>
  <li><strong>Frase</strong> (Frase, US) &mdash; SEO content AI; SERP analysis; competitive data scraping; search algorithm dependency.</li>
  <li><strong>Grammarly</strong> (Grammarly, US) &mdash; Reads document text broadly.</li>
  <li><strong>Jasper</strong> (Jasper, US) &mdash; Marketing copy.</li>
  <li><strong>Jasper Campaigns</strong> (Jasper, US) &mdash; End-to-end marketing campaigns AI; brand voice; cross-channel content; governance dashboard.</li>
  <li><strong>MarketMuse</strong> (MarketMuse, US) &mdash; Content strategy AI; topic modeling; site-wide content audit; competitive intelligence.</li>
  <li><strong>QuillBot</strong> (Course Hero, US) &mdash; Paraphrasing.</li>
  <li><strong>Rytr</strong> (Rytr, US) &mdash; Marketing copy.</li>
  <li><strong>Surfer SEO</strong> (Surfer, Poland) &mdash; SEO optimization AI; content scoring; NLP analysis; EU-hosted options.</li>
  <li><strong>Typeface</strong> (Typeface, US) &mdash; Enterprise content AI; brand-customized models; marketing asset generation; high decision-influence.</li>
  <li><strong>Wordtune</strong> (AI21 Labs, Israel) &mdash; Rewriting.</li>
  <li><strong>Writer.com</strong> (Writer, US) &mdash; Enterprise writing AI; brand governance; style guide enforcement; hallucination detection; PALMYRA models.</li>
  <li><strong>WriteSonic</strong> (Writesonic, US) &mdash; Marketing copy.</li>
</ul>
<!--SRJ_TOOLS_CATALOG_END-->

<h2 id="keeping-the-inventory-alive">Keeping the inventory alive</h2>

<p>A tool catalog is a snapshot; an inventory is a discipline. New tools appear monthly, vendors get acquired, and embedded AI features switch on without notice, so the working practice is a quarterly review: reconcile this list against what finance is paying for, what IT sees on the network, and what teams admit to using, then record owner, data access, and approval status for each. The <a href="/ai-governance/">AI Governance Reference Library</a> covers the frameworks that inventory feeds into.</p>
SRJBODY
);
