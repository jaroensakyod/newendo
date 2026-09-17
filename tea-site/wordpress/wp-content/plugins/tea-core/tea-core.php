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

/**
 * Simplified admin for association staff.
 * Keep technical settings available to administrators, while editors see
 * only the content workflows they use every day.
 */
function tea_core_simplify_admin() {
    if (!is_admin() || current_user_can('manage_options')) return;

    remove_menu_page('edit.php');               // Posts
    remove_menu_page('upload.php');             // Media
    remove_menu_page('edit-comments.php');
    remove_menu_page('themes.php');
    remove_menu_page('plugins.php');
    remove_menu_page('tools.php');
    remove_menu_page('options-general.php');
    remove_menu_page('users.php');
    remove_menu_page('edit.php?post_type=page');

}
add_action('admin_menu', 'tea_core_simplify_admin', 999);

/**
 * Facebook Reel links shown on the homepage.
 * One line per item: Facebook URL | optional caption
 */
function tea_core_get_reels() {
    $items = get_option('tea_facebook_reels', []);
    return is_array($items) ? array_values(array_filter($items, function ($item) {
        return is_array($item) && !empty($item['url']);
    })) : [];
}

function tea_core_reels_admin_menu() {
    if (!current_user_can('edit_posts')) return;
    add_menu_page(
        'Facebook Reels',
        'Facebook Reels',
        'edit_posts',
        'tea-facebook-reels',
        'tea_core_reels_settings_page',
        'dashicons-video-alt3',
        31
    );
}
add_action('admin_menu', 'tea_core_reels_admin_menu', 1001);

function tea_core_reels_settings_page() {
    if (!current_user_can('edit_posts')) return;
    if (!empty($_POST['tea_reels_save'])) {
        check_admin_referer('tea_reels_save');
        $lines = preg_split('/\r\n|\r|\n/', (string) wp_unslash($_POST['tea_reels'] ?? ''));
        $items = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;
            [$url, $caption] = array_pad(array_map('trim', explode('|', $line, 2)), 2, '');
            $host = strtolower((string) wp_parse_url($url, PHP_URL_HOST));
            if (!$url || !wp_http_validate_url($url) || !preg_match('/(^|\.)facebook\.com$|(^|\.)fb\.watch$/', $host)) continue;
            $items[] = ['url' => esc_url_raw($url), 'caption' => sanitize_text_field($caption)];
        }
        update_option('tea_facebook_reels', $items, false);
        echo '<div class="notice notice-success is-dismissible"><p>บันทึกลิงก์ Facebook Reel แล้ว</p></div>';
    }
    $lines = array_map(function ($item) {
        return $item['url'] . (!empty($item['caption']) ? ' | ' . $item['caption'] : '');
    }, tea_core_get_reels());
    ?>
    <div class="wrap">
      <h1>Facebook Reels หน้าแรก</h1>
      <p>ใส่ลิงก์ Reel สาธารณะของสมาคม บรรทัดละ 1 รายการ หากต้องการใส่ชื่อคลิปให้พิมพ์ต่อท้ายด้วยเครื่องหมาย <code>|</code></p>
      <form method="post">
        <?php wp_nonce_field('tea_reels_save'); ?>
        <textarea name="tea_reels" rows="12" style="width: min(760px, 100%); font-family: monospace;" placeholder="https://www.facebook.com/reel/123456789/ | ชื่อกิจกรรม"><?php echo esc_textarea(implode("\n", $lines)); ?></textarea>
        <p class="description">ระบบจะแสดงเป็นแถบเลื่อนบนหน้าแรก และกดเล่นผ่านตัวเล่นของ Facebook ได้</p>
        <p><button type="submit" name="tea_reels_save" value="1" class="button button-primary">บันทึก Reel</button></p>
      </form>
    </div>
    <?php
}

function tea_core_admin_bar($bar) {
    if (current_user_can('manage_options')) return;
    $bar->remove_node('wp-logo');
    $bar->remove_node('customize');
    $bar->remove_node('comments');
    $bar->remove_node('new-content');
}
add_action('admin_bar_menu', 'tea_core_admin_bar', 999);

function tea_core_staff_dashboard() {
    if (!is_admin() || current_user_can('manage_options')) return;
    wp_add_dashboard_widget('tea_staff_welcome', 'การจัดการเว็บไซต์สมาคม', function () {
        echo '<p>เลือกประเภทเนื้อหาจากเมนูด้านซ้ายเพื่อเพิ่มหรือแก้ไขข้อมูล</p>';
        echo '<ul style="list-style:disc;margin-left:20px">';
        echo '<li>ข่าวสาร — ข่าวประชาสัมพันธ์ทั่วไป</li>';
        echo '<li>ประกาศ — ข้อความที่ต้องการแสดงเป็น Popup</li>';
        echo '<li>กิจกรรม — งานประชุมและอบรม</li>';
        echo '<li>ทุนวิจัย — กำหนดการและรายละเอียดทุน</li>';
        echo '<li>วารสาร / เอกสาร — ไฟล์และเนื้อหาสำหรับดาวน์โหลด</li>';
        echo '</ul>';
        echo '<p><strong>เคล็ดลับ:</strong> หากไม่แน่ใจ ให้บันทึกเป็นฉบับร่างก่อนเผยแพร่</p>';
    });
}
add_action('wp_dashboard_setup', 'tea_core_staff_dashboard');

function tea_core_admin_footer() {
    if (!current_user_can('manage_options')) {
        echo 'ระบบจัดการเว็บไซต์สมาคมเอ็นโดดอนติกส์ไทย';
    }
}
add_filter('admin_footer_text', 'tea_core_admin_footer');
