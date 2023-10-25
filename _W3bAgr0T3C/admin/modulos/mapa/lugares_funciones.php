<?

  ###############################################################################

  # productos_funciones.php  :  Archivo de funciones modulo productos / servicios

  # Desarrollo               :  Estilo y Dise�o & Informaticactiva

  # Web                      :  http://www.esidi.com

  #                             http://www.informaticactiva.com

  ###############################################################################

?>

<? include("../../funciones_generales.php"); ?>

<?

  function lugaresFormNuevo()

  {

?>
    <!-- Formulario Ingreso -->
    <form method="post" action="lugares.php?Accion=Guardar" enctype="multipart/form-data" name="frm">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO LUGAR</b></td>
        </tr>
		<tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres"><input type="text" name="txtNombre" id="txtNombre" maxlength="200" style="width:200px" value=""></td>
		</tr>
        <tr>
          <td class="tituloNombres">Descripcion:</td>
          <td class="contenidoNombres"><textarea id="txtDescripcion" name="txtDescripcion"></textarea></td>
        </tr>
		<tr>
          <td class="tituloNombres">Posicion en X:</td>
          <td class="contenidoNombres"><input type="text" name="txtPosicionX" id="txtPosicionX" maxlength="200" style="width:200px" value=""></td>
		</tr>
		<tr>
          <td class="tituloNombres">Posicion en Y:</td>
          <td class="contenidoNombres"><input type="text" name="txtPosicionY" id="txtPosicionY" maxlength="200" style="width:200px" value=""></td>
		</tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="lugares_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?

  }

  ###############################################################################

?>

<?
  ###############################################################################
  function lugaresGuardar( $nId,$Nombre,$Descripcion,$Posicionx,$Posiciony )
  {
		$IdCiudad			= $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblmapa_lugar ( nombre,descripcion,posicionx,posiciony ) VALUES ( '$Nombre','$Descripcion','$Posicionx','$Posiciony' )");
			Log_System( "lugares" , "NUEVO" , "lugares: " . $Nombre );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "lugares_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
		$cTxtSQLUpdate		= "UPDATE tblmapa_lugar SET nombre = '$Nombre',descripcion = '$Descripcion',posicionx = '$Posicionx',posiciony = '$Posiciony'";

		$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idlugar = '$nId'";

	  mysqli_query($nConexion,$cTxtSQLUpdate  );

		Log_System( "lugares" , "EDITA" , "BANNER: " . $Nombre );

    mysqli_close( $nConexion );

    Mensaje( "El registro ha sido actualizado correctamente.", "lugares_listar.php" ) ;

    exit;

    }

  } // FIN: function

  ###############################################################################

?>

<?
  function lugaresEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT nombre FROM tblmapa_lugar WHERE idlugar ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblmapa_lugar WHERE idlugar ='$nId'" );
		Log_System( "lugares" , "ELIMINA" , "BANNER: " . $reg->nombre );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","lugares_listar.php" );
    exit();
  } // FIN: function 
  ###############################################################################
?>

<?

  function lugaresFormEditar( $nId )

  {

		include("../../vargenerales.php");

    $nConexion    = Conectar();

    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmapa_lugar WHERE idlugar = '$nId'" ) ;

    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );

?>

    <!-- Formulario Edici�n / Eliminaci�n -->

    <form method="post" name="frm" action="lugares.php?Accion=Guardar" enctype="multipart/form-data">

      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">

      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO LUGAR</b></td>
        </tr>
		<tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres"><input type="text" name="txtNombre" id="txtNombre" maxlength="200" style="width:200px" value="<? echo $Registro["nombre"]; ?>"></td>
		</tr>
        <tr>
          <td class="tituloNombres">Descripcion:</td>
          <td class="contenidoNombres"><textarea id="txtDescripcion" name="txtDescripcion"><? echo $Registro["descripcion"]; ?></textarea></td>
        </tr>
		<tr>
          <td class="tituloNombres">Posicion en X:</td>
          <td class="contenidoNombres"><input type="text" name="txtPosicionX" id="txtPosicionX" maxlength="200" style="width:200px" value="<? echo $Registro["posicionx"]; ?>"></td>
		</tr>
		<tr>
          <td class="tituloNombres">Posicion en Y:</td>
          <td class="contenidoNombres"><input type="text" name="txtPosicionY" id="txtPosicionY" maxlength="200" style="width:200px" value="<? echo $Registro["posiciony"]; ?>"></td>
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
						?><a href="lugares.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="lugares_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################

?>

