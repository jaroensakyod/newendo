<?php
if (!defined('ABSPATH')) exit;
get_header();
$is_en = function_exists('pll_current_language') && pll_current_language() === 'en';
$asset = get_template_directory_uri() . '/assets/';
$committee_url = $is_en ? home_url('/en/committee-en/') : home_url('/committee/');
?>
<?php while (have_posts()) : the_post(); ?>
<section class="about-hero">
  <div class="shell about-hero-inner">
    <div>
      <div class="about-heading-meta"><span class="about-kicker"><span class="material-symbols-outlined" aria-hidden="true">grid_view</span> ABOUT THE ASSOCIATION</span></div>
      <h1><?php echo esc_html($is_en ? 'Thai Endodontic Association' : 'สมาคมเอ็นโดดอนติกส์ไทย'); ?></h1>
      <p><?php echo esc_html($is_en ? 'A professional home advancing the science, standards and community of endodontics in Thailand.' : 'องค์กรวิชาชีพที่ขับเคลื่อนมาตรฐานองค์ความรู้ และเครือข่ายทันตกรรมรากฟันของประเทศไทย'); ?></p>
    </div>
    <div class="about-hero-mark" aria-hidden="true"><img src="<?php echo esc_url($asset . 'logo-mark.svg'); ?>" alt=""><i></i><b>THAI ENDODONTIC ASSOCIATION</b></div>
  </div>
</section>

