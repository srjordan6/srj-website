<?php
/**
 * SRJ — Rank Math schema: author unification + site-wide normalization.
 *
 * Four interventions on Rank Math's schema output:
 *
 * Filters 1–3 hook `rank_math/json_ld` and reshape Rank Math's own graph
 * before serialization. Filter 4 is an output-buffer post-processor on
 * `wp_head`, catching what the filter chain cannot.
 *
 *
 * Filter 1 — Author unification on posts (added v1.17, priority 99)
 * ----------------------------------------------------------------
 * Scope: is_singular('post') only. Walks the graph, retargets the post-side
 * Person node and the Article author reference onto the canonical #stephen
 * @id, adds LinkedIn sameAs, jobTitle, worksFor. The About page is left
 * untouched because Rank Math reasserts custom-schema @ids after filter.
 *
 *
 * Filter 2 — Site-wide schema.org normalization (added v1.19, priority 100)
 * -------------------------------------------------------------------------
 * Scope: every page. Cleans up four classes of Rank Math output that strict
 * schema.org validators flag: openingHours long names to 2-letter codes
 * with contiguous-range collapse (Mo-Fr); Place.geo coordinate trim;
 * address.addressCountry "United States" to ISO "US"; ImageObject
 * width/height numeric-string-to-int (attempted; see Filter 4).
 *
 *
 * Filter 3 — Late-priority ImageObject dim sweep (added v1.20, priority 999)
 * -------------------------------------------------------------------------
 * Scope: every page. Deeper walker than Filter 2 (recurses into every
 * nested array regardless of @type) intended to catch ImageObject nodes
 * injected by Rank Math after the priority-100 filter exits. Empirically
 * does not land the dim coercion — see Filter 4.
 *
 *
 * Filter 4 — Output-buffer JSON-LD final pass (added v1.21, revised v1.22)
 * ------------------------------------------------------------------------
 * Why this exists: Rank Math emits ImageObject width/height as quoted
 * strings even after Filter 3 runs. Production observation (June 8, 2026)
 * confirmed the rendered HTML carries `"width":"768"` and `"height":"768"`
 * regardless of how late the rank_math/json_ld filter ran, because Rank
 * Math serializes those values from WP attachment metadata at a stage
 * outside the filter chain.
 *
 * v1.21 attempted this on `wp_head` priority 0 / PHP_INT_MAX. That hook
 * pair proved fragile because another plugin (or theme path) also runs
 * an `ob_start`/`ob_end_*` pair at the same priorities, and when the
 * sibling buffer pops via `ob_end_clean` the SRJ buffer is discarded
 * without firing its callback. v1.22 switches the wrapper to
 * `template_redirect` priority 0, which:
 *   1. Starts a single output buffer wrapping the entire response
 *      (head, body, footer — not just `wp_head`).
 *   2. Lets PHP auto-flush at script termination, which reliably
 *      invokes the registered callback regardless of what other
 *      plugins do during the request.
 *   3. Instruments the callback itself with a side-effect write to
 *      `srj_filter4_last_run` so we can verify invocation directly
 *      from the database without depending on shutdown ordering.
 *
 * The callback finds every JSON-LD <script> tag in the buffer, parses
 * each as JSON, walks the structure with
 * `srj_deep_coerce_imageobject_dims`, and re-serializes with int
 * width/height. The modified content is then sent to the browser.
 *
 * Safe by design: every script is matched, parsed, and re-emitted
 * independently. If a script's JSON fails to decode, or if re-encoding
 * fails, the original is passed through unchanged. The pass cannot break
 * a page; the worst case is a script that fails to validate which would
 * have failed to validate anyway.
 *
 *
 * All four interventions are PHP-only and add no asset; SRJ_VERSION is not
 * bumped.
 *
 * Safe by design: every modification is gated by isset() and type checks,
 * and any unrecognized input is returned unchanged rather than blanked.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/* ============================================================================
 * Filter 1 — Author unification on posts (v1.17)
 * ============================================================================
 */
