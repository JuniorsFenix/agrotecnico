<?php include("../../funciones_generales.php");
	include("../../herramientas/upload/SimpleImage.php");
  
  function modulosFormNuevo($nId) {
    $IdCiudad = $_SESSION["IdCiudad"];
    
	$nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
	$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE id = '$nId'" ) ;
	$Registro     = mysqli_fetch_array( $Resultado );
	$campos    = mysqli_query($nConexion, "SELECT * FROM campos ca JOIN campos_matriz cm on (ca.campo=cm.campo) WHERE cm.idmatriz = '$nId' ORDER BY cm.id ASC" );
 
    
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="modulos.php?Accion=Guardar&amp;modulo=<?=$nId?>" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>CREAR CONTENIDO</b></td>
        </tr>
		<?php while($r = mysqli_fetch_assoc($campos)): 
		if($r["campo"]=="Descripcion"){ $texto="Descripci&oacute;n:";}else{$texto="Resumen:";}
		?>
            <?php if($r["tipo"]=="textarea"){ ?>
            <tr>
              <td class="tituloNombres" colspan="2"><?php echo $texto; ?></td>
            </tr>
            <tr>
              <td class="contenidoNombres" colspan="2"><textarea name="<?php echo $r["campo"];?>"></textarea></td>
                <script>
                    $("textarea").addClass("ckeditor");
                </script>
            </tr>
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
            <?php  } else { ?>
            <tr>
              <td class="tituloNombres"><?php echo $r["campo"];?>:</td>
              <td class="contenidoNombres"><input type="<?=$r["tipo"];?>" placeholder="<?php echo $r["campo"];?>" name="<?php echo $r["campo"];?>" maxLength="200" style="width: 823px; height: 22px"></td>
            </tr> 
            <?php  } ?>
       <?php endwhile; ?>
        </table>
	<table width="100%">
      <tr>
        <td colspan="4" align="center" class="tituloFormulario"><b>POSICIONAMIENTO</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">T&iacute;tulo:</td>
        <td class="contenidoNombres" colspan="5"><INPUT type="text" name="metaTitulo" class="seocounter_title" maxLength="200"  style="width: 823px; height: 22px"></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripci&oacute;n:</td>
        <td class="contenidoNombres" colspan="5">
            <textarea name="metaDescripcion" class="seocounter_meta" cols="100" rows="10"></textarea>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Tags: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select url,nombre from tbltags_palabras where tag=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="tags[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["url"];?>"><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
        <td class="tituloNombres">Palabras Clave: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select idpalabra,nombre from tbltags_palabras where keyword=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="palabras[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["nombre"];?>"><?=$rax["nombre"];?></option>
        <?php endwhile;
    	mysqli_close( $nConexion ) ?>
        </select>
        </td>
      </tr>
        <tr>
            <td class="tituloNombres">Imágenes:
                <a href="#nolink" onclick="nuevaImagen();">
                <img src="../../image/add.gif" width="16" height="16" />
                </a></td>
        <td class="contenidoNombres" colspan="5">
		<script type="text/javascript">
        var indexImagen=2;
        
        function nuevaImagen(){
            
            $('.files').append('<li><input type="file" name="Imagen' + indexImagen + '" /> <input type="text" name="textoImagen' + indexImagen + '" style="width: 620px" /> <a href="#nolink" id="remove"><img src="../../image/borrar.gif" width="16" height="16" /></a></li>');
            indexImagen+=1;
        }

        $(document).on("click", "#remove", function(){
		   $(this).parent('li').remove();
		});
        </script>
        <ul class="files">
        <li><input type="file" name="Imagen1" /> <input type="text" name="textoImagen1" style="width: 620px" /></li>
        </ul>
        </td>
      </tr>
		<?
        if ( Perfil() == "3" )
        {
        ?><input type="hidden" name="optPublicar" id="optPublicar" value="N"><?
        }
        else
        {
        ?>
        <tr>
            <td class="tituloNombres">Publicar:</td>
            <td class="contenidoNombres" colspan="3">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><label><input type="radio" id="publicar" name="publicar" value="S">Si</label></td>
                        <td width="10"></td>
                        <td><label><input type="radio" id="publicar" name="publicar" value="N" checked>No</label></td>
                    </tr>
                </table>
          </td>
        </tr>
        <?
        }
        ?>
        <tr>
          <td colspan="4" class="nuevo">
      <input type="submit" alt="Guardar Registro." value="Guardar" id="save"/>
	    <a href="modulos_listar.php?modulo=<?=$nId?>"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################

  function modulosGuardar( $modulo,$d,$files ) {
	include("../../vargenerales.php");
    $IdCiudad = $_SESSION["IdCiudad"];
	$nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
	$nId = $d["txtId"];
	$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE id = '$modulo'" ) ;
	$Registro     = mysqli_fetch_array( $Resultado );
	$tabla = $Registro["tabla"];
	setlocale(LC_ALL, 'en_US.UTF8');
	$titulo = slug($d["Titulo"]);
	$results = array();
	$errors     = array();
	$acceptable = array(
		'application/pdf',
		'application/msword',
		'application/rtf',
		'application/vnd.ms-excel',
		'application/vnd.ms-powerpoint',
		'image/jpeg',
		'image/jpg',
		'image/gif',
		'image/png'
	);
	if (!empty($d["tags"])){
	$tags = implode(',', $d["tags"]);
	}
	if (!empty($d["palabras"])){
	$palabras = implode(', ', $d["palabras"]);
	}
	array_splice($d, 0, 1);
    if ( $nId <= 0 ) {
		
      $idContenido = mysqli_insert_id($nConexion);
	  $sql="update `$tabla` set tags='$tags',palabras='$palabras',publicar='{$d["publicar"]}',url='$titulo' where id = {$idContenido}";
      $r = mysqli_query($nConexion,$sql);
	for($i=1;$i<=30;$i++){
		$NomImagen="*";
		
		if( isset( $files["Imagen{$i}"]["tmp_name"] ) && $files["Imagen{$i}"]["tmp_name"]!="" ) {
		
		    $textoImagen = $d["textoImagen{$i}"];
			$NomImagenG = $idContenido . "_" . $i . "_" . $files["Imagen{$i}"]["name"];
			$NomImagenM = "m_" . $idContenido . "_" . $i . "_" . $files["Imagen{$i}"]["name"];
			$NomImagenP = "p_" . $idContenido . "_" . $i . "_" . $files["Imagen{$i}"]["name"];
			$image = new SimpleImage();
			$image->load($files["Imagen{$i}"]["tmp_name"]);
			$image->resizeToWidth(1920);
			$image->save($cRutaImgGeneral.$Registro["tabla"]."/".$NomImagenG);
			$image->resizeToWidth(600);
			$image->save($cRutaImgGeneral.$Registro["tabla"]."/".$NomImagenM);
			$image->resizeToWidth(200);
			$image->save($cRutaImgGeneral.$Registro["tabla"]."/".$NomImagenP);
			$sql="INSERT INTO imagenes_matriz (idmatriz, idcontenido, imagen, texto) VALUES ('$modulo', '$idContenido', '$NomImagenG', '$textoImagen')";
			$r = mysqli_query($nConexion,$sql);
			
			if(!$r){
				Mensaje( "Fallo actualizando imagenes.".mysqli_error($nConexion), "modulos_listar.php?modulo=$modulo" );
				exit;
			}
		}
	  
		if( isset( $files["Adjunto{$i}"]["tmp_name"] ) && $files["Adjunto{$i}"]["tmp_name"]!="" ) {
		
			if(!in_array($files["Adjunto{$i}"]["type"], $acceptable) && (!empty($files["Adjunto{$i}"]["type"]))) {
				$errors[] = 'Tipo de archivo inválido';
			}
		
			if(count($errors) === 0) {
				$nombre = $files["Adjunto{$i}"]["name"];
				$name  = pathinfo($nombre, PATHINFO_FILENAME);
				$name = slug($name);
				$ext  = pathinfo($nombre, PATHINFO_EXTENSION);
				$nombre = $idContenido."_".$i."_$name.$ext";
				move_uploaded_file($files["Adjunto{$i}"]['tmp_name'], $cRutaImgGeneral.$Registro["tabla"]."/".$nombre);
				$sql="insert into adjuntos_matriz (idmatriz,idcontenido,adjunto) values ('{$modulo}','{$idContenido}','{$nombre}')";
				$r = mysqli_query($nConexion,$sql);
			} else {
				foreach($errors as $error) {
					echo '<script>alert("'.$error.'");</script>';
				}
			}
		}
    unset($d["textoImagen{$i}"]);     
	}
  foreach ($d as $field => $value ) { 
  $results[] = $field ;
  }
  $fields = implode(',', $results);
  $values = "'".implode ("', '", $d)."'";
    $sql = "INSERT INTO `$tabla` ( $fields ) 
        VALUES ( $values )";
    $ra = mysqli_query($nConexion,$sql);

    if ( !$ra ) {
  Mensaje( mysqli_error($nConexion), "modulos_listar.php?modulo=$modulo" ) ;
  exit;
    }
      Log_System( $Registro["titulo"] , "NUEVO" , "NOMBRE: " . $d["titulo"]  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "modulos_listar.php?modulo=$modulo" ) ;
      return;
    }
    else {
	  
	if(isset($files["Adjunto"]["tmp_name"]) && $files["Adjunto"]["tmp_name"]!="") {
	
		if(!in_array($files['Adjunto']['type'], $acceptable) && (!empty($files["Adjunto"]["type"]))) {
			$errors[] = 'Tipo de archivo inválido';
		}
	
		if(count($errors) === 0) {
			$nombre = $files["Adjunto"]["name"];
			$ext  = pathinfo($nombre, PATHINFO_EXTENSION);
			$nombre = "$titulo.$ext";
			move_uploaded_file($files['Adjunto']['tmp_name'], $cRutaImgGeneral.$Registro["tabla"]."/".$nombre); 
			$results[] = " Adjunto='$nombre'";
		} else {
			foreach($errors as $error) {
				echo '<script>alert("'.$error.'");</script>';
			}
		}
	}	 
		
		for($i=1;$i<=30;$i++){
		  $NomImagen="*";
			    
			if( !empty($d["textoImagen{$i}"]) ) {
			
                $textoImagen = $d["textoImagen{$i}"];
				
				$sql="UPDATE imagenes_matriz SET texto='{$textoImagen}' WHERE idimagen={$d["idImagen_{$i}"]}";
			    $r = mysqli_query($nConexion,$sql);
			  
			  if(!$r){
				Mensaje( "Fallo actualizando imagenes.".mysqli_error($nConexion), "modulos_listar.php?modulo=$modulo" ) ;
				exit;
			  }
			  
			}
			    
			if( isset( $files["Imagen{$i}"]["tmp_name"] ) && $files["Imagen{$i}"]["tmp_name"]!="" ) {
			
                $textoImagen = $d["textoImagen{$i}"];
                $NomImagenG = $nId . "_" . $i . "_" . $files["Imagen{$i}"]["name"];
                $NomImagenM = "m_" . $nId . "_" . $i . "_" . $files["Imagen{$i}"]["name"];
                $NomImagenP = "p_" . $nId . "_" . $i . "_" . $files["Imagen{$i}"]["name"];
                $image = new SimpleImage();
                $image->load($files["Imagen{$i}"]["tmp_name"]);
                $image->resizeToWidth(1920);
                $image->save($cRutaImgGeneral.$Registro["tabla"]."/".$NomImagenG);
                $image->resizeToWidth(600);
                $image->save($cRutaImgGeneral.$Registro["tabla"]."/".$NomImagenM);
                $image->resizeToWidth(200);
                $image->save($cRutaImgGeneral.$Registro["tabla"]."/".$NomImagenP);
				
				
				$sql="INSERT into imagenes_matriz (idimagen,idmatriz,idcontenido,imagen,texto) values ('{$d["idImagen_{$i}"]}','{$modulo}','{$nId}','{$NomImagenG}','{$textoImagen}') ON DUPLICATE KEY UPDATE idcontenido='{$nId}',imagen='{$NomImagenG}',texto='{$textoImagen}'";

			  $r = mysqli_query($nConexion,$sql);
			  
			  if(!$r){
				Mensaje( "Fallo actualizando imagenes.".mysqli_error($nConexion), "modulos_listar.php?modulo=$modulo" ) ;
				exit;
			  }
			  
			}
	  
		if( isset( $files["Adjunto{$i}"]["tmp_name"] ) && $files["Adjunto{$i}"]["tmp_name"]!="" ) {
		
			if(!in_array($files["Adjunto{$i}"]["type"], $acceptable) && (!empty($files["Adjunto{$i}"]["type"]))) {
				$errors[] = 'Tipo de archivo inválido';
			}
		
			if(count($errors) === 0) {
				$nombre = $files["Adjunto{$i}"]["name"];
				$name  = pathinfo($nombre, PATHINFO_FILENAME);
				$name = slug($name);
				$ext  = pathinfo($nombre, PATHINFO_EXTENSION);
				$nombre = $nId."_".$i."_$name.$ext";
				move_uploaded_file($files["Adjunto{$i}"]['tmp_name'], $cRutaImgGeneral.$Registro["tabla"]."/".$nombre);
				$sql="INSERT into adjuntos_matriz (idadjunto,idmatriz,idcontenido,adjunto) values ('{$d["idAdjunto_{$i}"]}','{$modulo}','{$nId}','{$nombre}') ON DUPLICATE KEY UPDATE idcontenido='{$nId}',adjunto='{$nombre}'";
				$r = mysqli_query($nConexion,$sql);
			} else {
				foreach($errors as $error) {
					echo '<script>alert("'.$error.'");</script>';
				}
			}
		}	
			unset($d["idImagen_{$i}"]);
			unset($d["idAdjunto_{$i}"]);
			unset($d["textoImagen{$i}"]);
		  }
	  
		foreach ($d as $field => $value ) {
			$results[] = " $field='$value'";
		}
			$results[] = " url='$titulo'";
		$cTxtSQLUpdate = "UPDATE `$tabla` SET ".implode(',',$results)." WHERE id = {$nId}";
    	$ra = mysqli_query($nConexion,$cTxtSQLUpdate  );
	  $sql="update `$tabla` set tags='$tags',palabras='$palabras',publicar='{$d["publicar"]}',url='$titulo' where id = {$nId}";
      $r = mysqli_query($nConexion,$sql);  

	if ( !$ra ) {
	  Mensaje("Error actualizando contenido {$nId} Error: ".mysqli_error($nConexion),"modulos_listar.php?modulo=$modulo");
	  exit;
	}
    	Log_System( $Registro["titulo"] , "EDITA" , "NOMBRE: " . $d["titulo"] );
    	mysqli_close( $nConexion );
    	Mensaje( "El registro ha sido actualizado correctamente.", "modulos_listar.php?modulo=$modulo" ) ;
    	return;
    }
  }

  function modulosEliminar( $modulo,$nId )
  {
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
	$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE id = '$modulo'" ) ;
	$Registro     = mysqli_fetch_array( $Resultado );
	$tabla = $Registro["tabla"];
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT Titulo FROM `$tabla` WHERE id =$nId") );
    $sql = "DELETE FROM `$tabla` WHERE id =$nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando contenido {$nId}","modulos_listar.php?modulo=$modulo");
      exit;
    }
    Log_System( $Registro["titulo"] , "ELIMINA" , "TÍTULO: " . $reg->Titulo  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","modulos_listar.php?modulo=$modulo" );
    exit();
  }
  function modulosFormEditar( $modulo,$nId ) {
    $IdCiudad = $_SESSION["IdCiudad"];
	include("../../vargenerales.php");
    
	$nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
	$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE id = '$modulo'" ) ;
	$matriz     = mysqli_fetch_array( $Resultado );
	$tabla = $matriz["tabla"];
	
	$Resultado    = mysqli_query($nConexion, "SELECT * FROM `$tabla` WHERE id = '$nId'" ) ;
	$Registro     = mysqli_fetch_array( $Resultado );
	
    $tags=explode(",",$Registro["tags"]);
    $palabras=explode(", ",$Registro["palabras"]);
	$campos    = mysqli_query($nConexion, "SELECT * FROM campos ca JOIN campos_matriz cm on (ca.campo=cm.campo) WHERE cm.idmatriz = '$modulo' ORDER BY cm.id ASC" );
	
	$fotos    = mysqli_query($nConexion,"SELECT * FROM imagenes_matriz WHERE idmatriz = $modulo and idcontenido = $nId");
	$adjuntos = mysqli_query($nConexion,"SELECT * FROM adjuntos_matriz WHERE idmatriz = $modulo and idcontenido = $nId");
    
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="modulos.php?Accion=Guardar&amp;modulo=<?=$modulo?>" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $Registro["id"];?>">
      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>CREAR CONTENIDO</b></td>
        </tr>
		<?php while($r = mysqli_fetch_assoc($campos)):  
		if($r["campo"]=="Descripcion"){ $texto="Descripci&oacute;n:";}else{$texto="Resumen:";}
		  ?>
            <?php if($r["tipo"]=="textarea"){ ?>
            <tr>
              <td class="tituloNombres" colspan="2"><?php echo $texto; ?></td>
            </tr>
            <tr>
              <td class="contenidoNombres" colspan="2"><textarea name="<?php echo $r["campo"];?>"><?php echo $Registro[$r["campo"]];?></textarea></td>
                <script>
                    $("textarea").addClass("ckeditor");
                </script>
            </tr>
            <?php } elseif($r["tipo"]=="file") { ?>
            <tr>
                <td class="tituloNombres">Adjuntos:
                    <a href="#nolink" onclick="nuevoAdjunto();">
                    <img src="../../image/add.gif" width="16" height="16" />
                    </a></td>
            <td class="contenidoNombres" colspan="5">
            	<script type="text/javascript">
		function delete_adjunto(file)
		{
			var status = confirm("Esta seguro que desea eliminar el adjunto?");  
			if(status==true)
			{
				var clases = $("."+file);
					$.ajax({
					type:"POST",
					url:"eliminarAdjunto.php",
					data:{file:file},
					success: function(data){
					window.location.reload(true);
					}
				});
			}
		}
			
		$(function(){
			$('.deleteA').on('click', function(e){
				e.preventDefault();
				delete_adjunto($(this).data('adjunto'));
			});
		});
    </script>
        <ul class="adjuntos">
      <?php $i=1; ?>
	  <?php while($Adjuntos = mysqli_fetch_object($adjuntos) ):?>
          <li class="<?php echo $Adjuntos->adjunto; ?>">
          	<a target="_blank" href="<?php echo $cRutaVerImgGeneral.$tabla."/".$Adjuntos->adjunto; ?>"><?php echo $Adjuntos->adjunto; ?></a>
            <input type="file" name="Adjunto<?=$i;?>">
          	<a href="#nolink" class="deleteA" data-adjunto="<?php echo $Adjuntos->adjunto; ?>"><img src="../../image/borrar.gif" width="16" height="16" /></a>
          	<input type="hidden" name="idAdjunto_<?=$i;?>" value="<?=$Adjuntos->idadjunto;?>">
          </li>
      <?php $i+=1; 
	  endwhile;?>
        </ul>
        <?php echo "
		<script type=\"text/javascript\">
        var indexAdjunto={$i};
        
        function nuevoAdjunto(){
            
            $('.adjuntos').append('<li><input type=\"file\" name=\"Adjunto' + indexAdjunto + '\" /><a href=\"#nolink\" id=\"remove\"><img src=\"../../image/borrar.gif\" width=\"16\" height=\"16\" /></a><input type=\"hidden\" name=\"idAdjunto_' + indexAdjunto + '\" value=\"\"/></li>');
            indexAdjunto+=1;
        }

        $(document).on('click', '#remove', function(){
		   $(this).parent('li').remove();
		});
        </script>";?>
            </td>
          </tr>
            <?php  } else { ?>
            <tr>
              <td class="tituloNombres"><?php echo $r["campo"];?>:</td>
              <td class="contenidoNombres"><input type="<?=$r["tipo"];?>" value="<?php echo $Registro[$r["campo"]];?>" name="<?php echo $r["campo"];?>" maxLength="200" style="width: 823px; height: 22px"></td>
            </tr> 
            <?php  } ?>
       <?php endwhile; ?>
        </table>
	<table width="100%">
      <tr>
        <td colspan="4" align="center" class="tituloFormulario"><b>POSICIONAMIENTO</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">T&iacute;tulo:</td>
        <td class="contenidoNombres" colspan="5"><INPUT type="text" name="metaTitulo" class="seocounter_title" maxLength="200" value="<?php echo $Registro["metaTitulo"];?>" style="width: 823px; height: 22px"></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripci&oacute;n:</td>
        <td class="contenidoNombres" colspan="5">
            <textarea name="metaDescripcion" class="seocounter_meta" cols="100" rows="10"><?php echo $Registro["metaDescripcion"];?></textarea>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Tags: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select url,nombre from tbltags_palabras where tag=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="tags[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["url"];?>" <?=in_array($rax["url"],$tags)?"selected":"";?> ><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
        <td class="tituloNombres">Palabras Clave: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select idpalabra,nombre from tbltags_palabras where keyword=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="palabras[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["nombre"];?>" <?=in_array($rax["nombre"],$palabras)?"selected":"";?> ><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
      </tr>
		<?
        if ( Perfil() == "3" )
        {
        ?><input type="hidden" name="optPublicar" id="optPublicar" value="N"><?
        }
        else
        {
        ?>
      <tr>
        <td class="tituloNombres">Imágenes:
            <a href="#nolink" onclick="nuevaImagen();">
                <img src="../../image/add.gif" width="16" height="16" />
            </a>
        </td>
        <td class="contenidoNombres" colspan="5">
	<script type="text/javascript">
		function delete_image(file)
		{
			var status = confirm("Esta seguro que desea eliminar la imagen?");  
			if(status==true)
			{
				var clases = $("."+file);
					$.ajax({
					type:"POST",
					url:"eliminarImagen.php",
					data:{file:file},
					success: function(data){
					window.location.reload(true);
					}
				});
			}
		}
			
		$(function(){
			$('.delete').on('click', function(e){
				e.preventDefault();
				delete_image($(this).data('imagen'));
			});
		});
    </script>
        <ul class="files">
      <?php $i=1; ?>
	  <?php while($Fotos = mysqli_fetch_object($fotos) ):?>
          <li class="<?php echo $Fotos->imagen; ?>"><input type="file" name="Imagen<?=$i;?>"> <input type="text" name="textoImagen<?=$i;?>" value="<?php echo $Fotos->texto; ?>" style="width: 620px" />
          <a href="#nolink" class="delete" data-imagen="<?php echo $Fotos->imagen; ?>"><img src="../../image/borrar.gif" width="16" height="16" /></a>
          </li>
          <li class="<? echo $Fotos->imagen; ?>"><input type="hidden" name="idImagen_<?=$i;?>" value="<?=$Fotos->idimagen;?>"></li>
		  <li class="<? echo $Fotos->imagen; ?>"><img src="<?php echo $cRutaVerImgGeneral.$tabla."/m_".$Fotos->imagen; ?>" width="200"/></li>
      <?php $i+=1; 
	  endwhile;?>
        </ul>
        <?php echo "
		<script type=\"text/javascript\">
        var indexImagen={$i};
        
        function nuevaImagen(){
            
            $('.files').append('<li><input type=\"file\" name=\"Imagen' + indexImagen + '\" /> <input type=\"text\" name=\"textoImagen' + indexImagen + '\" style=\"width: 620px\" /> <a href=\"#nolink\" id=\"remove\"><img src=\"../../image/borrar.gif\" width=\"16\" height=\"16\" /></a><input type=\"hidden\" name=\"idImagen_' + indexImagen + '\" value=\"\"/></li>');
            indexImagen+=1;
        }

        $(document).on('click', '#remove', function(){
		   $(this).parent('li').remove();
		});
        </script>";?>
      
        </td>
      </tr>
        <tr>
            <td class="tituloNombres">Publicar:</td>
            <td class="contenidoNombres" colspan="3">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><label><input type="radio" id="publicar" name="publicar" value="S" <?=$Registro["publicar"]=="S"?"checked":"";?>>Si</label></td>
                        <td width="10"></td>
                        <td><label><input type="radio" id="publicar" name="publicar" value="N" <?=$Registro["publicar"]=="N"?"checked":"";?>>No</label></td>
                    </tr>
                </table>
          </td>
        </tr>
        <?
        }
        ?>
        <tr>
          <td colspan="4" class="nuevo">
      <input type="submit" alt="Guardar Registro." value="Guardar" id="save"/>
	    <a href="modulos_listar.php?modulo=<?=$modulo?>"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
	<?
  mysqli_free_result( $Resultado );
  }
?>
