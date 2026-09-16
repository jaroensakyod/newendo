<?php
/**
 * Plugin Name: TEA Core
 * Description: ประเภทเนื้อหาและ taxonomy ของเว็บไซต์สมาคมเอ็นโดดอนติกส์ไทย (ข่าว ประกาศ กิจกรรม ทุนวิจัย วารสาร เอกสาร)
 * Version: 1.0.0
 * Text Domain: tea-core
 */

if (!defined('ABSPATH')) exit;

function tea_core_lbl($th, $en) {
    return (function_exists('pll_current_language') && pll_current_language() === 'en') ? $en : $th;
}

function tea_core_cpts() {
    $types = [
        'news' => [
            'label_th' => 'ข่าวสาร',
            'label_en' => 'News',
            'menu_icon' => 'dashicons-megaphone',
            'rewrite_slug' => 'news',
        ],
        'announcement' => [
            'label_th' => 'ประกาศ',
            'label_en' => 'Announcements',
            'menu_icon' => 'dashicons-format-aside',
            'rewrite_slug' => 'announcements',
        ],
        'event' => [
            'label_th' => 'กิจกรรม',
            'label_en' => 'Events',
            'menu_icon' => 'dashicons-calendar-alt',
            'rewrite_slug' => 'events',
        ],
        'research_fund' => [
            'label_th' => 'ทุนวิจัย',
            'label_en' => 'Research Funds',
            'menu_icon' => 'dashicons-awards',
            'rewrite_slug' => 'research-funds',
        ],
        'journal' => [
            'label_th' => 'วารสาร',
            'label_en' => 'Journal',
            'menu_icon' => 'dashicons-book',
            'rewrite_slug' => 'journal',
        ],
        'document' => [
            'label_th' => 'เอกสารดาวน์โหลด',
            'label_en' => 'Documents',
            'menu_icon' => 'dashicons-media-default',
            'rewrite_slug' => 'documents',
        ],
    ];

    foreach ($types as $key => $t) {
        register_post_type($key, [
            'labels' => [
                'name'          => tea_core_lbl($t['label_th'], $t['label_en']),
                'singular_name' => tea_core_lbl($t['label_th'], $t['label_en']),
                'add_new_item'  => tea_core_lbl('เพิ่ม' . $t['label_th'], 'Add ' . $t['label_en']),
                'edit_item'     => tea_core_lbl('แก้ไข' . $t['label_th'], 'Edit ' . $t['label_en']),
            ],
            'public'       => true,
            'has_archive'  => true,
            'menu_icon'    => $t['menu_icon'],
            'supports'     => ['title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes'],
            'rewrite'      => ['slug' => $t['rewrite_slug']],
            'show_in_rest' => true,
        ]);
    }

    // หมวดหมู่ใช้ร่วมสำหรับข่าว/กิจกรรม/เอกสาร/ประกาศ
    register_taxonomy('tea_category', ['news', 'event', 'document', 'journal', 'announcement'], [
        'labels' => [
            'name'          => 'หมวดหมู่ TEA',
            'singular_name' => 'หมวดหมู่ TEA',
        ],
        'hierarchical' => true,
        'public'       => true,
        'show_in_rest' => true,
        'rewrite'      => ['slug' => 'tea-category'],
    ]);
}
add_action('init', 'tea_core_cpts', 20);

/**
 * ช่องข้อมูลเพิ่มเติมอย่างง่ายสำหรับเอกสารดาวน์โหลดและกิจกรรม
 * (ไม่พึ่ง ACF เพื่อให้ย้ายระบบได้ง่าย หากมี ACF สามารถขยายเพิ่มภายหลัง)
 */
function tea_core_meta_boxes() {
    add_meta_box('tea_document_file', 'ไฟล์ดาวน์โหลด (URL)', 'tea_document_file_box', 'document', 'side', 'default');
    add_meta_box('tea_event_date', 'วันที่จัดกิจกรรม', 'tea_event_date_box', 'event', 'side', 'default');
}
add_action('add_meta_boxes', 'tea_core_meta_boxes');

function tea_document_file_box($post) {
    wp_nonce_field('tea_save_meta', 'tea_meta_nonce');
    $val = get_post_meta($post->ID, '_tea_file_url', true);
    echo '<input type="url" style="width:100%" name="tea_file_url" value="' . esc_attr($val) . '" placeholder="https://...">';
}

function tea_event_date_box($post) {
    wp_nonce_field('tea_save_meta', 'tea_meta_nonce');
    $val = get_post_meta($post->ID, '_tea_event_date', true);
    echo '<input type="date" style="width:100%" name="tea_event_date" value="' . esc_attr($val) . '">';
}

function tea_core_save_meta($post_id) {
    if (!isset($_POST['tea_meta_nonce']) || !wp_verify_nonce($_POST['tea_meta_nonce'], 'tea_save_meta')) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (isset($_POST['tea_file_url'])) update_post_meta($post_id, '_tea_file_url', esc_url_raw($_POST['tea_file_url']));
    if (isset($_POST['tea_event_date'])) update_post_meta($post_id, '_tea_event_date', sanitize_text_field($_POST['tea_event_date']));
}
add_action('save_post', 'tea_core_save_meta');

/** อัปเดต label ตามภาษาที่เลือก (หลัง Polylang กำหนดภาษาแล้ว) */
add_action('wp', function () {
    global $wp_post_types;
    $types = [
        'news'          => ['ข่าวสาร', 'News'],
        'announcement'  => ['ประกาศ', 'Announcements'],
        'event'         => ['กิจกรรม', 'Events'],
        'research_fund' => ['ทุนวิจัย', 'Research Funds'],
        'journal'       => ['วารสาร', 'Journal'],
        'document'      => ['เอกสารดาวน์โหลด', 'Documents'],
    ];
    foreach ($types as $key => [$th, $en]) {
        if (isset($wp_post_types[$key])) {
            $lbl = tea_core_lbl($th, $en);
            $wp_post_types[$key]->labels->name = $lbl;
            $wp_post_types[$key]->labels->singular_name = $lbl;
            $wp_post_types[$key]->labels->menu_name = $lbl;
        }
    }
}, 99);
