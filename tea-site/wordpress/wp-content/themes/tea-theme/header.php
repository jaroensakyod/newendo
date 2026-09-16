<?php if (!defined('ABSPATH')) exit; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/favicon.svg'); ?>" type="image/svg+xml">
<link rel="alternate icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/favicon.png'); ?>" type="image/png">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="tea-grain" aria-hidden="true"></div>

<div class="site" id="top">

<div class="top-strip">
  <div class="shell top-strip-inner">
    <span><?php echo (function_exists('pll_current_language') && pll_current_language() === 'en') ? 'Thai Endodontic Association' : 'Thai Endodontic Association • สมาคมเอ็นโดดอนติกส์ไทย'; ?></span>
    <div class="top-contact">
      <span class="strip-note">Official Clinical Journal: Thai Endodontic Journal (TCI Tier 2)</span>
      <span class="strip-note">Affiliated with IFEA &amp; APEC</span>
      <span class="utility-separator" aria-hidden="true">|</span>
      <div class="accessibility-tools" aria-label="<?php esc_attr_e('เครื่องมือการเข้าถึง', 'tea-theme'); ?>">
        <?php tea_language_switcher(); ?>
        <button type="button" id="tea-search-toggle" aria-expanded="false" aria-label="<?php esc_attr_e('ค้นหาในเว็บไซต์', 'tea-theme'); ?>">/<?php esc_html_e('ค้นหา', 'tea-theme'); ?></button>
      </div>
    </div>
  </div>
</div>
</div>

<header class="site-header">
  <div class="shell nav-wrap">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('หน้าแรกสมาคม', 'tea-theme'); ?>">
      <picture>
        <img class="brand-logo brand-logo-horizontal" src="<?php echo esc_url(get_template_directory_uri() . '/assets/logo-horizontal.svg?v=2'); ?>" alt="<?php esc_attr_e('สมาคมเอ็นโดดอนติกส์ไทย Thai Endodontic Association', 'tea-theme'); ?>" width="310" height="64">
      </picture>
    </a>
    <button class="menu-button" type="button" aria-expanded="false" aria-controls="main-navigation" onclick="this.closest('.nav-wrap').querySelector('.main-nav').classList.toggle('is-open')">
      <span></span><span></span><span></span>
      <span class="sr-only"><?php esc_html_e('เปิดเมนู', 'tea-theme'); ?></span>
    </button>
    <nav id="main-navigation" class="main-nav" aria-label="<?php esc_attr_e('เมนูหลัก', 'tea-theme'); ?>">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'fallback_cb'    => false,
      ]);
      ?>
    </nav>

  </div>
</header>

<section class="search-panel" id="tea-search-panel" hidden aria-label="<?php esc_attr_e('ค้นหาในเว็บไซต์', 'tea-theme'); ?>">
  <div class="shell search-panel-inner">
    <label for="tea-site-search"><?php esc_html_e('ค้นหาข้อมูล ข่าว หรือเอกสาร', 'tea-theme'); ?></label>
    <form class="search-box" method="get" action="<?php echo esc_url(home_url('/')); ?>">
      <input id="tea-site-search" type="search" name="s" placeholder="<?php esc_attr_e('เช่น ทุนวิจัย, วารสาร, ใบประกาศ', 'tea-theme'); ?>">
      <button type="submit"><?php esc_html_e('ค้นหา', 'tea-theme'); ?></button>
    </form>
    <div class="search-suggestions">
      <span>SUGGESTED:</span>
      <a href="<?php echo esc_url(get_post_type_archive_link('research_fund')); ?>"><?php esc_html_e('ทุนวิจัย 2569', 'tea-theme'); ?></a>
      <a href="<?php echo esc_url(get_post_type_archive_link('journal')); ?>">Thai Endodontic Journal</a>
      <a href="https://www.thaiendodontics.com/cert"><?php esc_html_e('ใบประกาศ CDEC', 'tea-theme'); ?></a>
    </div>
  </div>
</section>

<main id="content">
