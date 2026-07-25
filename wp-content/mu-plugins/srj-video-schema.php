<?php
/**
 * Plugin Name: SRJ Video Schema
 * Description: Adds VideoObject schema (via Rank Math's json_ld filter) to the
 *              five pages whose walkthrough videos are rendered by PHP theme
 *              templates rather than stored in post content. Rank Math's
 *              Video Sitemap auto-detection scans post_content only, so
 *              template-rendered embeds are invisible to it; this plugin
 *              supplies the VideoObject data those pages need for video rich
 *              results and the video sitemap.
 * Version:     1.0.0
 * Author:      SRJ Consulting & Services
 *
 * Deployed July 24, 2026 alongside the Rank Math Video Sitemap module
 * enablement (v1.89). Config-driven: to add a video to a page, add an entry
 * to srj_video_schema_map() keyed by the page slug. Upload dates confirmed
 * by Stephen from YouTube Studio on July 24, 2026.
 *
 * @package SRJ_Consulting
 */

defined( 'ABSPATH' ) || exit;

/**
 * Page-slug => VideoObject data map.
 *
 * Durations are ISO 8601. Thumbnails use YouTube's canonical maxres URL.
 * uploadDate values are the YouTube publish dates (Stephen-confirmed).
 *
 * @return array[]
 */
function srj_video_schema_map() {
	return array(

		// Service page: AI Business Enablement Audit (Book 01 video).
		'ai-business-enablement-audit' => array(
			'name'         => 'The AI Business Enablement Audit Framework',
			'description'  => 'A complete 18-minute walkthrough of the AI Business Enablement Audit framework: how executives inventory every AI tool in use, surface scattered AI spending, and measure the distance between AI adoption and business intent.',
			'youtube_id'   => 'z5lEB49HyNc',
			'upload_date'  => '2026-05-15',
			'duration'     => 'PT18M',
		),

		// Service page: AI Readiness & Performance Assessment (Book 02 video).
		'ai-readiness-performance' => array(
			'name'         => 'The AI Readiness & Performance Assessment Framework',
			'description'  => 'A complete 15-minute walkthrough of the AI Readiness & Performance Assessment framework: why adoption is not the same as performance, the six conditions executives must score, and the Expand, Refine, or Pause decision the framework produces.',
			'youtube_id'   => 'i0xvvJaoJqQ',
			'upload_date'  => '2026-06-10',
			'duration'     => 'PT15M',
		),

		// Service page: AI Risk & Governance Review (Volume III video).
		'ai-risk-governance-review' => array(
			'name'         => 'Prove Your AI Is Governed: The Framework Every Executive Needs',
			'description'  => 'A complete 25-minute walkthrough of the AI Risk & Governance Review framework: the question every board, regulator, carrier, and acquirer is now asking, the governance record that answers it, and what a defensible AI operation looks like in practice.',
			'youtube_id'   => 'rcx0kqR4BNM',
			'upload_date'  => '2026-07-24',
			'duration'     => 'PT24M43S',
		),

		// Book page: The AI Readiness & Performance Assessment (Book 02 video).
		'the-ai-readiness-performance-assessment' => array(
			'name'         => 'The AI Readiness & Performance Assessment Framework',
			'description'  => 'A complete 15-minute walkthrough of the AI Readiness & Performance Assessment framework: why adoption is not the same as performance, the six conditions executives must score, and the Expand, Refine, or Pause decision the framework produces.',
			'youtube_id'   => 'i0xvvJaoJqQ',
			'upload_date'  => '2026-06-10',
			'duration'     => 'PT15M',
		),

		// Book page: The AI Risk & Governance Review (Volume III video).
		'the-ai-risk-governance-review' => array(
			'name'         => 'Prove Your AI Is Governed: The Framework Every Executive Needs',
			'description'  => 'A complete 25-minute walkthrough of the AI Risk & Governance Review framework: the question every board, regulator, carrier, and acquirer is now asking, the governance record that answers it, and what a defensible AI operation looks like in practice.',
			'youtube_id'   => 'rcx0kqR4BNM',
			'upload_date'  => '2026-07-24',
			'duration'     => 'PT24M43S',
		),
	);
}

/**
 * Inject a VideoObject entity into Rank Math's JSON-LD graph on mapped pages.
 *
 * @param array $data    Rank Math JSON-LD entities.
 * @param mixed $jsonld  Rank Math JsonLD instance (unused).
 * @return array
 */
add_filter( 'rank_math/json_ld', function ( $data, $jsonld ) {
	if ( ! is_page() ) {
		return $data;
	}

	$slug = get_post_field( 'post_name', get_queried_object_id() );
	$map  = srj_video_schema_map();

	if ( empty( $map[ $slug ] ) ) {
		return $data;
	}

	$v   = $map[ $slug ];
	$vid = $v['youtube_id'];

	$data['srjVideo'] = array(
		'@type'        => 'VideoObject',
		'name'         => $v['name'],
		'description'  => $v['description'],
		'uploadDate'   => $v['upload_date'],
		'duration'     => $v['duration'],
		'thumbnailUrl' => array(
			'https://i.ytimg.com/vi/' . $vid . '/maxresdefault.jpg',
			'https://i.ytimg.com/vi/' . $vid . '/hqdefault.jpg',
		),
		'embedUrl'     => 'https://www.youtube-nocookie.com/embed/' . $vid,
		'contentUrl'   => 'https://www.youtube.com/watch?v=' . $vid,
		'publisher'    => array(
			'@type' => 'Organization',
			'name'  => 'SRJ Consulting & Services LLC',
		),
	);

	return $data;
}, 20, 2 );
