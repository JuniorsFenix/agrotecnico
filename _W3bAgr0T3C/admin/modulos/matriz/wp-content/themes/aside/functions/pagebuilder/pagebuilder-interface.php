<?php
//pagebuilder switch
function ux_pb_switch($post){
	$get_switch = get_post_meta($post->ID, 'ux-pb-switch', true);
	$get_switch = $get_switch ? $get_switch : 'classic';
	$text_pagebuilder = __('Switch to Page Builder','ux');
	$text_classic = __('Classic Editor','ux');
	$button_style = $get_switch == 'classic' ? 'button-primary' : false;
	$button_text = $get_switch == 'classic' ? $text_pagebuilder : $text_classic;
	
	if($post->post_type == 'post' || $post->post_type == 'page'){ ?>
        <div id="ux-pb-switch">
            <input type="button" class="switch-btn button <?php echo $button_style; ?> button-large" value="<?php echo $button_text; ?>" />
            <input type="hidden" name="ux-pb-switch" class="switch-value" value="<?php echo $get_switch; ?>" />
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('.switch-btn').each(function(){
                    var _t = jQuery(this);
                    var _wp_pd = _t.parents('#post-body-content').find('#postdivrich');
                    var _pb_box = _t.parents('#post-body-content').find('#ux-pb-box');
					var ux_pb_box_container = jQuery('.ux-pb-box-container');
					var ux_pb_subbox_container = jQuery('.ux-pb-subbox-container');
                    
                    _t.click(function(){
                        var _this = jQuery(this);
                        if(_this.hasClass('button-primary')){
                            _this.removeClass('button-primary').val('<?php echo $text_classic;?>');
                            _this.next('.switch-value').val('pagebuilder');
                            _wp_pd.slideUp(); _pb_box.show();
							
							var ux_pb = new PageBuilder();
							ux_pb.refreshitem();
							if(ux_pb_subbox_container.length){
								ux_pb_subbox_container.each(function(index, element){
									var _this = jQuery(this);
									_this.isotope('reloadItems').isotope({sortBy: 'original-order'}, function(){
										ux_pb.refreshitem();
										_this.isotope('reLayout'); 
									});
								});
							}
							
							ux_pb_subbox_container.isotope('reloadItems').isotope({sortBy: 'original-order'}, function(){
								 ux_pb_box_container.isotope('reLayout'); 
							});
							
							setTimeout(function(){
								ux_pb_subbox_container.isotope('reLayout')
								ux_pb_box_container.isotope('reLayout'); 
							}, 1000);
                        }else{
                            _this.addClass('button-primary').val('<?php echo $text_pagebuilder;?>');
                            _this.next('.switch-value').val('classic');
                            _wp_pd.slideDown(); _pb_box.hide();
                        }
					});
                });
            });
        </script>
    <?php
	}
}
add_action('edit_form_after_title', 'ux_pb_switch');

//pagebuilder wrap
function ux_pb_wrap($post){ ?>
    <div id="ux-pb-box" class="postbox ux-theme-box">
        <h3 class="hndle"><span><?php _e('Page Builder','ux');?></span></h3>
        <div class="inside">
            <div id="ux-pb-box-choose"><?php ux_pb_choose_module(); ?></div>
            
            <div id="ux-pb-box-cols">
                <input pb-col='12' value="1/1" type="hidden" />
                <input pb-col="9" value="3/4" type="hidden" />
                <input pb-col="8" value="2/3" type="hidden" />
                <input pb-col="6" value="1/2" type="hidden" />
                <input pb-col="4" value="1/3" type="hidden" />
                <input pb-col="3" value="1/4" type="hidden" />
            </div>
            
            <div id="ux-pb-box-bgcolor"><?php ux_pb_box_bgcolor(); ?></div>
            
            <div id="ux-pb-box-toolbar">
                <div id="ux-pb-box-toolbar-main">
                    <?php do_action('ux-pb-box-toolbar-main'); ?>
                </div>
                <div id="ux-pb-box-toolbar-sub" class="text-right">
                    <?php do_action('ux-pb-box-toolbar-sub'); ?>
                </div>
            </div>
            <div id="ux-pb-box-container">
                <div class="ux-pb-box-container">
                    <?php ux_pb_load_module(get_the_ID()); ?>
                    
                </div>
            </div>
            
            <?php ux_pb_modal(); ?>
        </div>
    </div>
    <script type="text/javascript">
		jQuery(document).ready(function(){
			var ux_pb = new PageBuilder();
			ux_pb.init();
			ux_pb.modalsave();
			ux_pb.modaledit();
			ux_pb.loadtemplate();
			ux_pb.deletetemplate();
			
			jQuery(window).resize(function(){
				ux_pb.refreshitem();
			});
		});
    </script>
<?php
}
add_action('edit_form_after_editor', 'ux_pb_wrap');

