<?php
//gallery template
function ux_pb_module_gallery($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//gallery confing
		$source         = "image_post"; //get_post_meta($module_post, 'module_gallery_source', true);
		$category       = get_post_meta($module_post, 'module_gallery_category', true);
		//$sortable       = get_post_meta($module_post, 'module_gallery_sortable', true);
		//$spacing        = get_post_meta($module_post, 'module_gallery_image_spacing', true);
		//$size           = get_post_meta($module_post, 'module_gallery_image_size', true);
		$pagination     = get_post_meta($module_post, 'module_gallery_pagination', true);
		//$library        = get_post_meta($module_post, 'module_gallery_library', true);
		$per_page       = get_post_meta($module_post, 'module_gallery_per_page', true);
		
		$per_page       = $per_page ? $per_page : -1;
		//$get_categories = get_categories('parent=' . $category);
		require_once dirname(__FILE__).("/../../../../../../../../../include/funciones_public.php");
		$sitioCfg = sitioAssoc();
		$home = $sitioCfg["url"];
		$nConexion = Conectar();
		
		if($per_page == -1){$limit = "";}else{$limit = "LIMIT $per_page";}
		if($category == 0){$where = "";}else{$where = "AND idcategoria = $category";}
		
		$Resultado    = mysqli_query($nConexion,"SELECT * FROM tblimagenes WHERE publicar = 'S' $where ORDER BY idimagen DESC $limit");
		
		$isotope_style  = 'margin: -' . $spacing . ' 0 0 -' . $spacing;
		$inside_style   = 'margin: ' . $spacing . ' 0 0 ' . $spacing;
		
		?>
        <!--gallery isotope-->
        <h2>Galería</h2>
        <div class="gallery_wrapper">
            <?php switch($source){
				case 'image_post':
				while($galeria = mysqli_fetch_assoc($Resultado) ): ?>
				
					<a href='<?php echo "$home/galeria"; ?>' class='imagenA'>
						<img src="<?php echo "$home/fotos/Image/galeria/{$galeria["imagen"]}"; ?>"/>
					</a>
					<p><?php echo $galeria["descripcion"]; ?></p><br>
					<a class="link" href="<?php echo "$home/galeria"; ?>"><+></a>
				<?php endwhile;
					$count = count($gallery_querys);
					
					if($sortable && $sortable != 'no'){ ?>
                        <!--Filter-->
                        <ul class="clearfix filters <?php echo $filter_class; ?>">
                            <li class="active"><a href="#" data-filter="*"><?php _e('All', 'ux'); ?></a></li>	
                            <?php foreach($get_categories as $cate){ ?>		
                                <li><a data-filter=".filter_<?php echo $cate->slug; ?>" href="#"><?php echo $cate->name; ?></a></li>
                            <?php } ?> 
                        </ul><!--End filter-->
                    <?php } ?>
                    
                    <div class="container-isotope <?php echo $isotope_class; ?>" style=" <?php echo $isotope_margin; ?>" data-post="<?php echo $itemid; ?>">
                        <div id="isotope-load" class="isotope-load"></div>
                        <div class="isotope masonry <?php if($spacing =='0px'){ echo 'less-space'; } ?>" data-space="<?php echo $spacing; ?>" style=" <?php echo $isotope_style; ?>" data-size="<?php echo $size; ?>">
                            <?php ux_pb_module_load_gallery($itemid, 1); ?>
                        </div>
                    </div> <!--End container-isotope-->
				<?php
                break;
				
				case 'library':
					$count = count($library); ?>
                    <div class="container-isotope" data-post="<?php echo $itemid; ?>">
                        <div id="isotope-load" class="isotope-load"></div>
                        <div class="isotope masonry" data-space="<?php echo $spacing; ?>" style=" <?php echo $isotope_style; ?>" data-size="<?php echo $size; ?>">
                            <?php ux_pb_module_load_gallery($itemid, 1); ?>
                        </div>
                    </div> <!--End container-isotope-->
                <?php
				break;
			} ?>
        </div>
        <!--End row-fluid-->
		<?php
        if($count > 2){
			ux_view_module_pagenums($itemid, 'gallery', $per_page, $count, $pagination);
		}	
	}
}
add_action('ux-pb-module-template-gallery', 'ux_pb_module_gallery');

