<?php
/**
 * Template Name: Book Detail
 *
 * Reusable detail page for a single book in The Operating Discipline for AI Library&trade;.
 * One template renders any book, driven by the $book config array
 * below. To add another book: create its WordPress page under the correct
 * pillar parent, assign this "Book Detail" template, and add a matching
 * entry to the $SRJ_BOOKS config keyed by the page slug.
 *
 * URL pattern: /books/<pillar-slug>/<book-slug>/
 *   e.g. /books/ai-business-services/the-ai-business-enablement-audit/
 *
 * The page's slug (post_name) selects which $SRJ_BOOKS entry is used, so the
 * same template file serves every book. If no entry matches the slug, the
 * template falls back to the WordPress page title with a neutral message.
 *
 * To deploy:
 *   1. SFTP this file to /wp-content/themes/srj-consulting/
 *   2. Ensure parent pages exist: "Books" (slug: books), and under it the
 *      pillar page (slug: ai-business-services or ai-risk-governance-security).
 *   3. Create the book Page, set its parent to the pillar page, set its slug,
 *      assign Template = "Book Detail", and Publish.
 *
 * Companion files (Book 1) live under:
 *   /wp-content/uploads/The_Operating_Discipline_for_AI/AI_Business_Enablement_Audit/
 *
 * Worksheet gate (July 2, 2026): the library section (worksheets, companion
 * docs, chapter graphics) is gated behind a one-time email capture. The gate
 * is CLIENT-SIDE over server-set state, deliberately: the page renders
 * identical HTML for every visitor (full-page-cache safe against the
 * GoDaddy/Sucuri stack, Section 2.1 of the architecture doc), and a small
 * inline script checks the srj_worksheet_access cookie. Cookie present: the
 * gate panel is hidden and downloads work normally. Cookie absent: download
 * clicks are intercepted and scrolled to the gate form. The cookie is set
 * server-side by inc/beehiiv-integration.php when the SRJ Worksheet Access
 * Fluent Forms form is submitted (10-year lifetime, path /, SameSite Lax),
 * and also client-side on the fluentform_submission_success event so the
 * unlock is instant without a page refresh. No-JS visitors fall through to
 * working download links (fail-open; leakage is an accepted trade-off per
 * the July 2 2026 gating decision). The form ID is read from the
 * SRJ_WORKSHEET_FORM_ID constant defined in inc/beehiiv-integration.php.
 * Same pass: the Series CTA's stale srj_get_calendly() call was swapped to
 * the canonical srj_get_booking() (v1.12 rename, per architecture doc
 * Section 3.3 stale-helper note).
 *
 * Trademark audit (July 10, 2026): 35 &trade; markers added inline across
 * the 9 body_html nowdoc blocks, scoped strictly to prose (H2 headings
 * and paragraph text); PHP config arrays ('name'/'title' fields) are
 * untouched because the render code appends &trade; at display time,
 * and chapter titles inside heading_html <em> tags are also untouched
 * per the book-internal-title convention. Marks reconciled against the
 * canonical SRJ_Trademark_Portfolio_v1_1.csv (78 marks). Insertions
 * cluster in Book 03 (AI Risk & Governance Review) and Book 04
 * (AI Efficiency & Process Optimization) chapter walks, where multiple
 * secondary marks (AI Governance Framework Crosswalk, AI Governance
 * Maturity Scale, AI Accountability Matrix, AI Data Exposure Model,
 * Decision Influence Matrix, AI Vendor Risk Inventory, AI Steering
 * Committee Charter, AI Refinement Register, Use Case Decision Record,
 * Standing AI Adoption Policy, Master AI Readiness Scorecard, and
 * others) are cross-referenced.
 *
 * @package SRJ_Consulting
 */

get_header();

/**
 * SRJ Books Hub — chapter graphics preview helper.
 *
 * The Chapter Graphics Library lists book figures by scanning the uploads
 * folders directly (these files are placed via SFTP, not the Media Library,
 * so WordPress has generated no thumbnail sizes for them).
 *
 * To avoid loading multi-megabyte originals into ~200px preview cards, this
 * helper generates a small cached preview next to each original on first use,
 * and returns the preview URL plus its real pixel dimensions so the <img>
 * tag can declare width/height (eliminating layout shift / CLS).
 *
 * Safe by design:
 *   - If a preview already exists and is newer than the original, it is reused.
 *   - If the image library or folder write permission is unavailable, the
 *     function falls back to the original file — the page never breaks.
 *   - Download links always point to the full-resolution original elsewhere.
 *
 * @param string $abs_original  Absolute server path to the original image.
 * @param string $url_original  Public URL to the original image.
 * @return array { 'url' => string, 'width' => int|null, 'height' => int|null }
 */
function srj_books_graphic_preview( $abs_original, $url_original ) {

    $result = array( 'url' => $url_original, 'width' => null, 'height' => null );

    if ( ! is_file( $abs_original ) || ! is_readable( $abs_original ) ) {
        return $result;
    }

    $preview_width = 400; // crisp at 2x for ~200px cards

    $ext  = strtolower( pathinfo( $abs_original, PATHINFO_EXTENSION ) );
    $dir  = dirname( $abs_original );
    $name = pathinfo( $abs_original, PATHINFO_FILENAME );

    // SVGs are already tiny and vector — serve as-is, no raster preview.
    if ( 'svg' === $ext ) {
        return $result;
    }

    // Read native dimensions of the original.
    $size = @getimagesize( $abs_original );
    if ( false === $size ) {
        return $result; // not a usable raster image; fall back
    }
    $orig_w = (int) $size[0];
    $orig_h = (int) $size[1];

    // Original already small enough — just declare its real dimensions.
    if ( $orig_w > 0 && $orig_w <= $preview_width ) {
        $result['width']  = $orig_w;
        $result['height'] = $orig_h;
        return $result;
    }

    // Compute the scaled preview dimensions.
    $ratio    = $orig_h / max( 1, $orig_w );
    $thumb_w  = $preview_width;
    $thumb_h  = (int) round( $preview_width * $ratio );

    // Cached preview path: same folder, "-srjprev400" suffix.
    $preview_basename = $name . '-srjprev' . $preview_width . '.' . ( 'png' === $ext ? 'png' : 'jpg' );
    $abs_preview = $dir . '/' . $preview_basename;
    $url_preview = dirname( $url_original ) . '/' . rawurlencode( $preview_basename );

    // Reuse an existing, up-to-date preview.
    if ( is_file( $abs_preview ) && filemtime( $abs_preview ) >= filemtime( $abs_original ) ) {
        $result['url']    = $url_preview;
        $result['width']  = $thumb_w;
        $result['height'] = $thumb_h;
        return $result;
    }

    // Need to generate one. Requires WordPress's image editor and a writable folder.
    if ( ! is_writable( $dir ) || ! function_exists( 'wp_get_image_editor' ) ) {
        // Can't cache a preview — fall back to original, but still declare dimensions.
        $result['width']  = $orig_w;
        $result['height'] = $orig_h;
        return $result;
    }

    $editor = wp_get_image_editor( $abs_original );
    if ( is_wp_error( $editor ) ) {
        $result['width']  = $orig_w;
        $result['height'] = $orig_h;
        return $result;
    }

    $editor->resize( $thumb_w, $thumb_h, false );
    if ( method_exists( $editor, 'set_quality' ) ) {
        $editor->set_quality( 82 );
    }
    $saved = $editor->save( $abs_preview );

    if ( is_wp_error( $saved ) || empty( $saved['path'] ) || ! is_file( $saved['path'] ) ) {
        // Generation failed — fall back to original with real dimensions.
        $result['width']  = $orig_w;
        $result['height'] = $orig_h;
        return $result;
    }

    // Success. The editor may adjust the filename/extension — use what it reports.
    $result['url']    = dirname( $url_original ) . '/' . rawurlencode( basename( $saved['path'] ) );
    $result['width']  = isset( $saved['width'] )  ? (int) $saved['width']  : $thumb_w;
    $result['height'] = isset( $saved['height'] ) ? (int) $saved['height'] : $thumb_h;
    return $result;
}

/**
 * Auto-discover chapter graphics folders under a book's library base.
 *
 * Used when a book config omits an explicit 'chapters' map. Scans the
 * library_base for subdirectories (skipping 'Appendix'), derives a heading,
 * nav label, and anchor id from each folder name, and orders them sensibly:
 * Introduction first, numbered chapters in numeric order, Conclusion last,
 * anything else alphabetically. Returns the same shape as an explicit map:
 * array( folder_name => array('id','nav_label','heading_html') ).
 *
 * @param string $base_path  library_base, e.g. /wp-content/uploads/.../Book
 * @return array
 */
function srj_books_autodiscover_chapters( $base_path ) {
    $out = array();
    $abs = ABSPATH . ltrim( $base_path, '/' );
    if ( ! is_dir( $abs ) ) {
        return $out;
    }
    $entries = @scandir( $abs );
    if ( false === $entries ) {
        return $out;
    }

    $items = array();
    foreach ( $entries as $entry ) {
        if ( '.' === $entry || '..' === $entry || 'Appendix' === $entry ) {
            continue;
        }
        if ( ! is_dir( $abs . '/' . $entry ) ) {
            continue;
        }

        // Defaults for an unrecognized folder name.
        $sort    = 500;
        $id      = sanitize_title( $entry );
        $nav     = $entry;
        $heading = esc_html( $entry );

        if ( preg_match( '/^chapter\s*(\d+)\b\s*(?:[-\x{2013}\x{2014}:]\s*(.+))?$/iu', $entry, $m ) ) {
            $num     = (int) $m[1];
            $sort    = $num;
            $id      = 'ch' . str_pad( (string) $num, 2, '0', STR_PAD_LEFT );
            $nav     = 'Ch ' . $num;
            $title   = isset( $m[2] ) ? trim( $m[2] ) : '';
            $heading = ( '' !== $title )
                ? 'Chapter ' . $num . ': <em>' . esc_html( $title ) . '</em>'
                : 'Chapter ' . $num;
        } elseif ( preg_match( '/^introduction$/i', $entry ) ) {
            $sort = -1; $id = 'intro'; $nav = 'Intro'; $heading = 'Introduction';
        } elseif ( preg_match( '/^conclusion$/i', $entry ) ) {
            $sort = 999; $id = 'conclusion'; $nav = 'Conclusion'; $heading = 'Conclusion';
        }

        $items[] = array(
            'folder' => $entry,
            'sort'   => $sort,
            'info'   => array( 'id' => $id, 'nav_label' => $nav, 'heading_html' => $heading ),
        );
    }

    usort( $items, function ( $a, $b ) {
        if ( $a['sort'] === $b['sort'] ) {
            return strcmp( $a['folder'], $b['folder'] );
        }
        return $a['sort'] <=> $b['sort'];
    } );

    foreach ( $items as $it ) {
        $out[ $it['folder'] ] = $it['info'];
    }
    return $out;
}

/* =========================================================================
   PER-BOOK CONFIG
   Keyed by the WordPress page slug. Each book that uses the "Book Detail"
   template needs one entry here. Books 2-6 are placeholders for Stage 2.
   ========================================================================= */
