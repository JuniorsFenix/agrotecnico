<?php
//message box template
function ux_pb_module_messagebox($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//message box confing
		$type    = get_post_meta($module_post, 'module_message_type', true);
		$content = get_post_meta($module_post, 'module_message_content', true);
		
		switch($type){
			case 'error': $module_style = 'message-box box-bgcolor1 box-type1'; break;
			case 'warning': $module_style = 'message-box box-bgcolor2 box-type2'; break;
			case 'information': $module_style = 'message-box box-bgcolor3 box-type3'; break;
			case 'success': $module_style = 'message-box box-bgcolor4 box-type4'; break;
		}
		
		$module_style = $module_style ? $module_style : false; ?>
        
        <div class="<?php echo $module_style; ?>">
        	<a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
            <p class="box-close"><i class="icon-m-close-circle"></i></p>
            <?php echo $content; ?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-message-box', 'ux_pb_module_messagebox');

//message box select fields
function ux_pb_module_messagebox_select($fields){
	$fields['module_message_type'] = array(
		array('title' => __('Success','ux'), 'value' => 'success'),
		array('title' => __('Warning','ux'), 'value' => 'warning'),
		array('title' => __('Error','ux'), 'value' => 'error'),
		array('title' => __('Information','ux'), 'value' => 'information')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_messagebox_select');

//message box config fields
function ux_pb_module_messagebox_fields($module_fields){
	$module_fields['message-box'] = array(
		'id' => 'message-box',
		'title' => __('Message Box', 'ux'),
		'item' =>  array(
			array('title' => __('Type', 'ux'),
				  'description' => __('Select your message type', 'ux'),
				  'type' => 'select',
				  'name' => 'module_message_type',
				  'default' => 'success'),
				  
			array('title' => __('Content', 'ux'),
				  'description' => __('Enter content for this Message Box', 'ux'),
				  'type' => 'textarea',
				  'name' => 'module_message_content'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_messagebox_fields');
?>