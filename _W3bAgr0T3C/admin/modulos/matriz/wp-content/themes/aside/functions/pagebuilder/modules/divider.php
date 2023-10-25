<?php
//divider template
function ux_pb_module_divider($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//divider confing
		$type       = get_post_meta($module_post, 'module_divider_type', true);
		$text       = get_post_meta($module_post, 'module_divider_text', true);
		$text_align = get_post_meta($module_post, 'module_divider_text_align', true);
		$height     = get_post_meta($module_post, 'module_divider_height', true);
		$bg_color   = get_post_meta($module_post, 'module_divider_background_color', true);
		
		switch($text_align){
			case 'left': $type_align = 'title_on_left'; break;
			case 'center': $type_align = 'text-center'; break;
			case 'right': $type_align = 'title_on_right'; break;
		}
		$type_class    = $type != 'text_and_line' ? 'without-title' : false;
		$type_top      = $type != 'text_and_line' ? 'style="top: 8px;"' : false;
		$type_blank    = $type == 'blank_divider' ? 'blank-divider' : false;
		$type_align    = $type == 'text_and_line' ? $type_align : false;
		$height_class  = $type == 'blank_divider' ? $height : false;
		$bg_color      = $bg_color ? ux_theme_switch_color($bg_color) : false;
		$bg_color      = $type != 'blank_divider' ? $bg_color : false;
		$divider_title = $type == 'text_and_line' ? '<h4 class="' . $bg_color . '" style="background:none;">' . $text . '</h4>' : false;
		$separator_inn = '<div class="separator_inn bg-' . $bg_color . '" ' . $type_top . '></div>'; ?>
         
        <div class="separator <?php echo $type_class; ?> <?php echo $type_align; ?> <?php echo $type_blank; ?> <?php echo $height_class; ?>">
        	<a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
			<?php if($text_align == 'center'){
				echo $separator_inn;
			} 
			
			echo $divider_title;
			echo $separator_inn;
			?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-divider', 'ux_pb_module_divider');

//divider select fields
function ux_pb_module_divider_select($fields){
	$fields['module_divider_type'] = array(
		array('title' => __('Single Line', 'ux'), 'value' => 'single_line'),
		array('title' => __('Text and Line', 'ux'), 'value' => 'text_and_line'),
		array('title' => __('Blank Divider', 'ux'), 'value' => 'blank_divider')
	);
	
	$fields['module_divider_text_align'] = array(
		array('title' => __('Left', 'ux'), 'value' => 'left'),
		array('title' => __('Center', 'ux'), 'value' => 'center'),
		array('title' => __('Right', 'ux'), 'value' => 'right')
	);
		
	$fields['module_divider_height'] = array(
		array('title' => __('20px', 'ux'), 'value' => 'height-20'),
		array('title' => __('40px', 'ux'), 'value' => 'height-40'),
		array('title' => __('60px', 'ux'), 'value' => 'height-60'),
		array('title' => __('80px', 'ux'), 'value' => 'height-80')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_divider_select');

//divider config fields
function ux_pb_module_divider_fields($module_fields){
	$module_fields['divider'] = array(
		'id' => 'divider',
		'title' => __('Divider', 'ux'),
		'item' =>  array(
			array('title' => __('Type', 'ux'),
				  'description' => __('select a type for the Divider module', 'ux'),
				  'type' => 'select',
				  'name' => 'module_divider_type',
				  'default' => 'single_line'),
				  
			array('title' => __('Divider Text', 'ux'),
				  'description' => __('Enter the text you want to show in the divider', 'ux'),
				  'type' => 'text',
				  'name' => 'module_divider_text',
				  'control' => array(
					  'name' => 'module_divider_type',
					  'value' => 'text_and_line'
				  )),
			
			array('title' => __('Text Align', 'ux'),
				  'description' => __('Select alignment for the text', 'ux'),
				  'type' => 'select',
				  'name' => 'module_divider_text_align',
				  'default' => 'left',
				  'control' => array(
					  'name' => 'module_divider_type',
					  'value' => 'text_and_line'
				  )),
			
			array('title' => __('Height', 'ux'),
				  'type' => 'select',
				  'name' => 'module_divider_height',
				  'default' => '20px',
				  'control' => array(
					  'name' => 'module_divider_type',
					  'value' => 'blank_divider'
				  )),
				  
			array('title' => __('Color', 'ux'),
				  'description' => __('Select a color for the divider', 'ux'),
				  'type' => 'bg-color',
				  'name' => 'module_divider_background_color',
				  'control' => array(
					  'name' => 'module_divider_type',
					  'value' => 'single_line|text_and_line'
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
				  ))
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_divider_fields');
?>