<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

	include("../../vargenerales.php");

	$IdCiudad = $_SESSION["IdCiudad"];

  $page=new sistema_paginacion('tbl_cart_pedidos');

	$page->set_condicion( "WHERE idciudad = ". $IdCiudad );

  $page->ordenar_por('fecha desc');

  $page->set_limite_pagina(20);

	//$page->set_condicion("WHERE idcliente = $IdCliente");

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

          <b>LISTA DE PEDIDOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>

				<td bgcolor="#FEF1E2"><b>Neto</b></td>

				<td bgcolor="#FEF1E2"><b>Estado</b></td>

        <td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->idpedido; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->fecha; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo number_format($row->neto,2,'.',','); ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo $row->estado; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>" align="center">

						<a href="car_pedidos_editar_estado.php?Id=<? echo "$row->idpedido"; ?>"><img src="../../image/seleccionar.gif" border="0"></a>

						<a href="car_verpedido_detalle.php?Id=<? echo "$row->idpedido"; ?>" target="_blank"><img src="../../image/pedidos.gif" border="0" alt="Ver Detalle Pedido No: <? echo $row->idpedido; ?> "></a>

						<a href="car_pedidos_borrar.php?Id=<? echo "$row->idpedido"; ?>"><img src="../../image/borrar.gif" border="0" alt="Borrar Pedido No: <? echo $row->idpedido; ?> "></a>

					</td>

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

          <!--<input type="button" name="cmdRegresar" value="Lista de Clientes" onClick="document.location.href='car_clientes_listar.php'">-->

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









