<?php
//pagebuilder module ajax
function ux_pb_module_ajax(){
	$text_fullwidth    = __('Fullwidth Wrap', 'ux');
	$text_addmodule    = __('+ Module', 'ux');
	$text_setting      = __('Setting', 'ux');
	$text_choosemodule = __('Choose Module', 'ux');
	
	$random_num        = date("Ymd-His") . '-' . rand(100,999);
	
	switch($_POST['id']){		
		case 'general': ?>
            <div class="ux-pb-item isotopey ux-sortable-wrap" pb-col="12" data-type="general" data-itemid="<?php echo $random_num; ?>">
                <input class="ux-pb-field-col" type="hidden" />
                <input class="ux-pb-field-type" type="hidden" />
                <input class="ux-pb-field-first" type="hidden" />
                <input class="ux-pb-field-itemid" type="hidden" value="<?php echo $random_num; ?>" />
                <div class="panel-pbbox">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="#" class="increase"><span class="glyphicon glyphicon-plus"></span></a>
                            <a href="#" class="decrease"><span class="glyphicon glyphicon-minus"></span></a>
                            <div class="module-title"><span class="label label-primary"><?php _e('1/1', 'ux'); ?></span></div>
                            <div class="module-choose" data-target="#ux-pb-modal" data-title="<?php _e('Choose Module', 'ux'); ?>" data-id="choose-module"><span class="label label-default"><?php echo $text_addmodule; ?></span></div>
                            <a href="#" class="remove"><span class="glyphicon glyphicon-remove"></span></a>
                        </div>
                        <div class="panel-body">
                            <div class="ux-pb-subbox-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
		break;
		
		case 'fullwidth': ?>
            <div class="ux-pb-item isotopey ux-sortable-wrap" pb-col="12" data-type="fullwidth" data-itemid="<?php echo $random_num; ?>">
                <input class="ux-pb-field-col" type="hidden" />
                <input class="ux-pb-field-type" type="hidden" />
                <input class="ux-pb-field-first" type="hidden" />
                <input class="ux-pb-field-itemid" type="hidden" value="<?php echo $random_num; ?>" />
                <div class="panel-pbbox">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="module-title"><span class="label label-primary"><?php echo $text_fullwidth; ?></span></div>
                            <div class="module-setting" data-target="#ux-pb-modal" data-title="<?php echo $text_fullwidth; ?>" data-id="module-fullwidth" data-itemid="<?php echo $random_num; ?>"><span class="label label-default"><?php echo $text_setting; ?></span></div>
                            <div class="module-choose" data-target="#ux-pb-modal" data-title="<?php echo $text_choosemodule; ?>" data-id="choose-module"><span class="label label-default"><?php echo $text_addmodule; ?></span></div>
                            <a href="#" class="remove"><span class="glyphicon glyphicon-remove"></span></a>
                        </div>
                        <div class="panel-body">
                            <div class="ux-pb-subbox-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
		break;
		
		case 'insertmodule':
			$ux_pb_modules = ux_pb_modules();
			$module_title = isset($_POST['module_id']) ? $ux_pb_modules[$_POST['module_id']] : false;
			$module_id = isset($_POST['module_id']) ? $_POST['module_id'] : false; ?>
            <div class="ux-pb-item ux-sortable-item" pb-col="12" data-type="module" data-itemid="<?php echo $random_num; ?>">
                <input class="ux-pb-field-col" type="hidden" />
                <input class="ux-pb-field-type" type="hidden" />
                <input class="ux-pb-field-first" type="hidden" />
                <input class="ux-pb-field-itemid" type="hidden" value="<?php echo $random_num; ?>" />
                <input class="ux-pb-field-moduleid" type="hidden" value="<?php echo $module_id; ?>" />
                <div class="panel-pbsubbox">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="#" class="increase"></a>
                            <a href="#" class="decrease"></a>
                            <a href="#" class="edit" data-target="#ux-pb-modal" data-title="<?php echo $module_title; ?>" data-id="<?php echo $module_id; ?>" data-itemid="<?php echo $random_num; ?>"><?php _e('Edit', 'ux'); ?></a>
                            <a href="#" class="copy"></a>
                            <a href="#" class="remove"></a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body"><?php echo $module_title; ?> <span class="label label-primary"><?php _e('1/1', 'ux'); ?></span></div>
                    </div>
                </div>
            </div>
		<?php
		break;
		
		case 'copymodule':
			$ux_pb_modules = ux_pb_modules();
			$module_title = isset($_POST['module_id']) ? $ux_pb_modules[$_POST['module_id']] : false;
			$module_itemid = isset($_POST['module_itemid']) ? $_POST['module_itemid'] : false;
			$module_id = isset($_POST['module_id']) ? $_POST['module_id'] : false;
			$module_col = isset($_POST['module_col']) ? $_POST['module_col'] : 12;
			$module_col_title = isset($_POST['module_col_title']) ? $_POST['module_col_title'] : __('1/1', 'ux');
			
			if($module_itemid){
				$module_post = ux_pb_item_postid($module_itemid);
				if($module_post){
					global $wpdb;
					$post_fields = array(
						'post_title' => $random_num,
						'post_name' => $random_num,
						'post_status' => 'publish',
						'post_type' => 'modules'
					);
					
					$post_id = wp_insert_post($post_fields);
					$get_post_custom = $wpdb->get_results("
						SELECT `meta_key`, `meta_value`
						FROM $wpdb->postmeta
						WHERE `post_id` = $module_post
						"
					);
					
					foreach($get_post_custom as $custom){
						$get_custom_meta = get_post_meta($module_post, $custom->meta_key, true);
						update_post_meta($post_id, $custom->meta_key, $get_custom_meta);
					}
				}
			} ?>
            <div class="ux-pb-item ux-sortable-item" pb-col="<?php echo $module_col; ?>" data-type="module" data-itemid="<?php echo $random_num; ?>">
                <input class="ux-pb-field-col" type="hidden" />
                <input class="ux-pb-field-type" type="hidden" />
                <input class="ux-pb-field-first" type="hidden" />
                <input class="ux-pb-field-itemid" type="hidden" value="<?php echo $random_num; ?>" />
                <input class="ux-pb-field-moduleid" type="hidden" value="<?php echo $module_id; ?>" />
                <div class="panel-pbsubbox">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="#" class="increase"></a>
                            <a href="#" class="decrease"></a>
                            <a href="#" class="edit" data-target="#ux-pb-modal" data-title="<?php echo $module_title; ?>" data-id="<?php echo $module_id; ?>" data-itemid="<?php echo $random_num; ?>"><?php _e('Edit', 'ux'); ?></a>
                            <a href="#" class="copy"></a>
                            <a href="#" class="remove"></a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body"><?php echo $module_title; ?> <span class="label label-primary"><?php echo $module_col_title; ?></span></div>
                    </div>
                </div>
            </div>
		<?php
		break;
		
		case 'modulesave':
			$fields = $_POST['fields'];
			$content = $_POST['content'];
			$itemid = isset($_POST['itemid']) ? $_POST['itemid'] : false;
			$results = array();
			$result = array();
			
			foreach($fields as $field){
				if(strstr($field['name'], '[')){
					$subname = strstr($field['name'], '[');
					$name = str_replace($subname, '', $field['name']);
					$subname = str_replace('[', '', $subname);
					$subname = str_replace(']', '', $subname);
					
					$results[$name][$subname][] = $field['value'];
				}else{
					$results[$field['name']][] = $field['value'];
				}
			}
			
			foreach($results as $name => $value){
				if(count($value) > 1){
					$result[$name] = $value;
				}else{
					$result[$name] = $value[0];
				}
			}
			
			$result['module_content'] = $content;
			
			$get_posts = get_posts(array(
				'posts_per_page' => -1,
				'name' => $itemid,
				'post_type' => 'modules'
			));
			
			if($get_posts){
				$post_id = $get_posts[0]->ID;
			}else{
				$post_fields = array(
					'post_title' => $itemid,
					'post_name' => $itemid,
					'post_status' => 'publish',
					'post_type' => 'modules'
				);
				
				$post_id = wp_insert_post($post_fields);
			}
			
			if($post_id){
				$custom_meta = get_post_custom_keys($post_id);
				foreach($custom_meta as $meta){
					if($meta != '_edit_lock'){
						delete_post_meta($post_id, $meta);
					}
				}
				
				foreach($result as $name => $value){
					$old = get_post_meta($post_id, $name, true);  
					$new = $value;
				
					if ($new && $new != $old) {  
						update_post_meta($post_id, $name, $new);  
					} elseif ('' == $new && $old) {  
						delete_post_meta($post_id, $name, $old);  
					}
				}
			}
		break;
		
		case 'load_template':
			if(!isset($_POST['templateid'])){ ?>
                <div class="row ux-pb-module-field">
                    <div class="col-xs-4">
                        <h5><strong><?php _e('Select Template', 'ux'); ?></strong></h5>
                    </div>
                    <div class="col-xs-8">
                        <div class="form-group">
                            <select class="form-control" name="ux_pb_templateid" >
                                <option value="0">Por defecto</option>
                                <?php
								require_once dirname(__FILE__).("/../../../../../../../../include/funciones_public.php");
								$nConexion = Conectar();
								$plantillas = mysqli_query($nConexion,"SELECT * FROM plantillas");
                                
                                while($template = mysqli_fetch_object($plantillas) ): ?>
                                    <option value="<?php echo $template->idplantilla; ?>"><?php echo $template->nombre; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>
            <?php
			}else{
				/*$templateid = $_POST['templateid'];
				$post_id = $_POST['post_id'];
				$ux_pb_meta = get_post_meta($templateid, 'ux_pb_meta', true);
				
				if($ux_pb_meta){
					ux_pb_copy_module($post_id, $ux_pb_meta);
					ux_pb_load_module($post_id);
				}*/
			}
		break;
		
		case 'delete_template':
			if(isset($_POST['templateid'])){
				$templateid = $_POST['templateid'];
				wp_trash_post($templateid);
			}
		break;
		
		case 'save_current_template':
			$post_id = $_POST['post_id'];
			if(!isset($_POST['template_name'])){ ?>
                <div class="row ux-pb-module-field">
                    <div class="col-xs-4">
                        <h5><strong><?php _e('Template Name', 'ux'); ?></strong></h5>
                    </div>
                    <div class="col-xs-8">
                        <div class="form-group">
                            <input type="text" name="ux_pb_save_template" class="form-control" />
                        </div>
                    </div>
                </div>
			<?php }else{
				global $wpdb;
				$template_name = $_POST['template_name'];
				$ux_pb_meta = get_post_meta($post_id, 'ux_pb_meta', true);
				
				$post_fields = array(
					'post_title' => $template_name,
					'post_status' => 'publish',
					'post_type' => 'module_template'
				);
				
				$post_id = wp_insert_post($post_fields);
				
				if($post_id){
					if($ux_pb_meta){
						ux_pb_copy_module($post_id, $ux_pb_meta);
					}
				}
			}
		break;
		
		default: 
			$moduleid = str_replace('module-', '', $_POST['id']);
			$itemid = isset($_POST['itemid']) ? $_POST['itemid'] : false;
			echo '<input class="ux-pb-module-itemid" type="hidden" value="' . $itemid . '" />';
			echo '<input class="ux-pb-module-id" type="hidden" value="' . $moduleid . '" />';
			ux_pb_module_fields_interface($moduleid, $itemid);
		break;
	}
	
	die('');
}
add_action('wp_ajax_ux_pb_module_ajax', 'ux_pb_module_ajax');

