<?php
if (!defined('ABSPATH')) exit;
get_header();
$members = require get_template_directory() . '/parts/committee-data.php';
$is_en = function_exists('pll_current_language') && pll_current_language() === 'en';
$t = static function ($th, $en) use ($is_en) { return $is_en ? $en : $th; };
$asset = static function ($file) { return get_template_directory_uri() . '/assets/' . $file; };
$groups = [
  'president' => ['th' => 'นายกสมาคม', 'en' => 'President'],
  'advisors' => ['th' => 'ที่ปรึกษาสมาคม', 'en' => 'Association Advisors'],
  'central' => ['th' => 'กรรมการกลาง', 'en' => 'Central Committee'],
  'executive' => ['th' => 'คณะกรรมการบริหาร', 'en' => 'Executive Committee'],
];
?>
<section class="page-hero page-hero-compact">
  <div class="shell">
    <nav class="breadcrumb" aria-label="<?php esc_attr_e('เส้นทาง', 'tea-theme'); ?>"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('หน้าแรก', 'tea-theme'); ?></a><span aria-hidden="true">›</span><span><?php echo esc_html($t('คณะกรรมการบริหาร', 'Executive Committee')); ?></span></nav>
    <span class="page-hero-kicker"><span class="material-symbols-outlined" aria-hidden="true">groups</span> <?php echo esc_html($t('COMMITTEE', 'COMMITTEE')); ?></span>
    <h1><?php echo esc_html($t('คณะกรรมการบริหารสมาคม', 'Executive Committee')); ?></h1>
    <p><?php echo esc_html($t('สมาคมเอ็นโดดอนติกส์ไทย วาระ 2569–2570', 'Thai Endodontic Association, term 2026–2027')); ?></p>
  </div>
</section>

<section class="committee-page">
  <div class="shell">
    <header class="committee-page-intro"><span><?php echo esc_html($t('วาระ 2569–2570', 'TERM 2026–2027')); ?></span><h2><?php echo esc_html($t('คณะกรรมการสมาคม', 'Association Committee')); ?></h2></header>

    <?php foreach ($groups as $group_key => $group) : ?>
      <?php $group_members = array_values(array_filter($members, static function ($member) use ($group_key) { return $member['group'] === $group_key; })); ?>
      <?php if (empty($group_members)) continue; ?>
      <section class="committee-group committee-group-<?php echo esc_attr($group_key); ?>">
        <header class="committee-group-head"><div><h2><?php echo esc_html($t($group['th'], $group['en'])); ?></h2></div></header>
        <div class="committee-grid">
          <?php foreach ($group_members as $member) : ?>
          <article class="committee-card">
            <div class="committee-portrait"><img src="<?php echo esc_url($asset($member['image'])); ?>" alt="<?php echo esc_attr($is_en ? $member['name_en'] : $member['name']); ?>" width="420" height="540" loading="lazy"></div>
            <div><span><?php echo esc_html($is_en ? $member['role_en'] : $member['role_th']); ?></span><h3><?php echo esc_html($is_en ? $member['name_en'] : $member['name']); ?></h3></div>
          </article>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>
  </div>
</section>
<?php get_footer();
