<?php
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo 
  # Desarrollo               :  Estilo y Diseño - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
	include("../../funciones_generales.php");
  ###############################################################################
  # Descripción   : Muestra el formulario para ingreso 
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CiudadesFormNuevo()
	{
	?>
	<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
	<!-- Formulario Ingreso -->
	<form method="post" action="idiomas.php?Accion=Guardar" enctype="multipart/form-data">
		<input TYPE="hidden" id="txtId" name="txtId" value="0">
		<table width="100%">
			<tr>
				<td colspan="2" align="center" class="tituloFormulario"><b>NUEVO IDIOMA</b></td>
			</tr>
			<tr>
				<td class="tituloNombres">Idioma:</td>
				<td class="contenidoNombres"><INPUT id="txtCiudad" type="text" name="txtCiudad" maxLength="200" style="width:200px; "></td>
			</tr>
            <tr>
                <td class="tituloNombres">Código (Dos caracteres):</td>
                <td class="contenidoNombres"><INPUT id="codigo" type="text" name="codigo" maxLength="2" style="width:50px; "></td>
            </tr>
			<?php
			if ( Perfil() == "3" )
			{
			?><input type="hidden" name="optPublicar" id="optPublicar" value="N"><?php
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
			<?php
			}
			?>
			<tr>
				<td colspan="2" class="tituloFormulario">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="nuevo">
					<input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
					<a href="idiomas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
				</td>
			</tr>
		</table>
	</form>
	<?php
	}
###############################################################################
	# Descripción   : Adiciona un nuevo registro o actualiza uno existente a la DB
	# Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
	# Desarrollado  : Estilo y Diseño & Informaticactiva
	# Retorno       : Ninguno
	###############################################################################
	function CiudadesGuardar( $nId,$cCiudad,$codigo,$cPublicar )
	{
		$nConexion = Conectar();
		if ( $nId == "0" ) // Nuevo Registro
		{
			mysqli_query($nConexion,"INSERT INTO tblciudades ( ciudad,codigo,publicar ) VALUES ( '$cCiudad','$codigo','$cPublicar' )");
			mysqli_close($nConexion);
			Mensaje( "El registro ha sido almacenado correctamente.", "idiomas_listar.php" ) ;
			exit;
		}
		else // Actualizar Registro Existente
		{
			mysqli_query($nConexion, "UPDATE tblciudades SET ciudad = '$cCiudad', codigo = '$codigo', publicar = '$cPublicar' WHERE idciudad = '$nId'" );
		}
		mysqli_close( $nConexion );
		Mensaje( "El registro ha sido actualizado correctamente.", "idiomas_listar.php" ) ;
		exit;
	} // FIN: function 
	###############################################################################
	###############################################################################
	# Descripción   : Eliminar un registro 
	# Parametros    : $nId
	# Desarrollado  : Estilo y Diseño & Informaticactiva
	# Retorno       : Ninguno
	###############################################################################
	function CiudadesEliminar( $nId )
	{
		$nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT ciudad FROM tblciudades WHERE idciudad ='$nId'") );
		mysqli_query($nConexion, "DELETE FROM tblciudades WHERE idciudad ='$nId'" );
		Log_System( "IDIOMA" , "ELIMINA" , "IDIOMA: " . $reg->ciudad  );
		mysqli_close( $nConexion );
		Mensaje( "El registro ha sido eliminado correctamente.","idiomas_listar.php" );
		exit();
	} // FIN: function 
	###############################################################################
	###############################################################################
	# Nombre        : ContenidosFormEditar
	# Descripción   : Muestra el formulario para editar o eliminar registros
	# Parametros    : $nId = ID de registro que se debe mostrar el en formulario
	# Desarrollado  : Estilo y Diseño & Informaticactiva
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
		<!-- Formulario Edición / Eliminación de Contenidos -->
		<form method="post" action="idiomas.php?Accion=Guardar" enctype="multipart/form-data">
			<input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId ; ?>">
			<table width="100%">
				<tr>
					<td colspan="2" align="center" class="tituloFormulario"><b>EDITAR IDIOMA</b></td>
				</tr>
				<tr>
					<td class="tituloNombres">Idioma:</td>
					<td class="contenidoNombres"><INPUT id="txtCiudad" type="text" name="txtCiudad" value="<?php echo $Registro["ciudad"]; ?>" maxLength="200" style="width:200px; "></td>
				</tr>
				<tr>
					<td class="tituloNombres">Código (Dos caracteres):</td>
					<td class="contenidoNombres"><INPUT id="codigo" type="text" name="codigo" value="<?php echo $Registro["codigo"]; ?>" maxLength="2" style="width:50px; "></td>
				</tr>
			<?php
			if ( Perfil() == "3" )
			{
			?><input type="hidden" name="optPublicar" id="optPublicar" value="<?php echo $Registro["publicar"] ?>"><?
			}
			else
			{
			?>
			<tr>
				<td class="tituloNombres">Publicar:</td>
				<td class="contenidoNombres">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="S" <?php if ( $Registro["publicar"] == "S" ) echo "checked" ?>>Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="N" <?php if ( $Registro["publicar"] == "N" ) echo "checked" ?>>No</label></td>
						</tr>
					</table>
			  </td>
			</tr>
			<?php
			}
			?>
				<tr>
					<td colspan="2" class="tituloFormulario">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" class="nuevo">
						<input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
						<?php
						if ( Perfil() != "3" )
						{
						?><a href="idiomas.php?Accion=Eliminar&Id=<?php echo $nId; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('¿Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
						<a href="idiomas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
					</td>
				</tr>
			</table>
		</form>
		<?
		mysqli_free_result( $Resultado );
	}
	###############################################################################
	?>