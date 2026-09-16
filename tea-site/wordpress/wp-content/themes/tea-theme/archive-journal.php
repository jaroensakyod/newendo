<?php
if (!defined('ABSPATH')) exit;
get_header();
$tea_is_en = function_exists('pll_current_language') && pll_current_language() === 'en';
$tea_journal_en_titles = [
  'บทบาทของอีพิเจเนติกส์ต่อการเกิดและการรักษาโรค ของเนื้อเยื่อในโพรงฟันและโรครอบปลายรากฟัน' => 'The Role of Epigenetics in Pulpal and Periapical Diseases',
  'การรักษาคลองรากฟันที่มีรอยโรคร่วมระหว่างโรคเนื้อเยื่อในและโรคปริทันต์ : กรณีผู้ป่วยที่มีสาเหตุมาจากรอยโรคเนื้อเยื่อในปฐมภูมิตามด้วยโรคปริทันต์ทุติยภูมิในฟันกรามล่างขวาอันมีสาเหตุจากรอยร้าว' => 'Endodontic Treatment of Combined Endodontic-Periodontal Lesions: A Case Report',
  'การรักษาฟันที่มีการสูญสลายของรากฟันบริเวณคอฟันจากภายนอกที่มีลักษณะคล้ายการสูญสลายของรากฟันจากภายในด้วยการรักษาคลองรากฟันร่วมกับการรักษาทางศัลยกรรม' => 'Treatment of External Cervical Root Resorption Mimicking Internal Root Resorption',
  'รีเจเนอเรทีฟ เอ็นโดดอนติกส์: รูปแบบ Cell-free และ Cell-based' => 'Regenerative Endodontics: Cell-free and Cell-based Approaches',
  'การรักษาคลองรากฟันผ่านครอบฟันหลักยึดของสะพานฟันติดแน่น ในฟันตัดซี่ข้างล่างขวา' => 'Root Canal Treatment Through a Fixed Partial Denture Retainer Crown',
  'สถิติกับงานวิทยาเอ็นโดดอนต์ ตอนที่ 1: ตัวแปร' => 'Statistics in Endodontics Part 1: Variables',
  'การเรียนรู้ของเครื่องและการประยุกต์ใช้ทางวิทยาเอ็นโดดอนต์' => 'Machine Learning and Applications in Endodontics',
  'การทำศัลยกรรมปลายรากฟันร่วมกับการจัดการ ปุ่มกระดูกส่วนงอกของขากรรไกรที่มีขนาดใหญ่: รายงานผู้ป่วย' => 'Apical Surgery with Management of a Large Bony Exostosis: A Case Report',
  'สถิติกับงานวิทยาเอ็นโดดอนต์ ตอนที่ 2: ความเชื่อถือได้' => 'Statistics in Endodontics Part 2: Reliability',
  'การรักษาคลองรากฟันในฟันที่มีการตีบตันของคลองรากฟัน' => 'Root Canal Treatment in Calcified Canals',
  'การประยุกต์ใช้ภาพรังสีซีบีซีทีในงานรักษาคลองรากฟัน' => 'Applications of CBCT in Root Canal Treatment',
  'การรักษาภาวะฟันในฟันประเภทที่ 3 โดยวิธีการรักษาคลองรากฟันร่วมกับการทำเอ็มทีเอ เอเพคซิฟิเคชัน' => 'Treatment of Type III Dens Invaginatus with Root Canal Treatment and MTA Apexification',
  'การรักษาคลองรากฟันร่วมกับการปลูกถ่ายฟันโดยตั้งใจในฟันที่มีการสูญสลายของรากฟัน บริเวณคอฟัน' => 'Endodontic Treatment with Intentional Replantation for External Cervical Root Resorption',
  'กัญชาและแนวทางการนำมาใช้ในทางทันตกรรม' => 'Cannabis and Guidelines for Its Use in Dentistry',
  'สารสกัดพรอพอลิสไทยต่อการต้านการอักเสบในเซลล์เนื้อเยื่อในของฟันมนุษย์' => 'Anti-inflammatory Effects of Thai Propolis Extract on Human Pulp Cells',
];
$library_documents = new WP_Query([
  'post_type' => 'document',
  'lang' => '',
  'posts_per_page' => 12,
  'orderby' => 'date',
  'order' => 'DESC',
  'no_found_rows' => true,
]);
$journal_articles = new WP_Query([
  'post_type' => 'journal',
  'lang' => '',
  'posts_per_page' => -1,
  'meta_key' => '_tea_library_import',
  'orderby' => 'menu_order',
  'order' => 'DESC',
  'no_found_rows' => true,
]);
?>
<section class="page-hero page-hero-compact">
  <div class="shell">
    <nav class="breadcrumb" aria-label="<?php esc_attr_e('เส้นทาง', 'tea-theme'); ?>"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('หน้าแรก', 'tea-theme'); ?></a><span aria-hidden="true">›</span><span><?php esc_html_e('วารสาร', 'tea-theme'); ?></span></nav>
    <span class="page-hero-kicker"><span class="material-symbols-outlined" aria-hidden="true">auto_stories</span> PUBLICATIONS &amp; DOCUMENTS</span>
    <h1><?php esc_html_e('วารสารและเอกสารของสมาคม', 'tea-theme'); ?></h1>
    <p><?php esc_html_e('Thai Endodontic Journal คลังเอ็นโดสาร และเอกสารสำคัญของสมาคมในหน้าเดียว', 'tea-theme'); ?></p>
  </div>