//pagebuilder module load gallery list
function ux_pb_load_gallery_list(){
	$paged = (isset($_POST['paged']))? $_POST['paged'] : 1; 
	$paged = ($paged == '') ? $paged = 1 : $paged;
	
	$get_attachment = get_posts(array(
		'post_type' => 'attachment',
		'post_mime_type' =>'image',
		'post_status' => 'inherit',
		'posts_per_page' => '16',
		'paged' => $paged
	));
	
	if($get_attachment){ ?>
        <ul class="nav nav-pills">
			<?php foreach($get_attachment as $post){
				$image = wp_get_attachment_image_src($post->ID, 'imagebox-thumb');
				$image_full = wp_get_attachment_image_src($post->ID, 'image-thumb-1'); ?>
                <li>
                    <a href="#" class="thumbnail" data-image="<?php echo $image_full[0]; ?>" data-id="<?php echo $post->ID; ?>">
                        <span class="selected"></span>
                        <span class="border"></span>
                        <img src="<?php echo $image[0]; ?>" />
                    </a>
                </li>
            <?php
            } ?>
        </ul>
	<?php
	}
	if(isset($_POST['paged'])){
		die('');
	}
}
add_action('wp_ajax_ux_pb_load_gallery_list', 'ux_pb_load_gallery_list');
?>