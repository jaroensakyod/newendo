<?php
/**
 * Plugin Name: TEA Auto English Drafts
 * Description: Creates a paired English draft whenever a new Thai news, announcement, event, research-fund, journal or document is published.
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) exit;

const TEA_AED_POST_TYPES = ['news', 'announcement', 'event', 'research_fund', 'journal', 'document'];

/**
 * The API key deliberately lives outside the WordPress database. Define
 * TEA_TRANSLATION_OPENAI_API_KEY in wp-config.php or provide OPENAI_API_KEY
 * in the server environment. This keeps the secret out of editor screens.
 */
function tea_aed_api_key() {
    if (defined('TEA_TRANSLATION_OPENAI_API_KEY') && TEA_TRANSLATION_OPENAI_API_KEY) {
        return TEA_TRANSLATION_OPENAI_API_KEY;
    }
    return (string) getenv('OPENAI_API_KEY');
}

function tea_aed_response_text($payload) {
    if (!empty($payload['output_text']) && is_string($payload['output_text'])) return $payload['output_text'];
    foreach (($payload['output'] ?? []) as $output) {
        foreach (($output['content'] ?? []) as $content) {
            if (!empty($content['text']) && is_string($content['text'])) return $content['text'];
        }
    }
    return '';
}

function tea_aed_translate($source) {
    $key = tea_aed_api_key();
    if (!$key) return new WP_Error('tea_aed_no_key', 'No translation API key is configured.');

    $instruction = 'Translate the following Thai Association website content into polished, professional English. '
        . 'Keep proper names, dates, amounts, URLs, HTML tags and shortcodes accurate. '
        . 'Return JSON only with exactly these string keys: title, excerpt, content. '
        . 'The content value must retain valid HTML where the input contains HTML. Do not add commentary.';
    $input = "TITLE:\n{$source['title']}\n\nEXCERPT:\n{$source['excerpt']}\n\nCONTENT:\n{$source['content']}";
    $request = wp_remote_post('https://api.openai.com/v1/responses', [
        'timeout' => 60,
        'headers' => [
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
        ],
        'body' => wp_json_encode([
            'model' => defined('TEA_TRANSLATION_OPENAI_MODEL') ? TEA_TRANSLATION_OPENAI_MODEL : 'gpt-5-mini',
            'store' => false,
            'instructions' => $instruction,
            'input' => $input,
        ]),
    ]);
    if (is_wp_error($request)) return $request;
    if (wp_remote_retrieve_response_code($request) < 200 || wp_remote_retrieve_response_code($request) >= 300) {
        return new WP_Error('tea_aed_api_error', 'Translation service returned an error.');
    }
    $text = tea_aed_response_text(json_decode(wp_remote_retrieve_body($request), true));
    $text = preg_replace('/^```(?:json)?\s*|\s*```$/', '', trim($text));
    $translated = json_decode($text, true);
    if (!is_array($translated) || empty($translated['title'])) {
        return new WP_Error('tea_aed_invalid_response', 'Translation service returned an invalid response.');
    }
    return [
        'title' => sanitize_text_field($translated['title']),
        'excerpt' => sanitize_textarea_field($translated['excerpt'] ?? ''),
        'content' => wp_kses_post($translated['content'] ?? ''),
    ];
}

function tea_aed_create_draft($new_status, $old_status, $post) {
    if ($new_status !== 'publish' || !in_array($post->post_type, TEA_AED_POST_TYPES, true)) return;
    if (wp_is_post_revision($post->ID) || wp_is_post_autosave($post->ID)) return;
    if (!function_exists('pll_get_post_language') || pll_get_post_language($post->ID) !== 'th') return;

    $translations = function_exists('pll_get_post_translations') ? pll_get_post_translations($post->ID) : [];
    if (!empty($translations['en']) && get_post_status((int) $translations['en'])) return;

    $translation = tea_aed_translate([
        'title' => $post->post_title,
        'excerpt' => $post->post_excerpt,
        'content' => $post->post_content,
    ]);
    $needs_review_note = '';
    if (is_wp_error($translation)) {
        $translation = [
            'title' => '[English draft] ' . $post->post_title,
            'excerpt' => $post->post_excerpt,
            'content' => $post->post_content,
        ];
        $needs_review_note = ' Automatic translation was unavailable; please translate this draft before publishing.';
    }

    $english_id = wp_insert_post([
        'post_type' => $post->post_type,
        'post_status' => 'draft',
        'post_title' => $translation['title'],
        'post_excerpt' => $translation['excerpt'],
        'post_content' => $translation['content'],
        'post_author' => get_current_user_id() ?: $post->post_author,
    ], true);
    if (is_wp_error($english_id)) return;

    $thumbnail_id = get_post_thumbnail_id($post->ID);
    if ($thumbnail_id) set_post_thumbnail($english_id, $thumbnail_id);
    foreach (get_post_meta($post->ID) as $key => $values) {
        if (str_starts_with($key, '_tea_') && !in_array($key, ['_tea_auto_english_draft_id'], true)) {
            foreach ($values as $value) add_post_meta($english_id, $key, maybe_unserialize($value));
        }
    }
    if (function_exists('pll_set_post_language')) {
        pll_set_post_language($english_id, 'en');
        $translations['th'] = $post->ID;
        $translations['en'] = $english_id;
        pll_save_post_translations($translations);
    }
    update_post_meta($post->ID, '_tea_auto_english_draft_id', $english_id);
    update_post_meta($english_id, '_tea_translation_review_status', 'needs_review');
    if ($needs_review_note) update_post_meta($english_id, '_tea_translation_note', $needs_review_note);
}
add_action('transition_post_status', 'tea_aed_create_draft', 20, 3);

function tea_aed_admin_notice() {
    if (!current_user_can('manage_options') || tea_aed_api_key()) return;
    echo '<div class="notice notice-warning"><p><strong>TEA Auto English Drafts:</strong> English drafts will be created, but need manual translation until a server-side API key is configured.</p></div>';
}
add_action('admin_notices', 'tea_aed_admin_notice');
