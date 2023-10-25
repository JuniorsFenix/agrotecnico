<?php
//pagebuilder module fields
function ux_pb_module_fields(){
	$module_fields = array();
	$module_fields = apply_filters('ux_pb_module_fields', $module_fields);
	return $module_fields;
}

//pagebuilder module select fields
function ux_pb_module_select_fields(){
	$module_fields['module_select_orderby'] = array(
		array('title' => __('Please Select','ux'), 'value' => 'none'),
		array('title' => __('Title','ux'), 'value' => 'title'),
		array('title' => __('Date','ux'), 'value' => 'date'),
		array('title' => __('ID','ux'), 'value' => 'id'),
		array('title' => __('Modified','ux'), 'value' => 'modified'),
		array('title' => __('Author','ux'), 'value' => 'author'),
		array('title' => __('Comment count','ux'), 'value' => 'comment_count')
	);
	
	$module_fields['module_select_order'] = array(
		array('title' => __('Ascending','ux'), 'value' => 'ASC'),
		array('title' => __('Descending','ux'), 'value' => 'DESC')
	);
	
	$module_fields['module_bottom_margin'] = array(
		array('title' => __('No Margin','ux'), 'value' => 'bottom-space-no'),
		array('title' => __('20px','ux'), 'value' => 'bottom-space-20'),
		array('title' => __('40px','ux'), 'value' => 'bottom-space-40'),
		array('title' => __('60px','ux'), 'value' => 'bottom-space-60'),
		array('title' => __('80px','ux'), 'value' => 'bottom-space-80')
	);
	
	$module_fields['module_scroll_animation_one'] = array(
		array('title' => __('Fade in','ux'), 'value' => 'fadein'),
		array('title' => __('Fade in and zoom in','ux'), 'value' => 'zoomin'),
		array('title' => __('Fade in from left','ux'), 'value' => 'from-left-translate'),
		array('title' => __('Fade in from right','ux'), 'value' => 'from-right-translate'),
		array('title' => __('Fade in from top','ux'), 'value' => 'from-top-translate'),
		array('title' => __('Fade in from bottom','ux'), 'value' => 'from-bottom-translate')
	);
	
	$module_fields['module_scroll_animation_two'] = array(
		array('title' => __('Fade in','ux'), 'value' => 'fadein')
		//array('title' => __('Fade in and zoom in','ux'), 'value' => 'zoomin'),
		//array('title' => __('Fade in from bottom','ux'), 'value' => 'from-bottom-translate')
	);
	
	$module_fields['module_scroll_animation_three'] = array(
		array('title' => __('Fade In','ux'), 'value' => 'fadein'),
		array('title' => __('Fade In Left','ux'), 'value' => 'from-left-translate'),
		array('title' => __('Fade In Right','ux'), 'value' => 'from-right-translate'),
		array('title' => __('Fade In Up','ux'), 'value' => 'from-top-translate'),
		array('title' => __('Fade In Down','ux'), 'value' => 'from-bottom-translate'),
		array('title' => __('Bounce In Left','ux'), 'value' => 'bouncdein-left-translate'),
		array('title' => __('Bounce In Right','ux'), 'value' => 'bouncdein-right-translate'),
		array('title' => __('Bounce In Up','ux'), 'value' => 'bouncdein-up-translate'),
		array('title' => __('Bounce In Down','ux'), 'value' => 'bouncdein-down-translate'),
		array('title' => __('Flip X','ux'), 'value' => 'flip-x-translate'),
		array('title' => __('Flip Y','ux'), 'value' => 'flip-y-translate'),
		array('title' => __('Rotate In DownLeft','ux'), 'value' => 'rotate-downleft-translate'),
		array('title' => __('Rotate In DownRight','ux'), 'value' => 'rotate-downright-translate')
	);
	
	$module_fields = apply_filters('ux_pb_module_select_fields', $module_fields);
	return $module_fields;
}
?>