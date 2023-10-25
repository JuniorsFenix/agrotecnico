<?
	//include("../../herramientas/FCKeditor/fckeditor.php") ;
  include("../../herramientas/seguridad/seguridad.php");
  include("paquetes_funciones.php");

	if ( isset( $_POST["idpedido"] ) ){
		$Conetar = Conectar();
		$estado  = $_POST["cboEstado"];
		$Obser	 = $_POST["txtObservaciones"];
		$idpedido= $_POST["idpedido"];
		mysqli_query($nConexion,"UPDATE tblpaquetes_ped SET estado = '$estado' , observaciones = '$Obser' WHERE idpedido = $idpedido",$Conetar);
		mysqli_close($Conetar);
		echo "<script>document.location.href='paquetes_pedidos.php'</script>";
	}


  if (!isset ($_GET["Id"])) // Si no se envio la accion muestro la lista
  {
    header("Location: paquetes_listar.php");
  }


	
	$IdPedido = $_GET["Id"] ;
	$Conetar = Conectar();
	$rs_Pedido = 	mysqli_query($nConexion,"SELECT * FROM tblpaquetes_ped WHERE idpedido = $IdPedido",$Conetar);
	mysqli_close($Conetar);
	$reg_Pedido = mysqli_fetch_object( $rs_Pedido );
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
<form name="frmps" id="frmps" method="post" action="paquetes_pedidos_ver.php">
<input type="hidden" name="idpedido" value="<?=$IdPedido;?>">
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><strong>PEDIDO</strong></td>
	</tr>
	<tr>
		<td><?=$reg_Pedido->pedido;?></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
			Estado:
			<select name="cboEstado" id="cboEstado">
				<option value="NUEVO" <? if( $reg_Pedido->estado == "NUEVO" ) { echo "selected"; } ?>>NUEVO</option>
				<option value="EN PROCESO" <? if( $reg_Pedido->estado == "EN PROCESO" ) { echo "selected"; } ?>>EN PROCESO</option>
				<option value="FINALIZADO" <? if( $reg_Pedido->estado == "FINALIZADO" ) { echo "selected"; } ?>>FINALIZADO</option>
			</select>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>Observaciones:</td>
	</tr>
	<tr>
		<td>
			<textarea name="txtObservaciones" rows="10" cols="50"><?=$reg_Pedido->observaciones;?></textarea>
		</td>
	</tr>
</table><br>
<input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
</form>
</center>
</body>
</html>

