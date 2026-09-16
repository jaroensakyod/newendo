<?php if (!defined('ABSPATH')) exit; get_header();
$pto = get_post_type_object(get_post_type());
$tea_section = $pto ? tea_cpt_label(get_post_type(), $pto->labels->name) : '';
$tea_page_kicker = is_page('about') ? __('ABOUT THE ASSOCIATION', 'tea-theme') : '';
$tea_page_icon = is_page('about') ? 'account_balance' : '';
?>
<?php while (have_posts()) : the_post(); ?>

<section class="page-hero page-hero-compact">
  <div class="shell">
    <nav class="breadcrumb" aria-label="<?php esc_attr_e('เส้นทาง', 'tea-theme'); ?>">
      <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('หน้าแรก', 'tea-theme'); ?></a>
      <?php if ($tea_section && get_post_type() !== 'page') : ?>
      <span aria-hidden="true">›</span>
      <?php if ($pto && !empty($pto->has_archive)) : ?>
        <a href="<?php echo esc_url(get_post_type_archive_link(get_post_type())); ?>"><?php echo esc_html($tea_section); ?></a>
      <?php else : ?>
        <span><?php echo esc_html($tea_section); ?></span>
      <?php endif; ?>
      <?php endif; ?>
      <span aria-hidden="true">›</span>
      <span><?php echo esc_html(wp_trim_words(get_the_title(), 8, '…')); ?></span>
    </nav>
    <?php if ($tea_page_kicker) : ?><span class="page-hero-kicker"><span class="material-symbols-outlined" aria-hidden="true"><?php echo esc_html($tea_page_icon); ?></span> <?php echo esc_html($tea_page_kicker); ?></span><?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <div class="page-hero-meta">
      <?php
      $type = get_post_type();
      if ($type === 'event') {
          $d = get_post_meta(get_the_ID(), '_tea_event_date', true);
          if ($d) echo '<span class="hero-chip">' . esc_html(tea_thai_date($d)) . '</span>';
      }
      ?>
      <span class="hero-chip"><?php echo esc_html($tea_section ?: get_post_type()); ?></span>
      <span class="hero-chip ghost-chip"><?php tea_the_date(); ?></span>
    </div>
  </div>
</section>

<div class="shell singular-wrap">
  <article class="content-card">
    <?php if (has_post_thumbnail()) : ?>
    <div class="content-thumb"><?php the_post_thumbnail('large'); ?></div>
    <?php endif; ?>

    <?php
    $type = get_post_type();
    if ($type === 'document') {
        $file = get_post_meta(get_the_ID(), '_tea_file_url', true);
        if ($file) {
            echo '<a class="button primary doc-link" href="' . esc_url($file) . '" download>' . esc_html__('ดาวน์โหลดไฟล์ (PDF)', 'tea-theme') . ' ↓</a>';
        }
    }
    ?>

    <div class="entry-content"><?php the_content(); ?></div>

    <footer class="entry-footer">
      <span><?php printf(esc_html__('เผยแพร่เมื่อ %s', 'tea-theme'), tea_thai_date(get_post_field('post_date'))); ?></span>
      <?php if ($tea_section && $pto && !empty($pto->has_archive)) : ?>
        <a class="text-link" href="<?php echo esc_url(get_post_type_archive_link(get_post_type())); ?>">
          ← <?php printf(esc_html__('ดูทั้งหมดใน %s', 'tea-theme'), esc_html($tea_section)); ?>
        </a>
      <?php endif; ?>
    </footer>
  </article>
</div>
<?php endwhile; ?>
<?php get_footer();