$SRJ_BOOKS = array(

  'the-ai-business-enablement-audit' => array(
    'series'   => 'The Operating Discipline for AI Library&trade;',
    'title'    => 'The AI Business Enablement Audit&trade;',
    'subtitle' => 'The Operating System for Running AI as a Permanent Business Function',
    'cover'    => 'https://srjconsultingservices.com/wp-content/uploads/6x9-Front-Cover-RGB-scaled.jpg',
    'cover_alt'=> 'The AI Readiness and Performance Assessment book cover',
    'status'   => 'available',          // 'available' | 'forthcoming'
    'status_label' => 'Available Now',
    'description' => 'The diagnostic foundation of the series. A structured evaluation of how AI is currently operating across a business, what it is costing fully loaded, and whether it is producing measurable outcomes. Built for executives and boards who need a defensible understanding of their AI posture, written in plain English, no technical background required.',
    'buy_url'  => 'https://www.amazon.com/dp/B0H5M4BSYR',
    'buy_label'=> 'Buy on Amazon',
    'buy_note' => 'Hardcover. Also available in Kindle edition.',
    // Library: set 'library_base' to the uploads path to enable the worksheet
    // + chapter-graphics sections. Leave '' to omit (forthcoming books).
    'library_base' => '/wp-content/uploads/The_Operating_Discipline_for_AI/AI_Business_Enablement_Audit',

    // Optional: walkthrough video. Renders between hero and body when present.
    'video' => array(
        'youtube_id' => 'z5lEB49HyNc',
        'title_attr' => 'The AI Business Enablement Audit Framework',
        'label'      => 'Watch the 18-Minute Walkthrough',
        'headline'   => 'The full audit framework, in <em>eighteen minutes.</em>',
        'lede'       => 'A complete walkthrough of the AI Business Enablement Audit&trade; framework. The Shadow AI problem most leadership teams have not seen, the five-dimension audit, and what your business actually looks like twelve months after running it.',
        'meta'       => 'Presented by Elizabeth &middot; Script by Stephen R. Jordan &middot; 18 minutes',
    ),
    // Optional: executive briefing PDF card. Renders below the video when present.
    'briefing' => array(
        'title_html' => 'The AI Business Enablement Audit&trade;',
        'format'     => 'PDF &middot; 25 Slides',
        'lede'       => 'A condensed visual companion to the framework. The 19-tool problem, Shadow AI, the five-dimension audit, and the operating discipline executives are using to bring AI under control. Built for board distribution and leadership team review.',
        'pdf_path'   => '/wp-content/uploads/AI_Business_Enablement_Audit_Executive_Briefing.pdf',
    ),

    'body_html' => <<<'SRJBODY'
<h2>The AI Business Enablement Audit&trade; is the discipline every leadership team is now being asked to demonstrate, and <em>the one most cannot yet see clearly enough to defend.</em></h2>

<h2>The pain AI Business Enablement Audit is built to address</h2>
<p>AI tools have spread through the business one signup at a time: a subscription here, an embedded feature there, a workflow someone automated without telling anyone. No one set out to lose track of it. It simply accumulated faster than anyone thought to count. The result is an operating reality most leaders cannot describe with confidence: what AI is actually running, what it truly costs, and whether any of it is producing results.</p>
<p>The book is written for the leader who has watched AI enter the business through every door at once, has approved some of it and inherited the rest, and now has to answer the question that has arrived in every leadership room. Not what tools have been signed up for. Not how many employees have logged in. The real question: what is AI actually doing inside this business, and what is it costing?</p>
<p>Most leaders do not have a clean answer to that question right now. The gap between what leadership thinks AI is doing and what AI is actually doing inside the business is what The AI Business Enablement Audit&trade; is built to close.</p>

<h2>The question has moved from access to accountability</h2>
<p>Four stakeholders have arrived at the AI conversation, and they are asking different versions of the same question.</p>
<p>The CFO: what is AI costing fully loaded. The board: what is running, and who owns it. The auditor: is there an inventory that can be produced on request. The acquirer: is the AI footprint documented, controlled, and clean. None of those questions are answered by an adoption metric or a vendor slide deck.</p>
<p>The new executive standard is straightforward. Show what AI is actually running inside the business, not simply that AI is in use. Volume I is how that standard gets met by a leadership team running with the resources it already has.</p>

<h2>What The AI Business Enablement Audit&trade; book is</h2>
<p>Volume I is an operational execution book for the leader accountable for AI outcomes, not just AI activity. The difference between those two things is larger than it sounds. AI activity is easy to see. A dashboard fills with logos, subscriptions, and dashboards in a matter of weeks. AI outcomes are harder. They require inventorying, cost mapping, performance scoring, risk rating, and a documented view of what AI is doing to the business.</p>
<p>The book does not require a Big Four firm, a Chief AI Officer, or a dedicated analytics department. It requires the same operating discipline a leadership team already applies to finance, hiring, and vendor management, and it gives that discipline the structure to produce the baseline the business now needs to have ready.</p>
<p>Every chapter connects an AI reality to a named operating instrument. Every tool is built for a small or mid-sized business with a real budget and a lean team. Every framework is designed to produce something you can walk into a room with and defend, not just something you can read and feel good about.</p>

<h2>What you will learn from AI Business Enablement Audit</h2>
<p>How to surface every AI tool, embedded feature, and hidden subscription operating inside the business. How to price AI honestly, license cost plus supervision overhead plus rework loops plus embedded features already inside existing software. How to score performance against the outcomes AI was supposed to move. How to rate operational risk before it becomes a governance incident. How to test alignment between AI activity and business strategy so the answer to "why are we doing this" is not "because a vendor sold it."</p>
<p>The book introduces and develops the named operating instruments leadership teams use to bring AI under executive control: the AI Tool Inventory Worksheet&trade;, the AI Cost Map, the AI Performance Scorecard&trade;, the AI Operational Risk Assessment&trade;, the AI Governance Gap Analysis, the Outcome Alignment Map&trade;, the AI Operating Calendar&trade;, and the Standing AI Adoption Policy&trade; that keeps the inventory current after the audit closes. Each instrument carries a worked example and a usable template.</p>
<p>The lesson that runs through every chapter is the same. AI presence is not AI performance. A subscription is not a result. A dashboard is not a decision. A business that cannot see what AI is doing is still managing a story rather than a result.</p>

<h2>Who AI Business Enablement Audit is written for</h2>
<p>The book is written for executives and operating leaders, not engineers or data scientists. The goal is a defensible AI baseline, a fully loaded cost view, and a discipline the business can actually run.</p>
<p>The roles include owners and presidents, CEOs, CFOs, and COOs, managing partners, board members and operating partners, lenders, investors, and acquirers, and consultants advising mid-market clients. The sectors include professional services, accounting, legal, construction, manufacturing, distribution, healthcare, insurance, and financial services.</p>
<p>If you are responsible for AI outcomes, accountable for the AI budget, or in a position where someone is going to ask you to defend what AI is doing inside your business, the book is for you.</p>

<h2>How to use AI Business Enablement Audit in your business</h2>
<p>Read it with your current vendor list, your last quarter's software expense report, and the two or three AI use cases everyone in leadership already argues about, in front of you. Each chapter is designed to help you inventory one part of your AI operation, document what you find, and convert that finding into a decision your leadership team can act on.</p>
<p>The tools in the book are not meant to be read and set aside. They are meant to be used, filled in, and brought into your next leadership meeting. The seven-instrument Companion Worksheet library accompanying the book provides every artifact as an editable file, with the complete Excel workbook as the operating master.</p>
<p>The book is the first Volume in the Library and does not assume any prior work. It is designed to be run first.</p>

<h2>The case continuity across the Library</h2>
<p>The seventy-five-person construction firm, the forty-person accounting firm, and the sixty-person professional services practice are introduced here. Readers who continue into <a href="/books/ai-business-services/the-ai-readiness-performance-assessment/">Volume II</a>, <a href="/books/ai-business-services/the-ai-risk-governance-review/">Volume III</a>, and <a href="/books/ai-business-services/the-ai-efficiency-process-optimization/">Volume IV</a> will see the same case patterns continue as those businesses move from visibility (this Volume) to readiness, governance, and optimization.</p>
<p>Each composite is drawn from patterns observed across many consulting engagements spanning more than two decades of professional practice. No single composite represents a single real engagement. Every composite combines elements from multiple distinct situations, and the specific numeric details are illustrative constructions designed to convey operating patterns in concrete terms.</p>

<h2>What is inside AI Business Enablement Audit, chapter by chapter</h2>
<p><strong>Chapter 1</strong> names the Unmanaged AI Problem and shows where it lives inside a business. <strong>Chapter 2</strong> names Shadow AI, the most common specific pattern through which the problem appears. <strong>Chapter 3</strong> introduces the AI Business Enablement Audit as the operating discipline that brings both under executive control. <strong>Chapter 4</strong> builds the AI Tool Inventory, which surfaces every AI tool, embedded feature, and hidden subscription operating inside the business. <strong>Chapter 5</strong> puts a real dollar figure on The Real Cost of AI: license cost plus supervision overhead plus rework loops plus embedded features already inside existing software. <strong>Chapter 6</strong> installs AI Performance Governance&trade;, the recurring routine that scores AI against the outcomes it was supposed to move. <strong>Chapter 7</strong> installs AI Risk Management, the operating instrument that rates operational exposure before it becomes an incident. <strong>Chapter 8</strong> installs AI Governance, the structure that places accountability on named executives rather than a policy nobody reads. <strong>Chapter 9</strong> aligns AI to business strategy so activity connects to results the leadership team already tracks. <strong>Chapter 10</strong> installs operational integration, the discipline that puts AI on the same operating calendar as finance, hiring, and customer obligations. <strong>Chapter 11</strong> installs the Standing AI Adoption Policy&trade;, the recurring routine that keeps the audit current after the first pass closes. <strong>Chapter 12</strong> names the AI Operating System&trade;, the enduring structure the audit produces and the Library extends across the remaining Volumes.</p>

<h2>Where AI Business Enablement Audit sits in The Operating Discipline for AI Library&trade;</h2>
<p>Volume I is the opening book of Pillar I, AI Business Services&trade;. The four Volumes in Pillar I sequence the operating disciplines a business needs to install AI honestly: visibility (this Volume), readiness (<a href="/books/ai-business-services/the-ai-readiness-performance-assessment/">Volume II</a>), governance (<a href="/books/ai-business-services/the-ai-risk-governance-review/">Volume III</a>), and optimization (<a href="/books/ai-business-services/the-ai-efficiency-process-optimization/">Volume IV</a>). Volume I builds the foundation the rest of the Library extends. A business that finishes Volume I has the baseline every other AI decision depends on.</p>
<p><a href="/books/ai-risk-governance-security/">Pillar II, AI Risk Governance &amp; Security&trade;</a>, runs in parallel and addresses the security side of the AI Operating System&trade; through five further Volumes. The two pillars are deliberately independent.</p>

<h2>How the book and the AI Business Enablement Audit engagement work together</h2>
<p>The book is the methodology, written for leadership teams that want to run the discipline themselves. The <a href="/services/business-services/ai-business-enablement-audit/">AI Business Enablement Audit engagement</a> is the execution, designed for leadership teams that want the artifacts produced, scored, and pressure-tested against their own vendors, their own workflows, and their own cost base inside a defined engagement window.</p>
<p>Both share the same underlying operating instruments. The choice is whether to read, draft, and refine internally over six months, or to bring the firm in and have the artifacts on the table in weeks. Aligning with the <a href="https://www.nist.gov/itl/ai-risk-management-framework" rel="noopener">NIST AI Risk Management Framework</a> and <a href="https://www.iso.org/standard/81230.html" rel="noopener">ISO/IEC 42001</a> does not, by itself, produce these answers. Those frameworks define the measurement obligations. The book is the operating discipline that meets them inside a real business, with a real cost base and a lean team.</p>
SRJBODY,

    // Worksheet library (paths are relative to 'library_base').
    'worksheet_label'   => 'Companion Worksheets',
    'worksheet_heading' => 'The seven <em>audit worksheets,</em> editable and ready to use.',
    'worksheet_intro'   => 'The complete toolkit from the Appendix of the book. Download the master Excel workbook for the full audit, or grab individual templates one at a time. Each is pre-formatted with dropdowns, formulas, and conditional formatting. Works in Excel, Google Sheets, Numbers, and LibreOffice Calc.',
    'master' => array(
      'label'  => 'Recommended Starting Point',
      'name'   => 'AI Audit Worksheets, Complete Workbook',
      'detail' => 'All seven worksheets as tabs in one Excel file. 110 working formulas. SRJ-branded.',
      'file'   => '/Appendix/AI Audit Worksheets - Complete Workbook.xlsx',
      'button' => 'Download Master',
    ),
    'worksheets' => array(
      array('num' => '01', 'name' => 'AI Tool Inventory Worksheet&trade;',     'file' => '/Appendix/01_AI_Tool_Inventory_Worksheet.xlsx',   'type' => 'XLSX'),
      array('num' => '02', 'name' => 'AI Cost Map Worksheet',                  'file' => '/Appendix/02_AI_Cost_Map_Worksheet.xlsx',        'type' => 'XLSX'),
      array('num' => '03', 'name' => 'AI Performance Scorecard&trade;',         'file' => '/Appendix/03_AI_Performance_Scorecard.xlsx',     'type' => 'XLSX'),
      array('num' => '04', 'name' => 'AI Operational Risk Assessment&trade;',   'file' => '/Appendix/04_AI_Operational_Risk_Assessment.xlsx','type' => 'XLSX'),
      array('num' => '05', 'name' => 'AI Governance Gap Analysis',             'file' => '/Appendix/05_AI_Governance_Gap_Analysis.xlsx',   'type' => 'XLSX'),
      array('num' => '06', 'name' => 'Outcome Alignment Map&trade;',            'file' => '/Appendix/06_Outcome_Alignment_Map.xlsx',        'type' => 'XLSX'),
      array('num' => '07', 'name' => 'AI Operating Calendar&trade;',            'file' => '/Appendix/07_AI_Operating_Calendar.xlsx',        'type' => 'XLSX'),
      array('num' => '08', 'name' => 'Complete Appendix, Print Version',       'file' => '/Appendix/Appendix - Print Version.pdf',        'type' => 'PDF'),
    ),
    'companion_docs' => array(
      'intro' => 'The Appendix introduction and closing guidance are available as standalone Word documents for organizations that want to brief their teams or distribute the methodology internally.',
      'links' => array(
        array('label' => 'Appendix Introduction (DOCX)', 'file' => '/Appendix/Appendix Introduction.docx'),
        array('label' => 'Using the Worksheets (DOCX)',  'file' => '/Appendix/Using the Worksheets.docx'),
      ),
    ),
    // Explicit chapter map (curated labels). Omit on a book to auto-discover.
    'chapters' => array(
      'Introduction'                                 => array('id' => 'intro',      'nav_label' => 'Intro',      'heading_html' => 'Introduction'),
      'Chapter 1 - The Unmanaged AI Problem'         => array('id' => 'ch01',       'nav_label' => 'Ch 1',       'heading_html' => 'Chapter 1: <em>The Unmanaged AI Problem</em>'),
      'Chapter 2 - Shadow AI'                        => array('id' => 'ch02',       'nav_label' => 'Ch 2',       'heading_html' => 'Chapter 2: <em>Shadow AI</em>'),
      'Chapter 3 - The AI Business Enablement Audit' => array('id' => 'ch03',       'nav_label' => 'Ch 3',       'heading_html' => 'Chapter 3: <em>The AI Business Enablement Audit</em>'),
      'Chapter 4 - Building the Tool Inventory'      => array('id' => 'ch04',       'nav_label' => 'Ch 4',       'heading_html' => 'Chapter 4: <em>Building the Tool Inventory</em>'),
      'Chapter 5 - The Real Cost of AI'              => array('id' => 'ch05',       'nav_label' => 'Ch 5',       'heading_html' => 'Chapter 5: <em>The Real Cost of AI</em>'),
      'Chapter 6 - AI Performance Governance'        => array('id' => 'ch06',       'nav_label' => 'Ch 6',       'heading_html' => 'Chapter 6: <em>AI Performance Governance</em>'),
      'Chapter 7 - AI Risk Management'               => array('id' => 'ch07',       'nav_label' => 'Ch 7',       'heading_html' => 'Chapter 7: <em>AI Risk Management</em>'),
      'Chapter 8 - AI Governance'                    => array('id' => 'ch08',       'nav_label' => 'Ch 8',       'heading_html' => 'Chapter 8: <em>AI Governance</em>'),
      'Chapter 9 - Aligning AI to Business Strategy' => array('id' => 'ch09',       'nav_label' => 'Ch 9',       'heading_html' => 'Chapter 9: <em>Aligning AI to Business Strategy</em>'),
      'Chapter 10 - Operational Integration'         => array('id' => 'ch10',       'nav_label' => 'Ch 10',      'heading_html' => 'Chapter 10: <em>Operational Integration</em>'),
      'Chapter 11 - Standing AI Adoption Policy'     => array('id' => 'ch11',       'nav_label' => 'Ch 11',      'heading_html' => 'Chapter 11: <em>Standing AI Adoption Policy</em>'),
      'Chapter 12 - The AI Operating System'         => array('id' => 'ch12',       'nav_label' => 'Ch 12',      'heading_html' => 'Chapter 12: <em>The AI Operating System</em>'),
      'Conclusion'                                   => array('id' => 'conclusion', 'nav_label' => 'Conclusion', 'heading_html' => 'Conclusion'),
    ),
  ),

  'the-ai-readiness-performance-assessment' => array(
    'series'   => 'The Operating Discipline for AI Library&trade;',
    'title'    => 'The AI Readiness & Performance Assessment&trade;',
    'subtitle' => 'A Practical Operating Discipline for Scaling AI in Small and Mid-Sized Businesses',
    'cover'    => 'https://srjconsultingservices.com/wp-content/uploads/2560px-X-1600px-Kindle-Cover-RGB-1.jpg',
    'cover_alt'=> 'The AI Business Enablement Audit book cover',
    'status'   => 'available',          // 'available' | 'forthcoming'
    'status_label' => 'Available Now',
    'description' => 'The performance discipline of the series. A structured, evidence-based way to test whether the AI already running inside a business is producing measurable results, or just generating activity that looks like progress. It scores six readiness conditions into a single decision, expand, refine, or pause, so leaders stop guessing about AI and start managing it. Plain English, no engineering background required.',
    'buy_url'  => 'https://www.amazon.com/dp/B0H5X83K31',
    'buy_label'=> 'Buy on Amazon',
    'buy_note' => 'Hardcover, paperback, and Kindle editions.',
    'body_html' => <<<'SRJBODY'
<h2>The AI Readiness &amp; Performance Assessment&trade; is the discipline every leadership team is now being asked to demonstrate, and <em>the one most cannot yet apply to their own use cases.</em></h2>

<h2>The pain AI Readiness &amp; Performance Assessment is built to address</h2>
<p>AI is already inside the business. It is drafting emails, summarizing documents, and shaping client work, whether leadership planned for it or not. Adoption already happened. Performance was assumed. And somewhere in the gap between the two, money is leaking out: rework, inconsistent output, unclear ownership, and operational friction nobody sees until it becomes expensive.</p>
<p>The book is written for the leader who has watched AI enter the business, approved the tools, absorbed the friction of adoption, and now has to answer the question that has arrived in every leadership room. Not what tools are being used. Not how many employees have logged in. The real question: is the AI running inside this business actually producing measurable results, or generating activity that looks like progress?</p>
<p>Most leaders do not have a clean answer to that question right now. The gap between adoption and performance is what The AI Readiness &amp; Performance Assessment is built to close.</p>

<h2>The question has moved from adoption to performance</h2>
<p>Four stakeholders have arrived at the AI conversation, and they are asking different versions of the same question.</p>
<p>The CFO: what did AI return after cost. The board: which use cases are producing, and which are not. The operating partner: is the AI program scaling on evidence or on optimism. The acquirer: are the AI use cases documented, measured, and defensible. None of those questions are answered by an adoption metric or a usage report.</p>
<p>The new executive standard is straightforward. Show that each material AI use case is either producing measurable results or being refined toward them, not simply that AI is in use. Volume II is how that standard gets met by a leadership team running with the resources it already has.</p>

<h2>What The AI Readiness &amp; Performance Assessment book is</h2>
<p>Volume II is an operational execution book for the leader accountable for AI results, not just AI activity. The difference between those two things is larger than it sounds. AI activity is easy to see. A tool is signed up for, a workflow is automated, a dashboard fills. AI performance is harder. It requires readiness scoring across six conditions, a measurement of what AI actually returns net of the friction it creates, and a documented decision an outside party can read and accept.</p>
<p>The book does not require a Big Four firm, a Chief AI Officer, or a dedicated analytics department. It requires the same operating discipline a leadership team already applies to finance, hiring, and vendor management, and it gives that discipline the structure to produce the readiness scoring and use-case decisions the business now needs to have ready.</p>
<p>Every chapter connects an AI readiness condition to a named operating instrument. Every tool is built for a small or mid-sized business with a real budget and a lean team. Every framework is designed to produce something you can walk into a room with and defend, not just something you can read and feel good about.</p>

<h2>What you will learn from AI Readiness &amp; Performance Assessment</h2>
<p>How to score six readiness conditions on a five-point maturity scale: workflow clarity, data reliability, people readiness, leadership accountability, performance measurement, and operational friction. How to combine those six scores into a single readiness index that drives the most important AI decision a leader makes about a use case: expand, refine, controlled expansion, or pause. How to measure the Net Efficiency Yield Ratio, the discipline's core performance metric, which nets the value AI produces against the supervision, rework, and correction it creates. How to run the Operational Load Factor diagnostic that names the friction AI adds before scaling widens it.</p>
<p>The book introduces and develops the named operating instruments leadership teams use to convert AI adoption into AI performance: the Workflow Readiness Review&trade;, the Data Reliability Checklist&trade;, the AI Adoption Pattern Map&trade;, the AI Governance Matrix&trade;, the Performance Reality Test&trade; (Net Efficiency Yield Ratio), the AI Friction Diagnostic&trade; (Operational Load Factor), the Master AI Readiness Scorecard&trade;, the Use Case Decision Record&trade;, the AI Refinement Register&trade;, and the 90-Day AI Decision Action Plan&trade;. Each instrument carries a worked example and a usable template.</p>
<p>The lesson that runs through every chapter is the same. Adoption is not performance. Usage is not value. A subscription is not a return. A business that cannot measure what AI is returning net of friction is still managing a story rather than a result.</p>

<h2>Who AI Readiness &amp; Performance Assessment is written for</h2>
<p>The book is written for executives and operating leaders, not engineers or data scientists. The goal is a defensible readiness baseline, a measured performance view, and a decision protocol the business can actually run.</p>
<p>The roles include owners and presidents, CEOs, CFOs, and COOs, managing partners, board members and operating partners, lenders, investors, and acquirers, and consultants advising mid-market clients. The sectors include professional services, accounting, legal, construction, manufacturing, distribution, healthcare, insurance, and financial services.</p>
<p>If you are responsible for AI outcomes, accountable for the AI budget, or in a position where someone is going to ask you to justify which use cases are being scaled, the book is for you.</p>

<h2>How to use AI Readiness &amp; Performance Assessment in your business</h2>
<p>Read it with your AI Tool Inventory from <a href="/books/ai-business-services/the-ai-business-enablement-audit/">Volume I</a> and the two or three AI use cases everyone in leadership already argues about, in front of you. Each chapter is designed to help you score one readiness condition, measure one performance signal, or document one use-case decision, and convert that finding into a decision your leadership team can act on.</p>
<p>The tools in the book are not meant to be read and set aside. They are meant to be used, filled in, and brought into your next leadership meeting. The twenty-one-instrument Companion Worksheet library accompanying the book provides every artifact as an editable file, with the Master AI Readiness Scorecard&trade; as the operating master that combines the six condition scores into the single readiness index.</p>
<p>If you have not completed Volume I, the book still works. You will need to do some foundational inventory work as you move through the early chapters, and the book will guide you through that.</p>

<h2>The case continuity across the Library</h2>
<p>Readers who recognize the seventy-five-person construction firm, the forty-person accounting firm, and the sixty-person professional services practice from <a href="/books/ai-business-services/the-ai-business-enablement-audit/">Volume I</a> will see them again here. The case patterns are continuations of the same operating realities those businesses face as AI work moves from visibility (Volume I) to readiness (this Volume) to governance (<a href="/books/ai-business-services/the-ai-risk-governance-review/">Volume III</a>) to optimization (<a href="/books/ai-business-services/the-ai-efficiency-process-optimization/">Volume IV</a>).</p>
<p>Each composite is drawn from patterns observed across many consulting engagements spanning more than two decades of professional practice. No single composite represents a single real engagement. Every composite combines elements from multiple distinct situations, and the specific numeric details are illustrative constructions designed to convey operating patterns in concrete terms.</p>

<h2>What is inside AI Readiness &amp; Performance Assessment, chapter by chapter</h2>
<p>The book opens by naming the distinction most AI conversations skip: adoption is not performance. It then works through the six readiness conditions in sequence. <strong>Workflow clarity</strong> tests whether the workflow AI is being applied to is well-enough defined for AI to improve rather than obscure it. <strong>Data reliability</strong> tests whether the inputs AI depends on are trustworthy enough to build decisions on. <strong>People readiness</strong> tests whether the team using the tool has been prepared to catch the errors AI produces at the frequency AI produces them. <strong>Leadership accountability</strong> places named ownership on each material use case. <strong>Performance measurement</strong> installs the Net Efficiency Yield Ratio, the discipline's core metric, which nets the value AI produces against the supervision, rework, and correction it creates. <strong>Operational friction</strong> uses the Operational Load Factor to name the drag AI adds before scaling widens it. Each condition is scored on a five-point maturity scale, and the six scores combine into a single readiness index on the Master AI Readiness Scorecard&trade;. The scorecard drives the decision protocol: expand, refine, controlled expansion, or pause. The book closes with the Use Case Decision Record&trade;, the AI Refinement Register&trade;, and the 90-Day AI Decision Action Plan&trade;, which put the readiness discipline on the operating calendar so the assessment becomes a routine rather than a one-time exercise.</p>

<h2>Where AI Readiness &amp; Performance Assessment sits in The Operating Discipline for AI Library&trade;</h2>
<p>Volume II is the readiness discipline of Pillar I, AI Business Services&trade;. The four Volumes in Pillar I sequence the operating disciplines a business needs to install AI honestly: visibility (<a href="/books/ai-business-services/the-ai-business-enablement-audit/">Volume I</a>), readiness (this Volume), governance (<a href="/books/ai-business-services/the-ai-risk-governance-review/">Volume III</a>), and optimization (<a href="/books/ai-business-services/the-ai-efficiency-process-optimization/">Volume IV</a>). Volume I builds the AI inventory. Volume II sorts that inventory into what should be scaled, what should be refined, and what should be paused. Volumes III and IV extend the readiness decisions into governance and performance.</p>
<p><a href="/books/ai-risk-governance-security/">Pillar II, AI Risk Governance &amp; Security&trade;</a>, runs in parallel and addresses the security side of the AI Operating System&trade; through five further Volumes. The two pillars are deliberately independent.</p>

<h2>How the book and the AI Readiness &amp; Performance Assessment engagement work together</h2>
<p>The book is the methodology, written for leadership teams that want to run the discipline themselves. The <a href="/services/business-services/ai-readiness-performance-assessment/">AI Readiness &amp; Performance Assessment engagement</a> is the execution, designed for leadership teams that want the six readiness scores produced, the Net Efficiency Yield Ratio measured against their own workflows, and the expand-refine-controlled-expansion-pause decisions pressure-tested against their own use cases inside a defined engagement window.</p>
<p>Both share the same underlying operating instruments. The choice is whether to read, draft, and refine internally over six months, or to bring the firm in and have the readiness scorecard on the table in weeks. Aligning with the <a href="https://www.nist.gov/itl/ai-risk-management-framework" rel="noopener">NIST AI Risk Management Framework</a> and <a href="https://www.iso.org/standard/81230.html" rel="noopener">ISO/IEC 42001</a> does not, by itself, produce these answers. Those frameworks define the measurement obligations. The book is the operating discipline that meets them inside a real business, with a real cost base and a lean team.</p>
SRJBODY,
    'library_base' => '/wp-content/uploads/The_Operating_Discipline_for_AI/AI_Readiness_and_Performance_Assessment',

    // Optional: walkthrough video. Renders between hero and body when present.
    'video' => array(
        'youtube_id' => 'i0xvvJaoJqQ',
        'title_attr' => 'The AI Readiness & Performance Assessment&trade; Framework',
        'label'      => 'Watch the 15-Minute Walkthrough',
        'headline'   => 'The full readiness framework, in <em>fifteen minutes.</em>',
        'lede'       => 'A complete walkthrough of the AI Readiness &amp; Performance Assessment&trade; framework. Why adoption is not the same as performance, the six conditions executives must score, and the Expand, Refine, or Pause decision the framework produces.',
        'meta'       => 'Presented by Elizabeth &middot; Script by Stephen R. Jordan &middot; 15 minutes',
    ),
    // Optional: executive briefing PDF card. Renders below the video when present.
    'briefing' => array(
        'title_html' => 'The AI Readiness &amp; Performance Assessment&trade;',
        'format'     => 'PDF &middot; 27 Slides',
        'lede'       => 'A condensed visual companion to the framework. The performance gap, the six readiness conditions, the Net Efficiency Yield Ratio, and the Expand, Refine, or Pause decision protocol leadership teams use to scale AI on evidence. Built for board distribution and leadership team review.',
        'pdf_path'   => '/wp-content/uploads/srj_volume2_executive_briefing.pdf',
    ),

    // Files are already web-sized, so the preview helper serves them directly.
    'worksheet_label'   => 'Companion Worksheets',
    'worksheet_heading' => 'Every <em>assessment instrument,</em> editable and ready to use.',
    'worksheet_intro'   => 'Every assessment instrument from the book, free and editable, ready to use in a live readiness assessment. Fill in the worksheets and the scores and decisions calculate automatically. Works in Excel, Google Sheets, Numbers, and LibreOffice Calc.',
    'master' => array(
      'label'  => 'Recommended Starting Point',
      'name'   => 'Master AI Readiness Scorecard',
      'detail' => 'Enter your six condition scores; the readiness index and the recommended decision, expand, refine, controlled expansion, or pause, calculate automatically.',
      'file'   => '/Appendix/07_Master_AI_Readiness_Scorecard.xlsx',
      'button' => 'Download Scorecard',
    ),
    'worksheets' => array(
      array('num' => '01', 'name' => 'Workflow Readiness Review',            'file' => '/Appendix/01_Workflow_Readiness_Review.xlsx',                'type' => 'XLSX'),
      array('num' => '02', 'name' => 'Data Reliability Checklist',           'file' => '/Appendix/02_Data_Reliability_Checklist.xlsx',               'type' => 'XLSX'),
      array('num' => '03', 'name' => 'AI Adoption Pattern Map',              'file' => '/Appendix/03_AI_Adoption_Pattern_Map.xlsx',                  'type' => 'XLSX'),
      array('num' => '04', 'name' => 'AI Governance Matrix',                 'file' => '/Appendix/04_AI_Governance_Matrix.xlsx',                     'type' => 'XLSX'),
      array('num' => '05', 'name' => 'Performance Reality Test (NEYR)',      'file' => '/Appendix/05_Performance_Reality_Test_NEYR.xlsx',            'type' => 'XLSX'),
      array('num' => '06', 'name' => 'AI Friction Diagnostic (OLF)',         'file' => '/Appendix/06_AI_Friction_Diagnostic_OLF.xlsx',               'type' => 'XLSX'),
      array('num' => '08', 'name' => 'Use Case Decision Record',             'file' => '/Appendix/08_Use_Case_Decision_Record.xlsx',                 'type' => 'XLSX'),
      array('num' => '09', 'name' => 'AI Readiness Attestation Sheet',       'file' => '/Appendix/09_AI_Readiness_Attestation_Sheet.xlsx',           'type' => 'XLSX'),
      array('num' => '10', 'name' => 'Decision Control Matrix',              'file' => '/Appendix/10_Decision_Control_Matrix.xlsx',                  'type' => 'XLSX'),
      array('num' => '11', 'name' => '90-Day AI Decision Action Plan',       'file' => '/Appendix/11_90_Day_AI_Decision_Action_Plan.xlsx',           'type' => 'XLSX'),
      array('num' => '12', 'name' => 'AI Refinement Register',               'file' => '/Appendix/12_AI_Refinement_Register.xlsx',                   'type' => 'XLSX'),
      array('num' => '13', 'name' => 'AI Stakeholder Communication Matrix',  'file' => '/Appendix/13_AI_Stakeholder_Communication_Matrix.xlsx',      'type' => 'XLSX'),
      array('num' => '14', 'name' => 'AI Third-Party Governance Statement',  'file' => '/Appendix/14_AI_Third_Party_Governance_Statement.xlsx',      'type' => 'XLSX'),
      array('num' => '15', 'name' => 'Repeatable Governance Framework',      'file' => '/Appendix/15_Repeatable_Governance_Framework.xlsx',          'type' => 'XLSX'),
      array('num' => '16', 'name' => 'Weekly AI Operational Spot Check Log', 'file' => '/Appendix/16_Weekly_AI_Operational_Spot_Check_Log.xlsx',     'type' => 'XLSX'),
      array('num' => '17', 'name' => 'AI Output Review Exception Log',       'file' => '/Appendix/17_AI_Output_Review_Exception_Log.xlsx',           'type' => 'XLSX'),
      array('num' => '18', 'name' => 'Approved AI Tool Register',            'file' => '/Appendix/18_Approved_AI_Tool_Register.xlsx',                'type' => 'XLSX'),
      array('num' => '19', 'name' => 'AI Use Case Custodian Log',            'file' => '/Appendix/19_AI_Use_Case_Custodian_Log.xlsx',                'type' => 'XLSX'),
      array('num' => '20', 'name' => 'Bi-Annual AI Readiness Reassessment Log','file' => '/Appendix/20_Bi_Annual_AI_Readiness_Reassessment_Log.xlsx', 'type' => 'XLSX'),
      array('num' => '21', 'name' => 'Master 90-Day Execution Matrix',       'file' => '/Appendix/21_Master_90_Day_Execution_Matrix.xlsx',           'type' => 'XLSX'),
    ),
    // No standalone companion DOCX for this volume; omit the block.
    'companion_docs' => array(),
    // No explicit chapter map: chapter graphics auto-discover from library_base.
  ),

  /* ========================================================================
     SECURITY IN THE AGE OF AI — Books 07/08/09 of Pillar II (added v1.28, June 2026)
     Books 3-5 of 5 in AI Risk Governance & Security&trade;, part of
     The Operating Discipline for AI Library&trade;.
     All three are forthcoming. No library, video, or briefing yet.
     ======================================================================== */

  'the-secure-by-design' => array(
    'series'   => 'The Operating Discipline for AI Library&trade;',
    'title'    => 'Secure by Design in the Age of AI&trade;',
    'subtitle' => 'The Product Security Operating Model for the AI Era',
    'status'   => 'forthcoming',
    'status_label' => 'Forthcoming',
    'description' => 'Book 07 of 9 in The Operating Discipline for AI Library&trade;, Book 3 of 5 in AI Risk Governance &amp; Security&trade;. Secure by Design has changed from a compliance posture into a capacity problem. Engineering velocity has increased by an order of magnitude. Security review capacity has not. At the same time, AI introduces a class of vulnerabilities that traditional, deterministic tools are structurally unable to detect. This book introduces The Dual-Impedance Problem and provides the working frameworks executives need to ship AI-enabled products faster and more securely than the organizations they compete with.',
    'buy_url'  => '',
    'buy_label'=> 'Buy on Amazon',
    'buy_note' => '',
    'forthcoming_note' => 'Secure by Design in the Age of AI&trade; is forthcoming as Book 07 of 9 in The Operating Discipline for AI Library&trade;, Book 3 of 5 in AI Risk Governance &amp; Security&trade;. Be the first to know when it launches, subscribe to The AI Operating System newsletter for the launch announcement, advance excerpts, and the methodology behind the framework.',
    'body_html' => <<<'SRJBODY'
<h2>AI has changed product security from a quality function into <em>a capacity problem.</em></h2>
<p>Two forces compound at once. Engineering velocity has increased by an order of magnitude while security review capacity has not, opening a widening gap between how fast products are built and how fast they can be reasonably secured. Layered on top of that velocity gap, AI introduces a fundamentally different class of risk: vulnerabilities that exist at the meaning layer, not the syntax layer, where deterministic tooling cannot reliably find them. Most organizations are quietly shipping AI-enabled products faster than they can secure them, and learning about the gap from customers, regulators, or breach disclosures.</p>
<p>This book names that combined condition The Dual-Impedance Problem and treats it as the strategic context every product organization now operates inside. Organizations that solve it use AI to close the security capacity gap and build structural boundaries around AI's new failure modes. Organizations that do not ship faster, accumulate undetected risk, and discover it from the outside.</p>
<h3>What this book gives you</h3>
<p>At its center are five working frameworks executives can apply directly: The Product Attack Surface Taxonomy&trade; (where product risk lives across seven layers, extended to include AI-native components); The AI-Caused Vulnerability Model&trade; (the seven sources of AI-introduced risk, scored against the organization's actual product stack); The Action Boundary Model&trade; (a four-tier classification of what an AI system may read, decide, recommend, and execute); The AI Product Security Lifecycle&trade; (the integrated operating model that merges existing SDLC and DevSecOps with AI-specific controls); and The Secure AI Release Gate&trade; (the release-readiness artifact that consolidates threat modeling, output validation, prompt injection coverage, agent boundary documentation, model provenance, and incident response readiness).</p>
<p>The frameworks are aligned with the CISA Secure by Design program, OWASP LLM Top 10, NIST SSDF, and emerging AI regulation. They produce decisions defensible to a board, an auditor, or a regulator, not a slide deck.</p>
<h3>Who it's for</h3>
<p>CISOs, CTOs, VPs of Engineering and Product, security architects, board members, and compliance officers in organizations shipping AI-enabled products to enterprise customers or regulated industries. No technical background required for the executive deliverables; engineering-grade depth available for the architects and senior engineers who will own the implementation.</p>
SRJBODY,
    'library_base' => '',
  ),

  'the-application-security' => array(
    'series'   => 'The Operating Discipline for AI Library&trade;',
    'title'    => 'Application Security in the Age of AI&trade;',
    'subtitle' => 'The AppSec Program for a Probabilistic Runtime',
    'status'   => 'forthcoming',
    'status_label' => 'Forthcoming',
    'description' => 'Book 08 of 9 in The Operating Discipline for AI Library&trade;, Book 4 of 5 in AI Risk Governance &amp; Security&trade;. Every application security tool in production today was built on a quiet assumption: that an application produces the same output for the same input. AI features have invalidated that assumption, and most AppSec programs do not yet realize it. This book introduces The Runtime Determinism Gap and provides the working frameworks AppSec leaders need to rebuild their program for applications that no longer behave deterministically.',
    'buy_url'  => '',
    'buy_label'=> 'Buy on Amazon',
    'buy_note' => '',
    'forthcoming_note' => 'Application Security in the Age of AI&trade; is forthcoming as Book 08 of 9 in The Operating Discipline for AI Library&trade;, Book 4 of 5 in AI Risk Governance &amp; Security&trade;. Be the first to know when it launches, subscribe to The AI Operating System newsletter for the launch announcement, advance excerpts, and the methodology behind the framework.',
    'body_html' => <<<'SRJBODY'
<h2>Applications that pass every existing scan can still <em>fail in production.</em></h2>
<p>The moment an application calls a language model, retrieves dynamic context, or hands control to an autonomous agent, the entire AppSec stack starts seeing partial behavior. Scans pass. Runtime defenses match patterns that no longer reflect what the application actually does. Bug bounties pay for reproducible exploits in an environment where reproducibility has become probabilistic. The result is a program that looks healthy on every dashboard while the actual risk profile of the product portfolio drifts somewhere the program cannot see.</p>
<p>This book names that condition The Runtime Determinism Gap and treats it as the single most important shift in application security since the move to cloud. Teams that close the gap use AI to compress the review and triage cycles they have been losing for a decade, and they rebuild their runtime defenses around behavioral validation rather than pattern matching. Teams that do not keep shipping applications that pass every existing scan and still fail in production.</p>
<h3>What this book gives you</h3>
<p>At its center are five working frameworks AppSec leaders can apply directly: The Behavioral Attack Surface&trade; (the application surface areas that change once AI is introduced); The Semantic Vulnerability Class&trade; (the bug taxonomy that exists at the meaning layer and how it extends OWASP Top 10 and OWASP LLM Top 10); The AppSec Capacity Equation&trade; (the math of vulnerability management when AI changes both the production rate of code and the inspection rate of security); The AI Application Security Lifecycle&trade; (the integrated operating model that merges DevSecOps with AI-specific controls); and The Continuous Validation Loop&trade; (the release-and-runtime model that replaces point-in-time scanning with ongoing behavioral validation).</p>
<p>The frameworks are aligned with OWASP LLM Top 10, the Google Secure AI Framework (SAIF), and emerging AI procurement expectations. They land inside existing DevSecOps cadence without breaking release velocity.</p>
<h3>Who it's for</h3>
<p>AppSec leaders and program managers, security architects, senior developers and tech leads, DevSecOps and platform engineers, CISOs and security directors, and product engineering managers in organizations shipping AI-enabled applications. Precise enough that a principal engineer respects it, accessible enough that a VP of Engineering walks into a Monday review with a specific list of questions.</p>
SRJBODY,
    'library_base' => '',
  ),

  'the-cloud-infrastructure-security' => array(
    'series'   => 'The Operating Discipline for AI Library&trade;',
    'title'    => 'Cloud and Infrastructure Security in the Age of AI&trade;',
    'subtitle' => 'Governance for a Cloud Where the Majority of Actors Are Not Human',
    'status'   => 'forthcoming',
    'status_label' => 'Forthcoming',
    'description' => 'Book 09 of 9 in The Operating Discipline for AI Library&trade;, Book 5 of 5 in AI Risk Governance &amp; Security&trade;. Cloud security was built on a single premise: that every meaningful action could be traced to an accountable human. AI has broken that premise in three places at once: non-human identities now outnumber human ones by an order of magnitude, infrastructure changes happen at machine pace while approval and audit operate at human pace, and the audit chain no longer cleanly answers who did this, on whose behalf, with what authorization. This book introduces The Sovereignty Problem and provides the working frameworks cloud security leaders need to catch up.',
    'buy_url'  => '',
    'buy_label'=> 'Buy on Amazon',
    'buy_note' => '',
    'forthcoming_note' => 'Cloud and Infrastructure Security in the Age of AI&trade; is forthcoming as Book 09 of 9 in The Operating Discipline for AI Library&trade;, Book 5 of 5 in AI Risk Governance &amp; Security&trade;. Be the first to know when it launches, subscribe to The AI Operating System newsletter for the launch announcement, advance excerpts, and the methodology behind the framework.',
    'body_html' => <<<'SRJBODY'
<h2>The majority of actors in your cloud accounts are <em>no longer human.</em></h2>
<p>Three breaks happened simultaneously and they are inseparable. The identity ratio inverted: non-human identities now outnumber human ones by an order of magnitude, and the trend continues. Infrastructure pace outran governance pace: changes that used to take a person an hour now happen in seconds across thousands of resources, while the approval and audit processes designed to govern them still operate at human pace. And the accountability chain that cloud audit logs exist to preserve no longer has a clean answer to its central question when the actor is an AI agent operating on behalf of a workflow that itself was triggered by another agent.</p>
<p>This book names that combined condition The Sovereignty Problem and treats it as the defining cloud security shift of this technology cycle. Teams that solve it use AI to finally compress the identity, posture, and threat detection work that has been crushing them for a decade, and they rebuild their governance model around the new reality. Teams that do not operate cloud environments where the audit log no longer answers the question it was designed to answer, and they will not realize it until a regulator, customer, or incident makes them.</p>
<h3>What this book gives you</h3>
<p>At its center are five working frameworks cloud security leaders can apply directly: The Cloud Attack Surface Map&trade; (the surface extended to include AI workloads, agent identities, model artifacts, and machine-paced change vectors); The Non-Human Identity Equation&trade; (the model for governing the identity explosion through classification, lifecycle, scoping, and accountability); The Blast Radius Calculus&trade; (the framework for evaluating risk in machine-paced environments, where small actions can produce catastrophic outcomes routinely); The AI Cloud Security Lifecycle&trade; (the integrated operating model that merges cloud security operations with AI-specific controls); and The Cloud Sovereignty Score&trade; (the maturity model and assessment tool, a defensible way to measure whether a cloud security program has caught up to the AI era).</p>
<p>The frameworks integrate with existing CSPM, CNAPP, CIEM, and SIEM investments rather than replacing them, and align with NIST SP 800-207 Zero Trust Architecture, the CSA Cloud Controls Matrix, and emerging cloud audit standards.</p>
<h3>Who it's for</h3>
<p>Cloud security architects, CSPM/CNAPP/CIEM operators, platform engineering leaders, identity and IAM teams, SRE and DevOps leaders, CISOs with significant cloud footprint, and compliance and audit leaders preparing for the next wave of cloud audit requirements. Precise enough that a principal cloud engineer respects it, accessible enough that a VP of Platform Engineering reads it on the plane.</p>
SRJBODY,
    'library_base' => '',
  ),

  'the-ai-it-security-audit' => array(
    'series'   => 'The Operating Discipline for AI Library&trade;',
    'title'    => 'The AI IT Security Audit&trade;',
    'subtitle' => 'A CISO-Grade Framework for Finding, and Fixing, the AI Exposure Your Dashboards Cannot See',
    'status'   => 'forthcoming',
    'status_label' => 'Forthcoming',
    'description' => 'Book 05 of 9 in The Operating Discipline for AI Library&trade;, and the opening Volume of Pillar II, AI Risk Governance &amp; Security&trade;. Every executive accountable for AI is about to be asked a question they cannot yet answer with evidence: can you prove your AI exposure is known, controlled, and governed? This is the audit framework that produces the answer. The Visibility Triangle&trade; surfaces what no dashboard shows. The Six-Domain Operating View walks the CISO portfolio in the order it actually runs. The Defensible AI Security Baseline&trade; is the dated, scored standard you re-test yourself against. Seventeen chapters, eighteen operating instruments, and a ninety-day plan.',
    'buy_url'  => '',
    'buy_label'=> 'Buy on Amazon',
    'buy_note' => '',
    'forthcoming_note' => 'The AI IT Security Audit is forthcoming as Book 05 of 9 in The Operating Discipline for AI Library&trade;. The eighteen operating instruments from the Consulting Toolkit are already available below, free and editable, so the work can start before the book ships. Subscribe to The AI Operating System newsletter for the launch announcement and advance excerpts.',
    'body_html' => <<<'SRJBODY'
<h2>Every dashboard is green. <em>That is the problem.</em></h2>

<h2>The pain The AI IT Security Audit is built to address</h2>
<p>The board will ask it. An enterprise customer will ask it in a security questionnaire. A regulator will ask it in an examination. A carrier will ask it in an underwriting review. The question takes different forms, but underneath it is always the same question: can you prove your AI exposure is known, controlled, and governed?</p>
<p>Most security leaders cannot. Not because the program is weak, but because the dashboards were built before the question existed. AI does not invent new attack surfaces from scratch. It accelerates existing ones, lowers the cost of attacks that used to require expertise, and introduces a class of vulnerability that traditional tooling does not detect: prompt injection, model poisoning, training data exposure, agent privilege escalation. The result is a posture that looks healthy on every existing dashboard while the actual exposure profile of the business drifts somewhere the program cannot see.</p>
<p>This book names that condition. The green dashboard fallacy is the belief that because every existing security dashboard shows green, the organization&rsquo;s AI exposure is being watched. The greatest AI security risk is not that the organization is undefended. It is that leadership believes the existing program is already looking.</p>

<h2>The question has moved from defense to evidence</h2>
<p>There is a distinction running through this Volume that most security programs have not yet absorbed. The security problem and the evidence problem are not the same problem.</p>
<p>A program can be genuinely well defended and still fail the question, because it cannot produce the artifact. A regulator does not accept confidence. An underwriter does not price assurance. An acquirer does not buy a verbal account of the controls. Each of them asks for something dated, documented, and reviewable, and a security team that has never been asked for that has never built it.</p>
<p>The audit method in this book is built to produce evidence, not comfort. Every chapter ends in an artifact. Every artifact is designed to survive being handed across a table.</p>

<h2>What The AI IT Security Audit book is</h2>
<p>Volume V is an execution manual for the executive who will be asked the question first: the CISO, the CIO, the Chief Risk Officer, and the General Counsel. It is the opening Volume of Pillar II, AI Risk Governance &amp; Security&trade;, and it is a security book, not a governance book. Where <a href="/books/ai-business-services/the-ai-risk-governance-review/">Volume III</a> makes the AI program defensible to a regulator, Volume V makes it defensible to an adversary and to the auditor who arrives afterward.</p>
<p>It does not assume a large security team, a dedicated AI security function, or a budget that has already been approved. It assumes a CISO with an existing program, a real portfolio, a lean team, and a board that is about to start asking harder questions than it asked last year.</p>

<h2>The three frameworks that run the entire audit</h2>
<p><strong>The Visibility Triangle&trade;</strong> is the flagship diagnostic. It divides AI exposure into three zones: what the program sees, what it suspects, and what it cannot detect. Six questions, one per domain, surface what no dashboard would ever show. Honest gaps are more useful than false completeness, and the Triangle is built to produce them.</p>
<p><strong>The Six-Domain Operating View</strong> is the spine. Governance, security operations, architecture, application security, third-party risk, and data protection, walked in the order a CISO portfolio actually runs, and in the order the companion audit engagement runs. Domain coverage is what prevents blind spots; a partial audit is how an exposure survives an audit.</p>
<p><strong>The Defensible AI Security Baseline&trade;</strong> is the exit standard. It is the minimum an organization must hold across inventory, access, data, vendors, incidents, governance, and evidence to answer the core question with proof. It is scored, it is dated, and it is what the organization re-tests itself against annually.</p>

<h2>What you will learn from The AI IT Security Audit</h2>
<p>How to build a four-layer AI inventory that finds sanctioned, shadow, embedded, and agentic AI, including the AI nobody procured. How to build a Non-Human Identity Inventory of every identity that can act, because the IAM stack was never designed for agents. How to document what each agent is permitted to do in an Agent Boundary Matrix, and why prompt injection is best understood as privilege escalation rather than as a content problem.</p>
<p>How to retune the SOC for threats that did not exist last year, and why the patching SLA that worked last year is now a liability. How to classify vendors by access depth rather than by spend, and how to catch the silent AI upgrade that a point-in-time vendor review will always miss. How to trace every sensitive data path through every AI system, including the cross-border inference nobody filed a report on.</p>
<p>Then how to assemble it. The Four-Page Board Pack, the Regulatory Crosswalk that answers every external inquiry from one document, and the dated Baseline that scores the posture. And finally how to defend the budget, work with the four external audiences who will ask for the same artifacts in four different ways, and convert an engagement into an operating program that survives the next CISO.</p>

<h2>Every chapter ends with something you can use the next morning</h2>
<p>Each domain chapter closes the same way. The <strong>Board Question</strong> a director would actually ask. The <strong>Evidence Required</strong> to answer it. The <strong>Common Failure Pattern</strong> drawn from field engagements. And the <strong>30-Day Move</strong>, sized so any organization can begin before the next board cycle.</p>
<p>The book references NIST SP 800-207, the NIST AI Risk Management Framework, the OWASP LLM Top 10, MITRE ATLAS, and the SEC cybersecurity disclosure rules where they bind, without ever becoming a framework walk-through. The frameworks serve the audit. The audit does not serve the frameworks.</p>

<h2>The chapter that most security books will not write</h2>
<p>Chapter 12 turns the audit on the security function itself. The SOC has AI in it. Threat hunting has AI in it. Vulnerability triage, code review, incident response, and the security team&rsquo;s own coding assistants all have AI in them. Every question this book asks of the business applies with equal force to the tools the security team uses to defend it.</p>
<p>A CISO who audits the business and exempts the security stack has not run an audit. They have run an inspection of somebody else.</p>

<h2>Who The AI IT Security Audit is written for</h2>
<p>The executive accountable when the AI exposure question lands: the CISO, the CIO, the Chief Risk Officer, and the General Counsel. The secondary reader is the audit committee chair and the board director with technology oversight, who will be asked before anyone else and will have the least time to prepare.</p>
<p>The audit is deliberately built to be run as a coalition rather than by one function. Chapter 14 names the five roles and what each actually owns, because the solo audit fails predictably: the CISO cannot compel the business, the General Counsel cannot assess the architecture, and the CFO will not fund a gap nobody has translated into money.</p>

<h2>How to use The AI IT Security Audit in your business</h2>
<p>Read it with your existing asset inventory, your vendor list, your incident response plan, and your last board security update in front of you. The book is designed to be run, not read. Chapter 13 sequences the first ninety days into a working plan: the week-one mandate, discovery in weeks two through four, inventory in weeks five and six, the six domain audits in weeks seven through ten, and assembly in weeks eleven and twelve.</p>
<p>The eighteen instruments in the Consulting Toolkit below are the working material of that plan. They are free, editable, and available now, before the book ships. Start with the Visibility Triangle Worksheet. It will tell you, in an afternoon, how much of your AI exposure your program can currently see.</p>

<h2>What is inside The AI IT Security Audit, chapter by chapter</h2>
<p><strong>Chapter 1</strong> names the green dashboard fallacy and the six faces of AI exposure the existing dashboards were never built to see. <strong>Chapter 2</strong> introduces the three frameworks that run the entire audit: the Visibility Triangle&trade;, the Six-Domain Operating View, and the Defensible AI Security Baseline&trade;. <strong>Chapter 3</strong> puts AI risk on the register where it belongs and reconciles the CISO and General Counsel views into one regulatory posture instead of two. <strong>Chapter 4</strong> builds the four-layer AI inventory: sanctioned, shadow, embedded, and agentic. <strong>Chapter 5</strong> maps the new perimeter nobody is watching, non-human identity and agent governance, and treats prompt injection as the privilege escalation it actually is.</p>
<p><strong>Chapter 6</strong> retunes security operations for AI-native threats, the compressed exploit window, and an incident response addendum that routes AI incidents to the right response. <strong>Chapter 7</strong> bounds the attack surface at the design layer, with secure AI architecture patterns, provenance, and Zero Trust for AI traffic. <strong>Chapter 8</strong> secures what the business built and what the vendors shipped, through threat modeling, a hands-on vulnerability audit sequence, adversarial testing, and MLOps lifecycle governance. <strong>Chapter 9</strong> audits the vendors who are already inside the perimeter, classifying them by access depth and monitoring for the silent upgrade. <strong>Chapter 10</strong> governs the data AI is already using, because prompts are data and the DLP stack was never tuned for it.</p>
<p><strong>Chapter 11</strong> is the assembly phase: the Four-Page Board Pack, the Regulatory Crosswalk, and the dated Baseline. <strong>Chapter 12</strong> holds the security team&rsquo;s own AI tools to the standard it demands of the business. <strong>Chapter 13</strong> sequences the first ninety days. <strong>Chapter 14</strong> builds the coalition of CISO, CIO, CRO, and General Counsel. <strong>Chapter 15</strong> defends the budget and builds the multi-year program, including the ROI conversation you cannot win and the one you can. <strong>Chapter 16</strong> shows how the same artifacts survive four external audiences: the regulator, the insurer, the enterprise customer, and the auditor. <strong>Chapter 17</strong> converts the engagement into an operating rhythm that survives the next CISO.</p>

<h2>Where The AI IT Security Audit sits in The Operating Discipline for AI Library&trade;</h2>
<p>Volume V opens <a href="/books/ai-risk-governance-security/">Pillar II, AI Risk Governance &amp; Security&trade;</a>, the five-Volume security arc of the Library. It is the diagnostic. <a href="/books/ai-risk-governance-security/the-ai-it-security-implementation-strategy/">Volume VI</a> is the buildout that follows: the governance framework, the risk register integration, the board reporting, and the operating cadence. Volumes VII, VIII, and IX go deeper into product security, application security, and the cloud and infrastructure layer AI runs on.</p>
<p><a href="/books/ai-business-services/">Pillar I, AI Business Services&trade;</a>, runs in parallel and addresses the business side of the AI Operating System&trade; through four Volumes. The two pillars are deliberately independent. A CISO can run Volume V without having read Volume I, and a CEO can run Volume I without having read Volume V. The two meet at the board table.</p>

<h2>How the book and the AI IT Security Audit engagement work together</h2>
<p>The book is the methodology, written for security leaders who want to run the audit themselves. The <a href="/services/risk-governance-security/ai-it-security-audit/">AI IT Security Audit engagement</a> is the execution, designed for organizations that want the six domains audited, the exposure scored, and the Board Pack on the table inside a defined window rather than across two quarters of internal effort.</p>
<p>Both run the same method and produce the same artifacts. The choice is whether to run it internally with the toolkit and the ninety-day plan, or to bring the firm in and have the dated Baseline ready before the next board cycle, the next carrier renewal, or the next enterprise security questionnaire. Aligning to <a href="https://www.nist.gov/itl/ai-risk-management-framework" rel="noopener">the NIST AI Risk Management Framework</a> and <a href="https://www.iso.org/standard/81230.html" rel="noopener">ISO/IEC 42001</a> does not, by itself, produce the evidence. Those frameworks define what good looks like. The audit is the discipline that proves you have it.</p>

<h2>There is a window, and it is closing</h2>
<p>There is a short period in which an organization can define its AI security posture on its own terms, at its own pace, against a standard it set itself. After that, the timeline belongs to whoever asks the question first: the regulator, the carrier, the customer, or the board. The organizations that run the audit now will hand over an artifact. The ones that wait will write one under a deadline somebody else chose.</p>
SRJBODY,

    'library_base' => '/wp-content/uploads/The_Operating_Discipline_for_AI/The_AI_IT_Security_Audit/Graphics',

    // Video walkthrough: omitted until provided. To enable, uncomment and fill.
    // 'video' => array( 'youtube_id' => '...', 'title_attr' => '...', 'label' => '...', 'headline' => '...', 'lede' => '...', 'meta' => '...' ),

    // Executive briefing PDF: omitted until provided. Uncomment when the asset ships.
    // 'briefing' => array( 'title_html' => '...', 'format' => '...', 'lede' => '...', 'pdf_path' => '...' ),

    // ---- Consulting Toolkit (18 instruments, A through R) -------------------
    // Paths are relative to 'library_base'. The folder name contains spaces;
    // esc_url() encodes them, and Book 04 already proved this path shape works.
    //
    // NOTE: the Toolkit folder on the server ALSO still contains 29 leftover
    // Volume IV files (timestamped 8:53 PM, Toolkit_A_The_AI_Efficiency_Gap
    // and friends). They are not listed here, so they do not render, but they
    // should be deleted from the server. Only the 18 Volume V instruments
    // below are wired.
    'worksheet_label'   => 'The Consulting Toolkit',
    'worksheet_heading' => 'Every <em>audit instrument,</em> editable and ready to run.',
    'worksheet_intro'   => 'The eighteen operating instruments from the book, free and editable, ready to use in a live AI IT Security Audit. These are the working material of the ninety-day plan, not reading material. Works in Microsoft Excel, Google Sheets, Apple Numbers, and LibreOffice Calc.',
    'master' => array(
      'label'  => 'Recommended Starting Point',
      'name'   => 'The Visibility Triangle Worksheet',
      'detail' => 'The flagship diagnostic. Divides AI exposure into what your program sees, what it suspects, and what it cannot detect, and asks the six questions, one per domain, that surface what no dashboard would ever show. Run this first. It will tell you in an afternoon how much of your AI exposure you can currently see.',
      'file'   => '/The Consulting Toolkit Workfiles/Toolkit_B_The_Visibility_Triangle_Worksheet.xlsx',
      'button' => 'Download the Diagnostic',
    ),
    'worksheets' => array(
      array('num' => 'A', 'name' => 'The Six Faces of AI Exposure Diagnostic',                  'file' => '/The Consulting Toolkit Workfiles/Toolkit_A_The_Six_Faces_of_AI_Exposure_Diagnostic.xlsx',                  'type' => 'XLSX'),
      array('num' => 'C', 'name' => 'The Six-Domain Operating View Coverage Map',               'file' => '/The Consulting Toolkit Workfiles/Toolkit_C_The_Six_Domain_Operating_View_Coverage_Map.xlsx',               'type' => 'XLSX'),
      array('num' => 'D', 'name' => 'The AI Risk Register Entry',                               'file' => '/The Consulting Toolkit Workfiles/Toolkit_D_The_AI_Risk_Register_Entry.xlsx',                               'type' => 'XLSX'),
      array('num' => 'E', 'name' => 'The AI Insurance and Risk-Transfer Pack',                  'file' => '/The Consulting Toolkit Workfiles/Toolkit_E_The_AI_Insurance_and_Risk_Transfer_Pack.xlsx',                  'type' => 'XLSX'),
      array('num' => 'F', 'name' => 'The AI Accountability Matrix',                             'file' => '/The Consulting Toolkit Workfiles/Toolkit_F_The_AI_Accountability_Matrix.xlsx',                             'type' => 'XLSX'),
      array('num' => 'G', 'name' => 'The Four-Layer AI Inventory',                              'file' => '/The Consulting Toolkit Workfiles/Toolkit_G_The_Four_Layer_AI_Inventory.xlsx',                              'type' => 'XLSX'),
      array('num' => 'H', 'name' => 'The Non-Human Identity Inventory',                         'file' => '/The Consulting Toolkit Workfiles/Toolkit_H_The_Non_Human_Identity_Inventory.xlsx',                         'type' => 'XLSX'),
      array('num' => 'I', 'name' => 'The Agent Boundary Matrix',                                'file' => '/The Consulting Toolkit Workfiles/Toolkit_I_The_Agent_Boundary_Matrix.xlsx',                                'type' => 'XLSX'),
      array('num' => 'J', 'name' => 'The MCP Server and Plugin Credential Register',            'file' => '/The Consulting Toolkit Workfiles/Toolkit_J_The_MCP_Server_and_Plugin_Credential_Register.xlsx',            'type' => 'XLSX'),
      array('num' => 'K', 'name' => 'The AI Incident Response Addendum and Red Button Procedure','file' => '/The Consulting Toolkit Workfiles/Toolkit_K_The_AI_Incident_Response_Addendum_and_Red_Button_Procedure.xlsx','type' => 'XLSX'),
      array('num' => 'L', 'name' => 'The AI Architecture Pattern Library and Zero Trust Test',   'file' => '/The Consulting Toolkit Workfiles/Toolkit_L_The_AI_Architecture_Pattern_Library_and_Zero_Trust_Test.xlsx',  'type' => 'XLSX'),
      array('num' => 'M', 'name' => 'The AI Application Security Scorecard',                    'file' => '/The Consulting Toolkit Workfiles/Toolkit_M_The_AI_Application_Security_Scorecard.xlsx',                    'type' => 'XLSX'),
      array('num' => 'N', 'name' => 'The MLOps Lifecycle Governance Workpaper',                 'file' => '/The Consulting Toolkit Workfiles/Toolkit_N_The_MLOps_Lifecycle_Governance_Workpaper.xlsx',                 'type' => 'XLSX'),
      array('num' => 'O', 'name' => 'The AI Vendor Tier Map and Security Review',               'file' => '/The Consulting Toolkit Workfiles/Toolkit_O_The_AI_Vendor_Tier_Map_and_Security_Review.xlsx',               'type' => 'XLSX'),
      array('num' => 'P', 'name' => 'The AI Data Flow Map',                                     'file' => '/The Consulting Toolkit Workfiles/Toolkit_P_The_AI_Data_Flow_Map.xlsx',                                     'type' => 'XLSX'),
      array('num' => 'Q', 'name' => 'The Regulatory Crosswalk',                                 'file' => '/The Consulting Toolkit Workfiles/Toolkit_Q_The_Regulatory_Crosswalk.xlsx',                                 'type' => 'XLSX'),
      array('num' => 'R', 'name' => 'The Defensible AI Security Baseline and Four-Page Board Pack', 'file' => '/The Consulting Toolkit Workfiles/Toolkit_R_The_Defensible_AI_Security_Baseline_and_Four_Page_Board_Pack.xlsx', 'type' => 'XLSX'),
    ),
    'companion_docs' => array(),

    // ---- Explicit chapter map ------------------------------------------------
    // REQUIRED. The folders are named "Chapter_01" (underscore). The
    // auto-discovery regex is /^chapter\s*(\d+)\b/ and \s* matches WHITESPACE,
    // not an underscore, so auto-discovery would render literal "Chapter_01"
    // headings, sort them randomly, and treat "The Consulting Toolkit
    // Workfiles" as a chapter. Do not remove this map.
    //
    // 'Appendix' is included deliberately: auto-discovery skips it, but an
    // explicit map does not, which lets the eighteen instrument diagrams
    // render as their own gallery block at the end.
    'chapters' => array(
      'Chapter_01' => array('id' => 'ch01', 'nav_label' => 'Ch 1',  'heading_html' => 'Chapter 1: <em>The Green Dashboard Fallacy</em>'),
      'Chapter_02' => array('id' => 'ch02', 'nav_label' => 'Ch 2',  'heading_html' => 'Chapter 2: <em>The Audit Method</em>'),
      'Chapter_03' => array('id' => 'ch03', 'nav_label' => 'Ch 3',  'heading_html' => 'Chapter 3: <em>AI Governance</em>'),
      'Chapter_04' => array('id' => 'ch04', 'nav_label' => 'Ch 4',  'heading_html' => 'Chapter 4: <em>AI Inventory</em>'),
      'Chapter_05' => array('id' => 'ch05', 'nav_label' => 'Ch 5',  'heading_html' => 'Chapter 5: <em>Non-Human Identity and Agent Governance</em>'),
      'Chapter_06' => array('id' => 'ch06', 'nav_label' => 'Ch 6',  'heading_html' => 'Chapter 6: <em>Security Operations for AI</em>'),
      'Chapter_07' => array('id' => 'ch07', 'nav_label' => 'Ch 7',  'heading_html' => 'Chapter 7: <em>AI Architecture Security</em>'),
      'Chapter_08' => array('id' => 'ch08', 'nav_label' => 'Ch 8',  'heading_html' => 'Chapter 8: <em>AI Application Security</em>'),
      'Chapter_09' => array('id' => 'ch09', 'nav_label' => 'Ch 9',  'heading_html' => 'Chapter 9: <em>AI Third-Party Risk</em>'),
      'Chapter_10' => array('id' => 'ch10', 'nav_label' => 'Ch 10', 'heading_html' => 'Chapter 10: <em>AI Data Protection</em>'),
      'Chapter_11' => array('id' => 'ch11', 'nav_label' => 'Ch 11', 'heading_html' => 'Chapter 11: <em>The Assembly Phase</em>'),
      'Chapter_12' => array('id' => 'ch12', 'nav_label' => 'Ch 12', 'heading_html' => 'Chapter 12: <em>Auditing the AI That Defends the Enterprise</em>'),
      'Chapter_13' => array('id' => 'ch13', 'nav_label' => 'Ch 13', 'heading_html' => 'Chapter 13: <em>Sequencing the First 90 Days</em>'),
      'Chapter_14' => array('id' => 'ch14', 'nav_label' => 'Ch 14', 'heading_html' => 'Chapter 14: <em>The Coalition</em>'),
      'Chapter_15' => array('id' => 'ch15', 'nav_label' => 'Ch 15', 'heading_html' => 'Chapter 15: <em>Defending the Budget and Building the Multi-Year Program</em>'),
      'Chapter_16' => array('id' => 'ch16', 'nav_label' => 'Ch 16', 'heading_html' => 'Chapter 16: <em>Working with Auditors, Regulators, Insurers, and Enterprise Customers</em>'),
      'Chapter_17' => array('id' => 'ch17', 'nav_label' => 'Ch 17', 'heading_html' => 'Chapter 17: <em>From Engagement to Program</em>'),
      'Appendix'   => array('id' => 'appendix', 'nav_label' => 'Appendix', 'heading_html' => 'Appendix: <em>The Eighteen Operating Instruments</em>'),
    ),
  ),

  'the-ai-it-security-implementation-strategy' => array(
    'series'   => 'The Operating Discipline for AI Library&trade;',
    'title'    => 'The AI IT Security Implementation &amp; Strategy&trade;',
    'subtitle' => 'Proving AI Risk Is Governed &mdash; Before the Board, the Auditor, or the Regulator Asks',
    'status'   => 'forthcoming',
    'status_label' => 'Forthcoming',
    'description' => 'Book 06 of 9 in The Operating Discipline for AI Library&trade; &mdash; the nine-book series behind the AI Operating System. Every organization deploying AI will eventually be asked one question &mdash; by a regulator, an insurance carrier, an enterprise customer, or its own board: how is AI risk being governed? Most cannot answer it. This book is the operating manual for building the answer &mdash; ratified policies, an integrated risk register, a regulatory crosswalk, board reporting that works at a glance, and a cadence that continues after the consultants leave. A discipline to operate, not a project to complete.',
    'buy_url'  => '',
    'buy_label'=> 'Buy on Amazon',
    'buy_note' => '',
    'forthcoming_note' => 'The AI IT Security Implementation &amp; Strategy is forthcoming as Book 06 of 9 in The Operating Discipline for AI Library&trade;. Be the first to know when it launches, subscribe to The AI Operating System newsletter for the launch announcement, advance excerpts, and the methodology behind the framework.',
    'body_html' => <<<'SRJBODY'
<h2>You have controls. You do not have governance. <em>The board can feel the difference.</em></h2>
<p>The audit committee chair asks the CISO how AI risk is being governed. The CISO has an answer &mdash; a good one, technically: forty minutes of architecture diagrams, model inventories, vendor assessments. The chair listens, then asks again: <em>no &mdash; how is it governed? Who decides? Where's the policy? What do we report? What would we show the SEC?</em> Silence. Controls are what you do; governance is how you decide, document, and demonstrate what you do &mdash; and four forces are now converging on that distinction at once. SEC cybersecurity disclosure rules are pulling AI exposure into 10-K material risk. EU AI Act provisions are phasing in through 2026 and 2027. Cyber insurance carriers are making documented AI governance a renewal condition. Enterprise customers are embedding AI governance attestation in vendor questionnaires. Four askers, one question, no translation available.</p>
<p>The question this book leaves ringing is sharper still: if the board asked for proof tomorrow, what would you show them? Because AI governance is not what you say you intended. It is what you can prove was decided, approved, funded, monitored, and reviewed.</p>
<h3>Artifacts, not aspirations</h3>
<p>This is not a book about what should exist. It is a book about what gets built, who signs it, and what it looks like when it's running. The unit of governance is the ratified artifact: the policy legal signed, the register entry the CRO accepted, the reporting template the audit committee actually uses. Anything that exists only in a slide deck does not exist &mdash; and at the end of every chapter the reader runs the same test: do I have the artifact, or do I have a description of the artifact?</p>
<h3>Six buildouts. Six sentences you can finally say to your board.</h3>
<p>The heart of the book walks the six buildouts of the companion AI IT Security Implementation &amp; Strategy engagement, one chapter each: the governance framework and policy, the risk register integration, budget alignment and risk transfer, the regulatory compliance crosswalk, board and audit committee reporting, and the operating cadence that keeps it all running. Each chapter opens with the exact sentence leadership will be able to say to the board once the artifact exists, and closes with the evidence that makes the sentence true. The book then converts the reader into an operator: a First 90 Days on-ramp, a first-year quarter-by-quarter operating plan, and an honest accounting of the three moments where governance programs most often die &mdash; and the countermeasure for each.</p>
<h3>Who it's for</h3>
<p>The executive who owns the answer when the question lands: the CISO, the Chief Risk Officer, the General Counsel, and the Chief Compliance Officer &mdash; and the audit committee members who will ask it. Governance is not the brake on AI; it is the chassis that lets you drive at speed &mdash; and it is what gives the technical disciplines of Books 07, 08, and 09 their coherence. Organizations that build operating-grade AI governance now do it on their own schedule. Organizations that wait inherit the cadence of whichever regulator, customer, or carrier asks first.</p>
SRJBODY,
    'library_base' => '',
  ),

  'the-ai-risk-governance-review' => array(
    'series'   => 'The Operating Discipline for AI Library&trade;',
    'title'    => 'The AI Risk &amp; Governance Review&trade;',
    'subtitle' => 'How Executives Defend Their AI Decisions When the Board, the Regulator, the Acquirer, or the Lawyer Asks',
    'cover'    => 'https://srjconsultingservices.com/wp-content/uploads/Volume_III_KDP_Kindle_RGB.jpg',
    'cover_alt'=> 'The AI Risk and Governance Review book cover',
    'status'   => 'available',
    'status_label' => 'Available Now',
    'description' => 'The governance discipline of the Library. A structured operating model for converting the audit and the assessment into a defensible dossier when a regulator, an auditor, an acquirer, or a carrier asks. The 6-Step Review produces a per-use-case governance dossier; the AI Governance Framework Crosswalk aligns it to ISO/IEC 42001, the NIST AI RMF, the EU AI Act, NYC Local Law 144, SR 11-7, and the sector rules. Plain English, no background in AI law or formal standards required.',
    'buy_url'  => 'https://www.amazon.com/dp/B0H7DB6TBV',
    'buy_label'=> 'Buy on Amazon',
    'buy_note' => 'Hardcover. Also available in Kindle edition.',
    'forthcoming_note' => '',
    'body_html' => <<<'SRJBODY'
<h2>The AI Risk &amp; Governance Review&trade; is the discipline every leadership team is now being asked to demonstrate, and <em>the one most cannot yet hand across the table.</em></h2>

<h2>The pain AI Risk &amp; Governance Review is built to address</h2>
<p>The audit did the work. The assessment did the work. Then a regulator opens an inquiry. An auditor tests the AI program against ISO/IEC 42001 or the NIST AI Risk Management Framework. An acquirer runs diligence. An enterprise customer requests an AI attestation. A cyber, E&amp;O, or D&amp;O carrier puts AI questions on the renewal application. The question lands the same way every time. What do you hand them?</p>
<p>Most leadership teams do not have a clean answer to that question right now. Slide decks about AI strategy do not close it. A vendor policy stapled to an employee handbook does not close it. The gap between running AI and being able to defend running AI is what The AI Risk &amp; Governance Review is built to close.</p>
<p>The book is written for the leader who has done the AI work, told the team it was going to change the business, absorbed the friction of adoption, and now has to answer a different kind of question. Not what tools are being used. Not how many employees have logged in. The real question, in the room where the real question gets asked: is this program defensible if someone tests it?</p>

<h2>The question has moved from adoption to defensibility</h2>
<p>Four stakeholders have arrived at the AI conversation, and they are asking different versions of the same question.</p>
<p>The regulator: is the program consistent with the rules that already apply. The board: who is accountable, and how do we know. The carrier: is the risk exposure understood well enough to underwrite. The acquirer: is the AI program documented, controlled, and clean enough to buy. None of those questions are answered by an adoption metric, a usage report, or a general policy document.</p>
<p>The new executive standard is straightforward. Show that AI is under formal governance discipline, not simply that AI is in use. Volume III is how that standard gets met by a leadership team running with the resources it already has.</p>

<h2>What The AI Risk &amp; Governance Review book is</h2>
<p>Volume III is an operational execution book for the leader accountable for AI outcomes, not just AI activity. The difference between those two things is larger than it sounds. AI activity is easy to document. A policy fills two pages, a usage report fills a dashboard, and the leadership team feels the box is checked. AI outcomes are harder. They require use-case-level review, evidence collection, framework crosswalking, and a documented decision an outside party can read and accept.</p>
<p>The book does not require a Big Four firm, a Chief AI Officer, an in-house counsel with an AI specialty, or a dedicated compliance department. It requires the same operating discipline a leadership team already applies to finance, hiring, and customer obligations, and it gives that discipline the structure to produce the dossier the business now needs to have ready.</p>
<p>Every chapter connects AI risk to a named operating instrument. Every artifact is built for a small or mid-sized business with a real budget and a lean team. Every framework is designed to produce something you can walk into a room with and defend, not just something you can read and feel good about.</p>

<h2>What you will learn from AI Risk &amp; Governance Review</h2>
<p>How to run a 6-Step AI Risk &amp; Governance Review that produces a per-use-case governance dossier for each material AI use case. How to map that dossier to the frameworks a regulator, auditor, or acquirer will actually reach for. How to place executive accountability so a board can see who owns what. How to score the program against a five-dimension AI Governance Maturity Scale&trade; that complements the readiness scoring from Volume II.</p>
<p>The book introduces and develops the named operating instruments leadership teams use to place the AI Operating System&trade; under formal governance discipline: the 6-Step Review, the Governance Dossier Template, the AI Governance Framework Crosswalk&trade;, the AI Governance Maturity Scale&trade;, the AI Accountability Matrix&trade;, the AI Data Exposure Model&trade;, the Decision Influence Matrix&trade;, the AI Vendor Risk Inventory&trade;, the AI Steering Committee Charter&trade;, three new operating logs that satisfy ISO 42001 Clauses 9 and 10, and the 90-Day Governance Launch Plan&trade;. Each instrument carries a worked example and a usable template.</p>
<p>The lesson that runs through every chapter is the same. AI usage is not AI governance. A policy is not a control. A dashboard is not a dossier. A business that cannot show its work when someone tests it is still running a story rather than a program.</p>

<h2>Who AI Risk &amp; Governance Review is written for</h2>
<p>The book is written for executives and operating leaders, not lawyers, auditors, or compliance specialists. No background in AI law, information security, procurement, or formal standards is assumed. The goal is a defensible operating program, not a legal treatise.</p>
<p>The roles include owners and presidents, CEOs, CFOs, and COOs, managing partners, board members and operating partners, general counsel and outside counsel, cyber, E&amp;O, and D&amp;O underwriters, and consultants advising mid-market clients. The sectors include professional services, accounting, legal, construction, manufacturing, distribution, healthcare, insurance, financial services, and education, alongside any organization subject to Colorado, Texas, California, New York City, or EU AI rules.</p>
<p>If you are responsible for the AI program, accountable for board reporting, or in a position where someone is going to ask you to defend an AI decision, the book is for you.</p>

<h2>How to use AI Risk &amp; Governance Review in your business</h2>
<p>Read it with your AI Tool Inventory from <a href="/books/ai-business-services/the-ai-business-enablement-audit/">Volume I</a>, your readiness decisions from <a href="/books/ai-business-services/the-ai-readiness-performance-assessment/">Volume II</a>, and your top three material AI use cases in front of you. Each chapter is designed to help you review one part of your AI program, document what you find, and convert that finding into a decision your leadership team, your board, or an outside party can act on.</p>
<p>The tools in the book are not meant to be read and set aside. They are meant to be used, filled in, and brought into your next leadership meeting. The fifteen-instrument Companion Worksheet library accompanying the book provides every artifact as an editable file, with the 6-Step Review Process Workbook as the operating master.</p>
<p>If you have not completed Volumes I and II, the book still works. You will need to do some foundational mapping as you move through the early chapters, and the book will guide you through that.</p>

<h2>The case continuity across the Library</h2>
<p>Readers who recognize the seventy-five-person construction firm, the forty-person accounting firm, and the sixty-person professional services practice from earlier Volumes will see them again here. The case patterns are continuations of the same operating realities those businesses face as AI work moves from visibility (Volume I) to readiness (Volume II) to governance (this Volume) to optimization (Volume IV).</p>
<p>Each composite is drawn from patterns observed across many consulting engagements spanning more than two decades of professional practice. No single composite represents a single real engagement. Every composite combines elements from multiple distinct situations, and the specific numeric details are illustrative constructions designed to convey operating patterns in concrete terms.</p>

<h2>What is inside AI Risk &amp; Governance Review, chapter by chapter</h2>
<p><strong>Chapter 1</strong> names the four forces that have made AI governance an executive obligation, not a compliance topic, and shows why AI governance is not just business governance. <strong>Chapter 2</strong> introduces the AI Governance Framework Crosswalk&trade; and the operational risk categories that organize the rest of the book. <strong>Chapter 3</strong> places executive accountability and AI literacy at the top of the program, where a regulator or acquirer will look first. <strong>Chapter 4</strong> maps data risk and confidentiality exposure through the AI Data Exposure Model&trade;. <strong>Chapter 5</strong> maps decision risk against the trustworthiness characteristics from the NIST AI RMF, using the Decision Influence Matrix&trade;. <strong>Chapter 6</strong> maps vendor dependency risk and third-party exposure through the AI Vendor Risk Inventory&trade;. <strong>Chapter 7</strong> maps compliance, regulatory, and financial reporting exposure across the sector rules already in force. <strong>Chapter 8</strong> installs the 6-Step AI Risk &amp; Governance Review as the operating routine that produces the per-use-case governance dossier. <strong>Chapter 9</strong> places the governance operating structure and board oversight around the review so accountability holds. <strong>Chapter 10</strong> installs policies, internal audit, and management review as the recurring discipline. <strong>Chapter 11</strong> installs the AI Incident Response Framework&trade; so an incident is met with a documented process rather than an improvised one. <strong>Chapter 12</strong> launches the program on the 90-Day Governance Launch Plan&trade; and shows how governance discipline converts into commercial value: cleaner renewals, better diligence outcomes, and a defensible position when the question arrives.</p>

<h2>Where AI Risk &amp; Governance Review sits in The Operating Discipline for AI Library&trade;</h2>
<p>Volume III is the governance discipline of Pillar I, AI Business Services&trade;. The four Volumes in Pillar I sequence the operating disciplines a business needs to install AI honestly: visibility (<a href="/books/ai-business-services/the-ai-business-enablement-audit/">Volume I</a>), readiness (<a href="/books/ai-business-services/the-ai-readiness-performance-assessment/">Volume II</a>), governance (this Volume), and optimization (<a href="/books/ai-business-services/the-ai-efficiency-process-optimization/">Volume IV</a>). Volumes I and II build the foundation the review draws from. Volume III makes the AI program defensible. Volume IV makes it measurably valuable. A business that finishes Pillar I has both.</p>
<p><a href="/books/ai-risk-governance-security/">Pillar II, AI Risk Governance &amp; Security&trade;</a>, runs in parallel and addresses the security side of the AI Operating System&trade; through five further Volumes. The two pillars are deliberately independent.</p>

<h2>How the book and the AI Risk &amp; Governance Review engagement work together</h2>
<p>The book is the methodology, written for leadership teams that want to run the discipline themselves. The <a href="/services/business-services/ai-risk-governance-review/">AI Risk &amp; Governance Review engagement</a> is the execution, designed for leadership teams that want the per-use-case governance dossier produced, scored, and pressure-tested against their own AI use cases and their own operating context inside a defined engagement window.</p>
<p>Both share the same underlying operating instruments. The choice is whether to read, draft, and refine internally over six months, or to bring the firm in and have the dossier on the table when the next diligence question, carrier renewal, or regulator inquiry arrives. Aligning with the <a href="https://www.nist.gov/itl/ai-risk-management-framework" rel="noopener">NIST AI Risk Management Framework</a> and <a href="https://www.iso.org/standard/81230.html" rel="noopener">ISO/IEC 42001</a> does not, by itself, produce these answers. Those frameworks define the governance obligations. The book is the operating discipline that meets them inside a real business, with a real cost base and a lean team.</p>
SRJBODY,
    'library_base' => '/wp-content/uploads/The_Operating_Discipline_for_AI/AI_Risk_and_Governance_Review',

    // Video walkthrough (added July 24, 2026).
    'video' => array(
        'youtube_id' => 'rcx0kqR4BNM',
        'title_attr' => 'Prove Your AI Is Governed: The Framework Every Executive Needs',
        'label'      => 'Watch the Walkthrough',
        'headline'   => 'Prove your AI is governed, <em>before someone asks.</em>',
        'lede'       => 'A complete walkthrough of the AI Risk &amp; Governance Review&trade; framework. The question every board, regulator, carrier, and acquirer is now asking, the governance record that answers it, and what a defensible AI operation looks like in practice.',
        'meta'       => 'Presented by Elizabeth &middot; Script by Stephen R. Jordan',
    ),

    // Optional: executive briefing PDF card. Renders below the video when present.
    'briefing' => array(
        'title_html' => 'The AI Risk &amp; Governance Review&trade;',
        'format'     => 'PDF &middot; 28 Slides',
        'lede'       => 'A condensed visual companion to the framework. The four forces, the 6-Step Review, the AI Governance Framework Crosswalk, and the per-use-case governance dossier executives use to defend their AI decisions when the board, the regulator, the acquirer, or the lawyer asks. Built for board distribution and leadership team review.',
        'pdf_path'   => '/wp-content/uploads/srj_ai_risk_governance_review_executive_briefing.pdf',
    ),

    // Worksheet library.
    'worksheet_label'   => 'Companion Worksheets',
    'worksheet_heading' => 'Every <em>governance instrument,</em> editable and ready to use.',
    'worksheet_intro'   => 'Every governance instrument from the book, free and editable, ready to use in a live Risk &amp; Governance Review. Works in Microsoft Office, Google Workspace, Apple iWork, and LibreOffice.',
    'master' => array(
      'label'  => 'Recommended Starting Point',
      'name'   => '6-Step Review Process Workbook',
      'detail' => 'The book&rsquo;s operating workbook. Walks each material AI use case through the six-step Risk &amp; Governance Review and produces the per-use-case governance dossier.',
      'file'   => '/Appendix/Appendix-B_6-Step-Review-Process-Workbook.xlsx',
      'button' => 'Download Master',
    ),
    'worksheets' => array(
      array('num' => 'A', 'name' => 'AI Risk &amp; Governance Review Dossier Template',  'file' => '/Appendix/Appendix-A_AI-Risk-Governance-Review-Dossier-Template.docx',  'type' => 'DOCX'),
      array('num' => 'C', 'name' => 'AI Governance Maturity Scale Rubric',                'file' => '/Appendix/Appendix-C_AI-Governance-Maturity-Scale-Rubric.xlsx',            'type' => 'XLSX'),
      array('num' => 'D', 'name' => 'AI Accountability Matrix',                           'file' => '/Appendix/Appendix-D_AI-Accountability-Matrix.xlsx',                       'type' => 'XLSX'),
      array('num' => 'E', 'name' => 'AI Data Exposure Model Reference Card',              'file' => '/Appendix/Appendix-E_AI-Data-Exposure-Model-Reference-Card.docx',          'type' => 'DOCX'),
      array('num' => 'F', 'name' => 'Decision Influence Matrix',                          'file' => '/Appendix/Appendix-F_Decision-Influence-Matrix.xlsx',                      'type' => 'XLSX'),
      array('num' => 'G', 'name' => 'AI Vendor Risk Inventory',                           'file' => '/Appendix/Appendix-G_AI-Vendor-Risk-Inventory.xlsx',                       'type' => 'XLSX'),
      array('num' => 'H', 'name' => 'AI Steering Committee Charter Template',             'file' => '/Appendix/Appendix-H_AI-Steering-Committee-Charter-Template.docx',         'type' => 'DOCX'),
      array('num' => 'I', 'name' => 'AI Usage Policy Functional Addendums',               'file' => '/Appendix/Appendix-I_AI-Usage-Policy-Functional-Addendums.docx',           'type' => 'DOCX'),
      array('num' => 'J', 'name' => 'AI Governance Logs',                                 'file' => '/Appendix/Appendix-J_AI-Governance-Logs.xlsx',                             'type' => 'XLSX'),
      array('num' => 'K', 'name' => '90-Day Governance Launch Plan',                      'file' => '/Appendix/Appendix-K_90-Day-Governance-Launch-Plan.xlsx',                  'type' => 'XLSX'),
      array('num' => 'L', 'name' => 'AI Governance Framework Crosswalk',                  'file' => '/Appendix/Appendix-L_AI-Governance-Framework-Crosswalk.xlsx',              'type' => 'XLSX'),
      array('num' => 'M', 'name' => 'AI Third-Party Governance Statement Template',       'file' => '/Appendix/Appendix-M_AI-Third-Party-Governance-Statement-Template.docx',   'type' => 'DOCX'),
      array('num' => 'N', 'name' => 'Bias Audit Calculator',                              'file' => '/Appendix/Appendix-N_Bias-Audit-Calculator.xlsx',                          'type' => 'XLSX'),
      array('num' => 'N', 'name' => 'Bias Audit Working Reference',                       'file' => '/Appendix/Appendix-N_Bias-Audit-Working-Reference.docx',                   'type' => 'DOCX'),
      array('num' => 'O', 'name' => 'Regulator Inquiry Response Template',                'file' => '/Appendix/Appendix-O_Regulator-Inquiry-Response-Template.docx',            'type' => 'DOCX'),
    ),
    'companion_docs' => array(),

    // Explicit chapter map. Folder names on disk are bare "Chapter 1", "Chapter 2", etc.
    'chapters' => array(
      'Chapter 1'  => array('id' => 'ch01', 'nav_label' => 'Ch 1',  'heading_html' => 'Chapter 1: <em>Why AI Governance Is Not Just Business Governance</em>'),
      'Chapter 2'  => array('id' => 'ch02', 'nav_label' => 'Ch 2',  'heading_html' => 'Chapter 2: <em>AI Governance Frameworks and Operational Risk Categories</em>'),
      'Chapter 3'  => array('id' => 'ch03', 'nav_label' => 'Ch 3',  'heading_html' => 'Chapter 3: <em>Executive Accountability and AI Literacy</em>'),
      'Chapter 4'  => array('id' => 'ch04', 'nav_label' => 'Ch 4',  'heading_html' => 'Chapter 4: <em>Data Risk and Confidentiality Exposure</em>'),
      'Chapter 5'  => array('id' => 'ch05', 'nav_label' => 'Ch 5',  'heading_html' => 'Chapter 5: <em>Decision Risk and the Trustworthiness Characteristics</em>'),
      'Chapter 6'  => array('id' => 'ch06', 'nav_label' => 'Ch 6',  'heading_html' => 'Chapter 6: <em>Vendor Dependency Risk and Third-Party Exposure</em>'),
      'Chapter 7'  => array('id' => 'ch07', 'nav_label' => 'Ch 7',  'heading_html' => 'Chapter 7: <em>Compliance, Regulatory, and Financial Reporting Exposure</em>'),
      'Chapter 8'  => array('id' => 'ch08', 'nav_label' => 'Ch 8',  'heading_html' => 'Chapter 8: <em>Conducting the AI Risk &amp; Governance Review</em>'),
      'Chapter 9'  => array('id' => 'ch09', 'nav_label' => 'Ch 9',  'heading_html' => 'Chapter 9: <em>The Governance Operating Structure and Board Oversight</em>'),
      'Chapter 10' => array('id' => 'ch10', 'nav_label' => 'Ch 10', 'heading_html' => 'Chapter 10: <em>Policies, Internal Audit, and Management Review</em>'),
      'Chapter 11' => array('id' => 'ch11', 'nav_label' => 'Ch 11', 'heading_html' => 'Chapter 11: <em>AI Incident Response Framework</em>'),
      'Chapter 12' => array('id' => 'ch12', 'nav_label' => 'Ch 12', 'heading_html' => 'Chapter 12: <em>Launching Governance and Realizing Its Commercial Value</em>'),
    ),
  ),

  'the-ai-efficiency-process-optimization' => array(
    'series'   => 'The Operating Discipline for AI Library&trade;',
    'title'    => 'The AI Efficiency &amp; Process Optimization&trade;',
    'subtitle' => 'How Leadership Teams Convert AI Adoption Into Measurable Operating Performance and a Defensible Financial Return',
    'cover'    => 'https://srjconsultingservices.com/wp-content/uploads/Volume_IV_KDP_Kindle_RGB.jpg',
    'cover_alt'=> 'The AI Efficiency and Process Optimization book cover',
    'status'   => 'available',        // launch day: change to 'available'
    'status_label' => 'Available Now',
    'description' => 'The performance discipline that closes Pillar I. A structured operating discipline for converting AI adoption into measurable operating performance and a defensible financial return. Names the AI Efficiency Gap, maps Phantom Productivity, calculates the AI Efficiency Tax, and installs the Workflow Reality Map, the AI Process Fit Test, and the Four AI Performance Indicators. Produces a single AI Efficiency Scorecard, an AI ROI Formula the CFO can defend in the boardroom, an Executive AI Efficiency Brief the chair can read in five minutes, and a 90 Day AI Process Optimization Plan that runs inside the operating rhythm already in place.',
    // Launch day: add the Amazon URL and the buy button replaces the note below.
    'buy_url'  => 'https://www.amazon.com/dp/B0HBFVM7DG',
    'buy_label'=> 'Buy on Amazon',
    'buy_note' => 'Hardcover, paperback, and Kindle editions.',
    'forthcoming_note' => 'The AI Efficiency &amp; Process Optimization&trade; is forthcoming as Book 04 of 9 in The Operating Discipline for AI Library&trade;, the closing volume of Pillar I, AI Business Services&trade;. Be the first to know when it launches, subscribe to The AI Operating System newsletter for the launch announcement, advance excerpts, and the methodology behind the framework.',
    'body_html' => <<<'SRJBODY'
<h2>The AI Efficiency &amp; Process Optimization&trade; is the discipline every leadership team is now being asked to demonstrate, and <em>the one most are not yet equipped to defend.</em></h2>

<h2>The pain AI Efficiency &amp; Process Optimization is built to address</h2>
<p>The licenses are paid. The training is done. The pilots are everywhere. Twelve to eighteen months in, the recurring AI spend is real and the operating performance has not moved. Margins have not improved. Cost per customer has not dropped. Capacity has not expanded. What did show up is a recurring software bill, a quiet supervision overhead the senior reviewer is absorbing inside billable time, a rework loop nobody planned for, and a board asking sharper questions every quarter.</p>
<p>The book is written for the leader who has spent the money, told the team AI was going to change the business, pushed through the friction of adoption, and now has to answer the question that has arrived in every leadership room. Not what tools are being used. Not how many employees have logged in. The real question: what has AI actually done for this business?</p>
<p>Most leaders do not have a clean answer to that question right now. The gap between what AI appears to be doing and what it is actually doing to the P&amp;L is what The AI Efficiency &amp; Process Optimization is built to close.</p>

<h2>The question has moved from adoption to proof</h2>
<p>Four stakeholders have arrived at the AI conversation, and they are asking different versions of the same question.</p>
<p>The CFO: what did AI return after cost. The board: what moved, and who owns it. The lender: did AI improve cash flow stability. The acquirer: is AI scalable, documented, and defensible. None of those questions are answered by an adoption metric or a usage report.</p>
<p>The new executive standard is straightforward. Show what AI has moved, not simply where AI is being used. Volume IV is how that standard gets met by a leadership team running with the resources it already has.</p>

<h2>What The AI Efficiency &amp; Process Optimization book is</h2>
<p>Volume IV is an operational execution book for the leader accountable for AI results, not just AI activity. The difference between those two things is larger than it sounds. AI activity is easy to generate. A dashboard fills with usage statistics, output volumes, and adoption rates in a matter of weeks. AI results are harder. They require workflow mapping, baseline measurement, structured testing, and a clear line connecting what AI did to what the business saved, gained, or improved.</p>
<p>The book does not require a Big Four firm, a Chief AI Officer, or a dedicated analytics department. It requires the same operating discipline a leadership team already applies to finance, hiring, and customer obligations, and it gives that discipline the structure to produce the financial answer the business now needs to have ready.</p>
<p>Every chapter connects AI to the P&amp;L. Every tool is built for a small or mid-sized business with a real budget and a lean team. Every framework is designed to produce something you can walk into a room with and defend, not just something you can read and feel good about.</p>

<h2>What you will learn from AI Efficiency &amp; Process Optimization</h2>
<p>How to map the workflows AI is already touching. How to identify where it is creating real efficiency and where it is creating the appearance of efficiency. How to measure cycle time, capacity, error rates, and labor savings with numbers you can stand behind. How to calculate an AI return on investment that holds up under CFO scrutiny.</p>
<p>The book introduces and develops the named operating instruments leadership teams use to close the AI Efficiency Gap: the Workflow Reality Map, the AI Process Fit Test, the AI Efficiency Tax estimate, the AI Efficiency Scorecard, the AI ROI Formula, the Executive AI Efficiency Brief, and the 90 Day AI Process Optimization Plan. Each instrument carries a worked example and a usable template.</p>
<p>The lesson that runs through every chapter is the same. AI activity is not AI efficiency. Usage is not improvement. Adoption is not optimization. A business that cannot measure what AI has moved is still managing a story rather than a result.</p>

<h2>Who AI Efficiency &amp; Process Optimization is written for</h2>
<p>The book is written for executives and operating leaders, not engineers. The goal is measurable performance, defensible ROI, and a cadence the business can actually run.</p>
<p>The roles include owners and presidents, CEOs, CFOs, and COOs, managing partners, board members and operating partners, lenders, investors, and acquirers, and consultants advising mid-market clients. The sectors include professional services, accounting, legal, construction, manufacturing, distribution, healthcare, insurance, and financial services.</p>
<p>If you are responsible for the P&amp;L, accountable for operating performance, or in a position where someone is going to ask you to justify your AI investment, the book is for you.</p>

<h2>How to use AI Efficiency &amp; Process Optimization in your business</h2>
<p>Read it with your current AI Tool Inventory, your readiness decisions from <a href="/books/ai-business-services/the-ai-readiness-performance-assessment/">Volume II</a>, your governance records from <a href="/books/ai-business-services/the-ai-risk-governance-review/">Volume III</a>, and your top three AI-supported workflows in front of you. Each chapter is designed to help you test one part of your AI operation, document what you find, and convert that finding into a decision your leadership team can act on.</p>
<p>The tools in the book are not meant to be read and set aside. They are meant to be used, filled in, and brought into your next leadership meeting. The fourteen-instrument Consulting Toolkit accompanying the book provides every artifact as an editable file.</p>
<p>If you have not completed the earlier Volumes, the book still works. You will need to do some foundational mapping as you move through the early chapters, and the book will guide you through that.</p>

<h2>The case continuity across the Library</h2>
<p>Readers who recognize the seventy-five-person construction firm, the forty-person accounting firm, and the sixty-person professional services practice from earlier Volumes will see them again here. The case patterns are continuations of the same operating realities those businesses face as AI work moves from visibility (Volume I) to readiness (Volume II) to governance (Volume III) to optimization (this Volume).</p>
<p>Each composite is drawn from patterns observed across many consulting engagements spanning more than two decades of professional practice. No single composite represents a single real engagement. Every composite combines elements from multiple distinct situations, and the specific numeric details are illustrative constructions designed to convey operating patterns in concrete terms.</p>

<h2>What is inside AI Efficiency &amp; Process Optimization, chapter by chapter</h2>
<p><strong>Chapter 1</strong> names the AI Efficiency Gap and shows where it lives inside a business. <strong>Chapter 2</strong> names Phantom Productivity, the most common specific pattern through which the gap appears. <strong>Chapter 3</strong> puts a dollar figure on the AI Efficiency Tax. <strong>Chapter 4</strong> introduces the Workflow Reality Map, which finds the cost at the step where it enters the process. <strong>Chapter 5</strong> introduces the AI Process Fit Test, which turns the map into a decision: expand, refine, pause, or remove. <strong>Chapter 6</strong> develops the four AI performance indicators that prove AI moved the operation. <strong>Chapter 7</strong> builds the AI Efficiency Scorecard, a single operating view across every active use case. <strong>Chapter 8</strong> builds the AI ROI Formula, the defensible number a CFO, board, lender, or acquirer can examine without it falling apart. <strong>Chapter 9</strong> develops the Executive AI Efficiency Brief, a one-page communication format that replaces the AI enthusiasm update with an AI performance report. <strong>Chapter 10</strong> installs the 90 Day AI Process Optimization Plan, a sequenced execution plan that runs inside the existing operating rhythm.</p>

<h2>Where AI Efficiency &amp; Process Optimization sits in The Operating Discipline for AI Library&trade;</h2>
<p>Volume IV is the closing book of Pillar I, AI Business Services&trade;. The four Volumes in Pillar I sequence the operating disciplines a business needs to install AI honestly: visibility (<a href="/books/ai-business-services/the-ai-business-enablement-audit/">Volume I</a>), readiness (<a href="/books/ai-business-services/the-ai-readiness-performance-assessment/">Volume II</a>), governance (<a href="/books/ai-business-services/the-ai-risk-governance-review/">Volume III</a>), and optimization (this Volume). Volumes I, II, and III build the foundation that makes AI defensible. Volume IV builds the layer that makes AI valuable. A business that finishes Pillar I has both.</p>
<p><a href="/books/ai-risk-governance-security/">Pillar II, AI Risk Governance &amp; Security&trade;</a>, runs in parallel and addresses the security side of the AI Operating System&trade; through five further Volumes. The two pillars are deliberately independent.</p>

<h2>How the book and the AI Efficiency &amp; Process Optimization engagement work together</h2>
<p>The book is the methodology, written for leadership teams that want to run the discipline themselves. The <a href="/services/business-services/ai-efficiency-process/">AI Efficiency &amp; Process Optimization engagement</a> is the execution, designed for leadership teams that want the artifacts produced, scored, and pressure-tested against their own data and their own workflows in ninety days.</p>
<p>Both share the same underlying operating instruments. The choice is whether to read, draft, and refine internally over six months, or to bring the firm in and have the artifacts on the table in ninety days. Aligning with the <a href="https://www.nist.gov/itl/ai-risk-management-framework" rel="noopener">NIST AI Risk Management Framework</a> and <a href="https://www.iso.org/standard/81230.html" rel="noopener">ISO/IEC 42001</a> does not, by itself, produce these answers. Those frameworks define the measurement obligations. The book is the operating discipline that meets them inside a real business, with a real cost base and a lean team.</p>
SRJBODY,
    'library_base' => '/wp-content/uploads/The_Operating_Discipline_for_AI/The_AI_Efficiency_and_Process_Optimization',

    // Optional: walkthrough video. Renders between hero and body when present.
    'video' => array(
        'youtube_id' => 'AWEo4s-Im_E',
        'title_attr' => 'The AI Efficiency and Process Optimization Framework',
        'label'      => 'Watch the 13-Minute Walkthrough',
        'headline'   => 'Prove your AI <em>paid off.</em>',
        'lede'       => 'A complete walkthrough of the AI Efficiency &amp; Process Optimization&trade; framework. Why adoption is not the same as return, the four AI performance indicators executives should be measuring, and how governance findings become operational savings the finance team will accept.',
        'meta'       => 'Presented by Elizabeth &middot; Script by Stephen R. Jordan &middot; 13 minutes',
    ),

    'briefing' => array(
        'title_html' => 'The AI Efficiency &amp; Process Optimization&trade;',
        'format'     => 'PDF &middot; 25 Pages',
        'lede'       => 'A condensed visual companion to Volume IV. The four operating pillars, the named instruments, the board and CFO stress test, and the operating discipline executives use to convert AI adoption into measurable performance. Built for board distribution and leadership team review.',
        'pdf_path'   => '/wp-content/uploads/SRJ_AI_Efficiency_Process_Optimization_Executive_Briefing.pdf',
    ),

    // Worksheet library (paths are relative to 'library_base').
    'worksheet_label'   => 'The Consulting Toolkit',
    'worksheet_heading' => 'Every <em>consulting toolkit instrument,</em> editable and ready to use.',
    'worksheet_intro'   => 'The full Consulting Toolkit from the Appendix of the book. Fourteen instruments, each editable and ready to use. XLSX for the calculators, scorecards, and worksheets that run live formulas. DOCX for the same instruments in editable document form, sized for executive review and team distribution. Works in Excel, Google Sheets, Numbers, LibreOffice Calc, Microsoft Word, Google Docs, Apple Pages, and LibreOffice Writer.',
    'worksheets' => array(
      array('num' => 'A', 'name' => 'The AI Efficiency Gap Worksheet',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_A_The_AI_Efficiency_Gap_Worksheet.xlsx', 'type' => 'XLSX'),
      array('num' => 'A', 'name' => 'The AI Efficiency Gap Worksheet',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_A_The_AI_Efficiency_Gap_Worksheet.docx', 'type' => 'DOCX'),
      array('num' => 'B', 'name' => 'The Phantom Productivity Diagnostic',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_B_The_Phantom_Productivity_Diagnostic.xlsx', 'type' => 'XLSX'),
      array('num' => 'B', 'name' => 'The Phantom Productivity Diagnostic',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_B_The_Phantom_Productivity_Diagnostic.docx', 'type' => 'DOCX'),
      array('num' => 'C', 'name' => 'The AI Efficiency Tax Calculator',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_C_The_AI_Efficiency_Tax_Calculator.xlsx', 'type' => 'XLSX'),
      array('num' => 'C', 'name' => 'The AI Efficiency Tax Calculator',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_C_The_AI_Efficiency_Tax_Calculator.docx', 'type' => 'DOCX'),
      array('num' => 'D', 'name' => 'The Workflow Reality Map Template',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_D_The_Workflow_Reality_Map_Template.xlsx', 'type' => 'XLSX'),
      array('num' => 'D', 'name' => 'The Workflow Reality Map Template',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_D_The_Workflow_Reality_Map_Template.docx', 'type' => 'DOCX'),
      array('num' => 'E', 'name' => 'The AI Process Fit Test Scoring Sheet',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_E_The_AI_Process_Fit_Test_Scoring_Sheet.xlsx', 'type' => 'XLSX'),
      array('num' => 'E', 'name' => 'The AI Process Fit Test Scoring Sheet',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_E_The_AI_Process_Fit_Test_Scoring_Sheet.docx', 'type' => 'DOCX'),
      array('num' => 'F', 'name' => 'The Pre-AI Baseline Capture Form',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_F_The_PreAI_Baseline_Capture_Form.xlsx', 'type' => 'XLSX'),
      array('num' => 'F', 'name' => 'The Pre-AI Baseline Capture Form',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_F_The_PreAI_Baseline_Capture_Form.docx', 'type' => 'DOCX'),
      array('num' => 'G', 'name' => 'The AI Efficiency Scorecard Template',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_G_The_AI_Efficiency_Scorecard_Template.xlsx', 'type' => 'XLSX'),
      array('num' => 'G', 'name' => 'The AI Efficiency Scorecard Template',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_G_The_AI_Efficiency_Scorecard_Template.docx', 'type' => 'DOCX'),
      array('num' => 'H', 'name' => 'The AI ROI Formula Workbook',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_H_The_AI_ROI_Formula_Workbook.xlsx', 'type' => 'XLSX'),
      array('num' => 'H', 'name' => 'The AI ROI Formula Workbook',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_H_The_AI_ROI_Formula_Workbook.docx', 'type' => 'DOCX'),
      array('num' => 'I', 'name' => 'The Executive AI Efficiency Brief Template',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_I_The_Executive_AI_Efficiency_Brief_Template.docx', 'type' => 'DOCX'),
      array('num' => 'J', 'name' => 'The AI Standardization Worksheet',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_J_The_AI_Standardization_Worksheet.xlsx', 'type' => 'XLSX'),
      array('num' => 'J', 'name' => 'The AI Standardization Worksheet',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_J_The_AI_Standardization_Worksheet.docx', 'type' => 'DOCX'),
      array('num' => 'K', 'name' => 'The 90 Day AI Process Optimization Plan Template',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_K_The_90_Day_AI_Process_Optimization_Plan_Template.xlsx', 'type' => 'XLSX'),
      array('num' => 'K', 'name' => 'The 90 Day AI Process Optimization Plan Template',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_K_The_90_Day_AI_Process_Optimization_Plan_Template.docx', 'type' => 'DOCX'),
      array('num' => 'L', 'name' => 'The Due Diligence AI Operations Package Index',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_L_The_Due_Diligence_AI_Operations_Package_Index.xlsx', 'type' => 'XLSX'),
      array('num' => 'L', 'name' => 'The Due Diligence AI Operations Package Index',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_L_The_Due_Diligence_AI_Operations_Package_Index.docx', 'type' => 'DOCX'),
      array('num' => 'M', 'name' => 'The Loaded Labor Rate Calculator',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_M_The_Loaded_Labor_Rate_Calculator.xlsx', 'type' => 'XLSX'),
      array('num' => 'M', 'name' => 'The Loaded Labor Rate Calculator',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_M_The_Loaded_Labor_Rate_Calculator.docx', 'type' => 'DOCX'),
      array('num' => 'N', 'name' => 'The Optimization Action List Template',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_N_The_Optimization_Action_List_Template.xlsx', 'type' => 'XLSX'),
      array('num' => 'N', 'name' => 'The Optimization Action List Template',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_N_The_Optimization_Action_List_Template.docx', 'type' => 'DOCX'),
      array('num' => 'O', 'name' => 'The Operating Cycle Calendar',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_O_The_Operating_Cycle_Calendar.xlsx', 'type' => 'XLSX'),
      array('num' => 'O', 'name' => 'The Operating Cycle Calendar',  'file' => '/The Consulting Toolkit Workfiles/Toolkit_O_The_Operating_Cycle_Calendar.docx', 'type' => 'DOCX'),
    ),
    'companion_docs' => array(),

    // No explicit chapter map: chapter graphics auto-discover from library_base.
  ),

  // --- Stage 2 placeholder for The Operating Discipline for AI Library&trade; ---
  // (Book 04 wired above. Books 05-09 are configured in their own forthcoming entries earlier in this array.)
);

// Select the book by the current page slug.
$srj_slug = get_post_field( 'post_name', get_queried_object_id() );
$book = isset( $SRJ_BOOKS[ $srj_slug ] ) ? $SRJ_BOOKS[ $srj_slug ] : null;
?>


<style>
  /* ===== BOOK DETAIL PAGE — title block, meta, buy button ===== */
  .book-detail .book-hero {
    padding: 88px 0 56px; border-bottom: 1px solid var(--gray-light);
  }
  .book-detail .book-hero-grid {
    display: grid; grid-template-columns: 1fr; gap: 48px; align-items: start;
  }
  .book-detail .book-hero-grid.has-cover {
    grid-template-columns: minmax(0, 1fr) 300px;
  }
  .book-detail .book-cover-col { order: 2; }
  .book-detail .book-cover-col img {
    width: 100%; height: auto; display: block;
    border-radius: 4px;
    box-shadow: 0 24px 60px -20px rgba(32, 24, 104, .45);
  }
  @media (max-width: 900px) {
    .book-detail .book-hero-grid.has-cover { grid-template-columns: 1fr; }
    .book-detail .book-cover-col { order: 0; max-width: 260px; margin-bottom: 8px; }
  }
  .book-detail .series-eyebrow {
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: .18em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 22px;
  }
  .book-detail .book-title {
    font-family: 'Lora', serif; font-size: 50px; line-height: 1.08;
    font-weight: 500; color: var(--navy); margin: 0 0 16px; max-width: 880px;
  }
  .book-detail .book-subtitle {
    font-family: 'Lora', serif; font-size: 23px; line-height: 1.35;
    font-weight: 400; font-style: italic; color: var(--gray);
    margin: 0 0 26px; max-width: 760px;
  }
  .book-detail .book-status {
    display: inline-block;
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .12em; text-transform: uppercase;
    padding: 6px 13px; margin-bottom: 28px;
  }
  .book-detail .book-status.available    { background: var(--orange); color: var(--white); }
  .book-detail .book-status.forthcoming  { background: var(--gray-light); color: var(--gray); }
  .book-detail .book-desc {
    font-family: 'Poppins', sans-serif; font-size: 18px; line-height: 1.6;
    color: var(--ink); max-width: 720px; margin: 0 0 36px;
  }
  .book-detail .buy-row { display: flex; gap: 16px; flex-wrap: wrap; align-items: center; }
  .btn-buy {
    display: inline-flex; align-items: center; gap: 10px;
    padding: 16px 30px; background: var(--orange); color: var(--white);
    font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600;
    letter-spacing: .1em; text-transform: uppercase;
    text-decoration: none; transition: background .25s ease;
  }
  .btn-buy:hover { background: #d96b00; color: var(--white); }
  .btn-buy .arrow { transition: transform .25s ease; }
  .btn-buy:hover .arrow { transform: translateX(4px); }
  .buy-note {
    font-family: 'Poppins', sans-serif; font-size: 13px; color: var(--gray);
  }

  /* coming-soon variant */
  .book-detail .coming-note {
    display: flex; gap: 14px; align-items: flex-start;
    padding: 24px 26px; background: var(--gray-fill);
    border-left: 3px solid var(--orange); max-width: 720px;
  }
  .book-detail .coming-note .cn-label {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .16em; text-transform: uppercase; color: var(--navy);
    margin-bottom: 6px;
  }
  .book-detail .coming-note p {
    font-family: 'Poppins', sans-serif; font-size: 14px; line-height: 1.6;
    color: var(--ink); margin: 0;
  }

  /* the library section header on a book page */
  .book-detail .book-library { padding: 56px 0 16px; }

  @media (max-width: 720px) {
    .book-detail .book-title { font-size: 34px; }
    .book-detail .book-subtitle { font-size: 19px; }
    .book-detail .book-desc { font-size: 16px; }
  }

  /* BODY CONTENT (marketing copy between hero and library) */
  .book-detail .book-body { padding: 16px 0 8px; }
  .book-detail .book-body h2 { font-family: 'Lora', serif; font-size: 34px; line-height: 1.2; font-weight: 500; color: var(--navy); margin: 32px 0 20px; max-width: 820px; }
  .book-detail .book-body h2 em { font-style: italic; color: var(--orange); }
  .book-detail .book-body h3 { font-family: 'Lora', serif; font-size: 24px; line-height: 1.25; font-weight: 500; color: var(--navy); margin: 40px 0 14px; }
  .book-detail .book-body h3 em { font-style: italic; color: var(--orange); }
  .book-detail .book-body p { font-family: 'Poppins', sans-serif; font-size: 17px; line-height: 1.65; color: var(--ink); margin: 0 0 18px; max-width: 760px; }
  .book-detail .book-body strong { color: var(--navy); font-weight: 600; }
  .book-detail .book-body p em { font-style: italic; color: var(--orange); font-weight: 500; }
  @media (max-width: 720px) {
    .book-detail .book-body h2 { font-size: 27px; }
    .book-detail .book-body h3 { font-size: 21px; }
    .book-detail .book-body p { font-size: 16px; }
  }
</style>

<?php // shared books CSS below ?>
<style>
  :root {
    --navy: #201868;
    --orange: #F07800;
    --white: #FFFFFF;
    --paper: #FAFAFA;
    --gray: #7A8A9E;
    --gray-light: #E8ECF1;
    --gray-fill: #F5F5F7;
    --ink: #1A1A2E;
  }

  .books-page { background: var(--white); color: var(--ink); }
  .books-page .container { max-width: 1200px; margin: 0 auto; padding: 0 32px; }

  /* HERO */
  .books-hero { padding: 96px 0 64px; border-bottom: 1px solid var(--gray-light); }
  .books-hero .eyebrow {
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: .18em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 28px;
  }
  .books-hero h1 {
    font-family: 'Lora', serif; font-size: 56px; line-height: 1.05;
    font-weight: 500; color: var(--navy); margin: 0 0 28px;
    max-width: 880px;
  }
  .books-hero h1 em { font-style: italic; color: var(--orange); font-weight: 500; }
  .books-hero .lede {
    font-family: 'Poppins', sans-serif; font-size: 19px; line-height: 1.55;
    color: var(--ink); max-width: 720px; margin: 0;
  }

  /* PILLAR HEADERS */
  .pillar-header { padding: 80px 0 32px; }
  .pillar-header .tag {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--gray);
    margin-bottom: 16px;
  }
  .pillar-header h2 {
    font-family: 'Lora', serif; font-size: 38px; line-height: 1.15;
    font-weight: 500; color: var(--navy); margin: 0 0 18px;
  }
  .pillar-header h2 em { font-style: italic; color: var(--orange); font-weight: 500; }
  .pillar-header p {
    font-family: 'Poppins', sans-serif; font-size: 16px; line-height: 1.6;
    color: var(--ink); max-width: 720px; margin: 0;
  }

  /* BOOK CARDS GRID */
  .books-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 28px; padding-bottom: 16px; }
  @media (max-width: 820px) { .books-grid { grid-template-columns: 1fr; } }

  .book-card {
    position: relative;
    background: var(--white); padding: 40px 36px 36px;
    border: 1px solid var(--gray-light); transition: border-color .3s ease;
  }
  .book-card::before, .book-card::after,
  .book-card .corner-tl, .book-card .corner-br {
    content: ''; position: absolute; width: 22px; height: 22px; border: 2px solid var(--navy);
  }
  .book-card::before { top: -1px; left: -1px; border-right: 0; border-bottom: 0; }
  .book-card::after { top: -1px; right: -1px; border-left: 0; border-bottom: 0; }
  .book-card .corner-bl { position: absolute; bottom: -1px; left: -1px; width: 22px; height: 22px; border: 2px solid var(--navy); border-right: 0; border-top: 0; }
  .book-card .corner-br { bottom: -1px; right: -1px; border-left: 0; border-top: 0; }

  .book-card.featured { grid-column: 1 / -1; padding: 56px 48px 48px; background: var(--paper); }

  .book-card .book-num {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 12px;
  }
  .book-card h3 {
    font-family: 'Lora', serif; font-size: 26px; line-height: 1.25;
    font-weight: 500; color: var(--navy); margin: 0 0 16px;
  }
  .book-card.featured h3 { font-size: 36px; line-height: 1.15; }
  .book-card .status {
    display: inline-block;
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .12em; text-transform: uppercase;
    padding: 5px 12px; margin-bottom: 22px;
  }
  .book-card .status.available { background: var(--orange); color: var(--white); }
  .book-card .status.forthcoming { background: var(--gray-light); color: var(--gray); }

  .book-card .summary {
    font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 1.6;
    color: var(--ink); margin: 0 0 24px;
  }
  .book-card.featured .summary { font-size: 17px; max-width: 760px; }

  /* TEMPLATE LIBRARY (under Book 1) */
  .template-library { margin-top: 36px; padding-top: 36px; border-top: 1px solid var(--gray-light); }
  .template-library .lib-label {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--navy);
    margin-bottom: 14px;
  }
  .template-library h4 {
    font-family: 'Lora', serif; font-size: 28px; line-height: 1.15;
    font-weight: 500; color: var(--navy); margin: 0 0 16px;
  }
  .template-library h4 em { font-style: italic; color: var(--orange); }
  .template-library .lib-intro {
    font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 1.6;
    color: var(--ink); margin: 0 0 32px; max-width: 760px;
  }

  /* MASTER DOWNLOAD CALLOUT */
  .master-download {
    display: flex; align-items: center; justify-content: space-between; gap: 24px;
    padding: 28px 32px; background: var(--navy); color: var(--white);
    margin-bottom: 32px; flex-wrap: wrap;
  }
  .master-download .md-text { flex: 1; min-width: 280px; }
  .master-download .md-text .label {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .18em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 8px;
  }
  .master-download .md-text .name {
    font-family: 'Lora', serif; font-size: 22px; font-weight: 500;
    color: var(--white); margin: 0 0 6px;
  }
  .master-download .md-text .detail {
    font-family: 'Poppins', sans-serif; font-size: 13px;
    color: rgba(255,255,255,0.75); margin: 0;
  }
  .btn-master {
    display: inline-flex; align-items: center; gap: 10px;
    padding: 16px 28px; background: var(--orange); color: var(--white);
    font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600;
    letter-spacing: .1em; text-transform: uppercase;
    transition: background .25s ease; text-decoration: none;
  }
  .btn-master:hover { background: #d96b00; color: var(--white); }
  .btn-master .arrow { transition: transform .25s ease; }
  .btn-master:hover .arrow { transform: translateX(4px); }

  /* INDIVIDUAL TEMPLATE GRID */
  .templates-grid {
    display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;
  }
  @media (max-width: 720px) { .templates-grid { grid-template-columns: 1fr; } }

  .template-item {
    display: flex; align-items: center; justify-content: space-between; gap: 14px;
    padding: 18px 22px; background: var(--white);
    border: 1px solid var(--gray-light);
    text-decoration: none; color: var(--ink);
    transition: border-color .25s ease, transform .25s ease;
  }
  .template-item:hover { border-color: var(--orange); transform: translateX(2px); color: var(--ink); }
  .template-item .ti-num {
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
    color: var(--orange); min-width: 22px;
  }
  .template-item .ti-name {
    flex: 1;
    font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500;
    color: var(--navy); line-height: 1.3;
  }
  .template-item .ti-type {
    font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 600;
    letter-spacing: .12em; text-transform: uppercase; color: var(--gray);
  }

  /* CHAPTER GRAPHICS LIBRARY */
  .graphics-library { margin-top: 48px; padding-top: 36px; border-top: 1px solid var(--gray-light); }
  .graphics-library .lib-label {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--navy);
    margin-bottom: 14px;
  }
  .graphics-library h4 {
    font-family: 'Lora', serif; font-size: 28px; line-height: 1.15;
    font-weight: 500; color: var(--navy); margin: 0 0 16px;
  }
  .graphics-library h4 em { font-style: italic; color: var(--orange); }
  .graphics-library .lib-intro {
    font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 1.6;
    color: var(--ink); margin: 0 0 32px; max-width: 760px;
  }

  .chapter-nav {
    position: sticky; top: 0; z-index: 10;
    display: flex; flex-wrap: wrap; gap: 8px;
    padding: 14px 0; margin-bottom: 28px;
    background: var(--paper);
    border-bottom: 1px solid var(--gray-light);
  }
  .chapter-nav a {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .08em; color: var(--navy); text-decoration: none;
    padding: 7px 14px; border: 1px solid var(--gray-light);
    background: var(--white);
    transition: all .2s ease;
  }
  .chapter-nav a:hover { background: var(--navy); color: var(--white); border-color: var(--navy); }

  .chapter-graphics-block { margin-bottom: 48px; padding-top: 16px; scroll-margin-top: 80px; }
  .chapter-graphics-block h5 {
    font-family: 'Lora', serif; font-size: 22px; font-weight: 500;
    color: var(--navy); margin: 0 0 18px;
  }
  .chapter-graphics-block h5 em { font-style: italic; color: var(--orange); font-weight: 500; }

  .graphics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
  }

  .graphic-card {
    display: flex; flex-direction: column;
    background: var(--white);
    border: 1px solid var(--gray-light);
    text-decoration: none; color: var(--ink);
    transition: border-color .25s ease, transform .25s ease, box-shadow .25s ease;
    overflow: hidden;
  }
  .graphic-card:hover {
    border-color: var(--orange);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px -8px rgba(32, 24, 104, 0.15);
    color: var(--ink);
  }
  .graphic-card .thumb {
    width: 100%; height: 160px; object-fit: contain;
    background: var(--gray-fill);
    padding: 12px;
    box-sizing: border-box;
  }
  .graphic-card .gc-meta {
    padding: 14px 16px;
    border-top: 1px solid var(--gray-light);
    flex: 1;
    display: flex; flex-direction: column; justify-content: space-between;
  }
  .graphic-card .gc-name {
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 500;
    color: var(--navy); line-height: 1.4;
    margin-bottom: 8px;
  }
  .graphic-card .gc-action {
    font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 600;
    letter-spacing: .12em; text-transform: uppercase; color: var(--orange);
  }

  .companion-formats {
    margin-top: 24px; padding: 24px;
    background: var(--gray-fill); border-left: 3px solid var(--orange);
  }
  .companion-formats .cf-label {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .18em; text-transform: uppercase; color: var(--navy);
    margin-bottom: 10px;
  }
  .companion-formats p {
    font-family: 'Poppins', sans-serif; font-size: 14px; line-height: 1.55;
    color: var(--ink); margin: 0 0 12px;
  }
  .cf-links { display: flex; gap: 16px; flex-wrap: wrap; }
  .cf-links a {
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
    color: var(--navy); text-decoration: none; border-bottom: 1px solid var(--navy);
    letter-spacing: .04em;
  }
  .cf-links a:hover { color: var(--orange); border-bottom-color: var(--orange); }

  /* FORTHCOMING BOOK CARD */
  .book-card.coming { background: var(--paper); }
  .book-card.coming::before, .book-card.coming::after,
  .book-card.coming .corner-bl, .book-card.coming .corner-br {
    border-color: var(--gray);
  }
  .book-card.coming h3 { color: var(--gray); }
  .book-card.coming .summary { color: var(--gray); }

  /* SERIES CTA */
  .series-cta { padding: 96px 0; background: var(--paper); margin-top: 72px;
    border-top: 1px solid var(--gray-light); border-bottom: 1px solid var(--gray-light); }
  .series-cta .label {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600;
    letter-spacing: .2em; text-transform: uppercase; color: var(--orange);
    margin-bottom: 18px;
  }
  .series-cta h2 {
    font-family: 'Lora', serif; font-size: 42px; line-height: 1.15;
    font-weight: 500; color: var(--navy); margin: 0 0 22px;
    max-width: 720px;
  }
  .series-cta h2 em { font-style: italic; color: var(--orange); }
  .series-cta p {
    font-family: 'Poppins', sans-serif; font-size: 17px; line-height: 1.6;
    color: var(--ink); margin: 0 0 36px; max-width: 640px;
  }
  .cta-buttons { display: flex; gap: 16px; flex-wrap: wrap; }
  .btn-primary {
    display: inline-flex; align-items: center; gap: 10px;
    padding: 16px 30px; background: var(--navy); color: var(--white);
    font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600;
    letter-spacing: .1em; text-transform: uppercase;
    transition: background .25s ease; text-decoration: none;
  }
  .btn-primary:hover { background: #150f47; color: var(--white); }
  .btn-secondary {
    display: inline-flex; align-items: center; gap: 10px;
    padding: 16px 30px; background: transparent; color: var(--navy);
    font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600;
    letter-spacing: .1em; text-transform: uppercase;
    border: 1px solid var(--navy); transition: all .25s ease; text-decoration: none;
  }
  .btn-secondary:hover { background: var(--navy); color: var(--white); }

  /* ===== Worksheet gate (July 2, 2026) ===== */
  .book-gate {
    background: #FFF6EC; border-left: 4px solid var(--orange);
    padding: 30px 34px 32px; margin: 0 0 44px;
  }
  .book-gate h5 {
    font-family: 'Lora', serif; font-size: 24px; font-weight: 500;
    color: var(--navy); margin: 0 0 12px;
  }
  .book-gate p {
    font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 1.65;
    color: var(--ink); margin: 0 0 20px; max-width: 660px;
  }
  .book-gate .fluentform, .book-gate form { max-width: 560px; }
  .book-gate .gate-fallback a { color: var(--orange); }
  .book-gate .ff-el-input--label label {
    font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500;
    color: var(--navy);
  }
  .book-gate .ff-el-form-control {
    font-family: 'Poppins', sans-serif; font-size: 15px; color: var(--ink);
    background: var(--white); border: 1px solid #7A8A9E; border-radius: 4px;
    padding: 10px 14px;
  }
  .book-gate .ff-el-form-control:focus {
    border-color: var(--orange); outline: none;
    box-shadow: 0 0 0 2px rgba(240, 120, 0, .18);
  }
  .book-gate .ff-btn-submit {
    font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 600;
    color: var(--white); background: var(--orange); border: none;
    border-radius: 4px; padding: 12px 28px; cursor: pointer;
    transition: background .2s ease;
  }
  .book-gate .ff-btn-submit:hover { background: var(--navy); }
  .book-gate .ff-message-success {
    font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 1.65;
    color: var(--navy); background: var(--white);
    border-left: 4px solid var(--orange); padding: 16px 20px; margin-top: 6px;
  }
  .book-library.srj-locked a[download] { opacity: .55; }
  .book-library.srj-locked a[download]:hover { opacity: .75; }

  @media (max-width: 720px) {
    .books-hero h1 { font-size: 38px; }
    .books-hero .lede { font-size: 17px; }
    .pillar-header h2 { font-size: 30px; }
    .book-card.featured { padding: 36px 28px 32px; }
    .book-card.featured h3 { font-size: 28px; }
    .series-cta h2 { font-size: 32px; }
  }
</style>

<?php /* ===== Optional video + briefing companion sections (rendered only when present in $book) ===== */ ?>
<style>
  .video-embed-section { padding: 80px 0 70px; background: var(--paper); border-bottom: 1px solid var(--line); text-align: center; }
  .video-embed-section .label { justify-content: center; display: inline-flex; margin-bottom: 22px; font-family: 'Inter', sans-serif; font-size: 12px; letter-spacing: .18em; text-transform: uppercase; color: var(--orange); font-weight: 600; }
  .video-embed-section h2 { font-family: 'Lora', serif; font-weight: 500; color: var(--navy); font-size: clamp(30px, 3.6vw, 46px); line-height: 1.15; margin: 0 auto 22px; max-width: 22ch; }
  .video-embed-section h2 em { font-style: italic; color: var(--orange); }
  .video-embed-section .video-lede { font-family: 'Poppins', sans-serif; color: var(--ink-soft); font-size: 17px; line-height: 1.65; max-width: 60ch; margin: 0 auto 44px; }
  .video-frame { position: relative; width: 100%; max-width: 960px; margin: 0 auto; padding-bottom: 56.25%; height: 0; overflow: hidden; background: var(--navy-deep); border-radius: 4px; box-shadow: 0 30px 80px -24px rgba(36, 24, 91, 0.35); }
  .video-frame iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; }
  .video-meta { margin-top: 30px; font-family: 'Inter', sans-serif; font-size: 12.5px; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); font-weight: 500; }
  @media (max-width: 720px) { .video-embed-section { padding: 60px 0 50px; } .video-embed-section .video-lede { margin-bottom: 32px; } }

  .briefing-cta { padding: 80px 0 90px; background: var(--paper-warm); border-bottom: 1px solid var(--line); }
  .briefing-card { max-width: 880px; margin: 0 auto; background: var(--white); border: 1px solid var(--line); padding: 56px 56px 52px; display: grid; grid-template-columns: 1fr 1.4fr; gap: 48px; align-items: center; box-shadow: 0 30px 60px -28px rgba(36, 24, 91, 0.18); }
  .briefing-visual { background: var(--navy-deep); padding: 44px 32px; color: var(--paper); text-align: center; position: relative; overflow: hidden; }
  .briefing-visual::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse at 70% 30%, rgba(239,124,0,.18), transparent 60%); pointer-events: none; }
  .briefing-visual .brief-tag { position: relative; font-family: 'Inter', sans-serif; font-size: 10.5px; letter-spacing: .24em; text-transform: uppercase; color: rgba(245,160,78,.85); font-weight: 600; margin-bottom: 16px; }
  .briefing-visual .brief-title { position: relative; font-family: 'Alike', serif; font-size: 22px; line-height: 1.25; color: var(--paper); margin-bottom: 14px; }
  .briefing-visual .brief-format { position: relative; font-family: 'Inter', sans-serif; font-size: 11px; letter-spacing: .18em; text-transform: uppercase; color: rgba(250,250,246,.55); }
  .briefing-content .label { margin-bottom: 18px; font-family: 'Inter', sans-serif; font-size: 12px; letter-spacing: .18em; text-transform: uppercase; color: var(--orange); font-weight: 600; }
  .briefing-content h2 { font-family: 'Lora', serif; font-weight: 500; color: var(--navy); font-size: clamp(26px, 2.8vw, 34px); line-height: 1.2; margin-bottom: 18px; }
  .briefing-content h2 em { font-style: italic; color: var(--orange); }
  .briefing-content p { font-family: 'Poppins', sans-serif; color: var(--ink-soft); font-size: 15.5px; line-height: 1.7; margin-bottom: 28px; }
  .briefing-actions { display: flex; gap: 14px; flex-wrap: wrap; align-items: center; }
  .btn-brief-view { display: inline-flex; align-items: center; gap: 10px; padding: 14px 26px; background: var(--navy); color: var(--paper); font-family: 'Inter', sans-serif; font-size: 12.5px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; transition: all .25s ease; border: 1px solid var(--navy); text-decoration: none; }
  .btn-brief-view:hover { background: var(--navy-deep); transform: translateY(-1px); color: var(--paper); }
  .btn-brief-download { display: inline-flex; align-items: center; gap: 10px; padding: 14px 26px; background: transparent; color: var(--navy); font-family: 'Inter', sans-serif; font-size: 12.5px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; transition: all .25s ease; border: 1px solid var(--navy); text-decoration: none; }
  .btn-brief-download:hover { background: var(--navy); color: var(--paper); }
  .btn-brief-view .arrow, .btn-brief-download .arrow { transition: transform .25s ease; }
  .btn-brief-view:hover .arrow { transform: translateX(4px); }
  @media (max-width: 820px) {
    .briefing-card { grid-template-columns: 1fr; padding: 40px 32px; gap: 32px; }
    .briefing-visual { padding: 36px 24px; }
  }
</style>

<main class="books-page book-detail">

  <!-- BOOK HERO -->
  <section class="book-hero">
    <div class="container">
      <?php if ( function_exists( 'srj_breadcrumbs' ) ) { srj_breadcrumbs(); } ?>

      <?php if ( $book ) : ?>
        <div class="book-hero-grid<?php echo ! empty( $book['cover'] ) ? ' has-cover' : ''; ?>">
        <div class="book-hero-text">
        <div class="series-eyebrow"><?php echo esc_html( $book['series'] ); ?></div>
        <h1 class="book-title"><?php echo esc_html( $book['title'] ); ?></h1>
        <?php if ( ! empty( $book['subtitle'] ) ) : ?>
          <p class="book-subtitle"><?php echo esc_html( $book['subtitle'] ); ?></p>
        <?php endif; ?>

        <span class="book-status <?php echo esc_attr( $book['status'] ); ?>">
          <?php echo esc_html( $book['status_label'] ); ?>
        </span>

        <p class="book-desc"><?php echo esc_html( $book['description'] ); ?></p>

        <?php if ( 'available' === $book['status'] && ! empty( $book['buy_url'] ) ) : ?>
          <div class="buy-row">
            <a href="<?php echo esc_url( $book['buy_url'] ); ?>" target="_blank" rel="noopener" class="btn-buy">
              <?php echo esc_html( $book['buy_label'] ); ?> <span class="arrow">&rarr;</span>
            </a>
            <?php if ( ! empty( $book['buy_note'] ) ) : ?>
              <span class="buy-note"><?php echo esc_html( $book['buy_note'] ); ?></span>
            <?php endif; ?>
          </div>
        <?php else : ?>
          <div class="coming-note">
            <div>
              <div class="cn-label">Forthcoming</div>
              <p><?php echo esc_html( ! empty( $book['forthcoming_note'] ) ? $book['forthcoming_note'] : 'This volume is in preparation. Subscribe to The AI Operating System newsletter to be notified when it is released.' ); ?></p>
            </div>
          </div>
        <?php endif; ?>
        </div><!-- .book-hero-text -->
        <?php if ( ! empty( $book['cover'] ) ) : ?>
          <div class="book-cover-col">
            <img src="<?php echo esc_url( $book['cover'] ); ?>"
                 alt="<?php echo esc_attr( ! empty( $book['cover_alt'] ) ? $book['cover_alt'] : $book['title'] ); ?>"
                 loading="eager" width="600" height="960">
          </div>
        <?php endif; ?>
        </div><!-- .book-hero-grid -->

      <?php else : ?>
        <?php // Fallback: no config entry matched this page slug. ?>
        <h1 class="book-title"><?php the_title(); ?></h1>
        <p class="book-desc">Book details are being prepared for this page.</p>
      <?php endif; ?>
    </div>
  </section>

  <?php /* ===== VIDEO: walkthrough of the book's framework (renders only when configured) ===== */ ?>
  <?php if ( $book && ! empty( $book['video'] ) && ! empty( $book['video']['youtube_id'] ) ) : $srj_v = $book['video']; ?>
  <section class="video-embed-section">
    <div class="container">
      <div class="label"><?php echo esc_html( $srj_v['label'] ); ?></div>
      <h2><?php echo wp_kses_post( $srj_v['headline'] ); ?></h2>
      <p class="video-lede"><?php echo wp_kses_post( $srj_v['lede'] ); ?></p>
      <div class="video-frame">
        <iframe
          src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr( $srj_v['youtube_id'] ); ?>?rel=0&modestbranding=1"
          title="<?php echo esc_attr( $srj_v['title_attr'] ); ?>"
          loading="lazy"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          referrerpolicy="strict-origin-when-cross-origin"
          allowfullscreen></iframe>
      </div>
      <div class="video-meta"><?php echo wp_kses_post( $srj_v['meta'] ); ?></div>
    </div>
  </section>
  <?php endif; ?>

  <?php /* ===== EXECUTIVE BRIEFING PDF (renders only when configured) ===== */ ?>
  <?php if ( $book && ! empty( $book['briefing'] ) && ! empty( $book['briefing']['pdf_path'] ) ) : $srj_b = $book['briefing']; ?>
  <section class="briefing-cta">
    <div class="container">
      <div class="briefing-card">
        <div class="briefing-visual">
          <div class="brief-tag">Executive Briefing</div>
          <div class="brief-title"><?php echo wp_kses_post( $srj_b['title_html'] ); ?></div>
          <div class="brief-format"><?php echo wp_kses_post( $srj_b['format'] ); ?></div>
        </div>
        <div class="briefing-content">
          <div class="label">Read the Briefing</div>
          <h2>The executive briefing, in <em>one page at a time.</em></h2>
          <p><?php echo wp_kses_post( $srj_b['lede'] ); ?></p>
          <div class="briefing-actions">
            <a href="<?php echo esc_url( home_url( $srj_b['pdf_path'] ) ); ?>" target="_blank" rel="noopener" class="btn-brief-view">
              View Briefing <span class="arrow">&rarr;</span>
            </a>
            <a href="<?php echo esc_url( home_url( $srj_b['pdf_path'] ) ); ?>" download class="btn-brief-download">
              Download PDF
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ( $book && ! empty( $book['body_html'] ) ) : ?>
  <section class="book-body">
    <div class="container">
      <?php echo wp_kses_post( $book['body_html'] ); ?>
    </div>
  </section>
  <?php endif; ?>

  <?php
  /* ===== LIBRARY: worksheets + chapter graphics =====
     Rendered only when the book config provides a 'library_base' path.
     This is the Book 1 library, moved here from the old /books/ hub. */
  if ( $book && ! empty( $book['library_base'] ) ) :
    $graphics_base_path = $book['library_base'];
  ?>
  <section class="book-library">
    <div class="container">

      <?php /* ===== WORKSHEET GATE (July 2, 2026) — hidden by the inline script below when the srj_worksheet_access cookie is present. ===== */ ?>
      <div class="book-gate" id="srj-book-gate">
        <h5>Free downloads for this book</h5>
        <p>The worksheets and templates that ship with this book are free. Enter your email once, click the confirmation link we send you, and every book's downloads unlock across the site, forever.</p>
        <?php if ( defined( 'SRJ_WORKSHEET_FORM_ID' ) && SRJ_WORKSHEET_FORM_ID > 0 && shortcode_exists( 'fluentform' ) ) : ?>
          <?php echo do_shortcode( '[fluentform id="' . (int) SRJ_WORKSHEET_FORM_ID . '"]' ); ?>
        <?php else : ?>
          <p class="gate-fallback">The unlock form is being configured. In the meantime, you can subscribe on the <a href="<?php echo esc_url( home_url( '/newsletter/' ) ); ?>">newsletter page</a>, and the downloads below remain available.</p>
        <?php endif; ?>
      </div>

      <!-- WORKSHEET LIBRARY -->
      <div class="template-library" style="border-top:0;margin-top:0;padding-top:0;">
        <div class="lib-label"><?php echo esc_html( ! empty( $book['worksheet_label'] ) ? $book['worksheet_label'] : 'Companion Worksheets' ); ?></div>
        <?php if ( ! empty( $book['worksheet_heading'] ) ) : ?><h4><?php echo wp_kses_post( $book['worksheet_heading'] ); ?></h4><?php endif; ?>
        <?php if ( ! empty( $book['worksheet_intro'] ) ) : ?><p class="lib-intro"><?php echo esc_html( $book['worksheet_intro'] ); ?></p><?php endif; ?>

        <?php if ( ! empty( $book['master'] ) ) : $srj_m = $book['master']; ?>
        <div class="master-download">
          <div class="md-text">
            <div class="label"><?php echo esc_html( ! empty( $srj_m['label'] ) ? $srj_m['label'] : 'Recommended Starting Point' ); ?></div>
            <div class="name"><?php echo esc_html( $srj_m['name'] ); ?></div>
            <?php if ( ! empty( $srj_m['detail'] ) ) : ?><p class="detail"><?php echo esc_html( $srj_m['detail'] ); ?></p><?php endif; ?>
          </div>
          <a href="<?php echo esc_url( home_url( $graphics_base_path . $srj_m['file'] ) ); ?>" download class="btn-master">
            <?php echo esc_html( ! empty( $srj_m['button'] ) ? $srj_m['button'] : 'Download' ); ?> <span class="arrow">&rarr;</span>
          </a>
        </div>
        <?php endif; ?>

        <?php if ( ! empty( $book['worksheets'] ) ) : ?>
        <div class="templates-grid">
          <?php foreach ( $book['worksheets'] as $srj_w ) : ?>
          <a href="<?php echo esc_url( home_url( $graphics_base_path . $srj_w['file'] ) ); ?>" download class="template-item">
            <span class="ti-num"><?php echo esc_html( $srj_w['num'] ); ?></span><span class="ti-name"><?php echo wp_kses_post( $srj_w['name'] ); ?></span><span class="ti-type"><?php echo esc_html( ! empty( $srj_w['type'] ) ? $srj_w['type'] : 'XLSX' ); ?></span>
          </a>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if ( ! empty( $book['companion_docs'] ) && ! empty( $book['companion_docs']['links'] ) ) : $srj_cd = $book['companion_docs']; ?>
        <div class="companion-formats">
          <div class="cf-label">Also Available</div>
          <?php if ( ! empty( $srj_cd['intro'] ) ) : ?><p><?php echo esc_html( $srj_cd['intro'] ); ?></p><?php endif; ?>
          <div class="cf-links">
            <?php foreach ( $srj_cd['links'] as $srj_l ) : ?>
            <a href="<?php echo esc_url( home_url( $graphics_base_path . $srj_l['file'] ) ); ?>" download><?php echo esc_html( $srj_l['label'] ); ?> &darr;</a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <!-- CHAPTER GRAPHICS LIBRARY (auto-discovered) -->
      <?php
      $graphics_chapters = ( ! empty( $book['chapters'] ) && is_array( $book['chapters'] ) )
        ? $book['chapters']
        : srj_books_autodiscover_chapters( $graphics_base_path );
      $image_extensions = array('png', 'jpg', 'jpeg', 'svg', 'gif', 'webp');

      $chapters_with_graphics = array();
      foreach ($graphics_chapters as $folder => $info) {
        $abs_path = ABSPATH . ltrim($graphics_base_path . '/' . $folder, '/');
        $files = array();
        if (is_dir($abs_path)) {
          $scan = @scandir($abs_path);
          if ($scan !== false) {
            foreach ($scan as $file) {
              if ($file === '.' || $file === '..') continue;
              $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
              if (strpos(pathinfo($file, PATHINFO_FILENAME), '-srjprev') !== false) continue;
              if (in_array($ext, $image_extensions, true)) { $files[] = $file; }
            }
          }
        }
        if (count($files) > 0) {
          sort($files);
          $chapters_with_graphics[$folder] = array('info' => $info, 'files' => $files);
        }
      }

      if (count($chapters_with_graphics) > 0): ?>
      <div class="graphics-library">
        <div class="lib-label">Chapter Graphics Library</div>
        <h4>Visual frameworks, ready for your <em>presentations.</em></h4>
        <p class="lib-intro">Every diagram, framework, and chart from the book is available here as an individual file. Use them in your slide decks, internal memos, board presentations, or training sessions. Free to use within your organization. Browse by chapter, click any image to download.</p>

        <nav class="chapter-nav">
          <?php foreach ($chapters_with_graphics as $folder => $data): ?>
            <a href="#<?php echo esc_attr($data['info']['id']); ?>"><?php echo esc_html($data['info']['nav_label']); ?></a>
          <?php endforeach; ?>
        </nav>

        <?php foreach ($chapters_with_graphics as $folder => $data): ?>
        <div class="chapter-graphics-block" id="<?php echo esc_attr($data['info']['id']); ?>">
          <h5><?php echo wp_kses_post($data['info']['heading_html']); ?></h5>
          <div class="graphics-grid">
            <?php foreach ($data['files'] as $file):
              $file_url = home_url($graphics_base_path . '/' . $folder . '/' . $file);
              $file_abs = ABSPATH . ltrim($graphics_base_path . '/' . $folder . '/' . $file, '/');
              $display_name = pathinfo($file, PATHINFO_FILENAME);
              $display_name = str_replace(array('_', '-'), ' ', $display_name);
              $display_name = trim(preg_replace('/^chapter\\s*\\d+\\s*/i', '', $display_name));
              $display_name = ucwords($display_name);
              $preview = srj_books_graphic_preview($file_abs, $file_url);
            ?>
            <a href="<?php echo esc_url($file_url); ?>" download class="graphic-card">
              <img class="thumb"
                   src="<?php echo esc_url($preview['url']); ?>"
                   <?php if ($preview['width'] && $preview['height']) : ?>width="<?php echo (int) $preview['width']; ?>" height="<?php echo (int) $preview['height']; ?>"<?php endif; ?>
                   alt="<?php echo esc_attr($display_name); ?>"
                   loading="lazy" decoding="async">
              <div class="gc-meta">
                <div class="gc-name"><?php echo esc_html($display_name); ?></div>
                <div class="gc-action">Download &darr;</div>
              </div>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

    </div>
  </section>

  <?php /* ===== WORKSHEET GATE SCRIPT (July 2, 2026) — cache-safe client-side gate over the server-set srj_worksheet_access cookie. Covers the library section only (worksheets, master workbook, companion docs, chapter graphics). The executive briefing PDF is deliberately ungated (operator decision, July 2 2026): it is marketing collateral, not book toolkit content. ===== */ ?>
  <script>
  (function () {
    var lib  = document.querySelector('.book-library');
    var gate = document.getElementById('srj-book-gate');
    if (!lib || !gate) { return; }

    var unlockedFlag = false;

    function hasAccess() {
      return document.cookie.indexOf('srj_worksheet_access=1') !== -1;
    }

    function unlock() {
      unlockedFlag = true;
      gate.style.display = 'none';
      lib.classList.remove('srj-locked');
    }

    if (hasAccess()) {
      unlock();
      return;
    }

    lib.classList.add('srj-locked');

    /* Intercept clicks on any gated download link while locked; route the visitor to the gate form. */
    lib.addEventListener('click', function (e) {
      if (unlockedFlag) { return; }
      var link = e.target && e.target.closest ? e.target.closest('a[download]') : null;
      if (!link) { return; }
      e.preventDefault();
      gate.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });

    /* No unlock on form submit: the srj_worksheet_access cookie is set only
       by the signed confirmation link emailed to the subscriber (handled
       server-side in inc/beehiiv-integration.php). */
  })();
  </script>
  <?php endif; // library ?>

  <!-- SERIES CTA -->
  <section class="series-cta">
    <div class="container">
      <div class="label">The Series</div>
      <h2>Explore the full <em>book series.</em></h2>
      <p>The Operating Discipline for AI Library&trade; is the nine-book series across two pillars &mdash; AI Business Services&trade; (four books) and AI Risk Governance &amp; Security&trade; (five books) &mdash; each mapped to one of the nine SRJ service lines. Browse the series, or speak with us directly about applying the framework in your organization.</p>
      <div class="cta-buttons">
        <a href="<?php echo esc_url( home_url( '/books/' ) ); ?>" class="btn-primary">All Books <span class="arrow">&rarr;</span></a>
        <a href="<?php echo esc_url( srj_get_booking() ); ?>" target="_blank" rel="noopener" class="btn-secondary">Schedule a Consultation</a>
      </div>
    </div>
  </section>

</main>

<?php
get_footer();
