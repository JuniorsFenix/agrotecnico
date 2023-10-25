<? include("../../funciones_generales.php");
	include("../../herramientas/upload/SimpleImage.php");

  function EstilosFormNuevo() {
    $IdCiudad = $_SESSION["IdCiudad"];
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="estilos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO ESTLO</b></td>
        </tr>

	</table>
	
	<br><br>
	<br><br>
	  <table width="100%">
	    <tr>
	      <td class="tituloNombres">Nombre:</td>
	      <td class="contenidoNombres"><input type="text" id="nombre" name="nombre"></td>
	    </tr>
	    <tr>
	      <td class="tituloNombres">CSS:</td>
	      <td class="contenidoNombres"><input type="file" id="css" name="css"></td>
	    </tr>
	    <tr>
	      <td class="tituloNombres">Jquery:</td>
	      <td class="contenidoNombres"><input type="file" id="jquery" name="jquery"></td>
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
            
            $('.files').append('<li><input type="file" name="txtImagen' + indexImagen + '" /><a href="#nolink" id="remove"><img src="../../image/borrar.gif" width="16" height="16" /></a></li>');
            indexImagen+=1;
        }

        $(document).on("click", "#remove", function(){
		   $(this).parent('li').remove();
		});
        </script>
        <ul class="files">
        <li><input type="file" name="txtImagen1" /></li>
        </ul>
        </td>
      </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
	</table>
	
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="estilos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################

  function EstilosGuardar( $d,$files ) {
    $IdCiudad = $_SESSION["IdCiudad"];
	include("../../vargenerales.php");
    $nConexion = Conectar();
    $nId = $d["txtId"];
    $css = $files["css"]["name"];
    $jquery = $files["jquery"]["name"];
    if ( $nId <= 0 ) {
      $sql = "INSERT INTO tblestilos ( nombre,css,jquery ) 
      		VALUES ('{$d["nombre"]}','{$files["css"]["name"]}','{$files["jquery"]["name"]}')";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
	Mensaje( "Error registrando nuevo estilo.", "estilos_listar.php" ) ;
	exit;
      }
	  
      $d["idestilo"] = mysqli_insert_id($nConexion);
	  
		  $cssTempFile=$files["css"]["tmp_name"];
			if( isset( $cssTempFile ) && $cssTempFile!="" ) {
			
			$targetFile =  $cRutaEstilos. $css;
			move_uploaded_file($cssTempFile,$targetFile);
			}
			
		  $jTempFile=$files["jquery"]["tmp_name"];
			if( isset( $jTempFile ) && $jTempFile!="" ) {
			
			$targetFile =  $cRutaEstilos. $jquery;
			move_uploaded_file($jTempFile,$targetFile);
			}
			   
	  for($i=1;$i<=20;$i++){
			if( isset( $files["txtImagen{$i}"]["tmp_name"] ) && $files["txtImagen{$i}"]["tmp_name"]!="" ) {
			
				$NomImagen = $files["txtImagen{$i}"]["name"];
	
			  move_uploaded_file($files["txtImagen{$i}"]["tmp_name"],$cRutaEstilos . $NomImagen);
				
				$sql="insert into tblimagenes_estilos (idestilo,imagen) values ('{$d["idestilo"]}','{$NomImagen}')";

			  $r = mysqli_query($nConexion,$sql);
		
			  
			  if(!$r){
				Mensaje( "Fallo actualizando imagenes.".mysqli_error($nConexion), "estilos_listar.php?idcategoria={$d["IdCategoria"]}" ) ;
				exit;
			  }
		  
		  }
				     
      }

      Log_System( "ESTILOS" , "NUEVO" , "Nombre: " . $archivo  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "estilos_listar.php" ) ;
      return;
    }
    else {
    	$cTxtSQLUpdate = "UPDATE tblestilos SET nombre='{$d["nombre"]}',css='{$files["css"]["name"]}',jquery='{$files["jquery"]["name"]}'";
    	 
    	$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE id = {$nId}";
    	$ra = mysqli_query($nConexion,$cTxtSQLUpdate  );
	if ( !$ra ) {
	  Mensaje("Error actualizando Estilos {$nId}","estilos_listar.php");
	  exit;
	}	
	for($i=1;$i<=20;$i++){
		  $NomImagen="*";
			    
			if( isset( $files["txtImagen{$i}"]["tmp_name"] ) && $files["txtImagen{$i}"]["tmp_name"]!="" ) {
			
				$NomImagen = $files["txtImagen{$i}"]["name"];
	
			  $image = new SimpleImage();
			  $image->load($files["txtImagen{$i}"]["tmp_name"]);
			  $image->save($cRutaEstilos . $NomImagen);
				
				$sql="INSERT into tblimagenes_estilos (idimagen,idestilo,imagen) values ('{$d["id_{$i}"]}','{$nId}','{$NomImagen}') ON DUPLICATE KEY UPDATE idestilo='{$nId}',imagen='{$NomImagen}'";

			  $r = mysqli_query($nConexion,$sql);
		
			  if(!$r){
				Mensaje( "Fallo actualizando imagenes.".mysqli_error($nConexion), "estilos_listar.php?idcategoria={$d["IdCategoria"]}" ) ;
				exit;
			  }

			}        
      }      

    	Log_System( "CABEZOTESJQ" , "EDITA" , "IMAGEN: " . $archivo );
    	mysqli_close( $nConexion );
    	Mensaje( "El registro ha sido actualizado correctamente.", "estilos_listar.php" ) ;
    	return;
    }
  }

  function EstilosEliminar( $nId )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT archivo FROM tblestilos WHERE idcabezote ='$nId'") );
    $sql = "DELETE FROM tblestilos WHERE idcabezote = $nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando cabezote {$nId}","estilos_listar.php");
      exit;
    }
    Log_System( "CABEZOTESJQ" , "ELIMINA" , "IMAGEN: " . $reg->archivo  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","estilos_listar.php" );
    exit();
  }

  function EstilosFormEditar( $nId ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblestilos WHERE id = '$nId'" );
	$fotos    = mysqli_query($nConexion,"SELECT * FROM tblimagenes_estilos WHERE idestilo = $nId");
    mysqli_close( $nConexion );

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edición / Eliminación de Servicios -->
    <form method="post" action="estilos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<?=$nId;?>">
	  <table width="100%">
	    <tr>
	      <td class="tituloNombres">Nombre:</td>
	      <td class="contenidoNombres"><input type="text" id="nombre" name="nombre" value="<?php echo $Registro["nombre"]; ?>"></td>
	    </tr>
	    <tr>
	      <td class="tituloNombres">CSS:</td>
	      <td class="contenidoNombres"><input type="file" id="css" name="css"></td>
	    </tr>
        <tr>
          <td class="tituloNombres">CSS Actual:</td>
          <td>
          <?
            if ( empty($Registro["css"]) )
            {
              echo "No se asigno CSS.";
            }
            else
            {
              ?><a target="_blank" href="<?php echo $cRutaVerEstilos.$Registro["css"]; ?>">
              <?php echo $Registro["css"]; ?>
              </a>
			  <?
            }
          ?>
          </td>
        </tr>
	    <tr>
	      <td class="tituloNombres">Jquery:</td>
	      <td class="contenidoNombres"><input type="file" id="jquery" name="jquery"></td>
	    </tr>        
        <tr>
          <td class="tituloNombres">Jquery Actual:</td>
          <td>
          <?
            if ( empty($Registro["jquery"]) )
            {
              echo "No se asigno Jquery.";
            }
            else
            {
              ?><a target="_blank" href="<?php echo $cRutaVerEstilos.$Registro["jquery"]; ?>">
              <?php echo $Registro["jquery"]; ?>
              </a>
			  <?
            }
          ?>
          </td>
        </tr>

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
			  url:"eliminar.php",
			  data:{file:file},
			  success: function(data){
				  window.location.reload(true);
			  }
			});
		  }
		 }
		 
	$(function(){
    $('.delete').on('click', function(e){
        e.preventDefault(); // stops the link doing what it normally 
                            // would do which is jump to page top with href="#"
        delete_image($(this).data('imagen'));
    });
});
    </script>
        <ul class="files">
      <?php $i=1; ?>
	  <?php while($Fotos = mysqli_fetch_object($fotos) ):?>
          <li class="<?php echo $Fotos->imagen; ?>"><input type="file" name="txtImagen<?=$i;?>">
          <a href="#nolink" class="delete" data-imagen="<? echo $Fotos->imagen; ?>"><img src="../../image/borrar.gif" width="16" height="16" /></a>
          </li>
          <li class="<?php echo $Fotos->imagen; ?>"><input type="hidden" name="id_<?=$i;?>" value="<?=$Fotos->idimagen;?>"></li>
		  <li class="<?php echo $Fotos->imagen; ?>"><img src="<? echo $cRutaVerEstilos.$Fotos->imagen; ?>"/></li>
      <?php $i+=1; 
	  endwhile;?>
        </ul>
        <?php echo "
		<script type=\"text/javascript\">
        var indexImagen={$i};
        
        function nuevaImagen(){
            
            $('.files').append('<li><input type=\"file\" name=\"txtImagen' + indexImagen + '\" /><a href=\"#nolink\" id=\"remove\"><img src=\"../../image/borrar.gif\" width=\"16\" height=\"16\" /></a><input type=\"hidden\" name=\"id_' + indexImagen + '\" value=\"\"/></li>');
            indexImagen+=1;
        }

        $(document).on('click', '#remove', function(){
		   $(this).parent('li').remove();
		});
        </script>";?>
      
        </td>
      </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
                <tr>
          <td colspan="4" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <?
            if ( Perfil() != "3" )
            {
            ?><a href="estilos.php?Accion=Eliminar&Id=<?php echo $nId; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('¿Esta seguro que desea eliminar este registro?')"></a><?
            }
            ?>
            <a href="estilos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>

	</table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
?>
