<?php
//theme import taxonomy cache
function ux_import_taxonomy_cache(){
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
		", '%import_cache_taxonomy%'
	));
	
	if($get_cache){
		foreach($get_cache as $cache){
			delete_option($cache->option_name);
		}
	}
	
	//category
	$category = $data_xml->channel->children('wp',true)->category;
	foreach($category as $cat){
		$term_id = $cat->children('wp',true)->term_id;
		$category_nicename = $cat->children('wp',true)->category_nicename;
		$cat_name = $cat->children('wp',true)->cat_name;
		
		update_option(
			'import_cache_taxonomy_category_'.$term_id,
			array(
				'category_nicename' => (string) $category_nicename,
				'cat_name' => (string) $cat_name
			)
		);
	}
	
	//taxonomy
	$taxonomy = $data_xml->channel->children('wp',true)->term;
	foreach($taxonomy as $tax){
		$term_id = $tax->children('wp',true)->term_id;
		$term_name = $tax->children('wp',true)->term_name;
		$term_slug = $tax->children('wp',true)->term_slug;
		$term_taxonomy = $tax->children('wp',true)->term_taxonomy;
		
		update_option(
			'import_cache_taxonomy_' . $term_taxonomy . '_' . $term_id,
			array(
				'category_nicename' => (string) $term_slug,
				'cat_name' => (string) $term_name
			)
		);
	}
}
add_action( 'import_start' , 'ux_import_taxonomy_cache' );

//theme import taxonomy replace
function ux_import_taxonomy_replace($taxonomy, $val){
	$post_type = 'post';
	
	switch($taxonomy){
		case 'client_cat':      $post_type = 'clients'; break;
		case 'question_cat':    $post_type = 'faqs'; break;
		case 'job_cat':         $post_type = 'jobs'; break;
		case 'team_cat':        $post_type = 'team'; break;
		case 'testimonial_cat': $post_type = 'testimonials'; break;
	}
	
	$categories = get_categories(array(
		'type' => $post_type,
		'hide_empty' => 0,
		'taxonomy' => $taxonomy
	));
	
	if($categories){
		foreach($categories as $category){
			$term_id = $category->term_id;
			$category_nicename = $category->category_nicename;
			$cat_name = $category->cat_name;
			
			$get_option = get_option('import_cache_taxonomy_' . $taxonomy . '_' . $val);
			if($get_option){
				$get_category_nicename = $get_option['category_nicename'];
				$get_cat_name = $get_option['cat_name'];
				if($get_category_nicename == $category_nicename && $get_cat_name == $cat_name){
					$val = $term_id;
				}
			}
		}
	}
	
	return $val;
}

//theme import attachment cache
function ux_import_attachment_cache(){
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
		", '%import_cache_attachment%'
	));
	
	if($get_cache){
		foreach($get_cache as $cache){
			delete_option($cache->option_name);
		}
	}
	
	$item = $data_xml->channel->item;
	foreach($item as $post){
		$post_id = $post->children('wp',true)->post_id;
		$post_type = $post->children('wp',true)->post_type;
		if($post_type == 'attachment'){
			$post_title = $post->title;
			$post_date = $post->children('wp',true)->post_date;
			$attachment_url = $post->children('wp',true)->attachment_url;
			$attachment_path = pathinfo((string) $attachment_url);
			
			update_option(
				'import_cache_attachment_'.$post_id,
				array(
					'post_title' => (string) $post_title,
					'post_date' => (string) $post_date,
					'attachment_url' => (string) $attachment_url,
					'filename' => $attachment_path['filename'],
					'dirname' => $attachment_path['dirname']
				)
			);
		}
	}
}
add_action( 'import_start' , 'ux_import_attachment_cache' );

