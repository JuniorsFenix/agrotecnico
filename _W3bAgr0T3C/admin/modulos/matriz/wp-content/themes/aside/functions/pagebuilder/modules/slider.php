<?php
//slider template
function ux_pb_module_slider($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		global $post;
		
		//slider confing
		$type          = get_post_meta($module_post, 'module_slider_type', true);
		$per_page      = get_post_meta($module_post, 'module_slider_per_page', true);
		$animation     = get_post_meta($module_post, 'module_slider_animation', true);
		$navigation    = get_post_meta($module_post, 'module_slider_navigation_hint', true);
		$previous_next = get_post_meta($module_post, 'module_slider_previous_next', true);
		$speed_second  = get_post_meta($module_post, 'module_slider_speed_second', true);
		$category      = get_post_meta($module_post, 'module_slider_category', true);
		$orderby       = get_post_meta($module_post, 'module_select_orderby', true);
		$order         = get_post_meta($module_post, 'module_select_order', true);
		
		$direction     = $previous_next == 'on' ? 'true' : 'false'; 
		$control       = $navigation == 'on' ? 'true' : 'false'; 
		$speed         = $speed_second ? $speed_second : 5000; 

    
		$per_page = $per_page ? $per_page : 3;
		
		$slider_query = get_posts(array(
			'posts_per_page' => $per_page,
			'category'       => $category,
			'orderby'        => $orderby,
			'order'          => $order,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array(
						'post-format-quote',
						'post-format-link',
						'post-format-audio',
						'post-format-video'
					),
					'operator' => 'NOT IN'
				)
			),
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => '_thumbnail_id',
					'compare' => 'EXISTS'
				)
			)
		)); ?>
		<a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
		<?php
		switch($type){
			case 'novo':
			require_once dirname(__FILE__).("/../../../../../../../../../include/funciones_public.php");
			$sitioCfg = sitioAssoc();
			$home = $sitioCfg["url"];
			$cRutaVerCabezotesjq = $home."/fotos/Image/cabezotesjq/";
			$nConexion = Conectar();
			
			$sql = "select opacidad,textura,altura from tblcabezotes_categorias where idcategoria={$category}";
			
			$rCategorias = mysqli_query($nConexion,$sql);
			$efectos = mysqli_fetch_assoc($rCategorias);
			
			$propiedades = array();
			foreach ( $efectos as $k => $v ) {
						$propiedades[$k] = $v;
			}
			
			$sql = "select a.* from tblcabezotes a where a.idcategoria={$category} order by orden";
		
			$rsImagenes = mysqli_query($nConexion,$sql);
		
			$opacitad = $propiedades["opacidad"];
			$textura = $propiedades["textura"];
			$altura = $propiedades["altura"];
      
      
			?>
            <link href='<?php echo $home; ?>/css/camera.css' rel='stylesheet' type='text/css' />
            <script type='text/javascript' src='<?php echo $home; ?>/php/js/camera.min.js'></script>
            <script type='text/javascript' src='<?php echo $home; ?>/php/js/jquery.easing.1.3.js'></script>
                <style>
                    .<?php echo $textura; ?> .camera_overlayer{
                        opacity:<?php echo $opacitad; ?>;
                    }
                </style>
				<div class='slider' data-0='margin-top: 0px;' data-500='margin-top: -200px;'>
                    <div class='camera_wrap camera_emboss <?php echo $textura; ?>' id='camera_wrap_1' style="height: <?php echo "{$altura}vw"; ?>">
					<?php while($rax = mysqli_fetch_assoc($rsImagenes)) { ?>
						<div data-src='<?php echo $cRutaVerCabezotesjq.$rax['archivo']; ?>' data-link='<?php echo $rax['url'] ?>' data-target='<?php echo $rax['target'] ?>' data-thumb='<?php echo $cRutaVerCabezotesjq.$rax['archivo'] ?>'>
						<?php if (!empty($rax['descripcion'])){ ?>
							<div class='ei-title fadeIn'><?php echo $rax['descripcion'] ?></div>";
						<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
            <script type='text/javascript'>
                jQuery(function() {
                    jQuery('#camera_wrap_1').camera({
						playPause: false,
						height: '<?php echo "$altura%"; ?>',
						minHeight: '100px',
            time: 4000,
					});
                });
            </script>
			<?php
            break;
			
			case 'flexslider': ?>
                <div class="flex-slider-wrap slide-wrap-ux" data-direction="<?php echo $direction; ?>" data-control="<?php echo $control; ?>" data-speed="<?php echo $speed; ?>" data-animation="<?php echo $animation; ?>">
                    <div class="flexslider">
                        <ul class="slides clearfix">
                            <?php foreach($slider_query as $num => $slider):
                                $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($slider->ID), 'full');  ?>
                                <li><a title="<?php echo get_the_title($slider->ID); ?>"><img src="<?php echo $thumbnail_url[0]; ?>" title="<?php echo get_the_title($slider->ID); ?>"></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div><!--End flexslider-->
                </div>
                <!--End flex-slider-wrap-->
			<?php
            break;
			
			case 'layerslider':
				$layerslider = get_post_meta($module_post, 'module_slider_layerslider', true);
				echo $layerslider ? do_shortcode('[layerslider id="'.$layerslider.'"]') : false;
			break;
			
			case 'revolutionslider':
				$revolution = get_post_meta($module_post, 'module_slider_revolution', true);
				echo $revolution ? do_shortcode('[rev_slider '.$revolution.']') : false;
			break;
		}
    }
}
add_action('ux-pb-module-template-slider', 'ux_pb_module_slider');

