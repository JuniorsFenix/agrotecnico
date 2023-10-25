<?php
//select icons
function ux_theme_option_select_icons(){
	$icons_fields = ux_theme_icons_fields();
	$get_value = get_option('ux_theme_option_icons_custom');
	$i = $_POST['i'];
	$type = $_POST['type']; ?>

    <div class="ux-theme-option-select-icons">
        <div class="row">
            <div class="col-xs-4">
                <h5><strong><?php _e('Select Icon', 'ux'); ?></strong></h5>
                <p class="text-muted"><?php _e('Choose a icon for this Icon Box', 'ux'); ?></p>
            </div>
            
            <div class="col-xs-8">
                <select class="form-control">
					<option value="fontawesome"><?php _e('Font Awesome', 'ux'); ?></option>
                    <?php if($get_value){ ?>
                        <option value="user-uploaded-icons"><?php _e('User Uploaded Icons', 'ux'); ?></option>
                    <?php } ?>
                </select>
                <div class="ux-theme-option-icons">
					<?php foreach($icons_fields as $icon){  ?>
                        <a href="#" class="fontawesome"><i class="<?php echo $icon; ?>"></i></a>
                    <?php }
					
					if($get_value){
						foreach($get_value as $portfolio){
							$image_src = wp_get_attachment_image_src($portfolio); ?>
                            <a href="#" class="user-uploaded-icons"><img src="<?php echo $image_src[0]; ?>" /></a>
						<?php
						}
					} ?>
                    <div class="clearfix"></div>
                    <input type="hidden" id="ux-theme-social-medias-rel" value="<?php echo $i; ?>" />
                    <input type="hidden" id="ux-theme-option-icons-input" value="" />
                    <script type="text/javascript">
						jQuery(document).ready(function(){
							jQuery('.ux-theme-option-select-icons').each(function(){
                                var _this = jQuery(this);
								var _this_select = _this.find('select');
								var _this_icon = _this.find('a');
								var _this_input = _this.find('#ux-theme-option-icons-input');
								var _this_rel = jQuery('#ux-theme-social-medias-rel').val();
								
								<?php if($type){ ?>
									var _target = jQuery('#<?php echo $type ; ?>').find('.ux-theme-social-medias[rel=' + _this_rel + ']');
								<?php }else{ ?>
									var _target = jQuery('.ux-theme-social-medias[rel=' + _this_rel + ']');
								<?php } ?>
								
								var _target_icon = _target.find('.new-media-col-icon');
								
								_this_select.change(function(){
									var _select_val = jQuery(this).val();
									_this_icon.each(function(){
                                        if(jQuery(this).hasClass(_select_val)){
											jQuery(this).fadeIn();
										}else{
											jQuery(this).hide();
										}
                                    });
								});
								
								_this_icon.click(function(){
									if(jQuery(this).is('.fontawesome')){
										var _icon = jQuery(this).find('i');
										var _icon_val = _icon.attr('class');
										var _icon_type = 'fontawesome';
									}else{
										var _icon = jQuery(this).find('img');
										var _icon_val = _icon.attr('src');
										var _icon_type = 'user';
									}
									
									_target_icon.find('.icon-content').html(_icon);
									_target_icon.find('.icon-content').next().val(_icon_val);
									_target_icon.find('.icon-content').next().next().val(_icon_type);
									jQuery('#ux-theme-modal').modal('hide');
									return false;
								});
                            });
						});
					</script>
                </div>
            </div>
        </div>
    </div>
    
	<?php
	die('');
}
add_action('wp_ajax_ux_theme_option_select_icons', 'ux_theme_option_select_icons');

//load google font
function ux_theme_option_googlefont(){
	$response = wp_remote_get('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyC83M8-g7oz8yZSslS7tzkF_5TA3gQfJzs', array('sslverify' => false));
	
	if(is_wp_error($response)){
		echo 'error';
	}else{
		if(isset($response['body']) && $response['body']){
			if(strpos($response['body'], 'error') === false){
				$fonts_json = $response['body'];
				update_option('ux_theme_googlefont', $fonts_json);
				echo 'success';
			}else{
				echo 'error';
			}
		}
	}
	die('');
}
add_action('wp_ajax_ux_theme_option_googlefont', 'ux_theme_option_googlefont');

