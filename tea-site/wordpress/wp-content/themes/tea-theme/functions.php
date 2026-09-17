<?php
if (!defined('ABSPATH')) exit;

function tea_theme_setup() {
    load_theme_textdomain('tea-theme', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('responsive-embeds');
    register_nav_menus([
        'primary' => __('เมนูหลัก / Primary Menu', 'tea-theme'),
        'footer'  => __('เมนูท้ายเว็บ / Footer Menu', 'tea-theme'),
    ]);
}
add_action('after_setup_theme', 'tea_theme_setup');

function tea_theme_assets() {
    wp_enqueue_style(
        'tea-fonts',
        'https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400..700;1,6..72,400..600&family=Manrope:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap',
        [],
        null
    );
    wp_enqueue_style('tea-theme', get_stylesheet_uri(), ['tea-fonts'], '4.9.56');
    wp_enqueue_script('tea-main', get_template_directory_uri() . '/js/main.js', [], '4.0.1', true);
}
add_action('wp_enqueue_scripts', 'tea_theme_assets');

/* The TEJ call-for-papers image has an incomplete generated thumbnail in the
 * legacy uploads folder.  Use the verified full association asset everywhere
 * this post's featured image is rendered. */
add_filter('post_thumbnail_html', function ($html, $post_id, $thumbnail_id, $size, $attr) {
    if ((int) $post_id !== 33) return $html;
    $classes = isset($attr['class']) ? ' ' . $attr['class'] : '';
    return '<img src="' . esc_url(get_template_directory_uri() . '/assets/journal-call.jpg') . '" class="wp-post-image' . esc_attr($classes) . '" alt="' . esc_attr(get_the_title($post_id)) . '" loading="lazy">';
}, 10, 5);

/* Announcements remain a separate editor workflow, but visitors see one
 * unified news stream. */
add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive('news')) {
        $query->set('post_type', ['news', 'announcement']);
        $query->set('posts_per_page', 12);
    }
});

add_action('template_redirect', function () {
  if (is_post_type_archive('announcement')) {
    wp_safe_redirect(get_post_type_archive_link('news'), 301);
    exit;
  }
  if (is_post_type_archive('document')) {
    wp_safe_redirect(get_post_type_archive_link('journal'), 301);
    exit;
  }
});

/** ปุ่มสลับภาษา (ใช้ Polylang ถ้ามี ไม่มีก็ไม่แสดง) */
function tea_language_switcher() {
    if (function_exists('pll_the_languages')) {
        echo '<ul class="lang-switch">';
        $languages = pll_the_languages(['raw' => 1, 'hide_if_empty' => 0]);
        foreach ($languages as $language) {
            $label = ($language['slug'] ?? '') === 'th' ? 'Thai' : 'English';
            $class = !empty($language['current_lang']) ? ' class="current-lang"' : '';
            echo '<li' . $class . '><a href="' . esc_url($language['url']) . '">' . esc_html($label) . '</a></li>';
        }
        echo '</ul>';
    }
}

/** Cookie Consent แบบเลือกประเภท — ดีไซน์ตามต้นฉบับ (ข้อ 6 ของใบเสนอราคา) */
function tea_cookie_consent() {
    if (isset($_COOKIE['tea_cookie_consent'])) return;
    ?>
    <aside class="cookie-banner" id="tea-cookie-banner" aria-label="<?php esc_attr_e('การใช้คุกกี้', 'tea-theme'); ?>">
      <div class="cookie-copy">
        <strong><?php esc_html_e('เว็บไซต์นี้ใช้คุกกี้', 'tea-theme'); ?></strong>
        <p><?php esc_html_e('เราใช้คุกกี้เพื่อพัฒนาประสบการณ์การใช้งาน — เลือกประเภทคุกกี้ได้ที่ "ตั้งค่าคุกกี้"', 'tea-theme'); ?></p>
        <div class="cookie-settings" id="tea-cookie-settings" hidden>
          <label>
            <span><strong><?php esc_html_e('คุกกี้ที่จำเป็น', 'tea-theme'); ?></strong><small><?php esc_html_e('ใช้สำหรับการทำงานพื้นฐานและการจดจำตัวเลือก', 'tea-theme'); ?></small></span>
            <input type="checkbox" checked disabled>
          </label>
          <label>
            <span><strong><?php esc_html_e('คุกกี้วิเคราะห์', 'tea-theme'); ?></strong><small><?php esc_html_e('ช่วยให้เข้าใจการใช้งานเพื่อปรับปรุงเว็บไซต์', 'tea-theme'); ?></small></span>
            <input type="checkbox" id="tea-ck-analytics">
          </label>
          <label>
            <span><strong><?php esc_html_e('คุกกี้การตลาด', 'tea-theme'); ?></strong><small><?php esc_html_e('ใช้เมื่อมีการเชื่อมบริการประชาสัมพันธ์ภายนอก', 'tea-theme'); ?></small></span>
            <input type="checkbox" id="tea-ck-marketing">
          </label>
        </div>
      </div>
      <div class="cookie-actions">
        <button type="button" class="cookie-button secondary" id="tea-ck-settings-toggle"><?php esc_html_e('ตั้งค่าคุกกี้', 'tea-theme'); ?></button>
        <button type="button" class="cookie-button secondary" id="tea-ck-save" hidden><?php esc_html_e('บันทึกการตั้งค่า', 'tea-theme'); ?></button>
        <button type="button" class="cookie-button primary" data-consent="all"><?php esc_html_e('ยอมรับทั้งหมด', 'tea-theme'); ?></button>
      </div>
    </aside>
    <script>
    (function () {
      var banner = document.getElementById('tea-cookie-banner');
      if (!banner) return;
      var settings = document.getElementById('tea-cookie-settings');
      var toggle = document.getElementById('tea-ck-settings-toggle');
      var save = document.getElementById('tea-ck-save');
      toggle.addEventListener('click', function () {
        var open = settings.hidden;
        settings.hidden = !open;
        save.hidden = !open;
        toggle.textContent = open ? 'ปิดการตั้งค่า' : 'ตั้งค่าคุกกี้';
      });
      function store(analytics, marketing) {
        var val = 'necessary:1|analytics:' + (analytics ? 1 : 0) + '|marketing:' + (marketing ? 1 : 0);
        document.cookie = 'tea_cookie_consent=' + encodeURIComponent(val) + ';path=/;max-age=31536000;SameSite=Lax';
        banner.remove();
      }
      banner.addEventListener('click', function (e) {
        var b = e.target.closest('[data-consent]');
        if (b) return store(true, true);
      });
      save.addEventListener('click', function () {
        store(document.getElementById('tea-ck-analytics').checked, document.getElementById('tea-ck-marketing').checked);
      });
    })();
    </script>
    <?php
}
add_action('wp_footer', 'tea_cookie_consent', 5);

