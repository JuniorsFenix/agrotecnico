<?php
//count down template
function ux_pb_module_countdown($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//count down confing
		$time  = get_post_meta($module_post, 'module_countdown_time', true);
		$start = get_post_meta($module_post, 'module_countdown_start', true);
		$end   = get_post_meta($module_post, 'module_countdown_end', true);
		
		$date_array = array(
			'years' => 0,
			'months' => 1,
			'days' => 2,
			'hours' => 3,
			'minutes' => 4,
			'seconds' => 5
		);
		
		$start = $start ? $date_array[$start] : $date_array['years'];
		$end = $end ? $date_array[$end] : $date_array['seconds'];
		
		$date_format = false;
		foreach($date_array as $date => $i){
			if($i >= $start && $i <= $end){
				switch($date){
					case 'years': $date_format .= 'y'; break;
					case 'months': $date_format .= 'o'; break;
					case 'days': $date_format .= 'd'; break;
					case 'hours': $date_format .= 'H'; break;
					case 'minutes': $date_format .= 'M'; break;
					case 'seconds': $date_format .= 'S'; break;
				}
			}
		}
		
		$date = new DateTime($time); ?>
        <a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
        <div class="countdown" data-years="<?php echo $date->format('Y'); ?>" data-months="<?php echo $date->format('n'); ?>" data-days="<?php echo $date->format('d'); ?>" data-hours="<?php echo $date->format('H'); ?>" data-minutes="<?php echo $date->format('i'); ?>" data-seconds="<?php echo $date->format('s'); ?>" data-dateformat="<?php echo $date_format; ?>"></div>
	<?php
	}
}
add_action('ux-pb-module-template-count-down', 'ux_pb_module_countdown');

//count down select fields
function ux_pb_module_countdown_select($fields){
	$fields['module_countdown_start'] = array(
		array('title' => __('Years', 'ux'), 'value' => 'years'),
		array('title' => __('Months', 'ux'), 'value' => 'months'),
		array('title' => __('Days', 'ux'), 'value' => 'days'),
		array('title' => __('Hours', 'ux'), 'value' => 'hours'),
		array('title' => __('Minutes', 'ux'), 'value' => 'minutes'),
		array('title' => __('Seconds', 'ux'), 'value' => 'seconds')
	);
	
	$fields['module_countdown_end'] = array(
		array('title' => __('Years', 'ux'), 'value' => 'years'),
		array('title' => __('Months', 'ux'), 'value' => 'months'),
		array('title' => __('Days', 'ux'), 'value' => 'days'),
		array('title' => __('Hours', 'ux'), 'value' => 'hours'),
		array('title' => __('Minutes', 'ux'), 'value' => 'minutes'),
		array('title' => __('Seconds', 'ux'), 'value' => 'seconds')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_countdown_select');

//count down config fields
function ux_pb_module_countdown_fields($module_fields){
	$module_fields['count-down'] = array(
		'id' => 'count-down',
		'animation' => 'class-1',
		'title' => __('Count Down', 'ux'),
		'item' =>  array(
			array('title' => __('Date', 'ux'),
				  'description' => __('Select a deadline for the counter', 'ux'),
				  'type' => 'date',
				  'name' => 'module_countdown_time'),
				  
			array('title' => __('Count Start', 'ux'),
				  'description' => __('Choose a start time unit', 'ux'),
				  'type' => 'select',
				  'name' => 'module_countdown_start',
				  'default' => 'years'),
				  
			array('title' => __('Count To', 'ux'),
				  'description' => __('Choose a end time unit', 'ux'),
				  'type' => 'select',
				  'name' => 'module_countdown_end',
				  'default' => 'seconds'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_countdown_fields');
?>