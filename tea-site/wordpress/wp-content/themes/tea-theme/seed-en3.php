<?php
/* seed-en3.php — สร้างโพสต์ IFEA อังกฤษ + ผูกคู่แปล */
if (!defined('ABSPATH')) exit;
$DATA = json_decode(file_get_contents(get_template_directory() . '/seed-en.json'), true);
$d = $DATA['31'];
$en_id = wp_insert_post([
    'post_title'   => $d['title'],
    'post_name'    => $d['slug'] . '-en',
    'post_content' => $d['content'],
    'post_excerpt' => $d['excerpt'],
    'post_status'  => 'publish',
    'post_type'    => 'event',
], true);
if (is_wp_error($en_id)) { echo "ERR: " . $en_id->get_error_message() . "\n"; exit; }
pll_set_post_language($en_id, 'en');
pll_save_post_translations(['th' => 31, 'en' => $en_id]);
$thumb = get_post_thumbnail_id(31);
if ($thumb) { set_post_thumbnail($en_id, $thumb); }
echo "IFEA EN created: $en_id\n";