<main class="about-page">
  <div class="shell">
    <section class="about-intro-grid">
      <div class="about-intro-copy">
        <span class="about-kicker warm"><?php echo esc_html($is_en ? 'OUR PURPOSE' : 'พันธกิจของเรา'); ?></span>
        <h2><?php echo esc_html($is_en ? 'Advancing endodontics with care, evidence and connection.' : 'ยกระดับวิชาเอ็นโดดอนติกส์ ด้วยความรู้ มาตรฐาน และเครือข่าย'); ?></h2>
        <p><?php echo esc_html($is_en ? 'The Thai Endodontic Association supports the advancement of root canal treatment through continuing education, academic exchange, research support and the Thai Endodontic Journal.' : 'สมาคมเอ็นโดดอนติกส์ไทยส่งเสริมความก้าวหน้าของทันตกรรมรากฟัน ผ่านการศึกษาต่อเนื่อง การแลกเปลี่ยนวิชาการ การสนับสนุนงานวิจัย และวารสาร Thai Endodontic Journal'); ?></p>
        <div class="about-statement"><strong><?php echo esc_html($is_en ? 'To foster trusted standards of care and a strong professional community for endodontics in Thailand.' : 'มุ่งสร้างมาตรฐานการดูแลรักษาที่น่าเชื่อถือ และชุมชนวิชาชีพเอ็นโดดอนติกส์ที่เข้มแข็งของประเทศไทย'); ?></strong></div>
      </div>
      <div class="about-pillar-grid">
        <article><span class="material-symbols-outlined" aria-hidden="true">school</span><h3><?php echo esc_html($is_en ? 'Learning' : 'การเรียนรู้'); ?></h3><p><?php echo esc_html($is_en ? 'Continuing education and academic activities for dentists.' : 'การศึกษาต่อเนื่องและกิจกรรมวิชาการสำหรับทันตแพทย์'); ?></p></article>
        <article><span class="material-symbols-outlined" aria-hidden="true">biotech</span><h3><?php echo esc_html($is_en ? 'Research' : 'งานวิจัย'); ?></h3><p><?php echo esc_html($is_en ? 'Research support and knowledge exchange for the profession.' : 'สนับสนุนงานวิจัยและการแลกเปลี่ยนองค์ความรู้ในวิชาชีพ'); ?></p></article>
        <article><span class="material-symbols-outlined" aria-hidden="true">groups</span><h3><?php echo esc_html($is_en ? 'Community' : 'เครือข่าย'); ?></h3><p><?php echo esc_html($is_en ? 'A connected community of endodontic professionals.' : 'เครือข่ายของผู้เชี่ยวชาญและผู้สนใจด้านเอ็นโดดอนติกส์'); ?></p></article>
      </div>
    </section>

    <section class="about-history" aria-labelledby="about-history-title">
      <div class="about-history-heading"><span class="about-kicker warm"><?php echo esc_html($is_en ? 'OUR HISTORY' : 'ประวัติความเป็นมา'); ?></span><h2 id="about-history-title"><?php echo esc_html($is_en ? 'A professional community rooted in excellence.' : 'สมาคมเอ็นโดดอนติกส์ไทย: รากฐานแห่งความเป็นเลิศ'); ?></h2><p><?php echo esc_html($is_en ? 'The Thai Endodontic Association was established in 1994, evolving from the Endodontic Club of Thailand, to advance knowledge and innovation in endodontics and root canal treatment in Thailand.' : 'สมาคมเอ็นโดดอนติกส์ไทย (Thai Endodontic Association) ก่อตั้งขึ้นเมื่อปี พ.ศ. 2537 โดยพัฒนามาจากชมรมเอ็นโดดอนติกส์แห่งประเทศไทย เพื่อส่งเสริมความรู้และพัฒนาวิทยาการด้านวิทยาเอ็นโดดอนต์ หรือการรักษาคลองรากฟัน ในประเทศไทย'); ?></p></div>
      <div class="about-history-grid">
        <article class="about-history-feature"><span>2537</span><strong><?php echo esc_html($is_en ? '1994' : 'ปีที่ก่อตั้งสมาคม'); ?></strong><p><?php echo esc_html($is_en ? 'The Association grew from the Endodontic Club of Thailand into a national professional association.' : 'เริ่มต้นจากการรวมตัวเป็นชมรมเอ็นโดดอนติกส์แห่งประเทศไทย ก่อนยกระดับเป็นสมาคม'); ?></p></article>
        <article><span class="material-symbols-outlined" aria-hidden="true">celebration</span><h3><?php echo esc_html($is_en ? '30 years of progress' : '30 ปีแห่งความก้าวหน้า'); ?></h3><p><?php echo esc_html($is_en ? 'In 2025, the Association marked 30 years under the theme “Rooted in Excellence”.' : 'ในปี พ.ศ. 2568 สมาคมจัดงานฉลองครบรอบ 30 ปี ภายใต้แนวคิด “Rooted in Excellence”'); ?></p></article>
        <article><span class="material-symbols-outlined" aria-hidden="true">auto_stories</span><h3>Thai Endodontic Journal</h3><p><?php echo esc_html($is_en ? 'The Association publishes its academic journal to share research and dental scholarship.' : 'สมาคมจัดพิมพ์วารสารเอ็นโดดอนติกส์ไทย เพื่อเผยแพร่งานวิจัยและบทความทางทันตกรรม'); ?></p></article>
        <article><span class="material-symbols-outlined" aria-hidden="true">event_available</span><h3><?php echo esc_html($is_en ? 'Core activities' : 'กิจกรรมหลัก'); ?></h3><p><?php echo esc_html($is_en ? 'Academic conferences, research grants and the advancement of root canal treatment standards.' : 'จัดประชุมวิชาการ ให้ทุนสนับสนุนการวิจัย และพัฒนามาตรฐานการรักษาคลองรากฟันของทันตแพทย์ไทย'); ?></p></article>
        <article><span class="material-symbols-outlined" aria-hidden="true">location_on</span><h3><?php echo esc_html($is_en ? 'Association office' : 'ที่ทำการสมาคม'); ?></h3><p><?php echo esc_html($is_en ? 'Department of Operative Dentistry, Faculty of Dentistry, Chulalongkorn University.' : 'ภาควิชาทันตกรรมหัตถการ คณะทันตแพทยศาสตร์ จุฬาลงกรณ์มหาวิทยาลัย'); ?></p></article>
      </div>
    </section>

    <section class="about-president" aria-labelledby="about-president-title">
      <div class="about-president-photo"><div class="about-president-frame"><img src="<?php echo esc_url($asset . 'person-chinalai-piyachon.jpg'); ?>" alt="<?php echo esc_attr($is_en ? 'Asst. Prof. Dr. Chinalai Piyachon, President of the Thai Endodontic Association' : 'ผศ.ทพญ.ชินาลัย ปิยะชน นายกสมาคมเอ็นโดดอนติกส์ไทย'); ?>" loading="eager"></div><span><?php echo esc_html($is_en ? 'PRESIDENT' : 'นายกสมาคม'); ?></span></div>
      <div class="about-president-copy">
        <span class="about-kicker warm"><?php echo esc_html($is_en ? 'ASSOCIATION LEADERSHIP' : 'ผู้นำสมาคม'); ?></span>
        <h2 id="about-president-title"><?php echo esc_html($is_en ? 'Asst. Prof. Dr. Chinalai Piyachon' : 'ผศ.ทพญ.ชินาลัย ปิยะชน'); ?></h2>
        <p class="about-president-role"><?php echo esc_html($is_en ? 'President, Thai Endodontic Association · 2026–2027' : 'นายกสมาคมเอ็นโดดอนติกส์ไทย · วาระบริหารสมาคม พ.ศ. 2569–2570'); ?></p>
        <p><?php echo esc_html($is_en ? 'The Association is committed to developing clinical standards, supporting research and Thai academic publishing, and strengthening the next generation of dental professionals through sustainable learning opportunities.' : 'สมาคมมุ่งขับเคลื่อนมาตรฐานวิชาเอ็นโดดอนติกส์สู่ความเป็นเลิศทางคลินิก ส่งเสริมงานวิจัยและวารสารไทย พร้อมพัฒนาทันตแพทย์รุ่นใหม่อย่างยั่งยืน'); ?></p>
        <a class="about-president-link" href="<?php echo esc_url($committee_url); ?>"><span class="material-symbols-outlined" aria-hidden="true">groups</span><?php echo esc_html($is_en ? 'Meet the executive committee' : 'ทำความรู้จักคณะกรรมการบริหาร'); ?><span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></a>
      </div>
    </section>

    <section class="about-actions" aria-label="<?php echo esc_attr($is_en ? 'Association services' : 'บริการของสมาคม'); ?>">
      <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>"><span class="material-symbols-outlined" aria-hidden="true">event</span><div><b><?php echo esc_html($is_en ? 'Activities and learning' : 'กิจกรรมและการเรียนรู้'); ?></b><small><?php echo esc_html($is_en ? 'Conferences, training and academic activities' : 'ประชุม อบรม และกิจกรรมวิชาการ'); ?></small></div><span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></a>
      <a href="<?php echo esc_url(get_post_type_archive_link('research_fund')); ?>"><span class="material-symbols-outlined" aria-hidden="true">clinical_notes</span><div><b><?php echo esc_html($is_en ? 'Research support' : 'ทุนสนับสนุนวิจัย'); ?></b><small><?php echo esc_html($is_en ? 'Opportunities and association documents' : 'โอกาสและเอกสารสนับสนุนจากสมาคม'); ?></small></div><span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></a>
      <a href="<?php echo esc_url(get_post_type_archive_link('journal')); ?>"><span class="material-symbols-outlined" aria-hidden="true">auto_stories</span><div><b>Thai Endodontic Journal</b><small><?php echo esc_html($is_en ? 'Read our journal and document library' : 'อ่านวารสารและคลังเอกสารของสมาคม'); ?></small></div><span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></a>
    </section>
  </div>
</main>
<?php endwhile; get_footer(); ?>
