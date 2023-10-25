<?php
//theme option getfield
function ux_theme_option_getfield($item, $key){
	$select_fields   = ux_theme_options_config_select_fields();
	$fonts_size      = ux_theme_options_fonts_size();
	$fonts_style     = ux_theme_options_fonts_style();
	$social_networks = ux_theme_social_networks();
	$theme_color     = ux_theme_color();
	
	$type            = isset($item['type'])        ? $item['type'] : false;
	$name            = isset($item['name'])        ? $item['name'] : false;
	$title           = isset($item['title'])       ? $item['title'] : false;
	$size            = isset($item['size'])        ? $item['size'] : false;
	$button          = isset($item['button'])      ? $item['button'] : false;
	$default         = isset($item['default'])     ? $item['default'] : false;
	$control         = isset($item['control'])     ? $item['control'] : false;
	$special         = isset($item['special'])     ? $item['special'] : false;
	$placeholder     = isset($item['placeholder']) ? $item['placeholder'] : false;
	$description     = isset($item['description']) ? $item['description'] : false;
	$col_size        = isset($item['col_size'])    ? $item['col_size'] : false;
	$col_style       = isset($item['col_style'])   ? $item['col_style'] : false;
	$scheme_name     = isset($item['scheme-name']) ? $item['scheme-name'] : false;
	$notice          = isset($item['notice'])      ? $item['notice'] : false;
	$taxonomy        = isset($item['taxonomy'])    ? $item['taxonomy'] : 'category';
	
	if($key == 'ux_theme_option'){
		$get_option = get_option($key);
	}else{
		$get_option = get_post_meta(get_the_ID(), $key, true);
	}
	
	$get_value   = isset($get_option[$name]) ? $get_option[$name] : $default;
	$control     = $control ? 'data-name="' . $control['name'] . '" data-value="' . $control['value'] . '"' : false;
	$scheme_name = $scheme_name ? 'data-scheme="scheme_' . $scheme_name . '"' : false;
		
	if($type){
		switch($type){
			case 'description': ?>
				<div class="row">
                    <div class="col-xs-12 text-muted"><?php echo $description; ?></div>
                </div>
			<?php
            break;
			
			case 'color-scheme':
				if($get_value){
					$color_scheme = $get_value;
				}else{
					$get_option['theme_option_color_scheme'] = ux_theme_options_color_scheme();
					update_option('ux_theme_option', $get_option);
					$get_option = get_option('ux_theme_option');
					$color_scheme = isset($get_option[$name]) ? $get_option[$name] : $default;
				}
				
				$current_scheme = isset($get_option[$name . '_current']) ? $get_option[$name . '_current'] : 'scheme-1';
				
				if(count($color_scheme)){ ?>
                    <ul class="nav nav-pills ux-theme-color-scheme">
						<?php foreach($color_scheme as $id => $schemes){
							$theme_main_color = false;
							$page_bg_color = false;
							foreach($schemes as $scheme){
								if($scheme['name'] == 'theme_main_color'){
									$theme_main_color = $scheme['value'];
								}
								if($scheme['name'] == 'page_post_bg_color'){
									$page_bg_color = $scheme['value'];
								}
							}
							
							$active = $current_scheme == $id ? 'active' : false; ?>
                            
                            <li class="scheme-item <?php echo $active; ?>" style="background-color: <?php echo $page_bg_color; ?>" data-scheme-id="<?php echo $id; ?>">
								<?php foreach($schemes as $i => $scheme){ ?>
                                    <input type="hidden" name="ux_theme_option[theme_option_color_scheme][<?php echo $id; ?>][<?php echo $i; ?>][name]" value="<?php echo $scheme['name']; ?>" />
                                    <input type="hidden" name="ux_theme_option[theme_option_color_scheme][<?php echo $id; ?>][<?php echo $i; ?>][value]" data-name="scheme_<?php echo $scheme['name']; ?>" value="<?php echo $scheme['value']; ?>" />
                                <?php } ?>
                                <span class="selected" style="border-color: <?php echo $theme_main_color; ?>"></span>
                                <div class="triangle" style="border-bottom-color: <?php echo $theme_main_color; ?>"></div>
                            </li>
                        <?php } ?>
                    </ul>
                    <input type="hidden" name="<?php echo $key . '[' . $name . '_current]'; ?>" value="<?php echo $current_scheme; ?>" />
                <?php     
				}
			break;
			
			case 'bg-color':
				if(count($theme_color) > 0){ ?>
                    <ul class="nav nav-pills ux-theme-color">
						<?php foreach($theme_color as $color){ ?>
                            <li><button type="button" class="btn" data-value="<?php echo $color['id']; ?>" style="background-color: <?php echo $color['rgb']; ?>"><span class="glyphicon glyphicon-ok"></span></button></li>
                        <?php } ?>
                        <li><button type="button" class="btn btn-cancelcolor"></button></li>
                    </ul>
                    <input type="hidden" name="<?php echo $key . '[' . $name . ']'; ?>" value="<?php echo $get_value; ?>">
				<?php
                }
			break;
			
			case 'divider': ?>
				<div class="ux-theme-divider"></div>
			<?php
            break;
			
			case 'button':
				$button_title   = isset($button['title']) ? $button['title'] : false;
				$button_type    = isset($button['type']) ? $button['type'] : false;
				$button_loading = isset($button['loading']) ? $button['loading'] : false;
				$button_class   = isset($button['class']) ? $button['class'] : false;
				$button_url     = isset($button['url']) ? $button['url'] : false;
				
				$data_url       = $button_url ? 'data-url="' . $button_url . '"' : false;
				$demo_data      = false;
				$data_notice    = $notice ? 'data-notice="' . esc_attr($notice) . '"' : false;
				
				if($button_type == 'import-demo-data'){
					$file = '../wp-content/themes/'.get_stylesheet().'/functions/theme/demo-data.xml';
					$demo_data = 'data-xml="' . $file . '" data-attachments="0"';
					wp_nonce_field('import-wordpress');
				} ?>
                <button type="button" class="btn <?php echo $button_class; ?>" data-ux-button="<?php echo $button_type; ?>" data-loading-text="<?php echo $button_loading; ?>" <?php echo $data_url; ?> <?php echo $demo_data; ?> <?php echo $data_notice; ?>><?php echo $button_title; ?></button>
            <?php
			break;
			
			case 'text': ?>
				<div class="form-group" style=" <?php echo $col_style; ?>">
                    <input type="text" name="<?php echo $key . '[' . $name . ']'; ?>" placeholder="<?php echo $placeholder; ?>" class="form-control" value="<?php echo $get_value; ?>" style=" <?php echo $col_size; ?>" />
                </div>
			<?php
			break;
			
			case 'textarea': ?>
                <div class="form-group">
                    <textarea rows="4" class="form-control" name="<?php echo $key . '[' . $name . ']'; ?>"><?php echo stripslashes($get_value); ?></textarea>
                </div>
            <?php
			break;
			
			case 'checkbox': ?>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="make-checkbox"> <?php echo $title; ?>
                        <input type="hidden" name="<?php echo $key . '[' . $name . ']'; ?>" value="<?php echo $get_value; ?>">
                    </label>
                </div>
            <?php
			break;
			
			case 'checkbox-group':
				if($select_fields[$name]){ ?>
                    <ul class="nav nav-pills ux-theme-checkbox-group" <?php echo $control; ?>>
                        <?php foreach($select_fields[$name] as $i => $select){
							$value = false;
							if(is_array($get_value)){
								$value = (in_array($select['value'], $get_value)) ? $select['value'] : false;
							} ?>
                            <li>
                                <input type="checkbox" name="<?php echo $key . '[' . $name . '][]'; ?>" value="<?php echo $select['value']; ?>" <?php checked($value, $select['value']); ?>>
                                <span class="pull-left"><?php echo $select['title']; ?></span>
                            </li>
                        <?php } ?>
                    </ul>
				<?php
				}
			break;
			
			case 'switch': ?>
                <div class="switch make-switch" data-on="success" data-off="danger">
                    <input type="checkbox" value="true" <?php checked($get_value, 'true'); ?> />
                    <input type="hidden" name="<?php echo $key . '[' . $name . ']'; ?>" data-class="<?php echo $name; ?>" value="<?php echo $get_value; ?>" data-value="<?php echo $get_value; ?>" />
                </div>
            <?php
			break; 
			
			case 'switch-color': ?>
                <div class="row" style="margin-bottom:0px;">
                    <h5 class="col-sm-8"><?php echo $title; ?></h5>
                    <div class="form-group ux-theme-switch-color col-sm-4" <?php echo $scheme_name; ?>>
                        <input type="text" class="form-control switch-color" data-position="bottom left" value="<?php echo $get_value; ?>" name="<?php echo $key . '[' . $name . ']'; ?>" />
                        <span class="ux-theme-remove-color"></span>
                    </div>
                </div>
            <?php
			break;
			
			case 'upload': ?>
                <div class="input-group theme-option-upload">
                    <input type="text" name="<?php echo $key . '[' . $name . ']'; ?>" placeholder="<?php echo $placeholder; ?>" class="form-control" value="<?php echo $get_value; ?>" />
                    <span class="input-group-btn">
                        <button class="btn btn-default ux-theme-upload-image" type="button"><?php _e('Upload Image', 'ux'); ?></button>
                        <button class="btn btn-danger ux-theme-remove-image" type="button"><?php _e('Remove', 'ux'); ?></button>
                    </span>
                </div>
            <?php
			break; 
			
			case 'select':
				if($select_fields[$name]){ ?>
                    <select class="form-control input-sm" name="<?php echo $key . '[' . $name . ']'; ?>" <?php echo $control; ?> style=" <?php echo $col_size; ?>" data-selected="<?php echo $get_value; ?>" data-class="<?php echo $name; ?>" data-value="<?php echo $get_value; ?>">
                        <?php foreach($select_fields[$name] as $select){ ?>
                            <option value="<?php echo $select['value']; ?>" <?php selected($get_value, $select['value']); ?>><?php echo $select['title']; ?></option>
                        <?php } ?>
                    </select>
                <?php
				}
			break;
			
			case 'select-front':
				$get_pages = get_pages();
				$show_on_front = get_option('show_on_front');
				$page_on_front = get_option('page_on_front');
				if($show_on_front == 'page'){
					$get_value = $page_on_front;
				} ?>
				<select class="form-control input-sm" name="<?php echo $key . '[' . $name . ']'; ?>">
                    <option value="-1"><?php _e('Homepage','ux') ?></option>
					<?php foreach($get_pages as $page){ ?>
                        <option value="<?php echo $page->ID; ?>" <?php selected($get_value, $page->ID); ?>><?php echo $page->post_title; ?></option>
                    <?php } ?>
				</select>
			<?php
            break;
			
			case 'select-images':
				$get_value = get_option('ux_theme_option_icons_custom'); ?>
                <div class="input-group theme-option-select-images">
                    <button type="button" class="btn btn-primary ux-theme-select-images" data-name="<?php echo $name; ?>"><?php _e('Select Images', 'ux'); ?></button>
                </div>
                <div class="theme-option-select-images-content">
                    <ul class="nav nav-pills">
						<?php if($get_value){
                            foreach($get_value as $portfolio){
                                $image_src = wp_get_attachment_image_src($portfolio); ?>
                                <li><img src="<?php echo $image_src[0]; ?>" /><input type="hidden" name="<?php echo $key . '[' . $name . '][]'; ?>" value="<?php echo $portfolio; ?>"/><span class="glyphicon glyphicon-remove"></span></li>
                            <?php
                            }
                        } ?>
                    
                    </ul>
                </div>
            <?php
			break;
			
			case 'image-select':
				if($select_fields[$name]){
					$sizes = explode(':', $size);
					$width_size = (isset($sizes[0])) ? 'width: ' . $sizes[0] . 'px;' : false;
					$height_size = (isset($sizes[1])) ? 'height: ' . $sizes[1] . 'px;' : false; ?>
                    <div class="ux-theme-image-select">
                        <ul class="nav nav-pills">
                            <?php foreach($select_fields[$name] as $select){
								$active = ($get_value == $select['value']) ? 'active' : false; ?>
                                <li class="<?php echo $active; ?>" style=" <?php echo $width_size; ?> <?php echo $height_size; ?>">
                                    <a href="#" class="<?php echo $select['value']; ?>" style=" <?php echo $width_size; ?> <?php echo $height_size; ?>"></a>
                                    <span class="selected"></span>
                                </li>
                            <?php } ?>
                        </ul>
                        <input type="hidden" data-value="<?php echo $get_value; ?>" data-class="<?php echo $name; ?>" name="<?php echo $key . '[' . $name . ']'; ?>" value="<?php echo $get_value; ?>">
                    </div>
                <?php
				}
			break;
			
			case 'fonts-family': ?>
                <div class="col-sm-5 ux-theme-no-col">
                    <select class="form-control input-sm ux-theme-font-family" name="<?php echo $key . '[' . $name . ']'; ?>">
                        <option value="-1"><?php _e('-- Select Font --', 'ux'); ?></option>
                        <?php $json = get_option('ux_theme_googlefont');
						if($json){
							$fonts_object = json_decode($json);
							if($fonts_object && is_object($fonts_object)){
								if($fonts_object->items && is_array($fonts_object->items)){
									$fonts = $fonts_object->items;
									foreach($fonts as $item){
										$family_val = str_replace(' ', '+', $item->family); ?>
										<option value="<?php echo $family_val; ?>" <?php selected($get_value, $family_val); ?>><?php echo $item->family; ?></option>
									<?php
									}
								}
							}
						} ?>
                    </select>
                </div>
            <?php
			break;
			
			case 'fonts-size': ?>
                <div class="col-sm-2 ux-theme-no-col">
                    <select class="form-control input-sm ux-theme-font-size" name="<?php echo $key . '[' . $name . ']'; ?>">
                        <?php foreach($fonts_size as $size){ ?>
                            <option value="<?php echo $size; ?>" <?php selected($get_value, $size); ?>><?php echo $size; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php
			break;
			
			case 'fonts-style': ?>
                <div class="col-sm-4 ux-theme-no-col">
                    <select class="form-control input-sm ux-theme-font-style" name="<?php echo $key . '[' . $name . ']'; ?>" data-value="<?php echo $get_value; ?>">
                        <?php foreach($fonts_style as $style){ ?>
                            <option value="<?php echo $style['value']; ?>" <?php selected($get_value, $style['value']); ?>><?php echo $style['value']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php
			break;
			
			case 'new-social-medias': ?>
                <div class="ux-theme-new-social-medias" <?php echo $control; ?>>
                    <?php if($get_value && isset($get_value['icontype'])){
                        $icon_type = $get_value['icontype'];
                        foreach($icon_type as $num => $type){
                            $icon = $get_value['icon'][$num];
                            $url = $get_value['url'][$num];
                            $tip = $get_value['tip'][$num];
							$button_remove = $num == 0 ? 'hidden' : false;
							$button_remove_style = $num == 0 ? false : 'style="right: 40px;"';
							$button_add = $num != 0 ? 'hidden' : false; ?>
                            
                            <div class="ux-theme-social-medias" rel="<?php echo $num; ?>">
                                <div class="new-media-col-select-icon pull-left">
                                    <button type="button" class="btn btn-default btn-sm" data-title="<?php _e('Select Icon', 'ux'); ?>"><i class="fa fa-ellipsis-h"></i></button>
                                </div>
                                <div class="new-media-col-icon pull-left">
                                    <div class="icon-content">
										<?php if($type == 'fontawesome'){ ?>
                                            <i class="<?php echo $icon; ?>"></i>
                                        <?php }elseif($type == 'user'){ ?>
                                            <img src="<?php echo $icon; ?>" />
                                        <?php } ?>
                                    </div>
                                    <input type="hidden" name="<?php echo $key . '[' . $name . ']'; ?>[icon][]" value="<?php echo $icon; ?>" />
                                    <input type="hidden" name="<?php echo $key . '[' . $name . ']'; ?>[icontype][]" value="<?php echo $type; ?>" />
                                </div>
                                <div class="new-media-col-url">
                                    <input type="text" name="<?php echo $key . '[' . $name . ']'; ?>[url][]" class="form-control input-sm pull-left" value="<?php echo $url; ?>" placeholder="<?php _e('Enter the social media url', 'ux'); ?>" />
                                    <input type="text" name="<?php echo $key . '[' . $name . ']'; ?>[tip][]" class="form-control input-sm pull-right" value="<?php echo $tip; ?>" placeholder="<?php _e('Tip for mouseover', 'ux'); ?>" />
                                </div>
                                <div class="new-media-col-remove pull-right <?php echo $button_remove; ?>" <?php echo $button_remove_style; ?>>
                                    <button type="button" class="btn btn-danger btn-sm social-medias-remove"><span class="glyphicon glyphicon-remove"></span></button>
                                </div>
                                <div class="new-media-col-add pull-right <?php echo $button_add; ?>">
                                    <button type="button" class="btn btn-info btn-sm social-medias-add "><span class="glyphicon glyphicon-plus"></span></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php
                        }
                    }else{ ?>
                        <div class="ux-theme-social-medias" rel="0">
                            <div class="new-media-col-select-icon pull-left">
                                <button type="button" class="btn btn-default btn-sm" data-title="<?php _e('Select Icon', 'ux'); ?>"><i class="fa fa-ellipsis-h"></i></button>
                            </div>
                            <div class="new-media-col-icon pull-left">
                                <div class="icon-content"></div>
                                <input type="hidden" name="<?php echo $key . '[' . $name . ']'; ?>[icon][]" value="" />
                                <input type="hidden" name="<?php echo $key . '[' . $name . ']'; ?>[icontype][]" value="" />
                            </div>
                            <div class="new-media-col-url">
                                <input type="text" name="<?php echo $key . '[' . $name . ']'; ?>[url][]" class="form-control input-sm pull-left" value="" placeholder="<?php _e('Enter the social media url', 'ux'); ?>" />
                                <input type="text" name="<?php echo $key . '[' . $name . ']'; ?>[tip][]" class="form-control input-sm pull-right" value="" placeholder="<?php _e('Tip for mouseover', 'ux'); ?>" />
                            </div>
                            <div class="new-media-col-remove pull-right hidden">
                                <button type="button" class="btn btn-danger btn-sm social-medias-remove"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                            <div class="new-media-col-add pull-right">
                                <button type="button" class="btn btn-info btn-sm social-medias-add "><span class="glyphicon glyphicon-plus"></span></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>
                </div>
			<?php
            break;
			
			case 'social-medias': ?>
                <div class="ux-theme-social-medias-lists" <?php echo $control; ?>>
					<?php 
					$placeholder_name = isset($placeholder[0]) ? $placeholder[0] : false;
					$placeholder_url  = isset($placeholder[1]) ? $placeholder[1] : false;
					if($get_value){
						foreach($get_value['name'] as $i => $m_name){
							$m_url = $get_value['url'][$i];
							$hidden_add = ($i == 0) ? false : 'hidden';
							$hidden_remove = ($i != 0) ? false : 'hidden'; ?>
							<div class="ux-theme-social-medias">
								<div class="col-sm-3 ux-theme-no-col">
									<?php if($special == 'mp3'){ ?>
										<input type="text" name="<?php echo $key . '[' . $name . ']'; ?>[name][]" class="form-control input-sm" value="<?php echo $m_name; ?>" placeholder="<?php echo $placeholder_name; ?>" />
									<?php }else{ ?>
                                        <select class="form-control input-sm" name="<?php echo $key . '[' . $name . ']'; ?>[name][]">
                                            <?php foreach($social_networks as $social){ ?>
                                                <option value="<?php echo $social['slug']; ?>" <?php selected($m_name, $social['slug']); ?>><?php echo $social['slug']; ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
								</div>
								<div class="col-sm-6 ux-theme-no-col">
									<input type="text" name="<?php echo $key . '[' . $name . ']'; ?>[url][]" class="form-control input-sm" value="<?php echo $m_url; ?>" placeholder="<?php echo $placeholder_url; ?>" />
								</div>
								<div class="col-sm-3 ux-theme-no-col">
									<button type="button" class="btn btn-info btn-sm social-medias-add <?php echo $hidden_add; ?>"><span class="glyphicon glyphicon-plus"></span></button>
									<button type="button" class="btn btn-danger btn-sm social-medias-remove <?php echo $hidden_remove; ?>"><span class="glyphicon glyphicon-remove"></span></button>
								</div>
								<div class="clearfix"></div>
							</div>
						<?php 
						}
					}else{ ?>
                        <div class="ux-theme-social-medias">
                            <div class="col-sm-3 ux-theme-no-col">
                                <?php if($special == 'mp3'){ ?>
                                    <input type="text" name="<?php echo $key . '[' . $name . ']'; ?>[name][]" class="form-control input-sm" value="" placeholder="<?php echo $placeholder_name; ?>" />
                                <?php }else{ ?>
                                    <select class="form-control input-sm" name="<?php echo $key . '[' . $name . ']'; ?>[name][]">
                                        <?php foreach($social_networks as $social){ ?>
                                            <option value="<?php echo $social['slug']; ?>" <?php selected($default, $social['slug']); ?>><?php echo $social['slug']; ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6 ux-theme-no-col">
                                <input type="text" name="<?php echo $key . '[' . $name . ']'; ?>[url][]" class="form-control input-sm" value="" placeholder="<?php echo $placeholder_url; ?>" />
                            </div>
                            <div class="col-sm-3 ux-theme-no-col">
                                <button type="button" class="btn btn-info btn-sm social-medias-add"><span class="glyphicon glyphicon-plus"></span></button>
                                <button type="button" class="btn btn-danger btn-sm social-medias-remove hidden"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>
                </div>
			<?php
			break;
			
			case 'gallery': ?>
                 <div class="row">
                     <div class="col-xs-12"><button type="button" class="btn btn-primary ux-theme-gallery-select-images"><?php _e('Select Images', 'ux'); ?></button></div>
                 </div>
                
                <div class="row ux-theme-gallery-select">
                    <div class="col-xs-12">
                        <ul class="nav nav-pills">
                        <?php if(is_array($get_value)){
							foreach($get_value as $image){
								$image_full = wp_get_attachment_image_src($image, 'full'); ?>
                                
								<li><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button><a href="#" class="thumbnail"><span class="border"></span><img src="<?php echo $image_full[0]; ?>" width="200" /></a><input type="hidden" name="ux_theme_meta[theme_meta_portfolio][]" value="<?php echo $image; ?>" /></li>
							<?php
                            }
						} ?>
                        </ul>
                    </div>
                </div>
            <?php
			break;
			
			case 'ratio': ?>
                <div data-id="ux-theme-ratio" class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" name="<?php echo $key . '[' . $name . ']'; ?>[1]" value="<?php echo $get_value[1]; ?>">
                    </div>
                    <div class="form-group">:</div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="<?php echo $key . '[' . $name . ']'; ?>[2]" value="<?php echo $get_value[2]; ?>">
                    </div>
                </div>
            <?php
			break;
			
			case 'category': 
				$categories = get_categories(array(
					'type'     => 'any',
					'taxonomy' => $taxonomy
				));
				
				if($categories){
					wp_dropdown_categories(array(
						'show_option_all'  => __('All Categories', 'ux'),
						'class'            => 'form-control', 
						'name'             => $key . '[' . $name . ']',
						'id'               => 'ux-theme-options-' . $name,
						'show_count'       => 1,
						'taxonomy'         => $taxonomy,
						'selected'         => $get_value
					));
				}else{ ?>
                    <select class="form-control" name="<?php echo $key . '[' . $name . ']'; ?>">
                        <option selected="selected" value="0"><?php _e('No Categories', 'ux'); ?></option>
                    </select>
                <?php	
				}
			break;
			
			case 'orderby': ?>
				<div class="form-group row">
                    <div class="col-xs-6">
						<?php if(isset($select_fields[$name])){ ?>
                            <select class="form-control" name="<?php echo $key . '[' . $name . ']'; ?>">
                                <?php foreach($select_fields[$name] as $select){ ?>
                                    <option value="<?php echo $select['value']; ?>" <?php selected($get_value, $select['value']); ?>><?php echo $select['title']; ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>
                    </div>
                    <div class="col-xs-6">
						<?php $name = 'theme_meta_order';
                        $get_value = isset($get_option[$name]) ? $get_option[$name] : 'DESC';
                        if(isset($select_fields[$name])){ ?>
                            <select class="form-control" name="<?php echo $key . '[' . $name . ']'; ?>">
                                <?php foreach($select_fields[$name] as $select){ ?>
                                    <option value="<?php echo $select['value']; ?>" <?php selected($get_value, $select['value']); ?>><?php echo $select['title']; ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>
                    </div>
                </div>
			<?php
			break;
			
			case 'property':
				$placeholder_title = isset($placeholder[0]) ? $placeholder[0] : false;
				$placeholder_content  = isset($placeholder[1]) ? $placeholder[1] : false;
				$placeholder_url  = isset($placeholder[2]) ? $placeholder[2] : false;
				
				if($get_value){
					foreach($get_value['title'] as $i => $this_title){
						$this_content = $get_value['content'][$i];
						$this_url = $get_value['url'][$i];
						$hidden_add = ($i == 0) ? false : 'hidden';
						$hidden_remove = ($i != 0) ? false : 'hidden'; ?>
                        
                        <div class="row property-item">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon"><?php echo $placeholder_title; ?></span>
                                            <input type="text" class="form-control input-sm" name="<?php echo $key . '[' . $name . '][title][]'; ?>" placeholder="<?php echo $placeholder_title; ?>" value="<?php echo $this_title; ?>" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-7">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon"><?php echo $placeholder_content; ?></span>
                                            <input type="text" class="form-control input-sm" name="<?php echo $key . '[' . $name . '][content][]'; ?>" placeholder="<?php echo $placeholder_content; ?>" value="<?php echo $this_content; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon"><?php echo $placeholder_url; ?></span>
                                            <input type="text" class="form-control input-sm" name="<?php echo $key . '[' . $name . '][url][]'; ?>" placeholder="<?php echo $placeholder_url; ?>" value="<?php echo $this_url; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <button type="button" class="btn btn-info btn-sm property-add <?php echo $hidden_add; ?>"><span class="glyphicon glyphicon-plus"></span></button>
                                <button type="button" class="btn btn-danger btn-sm property-remove <?php echo $hidden_remove; ?>"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                        </div>
				
					 <?php
					 }
					 
				}else{ ?>
                
                    <div class="row property-item">
                        <div class="col-xs-10">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon"><?php echo $placeholder_title; ?></span>
                                        <input type="text" class="form-control input-sm" name="<?php echo $key . '[' . $name . '][title][]'; ?>" placeholder="<?php echo $placeholder_title; ?>" />
                                    </div>
                                </div>
                                
                                <div class="col-xs-7">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon"><?php echo $placeholder_content; ?></span>
                                        <input type="text" class="form-control input-sm" name="<?php echo $key . '[' . $name . '][content][]'; ?>" placeholder="<?php echo $placeholder_content; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon"><?php echo $placeholder_url; ?></span>
                                        <input type="text" class="form-control input-sm" name="<?php echo $key . '[' . $name . '][url][]'; ?>" placeholder="<?php echo $placeholder_url; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <button type="button" class="btn btn-info btn-sm property-add"><span class="glyphicon glyphicon-plus"></span></button>
                            <button type="button" class="btn btn-danger btn-sm property-remove hidden"><span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </div>
                <?php
				}
            break;
		}
	}
}
?>