<?php
//image box template
function ux_pb_module_imagebox($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		global $wpdb;
		
		//image box confing
		$image            = get_post_meta($module_post, 'module_imagebox_image', true);
		$mask             = get_post_meta($module_post, 'module_imagebox_mask', true);
		$title            = get_post_meta($module_post, 'module_imagebox_title', true);
		$content          = get_post_meta($module_post, 'module_imagebox_content', true);
		$link             = get_post_meta($module_post, 'module_imagebox_link', true);
		$hyperlink        = get_post_meta($module_post, 'module_imagebox_hyperlink', true);
		$social_network   = get_post_meta($module_post, 'module_imagebox_social_network', true);
		$social_medias    = get_post_meta($module_post, 'module_imagebox_social_medias', true);
		$social_networks  = ux_theme_social_networks();
		
		$get_attachment   = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE `guid` LIKE '$image'");
		
		$hyperlink_before = $link == 'on' ? '<a href="' . esc_url($hyperlink) . '" target="_blank">' : false;
		$hyperlink_after  = $link == 'on' ? '</a>' : false;
		
		//$img_src          = wp_get_attachment_image_src($get_attachment->ID, 'imagebox-thumb');
		//$img_src          = $image ? $img_src[0] : false;
		$img_src          = $image ? wp_get_attachment_image_src($get_attachment->ID, 'imagebox-thumb') : false;
		$img_atta         = $image ? wp_get_attachment_image($get_attachment->ID, 'imagebox-thumb', false, array('class' => 'image-box-img-iehack')) : false;
		
		$icon_mask_name = false;
		if($mask){
			switch($mask){
				case 'circle': $icon_mask_name = 'image-box-circle'; break;
				case 'triangle': $icon_mask_name = 'image-box-triangle'; break;
				case 'square': $icon_mask_name = 'image-box-square'; break;
				case 'hexagonal': $icon_mask_name = 'image-box-hexagonal'; break;
				case 'pentagon': $icon_mask_name = 'image-box-pentagon'; break;
			}
		}
		$icon_mask_style = $icon_mask_name; ?>
        <section class="image-box ux-mod-nobg <?php echo $icon_mask_style; ?>">
			<?php if($image){
				if($mask){ ?>
                    <div class="image-box-svg-wrap">
                        <?php echo $hyperlink_before;
                        switch($mask){
                            case 'circle': $clippath = '<circle r="80" cy="80" cx="80"/>'; break;
                            case 'triangle': $clippath = '<path d="M7.738,145.805c-6.885,0-9.709-4.884-6.278-10.852L71.235,13.606c3.431-5.968,9.047-5.968,12.478,0
    l69.775,121.348c3.431,5.967,0.606,10.851-6.277,10.851H7.738z"/>'; break;
                            case 'square': $clippath = '<path d="M150.5,132c0,9.659-7.841,17.5-17.5,17.5H28c-9.669,0-17.5-7.841-17.5-17.5V27c0-9.659,7.831-17.5,17.5-17.5
    h105c9.659,0,17.5,7.841,17.5,17.5V132z"/>'; break;
                            case 'hexagonal': $clippath = '<path d="M48.797,149.5c-4.7,0-10.464-3.323-12.807-7.385L4.755,87.884c-2.34-4.062-2.34-10.707,0-14.771
    l31.234-54.223c2.344-4.062,8.107-7.391,12.808-7.391h62.407c4.696,0,10.46,3.327,12.8,7.391l31.242,54.223
    c2.338,4.063,2.338,10.71,0,14.771l-31.242,54.231c-2.34,4.062-8.104,7.385-12.8,7.385H48.797z"/>'; break;
                            case 'pentagon': $clippath = '<path d="M83.339,129.159c-2.112-1.104-5.562-1.106-7.675,0l-39.981,20.896c-2.11,1.102-3.506,0.09-3.103-2.248
    l7.636-44.252c0.405-2.34-0.664-5.604-2.37-7.262L5.5,64.938c-1.707-1.654-1.175-3.287,1.182-3.627l44.708-6.463
    c2.357-0.34,5.15-2.361,6.206-4.49l19.983-40.265c1.06-2.124,2.782-2.124,3.843,0L101.4,50.357c1.057,2.127,3.848,4.15,6.207,4.49
    l44.711,6.463c2.354,0.342,2.889,1.973,1.183,3.627l-32.349,31.354c-1.705,1.657-2.772,4.922-2.368,7.263l7.628,44.25
    c0.404,2.34-0.992,3.35-3.1,2.248L83.339,129.159z"/>'; break;
                        } ?>
                        <svg height="160" width="160">
                            <defs>
                                <clipPath id="<?php echo 'image-box' .$module_post; ?>">
                                    <?php echo $clippath; ?>
                                </clipPath>
                            </defs>
                            <image style="clip-path: url(#<?php echo 'image-box' .$module_post; ?>); width:160px; height:160px; " height="160" width="160" xlink:href="<?php echo $img_src[0]; ?>"/>
                        </svg>
                        <?php echo $hyperlink_after; ?>		
                    </div>
                    
                <?php }else{ 
                	echo $hyperlink_before; ?>
                    <img width="160" height="160" src="<?php echo $img_src[0]; ?>" class="image-box-img-iehack" style="display:block;" />
                    <?php echo $hyperlink_after; ?>	
                <?php }
				echo $img_atta;
			} ?>
            
            <?php if($title) { ?><h1><?php echo $title; ?></h1><?php } ?>
            <?php if($content) { ?><p class="image-box-des"><?php echo $content; ?></p><?php } ?>
            <?php if($social_network == 'on'){ ?>
                <ul class="image-box-icons">
                    <?php foreach($social_medias['name'] as $i => $m_name){
						$m_url = $social_medias['url'][$i];
						$social_ico = false;
						$social_name = false;
						foreach($social_networks as $social){
							if($m_name == $social['slug']){
								$social_ico = $social['icon2'];
								$social_name = $social['name'];
							}
						} ?>
						<li><a title="<?php echo 'visit ' . $social_name; ?>" href="<?php echo esc_url($m_url); ?>"><i class="<?php echo $social_ico; ?>"></i></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </section>
	<?php
	}
}
add_action('ux-pb-module-template-image-box', 'ux_pb_module_imagebox');

//image box select fields
function ux_pb_module_imagebox_select($fields){
	$fields['module_imagebox_mask'] = array(
		array('title' => __('Circle','ux'), 'value' => 'circle'),
		array('title' => __('Triangle','ux'), 'value' => 'triangle'),
		array('title' => __('Rounded Square','ux'), 'value' => 'square'),
		array('title' => __('Diamond','ux'), 'value' => 'hexagonal'),
		array('title' => __('Star','ux'), 'value' => 'pentagon')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_imagebox_select');

//image box config fields
function ux_pb_module_imagebox_fields($module_fields){
	$module_fields['image-box'] = array(
		'id' => 'image-box',
		'animation' => 'class-4',
		'title' => __('Image Box', 'ux'),
		'item' =>  array(
			array('title' => __('Image','ux'),
				  'description' => __('Select image','ux'),
				  'type' => 'upload',
				  'name' => 'module_imagebox_image'),
				  
			array('title' => __('Image Mask','ux'),
				  'type' => 'image_select',
				  'name' => 'module_imagebox_mask'),
				  
			array('title' => __('Title','ux'),
				  'type' => 'text',
				  'name' => 'module_imagebox_title'),
				  
			array('title' => __('Content','ux'),
				  'type' => 'textarea',
				  'name' => 'module_imagebox_content'),
				  
			array('title' => __('Link','ux'),
				  'description' => __('Descriptions','ux'),
				  'type' => 'switch',
				  'name' => 'module_imagebox_link',
				  'default' => 'off'),
				  
			array('title' => __('Url','ux'),
				  'description' => __('Paste a url for the image','ux'),
				  'type' => 'text',
				  'name' => 'module_imagebox_hyperlink',
				  'placeholder' => 'http://aol.com',
				  'control' => array(
					  'name' => 'module_imagebox_link',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Show Social Icons','ux'),
				  'description' => '',
				  'type' => 'switch',
				  'name' => 'module_imagebox_social_network',
				  'default' => 'off'),
			
			array('title' => __('Social Medias','ux'),
				  'type' => 'social-medias',
				  'name' => 'module_imagebox_social_medias',
				  'control' => array(
					  'name' => 'module_imagebox_social_network',
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
add_filter('ux_pb_module_fields', 'ux_pb_module_imagebox_fields');
?>