<?php
if (!defined('ABSPATH')) exit;

/* Official committee portraits and roles sourced from the Association's
   committee meeting record, term 2569-2570. */
$members = [
  ['group' => 'president', 'name' => 'ผศ.ทพญ.ชินาลัย ปิยะชน', 'role_th' => 'นายกสมาคม', 'role_en' => 'President', 'image' => 'person-chinalai-piyachon.jpg'],

  ['group' => 'advisors', 'name' => 'รศ.ทพญ.ปิยาณี พาณิชย์วิสัย', 'role_th' => 'ที่ปรึกษาสมาคม', 'role_en' => 'Association Advisor', 'image' => 'person-piyanee-panichwisit.jpg'],
  ['group' => 'advisors', 'name' => 'ทพ.วีระวัฒน์ สัตยานุรักษ์', 'role_th' => 'ที่ปรึกษาสมาคม', 'role_en' => 'Association Advisor', 'image' => 'person-weerawat-satayanurak.jpg'],
  ['group' => 'advisors', 'name' => 'ทพญ.ธาราธร สุนทรเกียรติ', 'role_th' => 'ที่ปรึกษาสมาคม', 'role_en' => 'Association Advisor', 'image' => 'person-tharathorn-sunthornkiat.jpg'],
  ['group' => 'advisors', 'name' => 'รศ.ดร.ทพญ.จีรภัทร จันทรัตน์', 'role_th' => 'ที่ปรึกษาสมาคม', 'role_en' => 'Association Advisor', 'image' => 'person-jirapath-chantharat.jpg'],
  ['group' => 'advisors', 'name' => 'รศ.ดร.ทพ.ไพโรจน์ หลินศุวนนท์', 'role_th' => 'ที่ปรึกษาสมาคม', 'role_en' => 'Association Advisor', 'image' => 'person-pairoj-linsuwanont.jpg'],
  ['group' => 'advisors', 'name' => 'ทพญ.พัชรินทร์ ปอแก้ว', 'role_th' => 'ที่ปรึกษาสมาคม', 'role_en' => 'Association Advisor', 'image' => 'person-patcharin-paokaew.jpg'],

  ['group' => 'central', 'name' => 'อ.ทพญ.พีรพร โชติวรรักษ์', 'role_th' => 'กรรมการกลาง', 'role_en' => 'Central Committee Member', 'image' => 'person-peeraphon-chotiwarak.jpg'],
  ['group' => 'central', 'name' => 'รศ.ทพญ.ถนอมศุข เจียรนัยไพศาล', 'role_th' => 'กรรมการกลาง', 'role_en' => 'Central Committee Member', 'image' => 'person-tanomsuk-chianaiyapaisan.jpg'],
  ['group' => 'central', 'name' => 'ผศ.ดร.ทพญ.อุทัยวรรณ อารยะตระกูลสวัสดิ์', 'role_th' => 'กรรมการกลาง', 'role_en' => 'Central Committee Member', 'image' => 'person-uthaiwan-arayatrakulsawat.jpg'],
  ['group' => 'central', 'name' => 'รศ.ทพ.ศิริวุฒิ หิรัญอัศว์', 'role_th' => 'กรรมการกลาง', 'role_en' => 'Central Committee Member', 'image' => 'person-sirawut-hiranus.jpg'],

  ['group' => 'executive', 'name' => 'รศ.ดร.ทพ.ภูมิศักดิ์ เลาวกุล', 'role_th' => 'อุปนายกสมาคม', 'role_en' => 'Vice President', 'image' => 'person-phumisak-laowakul.jpg'],
  ['group' => 'executive', 'name' => 'อ.ทพญ.ลลิดา องค์ชวลิต', 'role_th' => 'กรรมการและวิชาการ', 'role_en' => 'Committee Member, Academic Affairs', 'image' => 'person-lalida-ongchawalit.jpg'],
  ['group' => 'executive', 'name' => 'ผศ.ทพ.คเณศ โชติวรรักษ์', 'role_th' => 'กรรมการและผู้ช่วยเลขานุการ', 'role_en' => 'Committee Member, Assistant Secretary', 'image' => 'person-kanes-chotiwarak.jpg'],
  ['group' => 'executive', 'name' => 'อ.ดร.ทพญ.ทัดกมล ครองบารมี', 'role_th' => 'กรรมการและวิเทศสัมพันธ์', 'role_en' => 'Committee Member, International Relations', 'image' => 'person-tadkamol-krongbaramee.jpg'],
  ['group' => 'executive', 'name' => 'อ.ทพญ.สิริภัทร เลิศนันทปัญญา', 'role_th' => 'กรรมการและประชาสัมพันธ์', 'role_en' => 'Committee Member, Public Relations', 'image' => 'person-siriphat-lertnuntapanya.jpg'],
  ['group' => 'executive', 'name' => 'ทพญ.ประภัสสร พลอยแสงงาม', 'role_th' => 'กรรมการและนายทะเบียน', 'role_en' => 'Committee Member, Registrar', 'image' => 'person-prapassorn-ploysaengam.jpg'],
  ['group' => 'executive', 'name' => 'ทพญ.ปาริชาติ ดำริน', 'role_th' => 'กรรมการและปฏิคม', 'role_en' => 'Committee Member, Hospitality', 'image' => 'person-parichat-dumrin.jpg'],
  ['group' => 'executive', 'name' => 'อ.ดร.ทพญ.กุลนันทน์ ดำรงวุฒิ', 'role_th' => 'กรรมการและเหรัญญิก', 'role_en' => 'Committee Member, Treasurer', 'image' => 'person-kulanun-damrongwut.jpg'],
  ['group' => 'executive', 'name' => 'ทพ.นรชัย วงศ์กรเชาวลิต', 'role_th' => 'กรรมการและเลขาธิการ', 'role_en' => 'Committee Member, Secretary', 'image' => 'person-norachai-wongkornchaowalit.jpg'],
  ['group' => 'executive', 'name' => 'อ.ทพญ.ชนาภาพต์ สินเสรีกุล', 'role_th' => 'กรรมการและผู้ช่วยเลขาธิการ', 'role_en' => 'Committee Member, Assistant Secretary', 'image' => 'person-chanaphat-sinsereekul.jpg'],
];