/** วันที่ภาษาไทย พ.ศ. เช่น "13 กันยายน 2569" (ไม่ขึ้นกับ locale ของเว็บ) */
function tea_thai_date($date_str = null) {
    $ts = $date_str ? strtotime($date_str) : current_time('timestamp');
    if (!$ts) $ts = current_time('timestamp');
    $is_en = function_exists('pll_current_language') && pll_current_language() === 'en';
    if ($is_en) {
        $months_en = ['', 'January', 'February', 'March', 'April', 'May', 'June',
                      'July', 'August', 'September', 'October', 'November', 'December'];
        return (int) date('j', $ts) . ' ' . $months_en[(int) date('n', $ts)] . ' ' . date('Y', $ts);
    }
    $months = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
               'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    return (int) date('j', $ts) . ' ' . $months[(int) date('n', $ts)] . ' ' . ((int) date('Y', $ts) + 543);
}

function tea_the_date($post_id = 0) {
    echo esc_html(tea_thai_date(get_post_field('post_date', $post_id ?: get_the_ID())));
}

function tea_cpt_label($type, $default) {
    $map_en = [
        'news' => 'News', 'announcement' => 'Announcements', 'event' => 'Events',
        'research_fund' => 'Research Funds', 'journal' => 'Journal', 'document' => 'Documents',
    ];
    if (function_exists('pll_current_language') && pll_current_language() === 'en' && isset($map_en[$type])) {
        return $map_en[$type];
    }
    return $default;
}

/** สไตล์หน้าแรกแบบ design-22 + ไอคอน Material Symbols */
function tea_design22_assets() {
    $path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
    $is_en_home = in_array($path, ['en', 'home-en', 'en/home-en'], true);
    if (is_front_page() || $is_en_home) {
  wp_enqueue_style('tea-home', get_template_directory_uri() . '/assets/home.css', [], '1.18.10');
    }
    wp_enqueue_style('tea-material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap', [], null);
}
add_action('wp_enqueue_scripts', 'tea_design22_assets');

/** Polylang: register theme strings for translation */
function tea_strings_map() {
    static $m = null;
    if ($m === null) {
        $f = get_template_directory() . '/strings-en.php';
        $m = file_exists($f) ? include $f : [];
    }
    return $m;
}
add_action('plugins_loaded', function () {
    if (!function_exists('pll_register_string')) return;
    foreach (tea_strings_map() as $th => $en) {
        pll_register_string('tea', $th, 'Tea Theme', false);
    }
}, 5);

/** gettext filter: translate theme + core strings on EN pages */
add_filter('gettext', function ($translation, $text, $domain) {
    if (!in_array($domain, ['tea-theme', 'tea-core'], true)) return $translation;
    if (!function_exists('pll_current_language') || pll_current_language() !== 'en') return $translation;
    return tea_strings_map()[$text] ?? $translation;
}, 10, 3);


/** เอกสารดาวน์โหลด: language-neutral (แสดงทั้งไทย/อังกฤษ) */
add_filter('pll_get_post_types', function ($types) {
    unset($types['document']);
    return $types;
}, 10, 1);

add_filter('template_include', function ($tpl) {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    if (strpos($uri, 'tea-dbg') !== false) {
        global $wp_query;
        header('Content-Type: text/plain');
        echo 'template=' . $tpl . "
queried_id=" . get_queried_object_id() . "
lang=" . pll_current_language() . "
is_front=" . var_export(is_front_page(), true);
        exit;
    }
    return $tpl;
}, 99);

/** /en/ และ /home-en/ = หน้าแรกภาษาอังกฤษ (Polylang ไม่ route ภาษาที่สองไป front-page เองทุกกรณี) */
add_filter('template_include', function ($tpl) {
    if (is_admin() || !function_exists('pll_current_language') || pll_current_language() !== 'en') return $tpl;
    $path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
    if (is_front_page() || in_array($path, ['en', 'home-en', 'en/home-en'], true)) {
        return get_template_directory() . '/front-page.php';
    }
    return $tpl;
}, 99);
