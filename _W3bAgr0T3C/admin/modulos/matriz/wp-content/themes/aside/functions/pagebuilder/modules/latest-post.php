<?php
//latest post template
function ux_pb_module_latestpost($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		global $post;
		
		//latest post confing
		$layout            = get_post_meta($module_post, 'module_latestpost_layout', true);
		$posttype          = get_post_meta($module_post, 'module_latestpost_posttype', true);
		$number            = get_post_meta($module_post, 'module_latestpost_number', true);
		$ratio             = get_post_meta($module_post, 'module_latestpost_ratio', true);
		$size              = get_post_meta($module_post, 'module_latestpost_size', true);
		//$showfunction      = get_post_meta($module_post, 'module_latestpost_showfunction', true);
		$tags      = get_post_meta($module_post, 'module_latestpost_tags', true);
		$align             = get_post_meta($module_post, 'module_latestpost_align', true);
		$category          = get_post_meta($module_post, 'module_latestpost_category', true);
		$orderby           = get_post_meta($module_post, 'module_select_orderby', true);
		$order             = get_post_meta($module_post, 'module_select_order', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		
		$per_page          = $number ? $number : -1;
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, 'latest-post') : false;
		
		$showtype = array();
		if($posttype){
			if(is_array($posttype)){
				$showtype = $posttype;
			}else{
				array_push($showtype, $posttype);
			}
		}
		
		switch($ratio){
			case 'landscape': $image_ratio = 'image-thumb'; break;
			case 'square': $image_ratio = 'image-thumb-1'; break;
			case 'auto': $image_ratio = 'standard-thumb'; break;
		}
		$image_ratio = $image_ratio ? $image_ratio : 'image-thumb';
		
		/*$function = array();
		if($showfunction){
			if(is_array($showfunction)){
				$function = $showfunction;
			}else{
				array_push($function, $showfunction);
			}
		}*/
		
		$text_align = 'text-left';
		if($align){
			switch($align){
				case 'center': $text_align = 'text-center'; break;
			}
		}
		
		$post_format = false;
		$post_operator = false;
		if($showtype){
			$post_format = array();
			$post_format_date = array(
				'post-format-aside',
				'post-format-chat',
				'post-format-gallery',
				'post-format-link',
				'post-format-image',
				'post-format-quote',
				'post-format-status',
				'post-format-video',
				'post-format-audio'
			);
			foreach($showtype as $post_type){
				switch($post_type){
					case 'image': array_push($post_format, 'post-format-image'); break;
					case 'portfolio': array_push($post_format, 'post-format-gallery'); break;
					case 'audio': array_push($post_format, 'post-format-audio'); break;
					case 'video': array_push($post_format, 'post-format-video'); break;
				}
			}
			if(in_array("standard", $showtype)){
				$post_operator = 'NOT IN';
				foreach($post_format as $delete_format){
					foreach($post_format_date as $key => $format_string){
						if($delete_format == $format_string) unset($post_format_date[$key]);
					}
				}
				$post_format = $post_format_date;
			}else{
				$post_operator = 'IN';
			}
		}
		
		$thumbnail_compare = $layout == 'grid' ? array(
			'relation' => 'AND',
			array(
				'key' => '_thumbnail_id',
				'compare' => 'EXISTS'
			)
		) : false;
		
		$get_posts = get_posts(array(
			'posts_per_page' => $per_page,
			'orderby'        => $orderby,
			'order'          => $order,
			'cat'            => $category,
			'tax_query'      => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => $post_format,
					'operator' => $post_operator
				)
			),
			'meta_query' => $thumbnail_compare
		));		
		switch($layout){
			case 'grid': ?>
				<a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
                <div class="container-isotope clear" data-post="<?php echo $itemid; ?>">
                    <div class="isotope masonry" data-space="20px" style="margin: -20px 0px 0px -20px;" data-size="<?php echo $size; ?>">
						<?php foreach($get_posts as $post){ setup_postdata( $post );
                            $thumb_src_full = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
							
							$bg_color = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
							$bg_color = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default'; ?>
                            <div class="width2 isotope-item container3d <?php echo $animation_style; ?>">
                                <div class="inside" style="padding:20px 0 0 20px">
                                    
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php echo get_the_post_thumbnail(get_the_ID(), $image_ratio, array('title' => get_the_title(get_post_thumbnail_id()))); ?>
                                    </a>
                                    
                                    <?php //if(count($function)){
										 ?>
                                            <div class="latest-posts-tit-wrap">
                                                <h2 class="latest-posts-tit <?php echo $text_align; ?>">
                                                	<a class="latest-posts-tit-a" href="<?php the_permalink(); ?>"><span class="latest-posts-tit-a-inn"><?php the_title(); ?></span></a>
													<?php  //if(in_array("read_more_button", $function)){ 
														if ( $tags == 'on') { ?>
													<div class="latest-posts-tags"><?php the_tags('', '  '); ?></div>
													<?php } ?>
                                                </h2>
                                            </div>
                                           
										
										<?php
									//} ?>
                                </div>
                            </div>
                        <?php }
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php
			break;
			
			case 'vertical_list': ?>
                <div class="latest-posts-verticallist">
					<?php foreach($get_posts as $post){ setup_postdata( $post );
                        $thumb_src_full = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
                        <section class="posts-verticallist-item clearfix <?php echo $animation_style; ?>">
                            <?php if(has_post_thumbnail()){ ?>
                                <div class="posts-verticallist-img">
                                    <a class="lightbox" href="<?php echo $thumb_src_full[0]; ?>"><?php echo get_the_post_thumbnail(get_the_ID(), $image_ratio, array('title' => get_the_title(get_post_thumbnail_id()))); ?></a>
                                </div><!--End posts-verticallist-img-->
                            <?php } ?>
                            <div class="posts-verticallist-main">
                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <p class="posts-verticallist-meta"><i class="fa fa-calendar"></i><?php the_time('F j, Y'); ?></p>
                            </div><!--End posts-verticallist-main-->
                        </section>
                    <?php }
                    wp_reset_postdata(); ?>
                </div>
            <?php
			break;
		}
	}
}
add_action('ux-pb-module-template-latest-post', 'ux_pb_module_latestpost');

