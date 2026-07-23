<?php
/**
 * Beehiiv Integration for Fluent Forms
 *
 * Pushes newsletter signup form submissions to the Beehiiv API,
 * creating subscribers automatically without paid webhook/Zapier middleware.
 *
 * Runs on the free Fluent Forms tier and the free Beehiiv Launch plan.
 *
 * v1.3.0 (July 2, 2026): Email confirmation required before unlock, and
 * worksheet access is fully separate from the newsletter. The worksheet
 * form does NOT push to Beehiiv and does NOT enroll any automation; it
 * only sends a confirmation email (via wp_mail / WP Mail SMTP) containing
 * a signed, stateless unlock link (HMAC of the email keyed by wp_salt).
 * Clicking the link validates the token, sets the srj_worksheet_access
 * cookie (10 years), and redirects to /books/. New functions:
 * srj_worksheet_token(), srj_worksheet_send_confirmation(),
 * srj_worksheet_confirm_unlock() on admin-ajax (cache-immune). Newsletter form
 * (ID 2) behavior is unchanged.
 *
 * v1.2.0 (July 2, 2026): Worksheet download gate. The file now also handles
 * the SRJ Worksheet Access form (book-page download gate): submissions on
 * that form are pushed to Beehiiv with utm_campaign 'worksheet_download'
 * (so the cohort is separable from newsletter signups in Beehiiv analytics),
 * enrolled in the same Welcome automation, and the srj_worksheet_access
 * cookie is set on the AJAX response (10-year lifetime, path /, SameSite
 * Lax) so every book page's download library unlocks for that visitor
 * permanently. New helper srj_worksheet_access() reads the cookie
 * server-side. The gate rendering itself lives in page-book-detail.php.
 *
 * v1.1.0 (May 20, 2026): Added automation_ids parameter so new subscribers
 * enter the Welcome Email automation flow.
 *
 * v1.0.0 (May 20, 2026): Initial implementation.
 *
 * SETUP INSTRUCTIONS:
 *   1. Below, replace PASTE_YOUR_API_KEY_HERE with your real Beehiiv API key
 *      (only on first install - leave the key in place when upgrading).
 *   2. All other values are pre-configured for The AI Operating System.
 *   3. Save this file and upload to /wp-content/themes/srj-consulting/inc/.
 *
 * SECURITY NOTE:
 *   This file contains a private API key. Do NOT share or commit it to
 *   version control. If the key is ever exposed, immediately delete it
 *   in Beehiiv and create a new one.
 *
 * @package SRJ_Consulting
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// === CONFIGURATION ===
// Replace this placeholder string with your real Beehiiv API key.
define( 'SRJ_BEEHIIV_API_KEY', 'SQOe2DtsbZ42e1meVR7F9BeSvYSPcOllXCyxLCmJfSgIJEiq9UdxpXgiVojz6S8t' );

// V2 Publication ID for The AI Operating System(TM).
define( 'SRJ_BEEHIIV_PUBLICATION_ID', 'pub_a4172599-17b8-4548-a0dc-2a3fd73d791b' );

// Fluent Forms form ID for the Newsletter Signup form.
define( 'SRJ_BEEHIIV_FORM_ID', 2 );

// Fluent Forms form ID for the SRJ Worksheet Access form (book-page download
// gate, July 2 2026).
define( 'SRJ_WORKSHEET_FORM_ID', 4 );

// Cookie that marks a visitor as having unlocked the worksheet libraries.
// Read by srj_worksheet_access() below and by the client-side gate script
// in page-book-detail.php. Declared to Complianz as a functional cookie.
define( 'SRJ_WORKSHEET_COOKIE', 'srj_worksheet_access' );

// Welcome Email automation ID (created in Beehiiv > Automations).
// New subscribers will be enrolled in this automation, which triggers the
// welcome email. Comma-separate multiple IDs if enrolling in more than one.
define( 'SRJ_BEEHIIV_AUTOMATION_ID', 'aut_04f100b6-df3a-4ee1-999c-a8556384034c' );

// === HOOK ===
add_action( 'fluentform/submission_inserted', 'srj_beehiiv_push_subscriber', 20, 3 );

/**
 * Push a Fluent Forms submission to Beehiiv as a new subscriber.
 *
 * Fires when a form is submitted and saved to the WordPress database.
 * Only acts on the configured newsletter form (ignores all other forms).
 *
 * @param int   $entry_id The Fluent Forms submission ID.
 * @param array $form_data The submitted form field data.
 * @param object $form The form object (contains $form->id).
 */
