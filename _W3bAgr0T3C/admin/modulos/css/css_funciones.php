<? include("../../funciones_generales.php"); ?>
<?
function CssFormNuevo() {
  $IdCiudad = $_SESSION["IdCiudad"];
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="css.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA FRASE</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Descripci�n:</td>
          <td class="contenidoNombres">
	    <textarea name="descripcion" rows="4" cols="70"></textarea>
          </td>
        </tr>
      </table>
      <table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="css.php?action=Guardar"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################
?>
<?php
function CssGuardar( $nId,$cDescripcion ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      mysqli_query($nConexion,"INSERT INTO tblcss ( descripcion ) VALUES ( '$cDescripcion' )");
      Log_System( "FRASES" , "NUEVO" , "FRASE: " . $nId  );
      mysqli_close($nConexion);
      
      Mensaje( "El registro ha sido almacenado correctamente.", "css_listar.php" );
      return;
    }
    else // Actualizar Registro Existente
    {
      $cTxtSQLUpdate = "UPDATE tblcss SET descripcion = '$cDescripcion' WHERE idfrase = '$nId'";

      mysqli_query($nConexion,$cTxtSQLUpdate  );
      Log_System( "FRASES" , "EDITA" , "FRASE: " . $nId );
      mysqli_close( $nConexion );

      Mensaje( "El registro ha sido actualizado correctamente.", "css_listar.php" );
      return;
    }
} // FIN: function UsuariosGuardar

?>
<?php
function CssEliminar( $nId ) {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT idfrase FROM tblcss WHERE idfrase ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblcss WHERE idfrase ='$nId'" );
    Log_System( "FRASES" , "ELIMINA" , "FRASE: " . $reg->idfrase  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","css_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?php
function CssFormEditar( $nId )
  {
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblcss WHERE idfrase = '$nId'" );
    mysqli_close( $nConexion );

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="css.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR FRASE</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Descripci�n:</td>
          <td class="contenidoNombres">
	    <textarea name="descripcion" rows="4" cols="70"><?=$Registro["descripcion"];?></textarea>
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
	      ?><a href="css.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
	      }
	      ?>
            <a href="css_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
