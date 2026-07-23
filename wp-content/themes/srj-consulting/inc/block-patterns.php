<?php
/**
 * Block Pattern Registration
 *
 * Registers custom block patterns under the "SRJ" category.
 * Patterns can be inserted from the block inserter -> Patterns tab.
 *
 * @package SRJ_Consulting
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register a custom block pattern category for SRJ patterns.
 */
function srj_register_block_pattern_category() {
    if ( function_exists( 'register_block_pattern_category' ) ) {
        register_block_pattern_category(
            'srj',
            array(
                'label'       => __( 'SRJ Consulting', 'srj-consulting' ),
                'description' => __( 'Reusable patterns for SRJ Consulting & Services pages.', 'srj-consulting' ),
            )
        );
    }
}
add_action( 'init', 'srj_register_block_pattern_category' );

/**
 * Register the patterns themselves.
 */
function srj_register_block_patterns() {

    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    // -- Pattern: Section Eyebrow + Heading + Intro -----------------------
    register_block_pattern(
        'srj/section-hero',
        array(
            'title'       => __( 'SRJ Section Hero', 'srj-consulting' ),
            'description' => __( 'A page-opening section with a small eyebrow label, a large heading, and an intro paragraph.', 'srj-consulting' ),
            'categories'  => array( 'srj' ),
            'content'     => '<!-- wp:group {"className":"srj-section-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group srj-section-hero"><!-- wp:paragraph {"className":"srj-eyebrow"} -->
<p class="srj-eyebrow">Section Label</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"srj-section-heading"} -->
<h1 class="wp-block-heading srj-section-heading">Section heading goes here, <em>two or three lines maximum.</em></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"srj-section-intro"} -->
<p class="srj-section-intro">Intro paragraph that frames the rest of the section. Keep this tight, two sentences ideally, three at the most.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->',
        )
    );

    // -- Pattern: Standard Content Section --------------------------------
    register_block_pattern(
        'srj/content-section',
        array(
            'title'       => __( 'SRJ Content Section', 'srj-consulting' ),
            'description' => __( 'A standard content section with H2 heading and prose paragraphs.', 'srj-consulting' ),
            'categories'  => array( 'srj' ),
            'content'     => '<!-- wp:group {"className":"srj-content-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group srj-content-section"><!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Section heading</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>First paragraph of the section.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Second paragraph of the section.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->',
        )
    );

    // -- Pattern: Person Block (Image + Bio) ------------------------------
    register_block_pattern(
        'srj/person-block',
        array(
            'title'       => __( 'SRJ Person Block', 'srj-consulting' ),
            'description' => __( 'A two-column section with a portrait image on the left and biographical text on the right.', 'srj-consulting' ),
            'categories'  => array( 'srj' ),
            'content'     => '<!-- wp:group {"className":"srj-person-block","layout":{"type":"constrained"}} -->
<div class="wp-block-group srj-person-block"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"35%"} -->
<div class="wp-block-column" style="flex-basis:35%"><!-- wp:image {"className":"srj-portrait"} -->
<figure class="wp-block-image srj-portrait"><img alt="Portrait" /><figcaption class="wp-element-caption"><em>Caption goes here</em></figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"65%"} -->
<div class="wp-block-column" style="flex-basis:65%"><!-- wp:paragraph -->
<p>Bio paragraph 1.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Bio paragraph 2.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
        )
    );

    // -- Pattern: CTA Section ---------------------------------------------
    register_block_pattern(
        'srj/cta-section',
        array(
            'title'       => __( 'SRJ CTA Section', 'srj-consulting' ),
            'description' => __( 'A page-closing call to action with heading, lead text, button, and phone number.', 'srj-consulting' ),
            'categories'  => array( 'srj' ),
            'content'     => '<!-- wp:group {"className":"srj-cta-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group srj-cta-section"><!-- wp:paragraph {"className":"srj-eyebrow"} -->
<p class="srj-eyebrow">Begin the Engagement</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"className":"srj-cta-heading"} -->
<h2 class="wp-block-heading srj-cta-heading">Bring AI under <em>operating control.</em></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>A 30-minute consultation to scope the question your leadership team needs answered. No deck, no pitch.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"srj-cta-button"} -->
<div class="wp-block-button srj-cta-button"><a class="wp-block-button__link wp-element-button" href="https://calendly.com/srj-srjconsultingservices/schedule-a-free-30-minute-ai-consultation">Schedule a Free AI Consultation \u2192</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"className":"srj-cta-phone"} -->
<p class="srj-cta-phone">or speak directly <a href="tel:+14154137772">(415) 413-7772</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->',
        )
    );
}
add_action( 'init', 'srj_register_block_patterns' );
