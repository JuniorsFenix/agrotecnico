<?

  include("seguridad.php");

  include("class.paginaZ.php");

  include("funciones_generales.php");

  $page=new sistema_paginacion('tblquejas');

    $page->ordenar_por('fecha desc');

  $page->set_limite_pagina(20);

  $result_page=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900")

?>



<html>

  <head>

    <link href="administrador.css" rel="stylesheet" type="text/css">

  </head>

  <body>

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="10" align="center" class="tituloFormulario">

          <b>LISTA DE QUEJAS / RECLAMOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>

				<td bgcolor="#FEF1E2"><b>Documento</b></td>

				<td bgcolor="#FEF1E2"><b>Nombres</b></td>

				<td bgcolor="#FEF1E2"><b>Telefono</b></td>

        <td bgcolor="#FEF1E2"><b>Tipo</b></td>

				<td bgcolor="#FEF1E2"><b>Clase</b></td>

				<td bgcolor="#FEF1E2"><b>Area</b></td>

				<td bgcolor="#FEF1E2"><b>IPS</b></td>

				<td bgcolor="#FEF1E2"><b>Descripcion</b></td>

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fecha"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->docid"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nombres"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->telefono"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->tipo"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->clase"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->area"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->ips"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->descripcion"; ?></td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="10"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      </table>

			<a href="quejas_excel.php">Generar Archivo Excel</a>

			<br><br><br><br><br>

			<table border="0" width="100%" cellspacing="0" cellpadding="0">

			<tr>

				<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

			</tr>

			</table>

  	</body>

</html>