//gallery load template
function ux_pb_module_load_gallery($itemid, $paged){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		global $post;
		
		//gallery confing
		$source            = get_post_meta($module_post, 'module_gallery_source', true);
		$double_size       = get_post_meta($module_post, 'module_gallery_double_size', true);
		$category          = get_post_meta($module_post, 'module_gallery_category', true);
		$sortable          = get_post_meta($module_post, 'module_gallery_sortable', true);
		$spacing           = get_post_meta($module_post, 'module_gallery_image_spacing', true);
		$size              = get_post_meta($module_post, 'module_gallery_image_size', true);
		$ratio             = get_post_meta($module_post, 'module_gallery_image_ratio', true);
		$pagination        = get_post_meta($module_post, 'module_gallery_pagination', true);
		$library           = get_post_meta($module_post, 'module_gallery_library', true);
		$per_page          = get_post_meta($module_post, 'module_gallery_per_page', true);
		$hover_effect      = get_post_meta($module_post, 'module_gallery_mouseover_effect', true);
		$orderby           = get_post_meta($module_post, 'module_select_orderby', true);
		$order             = get_post_meta($module_post, 'module_select_order', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		
		$per_page          = $per_page ? $per_page : -1;
		$get_categories    = get_categories('parent=' . $category);
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, 'gallery') : false;
		$isotope_style     = 'margin: -' . $spacing . ' 0 0 -' . $spacing;
		$inside_style      = 'margin: ' . $spacing . ' 0 0 ' . $spacing;
		
		if($ratio == 'landscape'){
			$thumb_src_preview_size = 'image-thumb';
		}else if($ratio == 'square'){
			$thumb_src_preview_size = 'image-thumb-1';
		}else{
			$thumb_src_preview_size = 'standard-thumb';
		}
		
		$get_categories = get_categories('parent=' . $category);
		$gallery_query = get_posts(array(
			'posts_per_page' => $per_page,
			'paged' => $paged,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $order,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array('post-format-image'),
					'operator' => 'IN'
				)
			)
		));
		
		switch($source){
			case 'image_post':
				foreach($gallery_query as $num => $post){ setup_postdata($post);
					$width_item = $num == 0 && $paged == 1 ? $double_size == 'on' ? 'width4' : 'width2' : 'width2';
					$gallery_categories = get_the_category(get_the_ID());
					$separator = ' ';
					$output = '';
					if($gallery_categories){
						foreach($gallery_categories as $category){
							$output .= 'filter_' . $category->slug . $separator;
						}
					}
					
					$thumb_src_full = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
					$thumb_src_preview = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $thumb_src_preview_size);
					$ux_image_link = ux_get_post_meta(get_the_ID(), 'theme_meta_image_link'); ?>
                    <div class="<?php echo trim($output, $separator); ?> <?php echo $width_item; ?> isotope-item <?php echo $animation_style; ?>">
                        <div class="inside" style=" <?php echo $inside_style; ?>">
                            <div class="fade_wrap">
                                <a href="<?php echo esc_url($ux_image_link); ?>">
									<?php if($hover_effect == 'on'){ ?>
                                        <div class="fade_wrap_back">
                                            <div class="fade_wrap_back_bg">
                                                <i class="icon-m-link"></i>
                                            </div>
                                        </div>
                                    
                                    <?php } ?>
                                    <img src="<?php echo $thumb_src_preview[0]; ?>" class="isotope-list-thumb">
								</a>
                            </div><!--End fade_wrap-->
                        </div><!--End inside-->
                    </div>
                    <!--End isotope-item-->
				<?php
				}
				wp_reset_postdata();
			break;
				
			case 'library':
				if($library){
					$library       = is_array($library) ? $library : array($library); 
					$library_count = count($library);
					$per_page      = $per_page == -1 ? $library_count : $per_page;
					
					if($per_page){
						$library_page  = ceil($library_count / $per_page);
						
						$i = (intval($paged) - 1) * $per_page;
						for($i; $i<intval($paged) * $per_page; $i++){
							if(isset($library[$i])){
								$image = $library[$i];
								$thumb_src_preview = wp_get_attachment_image_src($image, $thumb_src_preview_size);
								$thumb_src_full = wp_get_attachment_image_src($image, 'full');
								$width_item = $i == (intval($paged) - 1) * $per_page  && $paged == 1 ? $double_size == 'on' ? 'width4' : 'width2' : 'width2'; ?>
								
								<?php if($i < $library_count){ ?>
                                    <div class="<?php echo $width_item; ?> isotope-item <?php echo $animation_style; ?>">
                                        <div class="inside" style=" <?php echo $inside_style; ?>">
                                            <div class="fade_wrap">
                                                <a href="<?php echo $thumb_src_full[0]; ?>" class="lightbox" data-rel="post-<?php echo $module_post; ?>">
                                                    <?php if($hover_effect == 'on'){ ?>
                                                        <div class="fade_wrap_back">
                                                            <div class="fade_wrap_back_bg">
                                                                <i class="icon-m-view"></i>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <img src="<?php echo $thumb_src_preview[0]; ?>" class="isotope-list-thumb">
                                                </a>
                                            </div><!--End fade_wrap-->
                                        </div><!--End inside-->
                                    </div><!--End isotope-item-->
								<?php
								}
							}
						}
					}
				}
			break;
		}
	}
}