function srj_beehiiv_push_subscriber( $entry_id, $form_data, $form ) {
    // Determine which SRJ form fired; bail on everything else.
    $is_newsletter = ( (int) $form->id === (int) SRJ_BEEHIIV_FORM_ID );
    $is_worksheet  = ( defined( 'SRJ_WORKSHEET_FORM_ID' ) && SRJ_WORKSHEET_FORM_ID > 0 && (int) $form->id === (int) SRJ_WORKSHEET_FORM_ID );
    if ( ! $is_newsletter && ! $is_worksheet ) {
        return;
    }

    // Bail if API key has not been configured.
    if ( SRJ_BEEHIIV_API_KEY === 'PASTE_YOUR_API_KEY_HERE' || empty( SRJ_BEEHIIV_API_KEY ) ) {
        error_log( 'SRJ Beehiiv Integration: API key not configured. Skipping submission #' . $entry_id );
        return;
    }

    // Extract the email address.
    $email = srj_beehiiv_extract_email( $form_data );
    if ( empty( $email ) || ! is_email( $email ) ) {
        error_log( 'SRJ Beehiiv Integration: Missing or invalid email in submission #' . $entry_id );
        return;
    }

    // Extract the first name (optional).
    $first_name = srj_beehiiv_extract_first_name( $form_data );

    // Worksheet gate: email confirmation required before unlock (July 2 2026).
    // Access is fully separate from the newsletter: no Beehiiv push, no
    // automation enrollment. Send the confirmation email and stop;
    // srj_worksheet_confirm_unlock() below validates the link and sets the
    // access cookie on click.
    if ( $is_worksheet ) {
        srj_worksheet_send_confirmation( $email );
        return;
    }

    // Build the API request body.
    $body = array(
        'email'               => $email,
        'reactivate_existing' => true,
        'send_welcome_email'  => false, // The Welcome automation handles this.
        'utm_source'          => 'srjconsultingservices.com',
        'utm_medium'          => 'website_form',
        'utm_campaign'        => 'newsletter_signup',
        'referring_site'      => home_url(),
    );

    // Enroll in the Welcome Email automation.
    if ( ! empty( SRJ_BEEHIIV_AUTOMATION_ID ) ) {
        $body['automation_ids'] = array( SRJ_BEEHIIV_AUTOMATION_ID );
    }

    if ( ! empty( $first_name ) ) {
        $body['custom_fields'] = array(
            array(
                'name'  => 'First Name',
                'value' => $first_name,
            ),
        );
    }

    // Call the Beehiiv Create Subscription endpoint.
    $api_url = 'https://api.beehiiv.com/v2/publications/' . SRJ_BEEHIIV_PUBLICATION_ID . '/subscriptions';

    $response = wp_remote_post(
        $api_url,
        array(
            'timeout' => 15,
            'headers' => array(
                'Authorization' => 'Bearer ' . SRJ_BEEHIIV_API_KEY,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ),
            'body'    => wp_json_encode( $body ),
        )
    );

    // Handle WP HTTP errors (network failure, timeout, etc).
    if ( is_wp_error( $response ) ) {
        error_log( 'SRJ Beehiiv Integration: API request failed for submission #' . $entry_id . ' - ' . $response->get_error_message() );
        return;
    }

    $response_code = wp_remote_retrieve_response_code( $response );
    $response_body = wp_remote_retrieve_body( $response );

    if ( $response_code >= 200 && $response_code < 300 ) {
        error_log( 'SRJ Beehiiv Integration: Subscriber added successfully (' . $email . ') for submission #' . $entry_id );
    } else {
        error_log( 'SRJ Beehiiv Integration: API returned HTTP ' . $response_code . ' for submission #' . $entry_id . ' - ' . $response_body );
    }
}

/**
 * Extract email from Fluent Forms submission data.
 * Handles a few common field name patterns.
 *
 * @param array $form_data
 * @return string
 */
function srj_beehiiv_extract_email( $form_data ) {
    $candidates = array( 'email', 'email_address', 'subscriber_email', 'user_email' );

    foreach ( $candidates as $key ) {
        if ( ! empty( $form_data[ $key ] ) ) {
            return sanitize_email( $form_data[ $key ] );
        }
    }

    // Fallback: scan all submitted values for the first valid email format.
    foreach ( $form_data as $value ) {
        if ( is_string( $value ) && is_email( $value ) ) {
            return sanitize_email( $value );
        }
    }

    return '';
}

/**
 * Extract first name from Fluent Forms submission data.
 * Handles Simple Text, Name Fields, and other common field structures.
 *
 * @param array $form_data
 * @return string
 */
