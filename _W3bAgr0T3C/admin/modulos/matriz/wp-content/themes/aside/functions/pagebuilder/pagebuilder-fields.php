<?php
//pagebuilder fields
function ux_pb_getfield($item, $itemid, $moduleid){
	$select_fields = ux_pb_module_select_fields();
	$social_networks = ux_theme_social_networks();
	$theme_color = ux_theme_color();
	$key = 'ux-pb-meta';
	
	$type        = isset($item['type']) ? $item['type'] : false;
	$name        = isset($item['name']) ? $item['name'] : false;
	$unit        = isset($item['unit']) ? $item['unit'] : false;
	$default     = isset($item['default']) ? $item['default'] : false;
	$control     = isset($item['control']) ? $item['control'] : false;
	$placeholder = isset($item['placeholder']) ? $item['placeholder'] : false;
	$taxonomy = isset($item['taxonomy']) ? $item['taxonomy'] : 'category';
	
	$get_posts = get_posts(array(
		'posts_per_page' => -1,
		'name' => $itemid,
		'post_type' => 'modules'
	));
	
	$post_id = $get_posts ? $get_posts[0]->ID : false;
	$get_post_meta = get_post_meta($post_id, $name, true);
	$get_value = $get_post_meta ? $get_post_meta : $default;
	$control = $control ? 'data-name="' . $control['name'] . '" data-value="' . $control['value'] . '"' : false;
	
	if($type){
		switch($type){
			case 'text': ?>
                <div class="form-group">
                    <input type="text" name="<?php echo $name; ?>" placeholder="<?php echo $placeholder; ?>" class="form-control" value="<?php echo $get_value; ?>" />
                </div>
                <?php if($unit){ ?>
                    <p class="text-danger"><?php _e('Unit:', 'ux'); ?> <?php echo $unit; ?></p>
                <?php
				}
			break;
			
			case 'textarea' ?>
                <textarea name="<?php echo $name; ?>" class="form-control" rows="3"><?php echo $get_value; ?></textarea>
            <?php
			break;
			
			case 'select':
				if(isset($select_fields[$name])){ ?>
                    <select class="form-control" name="<?php echo $name; ?>" data-value="<?php echo $get_value; ?>">
                        <?php foreach($select_fields[$name] as $select){ ?>
                            <option value="<?php echo $select['value']; ?>" <?php selected($get_value, $select['value']); ?>><?php echo $select['title']; ?></option>
                        <?php } ?>
                    </select>
                <?php
				}
			break;
			
			case 'image_select':
				if(isset($select_fields[$name])){ ?>
					<ul class="nav nav-pills ux-pb-icon-mask">
						<?php foreach($select_fields[$name] as $select){
							$current = $get_value == $select['value'] ? 'current' : false; ?>
                            <li><a href="#" class="mask-<?php echo $select['value']; ?> <?php echo $current; ?>" data-value="<?php echo $select['value']; ?>"><span class="choosed"></span></a></li>
                        <?php } ?>
                        <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $get_value; ?>" />
                    </ul>
				<?php
				}
			break;
			
			case 'bg-color':
				if(count($theme_color)){ ?>
                    <ul class="nav nav-pills ux-pb-bg-color">
						<?php foreach($theme_color as $color){ ?>
                            <li><button type="button" class="btn" data-value="<?php echo $color['id']; ?>" style="background-color: <?php echo $color['rgb']; ?>"><span class="glyphicon glyphicon-ok"></span></button></li>
                        <?php } ?>
                        <li><button type="button" class="btn btn-cancelcolor"></button></li>
                    </ul>
                    <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $get_value; ?>">
				<?php
                }
			break;
			
			case 'switch-color': ?>
                <div class="row">
                    <div class="form-group ux-pb-switch-color col-sm-4">
                        <input type="text" class="form-control switch-color" data-position="bottom left" value="<?php echo $get_value; ?>" name="<?php echo $name; ?>" />
                        <span class="ux-pb-remove-color"></span>
                    </div>
                </div>
            <?php
			break;
			
			case 'upload': ?>
                <div class="row">
                    <div class="input-group ux-pb-upload col-xs-10 input-group-sm">
                        <input type="text" name="<?php echo $name; ?>" placeholder="<?php echo $placeholder; ?>" class="form-control" value="<?php echo $get_value; ?>" />
                        <span class="input-group-btn">
                            <button class="btn btn-default ux-pb-upload-image" type="button"><?php _e('Upload Image', 'ux'); ?></button>
                            <button class="btn btn-danger ux-pb-remove-image" type="button"><?php _e('Remove', 'ux'); ?></button>
                        </span>
                    </div>
                    <div class="col-xs-10" style="margin-top:10px;">
                        <img src="<?php echo $get_value; ?>" class="img-responsive" />
                    </div>
                </div>
            <?php
			break;
			
			case 'switch': ?>
                <div class="switch pb-make-switch" data-on="success" data-off="danger">
                    <input type="checkbox" value="on" <?php checked($get_value, 'on'); ?> />
                    <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $get_value; ?>" data-value="<?php echo $get_value; ?>" />
                </div>
            <?php
			break; 
			
			case 'tabs':
				if($get_value){
					if(is_array($get_value)){
						foreach($get_value as $i => $tab){
							ux_pb_getfield_tabs_template($name, __('Tab ', 'ux') . $i, $tab, $placeholder);
						}
					}else{
						ux_pb_getfield_tabs_template($name, __('Tab 1', 'ux'), $get_value, $placeholder);
					}
				}else{
					ux_pb_getfield_tabs_template($name, __('Tab 1', 'ux'), $get_value, $placeholder);
				}
			break;
			
			case 'checkbox-group':
				if(isset($select_fields[$name])){ ?>
                    <ul class="nav nav-pills ux-pb-checkbox-group">
                        <?php foreach($select_fields[$name] as $i => $select){
							$value = false;
							if(is_array($get_value)){
								$value = (in_array($select['value'], $get_value)) ? $select['value'] : false;
							}else{
								$value = $get_value;
							} ?>
                            <li>
                                <input type="checkbox" name="<?php echo $name; ?>" value="<?php echo $select['value']; ?>" <?php checked($value, $select['value']); ?>>
                                <span class="pull-left"><?php echo $select['title']; ?></span>
                            </li>
                        <?php } ?>
                    </ul>
				<?php
				}
			break;
			
			case 'icons':
				$icons_fields = ux_theme_icons_fields();
				$icons_uploaded = get_option('ux_theme_option_icons_custom');
				$icons_type = 'fontawesome';
				
				$hidden_fa = false;
				$hidden_user = 'hidden';
				if(!(strstr($get_value, "fa fa")) && $get_value){
					$icons_type = 'user-uploaded-icons';
					$hidden_fa = 'hidden';
					$hidden_user = false;
				}
				
				if($moduleid != 'progress-bar'){ ?>
				
                    <p><select class="form-control fonts-module-icons">
                        <option value="fontawesome" <?php selected($icons_type, 'fontawesome'); ?>><?php _e('Font Awesome', 'ux'); ?></option>
                        <?php if($icons_uploaded){ ?>
                            <option value="user-uploaded-icons" <?php selected($icons_type, 'user-uploaded-icons'); ?>><?php _e('User Uploaded Icons', 'ux'); ?></option>
                        <?php } ?>
                    </select></p>
                
                <?php } ?>
                
                <div class="ux-pb-module-icons">
                    <?php if($icons_fields){ ?>
						<div class="ux-pb-module-icons-fontawesome <?php echo $hidden_fa; ?>" data-id="fontawesome">
							<?php foreach($icons_fields as $icon){
                                $current = $get_value == $icon ? 'current' : false; ?>
                                <a href="#" class="module-icon <?php echo $current; ?>"><i class="<?php echo $icon; ?>"></i></a>
                            <?php } ?>
                            <div class="clearfix"></div>
                        </div>
					<?php
                    }
					
					if($icons_uploaded){ ?>
                        <div class="ux-pb-module-icons-uploaded <?php echo $hidden_user; ?>" data-id="user-uploaded-icons">
                            <?php foreach($icons_uploaded as $portfolio){
                                $image_src = wp_get_attachment_image_src($portfolio, true);
                                $current = $get_value == $image_src[0] ? 'current' : false; ?>
                                <a href="#" class="module-icon <?php echo $current; ?>"><img src="<?php echo $image_src[0]; ?>" width="48" /></a>
                            <?php } ?>
                            <div class="clearfix"></div>
                        </div>
					<?php } ?>
                    <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $get_value; ?>" />
                </div>
            <?php
			break;
			
			case 'price-item': ?>
                <button type="button" class="btn btn-info ux-pb-price-item-add"><?php _e('Add', 'ux'); ?></button>
                <div class="ux-pb-module-items-price-template">
                    <div class="row">
                        <div class="col-xs-4">
                            <select class="form-control input-sm">
                                <option value="fa fa-check"><?php _e('Check', 'ux'); ?></option>
                                <option value="fa fa-arrow-right"><?php _e('Arrow', 'ux'); ?></option>
                                <option value="noting"><?php _e("Don't Show Icon", 'ux'); ?></option>
                            </select>
                        </div>
                        <div class="col-xs-6">
                            <input type="text" value="" class="form-control input-sm" />
                        </div>
                        <div class="col-xs-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger btn-sm ux-pb-items-remove"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group ux-pb-module-items-price"></div>
                <textarea name="<?php echo $name; ?>" class="form-control hidden" rows="3"><?php echo $get_value; ?></textarea>
            <?php
			break;
			
			case 'items': ?>
                <button type="button" class="btn btn-info ux-pb-items-add"><?php _e('Add Item', 'ux'); ?></button>
                <div class="ux-pb-module-items-template">
					<?php ux_pb_getfield_items_template($name, array(
						'title' => __('New Item', 'ux'),
						'value' => false,
						'icons' => false,
						'textarea' => false,
						'percent' => 0,
						'bgcolor' => false,
						'price' => 0,
						'button_text' => false,
						'button_link' => false
					)); ?>
                </div>
                <div class="list-group ux-pb-module-items">
					<?php if($get_value){
						$items_count = count($get_value['items']);
						$subcontrol_value = array();
						$get_subcontrol = ux_pb_getfield_subcontrol($name);
						if($get_subcontrol){
							foreach($get_subcontrol as $subcontrol => $field){
								$field_value = $field['value'];
								$field_type = $field['type'];
								$subcontrol = $field_type == 'content' ? 'ux-pb-module-content' : $subcontrol;
								$subcontrol_value[$field_value] = $get_value[$subcontrol];
							}
						}
						
						for($i = 0; $i < $items_count; $i++){
							$num = $i + 1;
							$title = isset($subcontrol_value['title'][$i]) ? $subcontrol_value['title'][$i] : __('Item ', 'ux') . $num;
							$content = isset($subcontrol_value['content'][$i]) ? $subcontrol_value['content'][$i] : false;
							$icons = isset($subcontrol_value['icons'][$i]) ? $subcontrol_value['icons'][$i] : false;
							$textarea = isset($subcontrol_value['textarea'][$i]) ? $subcontrol_value['textarea'][$i] : false;
							$percent = isset($subcontrol_value['percent'][$i]) ? $subcontrol_value['percent'][$i] : 0;
							$bgcolor = isset($subcontrol_value['bgcolor'][$i]) ? $subcontrol_value['bgcolor'][$i] : false;
							$price = isset($subcontrol_value['price'][$i]) ? $subcontrol_value['price'][$i] : 0;
							$button_text = isset($subcontrol_value['button_text'][$i]) ? $subcontrol_value['button_text'][$i] : false;
							$button_link = isset($subcontrol_value['button_link'][$i]) ? $subcontrol_value['button_link'][$i] : false;
							
							ux_pb_getfield_items_template($name, array(
								'title' => $title,
								'value' => $content,
								'icons' => $icons,
								'textarea' => $textarea,
								'percent' => $percent,
								'bgcolor' => $bgcolor,
								'price' => $price,
								'button_text' => $button_text,
								'button_link' => $button_link
							));
						}
					}else{
						$items_count = 4;
						for($i = 1; $i <= $items_count; $i++){
							ux_pb_getfield_items_template($name, array(
								'title' => __('Item ', 'ux') . $i,
								'value' => false,
								'icons' => false,
								'textarea' => false,
								'percent' => 0,
								'bgcolor' => false,
								'price' => 0,
								'button_text' => false,
								'button_link' => false
							));
						}
					} ?>
                </div>
            <?php
			break;
			
			case 'content': ?>
                <div class="ux-pb-editor-ajax-content">
                    <?php echo $get_value; ?>
                </div>
            <?php
            break;
			
			case 'date': ?>
                <div class="form-group">
                    <div class="input-group date form_datetime ux-pb-datetime">
                        <input class="form-control" name="<?php echo $name; ?>" value="<?php echo $get_value; ?>" type="text" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    </div>
                </div>
			<?php
			break;
			
			case 'ratio': ?>
                <div data-id="ux-pb-ratio" class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" name="<?php echo $name; ?>[1]" value="<?php echo $get_value[1][0]; ?>">
                    </div>
                    <div class="form-group">:</div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="<?php echo $name; ?>[2]" value="<?php echo $get_value[2][0]; ?>">
                    </div>
                </div>
                <script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery('[data-id=ux-pb-ratio]').each(function(){
							var _this = jQuery(this);
							var _this_parents = _this.parents('.module-ajaxfield');
							var _this_parents_prev = _this_parents.prev();
							if(_this_parents_prev.is('[data-name=module_video_ratio]')){
								_this.parent().css({'margin-top': '-35px'});
							}
						})
					});
				</script>
            <?php
			break;
			
			case 'category': 
			require_once dirname(__FILE__).("/../../../../../../../../include/connect.php");
			require_once dirname(__FILE__).("/../../../../../../../herramientas/paginar/dbquery.inc.php");
			$nConexion = Conectar();
			mysqli_set_charset($nConexion,'utf8');
			?>
                    <select name="module_blog_category" id="moduleid-module_blog_category" class="form-control">
                        <option value="0">Seleccionar categoría</option>
					  <?php 
                        $ca = new DbQuery($nConexion);
                        $ca->prepareSelect("tblmatriz","*","tipo=1","titulo");
                        $ca->exec();
                        $categorias = $ca->fetchAll();
                      foreach ( $categorias as $r):?>
                       <option class="level-0" value="<?=$r["id"];?>"  <?=$r["id"]==$get_value?"selected":"";?> ><?=$r["titulo"];?></option>
                      <?php endforeach;?>
                    </select>
            <?php
			break;
			
			case 'categoryS': 
			require_once dirname(__FILE__).("/../../../../../../../../include/connect.php");
			require_once dirname(__FILE__).("/../../../../../../../herramientas/paginar/dbquery.inc.php");
			$nConexion = Conectar();
			mysqli_set_charset($nConexion,'utf8');
			?>
                    <select name="module_slider_category" id="moduleid-module_slider_category" class="form-control">
                        <option value="0">Seleccionar categoría</option>
					  <?php 
                        $ca = new DbQuery($nConexion);
                        $ca->prepareSelect("tblcabezotes_categorias","*","","nombre");
                        $ca->exec();
                        $categorias = $ca->fetchAll();
                      foreach ( $categorias as $r):?>
                       <option class="level-0" value="<?=$r["idcategoria"];?>"  <?=$r["idcategoria"]==$get_value?"selected":"";?> ><?=$r["nombre"];?></option>
                      <?php endforeach;?>
                    </select>
            <?php
			break;
			
			case 'categoryC': 
			require_once dirname(__FILE__).("/../../../../../../../../include/connect.php");
			require_once dirname(__FILE__).("/../../../../../../../herramientas/paginar/dbquery.inc.php");
			$nConexion = Conectar();
			mysqli_set_charset($nConexion,'utf8');
			?>
                    <select name="module_carousel_category" id="moduleid-module_carousel_category" class="form-control">
                        <option value="0">Seleccionar categoría</option>
					  <?php 
                        $ca = new DbQuery($nConexion);
                        $ca->prepareSelect("tblcinta_categorias","*","","nombre");
                        $ca->exec();
                        $categorias = $ca->fetchAll();
                      foreach ( $categorias as $r):?>
                       <option class="level-0" value="<?=$r["idcategoria"];?>"  <?=$r["idcategoria"]==$get_value?"selected":"";?> ><?=$r["nombre"];?></option>
                      <?php endforeach;?>
                    </select>
            <?php
			break;
			
			case 'categoryF': 
			require_once dirname(__FILE__).("/../../../../../../../../include/connect.php");
			require_once dirname(__FILE__).("/../../../../../../../herramientas/paginar/dbquery.inc.php");
			$nConexion = Conectar();
			mysqli_set_charset($nConexion,'utf8');
			?>
                    <select name="module_contactform" id="moduleid-module_contactform" class="form-control">
                        <option value="0">Seleccionar categoría</option>
					  <?php 
                        $ca = new DbQuery($nConexion);
                        $ca->prepareSelect("tblmatriz","*","tipo=2","titulo");
                        $ca->exec();
                        $categorias = $ca->fetchAll();
                      foreach ( $categorias as $r):?>
                       <option class="level-0" value="<?=$r["id"];?>"  <?=$r["id"]==$get_value?"selected":"";?> ><?=$r["titulo"];?>
                      <?php endforeach;?>
                    </select>
            <?php
			break;
			
			case 'categoryV': 
			require_once dirname(__FILE__).("/../../../../../../../../include/connect.php");
			require_once dirname(__FILE__).("/../../../../../../../herramientas/paginar/dbquery.inc.php");
			$nConexion = Conectar();
			mysqli_set_charset($nConexion,'utf8');
			?>
                    <select name="<?php echo $name; ?>" id="moduleid-<?php echo $name; ?>" class="form-control">
                        <option value="0">Seleccionar categoría</option>
					  <?php 
                        $ca = new DbQuery($nConexion);
                        $ca->prepareSelect("tblvideosyoutube_categorias","*","idcategoria!=0","nombre");
                        $ca->exec();
                        $categorias = $ca->fetchAll();
                      foreach ( $categorias as $r):?>
                       <option class="level-0" value="<?=$r["idcategoria"];?>"  <?=$r["idcategoria"]==$get_value?"selected":"";?> ><?=$r["nombre"];?>
                      <?php endforeach;?>
                    </select>
            <?php
			break;
			
			case 'categoryG': 
			require_once dirname(__FILE__).("/../../../../../../../../include/connect.php");
			require_once dirname(__FILE__).("/../../../../../../../herramientas/paginar/dbquery.inc.php");
			$nConexion = Conectar();
			mysqli_set_charset($nConexion,'utf8');
			?>
                    <select name="module_gallery_category" id="moduleid-module_gallery_category" class="form-control">
                        <option value="0">Todas</option>
					  <?php 
                        $ca = new DbQuery($nConexion);
                        $ca->prepareSelect("tblcategoriasimagenes","*","","categoria");
                        $ca->exec();
                        $categorias = $ca->fetchAll();
                      foreach ( $categorias as $r):?>
                       <option class="level-0" value="<?=$r["idcategoria"];?>"  <?=$r["idcategoria"]==$get_value?"selected":"";?> ><?=$r["categoria"];?></option>
                      <?php endforeach;?>
                    </select>
            <?php
			break;
			
			case 'categoryCont': 
			require_once dirname(__FILE__).("/../../../../../../../../include/connect.php");
			require_once dirname(__FILE__).("/../../../../../../../herramientas/paginar/dbquery.inc.php");
			$nConexion = Conectar();
			mysqli_set_charset($nConexion,'utf8');
			?>
                    <select name="module_contenido" id="moduleid-module_contenido" class="form-control">
					  <?php 
                        $ca = new DbQuery($nConexion);
                        $ca->prepareSelect("tblcontenidos","*","publicar='S'","titulo");
                        $ca->exec();
                        $categorias = $ca->fetchAll();
                      foreach ( $categorias as $r):?>
                       <option class="level-0" value="<?=$r["idcontenido"];?>"  <?=$r["idcontenido"]==$get_value?"selected":"";?> ><?=$r["titulo"];?></option>
                      <?php endforeach;?>
                    </select>
            <?php
			break;
			
			case 'categoryP': 
			require_once dirname(__FILE__).("/../../../../../../../../include/connect.php");
			require_once dirname(__FILE__).("/../../../../../../../herramientas/paginar/dbquery.inc.php");
			$nConexion = Conectar();
			mysqli_set_charset($nConexion,'utf8');
			?>
                    <select name="module_cat_productos" id="moduleid-module_cat_productos" class="form-control">
                       <option class="level-0" value="0"  <?=0==$get_value?"selected":"";?> >Todas</option>
					  <?php 
                        $ca = new DbQuery($nConexion);
                        $ca->prepareSelect("tblti_categorias","*","idcategoria!=0","nombre");
                        $ca->exec();
                        $categorias = $ca->fetchAll();
                      foreach ( $categorias as $r):?>
                       <option class="level-0" value="<?=$r["idcategoria"];?>"  <?=$r["idcategoria"]==$get_value?"selected":"";?> ><?=$r["nombre"];?></option>
                      <?php endforeach;?>
                    </select>
            <?php
			break;
			
			case 'orderby': ?>
				<div class="form-inline">
                    <div class="form-group">
                        <?php if(isset($select_fields[$name])){ ?>
                            <select class="form-control" name="<?php echo $name; ?>">
                                <?php foreach($select_fields[$name] as $select){ ?>
                                    <option value="<?php echo $select['value']; ?>" <?php selected($get_value, $select['value']); ?>><?php echo $select['title']; ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <?php $name = 'module_select_order';
						$get_post_meta = get_post_meta($post_id, $name, true);
						$get_value = $get_post_meta ? $get_post_meta : 'DESC';
						if(isset($select_fields[$name])){ ?>
                            <select class="form-control" name="<?php echo $name; ?>">
                                <?php foreach($select_fields[$name] as $select){ ?>
                                    <option value="<?php echo $select['value']; ?>" <?php selected($get_value, $select['value']); ?>><?php echo $select['title']; ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>
                    </div>
                </div>
			<?php
			break;
			
			case 'social-medias':
				if($get_value){
					foreach($get_value['name'] as $i => $m_name){
						$m_url = $get_value['url'][$i];
						$hidden_add = ($i == 0) ? false : 'hidden';
						$hidden_remove = ($i != 0) ? false : 'hidden'; ?>
                        <div class="ux-pb-social-medias row">
                            <div class="col-sm-3">
                                <select class="form-control input-sm" name="<?php echo $name; ?>[name]">
                                    <?php foreach($social_networks as $social){ ?>
                                        <option value="<?php echo $social['slug']; ?>" <?php selected($m_name, $social['slug']); ?>><?php echo $social['slug']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-6 ux-pb-no-col">
                                <input type="text" name="<?php echo $name; ?>[url]" class="form-control input-sm" value="<?php echo $m_url; ?>" />
                            </div>
                            <div class="col-sm-3 ux-pb-no-col">
                                <button type="button" class="btn btn-info btn-sm ux-pb-social-medias-add <?php echo $hidden_add; ?>"><span class="glyphicon glyphicon-plus"></span></button>
                                <button type="button" class="btn btn-danger btn-sm ux-pb-social-medias-remove <?php echo $hidden_remove; ?>"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php	
					}
				}else{ ?>
                    <div class="ux-pb-social-medias row">
                        <div class="col-sm-3">
                            <select class="form-control input-sm" name="<?php echo $name; ?>[name]">
                                <?php foreach($social_networks as $social){ ?>
                                    <option value="<?php echo $social['slug']; ?>"><?php echo $social['slug']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-6 ux-pb-no-col">
                            <input type="text" name="<?php echo $name; ?>[url]" class="form-control input-sm" value="" />
                        </div>
                        <div class="col-sm-3 ux-pb-no-col">
                            <button type="button" class="btn btn-info btn-sm ux-pb-social-medias-add"><span class="glyphicon glyphicon-plus"></span></button>
                            <button type="button" class="btn btn-danger btn-sm ux-pb-social-medias-remove hidden"><span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                <?php
				}
			break;
			
			case 'gallery': ?>
                <div class="row">
                    <div class="col-xs-12"><button type="button" class="btn btn-primary ux-pb-gallery-select-images"><?php _e('Select Images', 'ux'); ?></button></div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12">
                        <div class="ux-pb-gallery-select">
                            <ul class="nav nav-pills">
                            <?php if(is_array($get_value)){
                                foreach($get_value as $image){
                                    $image_thumbnail = wp_get_attachment_image_src($image, 'thumbnail'); ?>
                                    
                                    <li><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button><a href="#" class="thumbnail"><img src="<?php echo $image_thumbnail[0]; ?>" width="100" /></a><input type="hidden" name="module_gallery_library" value="<?php echo $image; ?>" /></li>
                                <?php
                                }
                            } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php
			break;
			
			case 'google_map':
				$module_map_location_l = -33.8674869;
				$module_map_location_r = 151.20699020000006;
				if($get_value){
					$module_map_location = str_replace('(', '', $get_value);
					$module_map_location = str_replace(')', '', $module_map_location);
					$module_map_location = explode(', ', $module_map_location);
					
					$module_map_location_l = (isset($module_map_location[0])) ? $module_map_location[0] : -33.8674869;
					$module_map_location_r = (isset($module_map_location[1])) ? $module_map_location[1] : 151.20699020000006;
				} ?>
				<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $get_value; ?>" />
				<div id="ux-pb-map-canvas"></div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						var geocoder;
						var google_map;
						var markers = [];
						var module_map_location_l = Number(<?php echo $module_map_location_l; ?>);
						var module_map_location_r = Number(<?php echo $module_map_location_r; ?>);
						function map_initialize() {
							geocoder = new google.maps.Geocoder();
							var latlng = new google.maps.LatLng(module_map_location_l, module_map_location_r);
							var mapOptions = {
								zoom: 7,
								center: latlng,
								mapTypeId: google.maps.MapTypeId.ROADMAP
							}
							google_map = new google.maps.Map(document.getElementById('ux-pb-map-canvas'), mapOptions);
							var marker = new google.maps.Marker({
								position: latlng,
								map: google_map
							});
							marker.setAnimation(google.maps.Animation.BOUNCE);
							markers.push(marker);
							google.maps.event.addListener(google_map, 'click', function(event) {
								map_addMarker(event.latLng);
							});
							
						}
						
						function map_addMarker(location) {
							map_deleteMarkers();
							var marker = new google.maps.Marker({
								position: location,
								map: google_map
							});
							marker.setAnimation(google.maps.Animation.BOUNCE);
							markers.push(marker);
							jQuery('[name=module_googlemap_canvas]').val(location);
						}
						
						function map_clearMarkers() {
							map_setAllMap(null);
						}
						
						function map_showMarkers() {
							map_setAllMap(google_map);
						}
						
						function map_deleteMarkers() {
							map_clearMarkers();
							markers = [];
						}
						
						function map_setAllMap(map) {
							for (var i = 0; i < markers.length; i++) {
								markers[i].setMap(map);
							}
						}
					
						function map_codeAddress(address){
							geocoder.geocode( { 'address': address}, function(results, status) {
								if (status == google.maps.GeocoderStatus.OK) {
									google_map.setCenter(results[0].geometry.location);
									map_deleteMarkers();
									var marker = new google.maps.Marker({
										map: google_map,
										position: results[0].geometry.location
									});
									marker.setAnimation(google.maps.Animation.BOUNCE);
									markers.push(marker);
									jQuery('[name=module_googlemap_canvas]').val(results[0].geometry.location);
								} else {
									alert('Geocode was not successful for the following reason: ' + status);
								}
							});
						}
						map_initialize();
						
						jQuery('[name=module_googlemap_address]').change(function(){
							map_codeAddress(jQuery(this).val());
						});
					});
				
				</script>
			<?php
			break;
			
			case 'message':
				if($moduleid == 'latest-tweets'){
					$plugin_name = "Rotating Tweets (Twitter widget and shortcode)";
					$plugin_slug = "rotatingtweets/rotatingtweets.php";
					$plugin_url = 'http://wordpress.org/plugins/rotatingtweets/';
						
					if(!is_plugin_active($plugin_slug)){ ?>
						<div class="error">
                            <p><em><?php printf(__('You Need to install the %s %s', 'ux'), '<a href="' . esc_url($plugin_url) . '" target="_blank" title="' . $plugin_name . '">' . $plugin_name . '</a>', __('WordPress plugin and setup your Twitter API before working with this module.!', 'ux')); ?></em></p>
                        </div>
					<?php
                    }
				}
			break;
		}
	}
}

//pagebuilder subcontrol
function ux_pb_getfield_subcontrol($name){
	$module_fields = ux_pb_module_fields();
	
	$subcontrol_fields = array();
	foreach($module_fields as $field){
		if(isset($field['item'])){
			foreach($field['item'] as $item){
				if(isset($item['subcontrol'])){
					$subcontrol = explode('|', $item['subcontrol']);
					$subcontrol_name = $subcontrol[0];
					$subcontrol_type = $subcontrol[1];
					if($subcontrol_name == $name){
						$subcontrol_fields[$item['name']]['type'] = $item['type'];
						$subcontrol_fields[$item['name']]['value'] = $subcontrol_type;
					}
				}
			}
		}
	}
	$subcontrol_fields = count($subcontrol_fields) ? $subcontrol_fields : false;
	return $subcontrol_fields;
}

//pagebuilder items template
function ux_pb_getfield_items_template($name, $get_value){
	$title = isset($get_value['title']) ? $get_value['title'] : false;
	$button_text = isset($get_value['button_text']) ? $get_value['button_text'] : false;
	$button_link = isset($get_value['button_link']) ? $get_value['button_link'] : false;
	$bgcolor = isset($get_value['bgcolor']) ? $get_value['bgcolor'] : false;
	$percent = isset($get_value['percent']) ? $get_value['percent'] : 0;
	$price = isset($get_value['price']) ? $get_value['price'] : 0;
	$value = isset($get_value['value']) ? $get_value['value'] : false;
	$icons = isset($get_value['icons']) ? $get_value['icons'] : false;
	$textarea = isset($get_value['textarea']) ? $get_value['textarea'] : false; ?>
	<a href="#" class="list-group-item">
        <?php /*?><i class="<?php echo $icons; ?>"></i><?php */?>
        <span><?php echo $title; ?></span>
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-info btn-xs ux-pb-items-edit"><span class="glyphicon glyphicon-edit"></span></button>
            <button type="button" class="btn btn-danger btn-xs ux-pb-items-remove"><span class="glyphicon glyphicon-remove"></span></button>
        </div>
        <div class="field-group">
			<input type="text" name="<?php echo $name . '[items]'; ?>" />
			<?php $get_subcontrol = ux_pb_getfield_subcontrol($name);
			if($get_subcontrol){
				foreach($get_subcontrol as $subcontrol => $field){
					$field_value = $field['value'];
					switch($field_value){
						case 'title':
							echo '<input type="text" name="' . $name . '[' . $subcontrol . ']" data-fieldname="' . $subcontrol . '" value="' . $title . '" />';
						break;
						
						case 'content':
							echo '<textarea name="' . $name . '[ux-pb-module-content]" data-fieldname="ux-pb-module-content">' . $value . '</textarea>';
						break;
						
						case 'icons':
							echo '<input type="text" name="' . $name . '[' . $subcontrol . ']" data-fieldname="' . $subcontrol . '" value="' . $icons . '" />';
						break;
						
						case 'textarea':
							echo '<textarea name="' . $name . '[' . $subcontrol . ']" data-fieldname="' . $subcontrol . '">' . $textarea . '</textarea>';
						break;
						
						case 'percent':
							echo '<input type="text" name="' . $name . '[' . $subcontrol . ']" data-fieldname="' . $subcontrol . '" value="' . $percent . '" />';
						break;
						
						case 'bgcolor':
							echo '<input type="text" name="' . $name . '[' . $subcontrol . ']" data-fieldname="' . $subcontrol . '" value="' . $bgcolor . '" />';
						break;
						
						case 'price':
							echo '<input type="text" name="' . $name . '[' . $subcontrol . ']" data-fieldname="' . $subcontrol . '" value="' . $price . '" />';
						break;
						
						case 'button_text':
							echo '<input type="text" name="' . $name . '[' . $subcontrol . ']" data-fieldname="' . $subcontrol . '" value="' . $button_text . '" />';
						break;
						
						case 'button_link':
							echo '<input type="text" name="' . $name . '[' . $subcontrol . ']" data-fieldname="' . $subcontrol . '" value="' . $button_link . '" />';
						break;
					}
				}
			} ?>
        </div>
    </a>
<?php	
}

//pagebuilder tabs template
function ux_pb_getfield_tabs_template($name, $title, $value, $placeholder){ ?>
    <div class="row ux-pb-tabs">
        <div class="input-group input-group-sm col-xs-10">
            <span class="input-group-addon"><?php echo $title; ?></span>
            <input type="text" name="<?php echo $name; ?>" placeholder="<?php echo $placeholder; ?>" class="form-control" value="<?php echo $value; ?>" />
            <span class="input-group-btn">
                <button type="button" class="btn btn-info btn-sm ux-pb-tabs-add"><span class="glyphicon glyphicon-plus"></span></button>
                <button type="button" class="btn btn-danger btn-sm ux-pb-tabs-remove hidden"><span class="glyphicon glyphicon-remove"></span></button>
            </span>
        </div>
    </div>
<?php	
}

?>