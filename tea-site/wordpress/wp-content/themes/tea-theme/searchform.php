<?php if (!defined('ABSPATH')) exit; ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
  <label class="screen-reader-text" for="tea-s"><?php esc_html_e('ค้นหา', 'tea-theme'); ?></label>
  <input type="search" id="tea-s" placeholder="<?php esc_attr_e('ค้นหา… / Search…', 'tea-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s">
  <button type="submit"><?php esc_html_e('ค้นหา', 'tea-theme'); ?></button>
</form>
