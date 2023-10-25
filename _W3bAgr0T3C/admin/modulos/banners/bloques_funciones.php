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
  ###############################################################################
  # Nombre        : ServiciosFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de servicios nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function BloquesFormNuevo()
  {
?>
    <!-- Formulario Ingreso -->
    <form method="post" action="bloques.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO BLOQUE</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Bloque:</td>
          <td class="contenidoNombres"><INPUT id="txtBloque" type="text" name="txtBloque" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="bloques_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  }
  ###############################################################################
?>
<?
  function BloquesGuardar( $nId,$Bloque )
  {
    $nConexion = Conectar();
		$IdCiudad			= $_SESSION["IdCiudad"];
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblbanners_bloques ( bloque ) VALUES ( '$Bloque' )");
			Log_System( "BANNERS" , "NUEVO" , "BLOQUE: " . $Bloque );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "bloques_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
	  mysqli_query($nConexion,"UPDATE tblbanners_bloques SET bloque = '$Bloque' WHERE idbloque = $nId"  );
		Log_System( "BANNERS" , "EDITA" , "BLOQUE: " . $Bloque );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido actualizado correctamente.", "bloques_listar.php" ) ;
    exit;
    }
  } // FIN: function 
  ###############################################################################
?>
<?
  function BloquesEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT bloque FROM tblbanners_bloques WHERE idbloque ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblbanners_bloques WHERE idbloque ='$nId'" );
		Log_System( "BANNERS" , "ELIMINA" , "BLOQUE: " . $reg->bloque );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","bloques_listar.php" );
    exit();
  } // FIN: function 
  ###############################################################################
?>
<?
  function BloquesFormEditar( $nId )
  {
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblbanners_bloques WHERE idbloque = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n -->
    <form method="post" action="bloques.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR BLOQUE</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Bloque:</td>
          <td class="contenidoNombres"><INPUT id="txtBloque" type="text" name="txtBloque" value="<? echo $Registro["bloque"]; ?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
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
						?><a href="bloques.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>

            <a href="bloques_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
