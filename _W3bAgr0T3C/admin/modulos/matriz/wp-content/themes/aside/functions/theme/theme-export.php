<?php
//theme export CDATA
function ux_export_cdata( $str ) {
	if ( seems_utf8( $str ) == false )
		$str = utf8_encode( $str );

	// $str = ent2ncr(esc_html($str));
	$str = '<![CDATA[' . str_replace( ']]>', ']]]]><![CDATA[>', $str ) . ']]>';

	return $str;
}

//theme export layerslider
function ux_export_layerslider(){
	global $wpdb;
	$table_layerslider = $wpdb->prefix . "layerslider";
	$sql = "CREATE TABLE $table_layerslider (
			  id int(10) NOT NULL AUTO_INCREMENT,
			  name varchar(100) NOT NULL,
			  data mediumtext NOT NULL,
			  date_c int(10) NOT NULL,
			  date_m int(11) NOT NULL,
			  flag_hidden tinyint(1) NOT NULL DEFAULT 0,
			  flag_deleted tinyint(1) NOT NULL DEFAULT 0,
			  PRIMARY KEY  (id)
			);";
	
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	
	$get_layerslider = $wpdb->get_results("SELECT * FROM $table_layerslider");
	
	if($get_layerslider){
		if(count($get_layerslider) > 0){
			foreach($get_layerslider as $layerslider){
				echo "\t<layerslider>";
				echo "<id>" . $layerslider->id . "</id>";
				echo "<name>" . $layerslider->name . "</name>";
				echo "<data>" . ux_export_cdata($layerslider->data) . "</data>";
				echo "<date_c>" . $layerslider->date_c . "</date_c>";
				echo "<date_m>" . $layerslider->date_m . "</date_m>";
				echo "<flag_hidden>" . $layerslider->flag_hidden . "</flag_hidden>";
				echo "<flag_deleted>" . $layerslider->flag_deleted . "</flag_deleted>";
				echo "</layerslider>\n";
				
			}
		}
	}
}
add_action('rss2_head', 'ux_export_layerslider');

//require nav-menu export
require_once get_template_directory() . '/functions/theme/options/options-export.php';

//require nav-menu export
require_once get_template_directory() . '/functions/theme/nav-menu/nav-menu-export.php';

//require widget export
require_once get_template_directory() . '/functions/theme/widget/widget-export.php';

?>