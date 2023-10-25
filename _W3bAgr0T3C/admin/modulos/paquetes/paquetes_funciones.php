<? include("../../funciones_generales.php"); ?>
<?
###############################################################################
# Descripci�n   : Muestra el formulario para ingreso de registros nuevos
# Parametros    : Ninguno.
# Desarrollado  : Estilo y Dise�o - oscar_yepes@hotmail.com
# Retorno       : Ninguno
###############################################################################
function PaquetesFormNuevo()
{
?>
	<!-- Formulario Ingreso -->
	<form method="post" action="paquetes.php?Accion=Guardar" enctype="multipart/form-data">
		<input TYPE="hidden" id="txtId" name="txtId" value="0">
		<table width="100%">
			<tr>
				<td colspan="2" align="center" class="tituloFormulario"><b>NUEVO PAQUETE</b></td>
			</tr>
			<tr>
				<td class="tituloNombres">Titulo:</td>
				<td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
			</tr>
		</table>
		<?
			/*$oFCKeditor = new FCKeditor('txtDescripcion') ;
			$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
			$oFCKeditor->Create() ;
			$oFCKeditor->Width  = '100%' ;
			$oFCKeditor->Height = '400' ;*/
		?>
        <textarea name="txtDescripcion"></textarea>
        <script>
            CKEDITOR.replace( 'txtDescripcion' );
        </script>
		<table width="100%">
			<tr>
				<td class="tituloNombres">Precio:</td>
				<td class="contenidoNombres"><INPUT id="txtPrecio" type="text" name="txtPrecio" maxLength="15" style="WIDTH: 150px; HEIGHT: 22px"></td>
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
				<td colspan="2"  class="nuevo">
					<input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
					<a href="paquetes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
# Desarrollado  : Estilo y Dise�o - oscar_yepes@hotmail.com
# Retorno       : Ninguno
###############################################################################
function PaquetesGuardar( $nId,$cTitulo,$cDescripcion,$cPrecio,$cPublicar )
{
	$IdCiudad = $_SESSION["IdCiudad"];
	$nConexion = Conectar();
	if ( $nId <= 0 ) { // Nuevo Registro
		mysqli_query($nConexion,"INSERT INTO tblpaquetes ( titulo,descripcion,precio,publicar,idciudad ) VALUES ( '$cTitulo','$cDescripcion','$cPrecio','$cPublicar',$IdCiudad )");
		Log_System( "PAQUETES" , "NUEVO" , "TITULO: " . $cTitulo  );
		mysqli_close($nConexion);
		Mensaje( "El registro ha sido almacenado correctamente.", "paquetes_listar.php" ) ;
		exit;
	}
	else{ // Actualizar Registro Existente
		mysqli_query($nConexion, "UPDATE tblpaquetes SET titulo = '$cTitulo',descripcion = '$cDescripcion',precio = '$cPrecio',publicar='$cPublicar' WHERE idpaquete = '$nId'" );
		Log_System( "PAQUETES" , "EDITA" , "TITULO: " . $cTitulo  );
		mysqli_close( $nConexion );
		Mensaje( "El registro ha sido actualizado correctamente.", "paquetes_listar.php" ) ;
		exit;
	}
}
 // FIN: function 
###############################################################################
?>
<?
###############################################################################
# Descripci�n   : Eliminar un registro 
# Parametros    : $nId
# Desarrollado  : Estilo y Dise�o - oscar_yepes@hotmail.com
# Retorno       : Ninguno
###############################################################################
function PaquetesEliminar( $nId )
{
	$nConexion = Conectar();
	$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT titulo FROM tblpaquetes WHERE idpaquete ='$nId'") );
	mysqli_query($nConexion, "DELETE FROM tblpaquetes WHERE idpaquete ='$nId'" );
	mysqli_query($nConexion, "DELETE FROM tblpaquetes_ps WHERE idpaquete ='$nId'" );
	Log_System( "PAQUETES" , "ELIMINA" , "TITULO: " . $reg->titulo  );
	mysqli_close( $nConexion );
	Mensaje( "El registro ha sido eliminado correctamente.","paquetes_listar.php" );
	exit();
} // FIN: function 
###############################################################################
?>
<?
###############################################################################
# Descripci�n   : Muestra el formulario para editar o eliminar registros
# Parametros    : $nId = ID de registro que se debe mostrar el en formulario
# Desarrollado  : Estilo y Dise�o & oscar_yepes@hotmail.com
# Retorno       : Ninguno
###############################################################################
function PaquetesFormEditar( $nId )
{
	include("../../vargenerales.php");
	$nConexion    = Conectar();
	$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblpaquetes WHERE idpaquete = '$nId'" ) ;
	mysqli_close( $nConexion ) ;

	$Registro     = mysqli_fetch_array( $Resultado );
?>
	<!-- Formulario Edici�n / Eliminaci�n de Editorial -->
	<form method="post" action="paquetes.php?Accion=Guardar" enctype="multipart/form-data">
		<input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
		<table width="100%">
			<tr>
				<td colspan="2" align="center" class="tituloFormulario"><b>EDITAR PAQUETE</b></td>
			</tr>
			<tr>
				<td class="tituloNombres">Titulo:</td>
				<td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" value="<? echo $Registro["titulo"]; ?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
			</tr>
		</table>
		<?
			/*$oFCKeditor = new FCKeditor('txtDescripcion') ;
			$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
			$oFCKeditor->Value = $Registro["descripcion"];
			$oFCKeditor->Create() ;
			$oFCKeditor->Width  = '100%' ;
			$oFCKeditor->Height = '400' ;*/
		?>
            <textarea name="txtDescripcion"><? echo $Registro["descripcion"]?></textarea>
            <script>
                CKEDITOR.replace( 'txtDescripcion' );
            </script>
		<table width="100%">
			<tr>
				<td class="tituloNombres">Precio:</td>
				<td class="contenidoNombres"><INPUT id="txtPrecio" type="text" name="txtPrecio" value="<? echo $Registro["precio"]; ?>" maxLength="15" style="WIDTH: 150px; HEIGHT: 22px"></td>
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
					?><a href="paquetes.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
					}
					?>
					<a href="paquetes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
				</td>
			</tr>
		</table>
	</form>
<?
mysqli_free_result( $Resultado );
}
###############################################################################

