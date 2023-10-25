<?php
//text block template
function ux_pb_module_textblock($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//text block confing
		$bg_color = get_post_meta($module_post, 'module_textblock_background_color', true);
		$content  = get_post_meta($module_post, 'module_content', true);
		
		$content  = $content ? do_shortcode(wpautop($content)) : false;
		$bg_color = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : false;
		$module_style = $bg_color ? 'text_block withbg' : 'text_block ux-mod-nobg'; ?>
        
        <div data-post="<?php echo $itemid; ?>" class="<?php echo $module_style; ?> <?php echo $bg_color; ?>">
        	<a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
			<?php echo $content; ?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-text-block', 'ux_pb_module_textblock');

//text block config fields
function ux_pb_module_textblock_fields($module_fields){
	$module_fields['text-block'] = array(
		'id' => 'icon-box',
		'animation' => 'class-4',
		'title' => __('Text Block', 'ux'),
		'item' =>  array(
			array('title' => __('Background Color', 'ux'),
				  'description' => __('Select the Background Color for Text Block.', 'ux'),
				  'type' => 'bg-color',
				  'name' => 'module_textblock_background_color'),
				  
			array('title' => __('Content', 'ux'),
				  'description' => __('Enter some content for this Text Block.', 'ux'),
				  'type' => 'content',
				  'name' => 'module_content'),
				  
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
				  'name' => 'module_scroll_animation_three',
				  'default' => 'fadein',
				  'control' => array(
					  'name' => 'module_scroll_in_animation',
					  'value' => 'on'
				  ))
				  
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_textblock_fields');
?>