add_filter(
	'rank_math/json_ld',
	function ( $data, $jsonld ) {
		if ( ! function_exists( 'is_singular' ) || ! is_singular( 'post' ) ) {
			return $data;
		}
		if ( ! is_array( $data ) ) {
			return $data;
		}

		$person_id = 'https://srjconsultingservices.com/#stephen';
		$org_id    = 'https://srjconsultingservices.com/#organization';
		$linkedin  = 'https://www.linkedin.com/in/stephenrjordan/';
		$job_title = 'Founder & Principal Advisor';

		$article_types = array( 'Article', 'BlogPosting', 'NewsArticle', 'TechArticle', 'ScholarlyArticle', 'Report' );

		foreach ( $data as $key => &$node ) {
			if ( ! is_array( $node ) || empty( $node['@type'] ) ) {
				continue;
			}
			$types = (array) $node['@type'];

			if ( in_array( 'Person', $types, true ) ) {
				$name = isset( $node['name'] ) ? $node['name'] : '';
				if ( false !== stripos( $name, 'Jordan' ) ) {
					$node['@id']      = $person_id;
					$node['jobTitle'] = $job_title;
					$same_as          = isset( $node['sameAs'] ) ? (array) $node['sameAs'] : array();
					$same_as[]        = $linkedin;
					$node['sameAs']   = array_values( array_unique( $same_as ) );
					if ( empty( $node['worksFor'] ) ) {
						$node['worksFor'] = array( '@id' => $org_id );
					}
				}
			}

			if ( array_intersect( $types, $article_types ) ) {
				$node['author'] = array(
					'@id'  => $person_id,
					'name' => 'Stephen R. Jordan',
				);
			}
		}
		unset( $node );

		return $data;
	},
	99,
	2
);


/* ============================================================================
 * Filter 2 — Site-wide schema.org normalization (v1.19, priority 100)
 * ============================================================================
 */
add_filter(
	'rank_math/json_ld',
	function ( $data, $jsonld ) {
		if ( ! is_array( $data ) ) {
			return $data;
		}
		foreach ( $data as $key => &$node ) {
			if ( is_array( $node ) ) {
				srj_normalize_schema_node( $node );
			}
		}
		unset( $node );
		return $data;
	},
	100,
	2
);


/* ============================================================================
 * Filter 3 — Late-priority ImageObject dim sweep (v1.20, priority 999)
 * ============================================================================
 */
add_filter(
	'rank_math/json_ld',
	function ( $data, $jsonld ) {
		if ( ! is_array( $data ) ) {
			return $data;
		}
		srj_deep_coerce_imageobject_dims( $data );
		return $data;
	},
	999,
	2
);


/* ============================================================================
 * Filter 4 — Output-buffer JSON-LD final pass (v1.22)
 * ============================================================================
 * Wraps the entire response with a single output buffer that PHP auto-flushes
 * at script termination, calling `srj_json_ld_final_pass` on the full HTML.
 * This is more robust than v1.21's wp_head-bound buffer, which proved
 * vulnerable to sibling plugins popping the buffer via `ob_end_clean`.
 */
add_action(
	'template_redirect',
	function () {
		if ( function_exists( 'is_admin' ) && is_admin() ) {
			return;
		}
		if ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) {
			return;
		}
		if ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) {
			return;
		}
		if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
			return;
		}
		if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
			return;
		}
		ob_start( 'srj_json_ld_final_pass' );
	},
	0
);


if ( ! function_exists( 'srj_json_ld_final_pass' ) ) {
	/**
	 * Output-buffer callback. Receives the entire response, finds
	 * every JSON-LD <script> block, parses it, normalizes ImageObject
	 * dims via srj_deep_coerce_imageobject_dims, and re-serializes. On
	 * any decode or encode failure, the original script is passed
	 * through unchanged so the page never breaks.
	 *
	 * v1.22 adds a single update_option side effect per invocation so
	 * post-deploy verification can confirm the callback ran without
	 * relying on shutdown-ordering tricks.
	 */
	function srj_json_ld_final_pass( $buffer ) {
		// Self-instrumentation: write a small marker to wp_options every
		// time we run. Limited to once per request via a static guard so
		// repeated buffer flushes within a single request don't churn the
		// option. Remove this block once production verification is complete.
		static $ran_this_request = false;
		if ( ! $ran_this_request && function_exists( 'update_option' ) ) {
			$ran_this_request = true;
			update_option(
				'srj_filter4_last_run',
				array(
					'time'             => date( 'c' ),
					'buffer_length'    => is_string( $buffer ) ? strlen( $buffer ) : 0,
					'request_uri'      => isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '',
					'pattern_matches'  => 0,
					'first_dim_before' => '',
					'first_dim_after'  => '',
				),
				false
			);
		}

		if ( ! is_string( $buffer ) || '' === $buffer ) {
			return $buffer;
		}

		$pattern = '#<script\s+type=(["\'])application/ld\+json\1([^>]*)>(.*?)</script>#s';

		$match_count   = 0;
		$first_before  = '';
		$first_after   = '';

		$result = preg_replace_callback(
			$pattern,
			function ( $matches ) use ( &$match_count, &$first_before, &$first_after ) {
				$match_count++;
				$quote    = $matches[1];
				$attrs    = $matches[2];
				$json_str = $matches[3];

				$data = json_decode( $json_str, true );
				if ( ! is_array( $data ) ) {
					return $matches[0];
				}

				if ( 1 === $match_count ) {
					// Capture a short before/after snippet of the first block
					// so we can verify the transformation landed.
					if ( preg_match( '#"width":\s*"?\d+"?#', $json_str, $m_before ) ) {
						$first_before = $m_before[0];
					}
				}

				srj_deep_coerce_imageobject_dims( $data );

				$new_json = wp_json_encode(
					$data,
					JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
				);
				if ( false === $new_json ) {
					return $matches[0];
				}

				if ( 1 === $match_count ) {
					if ( preg_match( '#"width":\s*"?\d+"?#', $new_json, $m_after ) ) {
						$first_after = $m_after[0];
					}
				}

				return '<script type=' . $quote . 'application/ld+json' . $quote . $attrs . '>' . $new_json . '</script>';
			},
			$buffer
		);

		// Update the marker with match count + before/after for the first block
		if ( function_exists( 'update_option' ) && function_exists( 'get_option' ) ) {
			$existing = get_option( 'srj_filter4_last_run', array() );
			if ( is_array( $existing ) ) {
				$existing['pattern_matches']  = $match_count;
				$existing['first_dim_before'] = $first_before;
				$existing['first_dim_after']  = $first_after;
				update_option( 'srj_filter4_last_run', $existing, false );
			}
		}

		return ( null === $result ) ? $buffer : $result;
	}
}


