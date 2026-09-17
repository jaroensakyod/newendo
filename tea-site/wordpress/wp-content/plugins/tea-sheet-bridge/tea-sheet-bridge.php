<?php
/**
 * Plugin Name: TEA Sheet Bridge
 * Description: ดึงเนื้อหาที่เผยแพร่จาก Google Sheets เข้าสู่เว็บไซต์ TEA
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) exit;

define('TEA_SHEET_BRIDGE_ID', '1nsumrtlVWv0dOgiFnyIW5da7ceRjUr1J1FLwpZpDe7Y');

function tea_sheet_bridge_sources() {
    return [
        'news'    => 1158288641,
        'events'  => 1602776720,
        'library' => 1682554541,
        'hero'    => 931262432,
        'popups'  => 1567858899,
        'gallery' => 761836372,
    ];
}

function tea_sheet_bridge_yes($value) {
    return in_array(mb_strtolower(trim((string) $value)), ['1', 'yes', 'y', 'true', 'ใช่', 'เปิด'], true);
}

function tea_sheet_bridge_published($value) {
    return in_array(mb_strtolower(trim((string) $value)), ['publish', 'published', 'เผยแพร่'], true);
}

function tea_sheet_bridge_csv_rows($source, $refresh = false) {
    $sources = tea_sheet_bridge_sources();
    if (!isset($sources[$source])) return [];
    $key = 'tea_sheet_bridge_' . $source;
    if (!$refresh) {
        $cached = get_transient($key);
        if (is_array($cached)) return $cached;
    }
    $url = sprintf('https://docs.google.com/spreadsheets/d/%s/gviz/tq?tqx=out:csv&gid=%d', TEA_SHEET_BRIDGE_ID, $sources[$source]);
    $response = wp_remote_get($url, ['timeout' => 15, 'redirection' => 2]);
    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) return [];
    $body = preg_replace('/^\xEF\xBB\xBF/', '', wp_remote_retrieve_body($response));
    $handle = fopen('php://temp', 'r+');
    fwrite($handle, $body);
    rewind($handle);
    $csv = [];
    while (($row = fgetcsv($handle)) !== false) $csv[] = array_map('trim', $row);
    fclose($handle);
    $header_index = null;
    foreach ($csv as $i => $row) {
        if (in_array('รหัส', $row, true)) { $header_index = $i; break; }
        // Original template has the first field description ending in “รหัส”.
        if (in_array('ลำดับ', $row, true) && in_array('เปิดใช้', $row, true)) { $header_index = $i; $row[0] = 'รหัส'; $csv[$i] = $row; break; }
    }
    if ($header_index === null) return [];
    $headers = $csv[$header_index];
    $rows = [];
    foreach (array_slice($csv, $header_index + 1) as $row) {
        $item = [];
        foreach ($headers as $col => $header) if ($header !== '') $item[$header] = $row[$col] ?? '';
        if (array_filter($item, static function($value) { return $value !== ''; })) $rows[] = $item;
    }
    set_transient($key, $rows, 5 * MINUTE_IN_SECONDS);
    return $rows;
}

function tea_sheet_bridge_front_rows($source) {
    $rows = tea_sheet_bridge_csv_rows($source);
    return array_values(array_filter($rows, static function($row) {
        if (empty($row['รหัส'])) return false;
        $on = !isset($row['เปิดใช้']) || tea_sheet_bridge_yes($row['เปิดใช้']);
        $status = !isset($row['สถานะ']) || $row['สถานะ'] === '' || tea_sheet_bridge_published($row['สถานะ']);
        return $on && $status;
    }));
}

function tea_sheet_bridge_sync_post($row, $post_type, $date = '') {
    $id = sanitize_text_field($row['รหัส'] ?? '');
    $title = sanitize_text_field($row['หัวข้อไทย'] ?? ($row['ชื่อไทย'] ?? ''));
    if (!$id || !$title || !post_type_exists($post_type)) return false;
    $found = get_posts(['post_type' => $post_type, 'post_status' => 'any', 'meta_key' => '_tea_sheet_row_id', 'meta_value' => $id, 'numberposts' => 1, 'fields' => 'ids']);
    $post = ['post_type' => $post_type, 'post_title' => $title, 'post_content' => wp_kses_post($row['เนื้อหา'] ?? ($row['คำอธิบาย'] ?? '')), 'post_excerpt' => sanitize_textarea_field($row['คำเกริ่น'] ?? ''), 'post_status' => 'publish'];
    if ($date) $post['post_date'] = $date . ' 09:00:00';
    $post_id = $found ? wp_update_post($post + ['ID' => $found[0]], true) : wp_insert_post($post, true);
    if (is_wp_error($post_id)) return false;
    update_post_meta($post_id, '_tea_sheet_row_id', $id);
    foreach (['ลิงก์' => '_tea_sheet_link', 'รูป URL' => '_tea_sheet_image_url', 'รูปปก URL' => '_tea_sheet_image_url', 'ไฟล์ URL' => '_tea_file_url', 'วันเริ่ม' => '_tea_event_date', 'วันสิ้นสุด' => '_tea_event_end', 'ฉบับ/ปี' => '_tea_issue_label'] as $column => $meta) {
        if (empty($row[$column])) continue;
        $value = in_array($column, ['ลิงก์', 'รูป URL', 'รูปปก URL', 'ไฟล์ URL'], true) ? esc_url_raw($row[$column]) : sanitize_text_field($row[$column]);
        update_post_meta($post_id, $meta, $value);
    }
    if ($post_type === 'journal') {
        update_post_meta($post_id, '_tea_library_import', '1');
        if (!empty($row['ไฟล์ URL'])) update_post_meta($post_id, '_tea_pdf_url', esc_url_raw($row['ไฟล์ URL']));
        if (!empty($row['รูปปก URL'])) update_post_meta($post_id, '_tea_preview_url', esc_url_raw($row['รูปปก URL']));
    }
    return true;
}

function tea_sheet_bridge_sync() {
    $counts = ['news' => 0, 'events' => 0, 'library' => 0, 'popups' => 0];
    foreach (tea_sheet_bridge_csv_rows('news', true) as $row) {
        if (!tea_sheet_bridge_published($row['สถานะ'] ?? '')) continue;
        $type = in_array($row['ประเภท'] ?? '', ['news', 'announcement'], true) ? $row['ประเภท'] : 'news';
        if (tea_sheet_bridge_sync_post($row, $type, $row['วันที่เผยแพร่'] ?? '')) $counts['news']++;
    }
    foreach (tea_sheet_bridge_csv_rows('events', true) as $row) {
        if (!tea_sheet_bridge_published($row['สถานะ'] ?? '')) continue;
        $type = in_array($row['ประเภท'] ?? '', ['event', 'research_fund'], true) ? $row['ประเภท'] : 'event';
        if (tea_sheet_bridge_sync_post($row, $type, $row['วันเริ่ม'] ?? '')) $counts['events']++;
    }
    foreach (tea_sheet_bridge_csv_rows('library', true) as $row) {
        if (!tea_sheet_bridge_published($row['สถานะ'] ?? '')) continue;
        $type = in_array($row['ประเภท'] ?? '', ['journal', 'document'], true) ? $row['ประเภท'] : 'document';
        if (tea_sheet_bridge_sync_post($row, $type)) $counts['library']++;
    }
    foreach (tea_sheet_bridge_csv_rows('popups', true) as $row) {
        if (!tea_sheet_bridge_published($row['สถานะ'] ?? '') || !tea_sheet_bridge_yes($row['เปิดใช้'] ?? '')) continue;
        $popup = ['รหัส' => $row['รหัส'] ?? '', 'หัวข้อไทย' => $row['หัวข้อไทย'] ?? '', 'คำเกริ่น' => $row['คำเกริ่น'] ?? ''];
        if (!tea_sheet_bridge_sync_post($popup, 'announcement')) continue;
        $post = get_posts(['post_type' => 'announcement', 'post_status' => 'any', 'meta_key' => '_tea_sheet_row_id', 'meta_value' => $popup['รหัส'], 'numberposts' => 1, 'fields' => 'ids']);
        if (!$post) continue;
        $post_id = $post[0];
        foreach (['วันเริ่ม' => '_tea_ann_start', 'วันสิ้นสุด' => '_tea_ann_end', 'ลิงก์ปุ่ม' => '_tea_ann_link', 'ข้อความปุ่ม' => '_tea_ann_btn_text', 'ความถี่' => '_tea_ann_freq', 'ลำดับ' => '_tea_ann_order', 'คำเกริ่น' => '_tea_ann_kicker', 'รูป URL' => '_tea_sheet_image_url'] as $column => $meta) {
            if (isset($row[$column])) update_post_meta($post_id, $meta, $meta === '_tea_ann_link' || $meta === '_tea_sheet_image_url' ? esc_url_raw($row[$column]) : sanitize_text_field($row[$column]));
        }
        $counts['popups']++;
    }
    return $counts;
}

function tea_sheet_bridge_menu() {
    add_management_page('เชื่อม Google Sheet', 'เชื่อม Google Sheet', 'manage_options', 'tea-sheet-bridge', 'tea_sheet_bridge_screen');
}
add_action('admin_menu', 'tea_sheet_bridge_menu');

function tea_sheet_bridge_screen() {
    if (!current_user_can('manage_options')) return;
    if (isset($_POST['tea_sheet_bridge_sync']) && check_admin_referer('tea_sheet_bridge_sync')) {
        $counts = tea_sheet_bridge_sync();
        echo '<div class="notice notice-success"><p>อัปเดตแล้ว: ข่าว/ประกาศ ' . intval($counts['news']) . ', กิจกรรม/ทุน ' . intval($counts['events']) . ', วารสาร/เอกสาร ' . intval($counts['library']) . ', Popup ' . intval($counts['popups']) . ' รายการ</p></div>';
    }
    echo '<div class="wrap"><h1>เชื่อม Google Sheet</h1><p>ระบบจะดึงเฉพาะแถวที่สถานะเป็น “เผยแพร่” เท่านั้น และอัปเดตหน้ารายการเดิมตามรหัสในชีต</p><form method="post">';
    wp_nonce_field('tea_sheet_bridge_sync');
    submit_button('ดึงข้อมูลจาก Google Sheet ตอนนี้', 'primary', 'tea_sheet_bridge_sync');
    echo '</form><p><a href="https://docs.google.com/spreadsheets/d/' . esc_attr(TEA_SHEET_BRIDGE_ID) . '/edit" target="_blank" rel="noreferrer">เปิด TEA Content CMS</a></p></div>';
}