//gallery select fields
function ux_pb_module_gallery_select($fields){
	$fields['module_gallery_source'] = array(
		array('title' => __('Library', 'ux'), 'value' => 'library'),
		array('title' => __('Image Post', 'ux'), 'value' => 'image_post')
	);
	
	$fields['module_gallery_image_spacing'] = array(
		array('title' => __('0px', 'ux'), 'value' => '0px'),
		array('title' => __('1px', 'ux'), 'value' => '1px'),
		array('title' => __('2px', 'ux'), 'value' => '2px'),
		array('title' => __('5px', 'ux'), 'value' => '5px'),
		array('title' => __('10px', 'ux'), 'value' => '10px'),
		array('title' => __('20px', 'ux'), 'value' => '20px')
	);
	
	$fields['module_gallery_image_size'] = array(
		array('title' => __('Medium', 'ux'), 'value' => 'medium'),
		array('title' => __('Large', 'ux'), 'value' => 'large'),
		array('title' => __('Small', 'ux'), 'value' => 'small'),
	);
	
	$fields['module_gallery_image_ratio'] = array(
		array('title' => '3:2(Grid)', 'value' => 'landscape'),
		array('title' => '1:1(Grid)', 'value' => 'square'),
		array('title' => __('Auto Ratio(Masonry)', 'ux'), 'value' => 'auto')
	);
	
	$fields['module_gallery_sortable'] = array(
		array('title' => __('No', 'ux'), 'value' => 'no'),
		array('title' => __('Top', 'ux'), 'value' => 'top'),
		array('title' => __('Left', 'ux'), 'value' => 'left'),
		array('title' => __('Right', 'ux'), 'value' => 'right')
	);
	
	$fields['module_gallery_pagination'] = array(
		array('title' => __('No', 'ux'), 'value' => 'no'),
		array('title' => __('Page Number', 'ux'), 'value' => 'page_number'),
		array('title' => __('Twitter', 'ux'), 'value' => 'twitter')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_gallery_select');

//gallery config fields
function ux_pb_module_gallery_fields($module_fields){
	$module_fields['gallery'] = array(
		'id' => 'gallery',
		'animation' => 'class-3',
		'title' => __('Gallery', 'ux'),
		'item' =>  array(
				  
			array('title' => __('Categoría', 'ux'),
				  'description' => __('Seleccionar la categoría', 'ux'),
				  'type' => 'categoryG',
				  'name' => 'module_gallery_category',
				  'default' => '0'),
				  
			array('title' => __('Order by', 'ux'),
				  'description' => __('Select sequence rules for the list', 'ux'),
				  'type' => 'orderby',
				  'name' => 'module_select_orderby',
				  'default' => 'date',
				  'control' => array(
					  'name' => 'module_gallery_source',
					  'value' => 'image_post'
				  )),
				  
			array('title' => __('Post Number per Page', 'ux'),
				  'description' => __('How many items should be displayed per page, leave it empty to show all items in one page', 'ux'),
				  'type' => 'text',
				  'name' => 'module_gallery_per_page'),
				  
			array('title' => __('Pagination', 'ux'),
				  'description' => __('The "Twitter" option is to show a "Load More" button on the bottom of the list', 'ux'),
				  'type' => 'select',
				  'name' => 'module_gallery_pagination',
				  'default' => 'no'),
				  
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
				  'name' => 'module_scroll_animation_two',
				  'default' => 'fadein',
				  'control' => array(
					  'name' => 'module_scroll_in_animation',
					  'value' => 'on'
				  ))
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_gallery_fields');
?>