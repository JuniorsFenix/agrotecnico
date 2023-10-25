<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

	include("../../vargenerales.php");

  $page=new sistema_paginacion('tblplanes_reg');

  $page->ordenar_por('fecha_inscripcion desc');

  $page->set_limite_pagina(10);

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

        <td colspan="7" align="center" class="tituloFormulario">

          <b>LISTA DE BONOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id</b></td>

				<td bgcolor="#FEF1E2"><b>Nombres</b></td>

        <td bgcolor="#FEF1E2"><b>Nro. Pers.</b></td>

				<td bgcolor="#FEF1E2"><b>Sede</b></td>

				<td bgcolor="#FEF1E2"><b>Entrada</b></td>

				<td bgcolor="#FEF1E2"><b>Salida</b></td>

				<td bgcolor="#FEF1E2"><b>Inscripci�n</b></td>

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->id"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nombres"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nropersonas"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->sede"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fecha_ent"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fecha_sal"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fecha_inscripcion"; ?></td>

				</tr>

			<?

			}

			?>

      <tr>

        <td colspan="7"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="7">&nbsp;</td>

      </tr>

      </table>

			<br><br><br><br><br>

			<table border="0" width="100%" cellspacing="0" cellpadding="0">

			<tr>

				<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones inform�ticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

			</tr>

			</table>

  	</body>

</html>