//latest post select fields
function ux_pb_module_latestpost_select($fields){
	$fields['module_latestpost_layout'] = array(
		array('title' => __('Grid','ux'), 'value' => 'grid'),
		array('title' => __('Vertical List','ux'), 'value' => 'vertical_list')
	);
	
	$fields['module_latestpost_posttype'] = array(
		array('title' => __('Standard', 'ux'), 'value' => 'standard'),
		array('title' => __('Image', 'ux'), 'value' => 'image'),
		array('title' => __('Portfolio', 'ux'), 'value' => 'portfolio'),
		array('title' => __('Video', 'ux'), 'value' => 'video'),
		array('title' => __('Audio', 'ux'), 'value' => 'audio')
	);
	
	$fields['module_latestpost_ratio'] = array(
		array('title' => '3:2(Grid)', 'value' => 'landscape'),
		array('title' => '1:1(Grid)', 'value' => 'square'),
		array('title' => __('Auto Ratio(Masonry)', 'ux'), 'value' => 'auto')
	);
	
	$fields['module_latestpost_size'] = array(
		array('title' => __('Medium', 'ux'), 'value' => 'medium'),
		array('title' => __('Large', 'ux'), 'value' => 'large'),
		array('title' => __('Small', 'ux'), 'value' => 'small')
	);
	
	//$fields['module_latestpost_showfunction'] = array(
	//	array('title' => __('Title', 'ux'), 'value' => 'title'),
	//	array('title' => __('Read More Button', 'ux'), 'value' => 'read_more_button')
	//);
	
	$fields['module_latestpost_align'] = array(
		array('title' => __('Left', 'ux'), 'value' => 'left'),
		array('title' => __('Center', 'ux'), 'value' => 'center')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_latestpost_select');

//latest post config fields
function ux_pb_module_latestpost_fields($module_fields){
	$module_fields['latest-post'] = array(
		'id' => 'latest-post',
		'animation' => 'class-3',
		'title' => __('Latest/Related Post', 'ux'),
		'item' =>  array(
			array('title' => __('Layout','ux'),
				  'description' => __('Choose a layout','ux'),
				  'type' => 'select',
				  'name' => 'module_latestpost_layout',
				  'default' => 'grid'),
				  
			array('title' => __('Post Type', 'ux'),
				  'description' => __('Check on the post types you want to show on this module', 'ux'),
				  'type' => 'checkbox-group',
				  'name' => 'module_latestpost_posttype'),
			
			array('title' => __('Category','ux'),
				  'description' => __('The posts under the category you selected would be shown in this module','ux'),
				  'type' => 'category',
				  'name' => 'module_latestpost_category',
				  'taxonomy' => 'category',
				  'default' => '0'),
				  
			array('title' => __('Number of Items','ux'),
				  'description' => __('How many items should be displayed in this module, leave it empty to show all items','ux'),
				  'type' => 'text',
				  'name' => 'module_latestpost_number'),
				  
			array('title' => __('Ratio of Thumb','ux'),
				  'description' => __('The images come from featured image, choose a ratio to show in this module','ux'),
				  'type' => 'select',
				  'name' => 'module_latestpost_ratio',
				  'default' => 'landscape',
				  'control' => array(
					  'name' => 'module_latestpost_layout',
					  'value' => 'grid'
				  )),
				  
			array('title' => __('Order by', 'ux'),
				  'description' => __('Select sequence rules for the list', 'ux'),
				  'type' => 'orderby',
				  'name' => 'module_select_orderby',
				  'default' => 'date'),
				  
			array('title' => __('Image Size','ux'),
				  'description' => __('Choose a size for the images','ux'),
				  'type' => 'select',
				  'name' => 'module_latestpost_size',
				  'default' => 'medium',
				  'control' => array(
					  'name' => 'module_latestpost_layout',
					  'value' => 'grid'
				  )),
				  
			/*array('title' => __('Show','ux'),
				  'description' => __('Check on the elements you want to show','ux'),
				  'type' => 'checkbox-group',
				  'name' => 'module_latestpost_showfunction',
				  'control' => array(
					  'name' => 'module_latestpost_layout',
					  'value' => 'grid'
				  )),*/

			array('title' => __('Show Tags','ux'),
				  'description' => '',
				  'type' => 'switch',
				  'name' => 'module_latestpost_tags',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_latestpost_layout',
					  'value' => 'grid'
				  )),

				  
			  array('title' => __('Text Align','ux'),
				  'description' => __('Select alignment for the text','ux'),
				  'type' => 'select',
				  'name' => 'module_latestpost_align',
				  'default' => 'left',
				  'control' => array(
					  'name' => 'module_latestpost_layout',
					  'value' => 'grid'
				  )),
				  
			array('title' => __('Advanced Settings', 'ux'),
				  'description' => __('magin and animations', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_advanced_settings',
				  'default' => 'off'),
				  
			array('title' => __('Bottom Margin', 'ux'),
				  'description' => __('the spacing outside the bottom of module', 'ux'),
				  'type' => 'select',
				  'name' => 'module_bottom_margin',
				  'default' => 'bottom-space-40',
				  'control' => array(
					  'name' => 'module_advanced_settings',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Scroll in Animation', 'ux'),
				  'description' => __('enable to select Scroll in animation effect', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_scroll_in_animation',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_advanced_settings',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Scroll in Animation Effect', 'ux'),
				  'description' => __('animation effect when the module enter the scene', 'ux'),
				  'type' => 'select',
				  'name' => 'module_scroll_animation_two',
				  'default' => 'fadein',
				  'control' => array(
					  'name' => 'module_scroll_in_animation',
					  'value' => 'on'
				  ))
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_latestpost_fields');
?>