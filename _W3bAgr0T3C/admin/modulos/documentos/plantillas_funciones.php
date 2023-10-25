<? include("../../funciones_generales.php"); ?>
<?
function plantillasFormNuevo() {
  $IdCiudad = $_SESSION["IdCiudad"];
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="plantillas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA TARJETA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres">
	    <input type="text" name="titulo" value=""/>
          </td>
        </tr>
	<tr>
	  <td class="tituloNombres">Imagen:</td>
	  <td><input type="file" id="txtImagen" name="txtImagen">
	  </td>
	</tr>
	</table>
      
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="plantillas.php?action=Guardar"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################
?>
<?php
function plantillasGuardar( $nId,$cTitulo,$cArchivo ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      mysqli_query($nConexion,"INSERT INTO tblplantillas ( titulo,archivo ) VALUES ( '$cTitulo','$cArchivo' )");
      Log_System( "PLANTILLAS" , "NUEVO" , "PLANTILLA: " . $cArchivo  );
      mysqli_close($nConexion);
      
      Mensaje( "El registro ha sido almacenado correctamente.", "plantillas_listar.php" );
      return;
    }
    else // Actualizar Registro Existente
    {
      $cTxtSQLUpdate = "UPDATE tblplantillas SET titulo = '$cTitulo'";

      if ( $cArchivo != "*" ) {
	$cTxtSQLUpdate = $cTxtSQLUpdate . " , archivo = '$cArchivo'";
      }
       
      $cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idplantilla = '$nId'";
      mysqli_query($nConexion,$cTxtSQLUpdate  );
      Log_System( "PLANTILLAS" , "EDITA" , "PLANTILLA: " . $cArchivo );
      mysqli_close( $nConexion );

      Mensaje( "El registro ha sido actualizado correctamente.", "plantillas_listar.php" );
      return;
    }
} // FIN: function UsuariosGuardar

?>
<?php
function plantillasEliminar( $nId ) {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT archivo FROM tblplantillas WHERE idplantilla ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblplantillas WHERE idplantilla ='$nId'" );
	@ unlink("../../../fotos/Image/plantillas/{$reg->archivo}");
    Log_System( "plantillas" , "ELIMINA" , "TARJETA: " . $reg->archivo  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","plantillas_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?php
function plantillasFormEditar( $nId )
  {
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblplantillas WHERE idplantilla = '$nId'" );
    mysqli_close( $nConexion );

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="plantillas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR TARJETA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres">
	    <input type="text" name="titulo" value="<?=$Registro["titulo"]?>"/>
          </td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen:</td>
	  <td><input type="file" id="txtImagen" name="txtImagen"></td>
        </tr>
	<tr>
          <td class="tituloNombres">Imagen Actual:</td>
          <td>
          <?
            if ( empty($Registro["archivo"]) )
            {
              echo "No se asigno una imagen.";
            }
            else
            {
              ?><img src="<? echo $cRutaVerPlantillas . $Registro["archivo"]; ?>"><?
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
	      <?
	      if ( Perfil() != "3" )
	      {
	      ?><a href="plantillas.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
	      }
	      ?>
            <a href="plantillas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>