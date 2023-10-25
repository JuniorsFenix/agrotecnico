<?php
//theme import theme widgets
function ux_import_theme_widgets(){
	global $wpdb;
	
	if(!empty( $_POST['xml'] )){
		$file = $_POST['xml'];
	}else{
		$this_id = (int) $_POST['import_id'];
		$file = get_attached_file( $this_id );
	}
	$data_xml = simplexml_load_file($file, null, LIBXML_NOCDATA);
	
	$widgets = array(
		'sidebars_widgets'       => $data_xml->channel->sidebars_widgets,
		'widget_categories'      => $data_xml->channel->theme_widgets->widget_categories,
		'widget_text'            => $data_xml->channel->theme_widgets->widget_text,
		'widget_rss'             => $data_xml->channel->theme_widgets->widget_rss,
		'widget_search'          => $data_xml->channel->theme_widgets->widget_search,
		'widget_recent-posts'    => $data_xml->channel->theme_widgets->widget_recent_posts,
		'widget_recent-comments' => $data_xml->channel->theme_widgets->widget_recent_comments,
		'widget_archives'        => $data_xml->channel->theme_widgets->widget_archives,
		'widget_meta'            => $data_xml->channel->theme_widgets->widget_meta,
		'widget_calendar'        => $data_xml->channel->theme_widgets->widget_calendar,
		'widget_uxconatactform'  => $data_xml->channel->theme_widgets->widget_uxconatactform,
		'widget_nav_menu'        => $data_xml->channel->theme_widgets->widget_nav_menu,
		'widget_pages'           => $data_xml->channel->theme_widgets->widget_pages,
		'widget_uxsocialinons'   => $data_xml->channel->theme_widgets->widget_uxsocialinons,
		'widget_tag_cloud'       => $data_xml->channel->theme_widgets->widget_tag_cloud
	);
	
	
	foreach($widgets as $name => $value){
		delete_option($name);
		if($value != ''){
			$wpdb->insert( 
				$wpdb->options, 
				array( 
					'option_name'  => $name, 
					'option_value' => $value
				), 
				array( 
					'%s', 
					'%s'
				)
			);
		}
	}
	
}
add_action( 'import_start' , 'ux_import_theme_widgets' );

?>