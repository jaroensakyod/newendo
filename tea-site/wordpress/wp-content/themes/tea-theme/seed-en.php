<?php
/* seed-en.php — สร้างโพสต์/เพจเวอร์ชันอังกฤษ + ผูก translation (wp eval-file) */
if (!defined('ABSPATH')) exit;

$DATA = json_decode(file_get_contents(get_template_directory() . '/seed-en.json'), true);
if (!$DATA) { echo "NO DATA\n"; exit; }

/* 1) กำหนดภาษาไทยให้โพสต์/เพจเดิมที่ยังไม่มีภาษา */
$th_id = PLL()->model->get_language('th')->term_id;
foreach (get_posts(['numberposts' => -1, 'post_status' => 'publish', 'post_type' => ['news', 'announcement', 'event', 'research_fund', 'journal', 'document', 'page']]) as $p) {
    if (!pll_get_post_language($p->ID)) {
        pll_set_post_language($p->ID, 'th');
    }
}
echo "th assigned\n";

/* 2) ลบ Sample Page ทิ้ง */
foreach (get_posts(['numberposts' => 1, 'post_status' => 'publish', 'post_type' => 'page', 'name' => 'sample-page']) as $sp) {
    wp_delete_post($sp->ID, true);
    echo "sample page deleted\n";
}

/* 3) สร้างโพสต์อังกฤษ + ผูกคู่แปล */
$created = [];
foreach ($DATA as $th_id => $d) {
    $th_id = (int) $th_id;
    $exists = get_posts(['post_type' => 'any', 'post_status' => 'publish', 'name' => $d['slug'], 'numberposts' => 1]);
    if ($exists) { $created[] = $th_id . ':exists'; continue; }

    $en_id = wp_insert_post([
        'post_title'   => $d['title'],
        'post_name'    => $d['slug'],
        'post_content' => $d['content'],
        'post_excerpt' => $d['excerpt'],
        'post_status'  => 'publish',
        'post_type'    => get_post_type($th_id),
    ], true);
    if (is_wp_error($en_id)) { $created[] = $th_id . ':ERR'; continue; }

    pll_set_post_language($en_id, 'en');
    pll_save_post_translations(['th' => $th_id, 'en' => $en_id]);

    $thumb = get_post_thumbnail_id($th_id);
    if ($thumb) { set_post_thumbnail($en_id, $thumb); }

    $created[] = $th_id . ':EN' . $en_id;
}
echo 'POSTS: ' . implode(' ', $created) . "\n";
