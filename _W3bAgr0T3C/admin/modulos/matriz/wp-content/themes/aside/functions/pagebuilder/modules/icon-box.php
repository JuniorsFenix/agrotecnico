<?php
//icon box template
function ux_pb_module_iconbox($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//icon box confing
		$icons            = get_post_meta($module_post, 'module_iconbox_icon', true);
		$layout           = get_post_meta($module_post, 'module_iconbox_layout', true);
		$mask             = get_post_meta($module_post, 'module_iconbox_mask', true);
		$mask_color       = get_post_meta($module_post, 'module_iconbox_mask_color', true);
		$animation        = get_post_meta($module_post, 'module_iconbox_hover_animation', true);
		$title            = get_post_meta($module_post, 'module_iconbox_title', true);
		$link             = get_post_meta($module_post, 'module_iconbox_link', true);
		$hyperlink        = get_post_meta($module_post, 'module_iconbox_hyperlink', true);
		$content          = get_post_meta($module_post, 'module_content', true);
		
		$hyperlink_before = $link == 'on' ? '<a href="' . esc_url($hyperlink) . '" target="_blank">' : false;
		$hyperlink_after  = $link == 'on' ? '</a>' : false;
		$title            = $title ? '<h3>' . $title . '</h3>' : false;
		$content          = $content ? do_shortcode($content) : false;
		$mask_color       = $mask_color ? ux_theme_switch_color($mask_color, 'rgb') : ux_theme_switch_color('color10', 'rgb');
		$mask_type        = $mask ? 'iconbox-plus-' . $mask : false;
		$mask_animation   = $animation ? 'hover-' . $animation : false;
		$mask_style       = $layout == 'icon_top' ? 'iconbox-plus ' . $mask_type . ' ' . $mask_animation : false;
		$animation        = $animation ? 'data-animation="' . $animation . '"' : false;
		
		if(strstr($icons, "fa fa")){
			$icons = '<i class="' . $icons . '"></i>';
		}else{
			$icons = '<img class="user-uploaded-icons" src="' . $icons . '" />';
		} ?>
         
        <div <?php echo $animation; ?> class="iocnbox <?php echo $layout; ?> <?php echo $mask_style; ?> ux-mod-nobg">
        	<a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
            <?php if($mask){
				if($layout == 'icon_top'){ ?>
                    <!--End iconbox-plus-svg-wrap-->
                    <div class="iconbox-plus-svg-wrap">
                        <?php echo $hyperlink_before;
                        switch($mask){
                            case 'circle': ?>
                                <svg xml:space="preserve" enable-background="new 25.5 175.5 160 160" viewBox="25.5 175.5 160 160" height="160px" width="160px" y="0px" x="0px" id="<?php echo 'iconbox-plus' .$module_post; ?>" version="1.1"><circle r="65" cy="258.5" cx="105.5" fill="<?php echo $mask_color; ?>" /></svg>
                            <?php
                            break;
                            case 'triangle': ?>
                                <svg xml:space="preserve" enable-background="new 25.5 175.5 160 160" viewBox="25.5 175.5 160 160" height="160px" width="160px" y="0px" x="0px" id="<?php echo 'iconbox-plus' .$module_post; ?>" version="1.1"><g><path d="M39.791,315.5c-6.487,0-9.148-4.574-5.915-10.162L99.62,191.691c3.234-5.588,8.527-5.588,11.757,0
        l65.747,113.646c3.232,5.588,0.572,10.162-5.917,10.162H39.791z" fill="<?php echo $mask_color; ?>"/></g></svg>
                            <?php
                            break;
                            case 'square': ?>
                                <svg xml:space="preserve" enable-background="new 25.5 175.5 160 160" viewBox="25.5 175.5 160 160" height="160px" width="160px" y="0px" x="0px" id="<?php echo 'iconbox-plus' .$module_post; ?>" version="1.1"><path d="M175.5,308c0,9.659-7.841,17.5-17.5,17.5H53c-9.669,0-17.5-7.841-17.5-17.5V203
        c0-9.659,7.831-17.5,17.5-17.5h105c9.659,0,17.5,7.841,17.5,17.5V308z" fill="<?php echo $mask_color; ?>"/></svg>
                            <?php
                            break;
                            case 'hexagonal': ?>
                                <svg xml:space="preserve" enable-background="new 25.5 175.5 160 160" viewBox="25.5 175.5 160 160" height="160px" width="160px" y="0px" x="0px" id="<?php echo 'iconbox-plus' .$module_post; ?>" version="1.1"><g><path d="M74.297,324.5c-4.7,0-10.464-3.323-12.807-7.385l-31.235-54.231c-2.34-4.062-2.34-10.707,0-14.771
        l31.234-54.223c2.344-4.062,8.107-7.39,12.808-7.39h62.407c4.697,0,10.46,3.327,12.8,7.39l31.242,54.223
        c2.338,4.064,2.338,10.71,0,14.771l-31.242,54.231c-2.34,4.062-8.103,7.385-12.8,7.385H74.297z" fill="<?php echo $mask_color; ?>"/></g></svg>
                            <?php
                            break;
                            case 'pentagon': ?>
                                <svg xml:space="preserve" enable-background="new 25.5 175.5 160 160" viewBox="25.5 175.5 160 160" height="160px" width="160px" y="0px" x="0px" id="<?php echo 'iconbox-plus' .$module_post; ?>" version="1.1"><g><path d="M109.339,305.159c-2.113-1.104-5.562-1.106-7.675,0l-39.981,20.895c-2.11,1.102-3.506,0.09-3.103-2.248
        l7.636-44.251c0.405-2.34-0.664-5.604-2.37-7.262L31.5,240.937c-1.707-1.654-1.175-3.286,1.182-3.627l44.708-6.463
        c2.357-0.339,5.15-2.36,6.206-4.489l19.983-40.265c1.06-2.124,2.783-2.124,3.843,0l19.979,40.265
        c1.056,2.127,3.847,4.15,6.206,4.489l44.711,6.463c2.355,0.342,2.889,1.973,1.183,3.627l-32.348,31.355
        c-1.706,1.657-2.773,4.922-2.369,7.262l7.628,44.251c0.404,2.339-0.992,3.349-3.1,2.248L109.339,305.159z" fill="<?php echo $mask_color; ?>"/></g></svg>
                            <?php
                            break;
                        }
						echo $icons;
						echo $hyperlink_after; ?>
                    </div>
				<?php
				}
			}else{
				if($icons){ ?>
                    <div class="icon_wrap">
                        <?php echo $hyperlink_before; ?>
                        <?php echo $icons; ?>
                        <?php echo $hyperlink_after; ?>
                    </div>
                <?php
				}
			} ?>
            <div class="icon_text">
            	<?php echo $hyperlink_before; ?>
				<?php echo $title; ?>
				<?php echo $hyperlink_after; ?>
                <?php echo $content; ?>
            </div><!--End icon_text-->
                        
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-icon-box', 'ux_pb_module_iconbox');

//icon box select fields
function ux_pb_module_iconbox_select($fields){
	$fields['module_iconbox_layout'] = array(
		array('title' => __('Icon on Left','ux'), 'value' => 'icon_left'),
		array('title' => __('Icon on Top','ux'), 'value' => 'icon_top')
	);
	
	$fields['module_iconbox_hover_animation'] = array(
		array('title' => __('Full Rotate','ux'), 'value' => 'rorate'),
		array('title' => __('Flip','ux'), 'value' => 'flip'),
		array('title' => __('Scale','ux'), 'value' => 'scale')
	);
	
	$fields['module_iconbox_mask'] = array(
		array('title' => __('Circle','ux'), 'value' => 'circle'),
		array('title' => __('Triangle','ux'), 'value' => 'triangle'),
		array('title' => __('Rounded Square','ux'), 'value' => 'square'),
		array('title' => __('Diamond','ux'), 'value' => 'hexagonal'),
		array('title' => __('Star','ux'), 'value' => 'pentagon')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_iconbox_select');

//icon box config fields
function ux_pb_module_iconbox_fields($module_fields){
	$module_fields['icon-box'] = array(
		'id' => 'icon-box',
		'animation' => 'class-4',
		'title' => __('Icon Box', 'ux'),
		'item' =>  array(
			array('title' => __('Select Icon','ux'),
				  'description' => __('Choose a icon for this Icon Box','ux'),
				  'type' => 'icons',
				  'name' => 'module_iconbox_icon'),
				  
			array('title' => __('Layout', 'ux'),
				  'description' => __('Place the Icon on left or top', 'ux'),
				  'type' => 'select',
				  'name' => 'module_iconbox_layout',
				  'default' => 'icon_left'),
				  
			array('title' => __('Icon Mask', 'ux'),
				  'type' => 'image_select',
				  'name' => 'module_iconbox_mask',
				  'control' => array(
					  'name' => 'module_iconbox_layout',
					  'value' => 'icon_top'
				  )),
				  
			array('title' => __('Mask Color', 'ux'),
				  'type' => 'bg-color',
				  'name' => 'module_iconbox_mask_color',
				  'control' => array(
					  'name' => 'module_iconbox_layout',
					  'value' => 'icon_top'
				  )),
				  
			array('title' => __('Hover Animation','ux'),
				  'type' => 'select',
				  'name' => 'module_iconbox_hover_animation',
				  'default' => 'rorate',
				  'control' => array(
					  'name' => 'module_iconbox_layout',
					  'value' => 'icon_top'
				  )),
				  
			array('title' => __('Title','ux'),
				  'description' => __('Enter a title for this Icon Box','ux'),
				  'type' => 'text',
				  'name' => 'module_iconbox_title'),
				  
			array('title' => __('Link','ux'),
				  'type' => 'switch',
				  'name' => 'module_iconbox_link'),
				  
			array('title' => __('Url','ux'),
				  'description' => __('Paste a url for the icon','ux'),
				  'type' => 'text',
				  'name' => 'module_iconbox_hyperlink',
				  'placeholder' => 'http://aol.com',
				  'control' => array(
					  'name' => 'module_iconbox_link',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Content', 'ux'),
				  'description' => __('Enter content for this Icon Box', 'ux'),
				  'type' => 'content',
				  'name' => 'module_content'),

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
				  'name' => 'module_scroll_animation_three',
				  'default' => 'fadein',
				  'control' => array(
					  'name' => 'module_scroll_in_animation',
					  'value' => 'on'
				  ))
				  
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_iconbox_fields');
?>