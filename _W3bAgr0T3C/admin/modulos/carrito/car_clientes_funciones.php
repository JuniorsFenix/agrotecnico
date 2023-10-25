<?
  ###############################################################################
  # noticias_funciones.php   :  Archivo de funciones modulo faqs
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : FaqsFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CarClientesFormNuevo()
  {
?>
    <!-- Formulario Ingreso de Noticias -->
    <form method="post" action="car_clientes.php?Accion=Guardar">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table>
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO CLIENTE</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nit/C�dula:</td>
          <td class="contenidoNombres"><input type="text" name="txtNit" maxlength="100" style="width:300px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombres:</td>
          <td class="contenidoNombres"><input type="text" name="txtNombres" maxlength="100" style="width:300px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Apellidos:</td>
          <td class="contenidoNombres"><input type="text" name="txtApellidos" maxlength="100" style="width:300px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Direcci�n:</td>
          <td class="contenidoNombres"><input type="text" name="txtDireccion" maxlength="200" style="width:300px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Telefono:</td>
          <td class="contenidoNombres"><input type="text" name="txtTelefono" maxlength="50" style="width:150px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Mail:</td>
          <td class="contenidoNombres"><input type="text" name="txtMail" maxlength="200" style="width:300px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Clave:</td>
          <td class="contenidoNombres"><input type="text" name="txtClave" maxlength="20" style="width:150px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="car_clientes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : FaqsGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CarClientesGuardar( $nId,$Nombres,$Apellidos,$Direccion,$Telefono,$Mail,$Clave )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tbl_cart_clientes ( nit,nombres,apellidos,direccion,telefono,mail,clave,idciudad ) VALUES ( '$Nit','$Nombres','$Apellidos','$Direccion','$Telefono','$Mail','$Clave',$IdCiudad)");
			Log_System( "CLIENTES CARRITO" , "NUEVO" , "CLIENTE: " . $Nombres." ".$Apellidos  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "car_clientes_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
    	mysqli_query($nConexion, "UPDATE tbl_cart_clientes SET nit = '$Nit', nombres = '$Nombres', apellidos = '$Apellidos', direccion='$Direccion', telefono = '$Telefono', mail='$Mail', clave='$Clave' WHERE idcliente = '$nId'" );
			Log_System( "CLIENTES CARRITO" , "EDITA" , "CLIENTE: " . $Nombres." ".$Apellidos  );
		}
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "car_clientes_listar.php" ) ;
      exit;
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : FaqsEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CarClientesEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT nombres FROM tbl_cart_clientes WHERE idcliente ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tbl_cart_clientes WHERE idcliente ='$nId'" );
		Log_System( "CLIENTES CARRITO" , "ELIMINA" , "NOMBRE: " . $reg->nombres  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","car_clientes_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : FaqsFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CarClientesFormEditar( $nId )
  {
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tbl_cart_clientes WHERE idcliente = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Faqs -->
    <form method="post" action="car_clientes.php?Accion=Guardar">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table>
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CLIENTES</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nit/C�dula:</td>
          <td class="contenidoNombres"><input type="text" name="txtNit" value="<? echo $Registro["nit"]; ?>" maxlength="100" style="width:300px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombres:</td>
          <td class="contenidoNombres"><input type="text" name="txtNombres" value="<? echo $Registro["nombres"]; ?>" maxlength="100" style="width:300px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Apellidos:</td>
          <td class="contenidoNombres"><input type="text" name="txtApellidos" value="<? echo $Registro["apellidos"]; ?>" maxlength="100" style="width:300px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Direcci�n:</td>
          <td class="contenidoNombres"><input type="text" name="txtDireccion" value="<? echo $Registro["direccion"]; ?>" maxlength="200" style="width:300px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Telefono:</td>
          <td class="contenidoNombres"><input type="text" name="txtTelefono" value="<? echo $Registro["telefono"]; ?>" maxlength="50" style="width:150px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Mail:</td>
          <td class="contenidoNombres"><input type="text" name="txtMail" value="<? echo $Registro["mail"]; ?>" maxlength="200" style="width:300px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Clave:</td>
          <td class="contenidoNombres"><input type="text" name="txtClave" value="<? echo $Registro["clave"]; ?>" maxlength="20" style="width:150px"></td>
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
						?><a href="car_clientes.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="car_clientes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
