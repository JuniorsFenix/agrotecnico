<? include("../../funciones_generales.php"); ?>
<?

  $targets = array(
    "_self",
    "_blank"
  );

  
  function CabezotesFormNuevo() {
  	global $targets;
 
    
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="especificaciones.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA ESPECIFICACI�N</b></td>
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
	    <a href="especificaciones_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################
?>
<?php

  function CabezotesGuardar( $nId,$nombre,$url,$imagen,$target ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();

    	if ( !empty($imagen) ){
        $cTxtSQLUpdate = "UPDATE tblti_espec SET ";
    	  $cTxtSQLUpdate = $cTxtSQLUpdate . " imagen = '{$imagen}'"  ;
        $cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE nombre = '{$nombre}'";
//echo $cTxtSQLUpdate;
        $ra = mysqli_query($nConexion,$cTxtSQLUpdate  );

        if ( !$ra ) {
          Mensaje("Error actualizando especificacion {$nId}","especificaciones_listar.php");
          exit;
        }

        Log_System( "especificaciones" , "EDITA" , "IMAGEN: " . $imagen );
        mysqli_close( $nConexion );
        Mensaje( "El registro ha sido actualizado correctamente.", "especificaciones_listar.php" ) ;
    	}

    	return;
  }
?>
<?
  function CabezotesEliminar( $nId )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT imagen FROM tblti_espec WHERE idproducto ='$nId'") );
    $sql = "DELETE FROM tblti_espec WHERE idproducto = $nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando especificacion {$nId}","especificaciones_listar.php");
      exit;
    }
    Log_System( "especificaciones" , "ELIMINA" , "IMAGEN: " . $reg->imagen  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","especificaciones_listar.php" );
    exit();
  }
?>
<?
  function CabezotesFormEditar( $nId ) {
  	global $targets;
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion = Conectar();

    $sql = "SELECT * from tblti_espec WHERE nombre = '{$nId}' group by nombre order by nombre";
//echo $sql;
    $Resultado = mysqli_query($nConexion, $sql ) ;
    mysqli_close( $nConexion ) ;

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="especificaciones.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<?=$nId;?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR IMAGEN DE ESPECIFICACION</b></td>
        </tr>
	</table>
  
	<table width="100%">
      <tr>
	      <td class="tituloNombres">Nombre:</td>
	      <td class="contenidoNombres"><input readonly type="text" id="nombre" name="nombre" value="<?=$Registro["nombre"]?>">
	      </td>
	    </tr>

          <tr>
	      <td class="tituloNombres">Imagen:</td>
	      <td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen"></td>
	    </tr>
        <tr>
          <td class="tituloNombres">Imagen Actual:</td>
          <td>
          <?
            if ( empty($Registro["imagen"]) ){
              echo "No se asigno una imagen.";
            }else{
              ?><img src="<?=$cRutaImagenEspec.$Registro["imagen"]; ?>"><?
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
	    
      <!--<a href="especificaciones.php?Accion=Eliminar&Id=<?=$nId;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>-->
      
            <a href="especificaciones_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
?>
