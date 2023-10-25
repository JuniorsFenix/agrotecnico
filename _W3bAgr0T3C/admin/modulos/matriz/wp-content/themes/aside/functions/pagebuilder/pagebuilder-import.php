<?php
//theme import module set taxonomy
if(!function_exists('ux_import_module_set_taxonomy')){
	function ux_import_module_set_taxonomy(){
		$get_posts = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'modules'
		));
		
		foreach($get_posts as $post){
			$module_carousel_category     = get_post_meta($post->ID, 'module_carousel_category', true);
			$module_blog_category         = get_post_meta($post->ID, 'module_blog_category', true);
			$module_gallery_category      = get_post_meta($post->ID, 'module_gallery_category', true);
			$module_latestpost_category   = get_post_meta($post->ID, 'module_latestpost_category', true);
			$module_liquidlist_category   = get_post_meta($post->ID, 'module_liquidlist_category', true);
			$module_portfolio_category    = get_post_meta($post->ID, 'module_portfolio_category', true);
			$module_slider_category       = get_post_meta($post->ID, 'module_slider_category', true);
			$module_client_category       = get_post_meta($post->ID, 'module_client_category', true);
			$module_faq_category          = get_post_meta($post->ID, 'module_faq_category', true);
			$module_jobs_category         = get_post_meta($post->ID, 'module_jobs_category', true);
			$module_team_category         = get_post_meta($post->ID, 'module_team_category', true);
			$module_testimonials_category = get_post_meta($post->ID, 'module_testimonials_category', true);
			
			if($module_carousel_category){
				$category_id = ux_import_taxonomy_replace('category', $module_carousel_category);
				update_post_meta($post->ID, 'module_carousel_category', $category_id);
			}
			
			if($module_blog_category){
				$category_id = ux_import_taxonomy_replace('category', $module_blog_category);
				update_post_meta($post->ID, 'module_blog_category', $category_id);
			}
			
			if($module_gallery_category){
				$category_id = ux_import_taxonomy_replace('category', $module_gallery_category);
				update_post_meta($post->ID, 'module_gallery_category', $category_id);
			}
			
			if($module_latestpost_category){
				$category_id = ux_import_taxonomy_replace('category', $module_latestpost_category);
				update_post_meta($post->ID, 'module_latestpost_category', $category_id);
			}
			
			if($module_liquidlist_category){
				$category_id = ux_import_taxonomy_replace('category', $module_liquidlist_category);
				update_post_meta($post->ID, 'module_liquidlist_category', $category_id);
			}
			
			if($module_portfolio_category){
				$category_id = ux_import_taxonomy_replace('category', $module_portfolio_category);
				update_post_meta($post->ID, 'module_portfolio_category', $category_id);
			}
			
			if($module_client_category){
				$category_id = ux_import_taxonomy_replace('client_cat', $module_client_category);
				update_post_meta($post->ID, 'module_client_category', $category_id);
			}
			
			if($module_faq_category){
				$category_id = ux_import_taxonomy_replace('question_cat', $module_faq_category);
				update_post_meta($post->ID, 'module_faq_category', $category_id);
			}
			
			if($module_jobs_category){
				$category_id = ux_import_taxonomy_replace('job_cat', $module_jobs_category);
				update_post_meta($post->ID, 'module_jobs_category', $category_id);
			}
			
			if($module_team_category){
				$category_id = ux_import_taxonomy_replace('team_cat', $module_team_category);
				update_post_meta($post->ID, 'module_team_category', $category_id);
			}
			
			if($module_testimonials_category){
				$category_id = ux_import_taxonomy_replace('testimonial_cat', $module_testimonials_category);
				update_post_meta($post->ID, 'module_testimonials_category', $category_id);
			}
		}
	}
	add_action( 'import_end' , 'ux_import_module_set_taxonomy' );
}

//theme import module layerslider
if(!function_exists('ux_import_module_layerslider')){
	function ux_import_module_layerslider(){
		global $wpdb;
		$db_query = $wpdb->prepare("
			SELECT `post_id`, `meta_key`
			FROM $wpdb->postmeta
			WHERE `meta_value` LIKE '%s'
			", '%layerslider%'
		);
		$get_module_layerslider = $wpdb->get_results($db_query);
		
		if($get_module_layerslider){
			foreach($get_module_layerslider as $module_layerslider){
				$post = get_post($module_layerslider->post_id);
				switch($post->post_type){
					case 'modules':
						$get_post_meta = get_post_meta($module_layerslider->post_id, 'module_slider_layerslider', true);
						$new_id = get_option('import_cache_layerslider_' . $get_post_meta);
						update_post_meta($module_layerslider->post_id, 'module_slider_layerslider', $new_id);
					break;
				}
			}
		}
	}
	add_action( 'import_end' , 'ux_import_module_layerslider' );
}

