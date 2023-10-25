<?
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo contenidos
  # Desarrollo               :  Estilo y Diseño & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
	include("../../funciones_generales.php");
?>

<?
  ###############################################################################
  # Nombre        : NoticiasFormNuevo
  # Descripción   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ContenidosFormNuevo()
	{
	?>
	<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
	<!-- Formulario Ingreso de Contenidos -->
	<form method="post" action="contenidos.php?Accion=Guardar" enctype="multipart/form-data">
		<input TYPE="hidden" id="txtId" name="txtId" value="*">
		<table width="100%">
			<tr>
				<td colspan="2" align="center" class="tituloFormulario"><b>NUEVO CONTENIDO GENERAL</b></td>
			</tr>
			<tr>
				<td class="tituloNombres">Titulo:</td>
				<td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" maxLength="100"></td>
			</tr>
			<tr>
				<td colspan="2" class="tituloNombres">Contenido:</td>
			</tr>
		</table>
                    <textarea name="txtContenido"></textarea>
                    <script>
                        CKEDITOR.replace( 'txtContenido' );
                    </script>
		<table width="100%">
			<tr>
				<td class="tituloNombres">Imagen:</td>
				<td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen"></td>
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
				<td class="tituloNombres">Ver en Home:</td>
				<td class="contenidoNombres">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><label><input type="radio" id="optHome" name="optHome" value="S">Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optHome" name="optHome" value="N" checked>No</label></td>
						</tr>
					</table>
			  </td>
			</tr>
			<tr>
				<td colspan="2" class="tituloFormulario">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="nuevo">
					<input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
					<a href="contenidos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
	# Nombre        : ContenidosGuardar
	# Descripción   : Adiciona un nuevo registro o actualiza uno existente
	# Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
	#                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
	# Desarrollado  : Estilo y Diseño & Informaticactiva
	# Retorno       : Ninguno
	###############################################################################
	function ContenidosGuardar( $nId,$cTitulo,$cContenido,$cImagen,$cPublicar,$VerHome,$VerNosotros )
	{
		$IdCiudad = $_SESSION["IdCiudad"];
		$nConexion = Conectar();
		mysqli_set_charset($nConexion,'utf8');
		setlocale(LC_ALL, 'en_US.UTF8');
		$url = slug($cTitulo);
		if ( $nId == "*" ) // Nuevo Registro
		{
			//Verifico que la clave de contenido no exista
			$Resultado = mysqli_query($nConexion, "SELECT * FROM tblcontenidos WHERE clave = '$url' AND idciudad = $IdCiudad" );
			if ( mysqli_num_rows($Resultado) )
			{
				mysqli_free_result($Resultado);
				mysqli_close($nConexion);
				Error( "La clave de contenido ya existe intente con otra clave de contenido diferente." );
			}
			else
			{
				mysqli_free_result($Resultado);
				mysqli_query($nConexion,"INSERT INTO tblcontenidos ( clave,titulo,contenido,imagen,publicar,verhome,vernosotros,idciudad ) VALUES ( '$url','$cTitulo','$cContenido','$cImagen','$cPublicar','$VerHome','$VerNosotros',$IdCiudad )");
				Log_System( "CONTENIDOS" , "NUEVO" , "TITULO: " . $cTitulo );
				mysqli_close($nConexion);
				Mensaje( "El registro ha sido almacenado correctamente.", "contenidos_listar.php" ) ;
				exit;
			}
		}
		else // Actualizar Registro Existente
		{
				mysqli_query($nConexion, "UPDATE tblcontenidos SET clave = '$url', titulo = '$cTitulo',contenido = '$cContenido', publicar = '$cPublicar', verhome = '$VerHome', vernosotros = '$VerNosotros' WHERE clave='$nId' AND idciudad = $IdCiudad" );
				
				mysqli_query($nConexion, "UPDATE tblmenu SET clave = '$url', link = '$url' WHERE clave = '$nId' AND idciudad = $IdCiudad" );
				Log_System( "CONTENIDOS" , "EDITA" , "TITULO: " . $cTitulo );

			if ( !empty($cImagen) )
			{
				mysqli_query($nConexion, "UPDATE tblcontenidos set imagen = '$cImagen' WHERE clave = '$nId' AND idciudad = $IdCiudad" );
			}
			mysqli_close( $nConexion );
			Mensaje( "El registro ha sido actualizado correctamente.", "contenidos_listar.php" ) ;
			exit;
		}
	} // FIN: function 
	###############################################################################
?>

<?
	###############################################################################
	# Nombre        : ContenidosEliminar
	# Descripción   : Eliminar un registro 
	# Parametros    : $nId
	# Desarrollado  : Estilo y Diseño & Informaticactiva
	# Retorno       : Ninguno
	###############################################################################
	function ContenidosEliminar( $nId )
	{
		$nConexion = Conectar();
		mysqli_set_charset($nConexion,'utf8');
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT titulo FROM tblcontenidos WHERE clave ='$nId'") );
		mysqli_query($nConexion, "DELETE FROM tblcontenidos WHERE clave ='$nId'" );
		Log_System( "CONTENIDOS" , "ELIMINA" , "TITULO: " . $reg->titulo  );
		mysqli_close( $nConexion );
		Mensaje( "El registro ha sido eliminado correctamente.","contenidos_listar.php" );
		exit();
	} // FIN: function 
	###############################################################################
?>

<?
	###############################################################################
	# Nombre        : ContenidosFormEditar
	# Descripción   : Muestra el formulario para editar o eliminar registros
	# Parametros    : $nId = ID de registro que se debe mostrar el en formulario
	# Desarrollado  : Estilo y Diseño & Informaticactiva
	# Retorno       : Ninguno
	###############################################################################
	function ContenidosFormEditar( $nId )
	{
		include("../../vargenerales.php");
		$IdCiudad = $_SESSION["IdCiudad"];
		$nConexion    = Conectar();
		mysqli_set_charset($nConexion,'utf8');
		$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblcontenidos WHERE clave = '$nId' AND idciudad = $IdCiudad" ) ;
		mysqli_close( $nConexion ) ;
		$Registro     = mysqli_fetch_array( $Resultado );
		?>
		<!-- Formulario Edición / Eliminación de Contenidos -->
		<form method="post" action="contenidos.php?Accion=Guardar" enctype="multipart/form-data">
			<input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
			<table width="100%">
				<tr>
					<td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CONTENIDO GENERAL</b></td>
				</tr>
				<tr>
					<td class="tituloNombres">Titulo:</td>
					<td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" value="<? echo $Registro["titulo"]; ?>" maxLength="100">		<?php echo "http://{$_SERVER["HTTP_HOST"]}/{$Registro["clave"]}";?></td>
				</tr>
				<tr>
					<td colspan="2" class="tituloNombres">Contenido:</td>
				</tr>
			</table>
                    <textarea name="txtContenido"><? echo $Registro["contenido"];?></textarea>
                    <script>
                        CKEDITOR.replace( 'txtContenido' );
                    </script>

			<table width="100%">
				<tr>
					<td class="tituloNombres">Imagen:</td>
					<td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen"></td>
				</tr>
				<tr>
					<td class="tituloNombres">Imagen Actual:</td>
					<td class="contenidoNombres">
					<?
						if ( empty( $Registro["imagen"] ) )
						{
							echo "No se asigno una imagen.";
						}
						else
						{
							?><img src="<? echo $cRutaVerImgContenidos . "m_".$Registro['imagen']; ?>"><?
						}
					?>
					</td>
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
				<td class="tituloNombres">Ver en Home:</td>
				<td class="contenidoNombres">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><label><input type="radio" id="optHome" name="optHome" value="S" <? if ( $Registro["verhome"] == "S" ) echo "checked" ?>>Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optHome" name="optHome" value="N" <? if ( $Registro["verhome"] == "N" ) echo "checked" ?>>No</label></td>
						</tr>
					</table>
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
						?><a href="contenidos.php?Accion=Eliminar&Id=<? echo $nId; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('¿Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
						<a href="contenidos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
					</td>
				</tr>
			</table>
		</form>
		<?
		mysqli_free_result( $Resultado );
	}
	###############################################################################
	?>