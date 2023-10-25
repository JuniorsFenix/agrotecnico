<?php
//theme import themeoption
function ux_import_theme_option(){
	global $wpdb;
	
	if(!empty( $_POST['xml'] )){
		$file = $_POST['xml'];
	}else{
		$this_id = (int) $_POST['import_id'];
		$file = get_attached_file( $this_id );
	}
	$data_xml = simplexml_load_file($file, null, LIBXML_NOCDATA);
	
	delete_option('ux_theme_option');
	
	$theme_option = $data_xml->channel->theme_option;
	if($theme_option){
		$ux_theme_option = array();
		foreach($theme_option->children() as $name => $option){
			if(is_serialized((string) $option)){
				$ux_theme_option[$name] = maybe_unserialize((string) $option);
			}else{
				$ux_theme_option[$name] = (string) $option;
			}
		}
		update_option('ux_theme_option', $ux_theme_option);
		
		/*$wpdb->insert( 
			$wpdb->options, 
			array( 
				'option_name'  => 'ux_theme_option', 
				'option_value' => (string) $theme_option
			)
		);*/
	}
}
add_action( 'import_start' , 'ux_import_theme_option' );

//theme import theme option icons custom
function ux_import_theme_icons_custom(){
	global $wpdb;
	
	if(!empty( $_POST['xml'] )){
		$file = $_POST['xml'];
	}else{
		$this_id = (int) $_POST['import_id'];
		$file = get_attached_file( $this_id );
	}
	$data_xml = simplexml_load_file($file, null, LIBXML_NOCDATA);
	
	$theme_icons_custom = $data_xml->channel->theme_icons_custom;
	
	if($theme_icons_custom){
		$theme_icons_custom = json_decode(json_encode($theme_icons_custom), true);
		$theme_icons_custom = maybe_unserialize($theme_icons_custom[0]);
		update_option('ux_theme_option_icons_custom', $theme_icons_custom);
	
		/*$wpdb->insert( 
			$wpdb->options, 
			array( 
				'option_name'  => 'ux_theme_option_icons_custom', 
				'option_value' => $theme_icons_custom
			)
		);*/
	
	}
}
add_action( 'import_start', 'ux_export_theme_icons_custom' );

//theme import front cache
function ux_import_front_cache(){
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
		", '%import_cache_front%'
	));
	
	if($get_cache){
		foreach($get_cache as $cache){
			delete_option($cache->option_name);
		}
	}
	
	$post_title = false;
	$post_date = false;
	$item = $data_xml->channel->item;
	$show_on_front = $data_xml->channel->theme_front_page->show_on_front;
	$page_on_front = $data_xml->channel->theme_front_page->page_on_front;
	foreach($item as $post){
		$post_id = $post->children('wp',true)->post_id;
		if((int) $post_id == (int) $page_on_front){
			$post_title = $post->title;
			$post_date = $post->children('wp',true)->post_date;
		}
	}
	
	$wpdb->insert( 
		$wpdb->options, 
		array( 
			'option_name'  => 'import_cache_front_post_title', 
			'option_value' => $post_title
		),
		array(
			'%s',
			'%s'
		)
	);
	$wpdb->insert( 
		$wpdb->options, 
		array( 
			'option_name'  => 'import_cache_front_post_date', 
			'option_value' => $post_date
		),
		array(
			'%s',
			'%s'
		)
	);
	$wpdb->insert( 
		$wpdb->options, 
		array( 
			'option_name'  => 'import_cache_front_show_on', 
			'option_value' => $show_on_front
		),
		array(
			'%s',
			'%s'
		)
	);
	
	
}
add_action( 'import_start' , 'ux_import_front_cache' );

//theme import set front
function ux_import_set_front(){
	$get_posts = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'any'
	));
	
	$cache_post_title = get_option('import_cache_front_post_title');
	$cache_post_date = get_option('import_cache_front_post_date');
	$cache_show_on = get_option('import_cache_front_show_on');
	
	if($cache_show_on == ''){
		update_option('show_on_front', 'page'); 
	}else{
		update_option('show_on_front', $cache_show_on); 
	}
	if($cache_post_date != ''){
		foreach($get_posts as $post){
			if($post->post_date == $cache_post_date && $post->post_title == $cache_post_title){
				update_option('page_on_front', $post->ID); 
			}
		}
	}else{
		update_option('page_on_front', 0); 
	}
}
add_action( 'import_end' , 'ux_import_set_front' );

//theme import icons custom
function ux_import_set_icons_custom(){
	$get_icons_custom = get_option('ux_theme_option_icons_custom');
	$demo_attachment = get_option('ux_theme_demo_attachment');
	
	if($get_icons_custom){
		foreach($get_icons_custom as $num => $icon){
			$attachment_id = ux_import_attachment_replace('id', $icon);
			
			if(isset($_POST['action'])){
				if($_POST['action'] == 'ux_theme_process_demo_images_ajax'){
					$attachment_id = $demo_attachment;
				}
			}
			$get_icons_custom[$num] = $attachment_id;
		}
		update_option('ux_theme_option_icons_custom', $get_icons_custom); 
	}
}
add_action( 'import_end' , 'ux_import_set_icons_custom' );

//theme import social icons
function ux_import_set_social_icons(){
	$get_option = get_option('ux_theme_option');
	$get_value = isset($get_option['theme_option_show_social_medias']) ? $get_option['theme_option_show_social_medias'] : false;
	
	if($get_value && isset($get_value['icontype'])){
		$icon_type = $get_value['icontype'];
		foreach($icon_type as $num => $type){
			$icon = $get_value['icon'][$num];
			
			$attachment_id = ux_import_attachment_replace('url', $icon);
			$get_option['theme_option_show_social_medias']['icon'][$num] = $attachment_id;
		}
		update_option('ux_theme_option', $get_option); 
	}
}
?>