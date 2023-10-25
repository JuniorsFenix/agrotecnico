<?php
//contact form template
function ux_pb_module_contactform($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//contact form confing
		$type            = get_post_meta($module_post, 'module_contactform', true);
		$message         = get_post_meta($module_post, 'module_contactform_message', true);
		$verifynumber    = get_post_meta($module_post, 'module_contactform_verifynumber', true);
		//$show_captcha    = get_post_meta($module_post, 'module_contactform_captcha', true);
		$button_text     = get_post_meta($module_post, 'module_contactform_button_text', true);
		$field_text      = get_post_meta($module_post, 'module_contactform_field_text', true);
		$recipient_email = get_post_meta($module_post, 'module_contactform_recipient_email', true);
		
		require_once dirname(__FILE__).("/../../../../../../../../../include/funciones_public.php");
		$sitioCfg = sitioAssoc();
		$home = $sitioCfg["url"];
		
		$nConexion    = Conectar();
		mysqli_set_charset($nConexion,'utf8');
		$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE id = $type" ) ;
		$Registro     = mysqli_fetch_array( $Resultado );
		$campos    = mysqli_query($nConexion, "SELECT * FROM campos_form WHERE idform = $type ORDER BY idcampo ASC" );
		?>
    <!-- contact-form -->
    
    <script src="https://www.google.com/recaptcha/api.js?render=6Le2UngjAAAAAAngkVY8AQ2URakgQMqJtu_xCtBq"></script>
    <script>
      grecaptcha.ready(function() {
        grecaptcha.execute('6Le2UngjAAAAAAngkVY8AQ2URakgQMqJtu_xCtBq', {action: 'home'}).then(function(token) {
            $('.formulario-captcha .token').val(token);
        });
      });
    </script>
    
		<div class="formPaypal">
			<form id="formulario2" class="formulario-captcha" action="<?php echo $home; ?>/gracias-por-contactarnos" method="post" onsubmit="return validate1(this)">
			    <input type="hidden" name="action" value="home">
                <input type="hidden" name="token" class="token" value="">
			    <div class="row">
			<input id="ciudad" name="ciudad" type="hidden" value="1" />
			<input id="idform" name="idform" type="hidden" value="<?php echo $type; ?>" />
		<?php while($r = mysqli_fetch_assoc($campos)): 
			if($r["tipo"]=="textarea"){ ?>
			<label class="col-md-12"><textarea id="textarea" name="<?php echo $r["campo"];?>" rows="6" required placeholder="<?php echo $r["campo"];?>*" ></textarea></label>
            <?php } elseif($r["tipo"]=="file") { ?>
            <tr>
                <td class="tituloNombres">Adjuntos:
                    <a href="#nolink" onclick="nuevoAdjunto();">
                    <img src="../../image/add.gif" width="16" height="16" />
                    </a></td>
            <td class="contenidoNombres" colspan="5">
            <script type="text/javascript">
            var indexAdjunto=2;
            
            function nuevoAdjunto(){
                
                $('.adjuntos').append('<li><input type="file" name="Adjunto' + indexAdjunto + '" /><a href="#nolink" id="remove"><img src="../../image/borrar.gif" width="16" height="16" /></a></li>');
                indexAdjunto+=1;
            }
    
            $(document).on("click", "#remove", function(){
               $(this).parent('li').remove();
            });
            </script>
            <ul class="adjuntos">
            <li><input type="file" name="Adjunto1" /></li>
            </ul>
            </td>
          </tr>
            <?php } elseif($r["tipo"]=="email") { ?>
				<label class="col-12 col-md-6"><input type="email" maxlength="100" name="<?php echo $r["campo"];?>" required placeholder="<?php echo $r["campo"];?>*"  /></label>
            <?php  } else { ?>
				<label class="col-12 col-md-6"><input maxlength="150" name="<?php echo $r["campo"];?>" required placeholder="<?php echo $r["campo"];?>*" /></label>
            <?php  } ?>
       <?php endwhile; ?><br />
			<p class="antispam">Dejar este campo vacio: <input type="text" name="url" /></p>
			<div class="col-12" style="text-align: right">
									<input class="action-button" id="cmdEnviar" name="Submit" type="submit" value="Enviar" size="100">
								</div>
			</div>
			</form>
		 </div>
		<?php
		
	}
}
add_action('ux-pb-module-template-contact-form', 'ux_pb_module_contactform');

//contact form select fields
function ux_pb_module_contactform_select($fields){
	$fields['module_contactform'] = array(
		array('title' => __('Contact Form', 'ux'), 'value' => 'contact_form'),
		array('title' => __('Single Field', 'ux'), 'value' => 'single_field')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_contactform_select');

//contact form config fields
function ux_pb_module_contactform_fields($module_fields){
	$module_fields['contact-form'] = array(
		'id' => 'contact-form',
		'title' => __('Contact Form', 'ux'),
		'item' =>  array(
			array('title' => __('Formulario', 'ux'),
				  'type' => 'categoryF',
				  'name' => 'module_contactform',
				  'default' => '0'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_contactform_fields');

//Contact Form 7 select fields
function ux_pb_module_contactform7_select($fields){
	if(is_plugin_active('contact-form-7/wp-contact-form-7.php') && isset($fields['module_contactform'])){
		$get_cf7 = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'wpcf7_contact_form'
		));
		
		if(count($get_cf7)){
			$cf7 = array();
			foreach($get_cf7 as $form){
				array_push($cf7, array(
					'title' => $form->post_title, 'value' => $form->ID
				));
			}
			
			$fields['module_contactform_contactform7'] = $cf7;
		}
		
		array_push($fields['module_contactform'], array(
			'title' => __('Contact Form 7', 'ux'), 'value' => 'contactform7'
		));
	}
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_contactform7_select', 10);

//Contact Form 7 config fields
function ux_pb_module_contactform7_fields($module_fields){
	if(is_plugin_active('contact-form-7/wp-contact-form-7.php') && isset($module_fields['contact-form'])){
		array_push($module_fields['contact-form']['item'], array(
			'title' => __('Contact Form 7 Alias', 'ux'),
			'type' => 'select',
			'name' => 'module_contactform_contactform7',
			'control' => array(
				'name' => 'module_contactform',
				'value' => 'contactform7'
			)
		));
	}
	return $module_fields;
}
add_filter('ux_pb_module_fields', 'ux_pb_module_contactform7_fields', 10);
?>