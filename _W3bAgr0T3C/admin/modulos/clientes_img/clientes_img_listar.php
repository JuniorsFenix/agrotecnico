<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

	include("../../vargenerales.php");

  $page=new sistema_paginacion('tblclientesimg');

	

	if ( !isset( $_POST["cboCampo"] ) )

	{

		$page->ordenar_por('idcliente ASC');

		$cCampo = "idcliente";

		$cTipo  = "ASC";

	}

	else

	{

		$cOrden = $_POST["cboCampo"] . " " . $_POST["cboOrden"];

		$cCampo = $_POST["cboCampo"];

		$cTipo  = $_POST["cboOrden"];

		$page->ordenar_por( $cOrden );

	}

  

  $page->set_limite_pagina(20);

  $result_page=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900")

?>



<html>

  <head>

    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">

		<title>Lista de Clientes</title>

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

  <form action="clientes_img_listar.php" method="post">

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td>Ordenar Por:

          <select name="cboCampo">

            <option value="idcliente" <? if ( $cCampo == "idcliente" ) echo "selected"; ?>>Id. Cliente</option> 

						<option value="nombres" <? if ( $cCampo == "nombres" ) echo "selected"; ?>>Nombres</option>

						<option value="apellidos" <? if ( $cCampo == "apellidos" ) echo "selected"; ?>>Apellidos</option>

						<option value="usuario" <? if ( $cCampo == "usuario" ) echo "selected"; ?>>Usuario</option>

          </select>

          <select name="cboOrden">

            <option value="ASC" <? if ( $cTipo == "ASC" ) echo "selected"; ?>>Ascendente</option>

						<option value="DESC" <? if ( $cTipo == "DESC" ) echo "selected"; ?>>Descendente</option>

          </select>

          <input TYPE="submit" VALUE="Ver">

        </td>

      </tr>

    </table>

  </form>





    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="6" align="center" class="tituloFormulario">

					<center>

          <b>LISTA DE CLIENTES</b>

          <br>

          <? $page->mostrar_numero_pagina() ?>

					<br>

					</center>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

        <td bgcolor="#FEF1E2"><b>Nombres</b></td>

        <td bgcolor="#FEF1E2"><b>Apellidos</b></td>				

				<td bgcolor="#FEF1E2"><b>Mail</b></td>

				<td bgcolor="#FEF1E2"><b>Usuario</b></td>

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idcliente"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nombres"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->apellidos"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->mail"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->usuario"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>" align="center">

					<a href="clientes_img.php?Accion=Editar&Id=<? echo "$row->idcliente"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->usuario"; ?>"></a>

					<a href="imagenes_cli_listar.php?idcliente=<? echo "$row->idcliente"; ?>&cliente=<? echo $row->nombres . " " . $row->apellidos; ?>"><img src="../../image/imagenes_cli.gif" border="0" alt="Listar Imagenes"></a>

					</td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="6"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="6">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="6" class="nuevo">

          <a href="clientes_img.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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









