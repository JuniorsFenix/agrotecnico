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
function ProductosFormNuevo()
{
$IdCiudad = $_SESSION["IdCiudad"];
?>
<!-- Formulario Ingreso de Productos -->
	<form method="post" action="productos.php?Accion=Guardar" enctype="multipart/form-data">
		<input TYPE="hidden" id="txtId" name="txtId" value="0">
		<table width="100%">
			<tr>
				<td colspan="2" align="center" class="tituloFormulario"><b>NUEVO GLOSARIO</b></td>
			</tr>
			<tr>
				<td class="tituloNombres">Alfabeto:</td>
				<td class="contenidoNombres">
					<select name="cboCategorias" id="cboCategorias">
					<?
					$nConexion = Conectar();
					$ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblcategoriasproductos WHERE (idciudad = $IdCiudad) ORDER BY idcategoria" );
					$RSOpciones		= mysqli_query($nConexion, "SELECT * FROM tblproductosplus WHERE (idciudad = $IdCiudad) AND (publicar = 'S')"  );
					mysqli_close($nConexion);
					$nContador = 0;
					while($Registros=mysqli_fetch_object($ResultadoCat))
					{
						$nContador = $nContador + 1;
						if ( $nContador == 1 )
						{
							?>
								<option selected value="<? echo $Registros->idcategoria; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria ; ?></option>
							<?
						}
						else
						{
							?>
								<option value="<? echo $Registros->idcategoria; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria ; ?></option>
							<?
						}
					}
					mysqli_free_result($ResultadoCat);
					?></select>
				</td>
			</tr>
			<tr>
				<td class="tituloNombres">Glosario:</td>
				<td class="contenidoNombres"><INPUT id="txtProducto" type="text" name="txtProducto" maxLength="200" style="WIDTH: 300px; HEIGHT: 22px"></td>
			</tr>
			<tr>
				<td class="tituloNombres" colspan="2">Descripci�n:</td>
				<!--<td class="contenidoNombres"><textarea rows="20" id="txtDetalle" name="txtDetalle" cols="80"></textarea></td>-->
			</tr>
		</table>
				<?
					/*$oFCKeditor = new FCKeditor('txtDetalle') ;
					$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
					$oFCKeditor->Create() ;
					$oFCKeditor->Width  = '100%' ;
					$oFCKeditor->Height = '400' ;*/
				?>
                    <textarea name="txtDetalle"></textarea>
                    <script>
                        CKEDITOR.replace( 'txtDetalle' );
                    </script>
		<table width="100%">
			<tr>
				<td class="tituloNombres">Precio:</td>
				<td class="contenidoNombres"><INPUT id="txtPrecio" type="text" name="txtPrecio" maxLength="50"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Imagen:</td>
				<td class="contenidoNombres"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Encabezado Flash:</td>
				<td class="contenidoNombres"><input type="file" id="txtEncFlash[]" name="txtEncFlash[]"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Foto Peque�a:</td>
				<td class="contenidoNombres"><input type="file" id="txtAdjunto[]" name="txtAdjunto[]"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Activar en Carrito:</td>
				<td class="contenidoNombres">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td><label><input type="radio" id="optCarrito" name="optCarrito" value="S">Si</label></td>
						<td width="10"></td>
						<td><label><input type="radio" id="optCarrito" name="optCarrito" value="N" checked>No</label></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td class="tituloNombres">Opciones:</td>
				<td class="contenidoNombres">
				<select name="cboOpciones" id="cboOpciones">
					<option value="0" selected>Ninguno</option>
				<?
				while ( $regOpciones = mysqli_fetch_object( $RSOpciones ) ){
					echo "<option value=\"$regOpciones->id\">$regOpciones->descripcion</option>";
				}
				?>
				</select>
				</td>
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
					<a href="productos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
function ProductosGuardar( $nId,$nIdCategoria,$cProducto,$cDetalle,$nPrecio,$cImagen,$cEncFlash,$cAdjunto,$cPublicar,$cActCarrito,$cOpciones )
{
	$IdCiudad = $_SESSION["IdCiudad"];
	$nConexion = Conectar();
	if ( $nId <= 0 ) // Nuevo Registro
	{
		mysqli_query($nConexion,"INSERT INTO tblproductos ( idcategoria,producto,detalle,precio,imagen,encflash,adjunto,publicar,activar_carrito,idciudad,idopcion ) VALUES ( '$nIdCategoria','$cProducto','$cDetalle','$nPrecio','$cImagen','$cEncFlash','$cAdjunto','$cPublicar','$cActCarrito',$IdCiudad,$cOpciones )");
		Log_System( "PRODUCTOS" , "NUEVO" , "PRODUCTO: " . $cProducto );
		mysqli_close($nConexion);
		Mensaje( "El registro ha sido almacenado correctamente.", "productos_listar.php" ) ;
		exit;
	}
	else // Actualizar Registro Existente
	{
		$cTxtSQLUpdate		= "UPDATE tblproductos SET idcategoria = '$nIdCategoria',producto = '$cProducto',detalle = '$cDetalle',precio = '$nPrecio', publicar = '$cPublicar' , activar_carrito = '$cActCarrito', idopcion = $cOpciones, idciudad = $IdCiudad";

		if ( $cImagen!= "" )
			{
				$cTxtSQLUpdate = $cTxtSQLUpdate . " , imagen = '$cImagen'"  ;
			}
		
		if ( $cEncFlash != "" )
		{
			$cTxtSQLUpdate	= $cTxtSQLUpdate . " , encflash = '$cEncFlash'" ;
		}
		
		if ( $cAdjunto != "" )
			{
				$cTxtSQLUpdate	= $cTxtSQLUpdate . " , adjunto = '$cAdjunto'" ;
			}
		
			
		$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idproducto = '$nId'";
		mysqli_query($nConexion,$cTxtSQLUpdate  );
		Log_System( "PRODUCTOS" , "EDITA" , "PRODUCTO: " . $cProducto );
		mysqli_close( $nConexion );
		Mensaje( "El registro ha sido actualizado correctamente.", "productos_listar.php" ) ;
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
function ProductosEliminar( $nId )
{
	$nConexion = Conectar();
	$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT producto FROM tblproductos WHERE idproducto ='$nId'") );
	mysqli_query($nConexion, "DELETE FROM tblproductos WHERE idproducto ='$nId'" );
	Log_System( "PRODUCTOS" , "ELIMINA" , "PRODUCTO: " . $reg->producto );
	mysqli_close( $nConexion );
	Mensaje( "El registro ha sido eliminado correctamente.","productos_listar.php" );
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
function ProductosFormEditar( $nId )
{
	$IdCiudad = $_SESSION["IdCiudad"];
	include("../../vargenerales.php");
	$nConexion    = Conectar();
	$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblproductos WHERE idproducto = '$nId'" ) ;
	mysqli_close( $nConexion ) ;
	$Registro     = mysqli_fetch_array( $Resultado );
?>
	<!-- Formulario Edici�n / Eliminaci�n de Productos -->
	<form method="post" action="productos.php?Accion=Guardar" enctype="multipart/form-data">
		<input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
		<table width="100%">
			<tr>
				<td colspan="2" align="center" class="tituloFormulario"><b>EDITAR PRODUCTO</b></td>
			</tr>
			<tr>
				<td class="tituloNombres">Alfabeto:</td>
				<td class="contenidoNombres">
					<select name="cboCategorias" id="cboCategorias">
					<?
					$nConexion = Conectar();
					$ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblcategoriasproductos WHERE idciudad = $IdCiudad ORDER BY idcategoria" );
					$RSOpciones		= mysqli_query($nConexion, "SELECT * FROM tblproductosplus WHERE (idciudad = $IdCiudad) AND (publicar = 'S')"  );
					mysqli_close($nConexion);
					while($Registros=mysqli_fetch_object($ResultadoCat))
					{
						if ( $Registro["idcategoria"] == $Registros->idcategoria )
						{
							?>
								<option selected value="<? echo $Registros->idcategoria; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria ; ?></option>
							<?
						}
						else
						{
							?>
								<option value="<? echo $Registros->idcategoria; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria ; ?></option>
							<?
						}
					}
					mysqli_free_result($ResultadoCat);
					?></select>
				</td>
			</tr>
			<tr>

				<td class="tituloNombres">Glosario:</td>

				<td class="contenidoNombres"><INPUT id="txtProducto" type="text" name="txtProducto" value="<? echo $Registro["producto"]; ?>" maxLength="200" style="WIDTH: 300px; HEIGHT: 22px"></td>

			</tr>

			<tr>

				<td class="tituloNombres" colspan="2">Descripci�n:</td>

				<!--<td class="contenidoNombres"><textarea rows="20" id="txtDetalle" name="txtDetalle" cols="80"><? //echo $Registro["detalle"]; ?></textarea></td>-->

			</tr>
		</table>
				<?
					/*$oFCKeditor = new FCKeditor('txtDetalle') ;
					$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
					$oFCKeditor->Value = $Registro["detalle"];
					$oFCKeditor->Create() ;
					$oFCKeditor->Width  = '100%' ;
					$oFCKeditor->Height = '400' ;*/
				?>
                    <textarea name="txtDetalle"><? echo $Registro["detalle"]?></textarea>
                    <script>
                        CKEDITOR.replace( 'txtDetalle' );
                    </script>
		<table width="100%">
			<tr>
				<td class="tituloNombres">Precio:</td>
				<td class="contenidoNombres"><INPUT id="txtPrecio" type="text" value="<? echo $Registro["precio"]; ?>" name="txtPrecio" maxLength="50"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Imagen:</td>
				<td class="contenidoNombres"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Imagen Actual:</td>
				<td class="contenidoNombres">
				<?
					if ( empty($Registro["imagen"]) )
					{
						echo "No se asigno una imagen.";
					}
					else
					{
						?><img src="<? echo $cRutaVerImgProductos . $Registro["imagen"]; ?>"><?
					}
				?>
				</td>
			</tr>
			<tr>
				<td class="tituloNombres">Encabezado Flash:</td>
				<td class="contenidoNombres"><input type="file" id="txtEncFlash[]" name="txtEncFlash[]"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Encabezado Actual:</td>
				<td>
				<?
					if ( empty($Registro["encflash"]) )
					{
						echo "No se asigno un encabezado.";
					}
					else
					{
							$Tam_Archivo = getimagesize($cRutaVerImgProductos . $Registro["encflash"]);
							?>
							<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" <? echo $Tam_Archivo[3]; ?>>
								<param name="movie" value="<? echo $cRutaVerImgProductos . $Registro["encflash"]; ?>">
								<param name="quality" value="high">
								<embed src="<? echo $cRutaVerImgProductos . $Registro["encflash"]; ?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" <? echo $Tam_Archivo[3]; ?>></embed>
							</object>
							<?
					}
				?>
				</td>
			</tr>
			<tr>
				<td class="tituloNombres">Foto Peque�a:</td>
				<td class="contenidoNombres"><input type="file" id="txtAdjunto[]" name="txtAdjunto[]"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Foto Peque�a:</td>
				<td>
				<?
					if ( empty($Registro["adjunto"]) )
					{
						echo "No se asigno un archivo adjunto.";
					}
					else
					{
				?>
					<a href="<? echo $cRutaImgProductosPequenia . $Registro["adjunto"]; ?>">
					<? echo $cRutaVerImgProductosPequenia . $Registro["adjunto"]; ?>
					</a>
				<?
				}
				?>
				</td>
			</tr>
			<tr>
				<td class="tituloNombres">Activar en Carrito:</td>
				<td class="contenidoNombres">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td><label><input type="radio" id="optCarrito" name="optCarrito" value="S" <? if ( $Registro["activar_carrito"] == "S" ) echo "checked" ?>>Si</label></td>
						<td width="10"></td>
						<td><label><input type="radio" id="optCarrito" name="optCarrito" value="N" <? if ( $Registro["activar_carrito"] == "N" ) echo "checked" ?>>No</label></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td class="tituloNombres">Opciones:</td>
				<td class="contenidoNombres">
				<select name="cboOpciones" id="cboOpciones">
					<option value="0" selected>Ninguno</option>
				<?
				while ( $regOpciones = mysqli_fetch_object( $RSOpciones ) ){
					if ( $regOpciones->id == $Registro["idopcion"] ){
						echo "<option selected value=\"$regOpciones->id\">$regOpciones->descripcion</option>";
					}else{
						echo "<option value=\"$regOpciones->id\">$regOpciones->descripcion</option>";
					}
				}
				?>
				</select>
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
				<td colspan="2" class="tituloFormulario">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="nuevo">
					<input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
					<?
					if ( Perfil() != "3" )
					{
					?>
					<a href="productos.php?Accion=Eliminar&Id=<? echo $nId ;?>">
					<img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')">
					</a>
					<?
					}
					?>
					<a href="productos_listar.php">
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