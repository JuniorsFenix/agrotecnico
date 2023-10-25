<?php
//video template
function ux_pb_module_video($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//video confing
		$categoria = get_post_meta($module_post, 'video_category', true);
		$cantidad = get_post_meta($module_post, 'video_cantidad', true);
		
		require_once dirname(__FILE__).("/../../../../../../../../../include/funciones_public.php");
		$sitioCfg = sitioAssoc();
		$home = $sitioCfg["url"];
		$nConexion = Conectar();
		mysqli_set_charset($nConexion,'utf8');
		
		if($categoria!=0) $where = "WHERE idcategoria = $categoria";
		
		$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblvideosyoutube $where ORDER BY idvideo DESC LIMIT $cantidad" ) ;
		?>
		<div class="video-slider">
			<?php while($rxVideo = mysqli_fetch_assoc($Resultado)):
			$url = explode("watch?v=",$rxVideo["url"]);
			$url = explode("&",$url[1]);
			$url = $url[0]; ?>
			<div>
				<div class="videoWrapper">
					<iframe src="https://www.youtube.com/embed/<?php echo $url; ?>" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
	  <script type="text/javascript">
		jQuery(document).on('ready', function() {
			jQuery('.video-slider').slick({
				slidesToShow: 3,
				slidesToScroll: 3,
				arrows: true,
					responsive: [{
						breakpoint: 560,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}]
			});
		});
	  </script>
	<?php
	}
}
add_action('ux-pb-module-template-video', 'ux_pb_module_video');

//video select fields
function ux_pb_module_video_select($fields){
	$fields['module_video_ratio'] = array(
		array('title' => __('4:3', 'ux'), 'value' => '4:3'),
		array('title' => __('16:9', 'ux'), 'value' => '16:9'),
		array('title' => __('Custom', 'ux'), 'value' => 'custom')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_video_select');

//video config fields
function ux_pb_module_video_fields($module_fields){
	$module_fields['video'] = array(
		'id' => 'video',
		'animation' => 'class-1',
		'title' => __('Video', 'ux'),
		'item' =>  array(
				  
			array('title' => __('Categoría', 'ux'),
				  'description' => __('', 'ux'),
				  'type' => 'categoryV',
				  'name' => 'video_category',
				  'default' => '0'),
		
			array('title' => __('Cantidad', 'ux'),
				  'description' => __('Cuántos videos quiere mostrar', 'ux'),
				  'type' => 'text',
				  'name' => 'video_cantidad'),
				  
			/*array('title' => __('Advanced Settings', 'ux'),
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
				  'name' => 'module_scroll_animation_one',
				  'default' => 'fadein',
				  'control' => array(
					  'name' => 'module_scroll_in_animation',
					  'value' => 'on'
				  ))*/
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_video_fields');
?>