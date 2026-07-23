<?php
/**
 * SRJ Consulting Theme Security Hardening
 *
 * Defense-in-depth security measures applied at the theme level.
 * Complements (does not replace) the hosting-level firewall,
 * WordPress core security, and any installed security plugins.
 *
 * Each measure below is conservative and tested against common
 * WordPress workflows. Nothing here disables core block editor,
 * Beehiiv newsletter integration, or WPForms contact submissions.
 *
 * @package SRJ_Consulting
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* =========================================================================
   1. SECURITY HTTP HEADERS
   ========================================================================= */

/**
 * Add security HTTP headers to all responses.
 *
 * Defends against:
 *   - Clickjacking (X-Frame-Options)
 *   - MIME-sniffing attacks (X-Content-Type-Options)
 *   - Referer leakage to third parties (Referrer-Policy)
 *   - Unwanted browser feature access (Permissions-Policy)
 *   - Protocol-downgrade interception (Strict-Transport-Security)
 *
 * Note: this filter applies to responses rendered by WordPress (HTML
 * pages). Static files served directly by the web server (images, CSS,
 * JS) do not pass through PHP and so do not receive these headers. For
 * HSTS this is not a practical limitation: once a browser receives the
 * header on any page of the domain, it enforces HTTPS for the whole
 * domain for the duration of max-age. To also attach these headers to
 * static assets, set them at the server level (.htaccess) or edge.
 */
function srj_security_headers( $headers ) {

    // Prevent the site from being framed by other domains (clickjacking defense)
    $headers['X-Frame-Options'] = 'SAMEORIGIN';

    // Prevent browsers from MIME-sniffing the content type
    $headers['X-Content-Type-Options'] = 'nosniff';

    // Limit referrer information sent to other sites
    $headers['Referrer-Policy'] = 'strict-origin-when-cross-origin';

    // Disable browser features not used by the site
    $headers['Permissions-Policy'] = 'camera=(), microphone=(), geolocation=(), payment=(), usb=()';

    // HSTS: instructs browsers to only ever load the site over HTTPS.
    //
    // max-age set to one year (31536000 seconds), matching the value sent
    // by the Sucuri WAF on every response. Keeping both layers identical
    // means that if the WAF layer is ever bypassed (e.g. a direct-to-origin
    // request hits PHP), the same long-lived HTTPS commitment is enforced,
    // and browsers see one consistent value across every response.
    //
    // 'includeSubDomains' and 'preload' are deliberately omitted:
    //   - includeSubDomains forces HTTPS on every subdomain. Only add it
    //     once every subdomain is confirmed to be HTTPS-only.
    //   - preload is effectively permanent and should not be used until
    //     a long max-age plus includeSubDomains have run cleanly.
    //
    // History: launched at max-age=86400 (one day) in May 2026 as a
    // conservative rollout window. Raised to 31536000 in June 2026 once
    // HTTPS had run stable for over a month and the WAF layer's matching
    // value made the conservative theme-level value redundant (and an
    // Ahrefs audit flagged the duplicate-Strict-Transport-Security header
    // pair carrying mismatched values as a normalization issue).
    $headers['Strict-Transport-Security'] = 'max-age=31536000';

    return $headers;
}
add_filter( 'wp_headers', 'srj_security_headers' );


/* =========================================================================
   2. INFORMATION DISCLOSURE REDUCTION
   ========================================================================= */

/**
 * Remove WordPress version from public-facing source code.
 * Makes targeted version-specific attacks meaningfully harder.
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Remove WordPress version from RSS feeds.
 */
add_filter( 'the_generator', '__return_empty_string' );

/**
 * Remove legacy discovery links that leak metadata.
 */
remove_action( 'wp_head', 'rsd_link' );                       // Really Simple Discovery (XML-RPC)
remove_action( 'wp_head', 'wlwmanifest_link' );               // Windows Live Writer
remove_action( 'wp_head', 'wp_shortlink_wp_head' );           // ?p= shortlinks
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );

/**
 * Remove XML-RPC pingback HTTP header.
 */
function srj_remove_pingback_header( $headers ) {
    if ( isset( $headers['X-Pingback'] ) ) {
        unset( $headers['X-Pingback'] );
    }
    return $headers;
}
add_filter( 'wp_headers', 'srj_remove_pingback_header' );


/* =========================================================================
   3. LOGIN AND AUTHENTICATION HARDENING
   ========================================================================= */

/**
 * Hide login error messages to prevent username enumeration.
 *
 * Default WordPress reveals whether the username or password was wrong,
 * which lets attackers confirm valid usernames before brute forcing.
 * This filter replaces all login errors with a generic message.
 */
function srj_hide_login_errors() {
    return 'Login failed. Please verify your credentials and try again.';
}
add_filter( 'login_errors', 'srj_hide_login_errors' );


/* =========================================================================
   4. USER ENUMERATION PREVENTION
   ========================================================================= */

/**
 * Block user enumeration via ?author=N URL probes.
 *
 * By default, visiting /?author=1 redirects to /author/admin-username/,
 * leaking the admin username to anyone who tries. This is the first step
 * of most automated WordPress brute force attacks.
 */
function srj_block_author_enumeration() {
    if ( ! is_admin() && isset( $_GET['author'] ) ) {
        wp_redirect( home_url(), 301 );
        exit;
    }
}
add_action( 'init', 'srj_block_author_enumeration' );

/**
 * Restrict REST API user endpoint to authenticated users only.
 *
 * Prevents unauthenticated requests to /wp-json/wp/v2/users from
 * leaking the list of all usernames on the site.
 *
 * Does NOT disable the REST API entirely (which would break the block
 * editor, the Beehiiv newsletter integration, Rank Math's sitemap
 * generation, and many other plugins).
 */
function srj_restrict_rest_users( $result, $server, $request ) {
    if ( ! is_user_logged_in() ) {
        $route = $request->get_route();
        if ( preg_match( '/^\/wp\/v\d+\/users/', $route ) ) {
            return new WP_Error(
                'rest_unauthorized',
                __( 'Authentication required to access this endpoint.', 'srj-consulting' ),
                array( 'status' => 401 )
            );
        }
    }
    return $result;
}
add_filter( 'rest_pre_dispatch', 'srj_restrict_rest_users', 10, 3 );


/* =========================================================================
   5. XML-RPC DISABLE
   ========================================================================= */

/**
 * Disable XML-RPC.
 *
 * XML-RPC is a legacy WordPress feature primarily used by:
 *   - Jetpack (not installed on this site)
 *   - Old WordPress mobile apps (modern apps use REST API)
 *   - Remote publishing tools (rare for this site)
 *
 * It is also a frequent vector for brute force amplification attacks
 * (system.multicall lets attackers attempt many logins per request).
 *
 * If you ever need XML-RPC, comment out the line below.
 */
add_filter( 'xmlrpc_enabled', '__return_false' );


/* =========================================================================
   6. END OF SECURITY HARDENING
   ========================================================================= */