//add google font
function ux_theme_option_font_ajax(){
	$data = $_POST['data'];
	$fonts = null;
	$fonts_object = null;
	
	$json = get_option('ux_theme_googlefont');
	
	if($json){
		$fonts_object = json_decode($json);
	}
	if($fonts_object && is_object($fonts_object)){
		if($fonts_object->items && is_array($fonts_object->items)){
			$fonts = $fonts_object->items;
			if($data == 'load-fonts'){ ?>
                <option value="-1"><?php _e('-- Select Font --', 'ux'); ?></option>
            <?php 
			}
			
			foreach($fonts as $item){
				$family_val = str_replace(' ', '+', $item->family);
				switch($data){
					case 'load-fonts': ?>
                        <option value="<?php echo $family_val; ?>"><?php echo $item->family; ?></option>
					<?php
					break;
					
					case 'load-style':
						$font_family = $_POST['font'];
						$selected = (isset($_POST['selected'])) ? $_POST['selected'] : false;
						if($family_val == $font_family){
							foreach($item->variants as $variants){ ?>
                                <option value="<?php echo $variants; ?>" <?php selected($selected, $variants); ?>><?php echo $variants; ?></option>
                            <?php
							}
						}
					break;
				}
            }
		}
	}
	die('');
}
add_action('wp_ajax_ux_theme_option_font_ajax', 'ux_theme_option_font_ajax');

//theme restore defaults
function ux_theme_option_restore(){
	$delete = delete_option('ux_theme_option');
	echo ($delete) ? 'success' : 'error';
	die('');
}
add_action('wp_ajax_ux_theme_option_restore', 'ux_theme_option_restore');

//load slider
function ux_theme_meta_slider_ajax(){
	$data = $_POST['data'];
	
	switch($data){
		case 'load-slider':
			$selected = (isset($_POST['selected'])) ? $_POST['selected'] : false; ?>
            
            <option value="-1" <?php selected($selected, '-1'); ?>><?php _e('Select a slider', 'ux'); ?></option>
            
			<?php $slider = $_POST['slider'];
			switch($slider){
				case 'zoomslider':
					$get_topslider = get_posts(array(
						'posts_per_page' => -1,
						'post_type' => 'zoomslider'
					));
					foreach($get_topslider as $zoomslider){ ?>
						<option value="<?php echo $zoomslider->post_name; ?>" <?php selected($selected, $zoomslider->post_name); ?>><?php echo $zoomslider->post_title; ?></option>
					<?php
					}
				break;
				
				case 'revolutionslider':
					global $wpdb;
					$table_revslider = $wpdb->prefix . "revslider_sliders";
					$revslidersliders = $wpdb->get_results($wpdb->prepare("
						SELECT * FROM $table_revslider
						ORDER BY id ASC
						", $table_revslider
					));
					
					if(count($revslidersliders)){
						$slider_revslider = array();
						foreach($revslidersliders as $num => $slider){
							$params = (array) json_decode($slider->params);
							if(isset($params['template'])){
								$template = $params['template'] == 'true' ? true : false;
								if(!$template){ ?>
									<option value="<?php echo $slider->alias; ?>" <?php selected($selected, $slider->alias); ?>><?php echo $slider->title; ?></option>
								<?php
								}
							}
                        }
					}
				break;
				
				case 'layerslider':
					global $wpdb;
					$table_layerslider = $wpdb->prefix . "layerslider";
					$layerslider = $wpdb->get_results($wpdb->prepare("
						SELECT * FROM %s
						WHERE flag_hidden = '0' AND flag_deleted = '0'
						ORDER BY id ASC
						", $table_layerslider
					));
					
					if(count($layerslider)){
						$slider_layerslider = array();
						foreach($layerslider as $num => $slider){
							$name = empty($slider->name) ? 'Unnamed' : $slider->name; ?>
                            <option value="<?php echo $slider->id; ?>" <?php selected($selected, $slider->id); ?>><?php echo $name; ?></option>
						<?php	
						}
					}
				break;
			}
			
		break;
	}
	die('');
}
add_action('wp_ajax_ux_theme_meta_slider_ajax', 'ux_theme_meta_slider_ajax');

?>