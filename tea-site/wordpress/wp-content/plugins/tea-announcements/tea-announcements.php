<?php
/**
 * Plugin Name: TEA Announcements
 * Description: Popup ประกาศสำคัญแบบสไลด์หลายรายการ ตามดีไซน์ต้นฉบับ (ใบเสนอราคา Q-TEA-2026-005 ข้อ 4)
 * Version: 2.0.0
 * Text Domain: tea-announcements
 */

if (!defined('ABSPATH')) exit;

function tea_ann_meta_boxes() {
    add_meta_box('tea_ann_popup', 'ตั้งค่า Popup ประกาศ', 'tea_ann_popup_box', 'announcement', 'normal', 'high');
}
add_action('add_meta_boxes', 'tea_ann_meta_boxes');

function tea_ann_popup_box($post) {
    wp_nonce_field('tea_ann_save', 'tea_ann_nonce');
    $start    = get_post_meta($post->ID, '_tea_ann_start', true);
    $end      = get_post_meta($post->ID, '_tea_ann_end', true);
    $link     = get_post_meta($post->ID, '_tea_ann_link', true);
    $btn_text = get_post_meta($post->ID, '_tea_ann_btn_text', true);
    $freq     = get_post_meta($post->ID, '_tea_ann_freq', true) ?: 'once';
    $order    = get_post_meta($post->ID, '_tea_ann_order', true) ?: 0;
    $kicker   = get_post_meta($post->ID, '_tea_ann_kicker', true);
    $source   = get_post_meta($post->ID, '_tea_ann_source', true);
    $memorial = get_post_meta($post->ID, '_tea_ann_memorial', true);
    ?>
    <table class="form-table">
        <tr><th>หัวข้อเล็ก (kicker)</th><td><input type="text" style="width:100%" name="tea_ann_kicker" value="<?php echo esc_attr($kicker); ?>" placeholder="เช่น ประกาศสำคัญ"></td></tr>
        <tr><th>แหล่งที่มา</th><td><input type="text" style="width:100%" name="tea_ann_source" value="<?php echo esc_attr($source); ?>" placeholder="เช่น สมาคมเอ็นโดดอนติกส์ไทย"></td></tr>
        <tr><th>วันเริ่มแสดง</th><td><input type="date" name="tea_ann_start" value="<?php echo esc_attr($start); ?>"></td></tr>
        <tr><th>วันสิ้นสุดการแสดง</th><td><input type="date" name="tea_ann_end" value="<?php echo esc_attr($end); ?>"></td></tr>
        <tr><th>ลิงก์ปุ่ม</th><td><input type="url" style="width:100%" name="tea_ann_link" value="<?php echo esc_attr($link); ?>"></td></tr>
        <tr><th>ข้อความปุ่ม</th><td><input type="text" name="tea_ann_btn_text" value="<?php echo esc_attr($btn_text); ?>" placeholder="อ่านรายละเอียด / Read more"></td></tr>
        <tr><th>ความถี่การแสดง</th><td>
            <select name="tea_ann_freq">
                <option value="always" <?php selected($freq, 'always'); ?>>แสดงทุกครั้ง</option>
                <option value="once" <?php selected($freq, 'once'); ?>>ครั้งเดียวต่อผู้ใช้ (จำไว้ในเบราว์เซอร์)</option>
                <option value="daily" <?php selected($freq, 'daily'); ?>>วันละครั้งต่อผู้ใช้</option>
            </select>
        </td></tr>
        <tr><th>ลำดับสไลด์</th><td><input type="number" name="tea_ann_order" value="<?php echo esc_attr($order); ?>"></td></tr>
        <tr><th>ธีมไว้อาลัย</th><td><label><input type="checkbox" name="tea_ann_memorial" <?php checked($memorial, '1'); ?>> ใช้โทนดำ-ทอง (สำหรับประกาศงานพระราชพิธี)</label></td></tr>
    </table>
    <p><em>รูปประกอบ: ตั้งเป็น "รูปประกอบเนื้อหา" (Featured image) ของประกาศนี้</em></p>
    <?php
}

