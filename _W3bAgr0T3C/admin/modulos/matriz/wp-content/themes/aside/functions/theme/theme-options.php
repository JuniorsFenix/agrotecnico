<?php
//require theme config
require_once locate_template('/functions/theme/options/options-config.php');

//theme option menu
function ux_theme_option_menu(){
	add_menu_page(__('Aside','ux'), __('Aside','ux'), 'administrator', 'theme-option', 'ux_theme_option_interface');
}
add_action('admin_menu', 'ux_theme_option_menu');

//theme option interface
function ux_theme_option_interface(){
	require_once locate_template('/functions/theme/options/options-interface.php');
}

//theme google font style
function ux_theme_google_font_style($style){
	switch($style){
		case 'bold'     : $style = 'font-weight: bold; font-style: normal;';   break;
		case '100'      : $style = 'font-weight: 100; font-style: normal;';    break;
		case '200'      : $style = 'font-weight: 200; font-style: normal;';    break;
		case '300'      : $style = 'font-weight: 300; font-style: normal;';    break;
		case '400'      : $style = 'font-weight: 400; font-style: normal;';    break;
		case '500'      : $style = 'font-weight: 500; font-style: normal;';    break;
		case '600'      : $style = 'font-weight: 600; font-style: normal;';    break;
		case '700'      : $style = 'font-weight: 700; font-style: normal;';    break;
		case '800'      : $style = 'font-weight: 800; font-style: normal;';    break;
		case '900'      : $style = 'font-weight: 900; font-style: normal;';    break;
		case 'italic'   : $style = 'font-weight: normal; font-style: italic;'; break;
		case '100italic': $style = 'font-weight: 100; font-style: italic;';    break;
		case '200italic': $style = 'font-weight: 200; font-style: italic;';    break;
		case '300italic': $style = 'font-weight: 300; font-style: italic;';    break;
		case '400italic': $style = 'font-weight: 400; font-style: italic;';    break;
		case '500italic': $style = 'font-weight: 500; font-style: italic;';    break;
		case '600italic': $style = 'font-weight: 600; font-style: italic;';    break;
		case '700italic': $style = 'font-weight: 700; font-style: italic;';    break;
		case '800italic': $style = 'font-weight: 800; font-style: italic;';    break;
		case '900italic': $style = 'font-weight: 900; font-style: italic;';    break;
		default         : $style = 'font-weight: normal; font-style: normal;'; break;
	}
	return $style;
}

//theme color
function ux_theme_switch_color($key, $to='value'){
	$theme_color = ux_theme_color();
	$return = false;
	foreach($theme_color as $color){
		if($color['id'] == $key){
			$return = $color[$to];
		}
	}
	return $return;
}

//theme option default
function ux_theme_option_default($key){
	$theme_config_fields = ux_theme_options_config_fields();
	$default = false;
	foreach($theme_config_fields as $option){
		foreach($option['section'] as $section){
			if(isset($section['item'])){
				foreach($section['item'] as $item){
					if($item['name'] == $key){
						$default = isset($item['default']) ? $item['default'] : false;
						if($default == 'true'){
							$default = true;
						}elseif($default == 'false'){
							$default = false;
						}
					}else{
						if(isset($item['bind'])){
							foreach($item['bind'] as $bind){
								if($bind['name'] == $key){
									$default = isset($bind['default']) ? $bind['default'] : false;
									if($default == 'true'){
										$default = true;
									}elseif($default == 'false'){
										$default = false;
									}
								}
							}
						}
					}
				}
			}
		}
	}
	return $default;
}

//theme option save
function ux_theme_option_save(){
	$_uxnonce = (isset($_POST['_uxnonce'])) ? $_POST['_uxnonce'] : false;
	if(isset($_POST['action'])){
		if(!wp_verify_nonce($_uxnonce, admin_url('admin.php?page=theme-option'))){
			die('warning'); 
		}else{
			if(isset($_POST['ux_theme_option'])){
				update_option('ux_theme_option', $_POST['ux_theme_option']);
				
				if(isset($_POST['ux_theme_option']['theme_option_frontpage'])){
					$new = $_POST['ux_theme_option']['theme_option_frontpage']; 
					if($new == '-1'){
						$show_on = 'posts';
						$page_on = '0';
					}else{
						$show_on = 'page';
						$page_on = $new;
					}
					
					update_option('show_on_front', $show_on); 
					update_option('page_on_front', $page_on); 
				}
				
				if(isset($_POST['ux_theme_option']['theme_option_icons_custom'])){
					update_option('ux_theme_option_icons_custom', $_POST['ux_theme_option']['theme_option_icons_custom']);
				}
			}
		}
	}
}

//require theme option fields
require_once locate_template('/functions/theme/options/options-fields.php');

function ux_theme_option_modal(){ ?>
    <div class="modal fade" id="ux-theme-modal" tabindex="-1" role="dialog" aria-labelledby="ux-theme-modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="ux-theme-modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div id="ux-theme-modal-body"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'ux'); ?></button>
                    <button type="button" class="btn btn-primary"><?php _e('Insert', 'ux'); ?></button>
                    <button type="button" class="btn btn-success ux-theme-modal-agree"><?php _e('Agree', 'ux'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>