if ( ! function_exists( 'srj_normalize_schema_node' ) ) {
	function srj_normalize_schema_node( &$node ) {

		// 1. openingHours
		if ( isset( $node['openingHours'] ) ) {
			if ( is_array( $node['openingHours'] ) ) {
				$node['openingHours'] = array_map(
					'srj_normalize_opening_hours_string',
					$node['openingHours']
				);
			} elseif ( is_string( $node['openingHours'] ) ) {
				$node['openingHours'] = srj_normalize_opening_hours_string( $node['openingHours'] );
			}
		}

		// 2. geo coordinate whitespace
		if ( isset( $node['geo'] ) && is_array( $node['geo'] ) ) {
			foreach ( array( 'latitude', 'longitude' ) as $coord ) {
				if ( isset( $node['geo'][ $coord ] ) && is_string( $node['geo'][ $coord ] ) ) {
					$node['geo'][ $coord ] = trim( $node['geo'][ $coord ] );
				}
			}
		}

		// 3. addressCountry "United States" -> "US"
		if ( isset( $node['address'] ) && is_array( $node['address'] ) ) {
			if ( isset( $node['address']['addressCountry'] ) && $node['address']['addressCountry'] === 'United States' ) {
				$node['address']['addressCountry'] = 'US';
			}
		}

		// 4. ImageObject width/height to int
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

		// Recurse into typed children
		foreach ( $node as $k => $v ) {
			if ( is_array( $v ) && isset( $v['@type'] ) ) {
				srj_normalize_schema_node( $node[ $k ] );
			}
		}
	}
}


if ( ! function_exists( 'srj_deep_coerce_imageobject_dims' ) ) {
	function srj_deep_coerce_imageobject_dims( &$node ) {
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
				srj_deep_coerce_imageobject_dims( $node[ $k ] );
			}
		}
	}
}


if ( ! function_exists( 'srj_normalize_opening_hours_string' ) ) {
	function srj_normalize_opening_hours_string( $hours ) {
		if ( ! is_string( $hours ) ) {
			return $hours;
		}
		$day_map = array(
			'Monday'    => 'Mo',
			'Tuesday'   => 'Tu',
			'Wednesday' => 'We',
			'Thursday'  => 'Th',
			'Friday'    => 'Fr',
			'Saturday'  => 'Sa',
			'Sunday'    => 'Su',
		);
		$last_space = strrpos( $hours, ' ' );
		if ( false === $last_space ) {
			return $hours;
		}
		$days_part  = substr( $hours, 0, $last_space );
		$time_part  = substr( $hours, $last_space + 1 );
		$day_tokens = array_map( 'trim', explode( ',', $days_part ) );

		$already_short = true;
		foreach ( $day_tokens as $day ) {
			if ( strlen( $day ) !== 2 ) {
				$already_short = false;
				break;
			}
		}
		if ( $already_short ) {
			return $hours;
		}

		$short_days = array();
		foreach ( $day_tokens as $day ) {
			if ( isset( $day_map[ $day ] ) ) {
				$short_days[] = $day_map[ $day ];
			} else {
				return $hours;
			}
		}

		$week_order = array( 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su' );
		$indexes    = array();
		foreach ( $short_days as $d ) {
			$indexes[] = array_search( $d, $week_order, true );
		}

		$contiguous = count( $indexes ) > 1;
		for ( $i = 1; $i < count( $indexes ); $i++ ) {
			if ( $indexes[ $i ] !== $indexes[ $i - 1 ] + 1 ) {
				$contiguous = false;
				break;
			}
		}

		$days_normalized = $contiguous
			? $short_days[0] . '-' . end( $short_days )
			: implode( ',', $short_days );

		return $days_normalized . ' ' . $time_part;
	}
}
