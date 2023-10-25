<? include("../../funciones_generales.php"); ?>
<?

  function CabezotesFormNuevo() {
 
    
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="tecnologias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA TECNOLOG&Iacute;A</b></td>
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
	      <td class="tituloNombres">Descripci&oacute;n:</td>
	      <td class="contenidoNombres">
                    <textarea id="descripcion" name="descripcion"></textarea>
                    <script>
                        CKEDITOR.replace( 'descripcion' );
                    </script></td>
	    </tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
	</table>
	
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="tecnologias_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################
?>
<?php

  function CabezotesGuardar( $nId,$nombre,$descripcion ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      $sql = "INSERT INTO tblti_tecnologias ( nombre,descripcion ) 
      		VALUES ('{$nombre}','{$descripcion}')";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
	Mensaje( "Error registrando nuevoa tecnolog&iacute;.", "tecnologias_listar.php" ) ;
	exit;
      }
      Log_System( "tecnologi&iacute;s" , "NUEVO" , "IMAGEN: " . $nombre  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "tecnologias_listar.php" ) ;
      return;
    }
    else {
    	$cTxtSQLUpdate = "UPDATE tblti_tecnologias SET nombre='{$nombre}', descripcion='{$descripcion}'";
    	 
    	$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE id = {$nId}";
    	$ra = mysqli_query($nConexion,$cTxtSQLUpdate  );
	if ( !$ra ) {
	  Mensaje("Error actualizando tecnologias {$nId}","tecnologias_listar.php");
	  exit;
	}
    	Log_System( "tecnologias" , "EDITA" , "IMAGEN: " . $nombre );
    	mysqli_close( $nConexion );
    	Mensaje( "El registro ha sido actualizado correctamente.", "tecnologias_listar.php" ) ;
    	return;
    }
  }
?>
<?
  function CabezotesEliminar( $nId )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT nombre FROM tblti_tecnologias WHERE id ='$nId'") );
    $sql = "DELETE FROM tblti_tecnologias WHERE id = $nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando marca {$nId}","tecnologias_listar.php");
      exit;
    }
    Log_System( "TECNOLOGIAS" , "ELIMINA" , "IMAGEN: " . $reg->nombre  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","tecnologias_listar.php" );
    exit();
  }
?>
<?
  function CabezotesFormEditar( $nId ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblti_tecnologias WHERE id = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="tecnologias.php?Accion=Guardar" enctype="multipart/form-data">
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
	    <tr>
	      <td class="tituloNombres">Descripci&oacute;n:</td>
	      <td class="contenidoNombres">
                    <textarea id="descripcion" name="descripcion"><?=$Registro["descripcion"]?></textarea>
                    <script>
                        CKEDITOR.replace( 'descripcion' );
                    </script></td>
	    </tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="tecnologias.php?Accion=Eliminar&Id=<?=$nId;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
            <a href="tecnologias_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
?>
