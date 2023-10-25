<? include("../../funciones_generales.php"); ?>
<?

  function CabezotesFormNuevo() {
 
    
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="colores.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO COLOR</b></td>
        </tr>

	</table>
	
	<br><br>
	<br><br>
	  <table width="100%">

	    <tr>
	      <td class="tituloNombres">Nombre:</td>
	      <td class="contenidoNombres"><input type="text" id="nombre" name="nombre"></td>
	    </tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
	    <tr>
	      <td class="tituloNombres">Color:</td>
	      <td class="contenidoNombres">
            <p id="colorpickerHolder"></p>
            <script type="text/javascript">
            $('#colorpickerHolder').ColorPicker({flat: true});
            </script>
          </td>
	    </tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
	</table>
	
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="colores_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################
?>
<?php

  function CabezotesGuardar( $nId,$nombre,$color ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      $sql = "INSERT INTO tblti_colores ( nombre,color ) 
      		VALUES ('{$nombre}','{$color}')";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
	Mensaje( "Error registrando nuevo color.", "colores_listar.php" ) ;
	exit;
      }
      Log_System( "colores" , "NUEVO" , "IMAGEN: " . $nombre  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "colores_listar.php" ) ;
      return;
    }
    else {
    	$cTxtSQLUpdate = "UPDATE tblti_colores SET nombre='{$nombre}', color='{$color}'";
    	 
    	$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE id = {$nId}";
    	$ra = mysqli_query($nConexion,$cTxtSQLUpdate  );
	if ( !$ra ) {
	  Mensaje("Error actualizando colores {$nId}","colores_listar.php");
	  exit;
	}
    	Log_System( "colores" , "EDITA" , "IMAGEN: " . $nombre );
    	mysqli_close( $nConexion );
    	Mensaje( "El registro ha sido actualizado correctamente.", "colores_listar.php" ) ;
    	return;
    }
  }
?>
<?
  function CabezotesEliminar( $nId )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT nombre FROM tblti_colores WHERE id ='$nId'") );
    $sql = "DELETE FROM tblti_colores WHERE id = $nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando marca {$nId}","colores_listar.php");
      exit;
    }
    Log_System( "CABEZOTESJQ" , "ELIMINA" , "IMAGEN: " . $reg->nombre  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","colores_listar.php" );
    exit();
  }
?>
<?
  function CabezotesFormEditar( $nId ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblti_colores WHERE id = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="colores.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<?=$nId;?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR COLOR</b></td>
        </tr>
	</table>
	<table width="100%">
	  <tr>
	      <td class="tituloNombres">Nombre:</td>
	      <td class="contenidoNombres"><input type="text" id="nombre" name="nombre" value="<?=$Registro["nombre"]?>">
	      </td>
	    </tr>
	    <tr>
	      <td class="tituloNombres">Color:</td>
	      <td class="contenidoNombres">
            <p id="colorpickerHolder"></p>
            <script type="text/javascript">
            $('#colorpickerHolder').ColorPicker({flat: true});
            </script>
          </td>
	    </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="colores.php?Accion=Eliminar&Id=<?=$nId;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
            <a href="colores_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
?>
