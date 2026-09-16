<?php
/* seed-en2.php — เชื่อมโพสต์ IFEA + เพจอังกฤษ + เมนูอังกฤษ */
if (!defined('ABSPATH')) exit;

/* 1) โพสต์ IFEA: หาตัวที่ slug ซ้ำ แล้วตั้งภาษา en + ผูกกับ 31 */
foreach (get_posts(['post_type' => 'event', 'post_status' => 'publish', 'name' => 'the-15th-ifea-world-endodontic-congress', 'numberposts' => 5]) as $p) {
    $lang = pll_get_post_language($p->ID);
    echo "ifea found ID=" . $p->ID . " lang=" . ($lang ?: 'none') . " title=" . $p->post_title . "\n";
    if ($lang !== 'en' && $lang !== 'th') {
        pll_set_post_language($p->ID, 'en');
        pll_save_post_translations(['th' => 31, 'en' => $p->ID]);
        echo "ifea linked as EN of 31\n";
    } elseif ($lang === 'en') {
        pll_save_post_translations(['th' => 31, 'en' => $p->ID]);
        echo "ifea already EN, linked\n";
    }
}

/* 2) เพจ About (EN) — สร้างถ้ายังไม่มี */
$about_en = get_posts(['post_type' => 'page', 'post_status' => 'publish', 'name' => 'about-en', 'numberposts' => 1]);
if (!$about_en) {
    $about_en_id = wp_insert_post([
        'post_title'   => 'About the Association',
        'post_name'    => 'about-en',
        'post_content' => "<p class=\"tp-lead\">The Thai Endodontic Association is the professional society for endodontics in Thailand, dedicated to advancing the science and practice of root canal treatment, supporting continuing education (CDEC), funding research and publishing the Thai Endodontic Journal.</p>"
            . "<div class=\"tp-info-grid\">"
            . "<div class=\"tp-info\"><span class=\"k\"><span class=\"material-symbols-outlined\">flag</span> Role</span><span class=\"v\">Professional society for endodontics in Thailand</span></div>"
            . "<div class=\"tp-info\"><span class=\"k\"><span class=\"material-symbols-outlined\">public</span> Networks</span><span class=\"v\">IFEA and APEC member</span></div>"
            . "<div class=\"tp-info\"><span class=\"k\"><span class=\"material-symbols-outlined\">location_on</span> Office</span><span class=\"v\">Department of Operative Dentistry<small>Faculty of Dentistry, Chulalongkorn University, Bangkok 10330</small></span></div>"
            . "</div>"
            . "<h2>Executive Committee 2026–2027</h2>"
            . "<p>The Executive Committee leads the Association's scientific conferences and training, research funds, the Thai Endodontic Journal and international collaborations.</p>"
            . "<div class=\"tp-cta\"><span class=\"msg\">Contact the Association office for membership and activities<small>Tel. 02-218-8795 · thaiendodontics@gmail.com</small></span><a href=\"/contact/\"><span class=\"material-symbols-outlined\">forum</span>Contact us</a></div>",
        'post_status'  => 'publish',
        'post_type'    => 'page',
    ], true);
    if (!is_wp_error($about_en_id)) {
        pll_set_post_language($about_en_id, 'en');
        pll_save_post_translations(['th' => 12, 'en' => $about_en_id]);
        echo "about EN page created: $about_en_id\n";
    }
} else {
    pll_set_post_language($about_en[0]->ID, 'en');
    pll_save_post_translations(['th' => 12, 'en' => $about_en[0]->ID]);
    echo "about EN page existed, linked\n";
}

/* 3) เพจ Contact (EN) — ใช้ template เดียวกัน */
$contact_en = get_posts(['post_type' => 'page', 'post_status' => 'publish', 'name' => 'contact-en', 'numberposts' => 1]);
if (!$contact_en) {
    $contact_en_id = wp_insert_post([
        'post_title'   => 'Contact the Association',
        'post_name'    => 'contact-en',
        'post_content' => "<p>For enquiries about membership, conferences, research grants and the journal, contact the Association office.</p>",
        'post_status'  => 'publish',
        'post_type'    => 'page',
    ], true);
    if (!is_wp_error($contact_en_id)) {
        update_post_meta($contact_en_id, '_wp_page_template', 'page-contact.php');
        pll_set_post_language($contact_en_id, 'en');
        pll_save_post_translations(['th' => 13, 'en' => $contact_en_id]);
        echo "contact EN page created: $contact_en_id\n";
    }
} else {
    pll_set_post_language($contact_en[0]->ID, 'en');
    pll_save_post_translations(['th' => 13, 'en' => $contact_en[0]->ID]);
    echo "contact EN page existed, linked\n";
}

/* 4) เมนูอังกฤษ + ผูก location primary ให้ภาษา en */
$menu_name = 'Primary Menu (English)';
$menu = wp_get_nav_menu_object($menu_name);
if (!$menu) {
    $menu_id = wp_create_nav_menu($menu_name);
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title'  => 'Home',
        'menu-item-url'    => home_url('/en/'),
        'menu-item-status' => 'publish',
    ]);
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title'  => 'News',
        'menu-item-url'    => home_url('/en/news/'),
        'menu-item-status' => 'publish',
    ]);
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title'  => 'Conferences & Training',
        'menu-item-url'    => home_url('/en/events/'),
        'menu-item-status' => 'publish',
    ]);
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title'  => 'Research Grants',
        'menu-item-url'    => home_url('/en/research-funds/'),
        'menu-item-status' => 'publish',
    ]);
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title'  => 'TEJ Journal',
        'menu-item-url'    => 'https://he03.tci-thaijo.org/index.php/thaiendod',
        'menu-item-status' => 'publish',
    ]);
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title'  => 'Documents',
        'menu-item-url'    => home_url('/en/documents/'),
        'menu-item-status' => 'publish',
    ]);
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title'  => 'About the Association',
        'menu-item-url'    => home_url('/en/about-en/'),
        'menu-item-status' => 'publish',
    ]);
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title'  => 'Contact',
        'menu-item-url'    => home_url('/en/contact-en/'),
        'menu-item-status' => 'publish',
    ]);
    $locations = get_theme_mod('nav_menu_locations', []);
    if (!isset($locations['primary']) || !is_array($locations['primary'])) {
        $locations['primary'] = [];
    }
    // Polylang: ผูกเมนูต่อภาษา
    $options = get_option('polylang', []);
    $options['nav_menus']['primary']['en'] = $menu_id;
    update_option('polylang', $options);
    // กำหนด location ปกติด้วย (กันธีมตั้งค่าไม่ครบ)
    $locations['primary'] = is_array($locations['primary']) ? $locations['primary'] : [];
    set_theme_mod('nav_menu_locations', $locations);
    echo "EN menu created: $menu_id\n";
} else {
    echo "EN menu exists: " . $menu->term_id . "\n";
}
