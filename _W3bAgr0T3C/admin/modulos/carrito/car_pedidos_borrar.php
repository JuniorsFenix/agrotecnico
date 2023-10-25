<? 
include("../../funciones_generales.php");


if ( isset( $_GET["Id"] ) )
{
	$nConexion = Conectar();
	$nIdPedido = $_GET["Id"];
	mysqli_query($nConexion,"DELETE FROM tbl_cart_pedidos WHERE idpedido = $nIdPedido");
	mysqli_query($nConexion,"DELETE FROM tbl_cart_pedidos_detalle WHERE idpedido = $nIdPedido");
	mysqli_close($nConexion);
	//Mensaje( "Pedido Eliminado Correctamente", "car_pedidos_listar.php" );
}
?>
<script>document.location.href='car_pedidos_listar.php'</script>
