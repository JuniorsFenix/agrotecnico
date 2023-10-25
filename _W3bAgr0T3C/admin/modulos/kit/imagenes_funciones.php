<? include("../../funciones_generales.php"); ?>
<?


  
  function ImagenesFormNuevo() {
    $IdCiudad = $_SESSION["IdCiudad"];
 
    
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="imagenes.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA IMAGEN</b></td>
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
	      <td class="tituloNombres">Imagen:</td>
	      <td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen"></td>
	    </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
	</table>
	
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="imagenes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################
?>
<?php

  function ImagenesGuardar( $nId,$archivo,$nombre ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      $sql = "INSERT INTO tblki_imagenes ( imagen,nombre ) 
      		VALUES ('{$archivo}','{$nombre}')";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
	Mensaje( "Error registrando nueva imagen.", "imagenes_listar.php" ) ;
	exit;
      }
      Log_System( "IMAGENES" , "NUEVO" , "IMAGEN: " . $archivo  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "imagenes_listar.php" ) ;
      return;
    }
    else {
    	$cTxtSQLUpdate = "UPDATE tblki_imagenes SET nombre='{$nombre}'";

    	if ( $archivo != "*" ){
    	    $cTxtSQLUpdate = $cTxtSQLUpdate . " , imagen = '{$archivo}'"  ;
    	}
    	 
    	$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idimagen = {$nId}";
    	$ra = mysqli_query($nConexion,$cTxtSQLUpdate  );
	if ( !$ra ) {
	  Mensaje("Error actualizando fondo {$nId}","imagenes_listar.php");
	  exit;
	}
    	Log_System( "IMAGENES" , "EDITA" , "IMAGEN: " . $archivo );
    	mysqli_close( $nConexion );
    	Mensaje( "El registro ha sido actualizado correctamente.", "imagenes_listar.php" ) ;
    	return;
    }
  }
?>
<?
  function ImagenesEliminar( $nId )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT imagen FROM tblki_imagenes WHERE idimagen ='$nId'") );
    $sql = "DELETE FROM tblki_imagenes WHERE idimagen = $nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando fondo {$nId}","imagenes_listar.php");
      exit;
    }
    Log_System( "IMAGENES" , "ELIMINA" , "IMAGEN: " . $reg->imagen  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","imagenes_listar.php" );
    exit();
  }
?>
<?
  function ImagenesFormEditar( $nId ) {
  	global $targets;
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblki_imagenes WHERE idimagen = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="imagenes.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<?=$nId;?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR FONDO</b></td>
        </tr>
	</table>
	<table width="100%">
	    <tr>
	      <td class="tituloNombres">Nombre:</td>
	      <td class="contenidoNombres"><input type="text" id="nombre" value="<?php echo $Registro["nombre"]; ?>" name="nombre"></td>
	    </tr>
          <tr>
	      <td class="tituloNombres">Imagen:</td>
	      <td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen"></td>
	    </tr>
        <tr>
          <td class="tituloNombres">Imagen Actual:</td>
          <td>
          <?
            if ( empty($Registro["imagen"]) )
            {
              echo "No se asigno una imagen.";
            }
            else
            {
              ?><img src="<?=$cRutaVerKit.$Registro["imagen"]; ?>"><?
            }
          ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="imagenes.php?Accion=Eliminar&Id=<?=$nId;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
            <a href="imagenes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
?>
