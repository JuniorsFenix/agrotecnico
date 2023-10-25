<?php
//promote template
function ux_pb_module_promote($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//promote confing
		$big_text     = get_post_meta($module_post, 'module_promote_big_text', true);
		$medium_text  = get_post_meta($module_post, 'module_promote_medium_text', true);
		$text_align   = get_post_meta($module_post, 'module_promote_text_align', true);
		$show_button  = get_post_meta($module_post, 'module_promote_show_button', true);
		$button_color = get_post_meta($module_post, 'module_promote_button_color', true);
		$button_text  = get_post_meta($module_post, 'module_promote_button_text', true);
		$button_link  = get_post_meta($module_post, 'module_promote_button_link', true);
		
		$text_align   = $text_align == 'center' ? 'text-center' : 'promote-wrap-2c';
		$button_color = $button_color ? 'bg-' . ux_theme_switch_color($button_color) : false; ?>
        
        <div class="promote-wrap <?php echo $text_align; ?>">
        	<a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
            <div class="promote-text">
                <?php echo $big_text ? '<h4 class="promote-big">' . $big_text . '</h4>' : false; ?>
                <?php echo $medium_text ? '<p class="promote-medium">' . $medium_text . '</p>' : false; ?>
            </div>
                
			<?php if($show_button == 'on'){ ?>
                <div class="promote-button-wrap">
                    <a class="promote-button btn-dark ux-btn <?php echo $button_color; ?>" title="<?php echo $button_text; ?>" href="<?php echo esc_url($button_link); ?>" pajx-click="true"><?php echo $button_text; ?></a>
                </div>
            <?php } ?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-promote', 'ux_pb_module_promote');

//promote select fields
function ux_pb_module_promote_select($fields){
	$fields['module_promote_text_align'] = array(
		array('title' => __('Left','ux'), 'value' => 'left'),
		array('title' => __('Center','ux'), 'value' => 'center')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_promote_select');

//promote config fields
function ux_pb_module_promote_fields($module_fields){
	$module_fields['promote'] = array(
		'id' => 'promote',
		'title' => __('Promote', 'ux'),
		'item' =>  array(
			array('title' => __('Big Text', 'ux'),
				  'description' => __('Enter the text you want to show in a largger size.', 'ux'),
				  'type' => 'textarea',
				  'name' => 'module_promote_big_text'),
				  
			array('title' => __('Medium Text', 'ux'),
				  'description' => __('Enter the text you want to show in normal size.', 'ux'),
				  'type' => 'textarea',
				  'name' => 'module_promote_medium_text'),
				  
			array('title' => __('Text Align', 'ux'),
				  'description' => __('Select alignment for the text.', 'ux'),
				  'type' => 'select',
				  'name' => 'module_promote_text_align',
				  'default' => 'left'),
				  
			array('title' => __('Show Button', 'ux'),
				  'description' => __('Enable it to show the button.', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_promote_show_button',
				  'default' => 'off'),
				  
			array('title' => __('Button Style', 'ux'),
				  'description' => __('Select a color for the button mouseover', 'ux'),
				  'type' => 'bg-color',
				  'name' => 'module_promote_button_color',
				  'control' => array(
					  'name' => 'module_promote_show_button',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Button Text', 'ux'),
				  'description' => __('Enter the text you want to show on button', 'ux'),
				  'type' => 'text',
				  'name' => 'module_promote_button_text',
				  'control' => array(
					  'name' => 'module_promote_show_button',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Button Link', 'ux'),
				  'description' => __('Paste the url to link the button to', 'ux'),
				  'type' => 'text',
				  'name' => 'module_promote_button_link',
				  'control' => array(
					  'name' => 'module_promote_show_button',
					  'value' => 'on'
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
add_filter('ux_pb_module_fields', 'ux_pb_module_promote_fields');
?>