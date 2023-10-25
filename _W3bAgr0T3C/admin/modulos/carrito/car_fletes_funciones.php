<?
  ###############################################################################
  # noticias_funciones.php   :  Archivo de funciones 
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             oscar_yepes@hotmail.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Descripci�n   : Muestra el formulario para ingreso
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CarFletesFormNuevo()
  {
?>
    <form method="post" action="car_fletes.php?Accion=Guardar">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table>
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO FLETE</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><input type="text" name="txtTitulo" maxlength="100" style="width:300px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Precio:</td>
          <td class="contenidoNombres"><input type="text" name="txtPrecio" maxlength="100" style="width:300px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="car_fletes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CarFletesGuardar( $nId,$Titulo,$Precio )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tbl_cart_fletes ( titulo,precio,idciudad ) VALUES ( '$Titulo',$Precio,$IdCiudad)");
			Log_System( "FLETES CARRITO" , "NUEVO" , "FLETE: " . $Titulo );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "car_fletes_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
    	mysqli_query($nConexion, "UPDATE tbl_cart_fletes SET titulo = '$Titulo', precio = $Precio WHERE idflete = '$nId'" );
			Log_System( "FLETES CARRITO" , "EDITA" , "FLETE: " . $Titulo );
		}
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "car_fletes_listar.php" ) ;
      exit;
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CarFletesEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT titulo FROM tbl_cart_fletes WHERE idflete ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tbl_cart_fletes WHERE idflete ='$nId'" );
		Log_System( "FLETES CARRITO" , "ELIMINA" , "FLETE: " . $reg->titulo  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","car_fletes_listar.php" );
    exit();
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CarFletesFormEditar( $nId )
  {
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tbl_cart_fletes WHERE idflete = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <form method="post" action="car_fletes.php?Accion=Guardar">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table>
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR FLETES</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><input type="text" name="txtTitulo" value="<? echo $Registro["titulo"]; ?>" maxlength="100" style="width:300px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Precio:</td>
          <td class="contenidoNombres"><input type="text" name="txtPrecio" value="<? echo $Registro["precio"]; ?>" maxlength="100" style="width:300px"></td>
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
						?><a href="car_fletes.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="car_fletes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
