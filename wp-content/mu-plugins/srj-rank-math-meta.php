<?php
/**
 * Plugin Name: SRJ Rank Math Meta Writer
 * Description: Writes Rank Math focus keyword, SEO title, and meta description directly via update_post_meta(), bypassing the /rankmath/v1/updateMeta REST endpoint which returns 403. Visit /wp-admin/?srj_rm_meta=1 as admin to use.
 * Version: 2.1
 */
defined('ABSPATH') || exit;

add_action('admin_init', function() {
    if (!isset($_GET['srj_rm_meta'])) return;
    if (!current_user_can('manage_options')) wp_die('Insufficient permissions.');

    $results = null;
    $post_id = 0;
    $kw = $title = $desc = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST'
        && isset($_POST['srj_rm_nonce'])
        && wp_verify_nonce($_POST['srj_rm_nonce'], 'srj_rm_meta')) {

        $post_id = absint($_POST['post_id'] ?? 0);
        $kw    = sanitize_text_field(wp_unslash($_POST['kw'] ?? ''));
        $title = sanitize_text_field(wp_unslash($_POST['title'] ?? ''));
        $desc  = sanitize_textarea_field(wp_unslash($_POST['desc'] ?? ''));

        if ($post_id && get_post($post_id)) {
            $map = array(
                'rank_math_focus_keyword' => $kw,
                'rank_math_title'         => $title,
                'rank_math_description'   => $desc,
            );
            $results = array();
            foreach ($map as $k => $v) {
                if ($v === '') { $results[$k] = 'skipped (empty)'; continue; }
                update_post_meta($post_id, $k, $v);
                $results[$k] = (get_post_meta($post_id, $k, true) === $v) ? 'written' : 'failed';
            }
        } else {
            $results = array('error' => 'Invalid post ID.');
        }
    }

    echo '<!doctype html><html><head><title>SRJ Rank Math Meta</title></head><body style="font-family:sans-serif;max-width:700px;margin:40px auto;padding:0 20px">';
    echo '<h1 style="color:#201868;border-bottom:3px solid #F07800;padding-bottom:8px">SRJ Rank Math Meta Writer</h1>';

    if (is_array($results)) {
        if (isset($results['error'])) {
            echo '<p style="color:#c00"><strong>'.esc_html($results['error']).'</strong></p>';
        } else {
            echo '<h2>Results</h2><ul>';
            foreach ($results as $k => $v) {
                echo '<li><code>'.esc_html($k).'</code>: <strong>'.esc_html($v).'</strong></li>';
            }
            echo '</ul><p>View live: <a href="'.esc_url(get_permalink($post_id)).'" target="_blank">'.esc_html(get_permalink($post_id)).'</a> (flush GoDaddy cache first).</p>';
        }
    }

    echo '<h2>Write meta</h2><form method="post">';
    wp_nonce_field('srj_rm_meta', 'srj_rm_nonce');
    echo '<p><label>Post ID<br><input type="number" name="post_id" value="'.esc_attr($post_id ?: '').'" required min="1" style="width:200px;padding:6px"></label></p>';
    echo '<p><label>Focus keyword<br><input type="text" name="kw" value="'.esc_attr($kw).'" style="width:100%;padding:6px"></label></p>';
    echo '<p><label>SEO title (target 50-60 chars)<br><input type="text" name="title" value="'.esc_attr($title).'" style="width:100%;padding:6px"></label></p>';
    echo '<p><label>Meta description (target 150-160 chars)<br><textarea name="desc" rows="3" style="width:100%;padding:6px">'.esc_textarea($desc).'</textarea></label></p>';
    echo '<p><button type="submit" style="background:#F07800;color:#fff;border:0;padding:10px 20px;font-size:15px;cursor:pointer;border-radius:4px">Update meta</button></p>';
    echo '<p style="color:#666;font-size:13px">Leave a field blank to skip writing that key (existing value preserved).</p>';
    echo '</form></body></html>';
    exit;
});