<?php
//theme export theme widgets
function ux_export_theme_widgets(){
	global $wpdb;
	
	$sidebars_widgets       = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'sidebars_widgets'));
	$widget_categories      = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_categories'));
	$widget_text            = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_text'));
	$widget_rss             = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_rss'));
	$widget_search          = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_search'));
	$widget_recent_posts    = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_recent-posts'));
	$widget_recent_comments = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_recent-comments'));
	$widget_archives        = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_archives'));
	$widget_meta            = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_meta'));
	$widget_calendar        = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_calendar'));
	$widget_uxconatactform  = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_uxconatactform'));
	$widget_nav_menu        = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_nav_menu'));
	$widget_pages           = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_pages'));
	$widget_uxsocialinons   = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_uxsocialinons'));
	$widget_tag_cloud       = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = '%s'", 'widget_tag_cloud'));
	
	echo "\t<sidebars_widgets>";
	if($sidebars_widgets){
		echo ux_export_cdata($sidebars_widgets->option_value);
	}
	echo "</sidebars_widgets>\n";
	
	echo "\t<theme_widgets>";
	if($widget_categories){
		echo "<widget_categories>" . ux_export_cdata($widget_categories->option_value) . "</widget_categories>";
	}
	if($widget_text){
		echo "<widget_text>" . ux_export_cdata($widget_text->option_value) . "</widget_text>";
	}
	if($widget_rss){
		echo "<widget_rss>" . ux_export_cdata($widget_rss->option_value) . "</widget_rss>";
	}
	if($widget_search){
		echo "<widget_search>" . ux_export_cdata($widget_search->option_value) . "</widget_search>";
	}
	if($widget_recent_posts){
		echo "<widget_recent_posts>" . ux_export_cdata($widget_recent_posts->option_value) . "</widget_recent_posts>";
	}
	if($widget_recent_comments){
		echo "<widget_recent_comments>" . ux_export_cdata($widget_recent_comments->option_value) . "</widget_recent_comments>";
	}
	if($widget_archives){
		echo "<widget_archives>" . ux_export_cdata($widget_archives->option_value) . "</widget_archives>";
	}
	if($widget_meta){
		echo "<widget_meta>" . ux_export_cdata($widget_meta->option_value) . "</widget_meta>";
	}
	if($widget_calendar){
		echo "<widget_calendar>" . ux_export_cdata($widget_calendar->option_value) . "</widget_calendar>";
	}
	if($widget_uxconatactform){
		echo "<widget_uxconatactform>" . ux_export_cdata($widget_uxconatactform->option_value) . "</widget_uxconatactform>";
	}
	if($widget_nav_menu){
		echo "<widget_nav_menu>" . ux_export_cdata($widget_nav_menu->option_value) . "</widget_nav_menu>";
	}
	if($widget_pages){
		echo "<widget_pages>" . ux_export_cdata($widget_pages->option_value) . "</widget_pages>";
	}
	if($widget_uxsocialinons){
		echo "<widget_uxsocialinons>" . ux_export_cdata($widget_uxsocialinons->option_value) . "</widget_uxsocialinons>";
	}
	if($widget_tag_cloud){
		echo "<widget_tag_cloud>" . ux_export_cdata($widget_tag_cloud->option_value) . "</widget_tag_cloud>";
	}
	echo "</theme_widgets>\n";
}
add_action( 'rss2_head', 'ux_export_theme_widgets' );
?>