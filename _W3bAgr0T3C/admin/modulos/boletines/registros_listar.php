<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  $page=new sistema_paginacion('tblregistros');

  $page->ordenar_por('idregistro desc');

  $page->set_limite_pagina(20);

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

        <td colspan="8" align="center" class="tituloFormulario">

          <b>LISTA DE REGISTROS AL BOLET�N</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

        <td bgcolor="#FEF1E2"><b>Nombres y Apellidos</b></td>

				<td bgcolor="#FEF1E2"><b>Pais</b></td>

				<td bgcolor="#FEF1E2"><b>Ciudad</b></td>

				<td bgcolor="#FEF1E2"><b>Email</b></td>

        <td bgcolor="#FEF1E2"><b>Confirmado</b></td>

				<td bgcolor="#FEF1E2"><b>Fecha</b></td>

				<td bgcolor="#FEF1E2"><b>Borrar</b></td>

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

        <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idregistro"; ?></td>

        <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nombres $row->apellidos"; ?></td>

        <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->pais"; ?></td>

        <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->ciudad"; ?></td>

        <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->email"; ?></td>

        <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->confirmado"; ?></td>

        <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fechareg"; ?></td>

		<td bgcolor="<? echo $ColorFila; ?>"><a href="borrar_reg_boletin.php?id=<? echo "$row->idregistro"; ?>">Ir</a></td>

        </tr>

        <?

        }

        ?>

      <tr>

        <td colspan="8"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      </table>

			<a href="registros_excel.php">Generar Archivo Excel</a>

			<br><br><br><br><br>

			<table border="0" width="100%" cellspacing="0" cellpadding="0">

			<tr>

				<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones inform�ticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

			</tr>

			</table>

  	</body>

</html>









