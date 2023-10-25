<? 
include("../../funciones_generales.php");
$nConexion = Conectar();

if ( !isset( $_POST["txtId"] ) )
{
	$IdPedido = $_GET["Id"];
	$rs_Pedido = mysqli_query($nConexion,"SELECT tbl_cart_pedidos.idpedido, tbl_cart_pedidos.idcliente, tbl_cart_pedidos.neto, tbl_cart_pedidos.estado, tbl_cart_pedidos.fecha, tbl_cart_clientes.nombres, tbl_cart_clientes.apellidos FROM tbl_cart_pedidos INNER JOIN tbl_cart_clientes ON tbl_cart_pedidos.idcliente = tbl_cart_clientes.idcliente WHERE idpedido = $IdPedido");
	$Reg_Pedido = mysqli_fetch_object($rs_Pedido);
	mysqli_close($nConexion);
}
else
{
	$nIdPedido = $_POST["txtId"];
	$cEstado = $_POST["cboEstado"];
	mysqli_query($nConexion,"UPDATE tbl_cart_pedidos SET estado = '$cEstado' WHERE idpedido = $nIdPedido");
	mysqli_close($nConexion);
	?><script>document.location.href='car_pedidos_listar.php'</script><?
}


?>
<html>
	<head>
		<title>Administraci�n de Clientes</title>
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
    <!-- Formulario Ingreso de Noticias -->
    <form method="post" action="car_pedidos_editar_estado.php">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $Reg_Pedido->idpedido; ?>">
      <table>
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR PEDIDO - ESTADO</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Pedido:</td>
          <td class="contenidoNombres"><? echo $Reg_Pedido->idpedido; ?></td>
        </tr>
        <tr>
          <td class="tituloNombres">Fecha:</td>
          <td class="contenidoNombres"><? echo $Reg_Pedido->fecha; ?></td>
        </tr>
        <tr>
          <td class="tituloNombres">Cliente:</td>
          <td class="contenidoNombres"><? echo $Reg_Pedido->nombres . " " . $Reg_Pedido->apellidos; ?></td>
        </tr>
        <tr>
          <td class="tituloNombres">Neto:</td>
          <td class="contenidoNombres"><? echo number_format($Reg_Pedido->neto,2,'.',',') ; ?></td>
        </tr>
        <tr>
          <td class="tituloNombres">Estado:</td>
          <td class="contenidoNombres">
						<select name="cboEstado" id="cboEstado">
							<option value="PENDIENTE" <? if ( $Reg_Pedido->estado == "PENDIENTE" ) { echo "selected"; } ?>>PENDIENTE</option>
							<option value="PROCESADO" <? if ( $Reg_Pedido->estado == "PROCESADO" ) { echo "selected"; } ?>>PROCESADO</option>
						</select>
					</td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="car_pedidos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
</body>
</html>
