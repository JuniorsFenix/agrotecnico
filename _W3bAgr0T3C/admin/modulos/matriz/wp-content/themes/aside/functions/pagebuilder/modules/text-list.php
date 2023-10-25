<?php
//text list template
function ux_pb_module_textlist($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//text list confing
		$items             = get_post_meta($module_post, 'module_textlist_items', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, 'text-list') : false;
		
		if($items){
			$items_count = count($items['items']);
			$subcontrol_value = array();
			$get_subcontrol = ux_pb_getfield_subcontrol('module_textlist_items');
			if($get_subcontrol){
				foreach($get_subcontrol as $subcontrol => $field){
					$field_value = $field['value'];
					$field_type = $field['type']; 
					$subcontrol_value[$field_value] = $items[$subcontrol];
				}
			}
			
			for($i = 0; $i < $items_count; $i++){
				$title = $subcontrol_value['title'][$i];
				$icons = $subcontrol_value['icons'][$i];
				
				if(strstr($icons, "fa fa")){
					$icons = '<i class="' . $icons . '"></i>';
				}else{
					$icons = '<img class="user-uploaded-icons" src="' . $icons . '" />';
				} ?>
                
				<a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
				<div class="text-list ux-mod-nobg <?php echo $animation_style; ?>">
                    <?php echo $icons; ?>
                    <p class="text-list-inn"> <?php echo $title; ?></p>
                </div>
			<?php
			}
		}
	}
}
add_action('ux-pb-module-template-text-list', 'ux_pb_module_textlist');

//text list config fields
function ux_pb_module_textlist_fields($module_fields){
	$module_fields['text-list'] = array(
		'id' => 'text-list',
		'animation' => 'class-2',
		'title' => __('Text List', 'ux'),
		'item' =>  array(
			array('title' => __('Add Item', 'ux'),
				  'description' => __('Press the "Add" button to add an item', 'ux'),
				  'type' => 'items',
				  'name' => 'module_textlist_items',
				  'count' => 4),
				  
			array('title' => __('Select Icon','ux'),
				  'description' => __('Choose a icon for this Icon Box','ux'),
				  'type' => 'icons',
				  'name' => 'module_textlist_icon',
				  'subcontrol' => 'module_textlist_items|icons'),
				  
			array('title' => __('Content', 'ux'),
				  'description' => __('Enter content for this Text List', 'ux'),
				  'type' => 'text',
				  'name' => 'module_textlist_content',
				  'subcontrol' => 'module_textlist_items|title'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_textlist_fields');
?>