<?
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo 
  # Desarrollo               :  Estilo y Dise�o - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
	include("../../funciones_generales.php");
?>

<?
  ###############################################################################
  # Descripci�n   : Muestra el formulario para ingreso 
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CiudadesFormNuevo()
	{
	?>
	<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
	<!-- Formulario Ingreso -->
	<form method="post" action="ciudades.php?Accion=Guardar" enctype="multipart/form-data">
		<input TYPE="hidden" id="txtId" name="txtId" value="0">
		<table width="100%">
			<tr>
				<td colspan="2" align="center" class="tituloFormulario"><b>NUEVA CIUDAD</b></td>
			</tr>
			<tr>
				<td class="tituloNombres">Ciudad:</td>
				<td class="contenidoNombres"><INPUT id="txtCiudad" type="text" name="txtCiudad" maxLength="200" style="width:200px; "></td>
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
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="S" checked>Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="N">No</label></td>
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
					<a href="ciudades_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
	# Descripci�n   : Adiciona un nuevo registro o actualiza uno existente a la DB
	# Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
	# Desarrollado  : Estilo y Dise�o & Informaticactiva
	# Retorno       : Ninguno
	###############################################################################
	function CiudadesGuardar( $nId,$cCiudad,$cPublicar )
	{
		$nConexion = Conectar();
		if ( $nId == "0" ) // Nuevo Registro
		{
			mysqli_query($nConexion,"INSERT INTO tblciudades ( ciudad,publicar ) VALUES ( '$cCiudad','$cPublicar' )");
			mysqli_close($nConexion);
			Mensaje( "El registro ha sido almacenado correctamente.", "ciudades_listar.php" ) ;
			exit;
		}
		else // Actualizar Registro Existente
		{
			mysqli_query($nConexion, "UPDATE tblciudades SET ciudad = '$cCiudad', publicar = '$cPublicar' WHERE idciudad = '$nId'" );
		}
		mysqli_close( $nConexion );
		Mensaje( "El registro ha sido actualizado correctamente.", "ciudades_listar.php" ) ;
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
	function CiudadesEliminar( $nId )
	{
		$nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT ciudad FROM tblciudades WHERE idciudad ='$nId'") );
		mysqli_query($nConexion, "DELETE FROM tblciudades WHERE idciudad ='$nId'" );
		Log_System( "CIUDADES" , "ELIMINA" , "CIUDADES: " . $reg->ciudad  );
		mysqli_close( $nConexion );
		Mensaje( "El registro ha sido eliminado correctamente.","ciudades_listar.php" );
		exit();
	} // FIN: function 
	###############################################################################
?>

<?
	###############################################################################
	# Nombre        : ContenidosFormEditar
	# Descripci�n   : Muestra el formulario para editar o eliminar registros
	# Parametros    : $nId = ID de registro que se debe mostrar el en formulario
	# Desarrollado  : Estilo y Dise�o & Informaticactiva
	# Retorno       : Ninguno
	###############################################################################
	function CiudadesFormEditar( $nId )
	{
		include("../../vargenerales.php");
		$nConexion    = Conectar();
		$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblciudades WHERE idciudad = '$nId'" ) ;
		mysqli_close( $nConexion ) ;
		$Registro     = mysqli_fetch_array( $Resultado );
		?>
		<!-- Formulario Edici�n / Eliminaci�n de Contenidos -->
		<form method="post" action="ciudades.php?Accion=Guardar" enctype="multipart/form-data">
			<input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
			<table width="100%">
				<tr>
					<td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CIUDAD</b></td>
				</tr>
				<tr>
					<td class="tituloNombres">Ciudad:</td>
					<td class="contenidoNombres"><INPUT id="txtCiudad" type="text" name="txtCiudad" value="<? echo $Registro["ciudad"]; ?>" maxLength="200" style="width:200px; "></td>
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
						?><a href="ciudades.php?Accion=Eliminar&Id=<? echo $nId; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
						<a href="ciudades_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
					</td>
				</tr>
			</table>
		</form>
		<?
		mysqli_free_result( $Resultado );
	}
	###############################################################################
	?>