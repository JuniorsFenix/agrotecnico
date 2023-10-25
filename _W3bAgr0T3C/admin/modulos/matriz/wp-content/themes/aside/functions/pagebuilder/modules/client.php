<?php
//client template
function ux_pb_module_client($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//client confing
		$category          = get_post_meta($module_post, 'module_contenido', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, 'client') : false;
		
?>
        
        <div class="contenidos">
            <?php 
			require_once dirname(__FILE__).("/../../../../../../../../../include/funciones_public.php");
			$nConexion    = Conectar();
			mysqli_set_charset($nConexion,'utf8');
			$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblcontenidos WHERE idcontenido = $category" );
			$Registro     = mysqli_fetch_array( $Resultado );
			?>
			<?php if (!empty( $Registro["imagen"] )) { ?>
			<img src="<?php echo $home."/fotos/Image/contenidos/".$Registro["imagen"]; ?>" alt="<?php echo $Registro["titulo"]; ?>" class="imagenInterna"/>
			<?php
			}
			echo $Registro["contenido"]; ?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-client', 'ux_pb_module_client');

//client config fields
function ux_pb_module_client_fields($module_fields){
	$module_fields['client'] = array(
		'id' => 'client',
		'animation' => 'class-2',
		'title' => __('Contenidos', 'ux'),
		'item' =>  array(
			array('title' => __('Categoría', 'ux'),
				  'description' => __('Seleccione qué contenido desea mostrar', 'ux'),
				  'type' => 'categoryCont',
				  'name' => 'module_contenido',
				  'taxonomy' => 'client_cat'),
				  
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
			/*	  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_client_fields');
?>