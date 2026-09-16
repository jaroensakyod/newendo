<?php
/* seed-committee.php — เพจเกี่ยวกับสมาคม: อัปเดตเนื้อหา + โครงสร้างกรรมการ (wp eval-file) */
if (!defined('ABSPATH')) exit;

$th = <<<HTML
<p class="tp-lead">สมาคมเอ็นโดดอนติกส์ไทย ก่อตั้งขึ้นเพื่อส่งเสริมวิชาเอ็นโดดอนติกส์ (ทันตกรรมรากฟัน) ให้มีมาตรฐานเป็นที่ยอมรับระดับสากล ดูแลการศึกษาต่อเนื่องของทันตแพทย์ (CDEC) สนับสนุนทุนวิจัย และเผยแพร่วารสารวิชาการ Thai Endodontic Journal</p>
<h2>วิสัยทัศน์</h2>
<ul class="tp-list"><li>เป็นองค์กรวิชาชีพชั้นนำด้านทันตกรรมรากฟันของประเทศไทย</li><li>ยกระดับมาตรฐานการรักษาและการศึกษาต่อเนื่องของทันตแพทย์</li><li>เชื่อมโยงเครือข่ายวิชาการระดับนานาชาติ อาทิ IFEA และ APEC</li></ul>
<h2>คณะกรรมการบริหาร วาระ 2569–2570</h2>
<div class="tea-committee">
  <div class="tea-member is-president">
    <div class="tea-member-photo"><span class="material-symbols-outlined">person</span></div>
    <div class="tea-member-body"><span class="pos">นายกสมาคม</span><b>ผศ.ทพญ.ชินาลัย ปิยะชน</b></div>
  </div>
  <div class="tea-note">รายชื่อคณะกรรมการบริหารชุดเต็ม (รองนายก เลขานุการ เหรัญญิการ และกรรมการ) จะประกาศผ่านหน้านี้และช่องทางทางการของสมาคมโดยเร็ว</div>
</div>
HTML;

$en = <<<HTML
<p class="tp-lead">The Thai Endodontic Association is the professional society for endodontics in Thailand, dedicated to advancing the science and practice of root canal treatment, supporting continuing education (CDEC), funding research and publishing the Thai Endodontic Journal.</p>
<h2>Vision</h2>
<ul class="tp-list"><li>To be the leading professional body for endodontics in Thailand</li><li>To raise the standards of treatment and continuing education for dentists</li><li>To connect with international networks such as IFEA and APEC</li></ul>
<h2>Executive Committee 2026–2027</h2>
<div class="tea-committee">
  <div class="tea-member is-president">
    <div class="tea-member-photo"><span class="material-symbols-outlined">person</span></div>
    <div class="tea-member-body"><span class="pos">President</span><b>Asst. Prof. Dr. Chinalai Piyachon</b></div>
  </div>
  <div class="tea-note">The full list of executive committee members (Vice Presidents, Secretary, Treasurer and Members) will be announced on this page and through the Association's official channels soon.</div>
</div>
HTML;

// เพจไทย (12 = about) — ตั้งเป็นภาษาไทย + เนื้อหาใหม่
wp_update_post([
    'ID'           => 12,
    'post_content' => $th,
    'post_excerpt' => 'ประวัติ วิสัยทัศน์ และคณะกรรมการบริหารสมาคมเอ็นโดดอนติกส์ไทย วาระ 2569–2570',
]);
pll_set_post_language(12, 'th');

// เพจอังกฤษ (65) — อัปเดตเนื้อหา EN
wp_update_post([
    'ID'           => 65,
    'post_content' => $en,
    'post_excerpt' => 'History, vision and the executive committee of the Thai Endodontic Association, term 2026–2027',
]);
pll_set_post_language(65, 'en');
pll_save_post_translations(['th' => 12, 'en' => 65]);

echo "about pages updated (TH 12 / EN 65)\n";
