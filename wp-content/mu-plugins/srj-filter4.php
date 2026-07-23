<?php
/**
 * Plugin Name: SRJ Filter 4 — JSON-LD ImageObject dim coercion
 * Description: Wraps the entire response with an output buffer that coerces ImageObject width/height numeric-string values to ints across every JSON-LD <script> block. Final pass after Rank Math's schema chain. Required because Rank Math emits these dims as strings even after rank_math/json_ld filter modifications.
 * Version: 1.22
 * Author: SRJ Consulting & Services
 *
 * This is a must-use plugin. WordPress auto-loads it on every request,
 * before regular plugins and the active theme. Do not move or rename
 * this file.
 *
 * Location on server: /wp-content/mu-plugins/srj-filter4.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'srj_deep_coerce_imageobject_dims_v122' ) ) {
	function srj_deep_coerce_imageobject_dims_v122( &$node ) {
		if ( ! is_array( $node ) ) {
			return;
		}
		if ( ! empty( $node['@type'] ) ) {
			$types = (array) $node['@type'];
			if ( in_array( 'ImageObject', $types, true ) ) {
				foreach ( array( 'width', 'height' ) as $dim ) {
					if ( isset( $node[ $dim ] ) && is_string( $node[ $dim ] ) && ctype_digit( $node[ $dim ] ) ) {
						$node[ $dim ] = (int) $node[ $dim ];
					}
				}
			}
		}
		foreach ( $node as $k => $v ) {
			if ( is_array( $v ) ) {
				srj_deep_coerce_imageobject_dims_v122( $node[ $k ] );
			}
		}
	}
}

if ( ! function_exists( 'srj_filter4_buffer_pass_v122' ) ) {
	function srj_filter4_buffer_pass_v122( $buffer ) {
		static $ran_this_request = false;
		if ( ! $ran_this_request && function_exists( 'update_option' ) ) {
			$ran_this_request = true;
			update_option( 'srj_filter4_last_run', array(
				'time'            => date( 'c' ),
				'buffer_length'   => is_string( $buffer ) ? strlen( $buffer ) : 0,
				'request_uri'     => isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '',
				'pattern_matches' => 0,
				'source'          => 'mu_plugin_srj_filter4',
			), false );
		}

		if ( ! is_string( $buffer ) || '' === $buffer ) {
			return $buffer;
		}

		$pattern     = '#<script\s+type=(["\'])application/ld\+json\1([^>]*)>(.*?)</script>#s';
		$match_count = 0;

		$result = preg_replace_callback( $pattern, function ( $matches ) use ( &$match_count ) {
			$match_count++;
			$quote    = $matches[1];
			$attrs    = $matches[2];
			$json_str = $matches[3];

			$data = json_decode( $json_str, true );
			if ( ! is_array( $data ) ) {
				return $matches[0];
			}

			srj_deep_coerce_imageobject_dims_v122( $data );

			$new_json = function_exists( 'wp_json_encode' )
				? wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
				: json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

			if ( false === $new_json ) {
				return $matches[0];
			}

			return '<script type=' . $quote . 'application/ld+json' . $quote . $attrs . '>' . $new_json . '</script>';
		}, $buffer );

		if ( function_exists( 'update_option' ) ) {
			$existing = get_option( 'srj_filter4_last_run', array() );
			if ( is_array( $existing ) ) {
				$existing['pattern_matches'] = $match_count;
				update_option( 'srj_filter4_last_run', $existing, false );
			}
		}

		return ( null === $result ) ? $buffer : $result;
	}
}

add_action( 'template_redirect', function () {
	if ( function_exists( 'is_admin' ) && is_admin() ) return;
	if ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) return;
	if ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) return;
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) return;
	if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) return;
	ob_start( 'srj_filter4_buffer_pass_v122' );
}, 0 );
