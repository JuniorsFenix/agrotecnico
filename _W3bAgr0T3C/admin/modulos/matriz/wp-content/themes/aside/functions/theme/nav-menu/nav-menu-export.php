<?php
//theme export theme nav menu
function ux_export_theme_mods(){
	$nav_menu_locations = get_theme_mod('nav_menu_locations');
	if($nav_menu_locations){
		foreach($nav_menu_locations as $menu_name => $menu_id){
			if($menu_id != 0){
				$menu = get_term( $menu_id, 'nav_menu' );
				echo "\t<nav_menu_locations>";
				echo "<menu_name>" . $menu_name . "</menu_name>";
				echo "<menu_slug>" . $menu->slug . "</menu_slug>";
				echo "</nav_menu_locations>\n";
			}
		}
	}
}
add_action( 'rss2_head', 'ux_export_theme_mods' );

?>