function srj_beehiiv_extract_first_name( $form_data ) {
    // Direct match for common first-name field keys.
    $direct_keys = array( 'first_name', 'firstname', 'fname', 'name' );
    foreach ( $direct_keys as $key ) {
        if ( ! empty( $form_data[ $key ] ) && is_string( $form_data[ $key ] ) ) {
            return sanitize_text_field( $form_data[ $key ] );
        }
    }

    // Compound Name Fields block stores data as ['names' => ['first_name' => ..., 'last_name' => ...]].
    if ( ! empty( $form_data['names'] ) && is_array( $form_data['names'] ) ) {
        if ( ! empty( $form_data['names']['first_name'] ) ) {
            return sanitize_text_field( $form_data['names']['first_name'] );
        }
    }

    // Default Simple Text field key patterns (input_text, input_text_1, etc).
    foreach ( $form_data as $key => $value ) {
        if ( is_string( $value ) && strpos( $key, 'input_text' ) === 0 ) {
            return sanitize_text_field( $value );
        }
    }

    return '';
}

/**
 * Whether the current visitor has unlocked the worksheet libraries.
 *
 * Reads the srj_worksheet_access cookie set by the worksheet-gate branch of
 * srj_beehiiv_push_subscriber() above. The book-page gate itself is applied
 * client-side (cache-safe against the GoDaddy/Sucuri full-page cache stack),
 * so this helper exists for any server-side consumer that needs the same
 * signal, and as the canonical definition of what "unlocked" means.
 *
 * @return bool
 */
function srj_worksheet_access() {
    return isset( $_COOKIE[ SRJ_WORKSHEET_COOKIE ] ) && '1' === $_COOKIE[ SRJ_WORKSHEET_COOKIE ];
}

/**
 * Signed unlock token for a given email address.
 *
 * Stateless HMAC over the normalized email, keyed by the site's auth salt.
 * No database storage and no expiry: the unlock itself is permanent by
 * design (10-year cookie), so the link staying valid is consistent.
 *
 * @param string $email
 * @return string
 */
function srj_worksheet_token( $email ) {
    return hash_hmac( 'sha256', strtolower( trim( $email ) ), wp_salt( 'auth' ) );
}

/**
 * Send the worksheet-unlock confirmation email.
 *
 * @param string $email
 */
function srj_worksheet_send_confirmation( $email ) {
    // The unlock link routes through admin-ajax.php, which is never served
    // from the GoDaddy or Sucuri page caches, so the handler is guaranteed
    // to execute PHP on every click.
    $confirm_url = add_query_arg(
        array(
            'action' => 'srj_worksheet_unlock',
            't'      => srj_worksheet_token( $email ),
            'e'      => rawurlencode( $email ),
        ),
        admin_url( 'admin-ajax.php' )
    );

    $subject = 'Confirm your email to unlock your downloads';
    $body    = "You requested the free worksheets and templates on srjconsultingservices.com.\n\n"
             . "Confirm your email to unlock every download on every book page, permanently:\n\n"
             . $confirm_url . "\n\n"
             . "If you didn't request this, you can ignore this email.\n\n"
             . "Stephen R. Jordan\n"
             . "SRJ Consulting & Services LLC";

    $sent = wp_mail( $email, $subject, $body );
    if ( ! $sent ) {
        error_log( 'SRJ Worksheet Gate: confirmation email failed to send to ' . $email );
    }
}

// Validate unlock links and set the access cookie (admin-ajax: cache-immune).
add_action( 'wp_ajax_srj_worksheet_unlock', 'srj_worksheet_confirm_unlock' );
add_action( 'wp_ajax_nopriv_srj_worksheet_unlock', 'srj_worksheet_confirm_unlock' );

/**
 * Handle clicks on the confirmation link.
 *
 * Validates the signed token, sets the 10-year access cookie, and redirects
 * to the Books landing page. Invalid or tampered links redirect without
 * setting the cookie. Runs on admin-ajax.php, which bypasses every page
 * cache in the stack.
 */
function srj_worksheet_confirm_unlock() {
    $email = isset( $_GET['e'] ) ? sanitize_email( rawurldecode( wp_unslash( $_GET['e'] ) ) ) : '';
    $token = isset( $_GET['t'] ) ? sanitize_text_field( wp_unslash( $_GET['t'] ) ) : '';

    if ( $email && $token && hash_equals( srj_worksheet_token( $email ), $token ) ) {
        setcookie( SRJ_WORKSHEET_COOKIE, '1', array(
            'expires'  => time() + 315360000, // 10 years.
            'path'     => '/',
            'secure'   => is_ssl(),
            'httponly' => false, // The client-side gate script reads it.
            'samesite' => 'Lax',
        ) );
        wp_safe_redirect( home_url( '/books/' ) );
        exit;
    }

    wp_safe_redirect( home_url( '/books/' ) );
    exit;
}
