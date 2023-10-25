<?
	include("../../herramientas/FCKeditor/fckeditor.php") ;
  include("../../herramientas/seguridad/seguridad.php");
  include("paquetes_funciones.php");
  if (!isset ($_GET["Id"])) // Si no se envio la accion muestro la lista
  {
    header("Location: paquetes_listar.php");
  }
	//Adicionar
	if ( ( isset( $_GET["cmdAdd"] ) ) and ( isset( $_GET["cboPS"] ) ) ){
		$Tipo		=	substr($_GET["cboPS"] , 0 , 1) ;
		$Codigo	= substr($_GET["cboPS"] , 1 , strlen($_GET["cboPS"]) ) ;
		// Busco IdProducto o IdServicio - Determinados por Tipo
		// La busqueda se hace sobre la tabla paquetes_ps para determinar su el elemento ya existe.
		if ( Verificar_Seleccion( $_GET["Id"] , $Codigo , $Tipo ) == true ){
			?><script>alert("El elemento ya esta seleccionado.");</script><?
		}
	}
	//Eliminar
	if ( ( isset( $_GET["cmdDel"] ) ) and ( isset( $_GET["cboPS_Sel"] ) ) ){
		Eliminar_PS( $_GET["cboPS_Sel"] ) ;
	}



?>
<html>
	<head>
		<title>Administraci�n de Paquetes</title>
		<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<style type="text/css">
		<!--
		body {
			margin-top: 0px;
			margin-bottom:0px;
			margin-left:0px;
			margin-right:0px;
		}
		-->
		</style>
	</head>
	<body>
<? include("../../system_menu.php"); ?><br>
<center>
<form name="frmps" id="frmps" method="get" action="paquetes_ps.php">
<input type="hidden" name="Id" name="Id" value="<?=$_GET["Id"];?>">
<input type="hidden" name="nompaquete" id="nompaquete" value="<?=$_GET["nompaquete"];?>">
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><strong>NOMBRE DEL PAQUETE: <?=$_GET["nompaquete"];?></strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><strong>Productos/Servicios Disponibles:</strong></td>
		<td>&nbsp;&nbsp;</td>
		<td><strong>Productos/Servicios Seleccionados:</strong></td>
	</tr>
	<tr>
		<td>
			<select name="cboPS" id="cboPS" size="10" style="width:350px;">
				<?
				$rs_P = Cargar_Productos();
				$rs_S = Cargar_Servicios();
				while ($reg_P = mysqli_fetch_object($rs_P)) {
					echo "<option value=\"P$reg_P->idproducto\" title=\"$reg_P->producto\">P.$reg_P->producto</option>\n";
				}
				while ($reg_S = mysqli_fetch_object($rs_S)) {
					echo "<option value=\"S$reg_S->idservicio\" title=\"$reg_S->servicio\">S.$reg_S->servicio</option>\n";
				}
				?>
			</select>
		</td>
		<td>&nbsp;&nbsp;</td>
		<td>
			<select name="cboPS_Sel" id="cboPS_Sel" size="10" style="width:350px;">
				<?
				$rs_PS = Cargar_PS( $_GET["Id"] );
				while ( $reg_PS = mysqli_fetch_object($rs_PS) ) {
					$cCaption = Nom_PS($reg_PS->id_ps , $reg_PS->tipo);
					echo "<option value=\"$reg_PS->id\" title=\"$cCaption\">$reg_PS->tipo.$cCaption</option>\n";
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td><center><input type="submit" name="cmdAdd" id="cmdAdd" value="Adicionar" onclick="" /></center></td>
		<td>&nbsp;&nbsp;</td>
		<td><center><input type="submit" name="cmdDel" id="cmdDel" value="Eliminar" /></center></td>
	</tr>
</table>
<br>
<center>
<a href="paquetes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
</center>
</form>
</center>
</body>
</html>