//slider select fields
function ux_pb_module_slider_select($fields){
	$fields['module_slider_animation'] = array(
		array('title' => __('Fade','ux'), 'value' => 'fade'),
		array('title' => __('Slide','ux'), 'value' => 'slide')
	);
	
	$fields['module_slider_type'] = array(
		array('title' => __('Camera Slider', 'ux'), 'value' => 'novo')
	);
	
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_slider_select');

//slider config fields
function ux_pb_module_slider_fields($module_fields){
	$module_fields['slider'] = array(
		'id' => 'slider',
		'title' => __('Slider', 'ux'),
		'item' =>  array(
			array('title' => __('Slider Type', 'ux'),
				  'description' => __('Select the slider type', 'ux'),
				  'type' => 'select',
				  'name' => 'module_slider_type',
				  'default' => 'novo'),
				  
			array('title' => __('Category', 'ux'),
				  'description' => __('The post under the category you selected would be shown in this slider.', 'ux'),
				  'type' => 'categoryS',
				  'name' => 'module_slider_category',
				  'default' => '0',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'novo|flexslider'
				  )),
				  
			array('title' => __('Order by', 'ux'),
				  'description' => __('Select sequence rules for the list', 'ux'),
				  'type' => 'orderby',
				  'name' => 'module_select_orderby',
				  'default' => 'date',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'novo|flexslider'
				  )),
				  
			array('title' => __('Number to Show', 'ux'),
				  'description' => __('How many posts(slides) you want to show in the slider.', 'ux'),
				  'type' => 'text',
				  'name' => 'module_slider_per_page',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'novo|flexslider'
				  )),
				  
			array('title' => __('Animation', 'ux'),
				  'description' => __('Choose an animation effect for the slider', 'ux'),
				  'type' => 'select',
				  'name' => 'module_slider_animation',
				  'default' => 'fade',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'flexslider'
				  )),
				  
			array('title' => __('Show Navigation Hint(dot)', 'ux'),
				  'description' => __('Turn on if you want to show the Nav Hint', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_slider_navigation_hint',
				  'default' => 'on',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'flexslider'
				  )),
				  
			array('title' => __('Show Previous/Next Button', 'ux'),
				  'description' => __('Turn on if you want to show the Nav Button', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_slider_previous_next',
				  'default' => 'on',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'flexslider'
				  )),
				  
			array('title' => __('Speed (second)', 'ux'),
				  'description' => __('Enter a speed for the animation', 'ux'),
				  'type' => 'text',
				  'name' => 'module_slider_speed_second',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'flexslider'
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
				  ))
			
			
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_slider_fields');

//layerslider select fields
function ux_pb_module_layerslider_select($fields){
	if(is_plugin_active('LayerSlider/layerslider.php') && isset($fields['module_slider_type'])){
		global $wpdb;
		$table_layerslider = $wpdb->prefix . "layerslider";
		$layerslider = $wpdb->get_results( "SELECT * FROM $table_layerslider
						  WHERE flag_hidden = '0' AND flag_deleted = '0'
						  ORDER BY id ASC" );
		
		if(count($layerslider)){
			$slider_layerslider = array();
			foreach($layerslider as $num => $slider){
				$name = empty($slider->name) ? 'Unnamed' : $slider->name;
				array_push($slider_layerslider, array(
					'title' => $name, 'value' => $slider->id
				));
			}
			
			$fields['module_slider_layerslider'] = $slider_layerslider;
		}
		
		array_push($fields['module_slider_type'], array(
			'title' => __('LayerSlider', 'ux'), 'value' => 'layerslider'
		));
	}
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_layerslider_select', 10);

//layerslider config fields
function ux_pb_module_layerslider_fields($module_fields){
	if(is_plugin_active('LayerSlider/layerslider.php') && isset($module_fields['slider'])){
		array_push($module_fields['slider']['item'], array(
			'title' => __('LayerSlider Alias', 'ux'),
			'description' => __('The right hand dropdown menu would be enabled after you have create at least 1 slider by LayerSlider plugin.', 'ux'),
			'type' => 'select',
			'name' => 'module_slider_layerslider',
			'control' => array(
				'name' => 'module_slider_type',
				'value' => 'layerslider'
			)
		));
	}
	return $module_fields;
}
add_filter('ux_pb_module_fields', 'ux_pb_module_layerslider_fields', 10);

//revolution select fields
function ux_pb_module_revolution_select($fields){
	if(is_plugin_active('revslider/revslider.php') && isset($fields['module_slider_type'])){
		global $wpdb;
		$table_revslider = $wpdb->prefix . "revslider_sliders";
		
		$revslidersliders = $wpdb->get_results( "SELECT * FROM $table_revslider ORDER BY id ASC" );
		
		if(count($revslidersliders)){
			$slider_revslider = array();
			foreach($revslidersliders as $num => $slider){
				array_push($slider_revslider, array(
					'title' => $slider->title, 'value' => $slider->alias
				));
			}
			
			$fields['module_slider_revolution'] = $slider_revslider;
		}
		
		array_push($fields['module_slider_type'], array(
			'title' => __('Revolution Slider', 'ux'), 'value' => 'revolutionslider'
		));
	}
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_revolution_select', 10);

//revslider config fields
function ux_pb_module_revslider_fields($module_fields){
	if(is_plugin_active('revslider/revslider.php') && isset($module_fields['slider'])){
		array_push($module_fields['slider']['item'], array(
			'title' => __('Revolution Slider Alias', 'ux'),
			'type' => 'select',
			'name' => 'module_slider_revolution',
			'control' => array(
				'name' => 'module_slider_type',
				'value' => 'revolutionslider'
			)
		));
	}
	return $module_fields;
}
add_filter('ux_pb_module_fields', 'ux_pb_module_revslider_fields', 10);
?>