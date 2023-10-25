<?php include("../../funciones_generales.php");
	include("../../herramientas/upload/SimpleImage.php");
  
  function plantillasFormNuevo() {
    $IdCiudad = $_SESSION["IdCiudad"];    
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="plantillas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">      
      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>NUEVA PLANTILLA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres"><input type="text" name="nombre" maxLength="200" style="width: 323px; height: 22px"></td>
        </tr>
        <tr>
            <td class="tituloNombres">Archivo CSS:</td>
        	<td class="contenidoNombres" colspan="5"><input type="file" name="estilo" /></td>
      </tr>
        <tr>
          <td colspan="4" class="nuevo">
              <input type="submit" alt="Guardar Registro." value="Guardar" id="save"/>
              <a href="plantillas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################

  function plantillasGuardar( $d,$files ) {
	include("../../vargenerales.php");
    $IdCiudad = $_SESSION["IdCiudad"];
	$nConexion    = Conectar();
	setlocale(LC_ALL, 'en_US.UTF8');
	$name = slug($d["nombre"]);
	$nId = $d["txtId"];
	$errors     = array();
	$acceptable = array(
		'text/css'
	);
    if ( $nId <= 0 ) {
      $sql = "INSERT INTO plantillas ( nombre, estilo ) 
      		VALUES ( '{$d["nombre"]}'";
	  
		if( isset( $files["estilo"]["tmp_name"] ) && $files["estilo"]["tmp_name"]!="" ) {
		
			if(!in_array($files["estilo"]["type"], $acceptable) && (!empty($files["estilo"]["type"]))) {
				$errors[] = 'Tipo de archivo inválido';
			}
		
			if(count($errors) === 0) {
				$nombre = $files["estilo"]["name"];
				$ext  = pathinfo($nombre, PATHINFO_EXTENSION);
				$nombre = "$name.$ext";
				move_uploaded_file($files["estilo"]['tmp_name'], "../../css/$nombre");
				$sql.=",'{$nombre}')";
			} else {
				foreach($errors as $error) {
					echo '<script>alert("'.$error.'");</script>';
				}
			}
		} else {
				$sql.=",'')";
			}
			$ra = mysqli_query($nConexion,$sql);


      if ( !$ra ) {
	Mensaje( "Fallo guardando registro ".mysqli_error($nConexion), "plantillas_listar.php" ) ;
	exit;
      }
      Log_System( "PLANTILLAS" , "NUEVO" , "NOMBRE: " . $d["nombre"]  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "plantillas_listar.php" ) ;
      return;
    }
    else { 
		$cTxtSQLUpdate = "UPDATE plantillas SET nombre='{$d["nombre"]}'";
	  
		if( isset( $files["estilo"]["tmp_name"] ) && $files["estilo"]["tmp_name"]!="" ) {
		
			if(!in_array($files["estilo"]["type"], $acceptable) && (!empty($files["estilo"]["type"]))) {
				$errors[] = 'Tipo de archivo inválido';
			}
		
			if(count($errors) === 0) {
				$nombre = $files["estilo"]["name"];
				$ext  = pathinfo($nombre, PATHINFO_EXTENSION);
				$nombre = "$name.$ext";
				move_uploaded_file($files["estilo"]['tmp_name'], "../../../css/$nombre");
				$cTxtSQLUpdate.=", estilo='$nombre' WHERE idplantilla = {$nId}";
			} else {
				foreach($errors as $error) {
					echo '<script>alert("'.$error.'");</script>';
				}
			}
		} else {
				$cTxtSQLUpdate.=" WHERE idplantilla = {$nId}";
			}
    	$ra = mysqli_query($nConexion,$cTxtSQLUpdate  );

	if ( !$ra ) {
	  Mensaje("Error actualizando Plantillas {$nId} Error: ".mysqli_error($nConexion),"plantillas_listar.php");
	  exit;
	}
    	Log_System( PLANTILLAS , "EDITA" , "NOMBRE: " . $d["nombre"] );
    	mysqli_close( $nConexion );
    	Mensaje( "El registro ha sido actualizado correctamente.", "plantillas_listar.php" ) ;
    	return;
    }
  }

  function plantillasEliminar( $nId )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT nombre FROM plantillas WHERE idplantilla =$nId") );
    $sql = "DELETE FROM plantillas WHERE idplantilla =$nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando contenido {$nId}","plantillas_listar.php?modulo=$modulo");
      exit;
    }
    Log_System( PLANTILLAS , "ELIMINA" , "TÍTULO: " . $reg->nombre  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","plantillas_listar.php" );
    exit();
  }
  function plantillasFormEditar( $nId ) {
    $IdCiudad = $_SESSION["IdCiudad"];
	include("../../vargenerales.php");
    
	$nConexion    = Conectar();
	
	$Resultado    = mysqli_query($nConexion, "SELECT * FROM plantillas WHERE idplantilla = '$nId'" ) ;
	$Registro     = mysqli_fetch_array( $Resultado );
    
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="plantillas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $Registro["idplantilla"];?>">
      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>EDITAR PLANTILLA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres"><input type="text" name="nombre" maxLength="200" style="width: 323px; height: 22px" value="<?php echo $Registro["nombre"];?>"></td>
        </tr>
        <tr>
            <td class="tituloNombres">Archivo Actual:</td>
        	<td class="contenidoNombres" colspan="5">
				<?php 
					if(!empty($Registro["estilo"])){
						echo $Registro["estilo"];
					}else{
						echo "No se subió ningún archivo .css";
					}?>
            </td>
      </tr>
        <tr>
            <td class="tituloNombres">Archivo CSS:</td>
        	<td class="contenidoNombres" colspan="5"><input type="file" name="estilo" /></td>
      </tr>
        <tr>
          <td colspan="4" class="nuevo">
              <input type="submit" alt="Guardar Registro." value="Guardar" id="save"/>
              <a href="plantillas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
	<?
  mysqli_free_result( $Resultado );
  }
?>
