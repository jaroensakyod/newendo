<?php if (!defined('ABSPATH')) exit;
$tea_legal_url = static function ($slug) {
  $page = get_page_by_path($slug);
  if (!$page) return home_url('/' . $slug . '/');
  $page_id = (int) $page->ID;
  if (function_exists('pll_current_language') && function_exists('pll_get_post')) {
    $translation_id = pll_get_post($page_id, pll_current_language());
    if ($translation_id) $page_id = (int) $translation_id;
  }
  return get_permalink($page_id);
};
$tea_footer_en = function_exists('pll_current_language') && pll_current_language() === 'en';
$tea_footer_about_url = home_url($tea_footer_en ? '/en/about-en/' : '/about/');
$tea_footer_contact_url = home_url($tea_footer_en ? '/en/contact-en/' : '/contact/');
$tea_footer_committee_url = home_url($tea_footer_en ? '/en/committee-en/' : '/committee/');
?>
</main>

<footer id="contact" class="site-footer">
  <div class="shell footer-contact-panel">
    <div class="footer-contact-intro">
      <span><?php echo (function_exists('pll_current_language') && pll_current_language() === 'en') ? 'Follow Us' : esc_html__('ติดตามเรา · Follow Us', 'tea-theme'); ?></span>
      <h2><?php esc_html_e('รับข่าวสารสมาคมได้ทุกช่องทาง', 'tea-theme'); ?></h2>
    </div>
    <div class="contact-channel-grid">
      <a class="contact-channel facebook" href="https://www.facebook.com/Thaiendodontics/" target="_blank" rel="noreferrer">
        <span class="channel-icon" aria-hidden="true"><svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M13.5 21v-7.2h2.5l.4-2.9h-2.9V9.1c0-.8.2-1.4 1.4-1.4h1.6V5.1c-.3 0-1.2-.1-2.2-.1-2.2 0-3.7 1.3-3.7 3.8v2.1H8v2.9h2.6V21h2.9z"/></svg></span>
        <span><small>FACEBOOK</small><strong>Thaiendodontics</strong></span>
        <b aria-hidden="true">↗</b>
      </a>
      <a class="contact-channel line" href="https://line.me/R/ti/p/@thaiendodontics" target="_blank" rel="noreferrer">
        <span class="channel-icon" aria-hidden="true"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3C7 3 3 6.3 3 10.4c0 3.6 3.1 6.6 7.3 7.3.3.1.7.3.8.6l.2 1.4c0 .2.3.3.5.2l2.4-1.4c3.5-.9 5.8-3.6 5.8-6.9C20 6.3 17 3 12 3z"/><path d="M8 9v3.4M8 9h3.4M13 9v3.4M13 9h2.6c.7 0 1.1.5 1.1 1.1v1.2c0 .6-.4 1.1-1.1 1.1H13M8 13.4h1.8"/></svg></span>
        <span><small>LINE OFFICIAL</small><strong>@thaiendodontics</strong></span>
        <b aria-hidden="true">↗</b>
      </a>
      <a class="contact-channel instagram" href="https://www.instagram.com/thaiendodontics/" target="_blank" rel="noreferrer">
        <span class="channel-icon" aria-hidden="true"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="3.8"/><circle cx="17.2" cy="6.8" r="1.1" fill="currentColor" stroke="none"/></svg></span>
        <span><small>INSTAGRAM</small><strong>thaiendodontics</strong></span>
        <b aria-hidden="true">↗</b>
      </a>
      <a class="contact-channel email" href="mailto:thaiendodontics@gmail.com">
        <span class="channel-icon" aria-hidden="true"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="m4 7 8 6 8-6"/></svg></span>
        <span><small>EMAIL</small><strong>thaiendodontics@gmail.com</strong></span>
        <b aria-hidden="true">→</b>
      </a>
    </div>
  </div>
  <div class="shell footer-grid">
    <div class="footer-column">
      <h3><?php esc_html_e('เกี่ยวกับสมาคม', 'tea-theme'); ?></h3>
      <div class="footer-links">
        <a href="<?php echo esc_url($tea_footer_about_url); ?>"><?php esc_html_e('ประวัติและวัตถุประสงค์', 'tea-theme'); ?></a>
        <a href="<?php echo esc_url($tea_footer_committee_url); ?>"><?php esc_html_e('คณะกรรมการสมาคม', 'tea-theme'); ?></a>
        <a href="<?php echo esc_url($tea_footer_about_url); ?>"><?php esc_html_e('ทำเนียบประธาน', 'tea-theme'); ?></a>
        <a href="<?php echo esc_url($tea_footer_contact_url); ?>"><?php esc_html_e('ติดต่อสำนักงาน', 'tea-theme'); ?></a>
        <a href="<?php echo esc_url(get_post_type_archive_link('document')); ?>"><?php esc_html_e('คลังเอกสารสมาคม', 'tea-theme'); ?></a>
      </div>
      <a class="footer-social facebook" href="https://www.facebook.com/Thaiendodontics/" target="_blank" rel="noreferrer"><span aria-hidden="true">f</span><b>Thaiendodontics</b></a>
    </div>
    <div class="footer-column">
      <h3><?php esc_html_e('บริการวิชาการ', 'tea-theme'); ?></h3>
      <div class="footer-links">
        <a href="<?php echo esc_url(get_post_type_archive_link('journal')); ?>"><?php esc_html_e('วารสารเอ็นโดดอนติกส์', 'tea-theme'); ?></a>
        <a href="<?php echo esc_url(get_post_type_archive_link('research_fund')); ?>"><?php esc_html_e('ทุนวิจัย', 'tea-theme'); ?></a>
        <a href="https://www.thaiendodontics.com/cert"><?php esc_html_e('ใบประกาศและ CDEC', 'tea-theme'); ?></a>
        <a href="<?php echo esc_url(get_post_type_archive_link('document')); ?>"><?php esc_html_e('คลังเอกสาร', 'tea-theme'); ?></a>
        <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>"><?php esc_html_e('กิจกรรม', 'tea-theme'); ?></a>
      </div>
      <a class="footer-social line" href="https://line.me/R/ti/p/@thaiendodontics" target="_blank" rel="noreferrer"><span class="material-symbols-outlined" aria-hidden="true">chat</span><b>@thaiendodontics</b></a>
    </div>
    <div class="footer-column">
      <h3><?php esc_html_e('ข่าวสารและช่วยเหลือ', 'tea-theme'); ?></h3>
      <div class="footer-links">
        <a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>"><?php esc_html_e('ข่าวประชาสัมพันธ์', 'tea-theme'); ?></a>
        <button type="button" onclick="window.teaOpenAnnouncements && window.teaOpenAnnouncements()"><?php esc_html_e('ประกาศสำคัญ', 'tea-theme'); ?></button>
        <a href="<?php echo esc_url(get_post_type_archive_link('document')); ?>"><?php esc_html_e('แบบฟอร์มดาวน์โหลด', 'tea-theme'); ?></a>
        <a href="<?php echo esc_url($tea_footer_contact_url); ?>"><?php esc_html_e('คำถามที่พบบ่อย', 'tea-theme'); ?></a>
        <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>"><?php esc_html_e('ปฏิทินกิจกรรม', 'tea-theme'); ?></a>
      </div>
      <a class="footer-social instagram" href="https://www.instagram.com/thaiendodontics/" target="_blank" rel="noreferrer"><span class="material-symbols-outlined" aria-hidden="true">photo_camera</span><b>thaiendodontics</b></a>
    </div>
    <div class="footer-column">
      <h3><?php esc_html_e('ลิงก์ที่เกี่ยวข้อง', 'tea-theme'); ?></h3>
      <div class="footer-links">
        <a href="<?php echo esc_url(get_post_type_archive_link('journal')); ?>">Thai Endodontic Journal</a>
        <a href="https://www.facebook.com/Thaiendodontics" target="_blank" rel="noreferrer"><?php esc_html_e('Facebook สมาคมเอ็นโดดอนติกส์ไทย', 'tea-theme'); ?></a>
        <a href="https://www.thailandorganizer.com/thaiendodontics/" target="_blank" rel="noreferrer">Thailand Organizer</a>
        <a href="<?php echo esc_url(home_url('/?s=')); ?>"><?php esc_html_e('แผนผังเว็บไซต์', 'tea-theme'); ?></a>
        <a href="<?php echo esc_url($tea_footer_contact_url); ?>"><?php esc_html_e('นโยบายคุ้มครองข้อมูล', 'tea-theme'); ?></a>
      </div>
      <a class="footer-social email" href="mailto:thaiendodontics@gmail.com"><span class="material-symbols-outlined" aria-hidden="true">mail</span><b>thaiendodontics@gmail.com</b></a>
    </div>
    <div class="footer-brand">
      <img class="footer-logo" src="<?php echo esc_url(get_template_directory_uri() . '/assets/logo-mark.svg'); ?>" alt="<?php esc_attr_e('สมาคมเอ็นโดดอนติกส์ไทย', 'tea-theme'); ?>" width="72" height="72">
      <h2><?php echo esc_html($tea_footer_en ? 'Thai Endodontic Association' : get_bloginfo('name')); ?></h2>
      <p>Thai Endodontic Association</p>
      <address>
        <?php esc_html_e('ภาควิชาทันตกรรมหัตถการ', 'tea-theme'); ?><br>
        <?php esc_html_e('คณะทันตแพทยศาสตร์ จุฬาลงกรณ์มหาวิทยาลัย', 'tea-theme'); ?><br>
        <?php esc_html_e('กรุงเทพฯ 10330', 'tea-theme'); ?>
      </address>
      <a href="tel:022188795"><?php esc_html_e('โทร.', 'tea-theme'); ?> 02-218-8795</a>
    </div>
  </div>
  <div class="shell footer-bottom">
    <span>© <?php echo date_i18n('Y'); ?> THAI ENDODONTIC ASSOCIATION</span>
    <span class="footer-legal-links"><a href="<?php echo esc_url($tea_legal_url('privacy-policy')); ?>">PRIVACY</a><i aria-hidden="true">•</i><a href="<?php echo esc_url($tea_legal_url('security')); ?>">SECURITY</a><i aria-hidden="true">•</i><a href="<?php echo esc_url($tea_legal_url('pdpa')); ?>">PDPA</a></span>
  </div>
</footer>

<a class="floating-contact" href="<?php echo esc_url($tea_footer_contact_url); ?>" aria-label="<?php esc_attr_e('เปิดแบบฟอร์มสอบถามข้อมูล', 'tea-theme'); ?>">
  <span class="material-symbols-outlined" aria-hidden="true">mail</span>
  <small><?php esc_html_e('สอบถามข้อมูล', 'tea-theme'); ?></small>
</a>

<?php wp_footer(); ?>
</div><!-- .site -->
</body>
</html>