function Cargar_Productos(){
	$nConexion = Conectar();
	$IdCiudad = $_SESSION["IdCiudad"];
	$rs_Pro		= mysqli_query($nConexion,"SELECT * FROM tblproductos WHERE idciudad = $IdCiudad AND publicar = 'S' ORDER BY producto" );
	mysqli_close($nConexion);
	return $rs_Pro;
}

function Cargar_Servicios(){
	$nConexion = Conectar();
	$IdCiudad = $_SESSION["IdCiudad"];
	$rs_Ser		= mysqli_query($nConexion,"SELECT * FROM tblservicios WHERE idciudad = $IdCiudad AND publicar = 'S' ORDER BY servicio" );
	mysqli_close($nConexion);
	return $rs_Ser;
}
function Cargar_PS( $idpaquete ){
	$nConexion = Conectar();
	$IdCiudad = $_SESSION["IdCiudad"];
	//$rs_PS		= mysqli_query($nConexion,"SELECT * FROM tblpaquetes_ps WHERE idpaquete = $idpaquete" );
	//$rs_PS		= mysqli_query($nConexion,"SELECT tblpaquetes_ps_1.id, tblpaquetes_ps_1.idpaquete, tblpaquetes_ps_1.id_ps, tblpaquetes_ps_1.tipo, tblproductos.producto, tblservicios.servicio FROM ((tblpaquetes_ps AS tblpaquetes_ps_1 INNER JOIN tblpaquetes_ps AS tblpaquetes_ps_2 ON tblpaquetes_ps_1.id = tblpaquetes_ps_2.id) INNER JOIN tblproductos ON tblpaquetes_ps_1.id_ps = tblproductos.idproducto) INNER JOIN tblservicios ON tblpaquetes_ps_2.id_ps = tblservicios.idservicio WHERE tblpaquetes_ps_1.idpaquete = $idpaquete AND tblpaquetes_ps_2.idpaquete = $idpaquete" );
	//$rs_PS		= mysqli_query($nConexion,"SELECT tblpaquetes_ps_1.id, tblpaquetes_ps_1.idpaquete, tblpaquetes_ps_1.id_ps, tblproductos.producto, tblservicios.servicio FROM tblpaquetes_ps AS tblpaquetes_ps_1 INNER JOIN tblproductos ON tblpaquetes_ps_1.id_ps = tblproductos.idproducto, tblpaquetes_ps AS tblpaquetes_ps_2 INNER JOIN tblservicios ON tblpaquetes_ps_2.id_ps = tblservicios.idservicio WHERE tblpaquetes_ps_1.idpaquete = $idpaquete AND tblpaquetes_ps_2.idpaquete = $idpaquete GROUP BY tblpaquetes_ps_1.id, tblpaquetes_ps_1.idpaquete, tblpaquetes_ps_1.id_ps, tblproductos.producto, tblservicios.servicio" );
	$rs_PS		= mysqli_query($nConexion,"SELECT * FROM tblpaquetes_ps WHERE idpaquete = $idpaquete" );
	return $rs_PS;
	mysqli_close( $nConexion );
}

function Verificar_Seleccion( $IdPaquete , $IDPS , $Tipo ){
	$nConexion = Conectar();
	$rs_Resultados = mysqli_query($nConexion,"SELECT * FROM tblpaquetes_ps WHERE idpaquete = $IdPaquete AND id_ps = $IDPS AND tipo = '$Tipo'" );
	if ( mysqli_num_rows( $rs_Resultados ) > 0 ){
		$lRetorno = true;	
	}else{
		$lRetorno = false;
		mysqli_query($nConexion,"INSERT INTO tblpaquetes_ps ( idpaquete , id_ps , tipo ) VALUES ( $IdPaquete , $IDPS , '$Tipo' )");
	}
	mysqli_close( $nConexion );
	mysqli_free_result( $rs_Resultados );
	return $lRetorno;
}

function Nom_PS($ID_ps , $cTipo){
	if ( $cTipo == "P" ){
		$strSQL = "SELECT producto AS titulo FROM tblproductos WHERE idproducto = $ID_ps";
	}else{
		$strSQL = "SELECT servicio AS titulo FROM tblservicios WHERE idservicio = $ID_ps";
	}
	$nConexion = Conectar();
	$rs_Resultado = mysqli_query($nConexion,$strSQL);
	mysqli_close($nConexion);
	$reg_Resultado = mysqli_fetch_object($rs_Resultado);
	$cRetorno = $reg_Resultado->titulo;
	mysqli_free_result($rs_Resultado);
	return $cRetorno;
}

function Eliminar_PS( $IdPS ){
	$nConexion = Conectar();
	mysqli_query($nConexion,"DELETE FROM tblpaquetes_ps WHERE id = $IdPS");
	mysqli_close($nConexion);
}
?>