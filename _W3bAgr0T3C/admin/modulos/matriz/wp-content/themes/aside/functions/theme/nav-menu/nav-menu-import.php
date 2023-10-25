<?php
//theme import nav menu cache
function ux_import_theme_menu(){
	global $wpdb;
	
	if(!empty( $_POST['xml'] )){
		$file = $_POST['xml'];
	}else{
		$this_id = (int) $_POST['import_id'];
		$file = get_attached_file( $this_id );
	}
	$data_xml = simplexml_load_file($file, null, LIBXML_NOCDATA);
	
	$get_cache = $wpdb->get_results($wpdb->prepare("
		SELECT `option_id`, `option_name`
		FROM $wpdb->options 
		WHERE `option_name` LIKE '%s'
		", '%import_cache_nav_menu_locations%'
	));
	
	if($get_cache){
		foreach($get_cache as $cache){
			delete_option($cache->option_name);
		}
	}
	
	$nav_menu = $data_xml->channel->nav_menu_locations;
	foreach($nav_menu as $menu){
		$menu_name = $menu->menu_name;
		$menu_slug = $menu->menu_slug;
		
		$wpdb->insert( 
			$wpdb->options, 
			array( 
				'option_name'  => 'import_cache_nav_menu_locations_'.$menu_name, 
				'option_value' => $menu_slug
			)
		);
	}
	
}
add_action( 'import_start' , 'ux_import_theme_menu' );

//theme import nav menu
function ux_import_theme_menu_locations(){
	global $wpdb;
	$get_cache = $wpdb->get_results($wpdb->prepare("
		SELECT `option_id`, `option_name`, `option_value`
		FROM $wpdb->options 
		WHERE `option_name` LIKE '%s'
		", '%import_cache_nav_menu_locations%'
	));
	$nav_menu_locations = get_theme_mod('nav_menu_locations');
	
	if($get_cache){
		foreach($get_cache as $nav_menu){
			$get_option = get_option($nav_menu->option_name);
			
			$get_term_by = get_term_by('slug', $get_option, 'nav_menu');
			
			$menu_name = str_replace('import_cache_nav_menu_locations_', '', $nav_menu->option_name);
			$menu_id = $get_term_by->term_id;
			
			$nav_menu_locations[$menu_name] = $menu_id;
		}
	}
	set_theme_mod('nav_menu_locations', $nav_menu_locations);
}
add_action( 'import_end' , 'ux_import_theme_menu_locations' );

//theme import nav menu anchor cache
function ux_import_nav_menu_anchor_cache(){
	global $wpdb;
	
	if(!empty( $_POST['xml'] )){
		$file = $_POST['xml'];
	}else{
		$this_id = (int) $_POST['import_id'];
		$file = get_attached_file( $this_id );
	}
	$data_xml = simplexml_load_file($file, null, LIBXML_NOCDATA);
	
	$get_cache = $wpdb->get_results($wpdb->prepare("
		SELECT `option_id`, `option_name`
		FROM $wpdb->options 
		WHERE `option_name` LIKE '%s'
		", '%import_cache_nav_menu_anchor%'
	));
	
	$get_nav_menu = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'nav_menu_item'
	));
	
	if($get_nav_menu){
		foreach($get_nav_menu as $nav_menu){
			wp_delete_post($nav_menu->ID);
		}
	}
	
	if($get_cache){
		foreach($get_cache as $cache){
			delete_option($cache->option_name);
		}
	}
	
	$item = $data_xml->channel->item;
	foreach($item as $post){
		$post_id = $post->children('wp',true)->post_id;
		$post_type = $post->children('wp',true)->post_type;
		if($post_type == 'nav_menu_item'){
			$post_title = $post->title;
			$post_date = $post->children('wp',true)->post_date;
			$menu_order = $post->children('wp',true)->menu_order;
			$postmeta = $post->children('wp',true)->postmeta;
			$nicename = false;
			
			if($postmeta){
				foreach($postmeta as $meta){
					$meta_key = $meta->children('wp',true)->meta_key;
					$meta_value = $meta->children('wp',true)->meta_value;
					if($meta_key == '_menu_item_anchor'){
						foreach($post->category->attributes() as $attributes_name => $attributes_value){
							if($attributes_name == 'nicename'){
								$nicename = $attributes_value;
							}
						}
						
						update_option(
							'import_cache_nav_menu_anchor_'.$post_id,
							array(
								'post_title' => (string) $post_title,
								'post_date' => (string) $post_date,
								'meta_value' => (string) $meta_value,
								'category' => (string) $nicename,
								'menu_order' => (int) $menu_order
							)
						);
					}
				}
			}
		}
	}
}
add_action( 'import_start' , 'ux_import_nav_menu_anchor_cache' );

//theme import nav menu anchor replace
function ux_import_nav_menu_anchor_replace(){
	global $wpdb;
	$get_nav_menu = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'nav_menu_item'
	));
	
	$get_cache = $wpdb->get_results($wpdb->prepare("
		SELECT `option_id`, `option_name`
		FROM $wpdb->options 
		WHERE `option_name` LIKE '%s'
		", '%import_cache_nav_menu_anchor%'
	));
	
	if($get_cache){
		foreach($get_cache as $cache){
			$get_option = get_option($cache->option_name);
			$get_post_title = $get_option['post_title'];
			$get_post_date = $get_option['post_date'];
			$menu_order = $get_option['menu_order'];
			$nicename = $get_option['category'];
			
			$items = wp_get_nav_menu_items($nicename);
			
			if($items){
				foreach($items as $item){
					if($item->menu_order == $menu_order){
						update_post_meta($item->ID, '_menu_item_anchor', $get_option['meta_value']);
					}
				}
			}
		}
	}
}
add_action( 'import_end' , 'ux_import_nav_menu_anchor_replace' );
?>