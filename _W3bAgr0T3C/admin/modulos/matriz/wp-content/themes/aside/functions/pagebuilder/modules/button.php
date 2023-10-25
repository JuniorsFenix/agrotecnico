<?php
//button template
function ux_pb_module_button($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//button confing
		$size  = get_post_meta($module_post, 'module_button_size', true);
		$skin  = get_post_meta($module_post, 'module_button_skin', true);
		$color = get_post_meta($module_post, 'module_button_color', true);
		$text  = get_post_meta($module_post, 'module_button_text', true);
		$link  = get_post_meta($module_post, 'module_button_link', true);
		
		switch($size){
			case 'small': $size = 'ux-btn-small'; break;
			case 'medium': $size = false; break;
			case 'large': $size = 'ux-btn-big'; break;
		}
		
		$link = $link ? esc_url($link) : '#';
		$bg_color = $color ? 'bg-' . ux_theme_switch_color($color) : false; 
		$skin = $skin ? $skin : 'btn-dark' ?>
        <a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
        <a href="<?php echo $link; ?>" class="ux-btn <?php echo $size; ?> <?php echo $bg_color; ?> <?php echo $skin; ?>"><?php echo $text; ?></a>
	<?php
	}
}
add_action('ux-pb-module-template-button', 'ux_pb_module_button');

//button select fields
function ux_pb_module_button_select($fields){
	$fields['module_button_size'] = array(
		array('title' => __('Small','ux'), 'value' => 'small'),
		array('title' => __('Medium','ux'), 'value' => 'medium'),
		array('title' => __('Large','ux'), 'value' => 'large'),
	);
	$fields['module_button_skin'] = array(
		array('title' => __('Light','ux'), 'value' => 'btn-light'),
		array('title' => __('Dark','ux'), 'value' => 'btn-dark'),
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_button_select');

//button config fields
function ux_pb_module_button_fields($module_fields){
	$module_fields['button'] = array(
		'id' => 'button',
		'animation' => 'class-1',
		'title' => __('Button', 'ux'),
		'item' =>  array(
			array('title' => __('Size', 'ux'),
				  'description' => __('Choose a size for the button', 'ux'),
				  'type' => 'select',
				  'name' => 'module_button_size',
				  'default' => 'small'),

			array('title' => __('Button Color', 'ux'),
				  'description' => __('Choose a color for the button', 'ux'),
				  'type' => 'select',
				  'name' => 'module_button_skin',
				  'default' => 'dark'),
				  
			array('title' => __('Button Mouseover Color', 'ux'),
				  'description' => __('Choose a color for the button mouseover', 'ux'),
				  'type' => 'bg-color',
				  'name' => 'module_button_color'),
				  
			array('title' => __('Button Text', 'ux'),
				  'description' => __('Enter the text you want to show on button', 'ux'),
				  'type' => 'text',
				  'name' => 'module_button_text'),
				  
			array('title' => __('Button Link', 'ux'),
				  'description' => __('Paste a url for the button', 'ux'),
				  'type' => 'text',
				  'name' => 'module_button_link',
				  'placeholder' => 'http://aol.com'),
				  
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
				  'name' => 'module_scroll_animation_one',
				  'default' => 'fadein',
				  'control' => array(
					  'name' => 'module_scroll_in_animation',
					  'value' => 'on'
				  ))
		)
	);
	
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_button_fields');
?>