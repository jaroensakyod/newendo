<?php if (!defined('ABSPATH')) exit;
/* page-contact.php — ใช้อัตโนมัติกับหน้า slug "contact" */
get_header();

$en = function_exists('pll_current_language') && pll_current_language() === 'en';
$t = function ($th, $en_str) use ($en) { return $en ? $en_str : $th; };

get_template_part('parts/contact-intake');