//pagebuilder modal
function ux_pb_modal(){ ?>
    <div class="modal fade" id="ux-pb-modal" role="dialog" aria-labelledby="ux-pb-modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="model-open-subwin"></div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="ux-pb-modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div id="ux-pb-modal-body">
                        <div id="ux-pb-modal-body-before"></div>
                        <div id="ux-pb-box-editor">
                            <div class="row ux-pb-module-field" data-type="content" data-name="ux-pb-module-content">
                                <div class="col-xs-4">
                                    <h5><strong></strong></h5>
                                    <p class="text-muted"></p>
                                </div>
                                <div class="col-xs-8">
									<?php wp_editor('', 'ux-pb-module-content',
                                        array(
                                            'quicktags' => true,
                                            'tinymce' => true,
                                            'media_buttons' => true,
                                            'textarea_rows' => 10,
                                    )); ?>
                                </div>
                            </div>
                        </div>
                        <div id="ux-pb-modal-body-after"></div>
                    </div>
                </div>
                <div id="ux-pb-modal-footer" class="modal-footer">
                    <button type="button" class="btn btn-default ux-pb-modalclose" data-dismiss="modal"><?php _e('Close', 'ux'); ?></button>
                    <button type="button" data-loading-text="<?php _e('Saving...', 'ux'); ?>" class="btn btn-primary ux-pb-modalsave"><?php _e('Save', 'ux'); ?></button>
                    <button type="button" data-loading-text="<?php _e('Saving...', 'ux'); ?>" class="btn btn-success ux-pb-modaledit"><?php _e('Save Item', 'ux'); ?></button>
                    <button type="button" data-loading-text="<?php _e('Loading...', 'ux'); ?>" class="btn btn-success ux-pb-loadtemplate"><?php _e('Load Template', 'ux'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php
}

//pagebuilder toolbar wrap
function ux_pb_box_toolbar_wrap(){ ?>
    <div class="btn-group dropdown">
        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span> <?php _e('Wrap', 'ux'); ?></button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#" data-toggle="insert-wrap" data-id="general" data-target=".ux-pb-box-container"><?php _e('General Wrap', 'ux'); ?></a></li>
            <li><a href="#" data-toggle="insert-wrap" data-id="fullwidth" data-target=".ux-pb-box-container"><?php _e('FullWidth Wrap', 'ux'); ?></a></li>
        </ul>
    </div>
<?php	
}
add_action('ux-pb-box-toolbar-main', 'ux_pb_box_toolbar_wrap');

//pagebuilder toolbar wrap
function ux_pb_box_toolbar_choose(){
	$title = __('Choose Module', 'ux'); ?>
    <div class="btn-group">
        <button type="button" class="btn btn-default" data-target="#ux-pb-modal" data-totarget="ux-pb-box-container" data-title="<?php echo $title; ?>" data-id="choose-module"><?php echo $title; ?> <span class="glyphicon glyphicon-align-justify"></span></button>
    </div>
<?php	
}
add_action('ux-pb-box-toolbar-main', 'ux_pb_box_toolbar_choose');

//pagebuilder toolbar template
function ux_pb_box_toolbar_template(){ ?>
    <div class="btn-group dropdown">
        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"><?php _e('Template', 'ux'); ?> <span class="glyphicon glyphicon-align-justify"></span></button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#" data-target="#ux-pb-modal" data-title="<?php _e('Load a Template', 'ux'); ?>" data-id="load_template"><?php _e('Load a Template', 'ux'); ?></a></li>
        </ul>
    </div>
<?php	
}
add_action('ux-pb-box-toolbar-sub', 'ux_pb_box_toolbar_template');

//pagebuilder module interface template
function ux_pb_module_interface_template($col, $type, $first, $itemid, $moduleid, $items, $key){
	$module_post = ux_pb_item_postid($itemid);
	
	$cols = array(
		'12' => 'col-md-12',
		'9'  => 'col-md-9',
		'8'  => 'col-md-8',
		'6'  => 'col-md-6',
		'4'  => 'col-md-4',
		'3'  => 'col-md-3'
	);
	
	switch($type){
		case 'fullwidth':
			//fullwrap confing
			$height             = get_post_meta($module_post, 'module_fullwidth_height', true);
			$bg                 = get_post_meta($module_post, 'module_fullwidth_background', true);
			$bg_color           = get_post_meta($module_post, 'module_fullwidth_background_color', true);
			$bg_switch_color    = get_post_meta($module_post, 'module_fullwidth_background_switch_color', true);
			
			$show_bg_image      = get_post_meta($module_post, 'module_fullwidth_show_background_image', true);
			$bg_image           = get_post_meta($module_post, 'module_fullwidth_background_image', true);
			$bg_attachment      = get_post_meta($module_post, 'module_fullwidth_background_attachment', true);
			$bg_repeat          = get_post_meta($module_post, 'module_fullwidth_background_repeat', true);
			$bg_ratio           = get_post_meta($module_post, 'module_fullwidth_background_ratio', true);
			
			$video_image        = get_post_meta($module_post, 'module_fullwidth_alt_image', true);
			$video_webm         = get_post_meta($module_post, 'module_fullwidth_video_webm', true);
			$video_mp4          = get_post_meta($module_post, 'module_fullwidth_video_mp4', true);
			$video_ogg          = get_post_meta($module_post, 'module_fullwidth_video_ogg', true);
			
			$shadow             = get_post_meta($module_post, 'module_fullwidth_shadow', true);
			$dark_bg            = get_post_meta($module_post, 'module_fullwidth_dark_background', true);
			$dark_bg_check      = get_post_meta($module_post, 'module_fullwidth_dark_background_checkbox', true);
			
			$fit_content        = get_post_meta($module_post, 'module_fullwidth_fit_content', true);
			$spacer_top         = get_post_meta($module_post, 'module_fullwidth_spacer_top', true);
			$spacer_bottom      = get_post_meta($module_post, 'module_fullwidth_spacer_bottom', true);
			$spacer_top_in      = get_post_meta($module_post, 'module_fullwidth_spacer_in_top', true);
			$spacer_bottom_in   = get_post_meta($module_post, 'module_fullwidth_spacer_in_bottom', true);
			
			$via_tab            = get_post_meta($module_post, 'module_fullwidth_via_tab', true);
			$tabs               = get_post_meta($module_post, 'module_fullwidth_tabs', true);
			$anchor_name        = get_post_meta($module_post, 'module_fullwidth_anchor_name', true);
			
			$height             = $height ? 'height: ' . $height . 'px;' : false;
			
			$fit_content_before = $fit_content != 'on' ? '<div class="container">' : false;
			$fit_content_after  = $fit_content != 'on' ? '</div>' : false;
			
			$spacer_top         = $spacer_top == 'on' ? ' top-space-40' : false;
			$spacer_bottom      = $spacer_bottom == 'on' ? ' bottom-space-40' : false;
			$spacer_top_in      = $spacer_top_in == 'on' ? ' top-space-80-in' : false;
			$spacer_bottom_in   = $spacer_bottom_in == 'on' ? ' bottom-space-40-in' : false;
			
			$fullwrap_border    = $shadow == 'on' ? 'fullwrap-border' : false;
			$shadow             = $shadow == 'on' ? '<div class="fullwrap-shadow"></div>' : false;
			
			$bg_color           = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : false;
			$bg_color           = $bg_switch_color ? false : $bg_color;
			$bg_switch_color    = $bg_switch_color ? $bg_switch_color : false;
			$bg_repeat          = $bg_repeat == 'fill' ? ' background-size: cover;' : ' background-repeat: repeat;';
			
			$dark_bg            = $dark_bg == 'on' ? 'fullwidth-text-white' : false;
			$dark_bg_check      = is_array($dark_bg_check) ? in_array('text_shadow', $dark_bg_check) ? 'fullwidth-text-shadow' : false : $dark_bg_check  == 'text_shadow' ? 'fullwidth-text-shadow' : false;
			
			$background_color = false;
			$background_image = false;
			$background_attachment = false;
			$background_repeat = false;
			$background_position = false;
			$background_size = false;
			$background_parallax = false;
			$background_speed = false;
			
			switch($bg){
				case 'color':
					$background_color = 'background-color: ' . $bg_switch_color . ';';
					$bg_color = $bg_color;
				break;
				
				case 'image':
					$background_attachment = 'background-attachment: '.$bg_attachment.';';
					$background_repeat = 'background-repeat: no-repeat;';
					$background_position = 'background-position: top left;';
					$background_size = 'background-size: cover;';
					$background_image = $bg_image ? ' background-image: url('.$bg_image.'); ': false;
				break;
				
				case 'color_image':
					$background_color = 'background-color: ' . $bg_switch_color . ';';
					if($show_bg_image == 'on'){
						$background_attachment = $bg_attachment != 'parallax' ? 'background-attachment: '.$bg_attachment.';' : false;
						$background_parallax = $bg_attachment == 'parallax' ? 'parallax' : false;
						$background_repeat = $bg_repeat ;
						$background_image = $bg_image ? ' background-image: url('.$bg_image.'); ': false;
						$background_speed = 'data-speed="'.$bg_ratio.'"';
					}
				break;
			}
			
			$background_style  = '';
			$background_style .= $background_color . ' ';
			$background_style .= $background_repeat . ' ';
			$background_style .= $background_position . ' ';
			$background_style .= $background_size . ' ';
			$background_style .= $background_image . ' ';
			$background_style .= $background_attachment . ' ';
			
			//fullwrap confing end ?>
            
			<?php if($anchor_name){
				$anchor_name = str_replace(' ', '-', $anchor_name); ?>	
                <a name="<?php echo $anchor_name; ?>" class="fullwidth-anchor-name"></a>
            <?php } ?>
            
            <div id="<?php echo $anchor_name ?>" class="fullwidth-wrap <?php echo $fullwrap_border; ?> <?php echo $dark_bg_check; ?> <?php echo $dark_bg; ?> <?php echo $bg_color; ?> <?php echo $background_parallax; ?> <?php echo $spacer_top; ?> <?php echo $spacer_bottom; ?> <?php echo $spacer_top_in; ?> <?php echo $spacer_bottom_in; ?>" style=" <?php echo $height; ?> <?php echo $background_style; ?>" <?php echo $background_speed; ?>>
			
				<?php echo $shadow;
				
				if($bg == 'video'){ ?>
                    <div class="fullwrap-video">
                    	
                        <video autoplay loop poster="<?php echo $video_image; ?>" >
                            <?php if($video_webm){ ?>
                                <source src="<?php echo $video_webm; ?>" type="video/webm">
							<?php } ?>
                            
                            <?php if($video_mp4){ ?>
                                <source src="<?php echo $video_mp4; ?>" type="video/mp4">
							<?php } ?>
                            
                            <?php if($video_ogg){ ?>
                                <source src="<?php echo $video_ogg; ?>" type="video/ogg">
							<?php } ?>
                        </video>
<div class="video-cover" <?php if($video_image) { ?>style="background-image: url(<?php echo $video_image; ?>);"<?php } ?>></div>
                    </div><!---->
                <?php	
				}
				
				if($via_tab == 'on'){
					if($tabs){ ?>
						<nav class="fullwrap-with-tab-nav" data-itemid="<?php echo $itemid; ?>">
							<?php if(is_array($tabs)){
								foreach($tabs as $i => $tab){ 
									echo '<a href="javascript:;">' . $tab . '</a>';
								}
							}else{
								echo '<a href="javascript:;">' . $tabs . '</a>';
							} ?>
						</nav>
					<?php
					}
				}
				
				echo $fit_content_before;
				
				if($items){
                    echo '<div class="row-fluid">';
                    foreach($items as $i => $item){
                        $col = $item['col'];
                        $type = $item['type'];
                        $first = $item['first'];
                        $itemid = $item['itemid'];
                        $moduleid = $item['moduleid'];
                        
                        if($first == 'is'){
                            if($i != 0){
                                echo '</div>';
                                echo '<div class="row-fluid">';
                            }
                        }
                        
                        ux_pb_module_interface_template($col, $type, $first, $itemid, $moduleid, false, 'module');
                    }
                    echo '</div>';
                }
				echo $fit_content_after; ?>
            </div>
        <?php
		break;
		
		case 'general': ?>
            <div class="<?php echo $cols[$col]; ?> general_moudle">
				<?php if($items){
                    echo '<div class="row-fluid">';
                    foreach($items as $i => $item){
                        $col = $item['col'];
                        $type = $item['type'];
                        $first = $item['first'];
                        $itemid = $item['itemid'];
                        $moduleid = $item['moduleid'];
                        
                        if($first == 'is'){
                            if($i != 0){
                                echo '</div>';
                                echo '<div class="row-fluid">';
                            }
                        }
                        
                        ux_pb_module_interface_template($col, $type, $first, $itemid, $moduleid, false, 'module');
                    }
                    echo '</div>';
                } ?>
            </div>
		<?php
		break;
		
		case 'module':
			$ux_pb_module_fields  = ux_pb_module_fields();
			$animation_class = false;
			if(isset($ux_pb_module_fields[$moduleid])){
				if(isset($ux_pb_module_fields[$moduleid]['animation'])){
					$animation_class = $ux_pb_module_fields[$moduleid]['animation'];
				}
			}
			
			$advanced_settings    = get_post_meta($module_post, 'module_advanced_settings', true);
			$bottom_margin        = get_post_meta($module_post, 'module_bottom_margin', true);
			$scroll_animation  = get_post_meta($module_post, 'module_scroll_in_animation', true);
			$bottom_margin        = $advanced_settings == 'on' ? $bottom_margin : false;
			$animation_style      = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
			//$animation_style      = $animation_class == 'class-1' ? $animation_style : false;
			$scroll_in_animation  = $scroll_animation == 'on' ? 'moudle_has_animation' : false;
			$style_in_animation   = $scroll_animation == 'on' ? ' animation_hidden' : false;  ?>
            
			<div class="<?php echo $cols[$col]; ?> moudle <?php echo $scroll_in_animation; ?> <?php echo $animation_style; ?> <?php echo $bottom_margin; ?> <?php echo $style_in_animation; ?>" style="">
				<?php do_action('ux-pb-module-template-' . $moduleid, $itemid); ?>
			</div>
		<?php
        break;
	}
}

//pagebuilder module interface
function ux_pb_module_interface(){
	global $post;
	$ux_pb_meta = get_post_meta($post->ID, 'ux_pb_meta', true);
	
	if($ux_pb_meta){
		foreach($ux_pb_meta as $i => $wrap){
			$col = $wrap['col'];
			$type = $wrap['type'];
			$first = $wrap['first'];
			$itemid = $wrap['itemid'];
			$moduleid = isset($wrap['moduleid']) ? $wrap['moduleid'] : false;
			$items = isset($wrap['items']) ? $wrap['items'] : false;
			
			$container = ux_enable_sidebar() ? false : 'container';
			
			if($i == 0){
				if($type == 'fullwidth'){
					echo '<div class="fullwrap_moudle"><div class="row-fluid">';
				}else{
					echo '<div class="' . $container . '"><div class="row-fluid">';
				}
			}
			
			if($first == 'is'){
				if($i != 0){
					echo '</div></div>';
					if($type == 'fullwidth'){
						echo '<div class="fullwrap_moudle"><div class="row-fluid">';
					}else{
						echo '<div class="' . $container . '"><div class="row-fluid">';
					}
				}
			}
			
			ux_pb_module_interface_template($col, $type, $first, $itemid, $moduleid, $items, 'wrap');
			
			if($i == count($ux_pb_meta) - 1){
				echo '</div></div>';
			}
		} ?>
		<script type="text/javascript">
            jQuery(document).ready(function(){
                var ux_pb = new ThemePageBuilder();
                ux_pb.init();
            });
        </script>
	<?php
	}
}
add_action('ux-theme-single-pagebuilder', 'ux_pb_module_interface');

//pagebuilder module fields interface
function ux_pb_module_fields_interface($moduleid, $itemid){
	$ux_pb_module_fields = ux_pb_module_fields();
	
	if(isset($ux_pb_module_fields[$moduleid])){
		$items = $ux_pb_module_fields[$moduleid]['item'];
		foreach($items as $item){
			$item_title = isset($item['title']) ? $item['title'] : false;
			$item_bind = isset($item['bind']) ? $item['bind'] : false;
			$item_description = isset($item['description']) ? $item['description'] : false;
			$item_control = isset($item['control']) ? $item['control'] : false;
			$item_control = $item_control ? 'data-control="' . $item_control['name'] . '" data-controlvalue="' . $item_control['value'] . '"' : false;
			$item_subcontrol = isset($item['subcontrol']) ? $item['subcontrol'] : false;
			$item_subcontrol_type = false;
			if($item_subcontrol){
				$item_subcontrol = explode('|', $item['subcontrol']);
				$item_subcontrol_name = $item_subcontrol[0];
				$item_subcontrol_type = $item_subcontrol[1];
			}
			$item_subcontrol = $item_subcontrol ? 'data-subcontrol="' . $item_subcontrol_name . '"' : false;
			$item_subcontrol_type = $item_subcontrol_type ? 'data-subcontrol-type="' . $item_subcontrol_type . '"' : false; ?>
            <div class="row ux-pb-module-field module-ajaxfield" data-name="<?php echo $item['name']; ?>" data-type="<?php echo $item['type']; ?>" <?php echo $item_control; ?> <?php echo $item_subcontrol; ?> <?php echo $item_subcontrol_type; ?>>
                
                <?php if($item['type'] == 'message'){ ?>
					<div class="col-xs-12">
						<?php ux_pb_getfield($item, $itemid, $moduleid); ?>
                    </div>
				<?php }else{
					
					$item_left = $item['type'] == 'gallery' ? 'col-xs-12' : 'col-xs-4'; ?>
                    <div class="<?php echo $item_left; ?>">
                        <h5><strong><?php echo $item_title; ?></strong></h5>
                        <p class="text-muted"><?php echo $item_description; ?></p>
                    </div>
                    
                    <?php $item_right = $item['type'] == 'gallery' ? 'col-xs-12' : 'col-xs-8'; ?>
                    <div class="<?php echo $item_right; ?>">
                        <?php if($item_bind){
                            foreach($item_bind as $bind){
                                if($bind['position'] == 'before'){
                                    ux_pb_getfield($bind, $itemid, $moduleid);
                                }
                            }
                        }
                        
                        ux_pb_getfield($item, $itemid, $moduleid);
                        
                        if($item_bind){
                            foreach($item_bind as $bind){
                                if($bind['position'] == 'after'){
                                    ux_pb_getfield($bind, $itemid, $moduleid);
                                }
                            }
                        } ?>
                    </div>
				<?php } ?>
            </div>
        <?php	
		}
	}
}

//pagebuilder module pagenums
function ux_view_module_pagenums($itemid, $moduleid, $per_page, $count, $pagination){
	$module_post = ux_pb_item_postid($itemid);
	$per_page    = intval($per_page);
	$per_page    = $per_page == 0 ? 1 : $per_page;
	$page_paged  = $per_page != -1 ? ceil($count/$per_page) : 1;
	
	switch($pagination){
		case 'page_number':
			if($page_paged > 1){ ?>
				<div class="clearfix pagenums"> 
                    <div class="pagination">
                        <?php
                        $i = 0;
                        for($i=1; $i<=$page_paged; $i++){
                            if($i == 1){
                                $current = 'current';
                            }else{
                                $current = '';
                            }
                            ?><a class="<?php echo $current; ?> inactive select_pagination not_pagination" data-post="<?php echo $itemid; ?>" data-postid="<?php echo $module_post; ?>" data-paged="<?php echo $i; ?>" data-module=<?php echo $moduleid; ?> href="#"><?php echo $i; ?></a><?php
                        }?>
                    </div>
                </div><!--End pagenums-->
			<?php	
			}
		break;
		
		case 'twitter':
			if($page_paged > 1){ ?>
                <div class="clearfix pagenums tw_style page_twitter">
                    <a data-post="<?php echo $itemid; ?>" data-postid="<?php echo $module_post; ?>" data-paged="2" data-count="<?php echo $page_paged; ?>" data-module=<?php echo $moduleid; ?> href="#" class="not_pagination"><?php _e('Load More','ux'); ?></a>
                </div>
			<?php
			}
		break;
		
		case 'infiniti_scroll': ?>
            <div class="clearfix pagenums tw_style infiniti_scroll">
                <a data-post="<?php echo $itemid; ?>" data-postid="<?php echo $module_post; ?>" data-paged="2" data-module=<?php echo $moduleid; ?> href="#" class="not_pagination"><?php _e('Load More','ux'); ?></a>
            </div>
        <?php
		break;
	}
}

?>