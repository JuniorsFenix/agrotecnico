<?php
//Latest Tweets template
function ux_pb_module_latesttweets($itemid){
	$module_post = ux_pb_item_postid($itemid);
	$moduleid = 'latest-tweets';
	
	if($module_post){
		
		//Latest Tweets confing
		$count             = esc_attr(get_post_meta($module_post, 'module_tweets_count', true));
		$navigation        = get_post_meta($module_post, 'module_tweets_navigation', true);
		$username          = esc_attr(get_post_meta($module_post, 'module_tweets_name', true));
		
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		
		$count             = $count ? $count : 5;
		$navigation        = $navigation == 'on' ? 'show_meta_prev_next = "1" np_pos="bottom" middot="" next="" prev=""' : 'false';  ?>
        
		<div class="twitter-mod <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo sanitize_html_class($animation_end); ?>">
			<?php echo do_shortcode('[rotatingtweets screen_name="'. $username .'" tweet_count="' . $count . '" '.$navigation.' ]'); ?>
        </div>
        
	<?php
    }
}
add_action('ux-pb-module-template-latest-tweets', 'ux_pb_module_latesttweets');


//latest tweets config fields
function ux_pb_module_latesttweets_fields($module_fields){
	$module_fields['latest-tweets'] = array(
		'id' => 'latest-tweets',
		'animation' => true,
		'title' => __('Latest Tweets','ux'),
		'item' =>  array(
			array('type' => 'message',
				  'name' => 'module_tweets_message'),

			array('title' => __('Twitter User Name','ux'),
				  'type' => 'text',
				  'name' => 'module_tweets_name',
				  'default' => ''),
				  
			array('title' => __('Number of Items','ux'),
				  'type' => 'text',
				  'name' => 'module_tweets_count',
				  'default' => 5),

			array('title' => __('Show Navigation Buttons','ux'),
				  'type' => 'switch',
				  'name' => 'module_tweets_navigation',
				  'default' => 'off'),
				  
			array('title' => __('Advanced Settings','ux'),
				  'description' => __('magin and animations','ux'),
				  'type' => 'switch',
				  'name' => 'module_advanced_settings',
				  'default' => 'off'),
				  
			array('title' => __('Bottom Margin','ux'),
				  'description' => __('the spacing outside the bottom of module','ux'),
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
add_filter('ux_pb_module_fields', 'ux_pb_module_latesttweets_fields'); 
?>