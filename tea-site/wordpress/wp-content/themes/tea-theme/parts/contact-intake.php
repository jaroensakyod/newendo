<?php if (!defined('ABSPATH')) exit;
$en = function_exists('pll_current_language') && pll_current_language() === 'en';
$t = function ($th, $en_str) use ($en) { return $en ? $en_str : $th; };
?>
<div class="page-header"><div class="shell">
  <p class="section-kicker">CONTACT / INTAKE</p>
  <h1 class="page-title"><?php echo esc_html($t('สอบถามข้อมูลและติดต่อสมาคม', 'Contact the Association')); ?></h1>
</div></div>

<div class="contact-shell">
  <div class="intake-card">
    <div class="intake-head">
      <p class="mono-label">INTAKE FORM</p>
      <h1><?php echo esc_html($t('แบบฟอร์มสอบถามข้อมูล', 'Inquiry Form')); ?></h1>
      <span><?php echo esc_html($t('กรอกข้อมูลสั้น ๆ เจ้าหน้าที่สมาคมจะติดต่อกลับโดยเร็วที่สุด', 'Fill in briefly and our staff will get back to you shortly.')); ?></span>
    </div>
    <form class="intake-form" id="tea-contact-form" novalidate>
      <div class="field-row">
        <label>
          <span><?php echo esc_html($t('ชื่อ-นามสกุล', 'Name')); ?> *</span>
          <input type="text" name="tea_name" required placeholder="<?php echo esc_attr($t('เช่น ทพ. สมชาย ใจดี', 'e.g. Dr. Somchai Jaidi')); ?>">
        </label>
        <label>
          <span><?php echo esc_html($t('อีเมลติดต่อกลับ', 'Email')); ?></span>
          <input type="email" name="tea_email" placeholder="you@example.com">
        </label>
      </div>

      <div>
        <span class="mono-label" style="display:block;margin-bottom:10px"><?php echo esc_html($t('หัวข้อที่สนใจ', 'TOPIC')); ?></span>
        <div class="pill-group">
          <input type="radio" name="tea_topic" id="tea-topic-1" value="general" checked><label for="tea-topic-1"><?php echo esc_html($t('สอบถามทั่วไป', 'General')); ?></label>
          <input type="radio" name="tea_topic" id="tea-topic-2" value="grant"><label for="tea-topic-2"><?php echo esc_html($t('ทุนวิจัย', 'Research grant')); ?></label>
          <input type="radio" name="tea_topic" id="tea-topic-3" value="journal"><label for="tea-topic-3"><?php echo esc_html($t('วารสาร/ส่งบทความ', 'Journal')); ?></label>
          <input type="radio" name="tea_topic" id="tea-topic-4" value="member"><label for="tea-topic-4"><?php echo esc_html($t('สมาชิก/CDEC', 'Membership/CDEC')); ?></label>
        </div>
      </div>

      <div>
        <span class="mono-label" style="display:block;margin-bottom:10px"><?php echo esc_html($t('ช่วงเวลาที่สะดวกรับสาย', 'PREFERRED TIME')); ?></span>
        <div class="slot-group">
          <input type="radio" name="tea_slot" id="tea-slot-1" value="morning" checked><label for="tea-slot-1"><b><?php echo esc_html($t('ช่วงเช้า', 'Morning')); ?></b><small>09:00 – 12:00</small></label>
          <input type="radio" name="tea_slot" id="tea-slot-2" value="afternoon"><label for="tea-slot-2"><b><?php echo esc_html($t('ช่วงบ่าย', 'Afternoon')); ?></b><small>13:00 – 16:00</small></label>
          <input type="radio" name="tea_slot" id="tea-slot-3" value="email"><label for="tea-slot-3"><b><?php echo esc_html($t('อีเมลเท่านั้น', 'Email only')); ?></b><small>REPLY BY MAIL</small></label>
        </div>
      </div>

      <label>
        <span><?php echo esc_html($t('รายละเอียด', 'Message')); ?></span>
        <textarea name="tea_message" placeholder="<?php echo esc_attr($t('เขียนคำถามหรือรายละเอียดที่ต้องการสอบถาม', 'Your question or details')); ?>"></textarea>
      </label>

      <button class="intake-submit" type="submit"><?php echo esc_html($t('ส่งข้อความ', 'SEND MESSAGE')); ?></button>
    </form>
  </div>

  <aside class="direct-card">
    <span><?php echo esc_html($t('ติดต่อโดยตรง', 'DIRECT')); ?></span>
    <strong><?php echo esc_html($t('สมาคมเอ็นโดดอนติกส์ไทย', 'Thai Endodontic Association')); ?></strong>
    <a href="tel:022188795">02-218-8795</a>
    <a href="mailto:thaiendodontics@gmail.com">thaiendodontics@gmail.com</a>
    <p><?php echo esc_html($t('ภาควิชาทันตกรรมหัตถการ คณะทันตแพทยศาสตร์ จุฬาลงกรณ์มหาวิทยาลัย กรุงเทพฯ 10330', 'Dept. of Operative Dentistry, Faculty of Dentistry, Chulalongkorn University, Bangkok 10330')); ?></p>
  </aside>
</div>
<?php get_footer(); ?>
