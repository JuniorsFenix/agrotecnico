<?php
//accordion/toggle template
function ux_pb_module_accordion($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//accordion confing
		$type        = get_post_meta($module_post, 'module_accordion_type', true);
		$style       = get_post_meta($module_post, 'module_accordion_style', true);
		$firstitem   = get_post_meta($module_post, 'module_accordion_firstitem', true);
		$items       = get_post_meta($module_post, 'module_accordion_items', true);
		
		$type_class  = $type == 'toggle' ? 'accordion_toggle' : 'accordion';
		$style_class = $style == 'style_b' ? 'accordion-style-b' : false; ?>
        
        <div id="accordion-<?php echo $itemid; ?>" class="<?php echo $type_class; ?> <?php echo $style_class; ?> ux-mod-nobg accordion-ux">
        	
            <?php if($items){
                $items_count = count($items['items']);
                $subcontrol_value = array();
                $get_subcontrol = ux_pb_getfield_subcontrol('module_accordion_items');
                if($get_subcontrol){
                    foreach($get_subcontrol as $subcontrol => $field){
                        $field_value = $field['value'];
                        $field_type = $field['type']; 
                        $subcontrol = $field_type == 'content' ? 'ux-pb-module-content' : $subcontrol;
                        $subcontrol_value[$field_value] = $items[$subcontrol];
                    }
                }
                
                for($i = 0; $i < $items_count; $i++){
                    $title = $subcontrol_value['title'][$i];
                    $content = $subcontrol_value['content'][$i];
                    $accordion_in = $firstitem == 'on' && $i == 0 ? 'in' : false;
                    $active_class = $firstitem == 'on' && $i == 0 ? 'active' : false; ?>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a href="#collapse_<?php echo $itemid . $i; ?>" data-parent="#accordion-<?php echo $itemid; ?>" data-toggle="collapse" class="accordion-toggle <?php echo $active_class; ?>"><?php echo $title; ?></a>
                        </div><!--End accordion-heading-->
                        
                        <div class="accordion-body collapse <?php echo $accordion_in; ?>" id="collapse_<?php echo $itemid . $i; ?>">
                            <div class="accordion-inner"><?php echo do_shortcode($content); ?></div><!--End accordion-inner-->
                        </div><!--End accordion-body-->
                    </div>
                <?php
                }
            }?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-accordion-toggle', 'ux_pb_module_accordion');

//accordion/toggle select fields
function ux_pb_module_accordion_select($fields){
	$fields['module_accordion_type'] = array(
		array('title' => __('Accordion','ux'), 'value' => 'accordion'),
		array('title' => __('Toggle','ux'), 'value' => 'toggle')
	);
	$fields['module_accordion_style'] = array(
		array('title' => __('Style A','ux'), 'value' => 'style_a'),
		array('title' => __('Style B','ux'), 'value' => 'style_b')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_accordion_select');

//accordion/toggle config fields
function ux_pb_module_accordion_fields($module_fields){
	$module_fields['accordion-toggle'] = array(
		'id' => 'accordion-toggle',
		'title' => __('Accordion/Toggle', 'ux'),
		'item' =>  array(
			array('title' => __('Type', 'ux'),
				  'description' => __('Select accordion or toggle', 'ux'),
				  'type' => 'select',
				  'name' => 'module_accordion_type',
				  'default' => 'accordion'),
				  
			array('title' => __('Style', 'ux'),
				  'description' => __('Select a style for the module', 'ux'),
				  'type' => 'select',
				  'name' => 'module_accordion_style',
				  'default' => 'style_a'),
				  
			array('title' => __('Open First Item by Default', 'ux'),
				  'description' => __('Enable it the first item would be opened by default', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_accordion_firstitem',
				  'default' => 'on'),
				  
			array('title' => __('Add Item', 'ux'),
				  'description' => __('Press the "Add" button to add an item', 'ux'),
				  'type' => 'items',
				  'name' => 'module_accordion_items',
				  'count' => 4),
				  
			array('title' => __('Title', 'ux'),
				  'description' => __('Enter the title for this item', 'ux'),
				  'type' => 'text',
				  'name' => 'module_accordion_title',
				  'subcontrol' => 'module_accordion_items|title'),
				  
			array('title' => __('Content', 'ux'),
				  'description' => __('Enter content for this Icon Box', 'ux'),
				  'type' => 'content',
				  'name' => 'module_content',
				  'subcontrol' => 'module_accordion_items|content'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_accordion_fields');
?>