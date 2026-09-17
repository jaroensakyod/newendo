<?php if (!defined('ABSPATH')) exit; get_header();

$img = function ($name) { return esc_url(get_template_directory_uri() . '/assets/' . $name); };

/* งานประชุมประจำปี: Dental Trauma 30 พ.ย. 2569 */
$event_date_str = '2026-11-30T08:00:00+07:00';
$tea_conference_post_id = 30;
if (function_exists('pll_current_language') && function_exists('pll_get_post') && pll_current_language() === 'en') {
  $tea_conference_post_id = (int) (pll_get_post(30, 'en') ?: $tea_conference_post_id);
}
$tea_conference_url = get_permalink($tea_conference_post_id);

/* ข่าวล่าสุด (แสดง 5: เด่น 1 + รายการ 4) */
$news_q = new WP_Query(['post_type' => ['news', 'announcement', 'event'], 'posts_per_page' => 9]);
/* ประกาศจากสมาคม */
$ann_q = new WP_Query(['post_type' => 'announcement', 'posts_per_page' => 5, 'no_found_rows' => true]);
/* งานประชุม/อบรม สำหรับแท็บ */
$evt_q = new WP_Query(['post_type' => 'event', 'posts_per_page' => 4, 'no_found_rows' => true]);
/* กิจกรรมสมาคมที่กำลังจะมาถึง */
$upcoming_q = new WP_Query(['post_type' => 'event', 'posts_per_page' => 3, 'no_found_rows' => true]);
$sheet_hero = function_exists('tea_sheet_bridge_front_rows') ? tea_sheet_bridge_front_rows('hero') : [];
$sheet_gallery = function_exists('tea_sheet_bridge_front_rows') ? tea_sheet_bridge_front_rows('gallery') : [];
$tea_reels = function_exists('tea_core_get_reels') ? tea_core_get_reels() : [];
?>