function tea_ann_save($post_id) {
    if (!isset($_POST['tea_ann_nonce']) || !wp_verify_nonce($_POST['tea_ann_nonce'], 'tea_ann_save')) return;
    if (!current_user_can('edit_post', $post_id)) return;
    foreach (['tea_ann_start', 'tea_ann_end', 'tea_ann_freq', 'tea_ann_order', 'tea_ann_kicker', 'tea_ann_source'] as $f) {
        if (isset($_POST[$f])) update_post_meta($post_id, '_' . $f, sanitize_text_field($_POST[$f]));
    }
    if (isset($_POST['tea_ann_link'])) update_post_meta($post_id, '_tea_ann_link', esc_url_raw($_POST['tea_ann_link']));
    if (isset($_POST['tea_ann_btn_text'])) update_post_meta($post_id, '_tea_ann_btn_text', sanitize_text_field($_POST['tea_ann_btn_text']));
    update_post_meta($post_id, '_tea_ann_memorial', isset($_POST['tea_ann_memorial']) ? '1' : '');
}
add_action('save_post', 'tea_ann_save');

function tea_ann_lang( $th, $en ) {
    return ( function_exists( 'pll_current_language' ) && pll_current_language() === 'en' ) ? $en : $th;
}

function tea_ann_render() {
    $today = current_time('Y-m-d');
    $q = new WP_Query([
        'post_type'      => 'announcement',
        'posts_per_page' => 10,
        'meta_query'     => [
            'relation' => 'OR',
            ['key' => '_tea_ann_start', 'compare' => 'NOT EXISTS'],
            ['key' => '_tea_ann_start', 'value' => $today, 'compare' => '<=', 'type' => 'DATE'],
        ],
        'meta_key' => '_tea_ann_order',
        'orderby'  => 'meta_value_num date',
        'order'    => 'ASC',
    ]);

    $items = [];
    // กรองตามภาษาปัจจุบันเมื่อใช้ Polylang (โพสต์ไทยไม่โชว์บนหน้าอังกฤษ)
    $current_lang = function_exists('pll_current_language') ? pll_current_language() : null;
    $is_en = ($current_lang === 'en');
    foreach ($q->posts as $p) {
        if ($current_lang && function_exists('pll_get_post_language')) {
            $plang = pll_get_post_language($p->ID);
            if ($plang && $plang !== $current_lang) continue;
        }
        // Keep the legacy Thai grant notice in the news archive, but remove it from the popup rotation.
        if ($current_lang === 'th' && (int) $p->ID === 7) continue;
        $end = get_post_meta($p->ID, '_tea_ann_end', true);
        if ($end && $end < $today) continue;
        $raw_btn = get_post_meta($p->ID, '_tea_ann_btn_text', true);
        $raw_kicker = get_post_meta($p->ID, '_tea_ann_kicker', true);
        $raw_source = get_post_meta($p->ID, '_tea_ann_source', true);
        $items[] = [
            'id'      => $p->ID,
            'title'   => get_the_title($p),
            'excerpt' => wp_strip_all_tags(get_the_excerpt($p)),
            // Use the generated responsive size. Some legacy originals are
            // unavailable through the public tunnel while this size is served
            // reliably and remains sharp in the popup.
            'image'   => get_the_post_thumbnail_url($p, 'medium_large') ?: get_post_meta($p->ID, '_tea_sheet_image_url', true),
            'link'    => get_post_meta($p->ID, '_tea_ann_link', true) ?: get_permalink($p),
            'btnText' => $is_en
                ? (in_array($raw_btn, ['', 'อ่านรายละเอียด'], true) ? 'Read more' : $raw_btn)
                : ($raw_btn ?: __('อ่านรายละเอียด', 'tea-announcements')),
            'freq'    => get_post_meta($p->ID, '_tea_ann_freq', true) ?: 'once',
            'kicker'  => $is_en
                ? (in_array($raw_kicker, ['', 'ประกาศสำคัญ'], true) ? 'IMPORTANT ANNOUNCEMENT' : $raw_kicker)
                : ($raw_kicker ?: __('ประกาศสำคัญ', 'tea-announcements')),
            'source'  => $is_en
                ? (in_array($raw_source, ['', 'สมาคมเอ็นโดดอนติกส์ไทย'], true) ? 'Thai Endodontic Association' : $raw_source)
                : $raw_source,
            'memorial'=> (bool) get_post_meta($p->ID, '_tea_ann_memorial', true),
        ];
    }

    if (!$items) return;
    ?>
    <div class="modal-backdrop" id="tea-popup-backdrop" hidden>
        <section class="announcement-modal" id="tea-announcement-modal" role="dialog" aria-modal="true" aria-labelledby="announcement-title">
            <button class="modal-close" type="button" data-tea-close aria-label="<?php echo esc_attr(tea_ann_lang('ปิดประกาศ', 'Close announcement')); ?>">×</button>
            <div class="modal-image">
                <?php foreach ($items as $i) : ?>
                <div class="tea-modal-slide" data-slide-id="<?php echo esc_attr($i['id']); ?>"<?php echo $i === $items[0] ? '' : ' hidden'; ?>>
                    <?php if ($i['image']) : ?>
                    <img src="<?php echo esc_url($i['image']); ?>" alt="<?php echo esc_attr($i['title']); ?>">
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <?php if (count($items) > 1) : ?>
                <button class="slide-arrow previous" type="button" data-tea-dir="-1" aria-label="<?php echo esc_attr(tea_ann_lang('ประกาศก่อนหน้า', 'Previous announcement')); ?>">‹</button>
                <button class="slide-arrow next" type="button" data-tea-dir="1" aria-label="<?php echo esc_attr(tea_ann_lang('ประกาศถัดไป', 'Next announcement')); ?>">›</button>
                <?php endif; ?>
                <span class="slide-source" data-tea-source><?php echo esc_html(tea_ann_lang('ที่มา', 'Source') . ': ' . ($items[0]['source'] ?: get_bloginfo('name'))); ?></span>
            </div>
            <div class="modal-copy">
                <div class="slide-count" data-tea-count>01 / <?php echo str_pad(count($items), 2, '0', STR_PAD_LEFT); ?></div>
                <p class="section-kicker" data-tea-kicker><?php echo esc_html($items[0]['kicker']); ?></p>
                <h2 id="announcement-title" data-tea-title><?php echo esc_html($items[0]['title']); ?></h2>
                <p data-tea-desc><?php echo esc_html($items[0]['excerpt']); ?></p>
                <div class="modal-actions">
                    <a class="button primary" data-tea-btn href="<?php echo esc_url($items[0]['link']); ?>"><?php echo esc_html($items[0]['btnText']); ?></a>
                </div>
                <?php if (count($items) > 1) : ?>
                <div class="slide-dots" role="tablist" aria-label="<?php echo esc_attr(tea_ann_lang('เลือกประกาศ', 'Select announcement')); ?>" data-tea-dots></div>
                <?php endif; ?>
                <button class="remember-close" type="button" data-tea-close><?php echo tea_ann_lang('ปิดและไม่แสดงประกาศนี้อีก', "Close and don't show this again"); ?></button>
            </div>
        </section>
    </div>
    <script>window.tea_ann_is_en = <?php echo ( function_exists( 'pll_current_language' ) && pll_current_language() === 'en' ) ? 'true' : 'false'; ?>;
window.TEA_ANNOUNCEMENTS = <?php echo json_encode($items, JSON_UNESCAPED_UNICODE); ?>;</script>
    <?php
}
add_action('wp_footer', 'tea_ann_render');

function tea_ann_assets() {
    wp_enqueue_style('tea-popup', plugins_url('popup.css', __FILE__), [], '2.1.0');
    wp_enqueue_script('tea-popup', plugins_url('popup.js', __FILE__), [], '2.1.3', true);
}
add_action('wp_enqueue_scripts', 'tea_ann_assets');
