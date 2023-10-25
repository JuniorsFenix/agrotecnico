<?php
//theme export theme option
function ux_export_theme_option(){
	global $wpdb;
	$table_options = $wpdb->prefix . "options";
	/*$ux_theme_option = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_options WHERE option_name LIKE '%s'", 'ux_theme_option'));
	if($ux_theme_option){
		foreach($ux_theme_option as $option){
			echo "\t<theme_option>" . ux_export_cdata($option->option_value) . "</theme_option>\n";
		}
	}*/
	
	$theme_option = get_option('ux_theme_option');
	if($theme_option){
		echo "\t<theme_option>\n";
		foreach($theme_option as $name => $option){
			if(is_array($option)){
				$option = serialize($option);
			}
			echo "\t<" .$name. ">" . ux_export_cdata($option) . "</" .$name. ">\n";
		}
		echo "\t</theme_option>\n";
	}
}
add_action( 'rss2_head', 'ux_export_theme_option' );

//theme export theme front page
function ux_export_theme_front_page(){
	$show_on_front = get_option('show_on_front'); 
	$page_on_front = get_option('page_on_front');
	
	echo "\t<theme_front_page>";
	if($show_on_front){ echo "<show_on_front>" .$show_on_front. "</show_on_front>"; }
	if($page_on_front || $page_on_front == '0'){ echo "<page_on_front>" .$page_on_front. "</page_on_front>"; }
	echo "</theme_front_page>\n";
}
add_action( 'rss2_head', 'ux_export_theme_front_page' );

//theme export theme option icons custom
function ux_export_theme_icons_custom(){
	global $wpdb;
	$table_options = $wpdb->prefix . "options";
	$ux_theme_option = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_options WHERE option_name LIKE '%s'", 'ux_theme_option_icons_custom'));
	
	if($ux_theme_option){
		foreach($ux_theme_option as $option){
			echo "\t<theme_icons_custom>" . ux_export_cdata($option->option_value) . "</theme_icons_custom>\n";
		}
	}
}
add_action( 'rss2_head', 'ux_export_theme_icons_custom' );
?>