<div class="pea">

  <!-- ============ HERO SLIDER (แบบ กฟภ.: สไลด์เต็มจอ + เนื้อหาซ้าย + โปสเตอร์ขวา) ============ -->
  <section class="pea-hero">
    <div class="pea-track" id="pea-track">

      <?php if ($sheet_hero) : foreach ($sheet_hero as $slide) :
        $is_en = function_exists('pll_current_language') && pll_current_language() === 'en';
        $title = ($is_en && !empty($slide['หัวข้ออังกฤษ'])) ? $slide['หัวข้ออังกฤษ'] : ($slide['หัวข้อไทย'] ?? '');
        $detail = ($is_en && !empty($slide['รายละเอียดอังกฤษ'])) ? $slide['รายละเอียดอังกฤษ'] : ($slide['รายละเอียดไทย'] ?? '');
        $background = esc_url($slide['รูปพื้นหลัง URL'] ?? '');
      ?>
      <div class="pea-slide<?php echo $slide === $sheet_hero[0] ? ' is-active' : ''; ?>"<?php echo $background ? ' style="--bg:url(\'' . $background . '\')"' : ''; ?>>
        <div class="pea-shell pea-slide-in"><div class="pea-copy">
          <h1><?php echo esc_html($title); ?></h1>
          <?php if ($detail) : ?><p class="pea-sub"><?php echo esc_html($detail); ?></p><?php endif; ?>
          <div class="pea-actions">
          <?php if (!empty($slide['ลิงก์ปุ่มหลัก'])) : ?><a class="pea-btn pea-btn-accent" href="<?php echo esc_url($slide['ลิงก์ปุ่มหลัก']); ?>"><?php echo esc_html($slide['ปุ่มหลัก'] ?: __('อ่านเพิ่มเติม', 'tea-theme')); ?></a><?php endif; ?>
          <?php if (!empty($slide['ลิงก์ปุ่มรอง'])) : ?><a class="pea-btn pea-btn-ghost" href="<?php echo esc_url($slide['ลิงก์ปุ่มรอง']); ?>"><?php echo esc_html($slide['ปุ่มรอง'] ?: __('รายละเอียด', 'tea-theme')); ?></a><?php endif; ?>
          </div>
        </div></div>
      </div>
      <?php endforeach; else : ?>

      <div class="pea-slide is-active" style="--bg:url('<?php echo $img('event-dental-trauma-nov-2026.png'); ?>')">
        <div class="pea-shell pea-slide-in">
          <div class="pea-copy">
            <span class="pea-badge"><?php esc_html_e('ประชาสัมพันธ์งานประชุม', 'tea-theme'); ?> 2569</span>
            <h1>Dental Trauma <span><?php esc_html_e('and Root Resorption', 'tea-theme'); ?></span></h1>
            <p class="pea-sub">Guideline Updates and Clinical Management — <?php esc_html_e('อัปเดตแนวทางการรักษาและการจัดการทางคลินิก', 'tea-theme'); ?></p>
            <div class="pea-meta">
              <span><span class="material-symbols-outlined">event</span> <?php esc_html_e('30 พฤศจิกายน 2569', 'tea-theme'); ?></span>
              <span><span class="material-symbols-outlined">pin_drop</span> Grande Centre Point Lumphini</span>
              <span class="cde"><span class="material-symbols-outlined">workspace_premium</span> 6 CDE</span>
            </div>
            <div class="pea-actions">
              <a class="pea-btn pea-btn-accent" href="<?php echo esc_url($tea_conference_url); ?>"><span class="material-symbols-outlined">how_to_reg</span><?php esc_html_e('รายละเอียดและลงทะเบียน', 'tea-theme'); ?></a>
              <a class="pea-btn pea-btn-ghost" href="<?php echo esc_url($tea_conference_url); ?>"><span class="material-symbols-outlined">description</span><?php esc_html_e('โปสเตอร์งาน', 'tea-theme'); ?></a>
            </div>
          </div>
        </div>
      </div>

      <div class="pea-slide" style="--bg:url('<?php echo $img('n3-research-fund.jpg'); ?>')">
        <div class="pea-shell pea-slide-in">
          <div class="pea-copy">
            <span class="pea-badge pea-badge-orange"><?php esc_html_e('ทุนวิจัย รอบที่ 1/2569 เปิดรับสมัคร', 'tea-theme'); ?></span>
            <h1><?php esc_html_e('ทุนอุดหนุนการวิจัยทันตกรรม', 'tea-theme'); ?></h1>
            <p class="pea-sub"><?php esc_html_e('รอบที่ 1 เปิดรับสมัครระหว่างวันที่ 1 กันยายน ถึง 31 ตุลาคม พ.ศ. 2569 และประกาศผลการพิจารณาวันที่ 1 ธันวาคม พ.ศ. 2569', 'tea-theme'); ?></p>
            <div class="pea-meta">
              <span><span class="material-symbols-outlined">science</span> <?php esc_html_e('ไม่เกิน 100,000 บาท', 'tea-theme'); ?></span>
              <span><span class="material-symbols-outlined">schedule</span> <?php esc_html_e('ไม่เกิน 2 ปี', 'tea-theme'); ?></span>
            </div>
            <div class="pea-actions">
              <a class="pea-btn pea-btn-accent" href="<?php echo esc_url(get_post_type_archive_link('document')); ?>"><span class="material-symbols-outlined">download_for_offline</span><?php esc_html_e('ดาวน์โหลดใบสมัคร', 'tea-theme'); ?></a>
              <a class="pea-btn pea-btn-ghost" href="<?php echo esc_url(get_post_type_archive_link('research_fund')); ?>"><span class="material-symbols-outlined">rule</span><?php esc_html_e('หลักเกณฑ์ทุนวิจัย', 'tea-theme'); ?></a>
            </div>
          </div>
        </div>
      </div>

      <?php endif; ?>

    </div>

    <button class="pea-nav prev" type="button" id="pea-prev" aria-label="<?php esc_attr_e('สไลด์ก่อนหน้า', 'tea-theme'); ?>"><span class="material-symbols-outlined">chevron_left</span></button>
    <button class="pea-nav next" type="button" id="pea-next" aria-label="<?php esc_attr_e('สไลด์ถัดไป', 'tea-theme'); ?>"><span class="material-symbols-outlined">chevron_right</span></button>
    <div class="pea-dots" id="pea-dots" role="tablist" aria-label="<?php esc_attr_e('เลือกสไลด์', 'tea-theme'); ?>"></div>
  </section>

  <!-- ============ การ์ดลัดบริการ ลอยทับขอบล่าง hero (แบบ กฟภ.) ============ -->
  <div class="pea-shell">
    <div class="pea-shortcuts">
      <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>"><span class="ic"><span class="material-symbols-outlined">event</span></span><b><?php esc_html_e('ประชุม/อบรม', 'tea-theme'); ?></b></a>
      <a href="<?php echo esc_url(get_post_type_archive_link('research_fund')); ?>"><span class="ic"><span class="material-symbols-outlined">science</span></span><b><?php esc_html_e('ทุนวิจัย', 'tea-theme'); ?></b></a>
      <a href="<?php echo esc_url(get_post_type_archive_link('journal')); ?>"><span class="ic"><span class="material-symbols-outlined">article</span></span><b><?php esc_html_e('วารสาร TEJ', 'tea-theme'); ?></b></a>
      <a href="https://www.thaiendodontics.com/cert" target="_blank" rel="noreferrer"><span class="ic"><span class="material-symbols-outlined">verified</span></span><b><?php esc_html_e('ตรวจสอบ CDEC', 'tea-theme'); ?></b></a>
      <a href="<?php echo esc_url(get_post_type_archive_link('document')); ?>"><span class="ic"><span class="material-symbols-outlined">download</span></span><b><?php esc_html_e('เอกสารดาวน์โหลด', 'tea-theme'); ?></b></a>
      <a href="<?php echo esc_url(home_url('/contact/')); ?>"><span class="ic"><span class="material-symbols-outlined">forum</span></span><b><?php esc_html_e('ติดต่อสมาคม', 'tea-theme'); ?></b></a>
    </div>
  </div>

  <!-- ============ สารนายกสมาคม ============ -->
  <section class="pea-president" id="president">
    <div class="pea-shell">
      <div class="pea-sec-head row">
        <h2><?php esc_html_e('สารนายกสมาคม', 'tea-theme'); ?></h2>
      </div>
      <div class="pea-pres-grid">
        <article class="pea-pres-card">
          <div class="pea-pres-photo">
            <?php if (file_exists(get_template_directory() . '/assets/person-chinalai-piyachon.jpg')) : ?>
            <img src="<?php echo $img('person-chinalai-piyachon.jpg'); ?>" alt="<?php esc_attr_e('ภาพถ่ายนายกสมาคมเอ็นโดดอนติกส์ไทย', 'tea-theme'); ?>" width="486" height="487">
            <?php else : ?>
            <div class="ph"><span class="material-symbols-outlined">person</span></div>
            <?php endif; ?>
          </div>
          <div class="pea-pres-body">
            <span class="role"><?php esc_html_e('นายกสมาคมเอ็นโดดอนติกส์ไทย', 'tea-theme'); ?></span>
            <h3><?php esc_html_e('ผศ.ทพญ.ชินาลัย ปิยะชน', 'tea-theme'); ?></h3>
            <p class="sub"><?php esc_html_e('วาระบริหารสมาคม พ.ศ. 2569–2570', 'tea-theme'); ?></p>
            <p><?php esc_html_e('ยินดีต้อนรับสู่เว็บไซต์สมาคมเอ็นโดดอนติกส์ไทย ศูนย์รวมข้อมูลวิชาการ ข่าวกิจกรรม และบริการของสมาคม สำหรับทันตแพทย์ นักวิชาการ และประชาชนที่สนใจวิชาชีพเอ็นโดดอนต์ทุกท่าน', 'tea-theme'); ?></p>
            <blockquote><?php esc_html_e('สมาคมฯ มุ่งขับเคลื่อนมาตรฐานวิชาเอ็นโดดอนต์ไทย สู่ความเป็นเลิศทางคลินิก ส่งเสริมงานวิจัยและวารสารไทย พร้อมพัฒนาทันตแพทย์รุ่นใหม่อย่างยั่งยืน', 'tea-theme'); ?></blockquote>
            <p><?php esc_html_e('ในวาระนี้ สมาคมฯ จะขยายโอกาสการศึกษาต่อเนื่องผ่านการประชุมวิชาการและอบรมเชิงปฏิบัติการ สนับสนุนทุนวิจัยและการตีพิมพ์ในวารสาร Thai Endodontic Journal รวมถึงเชื่อมโยงเครือข่ายวิชาชีพระดับนานาชาติผ่าน IFEA', 'tea-theme'); ?></p>
          </div>
        </article>
      </div>
      <aside class="pea-pres-side">
          <?php $committee_members = require get_template_directory() . '/parts/committee-data.php'; $committee_en = function_exists('pll_current_language') && pll_current_language() === 'en'; ?>
          <section class="pea-committee-strip" aria-label="<?php esc_attr_e('คณะกรรมการสมาคม', 'tea-theme'); ?>">
            <div class="pea-committee-strip-head"><span><?php echo esc_html($committee_en ? 'Association Committee' : __('คณะกรรมการสมาคม', 'tea-theme')); ?></span><a href="<?php echo esc_url(home_url($committee_en ? '/committee-en/' : '/committee/')); ?>"><?php esc_html_e('ดูทั้งหมด', 'tea-theme'); ?> <span class="material-symbols-outlined">arrow_forward</span></a></div>
            <div class="pea-committee-viewport">
              <div class="pea-committee-track">
                <?php foreach (array_merge($committee_members, $committee_members) as $index => $member) : ?>
                <article class="pea-committee-member"<?php echo $index >= count($committee_members) ? ' aria-hidden="true"' : ''; ?>>
                  <img src="<?php echo esc_url($img($member['image'])); ?>" alt="<?php echo $index >= count($committee_members) ? '' : esc_attr($committee_en ? $member['name_en'] : $member['name']); ?>" width="96" height="120" loading="lazy">
                  <div><b><?php echo esc_html($committee_en ? $member['name_en'] : $member['name']); ?></b><span><?php echo esc_html($committee_en ? $member['role_en'] : $member['role_th']); ?></span></div>
                </article>
                <?php endforeach; ?>
              </div>
            </div>
          </section>
      </aside>
    </div>
  </section>

  <!-- ============ บริการแบบแท็บ (แบบ กฟภ.: "ให้เราดูแลทุกความต้องการ") ============ -->
  <section class="pea-services">
    <div class="pea-shell">
      <div class="pea-sec-head"><h2><?php esc_html_e('ให้สมาคมฯ ดูแลทุกความต้องการทางวิชาการของคุณ', 'tea-theme'); ?></h2></div>
      <div class="pea-tabs" role="tablist">
        <button class="is-active" data-tab="pro" role="tab"><span class="material-symbols-outlined">medical_information</span><?php esc_html_e('สำหรับทันตแพทย์', 'tea-theme'); ?></button>
        <button data-tab="events" role="tab"><span class="material-symbols-outlined">school</span><?php esc_html_e('ประชุมและอบรม', 'tea-theme'); ?></button>
        <button data-tab="research" role="tab"><span class="material-symbols-outlined">biotech</span><?php esc_html_e('วิจัยและวารสาร', 'tea-theme'); ?></button>
        <button data-tab="public" role="tab"><span class="material-symbols-outlined">family_restroom</span><?php esc_html_e('สำหรับประชาชน', 'tea-theme'); ?></button>
      </div>

      <div class="pea-panel is-active" data-panel="pro">
        <a class="pea-sv" href="https://www.thaiendodontics.com/cert" target="_blank" rel="noreferrer"><span class="ic"><span class="material-symbols-outlined">verified</span></span><div><b><?php esc_html_e('ตรวจสอบใบประกาศ CDEC', 'tea-theme'); ?></b><small><?php esc_html_e('ตรวจสอบผลการอบรมหลักสูตรเพิ่มพูนทักษะ', 'tea-theme'); ?></small></div><span class="material-symbols-outlined arr">arrow_forward</span></a>
        <a class="pea-sv" href="<?php echo esc_url(get_post_type_archive_link('research_fund')); ?>"><span class="ic"><span class="material-symbols-outlined">science</span></span><div><b><?php esc_html_e('ทุนอุดหนุนการวิจัย', 'tea-theme'); ?></b><small><?php esc_html_e('เปิดรับ 1 ก.ย. – 31 ต.ค. 2569 · ประกาศผล 1 ธ.ค. 2569', 'tea-theme'); ?></small></div><span class="material-symbols-outlined arr">arrow_forward</span></a>
        <a class="pea-sv" href="<?php echo esc_url(get_post_type_archive_link('journal')); ?>"><span class="ic"><span class="material-symbols-outlined">rate_review</span></span><div><b><?php esc_html_e('วารสาร TEJ', 'tea-theme'); ?></b><small><?php esc_html_e('เปิดอ่านบทความและเอกสารของสมาคม', 'tea-theme'); ?></small></div><span class="material-symbols-outlined arr">arrow_forward</span></a>
        <a class="pea-sv" href="<?php echo esc_url(get_post_type_archive_link('document')); ?>"><span class="ic"><span class="material-symbols-outlined">download</span></span><div><b><?php esc_html_e('เอกสารและแบบฟอร์มสมาคม', 'tea-theme'); ?></b><small><?php esc_html_e('ระเบียบ หลักเกณฑ์ ใบสมัคร ดาวน์โหลด PDF', 'tea-theme'); ?></small></div><span class="material-symbols-outlined arr">arrow_forward</span></a>
      </div>

      <div class="pea-panel" data-panel="events">
        <?php if ($evt_q->have_posts()) : while ($evt_q->have_posts()) : $evt_q->the_post();
          $ed = get_post_meta(get_the_ID(), '_tea_event_date', true);
          $th = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') : $img('poster-annual-2568.jpg'); ?>
        <a class="pea-evt" href="<?php the_permalink(); ?>">
          <img src="<?php echo esc_url($th); ?>" alt="">
          <div><span class="chip"><span class="material-symbols-outlined">event</span> <?php echo esc_html($ed ? tea_thai_date($ed) : tea_thai_date(get_post_field('post_date'))); ?></span><b><?php the_title(); ?></b></div>
        </a>
        <?php endwhile; wp_reset_postdata(); endif; ?>
      </div>

      <div class="pea-panel" data-panel="research">
        <a class="pea-sv" href="<?php echo esc_url(get_post_type_archive_link('journal')); ?>"><span class="ic"><span class="material-symbols-outlined">auto_stories</span></span><div><b>Thai Endodontic Journal</b><small><?php esc_html_e('เปิดอ่านบทความฉบับปัจจุบันจากคลังสมาคม', 'tea-theme'); ?></small></div><span class="material-symbols-outlined arr">arrow_forward</span></a>
        <a class="pea-sv" href="<?php echo esc_url(get_post_type_archive_link('research_fund')); ?>"><span class="ic"><span class="material-symbols-outlined">science</span></span><div><b><?php esc_html_e('ข้อเสนอโครงการทุนวิจัย 2569', 'tea-theme'); ?></b><small><?php esc_html_e('แนวปฏิบัติและรูปแบบเอกสารสำหรับนักวิจัย', 'tea-theme'); ?></small></div><span class="material-symbols-outlined arr">arrow_forward</span></a>
        <a class="pea-sv" href="<?php echo esc_url(get_post_type_archive_link('document')); ?>"><span class="ic"><span class="material-symbols-outlined">workspace_premium</span></span><div><b><?php esc_html_e('เกณฑ์สนับสนุนบทความวิชาการ', 'tea-theme'); ?></b><small><?php esc_html_e('หลักเกณฑ์การให้เงินสนับสนุนการตีพิมพ์', 'tea-theme'); ?></small></div><span class="material-symbols-outlined arr">arrow_forward</span></a>
        <a class="pea-sv" href="<?php echo esc_url(get_post_type_archive_link('journal')); ?>"><span class="ic"><span class="material-symbols-outlined">newspaper</span></span><div><b><?php esc_html_e('ประกาศวารสารทั้งหมด', 'tea-theme'); ?></b><small><?php esc_html_e('เชิญชวนเขียนบทความและเว็บบินาร์ TEJ', 'tea-theme'); ?></small></div><span class="material-symbols-outlined arr">arrow_forward</span></a>
      </div>

      <div class="pea-panel" data-panel="public">
        <a class="pea-sv" href="<?php echo esc_url(home_url('/about/')); ?>"><span class="ic"><span class="material-symbols-outlined">health_and_safety</span></span><div><b><?php esc_html_e('รู้จักวิชาเอ็นโดดอนต์', 'tea-theme'); ?></b><small><?php esc_html_e('การรักษารากฟันโดยทันตแพทย์เฉพาะทาง', 'tea-theme'); ?></small></div><span class="material-symbols-outlined arr">arrow_forward</span></a>
        <a class="pea-sv" href="<?php echo esc_url(home_url('/contact/')); ?>"><span class="ic"><span class="material-symbols-outlined">person_search</span></span><div><b><?php esc_html_e('สอบถามและติดต่อทันตแพทย์เฉพาะทาง', 'tea-theme'); ?></b><small><?php esc_html_e('ศูนย์ประสานงานสมาคม 02-218-8795', 'tea-theme'); ?></small></div><span class="material-symbols-outlined arr">arrow_forward</span></a>
        <a class="pea-sv" href="<?php echo esc_url(get_post_type_archive_link('news')); ?>"><span class="ic"><span class="material-symbols-outlined">campaign</span></span><div><b><?php esc_html_e('ข่าวกิจกรรมของสมาคม', 'tea-theme'); ?></b><small><?php esc_html_e('ติดตามงานประชุมและโครงการใหม่ล่าสุด', 'tea-theme'); ?></small></div><span class="material-symbols-outlined arr">arrow_forward</span></a>
        <a class="pea-sv" href="https://www.facebook.com/Thaiendodontics/" target="_blank" rel="noreferrer"><span class="ic"><span class="material-symbols-outlined">thumb_up</span></span><div><b><?php esc_html_e('ติดตามเพจเฟซบุ๊กสมาคม', 'tea-theme'); ?></b><small>fb.com/Thaiendodontics</small></div><span class="material-symbols-outlined arr">arrow_forward</span></a>
      </div>
    </div>
  </section>

  <!-- ============ ข่าว 2 คอลัมน์ (แบบ กฟภ.: ข่าวเด่น+รายการ | ประกาศ+นับถอยหลัง) ============ -->
  <section class="pea-newsband">
    <div class="pea-shell">
      <div class="pea-news-left">
        <div class="pea-sec-head row">
          <h2><?php esc_html_e('ข่าวสารและกิจกรรม', 'tea-theme'); ?></h2>
          <a class="pea-more" href="<?php echo esc_url(get_post_type_archive_link('news')); ?>"><?php esc_html_e('ดูข่าวทั้งหมด', 'tea-theme'); ?> <span class="material-symbols-outlined">arrow_forward</span></a>
        </div>
        <?php if ($news_q->have_posts()) : $n = 0; while ($news_q->have_posts()) : $news_q->the_post(); $n++;
          $pto = get_post_type_object(get_post_type());
          $cat = tea_cpt_label(get_post_type(), $pto ? $pto->labels->singular_name : '');
          $th = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') : $img('poster-annual-2568.jpg');
          if ($n === 1) : ?>
        <a class="pea-feat" href="<?php the_permalink(); ?>">
          <img src="<?php echo esc_url($th); ?>" alt="">
          <div><span class="chip"><?php echo esc_html($cat); ?></span><b><?php the_title(); ?></b><time><?php tea_the_date(); ?></time></div>
        </a>
          <?php else : ?>
        <a class="pea-row" href="<?php the_permalink(); ?>">
          <span class="chip"><?php echo esc_html($cat); ?></span>
          <b><?php the_title(); ?></b>
          <time><?php tea_the_date(); ?></time>
        </a>
          <?php endif;
        endwhile; wp_reset_postdata(); endif; ?>

        <div class="pea-news-library">
          <div class="pea-news-library-copy">
            <span class="material-symbols-outlined" aria-hidden="true">auto_stories</span>
            <span>
              <b><?php esc_html_e('คลังข่าวและประกาศของสมาคม', 'tea-theme'); ?></b>
              <small><?php esc_html_e('รวมข่าวประชาสัมพันธ์ กิจกรรม และข้อมูลสำคัญย้อนหลัง', 'tea-theme'); ?></small>
            </span>
          </div>
          <a class="pea-news-library-primary" href="<?php echo esc_url(get_post_type_archive_link('news')); ?>"><?php esc_html_e('เปิดคลังข่าว', 'tea-theme'); ?> <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></a>
          <div class="pea-news-library-tools" aria-label="<?php esc_attr_e('ทางลัดคลังข่าว', 'tea-theme'); ?>">
            <a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>"><span class="material-symbols-outlined" aria-hidden="true">campaign</span><?php esc_html_e('ข่าวประชาสัมพันธ์', 'tea-theme'); ?></a>
            <a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>"><span class="material-symbols-outlined" aria-hidden="true">notifications</span><?php esc_html_e('ประกาศสำคัญ', 'tea-theme'); ?></a>
            <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>"><span class="material-symbols-outlined" aria-hidden="true">event</span><?php esc_html_e('กิจกรรม', 'tea-theme'); ?></a>
          </div>
        </div>

      </div>

      <aside class="pea-news-side">
        <div class="pea-fb-widget">
          <div class="fb-head">
            <span class="t"><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.2h2.5l.4-2.9h-2.9V9.1c0-.8.2-1.4 1.4-1.4h1.6V5.1c-.3 0-1.2-.1-2.2-.1-2.2 0-3.7 1.3-3.7 3.8v2.1H8v2.9h2.6V21h2.9z"/></svg> Thaiendodontics</span>
            <a href="https://www.facebook.com/Thaiendodontics/" target="_blank" rel="noreferrer"><?php esc_html_e('เปิดเพจ', 'tea-theme'); ?> <span class="material-symbols-outlined">open_in_new</span></a>
          </div>
          <div class="pea-fb-frame">
            <a class="pea-fb-card" href="https://www.facebook.com/Thaiendodontics/" target="_blank" rel="noreferrer">
              <img src="<?php echo $img('fb-meeting1.jpg'); ?>" alt="<?php esc_attr_e('Thaiendodontics บน Facebook', 'tea-theme'); ?>">
              <span class="pea-fb-card-copy">
                <b><?php esc_html_e('ติดตามข่าวล่าสุดจากสมาคม', 'tea-theme'); ?></b>
                <small><?php esc_html_e('ประกาศ กิจกรรม และภาพจากเวทีวิชาการ อัปเดตผ่าน Facebook ทางการ', 'tea-theme'); ?></small>
                <em><span class="material-symbols-outlined">open_in_new</span> Facebook / Thaiendodontics</em>
              </span>
            </a>
          </div>
        </div>
        <div class="pea-count-card">
        <span class="k"><span class="material-symbols-outlined">hourglass_top</span> <?php esc_html_e('นับถอยหลังสู่งานประชุมประจำปี', 'tea-theme'); ?></span>
        <div class="pea-count" data-target="<?php echo esc_attr($event_date_str); ?>">
          <div><b>–</b><small><?php esc_html_e('วัน', 'tea-theme'); ?></small></div>
          <div><b>–</b><small><?php esc_html_e('ชม.', 'tea-theme'); ?></small></div>
          <div><b>–</b><small><?php esc_html_e('นาที', 'tea-theme'); ?></small></div>
          <div><b>–</b><small><?php esc_html_e('วินาที', 'tea-theme'); ?></small></div>
        </div>
        <a class="pea-btn pea-btn-accent sm" href="<?php echo esc_url(get_post_type_archive_link('event')); ?>"><span class="material-symbols-outlined">how_to_reg</span><?php esc_html_e('ดูรายละเอียดงานประชุม', 'tea-theme'); ?></a>
        </div>
        <?php if ($upcoming_q->have_posts()) : ?>
        <section class="pea-upcoming-events" aria-label="<?php esc_attr_e('กิจกรรมที่กำลังจะมาถึง', 'tea-theme'); ?>">
          <div class="pea-upcoming-head"><span class="material-symbols-outlined">event_upcoming</span><b><?php esc_html_e('กิจกรรมที่กำลังจะมาถึง', 'tea-theme'); ?></b><a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>"><?php esc_html_e('ทั้งหมด', 'tea-theme'); ?></a></div>
          <?php while ($upcoming_q->have_posts()) : $upcoming_q->the_post(); ?>
          <a class="pea-upcoming-item" href="<?php the_permalink(); ?>"><time><?php tea_the_date(); ?></time><b><?php the_title(); ?></b><span class="material-symbols-outlined">arrow_forward</span></a>
          <?php endwhile; wp_reset_postdata(); ?>
        </section>
        <?php endif; ?>
      </aside>
    </div>
  </section>

  <!-- ============ วารสาร: TEJ ปัจจุบัน + คลัง Endosarn ============ -->
  <section class="pea-journal-home">
    <div class="pea-shell">
      <div class="pea-sec-head row"><div><span class="pea-kicker">PUBLICATIONS</span><h2><?php esc_html_e('วารสารของสมาคม', 'tea-theme'); ?></h2></div><a class="pea-more" href="<?php echo esc_url(get_post_type_archive_link('journal')); ?>"><?php esc_html_e('ดูวารสารทั้งหมด', 'tea-theme'); ?> <span class="material-symbols-outlined">arrow_forward</span></a></div>
      <div class="pea-journal-library" aria-label="<?php esc_attr_e('บทความ Thai Endodontic Journal ฉบับปัจจุบัน', 'tea-theme'); ?>">
        <div class="pea-journal-intro">
          <span class="pea-library-tag"><span class="material-symbols-outlined">menu_book</span> E-JOURNAL</span>
          <h3><?php esc_html_e('Thai Endodontic Journal', 'tea-theme'); ?></h3>
          <p><?php esc_html_e('แหล่งความรู้ด้านเอ็นโดดอนติกส์สำหรับทันตแพทย์ไทย รวบรวมงานวิจัย บทความวิชาการ และกรณีศึกษาจากผู้เชี่ยวชาญ เพื่อพัฒนางานรักษาคลองรากฟันอย่างต่อเนื่อง', 'tea-theme'); ?></p>
          <a class="pea-library-cta" href="<?php echo esc_url(get_post_type_archive_link('journal')); ?>"><span class="material-symbols-outlined">collections_bookmark</span><?php esc_html_e('เปิดคลังวารสาร', 'tea-theme'); ?></a>
        </div>
        <?php $home_journal_q = new WP_Query(['post_type' => 'journal', 'lang' => '', 'posts_per_page' => 8, 'meta_key' => '_tea_library_import', 'orderby' => 'menu_order', 'order' => 'DESC', 'no_found_rows' => true]); ?>
        <div class="pea-pdf-carousel" data-journal-carousel>
          <button class="pea-pdf-scroll prev" type="button" data-journal-scroll="prev" aria-label="<?php esc_attr_e('เลื่อนดูบทความก่อนหน้า', 'tea-theme'); ?>"><span class="material-symbols-outlined" aria-hidden="true">chevron_left</span></button>
          <div class="pea-pdf-shelf" data-journal-shelf>
          <?php if ($home_journal_q->have_posts()) : while ($home_journal_q->have_posts()) : $home_journal_q->the_post();
            $file = get_post_meta(get_the_ID(), '_tea_pdf_url', true);
            $preview = get_post_meta(get_the_ID(), '_tea_preview_url', true);
            $issue = get_post_meta(get_the_ID(), '_tea_issue_label', true);
            $file_url = $file ? home_url($file) : get_permalink(); ?>
          <a class="pea-pdf-issue" href="<?php echo esc_url($file_url); ?>" target="_blank" rel="noreferrer">
            <div class="pea-pdf-page"><?php if ($preview) : ?><img src="<?php echo esc_url(home_url($preview)); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy"><?php endif; ?></div>
            <h3><?php the_title(); ?></h3><span><span class="material-symbols-outlined">picture_as_pdf</span><?php echo esc_html($issue ?: 'PDF'); ?></span>
          </a>
          <?php endwhile; wp_reset_postdata(); endif; ?>
          </div>
          <button class="pea-pdf-scroll next" type="button" data-journal-scroll="next" aria-label="<?php esc_attr_e('เลื่อนดูบทความถัดไป', 'tea-theme'); ?>"><span class="material-symbols-outlined" aria-hidden="true">chevron_right</span></button>
        </div>
      </div>
    </div>
  </section>

  <script>
  document.querySelectorAll('[data-journal-carousel]').forEach(function (carousel) {
    var shelf = carousel.querySelector('[data-journal-shelf]');
    carousel.querySelectorAll('[data-journal-scroll]').forEach(function (button) {
      button.addEventListener('click', function () {
        shelf.scrollBy({ left: (button.dataset.journalScroll === 'next' ? 1 : -1) * Math.max(240, shelf.clientWidth * .82), behavior: 'smooth' });
      });
    });
  });
  </script>

  <!-- ============ ประกาศ ============ -->
  <section class="pea-announcements-home">
    <div class="pea-shell">
      <div class="pea-sec-head row"><div><span class="pea-kicker">NEWS UPDATE</span><h2><?php esc_html_e('ข่าวสารและทุนสนับสนุน', 'tea-theme'); ?></h2></div><?php $al = get_post_type_archive_link('news'); if ($al) : ?><a class="pea-more" href="<?php echo esc_url($al); ?>"><?php esc_html_e('ดูทั้งหมด', 'tea-theme'); ?> <span class="material-symbols-outlined">arrow_forward</span></a><?php endif; ?></div>
      <div class="pea-announcement-grid">
      <?php if ($ann_q->have_posts()) : $announcement_count = 0; while ($ann_q->have_posts() && $announcement_count < 3) : $ann_q->the_post(); $announcement_count++; ?>
        <a class="pea-announcement-card" href="<?php the_permalink(); ?>"><span class="material-symbols-outlined">campaign</span><div><small><?php tea_the_date(); ?></small><b><?php the_title(); ?></b></div><span class="material-symbols-outlined arrow">arrow_forward</span></a>
      <?php endwhile; wp_reset_postdata(); endif; ?>
      </div>
    </div>
  </section>

  <!-- ============ ภาพกิจกรรม ============ -->
  <?php if ($tea_reels) : ?>
  <section class="pea-reels-home" aria-label="<?php esc_attr_e('คลิปกิจกรรมจาก Facebook สมาคม', 'tea-theme'); ?>">
    <div class="pea-shell">
      <div class="pea-sec-head row"><div><span class="pea-kicker">FACEBOOK REELS</span><h2><?php esc_html_e('คลิปกิจกรรมของสมาคม', 'tea-theme'); ?></h2></div><a class="pea-more" href="https://www.facebook.com/Thaiendodontics/" target="_blank" rel="noreferrer"><?php esc_html_e('ดูทั้งหมดบน Facebook', 'tea-theme'); ?> <span class="material-symbols-outlined">open_in_new</span></a></div>
      <div class="pea-reels-rail" role="list">
        <?php foreach ($tea_reels as $reel) :
          $embed = 'https://www.facebook.com/plugins/video.php?href=' . rawurlencode($reel['url']) . '&show_text=false&width=500';
        ?>
        <article class="pea-reel-card" role="listitem">
          <div class="pea-reel-frame <?php echo (!empty($reel['orientation']) && $reel['orientation'] === 'landscape') ? 'is-landscape' : 'is-portrait'; ?>"><iframe src="<?php echo esc_url($embed); ?>" title="<?php echo esc_attr($reel['caption'] ?: __('คลิปกิจกรรมจาก Facebook สมาคม', 'tea-theme')); ?>" loading="lazy" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowfullscreen></iframe></div>
          <?php if (!empty($reel['caption'])) : ?><h3><?php echo esc_html($reel['caption']); ?></h3><?php endif; ?>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>
  <section class="pea-gallery-home">
    <div class="pea-shell">
      <div class="pea-sec-head row"><div><span class="pea-kicker">ACTIVITY HIGHLIGHTS</span><h2><?php esc_html_e('ภาพกิจกรรมของสมาคม', 'tea-theme'); ?></h2></div><a class="pea-more" href="https://www.facebook.com/Thaiendodontics/" target="_blank" rel="noreferrer"><?php esc_html_e('ดูภาพเพิ่มเติม', 'tea-theme'); ?> <span class="material-symbols-outlined">open_in_new</span></a></div>
      <div class="pea-gallery-grid">
        <?php if ($sheet_gallery) : foreach ($sheet_gallery as $item) :
          $is_en = function_exists('pll_current_language') && pll_current_language() === 'en';
          $caption = ($is_en && !empty($item['คำบรรยายอังกฤษ'])) ? $item['คำบรรยายอังกฤษ'] : ($item['คำบรรยายไทย'] ?? '');
        ?>
        <a href="<?php echo esc_url($item['ลิงก์'] ?? get_post_type_archive_link('event')); ?>"><img src="<?php echo esc_url($item['รูป URL'] ?? ''); ?>" alt="<?php echo esc_attr($caption); ?>" loading="lazy"><span><?php echo esc_html($caption); ?></span></a>
        <?php endforeach; else : ?>
        <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>"><img src="<?php echo $img('fb-meeting1.jpg'); ?>" alt="<?php esc_attr_e('กิจกรรมสมาคมเอ็นโดดอนติกส์ไทย', 'tea-theme'); ?>" width="900" height="570" loading="lazy"><span><?php esc_html_e('การประชุมวิชาการประจำปี', 'tea-theme'); ?></span></a>
        <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>"><img src="<?php echo $img('fb-meeting2.jpg'); ?>" alt="<?php esc_attr_e('กิจกรรมสมาคมเอ็นโดดอนติกส์ไทย', 'tea-theme'); ?>" width="900" height="570" loading="lazy"><span><?php esc_html_e('เวทีวิชาการและเครือข่ายนานาชาติ', 'tea-theme'); ?></span></a>
        <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>"><img src="<?php echo $img('event-dental-trauma-nov-2026.png'); ?>" alt="<?php esc_attr_e('งานประชุม Dental Trauma and Root Resorption', 'tea-theme'); ?>" width="1536" height="864" loading="lazy"><span>Dental Trauma and Root Resorption</span></a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ============ แถบร่วมเครือข่าย ============ -->
  <section class="pea-cta">
    <div class="pea-shell">
      <div>
        <h2><?php esc_html_e('เข้าร่วมเครือข่ายวิชาชีพเอ็นโดดอนต์ไทย', 'tea-theme'); ?></h2>
        <p><?php esc_html_e('รับข่าวสารวิชาการ สิทธิ์เข้าร่วมอบรม CDEC และลิงก์แหล่งข้อมูลทางวิชาชีพจากสมาคม', 'tea-theme'); ?></p>
      </div>
      <div class="pea-cta-btns">
        <a class="pea-btn pea-btn-accent" href="<?php echo esc_url(home_url('/contact/')); ?>"><span class="material-symbols-outlined">how_to_reg</span><?php esc_html_e('สมัครสมาชิกเครือข่าย', 'tea-theme'); ?></a>
        <a class="pea-btn pea-btn-ghost" href="<?php echo esc_url(home_url('/contact/')); ?>"><span class="material-symbols-outlined">forum</span><?php esc_html_e('ติดต่อสมาคม', 'tea-theme'); ?></a>
      </div>
    </div>
  </section>

  <!-- ============ องค์กรเครือข่าย ============ -->
  <section class="pea-partners">
    <div class="pea-shell">
      <section class="pea-partner-panel" aria-label="Affiliations">
        <header class="pea-partner-panel-head"><span class="pea-kicker">Affiliations</span></header>
        <div class="pea-partner-viewport">
          <div class="pea-partner-row">
          <?php for ($partner_run = 0; $partner_run < 2; $partner_run++) : ?>
          <a href="https://ifea.info/" target="_blank" rel="noreferrer"<?php echo $partner_run ? ' aria-hidden="true" tabindex="-1"' : ''; ?>><img src="https://www.ifea2026sydney.com/wp-content/uploads/IFEA-NEW-LOGO-1-1.png" alt="" width="210" height="82" loading="eager"><span><b>IFEA</b><small>International Federation of Endodontic Associations</small></span></a>
          <a href="https://he03.tci-thaijo.org/index.php/thaiendod" target="_blank" rel="noreferrer"<?php echo $partner_run ? ' aria-hidden="true" tabindex="-1"' : ''; ?>><img src="https://so02.tci-thaijo.org/public/site/images/admin_jmsr/thai-journals-online.png" alt="" width="210" height="82" loading="eager"><span><b>ThaiJO</b><small>Thai Journal Online</small></span></a>
          <span class="is-plain"<?php echo $partner_run ? ' aria-hidden="true"' : ''; ?>><img src="https://ph04.tci-thaijo.org/public/site/images/journal/tci-e1d356c21d53429390ca5f0a490b4d85.png" alt="" width="210" height="82" loading="eager"><span><b>TCI Tier 2</b><small>Thai-Journal Citation Index</small></span></span>
          <a href="https://dentalcouncil.or.th/" target="_blank" rel="noreferrer"<?php echo $partner_run ? ' aria-hidden="true" tabindex="-1"' : ''; ?>><img src="https://dentalcouncil.or.th/assets/images/logo/LOGO-TDC-NEW.png" alt="" width="210" height="82" loading="eager"><span><b>Dental Council</b><small>The Dental Council of Thailand</small></span></a>
          <a href="https://www.dent.chula.ac.th/" target="_blank" rel="noreferrer"<?php echo $partner_run ? ' aria-hidden="true" tabindex="-1"' : ''; ?>><img src="https://www.dent.chula.ac.th/wp-content/uploads/2022/06/logo-dent-chula-color.png" alt="" width="210" height="82" loading="eager"><span><b>Faculty of Dentistry</b><small>Chulalongkorn University</small></span></a>
          <?php endfor; ?>
          </div>
        </div>
      </section>
    </div>
  </section>