$english_names = [
  'person-chinalai-piyachon.jpg' => 'Asst. Prof. Dr. Chinalai Piyachon',
  'person-piyanee-panichwisit.jpg' => 'Assoc. Prof. Dr. Piyanee Panichwisit',
  'person-weerawat-satayanurak.jpg' => 'Dr. Weerawat Satayanurak',
  'person-tharathorn-sunthornkiat.jpg' => 'Dr. Tharathorn Sunthornkiat',
  'person-jirapath-chantharat.jpg' => 'Assoc. Prof. Dr. Jirapath Chantharat',
  'person-pairoj-linsuwanont.jpg' => 'Assoc. Prof. Dr. Pairoj Linsuwanont',
  'person-patcharin-paokaew.jpg' => 'Dr. Patcharin Paokaew',
  'person-peeraphon-chotiwarak.jpg' => 'Dr. Peeraphon Chotiwarak',
  'person-tanomsuk-chianaiyapaisan.jpg' => 'Assoc. Prof. Dr. Tanomsuk Chianaiyapaisan',
  'person-uthaiwan-arayatrakulsawat.jpg' => 'Asst. Prof. Dr. Uthaiwan Arayatrakulsawat',
  'person-sirawut-hiranus.jpg' => 'Assoc. Prof. Dr. Sirawut Hiranus',
  'person-phumisak-laowakul.jpg' => 'Assoc. Prof. Dr. Phumisak Laowakul',
  'person-lalida-ongchawalit.jpg' => 'Dr. Lalida Ongchawalit',
  'person-kanes-chotiwarak.jpg' => 'Asst. Prof. Dr. Kanes Chotiwarak',
  'person-tadkamol-krongbaramee.jpg' => 'Dr. Tadkamol Krongbaramee',
  'person-siriphat-lertnuntapanya.jpg' => 'Dr. Siriphat Lertnuntapanya',
  'person-prapassorn-ploysaengam.jpg' => 'Dr. Prapassorn Ploysaengam',
  'person-parichat-dumrin.jpg' => 'Dr. Parichat Dumrin',
  'person-kulanun-damrongwut.jpg' => 'Dr. Kulanun Damrongwut',
  'person-norachai-wongkornchaowalit.jpg' => 'Dr. Norachai Wongkornchaowalit',
  'person-chanaphat-sinsereekul.jpg' => 'Dr. Chanaphat Sinsereekul',
];
foreach ($members as &$member) {
  $member['name_en'] = $english_names[$member['image']] ?? $member['name'];
}
unset($member);
return $members;
