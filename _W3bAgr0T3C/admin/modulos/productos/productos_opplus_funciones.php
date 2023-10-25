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
  function ProductosOpPlusFormNuevo()
  {
		$IdCiudad = $_SESSION["IdCiudad"];
?>
    <form method="post" action="productos_opplus.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA OPCION PRODUCTO</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Descripcion:</td>
          <td class="contenidoNombres"><INPUT id="txtDescripcion" type="text" name="txtDescripcion" maxLength="50" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" maxLength="50" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
				<?
				if ( Perfil() == "3" )
				{
				?><input type="hidden" name="optPublicar" id="optPublicar" value="N"><?
				}
				else
				{
				?>
				<tr>
					<td class="tituloNombres">Publicar:</td>
					<td class="contenidoNombres">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><label><input type="radio" id="optPublicar" name="optPublicar" value="S">Si</label></td>
								<td width="10"></td>
								<td><label><input type="radio" id="optPublicar" name="optPublicar" value="N" checked>No</label></td>
							</tr>
						</table>
					</td>
				</tr>
				<?
				}
				?>
					<tr>
						<td colspan="2" class="tituloFormulario">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" class="nuevo">
							<input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
							<a href="productos_opplus_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  function ProductosOpPlusGuardar( $nId,$cDescripcion,$cTitulo,$cPublicar )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblproductosplus ( descripcion,titulo,publicar,idciudad ) VALUES ( '$cDescripcion','$cTitulo','$cPublicar',$IdCiudad )");
			Log_System( "OPCIONES PRODUCTOS" , "NUEVO" , "OPCION: " . $cDescripcion );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "productos_opplus_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
			$cTxtSQLUpdate		= "UPDATE tblproductosplus SET descripcion = '$cDescripcion',titulo = '$cTitulo', publicar = '$cPublicar' WHERE id = '$nId'";
			mysqli_query($nConexion,$cTxtSQLUpdate  );
			Log_System( "OPCIONES PRODUCTOS" , "EDITA" , "OPCION: " . $cDescripcion );
			mysqli_close( $nConexion );
			Mensaje( "El registro ha sido actualizado correctamente.", "productos_opplus_listar.php" ) ;
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
  function ProductosOpPlusEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT descripcion FROM tblproductosplus WHERE id ='$nId'") );
		mysqli_query($nConexion, "DELETE FROM tblproductosplus WHERE id ='$nId'" );
    mysqli_query($nConexion, "DELETE FROM tblproductosopciones WHERE idplus ='$nId'" );
		Log_System( "OPCIONES PRODUCTOS" , "ELIMINA" , "OPCION: " . $reg->descripcion );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","productos_opplus_listar.php" );
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
  function ProductosOpPlusFormEditar( $nId )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
		$RelacionOP_Productos = "S";
		include("../../vargenerales.php");
    $nConexion    	= Conectar();
    $Resultado    	= mysqli_query($nConexion, "SELECT * FROM tblproductosplus WHERE id = '$nId'" ) ;
		$rsProductosPlus= mysqli_query($nConexion, "SELECT * FROM tblproductos WHERE idopcion = '$nId'" ) ;
		if ( !mysqli_num_rows( $rsProductosPlus ) ){
			$RelacionOP_Productos = "N";
		}
    mysqli_close( $nConexion ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Productos -->
    <form method="post" action="productos_opplus.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR OPCION PRODUCTO</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Descripcion:</td>
          <td class="contenidoNombres"><INPUT id="txtDescripcion" type="text" name="txtDescripcion" value="<? echo $Registro["descripcion"]; ?>" maxLength="50" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" value="<? echo $Registro["titulo"]; ?>" maxLength="50" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
			<?
			if ( Perfil() == "3" )
			{
			?><input type="hidden" name="optPublicar" id="optPublicar" value="<? echo $Registro["publicar"] ?>"><?
			}
			else
			{
			?>
			<tr>
				<td class="tituloNombres">Publicar:</td>
				<td class="contenidoNombres">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="S" <? if ( $Registro["publicar"] == "S" ) echo "checked" ?>>Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="N" <? if ( $Registro["publicar"] == "N" ) echo "checked" ?>>No</label></td>
						</tr>
					</table>
			  </td>
			</tr>
			<tr>
				<td colspan="2">
					<?
					if ( $RelacionOP_Productos == "S" ){
						echo "Existen Productos Relacionados: NO PUEDE ELIMINAR";
					}
					?>
					
				</td>
			</tr>
			<?
		}
		?>
       <tr>
         <td colspan="2" class="tituloFormulario">&nbsp;</td>
       </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
						<?
						if ( Perfil() != "3" )
						{
							if ( $RelacionOP_Productos == "N" ){
								?><a href="productos_opplus.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
							}
						}
						?>
            <a href="productos_opplus_listar.php">
						<img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar.">
						</a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
###############################################################################
?>