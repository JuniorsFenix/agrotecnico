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
  # Nombre        : ProductosFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ClientesImgFormNuevo()
  {
?>
    <!-- Formulario Ingreso de Productos -->
    <form method="post" action="clientes_img.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO CLIENTE</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombres:</td>
          <td class="contenidoNombres"><INPUT id="txtNombres" type="text" name="txtNombres" maxLength="60" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Apellidos:</td>
          <td class="contenidoNombres"><INPUT id="txtApellidos" type="text" name="txtApellidos" maxLength="60" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Mail:</td>
          <td class="contenidoNombres"><INPUT id="txtMail" type="text" name="txtMail" maxLength="200" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Usuario:</td>
          <td class="contenidoNombres"><INPUT id="txtUsuario" type="text" name="txtUsuario" maxLength="10" style="WIDTH: 150px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Clave:</td>
          <td class="contenidoNombres"><INPUT id="txtClave" type="text" name="txtClave" maxLength="20" style="WIDTH: 150px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="clientes_img_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : ProductosGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ClientesImgGuardar( $nId,$Nombres,$Apellidos,$Mail,$Usuario,$Clave )
  {
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblclientesimg ( nombres,apellidos,mail,usuario,clave ) VALUES ( '$Nombres','$Apellidos','$Mail','$Usuario','$Clave' )");
			Log_System( "CLIENTES IMAGENES" , "NUEVO" , "CLIENTE: " . $Nombres. " " . $Apellidos );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "clientes_img_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
			$cTxtSQLUpdate		= "UPDATE tblclientesimg SET nombres = '$Nombres',apellidos = '$Apellidos',mail = '$Mail',usuario = '$Usuario', clave = '$Clave' WHERE idcliente = '$nId'";
			mysqli_query($nConexion,$cTxtSQLUpdate  );
			Log_System( "CLIENTES IMAGENES" , "EDITA" , "CLIENTE: " . $Nombres. " " . $Apellidos );
			mysqli_close( $nConexion );
			Mensaje( "El registro ha sido actualizado correctamente.", "clientes_img_listar.php" ) ;
			exit;
    }
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : ProductosEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ClientesImgEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT CONCAT(nombres,' ',apellidos) as nombres from tblclientesimg WHERE idcliente ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblclientesimg WHERE idcliente ='$nId'" );
		Log_System( "CLIENTES IMAGENES" , "ELIMINA" , "CLIENTE: " . $reg->nombres );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","clientes_img_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : ProductosFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ClientesImgFormEditar( $nId )
  {
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblclientesimg WHERE idcliente = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Productos -->
    <form method="post" action="clientes_img.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CLIENTE</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombres:</td>
          <td class="contenidoNombres"><INPUT id="txtNombres" type="text" name="txtNombres" maxLength="60" value="<? echo $Registro["nombres"];  ?>" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Apellidos:</td>
          <td class="contenidoNombres"><INPUT id="txtApellidos" type="text" name="txtApellidos" maxLength="60" value="<? echo $Registro["apellidos"];  ?>" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Mail:</td>
          <td class="contenidoNombres"><INPUT id="txtMail" type="text" name="txtMail" maxLength="200" value="<? echo $Registro["mail"];  ?>" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Usuario:</td>
          <td class="contenidoNombres"><INPUT id="txtUsuario" type="text" name="txtUsuario" maxLength="10" value="<? echo $Registro["usuario"];  ?>" style="WIDTH: 150px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Clave:</td>
          <td class="contenidoNombres"><INPUT id="txtClave" type="text" name="txtClave" maxLength="20" value="<? echo $Registro["clave"];  ?>" style="WIDTH: 150px; HEIGHT: 22px"></td>
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
						?><a href="clientes_img.php?Accion=Eliminar&Id=<? echo $nId; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="clientes_img_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