//theme import set module
if(!function_exists('ux_import_set_modules')){
	function ux_import_set_modules(){
		global $wpdb;
		
		//module image box / single image
		$db_query_image = $wpdb->prepare("
			SELECT 
			`$wpdb->postmeta`.`post_id` as 'ID',
			`$wpdb->postmeta`.`meta_key` as 'meta_key',
			`$wpdb->postmeta`.`meta_value` as 'meta_value',
			`$wpdb->posts`.`post_type` as 'post_type'
			
			FROM $wpdb->postmeta, $wpdb->posts
			
			WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
			AND (`$wpdb->posts`.`post_type` = '%s')
			AND (`meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'))
			", 'modules', 'module_singleimage_image', 'module_imagebox_image', 'module_fullwidth_background_image', 'module_fullwidth_alt_image', 'module_video_cover', 'module_googlemap_pin_custom'
		);
		$get_module_image = $wpdb->get_results($db_query_image);
		
		if($get_module_image){
			foreach($get_module_image as $module_image){
				$image_url = $module_image->meta_value;
				$post_id = $module_image->ID;
				$post_type = get_post($post_id)->post_type;
				$attachment_url = ux_import_attachment_replace('url', $image_url);
				update_post_meta($post_id, $module_image->meta_key, $attachment_url);
			}
		}
		
		//module gallery library
		$db_query_gallery = $wpdb->prepare("
			SELECT 
			`$wpdb->postmeta`.`post_id` as 'ID',
			`$wpdb->postmeta`.`meta_key` as 'meta_key',
			`$wpdb->postmeta`.`meta_value` as 'meta_value',
			`$wpdb->posts`.`post_type` as 'post_type'
			
			FROM $wpdb->postmeta, $wpdb->posts
			
			WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
			AND (`$wpdb->posts`.`post_type` = '%s')
			AND (`meta_key` LIKE '%s'))
			", 'modules', 'module_gallery_library'
		);
		$get_module_gallery = $wpdb->get_results($db_query_gallery);
		
		if($get_module_gallery){
			foreach($get_module_gallery as $gallery){
				$post_id = $gallery->ID;
				$get_post_meta = get_post_meta($post_id, 'module_gallery_library', true);
				if($get_post_meta){
					if(is_array($get_post_meta)){
						foreach($get_post_meta as $num => $image){
							$attachment_id = ux_import_attachment_replace('id', $image);
							$get_post_meta[$num] = $attachment_id;
						}
					}else{
						$attachment_id = ux_import_attachment_replace('id', $image);
						$get_post_meta = $attachment_id;
					}
					update_post_meta($post_id, 'module_gallery_library', $get_post_meta);
				}
			}
		}
	}
	add_action( 'import_end' , 'ux_import_set_modules' );
}

//theme import process module
if(!function_exists('ux_import_process_modules_demo_images')){
	function ux_import_process_modules_demo_images(){
		global $wpdb;
		
		$demo_attachment = get_option('ux_theme_demo_attachment');
		if($demo_attachment){
		
			//module image box / single image
			$db_query_image = $wpdb->prepare("
				SELECT 
				`$wpdb->postmeta`.`post_id` as 'ID',
				`$wpdb->postmeta`.`meta_key` as 'meta_key',
				`$wpdb->postmeta`.`meta_value` as 'meta_value',
				`$wpdb->posts`.`post_type` as 'post_type'
				
				FROM $wpdb->postmeta, $wpdb->posts
				
				WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
				AND (`$wpdb->posts`.`post_type` = '%s')
				AND (`meta_key` LIKE '%s'
				  OR `meta_key` LIKE '%s'
				  OR `meta_key` LIKE '%s'
				  OR `meta_key` LIKE '%s'
				  OR `meta_key` LIKE '%s'
				  OR `meta_key` LIKE '%s'))
				", 'modules', 'module_singleimage_image', 'module_imagebox_image', 'module_fullwidth_background_image', 'module_fullwidth_alt_image', 'module_video_cover', 'module_googlemap_pin_custom'
			);
			$get_module_image = $wpdb->get_results($db_query_image);
			
			if($get_module_image){
				foreach($get_module_image as $module_image){
					$image_url = $module_image->meta_value;
					$post_id = $module_image->ID;
					$post_type = get_post($post_id)->post_type;
					$attachment_url = wp_get_attachment_image_src($demo_attachment, 'full');
					update_post_meta($post_id, $module_image->meta_key, $attachment_url[0]);
				}
			}
			
			//module gallery library
			$db_query_gallery = $wpdb->prepare("
				SELECT 
				`$wpdb->postmeta`.`post_id` as 'ID',
				`$wpdb->postmeta`.`meta_key` as 'meta_key',
				`$wpdb->postmeta`.`meta_value` as 'meta_value',
				`$wpdb->posts`.`post_type` as 'post_type'
				
				FROM $wpdb->postmeta, $wpdb->posts
				
				WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
				AND (`$wpdb->posts`.`post_type` = '%s')
				AND (`meta_key` LIKE '%s'))
				", 'modules', 'module_gallery_library'
			);
			$get_module_gallery = $wpdb->get_results($db_query_gallery);
			
			if($get_module_gallery){
				foreach($get_module_gallery as $gallery){
					$post_id = $gallery->ID;
					$get_post_meta = get_post_meta($post_id, 'module_gallery_library', true);
					if($get_post_meta){
						if(is_array($get_post_meta)){
							foreach($get_post_meta as $num => $image){
								$get_post_meta[$num] = $demo_attachment;
							}
						}else{
							$get_post_meta = $demo_attachment;
						}
						update_post_meta($post_id, 'module_gallery_library', $get_post_meta);
					}
				}
			}
		}
	}
	add_action('ux_theme_process_demo_images_ajax', 'ux_import_process_modules_demo_images');
}
?>