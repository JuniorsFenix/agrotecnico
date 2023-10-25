<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

	include("../../vargenerales.php");

  $page=new sistema_paginacion('tblimagenes');

  $page->ordenar_por('descripcion');

  $page->set_limite_pagina(5);

  $result_page=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900")

?>



<html>

  <head>

    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">

  </head>

  <body>

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="3" align="center" class="tituloFormulario">

          <b>GALER�A DE IMAGENES</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Descripci�n</b></td>

				<td bgcolor="#FEF1E2"><b>Ruta de Acceso</b></td>

				<td align="center" bgcolor="#FEF1E2"><b>Imagen</b></td>

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->descripcion"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$cRutaVerImgGaleria$row->imagen"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>" align="center"><img src="<? echo $cRutaVerImgGaleria . $row->imagen; ?>" width="50" height="50"></td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="3"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="3">&nbsp;</td>

      </tr>

      </table>

			<table border="0" width="100%" cellspacing="0" cellpadding="0">

			<tr>

				<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones inform�ticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

			</tr>

			</table>

  	</body>

</html>









