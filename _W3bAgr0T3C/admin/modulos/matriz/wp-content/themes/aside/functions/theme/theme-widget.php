<?php
//Tag widget filter
function ux_cloud_filter($args = array()) {
   $args['smallest'] = 11;
   $args['largest'] = 11;
   $args['unit'] = 'px';
   return $args;
}
add_filter('widget_tag_cloud_args', 'ux_cloud_filter', 90);

//ux widget require modal
function ux_widgets_admin_page(){ ?>
    <div class="ux-theme-box">
		<?php ux_theme_option_modal(); ?>
    </div>
<?php
}
add_action('widgets_admin_page', 'ux_widgets_admin_page');

//require theme widget recent comments
require_once locate_template('/functions/theme/widget/widget-recent-comments.php');

//require theme widget social network icons
require_once locate_template('/functions/theme/widget/widget-social-network-icons.php');

?>