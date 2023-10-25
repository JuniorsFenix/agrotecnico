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
    <form method="post" action="imagenes_cli.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
			<input type="hidden" id="idcliente" name="idcliente" value="<? echo $_GET["idcliente"]; ?>">
			<input type="hidden" id="cliente" name="cliente" value="<? echo $_GET["cliente"]; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA IMAGEN<br>CLIENTE: <? echo $_GET["cliente"]; ?></b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Descripci�n:</td>
          <td class="contenidoNombres"><textarea rows="10" id="txtDescripcion" name="txtDescripcion" cols="80"></textarea></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="imagenes_cli_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  function ImagenesGuardar( $nId,$nIdCliente,$cDescripcion,$cImagen )
  {
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblimagenescli ( idcliente,descripcion,imagen ) VALUES ( '$nIdCliente','$cDescripcion','$cImagen' )");
      mysqli_close($nConexion);
			$nomcli = $_POST["cliente"];
      Mensaje( "El registro ha sido almacenado correctamente.", "imagenes_cli_listar.php?idcliente=$nIdCliente&cliente=$nomcli" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
		$cTxtSQLUpdate		= "UPDATE tblimagenescli SET descripcion = '$cDescripcion'";

	  if ( $cImagen!= "*" )
      {
        $cTxtSQLUpdate = $cTxtSQLUpdate . " , imagen = '$cImagen'"  ;
      }
	  
		$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idimagen = '$nId'";
	  mysqli_query($nConexion,$cTxtSQLUpdate  );
    mysqli_close( $nConexion );
		$nomcli = $_POST["cliente"];
    Mensaje( "El registro ha sido actualizado correctamente.", "imagenes_cli_listar.php?idcliente=$nIdCliente&cliente=$nomcli" ) ;
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
		include("vargenerales.php");
    $nConexion = Conectar();
    mysqli_query($nConexion, "DELETE FROM tblimagenescli WHERE idimagen ='$nId'" );
    mysqli_close( $nConexion );
		$nomcli = $_GET["cliente"];
		$idclie = $_GET["idcliente"];
		$Archivo_Borrar = $cRuraImgClientes . $_GET["archivo"] ;
		unlink( $Archivo_Borrar );
    Mensaje( "El registro ha sido eliminado correctamente.","imagenes_cli_listar.php?idcliente=$idclie&cliente=$nomcli" );
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
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblimagenescli WHERE idimagen = '$nId'" ) ;
    mysqli_close( $nConexion ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="imagenes_cli.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
			<input type="hidden" id="idcliente" name="idcliente" value="<? echo $_GET["idcliente"]; ?>">
			<input type="hidden" id="cliente" name="cliente" value="<? echo $_GET["cliente"]; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR IMAGEN<br>CLIENTE: <? echo $_GET["cliente"]; ?></b></td>
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
              ?><img src="<? echo $cRuraVerImgClientes . $Registro["imagen"]; ?>"><?
            }
          ?>
          </td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Descripci�n:</td>
          <td class="contenidoNombres"><textarea rows="10" id="txtDescripcion" name="txtDescripcion" cols="80"><? echo $Registro["descripcion"]; ?></textarea></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
						<a href="imagenes_cli.php?Accion=Eliminar&Id=<? echo $nId ;?>&idcliente=<? echo $_GET["idcliente"]; ?>&cliente=<? echo $_GET["cliente"]; ?>&archivo=<? echo $Registro["imagen"]; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
            <a href="imagenes_cli_listar.php?idcliente=<? echo $_GET["idcliente"]; ?>&cliente=<? echo $_GET["cliente"]; ?>"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
