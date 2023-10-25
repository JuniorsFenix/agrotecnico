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
  # Nombre        : ImagenesFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de servicios nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ImagenesFormNuevo()
  {
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="mapas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA IMAGEN</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="mapas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : ImagenesGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ImagenesGuardar( $nId,$cImagen )
  {
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblmapa ( imagen ) VALUES ( '$cImagen' )");
			Log_System( "MAPAS" , "NUEVO" , "IMAGEN: " . $cImagen  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "mapas_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {

	  if ( $cImagen!= "*" )
      {
        $cTxtSQLUpdate = $cTxtSQLUpdate . "UPDATE tblmapa SET imagen = '$cImagen'"  ;
      }
	  
		$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idmapa = '$nId'";
	  mysqli_query($nConexion,$cTxtSQLUpdate  );
		Log_System( "IMAGENES" , "EDITA" , "IMAGEN: " . $cImagen  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido actualizado correctamente.", "mapas_listar.php" ) ;
    exit;
    }
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : ImagenesEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ImagenesEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT imagen FROM tblmapa WHERE idmapa ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblmapa WHERE idmapa ='$nId'" );
		Log_System( "MAPAS" , "ELIMINA" , "IMAGEN: " . $reg->imagen  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","mapas_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : ImagenesFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ImagenesFormEditar( $nId )
  {
		include("vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmapa WHERE idmapa = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="mapas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR IMAGEN</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
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
              ?><img src="<? echo $cRutaVerImgGaleria . $Registro["imagen"]; ?>"><?
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
						?><a href="mapas.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="mapas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