//theme import attachment replace
function ux_import_attachment_replace($key, $val){
	global $wpdb;
	$get_attachment = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'attachment'
	));
	
	$import_cache_attachment = false;
	switch($key){
		case 'url':
			$get_attachment_cache = $wpdb->get_row($wpdb->prepare("
				SELECT `option_name` FROM $wpdb->options 
				WHERE `option_value` LIKE '%s'
			", '%' .like_escape($val). '%'));
			if($get_attachment_cache){
				$import_cache_attachment = get_option($get_attachment_cache->option_name);
			}
		break;
		
		case 'id':
			$import_cache_attachment = get_option('import_cache_attachment_' . $val);
		break;
	}
	
	if($import_cache_attachment){
		$import_post_title = $import_cache_attachment['post_title'];
		$import_post_date = $import_cache_attachment['post_date'];
		foreach($get_attachment as $attachment){
			if($attachment->post_date == $import_post_date && $attachment->post_title == $import_post_title){
				$attachment_image_src = wp_get_attachment_image_src($attachment->ID, 'full');
				$val = $key == 'url' ? $attachment_image_src[0] : $attachment->ID;
			}
		}
	} 
	
	return $val;
}

//theme import layerslider
function ux_import_layerslider(){
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
		", '%import_cache_layerslider%'
	));
	
	if($get_cache){
		foreach($get_cache as $cache){
			delete_option($cache->option_name);
		}
	}
	
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
	
	$layerslider = $data_xml->channel->layerslider;
	foreach($layerslider as $slider){
		$id           = $slider->id;
		$name         = $slider->name;
		$data         = $slider->data;
		$date_c       = $slider->date_c;
		$date_m       = $slider->date_m;
		$flag_hidden  = $slider->flag_hidden;
		$flag_deleted = $slider->flag_deleted;
		
		$slider_row = $wpdb->get_row($wpdb->prepare("
			SELECT * FROM $table_layerslider
			WHERE date_c = %s 
			AND name = %s
			",
			$date_c,
			$name
		));
		
		if(!$slider_row){
			$wpdb->insert( 
				$table_layerslider, 
				array( 
					'name'         => $name, 
					'data'         => $data, 
					'date_c'       => $date_c,
					'date_m'       => $date_m, 
					'flag_hidden'  => $flag_hidden, 
					'flag_deleted' => $flag_deleted 
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s'
				)
			);
			
			$new_id = $wpdb->insert_id;
		}else{
			$new_id = $slider_row->id;
		}
		
		$wpdb->insert( 
			$wpdb->options, 
			array( 
				'option_name'  => 'import_cache_layerslider_'.$id, 
				'option_value' => $new_id
			),
			array(
				'%s',
				'%s'
			)
		);
	}
}
add_action( 'import_start' , 'ux_import_layerslider' );

//theme import layerslider for post
function ux_import_post_layerslider(){
	global $wpdb;
	$get_module_layerslider = $wpdb->get_results($wpdb->prepare("
		SELECT `post_id`, `meta_key`
		FROM $wpdb->postmeta 
		WHERE `meta_value` LIKE '%s'
		", '%layerslider%'
	));
	
	if($get_module_layerslider){
		foreach($get_module_layerslider as $module_layerslider){
			$post = get_post($module_layerslider->post_id);
			switch($post->post_type){
				case 'post':
					$get_post_meta = get_post_meta($module_layerslider->post_id, 'ux_theme_meta', true);
					foreach($get_post_meta as $name => $value){
						if($name == 'theme_meta_title_bar_slider_value'){
							$new_id = get_option('import_cache_layerslider_' . $value);;
							$get_post_meta['theme_meta_title_bar_slider_value'] = $new_id;
						}
					}
					update_post_meta($module_layerslider->post_id, 'ux_theme_meta', $get_post_meta);
				break;
			}
		}
	}
}
add_action( 'import_end' , 'ux_import_post_layerslider' );

