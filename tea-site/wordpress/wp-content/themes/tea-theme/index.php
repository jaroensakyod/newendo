<?php if (!defined('ABSPATH')) exit; get_header();

$tea_page_title = '';
$tea_page_desc = '';
$tea_page_kicker = '';
$tea_page_icon = '';
$tea_is_news_archive = is_post_type_archive('news');
$tea_is_event_archive = is_post_type_archive('event');
$tea_is_research_archive = is_post_type_archive('research_fund');
$tea_uses_editorial_archive_layout = $tea_is_news_archive || $tea_is_event_archive || $tea_is_research_archive;
if (is_home()) {
    $tea_page_title = tea_cpt_label('post', 'บทความ');
} elseif (is_archive()) {
    $pto = get_post_type_object(get_post_type());
    $tea_page_title = tea_cpt_label(get_post_type(), $pto ? $pto->labels->name : get_the_archive_title());
    $tea_page_desc = $pto && !empty($pto->description) ? $pto->description : '';
} elseif (is_search()) {
    $tea_page_title = sprintf('%s: %s', esc_html__('ผลการค้นหา', 'tea-theme'), get_search_query());
}
if ($tea_is_news_archive && !$tea_page_desc) {
    $tea_page_desc = __('รวมข่าวประชาสัมพันธ์ ประกาศสำคัญ และกิจกรรมวิชาการจากสมาคมเอ็นโดดอนติกส์ไทย', 'tea-theme');
}
if (is_archive() && !$tea_is_news_archive) {
    $tea_archive_copy = [
        'event' => ['ACTIVITIES', __('ติดตามกิจกรรม การประชุม และการอบรมวิชาการของสมาคม', 'tea-theme'), 'calendar_month'],
        'research_fund' => ['RESEARCH FUND', __('โอกาสและข้อมูลสนับสนุนงานวิจัยด้านเอ็นโดดอนติกส์', 'tea-theme'), 'science'],
        'document' => ['DOCUMENTS', __('รวบรวมเอกสาร แบบฟอร์ม และข้อมูลสำคัญของสมาคม', 'tea-theme'), 'folder_open'],
    ];
    $tea_archive_type = get_post_type();
    if (isset($tea_archive_copy[$tea_archive_type])) {
        $tea_page_kicker = $tea_archive_copy[$tea_archive_type][0];
        $tea_page_icon = $tea_archive_copy[$tea_archive_type][2];
        if (!$tea_page_desc) $tea_page_desc = $tea_archive_copy[$tea_archive_type][1];
    }
}
$tea_editorial_icon = $tea_is_event_archive ? 'calendar_month' : ($tea_is_research_archive ? 'science' : 'feed');
$tea_editorial_kicker = $tea_is_event_archive ? 'ACTIVITIES' : ($tea_is_research_archive ? 'RESEARCH FUND' : 'NEWS & ANNOUNCEMENTS');
$tea_editorial_title = $tea_is_news_archive ? __('ข่าวสารประชาสัมพันธ์ล่าสุด', 'tea-theme') : $tea_page_title;
$tea_editorial_url = $tea_is_event_archive ? get_post_type_archive_link('event') : ($tea_is_research_archive ? get_post_type_archive_link('research_fund') : get_post_type_archive_link('news'));
$tea_editorial_link = $tea_is_event_archive ? __('ดูกิจกรรมทั้งหมด', 'tea-theme') : ($tea_is_research_archive ? __('ดูทุนวิจัยทั้งหมด', 'tea-theme') : __('ดูข่าวทั้งหมด', 'tea-theme'));
?>

<?php if ($tea_uses_editorial_archive_layout) : ?>
<section class="archive-news-head">
  <div class="shell">
    <span class="archive-news-kicker"><span class="material-symbols-outlined" aria-hidden="true"><?php echo esc_html($tea_editorial_icon); ?></span> <?php echo esc_html($tea_editorial_kicker); ?></span>
    <div class="archive-news-title-row">
      <div>
        <h1><?php echo esc_html($tea_editorial_title); ?></h1>
        <p><?php echo esc_html($tea_page_desc); ?></p>
      </div>
      <a href="<?php echo esc_url($tea_editorial_url); ?>"><?php echo esc_html($tea_editorial_link); ?> <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></a>
    </div>
  </div>
