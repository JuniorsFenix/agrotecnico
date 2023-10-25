<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

	include("../../vargenerales.php");

	

	if ( !isset( $_GET["Id"] ) )

	{

		header("Location: car_clientes_listar.php");

	}

	else

	{

		$IdPedido = $_GET["Id"];

		$nConexion    = Conectar();

		$rs_pedido    = mysqli_query($nConexion,"SELECT tbl_cart_pedidos.idpedido, tbl_cart_pedidos.idcliente, tbl_cart_pedidos.neto, tbl_cart_pedidos.estado, tbl_cart_pedidos.fecha, tbl_cart_clientes.nombres, tbl_cart_clientes.apellidos FROM tbl_cart_pedidos INNER JOIN tbl_cart_clientes ON tbl_cart_pedidos.idcliente = tbl_cart_clientes.idcliente WHERE idpedido = $IdPedido");

		$rs_regP = mysqli_fetch_object( $rs_pedido );

	}

	

  $page=new sistema_paginacion('tbl_cart_pedidos_detalle');

  //$page->ordenar_por('fecha desc');

  $page->set_limite_pagina(20);

	$page->set_condicion("WHERE idpedido = $IdPedido");

  $result_page=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900")

?>



<html>

  <head>

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

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="5" align="center" class="tituloFormulario">

          <b>PEDIDO No: <? echo $rs_regP->idpedido ?></b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

			<tr>

				<td colspan="5" bgcolor="#FEF1E2"><b>Cliente: <? echo $rs_regP->idcliente . " / " . $rs_regP->nombres . " " . $rs_regP->apellidos; ?></b></td>

			</tr>

			<tr>

				<td colspan="5" bgcolor="#FEF1E2"><b>Fecha: <? echo $rs_regP->fecha . " / Estado: " . $rs_regP->estado . " / Neto: " . number_format($rs_regP->neto,2,'.',','); ?></b></td>

			</tr>

			<tr><td colspan="5">&nbsp;</td></tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id. Producto</b></td>

        <td bgcolor="#FEF1E2"><b>Producto</b></td>

				<td bgcolor="#FEF1E2"><b>Precio</b></td>

				<td bgcolor="#FEF1E2"><b>Cantidad</b></td>

				<td bgcolor="#FEF1E2"><b>Total</b></td>

      </tr>

      <?

				$ContFilas			= 0;

				$ColorFilaPar		= "#FFFFFF";

				$ColorFilaImpar	= "#F0F0F0";

        while($row=mysqli_fetch_object($result_page))

        {

				$ContFilas = $ContFilas+ 1 ;

				if ( fmod( $ContFilas,2 ) == 0 ) // Si devuelve cero el numero es par

				{

					$ColorFila = $ColorFilaPar;

				}

				else

				{

					$ColorFila = $ColorFilaImpar;

				}

        ?>

        <tr>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->idproducto; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->producto; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo number_format($row->precio,2,'.',','); ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo $row->cantidad; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo number_format($row->total,2,'.',','); ?></td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="5"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="5">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="5" class="nuevo">

          <input type="button" name="cmdRegresar" value="Lista de Clientes" onClick="document.location.href='car_clientes_listar.php'">

        </td>

      </tr>

      </table>

			<br><br><br><br><br>

			<table border="0" width="100%" cellspacing="0" cellpadding="0">

			<tr>

				<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

			</tr>

			</table>

  	</body>

</html>