//theme import ajax
function ux_theme_import_ajax(){
	// Load Importer API
	require_once ABSPATH . 'wp-admin/includes/import.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	
	if(!class_exists('WP_Importer')){
		$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		if(file_exists($class_wp_importer)){
			require $class_wp_importer;
		}
	}
	
	if(!class_exists('WXR_Parser')){
		// include WXR file parsers
		require get_template_directory() . '/functions/theme/wordpress-importer/parsers.php';
	}
	
	if(!class_exists('WP_Import')){
		require_once get_template_directory() . '/functions/class/class-ux-importer.php';
	}
	
	$ux_import = new WP_Import();
	$ux_import->fetch_attachments = (!empty($_POST['fetch_attachments']) && $ux_import->allow_fetch_attachments());
	$ux_import->import($_POST['xml']);
	
	$url =  UX_THEME . '/images/import-demo/demo-img.jpg';
	$parts = pathinfo( $url );
	$file_name = $parts['basename'];
	$t = date('Y-m-d G:i:s');
	$post = array(
		'upload_date' => $t,
		'guid' => ''
	);
	$upload = $ux_import->fetch_remote_file($url, $post);
	$wp_filetype = wp_check_filetype($upload['file']);
	
	$attachment = array(
		'guid' => $upload['url'], 
		'post_mime_type' => $wp_filetype['type'],
		'post_title' => $file_name,
		'post_content' => '',
		'post_status' => 'inherit',
		'upload_date' => $t
	);
	
	$attach_id = wp_insert_attachment($attachment, $upload['file']);
	wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $upload['file']));
	
	if($attach_id){
		update_option('ux_theme_demo_attachment', $attach_id);
	}
	
	die('');
}
add_action('wp_ajax_ux_theme_import_ajax', 'ux_theme_import_ajax');

//theme import process demo images
function ux_theme_process_demo_images_ajax(){
	global $wpdb;
	
	$demo_attachment = get_option('ux_theme_demo_attachment');
	if($demo_attachment){
		
		//featured image
		$get_post = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => array('post', 'page', 'team', 'clients', 'testimonials', 'jobs', 'faqs')
		));
		
		if($get_post){
			foreach($get_post as $post){
				$_thumbnail_id = get_post_meta($post->ID, '_thumbnail_id', true);
				if($_thumbnail_id){
					update_post_meta($post->ID, '_thumbnail_id', $demo_attachment);
				}
			}
		}
		
		//gallery format library
		$get_post = $wpdb->get_results($wpdb->prepare("
			SELECT 
			`$wpdb->postmeta`.`post_id` as 'ID',
			`$wpdb->postmeta`.`meta_key` as 'meta_key',
			`$wpdb->postmeta`.`meta_value` as 'meta_value',
			`$wpdb->posts`.`post_type` as 'post_type'
			
			FROM $wpdb->postmeta, $wpdb->posts
			
			WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
			AND (`$wpdb->posts`.`post_type` = '%s')
			AND (`meta_key` LIKE '%s')
			AND (`meta_value` LIKE '%s'))
			", 'post', 'ux_theme_meta', '%theme_meta_portfolio%'
		));
		
		if($get_post){
			foreach($get_post as $post){
				$post_id = $post->ID;
				$get_post_meta = get_post_meta($post_id, 'ux_theme_meta', true);
				if($get_post_meta){
					foreach($get_post_meta as $meta_key => $meta_value){
						if($meta_key == 'theme_meta_portfolio'){
							if(is_array($meta_value)){
								foreach($meta_value as $num => $image){
									$get_post_meta['theme_meta_portfolio'][$num] = $demo_attachment;
								}
							}
						}
					}
					update_post_meta($post_id, 'ux_theme_meta', $get_post_meta);
				}
			}
		}
	}
	
	do_action('ux_theme_process_demo_images_ajax');
}
add_action('wp_ajax_ux_theme_process_demo_images_ajax', 'ux_theme_process_demo_images_ajax');

//theme import post cache
function ux_import_post_cache(){
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
		", '%import_cache_post_s%'
	));
	
	if($get_cache){
		foreach($get_cache as $cache){
			delete_option($cache->option_name);
		}
	}
	
	$item = $data_xml->channel->item;
	foreach($item as $post){
		$post_id = $post->children('wp',true)->post_id;
		$post_type = $post->children('wp',true)->post_type;
		if($post_type == 'post'){
			$post_title = $post->title;
			$post_date = $post->children('wp',true)->post_date;
			
			update_option(
				'import_cache_post_s_'.$post_id,
				array(
					'post_title' => (string) $post_title,
					'post_date' => (string) $post_date
				)
			);
		}
	}
}
add_action( 'import_start' , 'ux_import_post_cache' );

//require widget import
require_once get_template_directory() . '/functions/theme/widget/widget-import.php';

//require post import
require_once get_template_directory() . '/functions/theme/post/post-import.php';

//require options import
require_once get_template_directory() . '/functions/theme/options/options-import.php';

//require nav menu import
require_once get_template_directory() . '/functions/theme/nav-menu/nav-menu-import.php';
?>