</div><!-- /.pea -->

<script>
(function () {
  /* ---------- Hero slider ---------- */
  var track = document.getElementById('pea-track');
  if (track) {
    var slides = track.querySelectorAll('.pea-slide');
    var dotsBox = document.getElementById('pea-dots');
    var idx = 0, timer;
    slides.forEach(function (_, i) {
      var d = document.createElement('button');
      d.type = 'button';
      d.setAttribute('aria-label', 'slide ' + (i + 1));
      if (i === 0) d.className = 'is-active';
      d.addEventListener('click', function () { go(i, true); });
      dotsBox.appendChild(d);
    });
    var dots = dotsBox.querySelectorAll('button');
    function render() {
      slides.forEach(function (s, i) { s.classList.toggle('is-active', i === idx); });
      dots.forEach(function (d, i) { d.classList.toggle('is-active', i === idx); });
    }
    function go(i, manual) {
      idx = (i + slides.length) % slides.length;
      render();
      if (manual) restart();
    }
    function restart() { clearInterval(timer); timer = setInterval(function () { go(idx + 1); }, 6500); }
    document.getElementById('pea-prev').addEventListener('click', function () { go(idx - 1, true); });
    document.getElementById('pea-next').addEventListener('click', function () { go(idx + 1, true); });
    track.addEventListener('mouseenter', function () { clearInterval(timer); });
    track.addEventListener('mouseleave', restart);
    restart();
  }

  /* ---------- Tabs ---------- */
  document.querySelectorAll('.pea-tabs button').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var key = btn.dataset.tab;
      document.querySelectorAll('.pea-tabs button').forEach(function (b) { b.classList.toggle('is-active', b === btn); });
      document.querySelectorAll('.pea-panel').forEach(function (p) { p.classList.toggle('is-active', p.dataset.panel === key); });
    });
  });

  /* ---------- Countdown ---------- */
  var el = document.querySelector('.pea-count');
  if (el) {
    var target = new Date(el.getAttribute('data-target')).getTime();
    var boxes = el.querySelectorAll('b');
    function pad(n) { return String(Math.max(0, n)).padStart(2, '0'); }
    function tick() {
      var diff = target - Date.now();
      var d = Math.floor(diff / 86400000);
      var h = Math.floor(diff % 86400000 / 3600000);
      var m = Math.floor(diff % 3600000 / 60000);
      var s = Math.floor(diff % 60000 / 1000);
      if (boxes[0]) boxes[0].textContent = d;
      if (boxes[1]) boxes[1].textContent = pad(h);
      if (boxes[2]) boxes[2].textContent = pad(m);
      if (boxes[3]) boxes[3].textContent = pad(s);
    }
    tick();
    setInterval(tick, 1000);
  }
})();
</script>

<?php get_footer();
