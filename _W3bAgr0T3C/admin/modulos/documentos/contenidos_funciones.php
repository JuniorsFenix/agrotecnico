<? include("../../funciones_generales.php"); ?>
<?
function contenidosFormNuevo() {
  $IdCiudad = $_SESSION["IdCiudad"];
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="contenidos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO CONTENIDO</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres">
	    <input type="text" name="titulo"/>
          </td>
        </tr>
        <tr>
          <td class="tituloNombres">Descripci�n:</td>
          <td class="contenidoNombres">
            <textarea name="descripcion"></textarea>
            <script>
                CKEDITOR.replace( 'descripcion' );
            </script>
          </td>
        </tr>
      </table>
      <table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="contenidos.php?action=Guardar"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################
?>
<?php
function contenidosGuardar( $nId,$cTitulo,$cDescripcion ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      mysqli_query($nConexion,"INSERT INTO tbldocumentos ( titulo,descripcion ) VALUES ( '$cTitulo','$cDescripcion' )");
      Log_System( "DOCUMENTOS" , "NUEVO" , "CONTENIDO: " . $nId  );
      mysqli_close($nConexion);
      
      Mensaje( "El registro ha sido almacenado correctamente.", "contenidos_listar.php" );
      return;
    }
    else // Actualizar Registro Existente
    {
      $cTxtSQLUpdate = "UPDATE tbldocumentos SET titulo = '$cTitulo', descripcion = '$cDescripcion' WHERE idcontenido = '$nId'";

      mysqli_query($nConexion,$cTxtSQLUpdate  );
      Log_System( "DOCUMENTOS" , "EDITA" , "CONTENIDO: " . $nId );
      mysqli_close( $nConexion );

      Mensaje( "El registro ha sido actualizado correctamente.", "contenidos_listar.php" );
      return;
    }
} // FIN: function UsuariosGuardar

?>
<?php
function contenidosEliminar( $nId ) {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT idcontenido FROM tbldocumentos WHERE idcontenido ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tbldocumentos WHERE idcontenido ='$nId'" );
    Log_System( "contenidos" , "ELIMINA" , "FRASE: " . $reg->idcontenido  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","contenidos_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?php
function contenidosFormEditar( $nId )
  {
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tbldocumentos WHERE idcontenido = '$nId'" );
    mysqli_close( $nConexion );

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="contenidos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR FRASE</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres">
	    <input type="text" name="titulo" value="<?=$Registro["titulo"]?>"/>
          </td>
        </tr>
        <tr>
          <td class="tituloNombres">Descripci�n:</td>
          <td class="contenidoNombres">
	    <textarea name="descripcion"><?=$Registro["descripcion"];?></textarea>
		<script>
            CKEDITOR.replace( 'descripcion' );
        </script>
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
	      ?><a href="contenidos.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
	      }
	      ?>
            <a href="contenidos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
