<?php
/**
 * Theme Customizer Settings
 * Appearance > Customize > SRJ Settings
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function srj_customize_register( $wp_customize ) {

    /* ==================================================================
       SRJ CONTACT INFO PANEL
       ================================================================== */

    $wp_customize->add_section( 'srj_contact', array(
        'title'    => __( 'SRJ Contact Info', 'srj-consulting' ),
        'priority' => 30,
        'description' => __( 'Phone, email, Calendly URL, and office address used across the site.', 'srj-consulting' ),
    ) );

    // Phone (display)
    $wp_customize->add_setting( 'srj_phone_display', array(
        'default'           => '(415) 413-7772',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'srj_phone_display', array(
        'label'    => __( 'Phone Number (Display)', 'srj-consulting' ),
        'description' => __( 'e.g. (415) 413-7772', 'srj-consulting' ),
        'section'  => 'srj_contact',
        'type'     => 'text',
    ) );

    // Phone (tel: link)
    $wp_customize->add_setting( 'srj_phone_tel', array(
        'default'           => '+14154137772',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'srj_phone_tel', array(
        'label'    => __( 'Phone (tel: Link Format)', 'srj-consulting' ),
        'description' => __( 'For click-to-call. Format: +14154137772', 'srj-consulting' ),
        'section'  => 'srj_contact',
        'type'     => 'text',
    ) );

    // Email
    $wp_customize->add_setting( 'srj_email', array(
        'default'           => 'info@srjconsultingservices.com',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'srj_email', array(
        'label'    => __( 'Email Address', 'srj-consulting' ),
        'section'  => 'srj_contact',
        'type'     => 'email',
    ) );

    // Calendly URL
    $wp_customize->add_setting( 'srj_calendly_url', array(
        'default'           => 'https://calendly.com/srj-srjconsultingservices/schedule-a-free-30-minute-ai-consultation',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'srj_calendly_url', array(
        'label'    => __( 'Calendly URL', 'srj-consulting' ),
        'description' => __( 'Full URL to your booking page. Used on every Schedule button across the site.', 'srj-consulting' ),
        'section'  => 'srj_contact',
        'type'     => 'url',
    ) );

    // Office address line 1
    $wp_customize->add_setting( 'srj_address_line1', array(
        'default'           => '13054 Cinderella Ln',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'srj_address_line1', array(
        'label'    => __( 'Office Street', 'srj-consulting' ),
        'section'  => 'srj_contact',
        'type'     => 'text',
    ) );

    // Office address line 2
    $wp_customize->add_setting( 'srj_address_line2', array(
        'default'           => 'Frisco, TX',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'srj_address_line2', array(
        'label'    => __( 'Office City/State', 'srj-consulting' ),
        'section'  => 'srj_contact',
        'type'     => 'text',
    ) );

    // Office display location (for announce bar)
    $wp_customize->add_setting( 'srj_office_short', array(
        'default'           => 'Frisco, TX',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'srj_office_short', array(
        'label'    => __( 'Short Location (Announce Bar)', 'srj-consulting' ),
        'description' => __( 'Short location, e.g. "Frisco, TX"', 'srj-consulting' ),
        'section'  => 'srj_contact',
        'type'     => 'text',
    ) );
}
add_action( 'customize_register', 'srj_customize_register' );
