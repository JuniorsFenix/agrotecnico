<?php
//fullwidth select fields
function ux_pb_module_fullwidth_select($fields){
	$fields['module_fullwidth_background'] = array(
		array('title' => __('Color and Image','ux'), 'value' => 'color_image'),
		array('title' => __('Video','ux'), 'value' => 'video')
	);
	
	$fields['module_fullwidth_background_repeat'] = array(
		array('title' => __('Fill','ux'), 'value' => 'fill'),
		array('title' => __('Repeat','ux'), 'value' => 'repeat')
	);
	
	$fields['module_fullwidth_background_attachment'] = array(
		array('title' => __('Parallax','ux'), 'value' => 'parallax'),
		array('title' => __('Fixed','ux'), 'value' => 'fixed'),
		array('title' => __('Scroll','ux'), 'value' => 'scroll')
	);
	
	$fields['module_fullwidth_background_ratio'] = array(
		array('title' => '0.1', 'value' => '19'),
		array('title' => '0.2', 'value' => '17'),
		array('title' => '0.3', 'value' => '15'),
		array('title' => '0.4', 'value' => '13'),
		array('title' => '0.5', 'value' => '11'),
		array('title' => '0.6', 'value' => '9'),
		array('title' => '0.7', 'value' => '7'),
		array('title' => '0.8', 'value' => '5'),
		array('title' => '0.9', 'value' => '3'),
		array('title' => '1.0', 'value' => '2')
	);
	
	$fields['module_fullwidth_dark_background_checkbox'] = array(
		array('title' => __('Text Shadow','ux'), 'value' => 'text_shadow')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_fullwidth_select');

//fullwidth config fields
function ux_pb_module_fullwidth_fields($module_fields){
	$module_fields['fullwidth'] = array(
		'id' => 'fullwidth',
		'title' => __('Fullwidth Wrap','ux'),
		'item' =>  array(
			array('title' => __('Background Type','ux'),
				  'description' => __('select background type for the wrap','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_background',
				  'default' => 'image'),
				  
			array('title' => __('Background Color','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_fullwidth_background_color',
				  'bind' => array(
					  array('type' => 'switch-color',
							'name' => 'module_fullwidth_background_switch_color',
							'position' => 'after')
				  ),
				  'control' => array(
					  'name' => 'module_fullwidth_background',
					  'value' => 'color_image'
				  )),
				  
			array('title' => __('Show Bg Image','ux'),
				  'description' => __('enable the background image','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_show_background_image',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_background',
					  'value' => 'color_image'
				  )),
				  
			array('title' => __('Bg Image','ux'),
				  'type' => 'upload',
				  'name' => 'module_fullwidth_background_image',
				  'control' => array(
					  'name' => 'module_fullwidth_show_background_image',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Bg Image Repeat','ux'),
				  'description' => __('use the image as a pattern','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_background_repeat',
				  'default' => 'fill',
				  'control' => array(
					  'name' => 'module_fullwidth_show_background_image',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Bg Image Attachment','ux'),
				  'description' => __('The fixed is not supported touch device. If you use "Fixed" option, the backgorund image size is larger than 1500px * 1500px','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_background_attachment',
				  'default' => 'parallax',
				  'control' => array(
					  'name' => 'module_fullwidth_background_repeat',
					  'value' => 'fill'
				  )),
				  
			array('title' => __('Ratio','ux'),
				  'description' => __('select a ratio for Parallax effect','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_background_ratio',
				  'default' => '0.3',
				  'control' => array(
					  'name' => 'module_fullwidth_background_attachment',
					  'value' => 'parallax'
				  )),
				  
			array('title' => __('Video Url', 'ux'),
				  'description' => __('enter the video url into right fields', 'ux'),
				  'type' => 'text',
				  'name' => 'module_fullwidth_video_webm',
				  'placeholder' => __('enter the “.webm” video url here for firefox/chrome/opera browser', 'ux'),
				  'bind' => array(
					  array('type' => 'text',
							'name' => 'module_fullwidth_video_mp4',
							'placeholder' => __('enter the “.mp4” or “.m4v” video url here for chrome/ie/safari browser', 'ux'),
							'position' => 'after'),
							
					  array('type' => 'text',
							'name' => 'module_fullwidth_video_ogg',
							'placeholder' => __('enter the “.ogg” or “ogv” video url here for chrome/firefox  browser', 'ux'),
							'position' => 'after')
				  ),
				  'control' => array(
					  'name' => 'module_fullwidth_background',
					  'value' => 'video'
				  )),
				  
			array('title' => __('Alt Image','ux'),
				  'description' => __('Touch devices and ie 8 do not support video background, you need to select a image for them ', 'ux'),
				  'type' => 'upload',
				  'name' => 'module_fullwidth_alt_image',
				  'control' => array(
					  'name' => 'module_fullwidth_background',
					  'value' => 'video'
				  )),

			array('title' => __('Anchor Name', 'ux'),
				  'description' => __('Please enter the anchor name', 'ux'),
				  'type' => 'text',
				  'name' => 'module_fullwidth_anchor_name'),

			array('title' => __('Height','ux'),
				  'type' => 'text',
				  'name' => 'module_fullwidth_height',
				  'description' => __('it is recommended to leave it empty to be "auto"', 'ux'),
				  'unit' => __('px','ux')),

			array('title' => __('Show Shadow','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_shadow',
				  'default' => 'off'),
				  
			array('title' => __('Shift Text Color for Dark Background','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_dark_background',
				  'default' => 'off'),
				  
			array('type' => 'checkbox-group',
				  'name' => 'module_fullwidth_dark_background_checkbox',
				  'control' => array(
					  'name' => 'module_fullwidth_dark_background',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Show Module via Tab','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_via_tab',
				  'default' => 'off'),
				  
			array('type' => 'tabs',
				  'name' => 'module_fullwidth_tabs',
				  'placeholder' => __('Tab Name', 'ux'),
				  'control' => array(
					  'name' => 'module_fullwidth_via_tab',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Fit Content to Fullwidth','ux'),
				  'description' => __('Content would fit to content container by default, turn on this option the content would fit to fullwidth of the page','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_fit_content',
				  'default' => 'off'),

			array('title' => __('Enable Top Inner Spacer','ux'),
				  'description' => '',
				  'type' => 'switch',
				  'name' => 'module_fullwidth_spacer_in_top',
				  'default' => 'on'),

			array('title' => __('Enable Bottom Inner Spacer','ux'),
				  'description' => '',
				  'type' => 'switch',
				  'name' => 'module_fullwidth_spacer_in_bottom',
				  'default' => 'on'),
				  
			array('title' => __('Enable Top Outer Spacer','ux'),
				  'description' => '',
				  'type' => 'switch',
				  'name' => 'module_fullwidth_spacer_top',
				  'default' => 'off'),
				  
			array('title' => __('Enable Bottom Outer Spacer','ux'),
				  'description' => '',
				  'type' => 'switch',
				  'name' => 'module_fullwidth_spacer_bottom',
				  'default' => 'off')

			
				  
		)
	);
	
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_fullwidth_fields');
?>