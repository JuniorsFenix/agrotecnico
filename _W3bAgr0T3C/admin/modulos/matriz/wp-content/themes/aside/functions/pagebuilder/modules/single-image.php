<?php
//single image template
function ux_pb_module_singleimage($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		global $wpdb;
		
		//single image confing
		$image            = get_post_meta($module_post, 'module_singleimage_image', true);
		$style            = get_post_meta($module_post, 'module_singleimage_style', true);
		$align            = get_post_meta($module_post, 'module_singleimage_align', true);
		$effect           = get_post_meta($module_post, 'module_singleimage_effect', true);
		$lightbox         = get_post_meta($module_post, 'module_singleimage_lightbox', true);
		
		$get_attachment   = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE `guid` LIKE '$image'");
		
		$img_src_full     = wp_get_attachment_image_src($get_attachment->ID, 'full');
		$img_src_full     = $image ? $img_src_full[0] : false;
		
		$with_shadow      = $style == 'shadow' ? 'shadow' : false;
		$with_effect      = $effect == 'on' ? '<div class="blog-item-img-hover ux-hover-icon-wrap"><i class="icon-m-view"></i></div>' : false;
		$mouseover        = $effect == 'on' ? 'mouse-over' : false;
		$lightbox_before  = $lightbox == 'on' ? '<a class="lightbox ux-hover-wrap" href="' . $img_src_full . '">' : false;
		$lightbox_after   = $lightbox == 'on' ? '</a>' : false;
		$image            = $image ? '<img src=" ' . $image . '" />' : false; ?>
		
		<div class="single-image <?php echo $mouseover; ?> <?php echo $with_shadow; ?> <?php echo $align; ?>-ux">
			<a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
			<?php 
				echo $lightbox_before;
				echo $with_effect;
				echo $image;
				echo $lightbox_after;
			?>
		</div>
        
	<?php
	}
}
add_action('ux-pb-module-template-single-image', 'ux_pb_module_singleimage');

//single image select fields
function ux_pb_module_singleimage_select($fields){
	$fields['module_singleimage_style'] = array(
		array('title' => __('Standard', 'ux'), 'value' => 'no'),
		array('title' => __('Shadow', 'ux'), 'value' => 'shadow')
	);
	
	$fields['module_singleimage_align'] = array(
		array('title' => __('Left', 'ux'), 'value' => 'left'),
		array('title' => __('Center', 'ux'), 'value' => 'center'),
		array('title' => __('Right', 'ux'), 'value' => 'right')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_singleimage_select');

//single image box config fields
function ux_pb_module_singleimage_fields($module_fields){
	$module_fields['single-image'] = array(
		'id' => 'single-image',
		'animation' => 'class-1',
		'title' => __('Single Image', 'ux'),
		'item' =>  array(
			array('title' => __('Image', 'ux'),
				  'description' => __('Select image', 'ux'),
				  'type' => 'upload',
				  'name' => 'module_singleimage_image'),
				  
			array('title' => __('Style', 'ux'),
				  'description' => __('Select a style for the image', 'ux'),
				  'type' => 'select',
				  'name' => 'module_singleimage_style',
				  'default' => 'no'),

			array('title' => __('Algin', 'ux'),
				  'description' => '',
				  'type' => 'select',
				  'name' => 'module_singleimage_align',
				  'default' => 'left'),
				  
			array('title' => __('Mouseover Effect', 'ux'),
				  'description' => __('Enable the mouseover effect', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_singleimage_effect',
				  'default' => 'on'),
				  
			array('title' => __('Lightbox', 'ux'),
				  'description' => __('Enable the Lightbox', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_singleimage_lightbox',
				  'default' => 'on'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_singleimage_fields');
?>