<?php
//share template
function ux_pb_module_share($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//share confing
		$share_show = get_post_meta($module_post, 'module_share_show', true);
		
		$get_value = array();
		if($share_show){
			if(is_array($share_show)){
				$get_value = $share_show;
			}else{
				array_push($get_value, $share_show);
			}
		} ?>
        
        <div class="share-icon-wrap">
        	<a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
            <input value="<?php the_permalink(); ?>" name="url"  type="hidden"/>
            <input value="<?php the_title(); ?>" name="title"  type="hidden"/>
            <input value="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" name="media"  type="hidden"/>
			<?php if(count($get_value)){ ?>
                <ul class="post_social share-icons-mod clearfix">
					<?php foreach($get_value as $share){
						switch($share){
							case 'twitter': ?>
                                <li>
                                    <a class="share postshareicon-twitter-wrap" href="javascript:;">
                                        <span class="icon postshareicon-twitter"><i class="fa fa-twitter"></i></span>
                                        <span class="count">0</span>
                                    </a>
                                </li>
							<?php
                            break;
							
							case 'facebook': ?>
                                <li>
                                    <a class="share postshareicon-facebook-wrap" href="javascript:;">
                                        <span class="icon postshareicon-facebook"><i class="fa fa-facebook"></i></span>
                                        <span class="count">0</span>
                                    </a>
                                </li>
							<?php
                            break;
							
							case 'pinterest':
								if(has_post_thumbnail()){ ?>
                                    <li>
                                        <a class="share postshareicon-pinterest-wrap" href="javascript:;">
                                            <span class="icon postshareicon-pinterest"><i class="fa fa-pinterest"></i></span>
                                            <span class="count">0</span>
                                        </a>
                                    </li>
								<?php
                                }
                            break;
						}
					} ?>
                </ul><!--End .post_social-->
            <?php } ?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-share', 'ux_pb_module_share');

//share select fields
function ux_pb_module_share_select($fields){
	$fields['module_share_show'] = array(
		array('title' => __('Twitter','ux'), 'value' => 'twitter'),
		array('title' => __('Facebook','ux'), 'value' => 'facebook'),
		array('title' => __('Pinterest','ux'), 'value' => 'pinterest')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_share_select');

//share config fields
function ux_pb_module_share_fields($module_fields){
	$module_fields['share'] = array(
		'id' => 'share',
		'title' => __('Share', 'ux'),
		'item' =>  array(
			array('title' => __('Show', 'ux'),
				  'description' => __('Check on the social medias you want to show in the page. If the featured image is not set, the pin button would not be shown.', 'ux'),
				  'type' => 'checkbox-group',
				  'name' => 'module_share_show'),
				  
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
				  ))
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_share_fields');
?>