<? include("../../funciones_generales.php");

  function CuerdasFormNuevo() {
  	global $targets;    
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="cuerdas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA CUERDA</b></td>
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
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
	</table>
	
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="cuerdas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################

  function CuerdasGuardar( $nId,$nombre ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      $sql = "INSERT INTO tblki_cuerdas ( nombre ) 
      		VALUES ('{$nombre}')";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
	Mensaje( "Error registrando nueva cuerda.", "cuerdas_listar.php" ) ;
	exit;
      }
      Log_System( "CUERDAS" , "NUEVO" , ""  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "cuerdas_listar.php" ) ;
      return;
    }
    else {
    	$cTxtSQLUpdate = "UPDATE tblki_cuerdas SET nombre='{$nombre}'";
    	 
    	$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idcuerda = {$nId}";
    	$ra = mysqli_query($nConexion,$cTxtSQLUpdate  );
	if ( !$ra ) {
	  Mensaje("Error actualizando cuerda {$nId}","cuerdas_listar.php");
	  exit;
	}
    	Log_System( "CUERDAS" , "EDITA" , "" );
    	mysqli_close( $nConexion );
    	Mensaje( "El registro ha sido actualizado correctamente.", "cuerdas_listar.php" ) ;
    	return;
    }
  }

  function CuerdasEliminar( $nId )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT imagen FROM tblki_cuerdas WHERE idcuerda ='$nId'") );
    $sql = "DELETE FROM tblki_cuerdas WHERE idcuerda = $nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando marca {$nId}","cuerdas_listar.php");
      exit;
    }
    Log_System( "CUERDAS" , "ELIMINA" , "IMAGEN: " . $reg->imagen  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","cuerdas_listar.php" );
    exit();
  }

  function CuerdasFormEditar( $nId ) {
  	global $targets;
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblki_cuerdas WHERE idcuerda = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="cuerdas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<?=$nId;?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CUERDA</b></td>
        </tr>
	</table>
	<table width="100%">
	  <tr>
	      <td class="tituloNombres">Nombre:</td>
	      <td class="contenidoNombres"><input type="text" id="nombre" name="nombre" value="<?=$Registro["nombre"]?>">
	      </td>
	    </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="cuerdas.php?Accion=Eliminar&Id=<?=$nId;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
            <a href="cuerdas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
?>