</section>

<main class="journal-hub">
  <div class="shell">
    <div class="library-page-tabs" role="tablist" aria-label="<?php esc_attr_e('เลือกหมวดวารสารและเอกสาร', 'tea-theme'); ?>">
      <button class="is-active" type="button" role="tab" aria-selected="true" data-library-page-tab="journal"><?php esc_html_e('วารสาร', 'tea-theme'); ?></button>
      <button type="button" role="tab" aria-selected="false" data-library-page-tab="documents"><?php esc_html_e('เอกสาร', 'tea-theme'); ?></button>
    </div>
    <section class="library-pdf-section" id="association-documents" aria-label="<?php esc_attr_e('เอกสารและแบบฟอร์มสมาคม', 'tea-theme'); ?>">
      <div class="library-pdf-heading">
        <div><span>ASSOCIATION LIBRARY</span><h2><?php esc_html_e('วารสารและเอกสาร', 'tea-theme'); ?></h2><p><?php esc_html_e('เลือกดูวารสารหรือเอกสาร เปิดดูหน้าแรกของไฟล์ แล้วกดอ่านหรือดาวน์โหลดฉบับเต็มตามต้องการ', 'tea-theme'); ?></p></div>
        <a href="#top"><span class="material-symbols-outlined" aria-hidden="true">vertical_align_top</span><?php esc_html_e('กลับด้านบน', 'tea-theme'); ?></a>
      </div>
      <div class="library-pdf-tabs" role="tablist" aria-label="<?php esc_attr_e('เลือกหมวดคลังข้อมูล', 'tea-theme'); ?>">
        <button class="is-active" type="button" role="tab" aria-selected="true" aria-controls="library-tab-journal" id="library-tab-button-journal" data-library-tab="journal"><?php esc_html_e('วารสาร', 'tea-theme'); ?></button>
        <button type="button" role="tab" aria-selected="false" aria-controls="library-tab-documents" id="library-tab-button-documents" data-library-tab="documents"><?php esc_html_e('เอกสาร', 'tea-theme'); ?></button>
      </div>
      <div class="library-tab-panel is-active" id="library-tab-journal" role="tabpanel" aria-labelledby="library-tab-button-journal" data-library-panel="journal">
        <?php
        $journal_groups = [];
        if ($journal_articles->have_posts()) : while ($journal_articles->have_posts()) : $journal_articles->the_post();
          $issue = get_post_meta(get_the_ID(), '_tea_issue_label', true) ?: 'Thai Endodontic Journal';
          $title = get_the_title();
          $journal_groups[$issue][] = [
            'title' => ($tea_is_en && isset($tea_journal_en_titles[$title])) ? $tea_journal_en_titles[$title] : $title,
            'file' => get_post_meta(get_the_ID(), '_tea_pdf_url', true),
            'preview' => get_post_meta(get_the_ID(), '_tea_preview_url', true),
            'permalink' => get_permalink(),
          ];
        endwhile; wp_reset_postdata(); endif;
        foreach ($journal_groups as $issue => $articles) : ?>
        <section class="library-issue-group" aria-label="<?php echo esc_attr($issue); ?>">
          <header class="library-issue-heading"><div><span>THAI ENDODONTIC JOURNAL</span><h3><?php echo esc_html($issue); ?></h3></div><b><?php echo esc_html($tea_is_en ? count($articles) . ' articles' : count($articles) . ' บทความ'); ?></b></header>
          <div class="library-pdf-grid">
          <?php foreach ($articles as $article) : $file_url = $article['file'] ? home_url($article['file']) : $article['permalink']; ?>
          <article class="library-pdf-card">
            <a class="library-pdf-preview" href="<?php echo esc_url($file_url); ?>" target="_blank" rel="noreferrer">
              <?php if ($article['preview']) : ?><img src="<?php echo esc_url(home_url($article['preview'])); ?>" alt="<?php echo esc_attr($article['title']); ?>" loading="lazy"><?php else : ?><span class="material-symbols-outlined" aria-hidden="true">picture_as_pdf</span><?php endif; ?>
            </a>
            <div class="library-pdf-copy"><small><?php esc_html_e('บทความวารสาร', 'tea-theme'); ?></small><h3><?php echo esc_html($article['title']); ?></h3><a href="<?php echo esc_url($file_url); ?>" target="_blank" rel="noreferrer"><span class="material-symbols-outlined" aria-hidden="true">picture_as_pdf</span><?php esc_html_e('เปิด PDF', 'tea-theme'); ?></a></div>
          </article>
          <?php endforeach; ?>
          </div>
        </section>
        <?php endforeach; if (!$journal_groups) : ?><p><?php esc_html_e('ยังไม่มีไฟล์วารสารในคลัง', 'tea-theme'); ?></p><?php endif; ?>
        </div>
      </div>
      <div class="library-tab-panel" id="library-tab-documents" role="tabpanel" aria-labelledby="library-tab-button-documents" data-library-panel="documents" hidden>
      <div class="library-pdf-grid">
      <?php if ($library_documents->have_posts()) : while ($library_documents->have_posts()) : $library_documents->the_post();
        $file = get_post_meta(get_the_ID(), '_tea_file_url', true);
        $file_url = $file ? home_url($file) : '';
        $tea_pdf_previews = [
          'tea-article-support-form.pdf' => 'article-support-form.png',
          'tea-article-support-rules.pdf' => 'article-support-rules.png',
          'tea-research-grant-rules-2569.pdf' => 'research-grant-rules-2569.png',
          'tea-research-grant-form-2569.pdf' => 'research-grant-form-2569.png',
        ];
        $preview = isset($tea_pdf_previews[basename($file)]) ? $tea_pdf_previews[basename($file)] : '';
      ?>
        <article class="library-pdf-card">
          <a class="library-pdf-preview" href="<?php echo esc_url($file_url ?: get_permalink()); ?>"<?php echo $file_url ? ' target="_blank" rel="noreferrer"' : ''; ?> aria-label="<?php echo esc_attr(sprintf(__('เปิด %s', 'tea-theme'), get_the_title())); ?>">
            <?php if ($preview) : ?>
              <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/pdf-previews/' . $preview); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
            <?php else : ?>
              <span class="material-symbols-outlined" aria-hidden="true">description</span>
            <?php endif; ?>
          </a>
          <div class="library-pdf-copy"><small><?php tea_the_date(); ?></small><h3><?php the_title(); ?></h3><a href="<?php echo esc_url($file_url ?: get_permalink()); ?>"<?php echo $file_url ? ' target="_blank" rel="noreferrer"' : ''; ?>><span class="material-symbols-outlined" aria-hidden="true">picture_as_pdf</span><?php echo $file_url ? esc_html__('เปิด PDF', 'tea-theme') : esc_html__('ดูรายละเอียด', 'tea-theme'); ?></a></div>
        </article>
      <?php endwhile; wp_reset_postdata(); endif; ?>
      </div>
      </div>
    </section>

  </div>
</main>
<script>
(function () {
  var tabs = document.querySelectorAll('[data-library-tab]');
  var panels = document.querySelectorAll('[data-library-panel]');
  var pageTabs = document.querySelectorAll('[data-library-page-tab]');
  function showLibraryTab(key, shouldScroll) {
    tabs.forEach(function (item) { var active = item.getAttribute('data-library-tab') === key; item.classList.toggle('is-active', active); item.setAttribute('aria-selected', active ? 'true' : 'false'); });
    panels.forEach(function (panel) { var active = panel.getAttribute('data-library-panel') === key; panel.classList.toggle('is-active', active); panel.hidden = !active; });
    pageTabs.forEach(function (item) { var active = item.getAttribute('data-library-page-tab') === key; item.classList.toggle('is-active', active); item.setAttribute('aria-selected', active ? 'true' : 'false'); });
    if (shouldScroll) document.getElementById('association-documents').scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
  tabs.forEach(function (tab) { tab.addEventListener('click', function () { showLibraryTab(tab.getAttribute('data-library-tab'), false); }); });
  pageTabs.forEach(function (tab) { tab.addEventListener('click', function () { showLibraryTab(tab.getAttribute('data-library-page-tab'), true); }); });
})();
</script>
<?php get_footer();