</section>

<?php else : ?>
<section class="page-hero">
  <div class="shell">
    <nav class="breadcrumb" aria-label="<?php esc_attr_e('เส้นทาง', 'tea-theme'); ?>">
      <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('หน้าแรก', 'tea-theme'); ?></a>
      <span aria-hidden="true">›</span>
      <span><?php echo esc_html($tea_page_title); ?></span>
    </nav>
    <?php if ($tea_page_kicker) : ?><span class="page-hero-kicker"><span class="material-symbols-outlined" aria-hidden="true"><?php echo esc_html($tea_page_icon); ?></span> <?php echo esc_html($tea_page_kicker); ?></span><?php endif; ?>
    <h1><?php echo esc_html($tea_page_title); ?></h1>
    <?php if ($tea_page_desc) : ?><p><?php echo esc_html($tea_page_desc); ?></p><?php endif; ?>
  </div>
</section>
<?php endif; ?>

<div class="shell archive-wrap<?php echo $tea_uses_editorial_archive_layout ? ' news-archive-wrap' : ''; ?>">
  <?php if (!$tea_uses_editorial_archive_layout) : ?>
  <form class="search-form-main" method="get" action="<?php echo esc_url(home_url('/')); ?>">
    <input type="search" name="s" value="<?php the_search_query(); ?>" placeholder="<?php esc_attr_e('ค้นหาข้อมูล ข่าว หรือเอกสาร…', 'tea-theme'); ?>">
    <button type="submit"><?php esc_html_e('ค้นหา', 'tea-theme'); ?></button>
  </form>
  <?php endif; ?>

  <?php if (have_posts()) : ?>
    <div class="news-grid">
      <?php $i = 0; while (have_posts()) : the_post(); ?>
        <article class="news-card<?php echo $i === 0 ? ' featured' : ''; ?>">
          <a class="news-image" href="<?php the_permalink(); ?>">
            <?php
            // A few legacy media records point to old upload URLs.  Use the
            // maintained theme copies for these editorial cards so every
            // language version has a reliable image.
            $tea_archive_card_assets = [
              184 => 'news-ifea-board-2026-2028.png', 185 => 'news-ifea-board-2026-2028.png',
              30 => 'event-dental-trauma-nov-2026.png', 62 => 'event-dental-trauma-nov-2026.png', 88 => 'event-dental-trauma-nov-2026.png', 187 => 'event-dental-trauma-nov-2026.png',
              5 => 'event-dental-trauma-nov-2026.png', 55 => 'event-dental-trauma-nov-2026.png',
              7 => 'poster-research-fund-1-2569.png', 32 => 'poster-research-fund-1-2569.png', 57 => 'poster-research-fund-1-2569.png', 63 => 'poster-research-fund-1-2569.png',
              33 => 'journal-call.jpg', 64 => 'journal-call.jpg',
              6 => 'news-ifea-board-2026-2028.png', 56 => 'news-ifea-board-2026-2028.png',
              8 => 'poster-country-speaker.jpg', 58 => 'poster-country-speaker.jpg',
            ];
            $tea_card_asset = $tea_archive_card_assets[get_the_ID()] ?? '';
            if ($tea_card_asset) : ?>
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/' . $tea_card_asset); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="eager">
            <?php elseif (has_post_thumbnail()) : the_post_thumbnail('large', ['loading' => 'eager']); else : ?>
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/poster-annual-2568.jpg'); ?>" alt="">
            <?php endif; ?>
            <span><?php
            $pto = get_post_type_object(get_post_type());
            echo esc_html(tea_cpt_label(get_post_type(), $pto ? $pto->labels->name : ''));
            ?></span>
          </a>
          <div class="news-body">
            <time><?php tea_the_date(); ?></time>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p><?php echo esc_html(get_the_excerpt()); ?></p>
            <?php if (get_post_type() === 'document') :
                $file = get_post_meta(get_the_ID(), '_tea_file_url', true);
                if ($file) : ?>
                  <a class="text-link doc-link" href="<?php echo esc_url($file); ?>" download><?php esc_html_e('ดาวน์โหลดไฟล์', 'tea-theme'); ?> ↓</a>
                <?php endif;
            else : ?>
              <a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e('อ่านรายละเอียด', 'tea-theme'); ?> →</a>
            <?php endif; ?>
          </div>
        </article>
      <?php $i++; endwhile; ?>
    </div>
    <div class="pagination"><?php the_posts_pagination(['mid_size' => 2]); ?></div>
    <?php if ($tea_is_event_archive) : ?>
    <section class="event-social-hub" aria-label="<?php esc_attr_e('กิจกรรมและภาพข่าวจาก Facebook สมาคม', 'tea-theme'); ?>">
      <div class="event-social-intro">
        <span class="event-social-source"><span aria-hidden="true">f</span> Facebook / Thaiendodontics</span>
        <h2><?php esc_html_e('ภาพกิจกรรมและข่าวจากสมาคม', 'tea-theme'); ?></h2>
        <p><?php esc_html_e('รวมภาพและโปสเตอร์กิจกรรมที่สมาคมเผยแพร่ไว้ในที่เดียว เลื่อนดูภาพด้านข้าง แล้วกดติดตามเพื่อรับข่าวล่าสุดจากช่องทางทางการ', 'tea-theme'); ?></p>
        <a class="event-social-follow" href="https://www.facebook.com/Thaiendodontics/" target="_blank" rel="noreferrer"><span class="material-symbols-outlined" aria-hidden="true">open_in_new</span><?php esc_html_e('ติดตาม Facebook สมาคม', 'tea-theme'); ?></a>
      </div>
      <div class="event-social-rail" role="list" aria-label="<?php esc_attr_e('เลื่อนดูภาพกิจกรรม', 'tea-theme'); ?>">
        <?php
        $tea_event_photos = [
          ['fb-meeting1.jpg', 'ภาพข่าวกิจกรรมจาก Facebook สมาคม'],
          ['fb-meeting2.jpg', 'ภาพบรรยากาศกิจกรรมจาก Facebook สมาคม'],
          ['fb-cover.jpg', 'ภาพรวมข่าวสารของสมาคม'],
          ['event-dental-trauma-nov-2026.png', 'ประชาสัมพันธ์งาน Dental Trauma and Root Resorption 2569'],
          ['event-uncovered-online-2569.png', 'ประชาสัมพันธ์กิจกรรมวิชาการออนไลน์'],
          ['poster-annual-2568.jpg', 'โปสเตอร์กิจกรรมวิชาการประจำปี'],
          ['committee-2026.jpg', 'ภาพคณะกรรมการสมาคม'],
          ['mothers-day-announcement.jpg', 'ประกาศจากสมาคม'],
        ];
        foreach ($tea_event_photos as [$photo, $caption]) : ?>
        <a class="event-social-photo" role="listitem" href="https://www.facebook.com/Thaiendodontics/" target="_blank" rel="noreferrer">
          <span class="event-social-photo-frame"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/' . $photo); ?>" alt="<?php echo esc_attr(__($caption, 'tea-theme')); ?>" loading="lazy"></span>
          <b><?php echo esc_html(__($caption, 'tea-theme')); ?></b>
          <small>Facebook / Thaiendodontics <span aria-hidden="true">↗</span></small>
        </a>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>
  <?php else : ?>
    <div class="content-card empty-state">
      <h2><?php esc_html_e('ยังไม่มีเนื้อหาในหมวดนี้', 'tea-theme'); ?></h2>
      <p><?php esc_html_e('เนื้อหาจะได้รับการอัปเดตจากสำนักงานสมาคมเร็ว ๆ นี้ — ลองค้นหา หรือกลับไปหน้าแรก', 'tea-theme'); ?></p>
      <a class="button ghost" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('กลับหน้าแรก', 'tea-theme'); ?></a>
    </div>
  <?php endif; ?>
</div>
<?php get_footer();
