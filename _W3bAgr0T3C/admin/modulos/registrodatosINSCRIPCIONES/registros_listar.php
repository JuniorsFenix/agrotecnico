<?

	include("../../herramientas/seguridad/seguridad.php");

	include("../../herramientas/paginar/class.paginaZ.php");

	include("../../funciones_generales.php");

	$page=new sistema_paginacion('tbl_datos_incripciones');

	$page->ordenar_por('iddatos_inscripciones desc');

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

    <table border="0" width="100%" cellspacing="5" cellpadding="4">

      <tr>

        <td colspan="37" align="center" class="tituloFormulario">

          <b>LISTA DE REGISTRO DE DATOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

		<td bgcolor="#FEF1E2">EPM</td>

		<td bgcolor="#FEF1E2">HERMANOS</td>

		<td bgcolor="#FEF1E2">NUEVO</td>

		<td bgcolor="#FEF1E2">NOMBRE<br>

NIÑO</td>

		<td bgcolor="#FEF1E2">APELLIDOS </td>

		<td bgcolor="#FEF1E2">NACIMIENTO</td>

		<td bgcolor="#FEF1E2">EDAD</td>

		<td bgcolor="#FEF1E2">TALLA</td>

		<td bgcolor="#FEF1E2">EPS</td>

		<td bgcolor="#FEF1E2">E-MAIL</td>

		<td bgcolor="#FEF1E2">DIRECCION CASA</td>

		<td bgcolor="#FEF1E2">BARRIO</td>

		<td bgcolor="#FEF1E2">TELEFONO</td>

		<td bgcolor="#FEF1E2">DIRECCION <br>

	    OPCIONAL</td>

		<td bgcolor="#FEF1E2">BARRIO <br>

	    OPCIONAL</td>

		<td bgcolor="#FEF1E2">TELEFONO<br>

OPCIONAL</td>

		<td bgcolor="#FEF1E2">NOMBRE<br>

PADRE</td>

		<td bgcolor="#FEF1E2">APELLIDO</td>

		<td bgcolor="#FEF1E2">CEDULA</td>

		<td bgcolor="#FEF1E2">E-MAIL</td>

		<td bgcolor="#FEF1E2">EMPRESA</td>

		<td bgcolor="#FEF1E2">CARGO</td>

		<td bgcolor="#FEF1E2">TELEFONO</td>

		<td bgcolor="#FEF1E2">TELEFONO<br>

CASA</td>

		<td bgcolor="#FEF1E2">CELULAR</td>

		<td bgcolor="#FEF1E2">NOMBRE<br>

MADRE</td>

		<td bgcolor="#FEF1E2">APELLIDO</td>

		<td bgcolor="#FEF1E2">CEDULA</td>

		<td bgcolor="#FEF1E2">E-MAIL</td>

		<td bgcolor="#FEF1E2">EMPRESA</td>

		<td bgcolor="#FEF1E2">CARGO</td>

		<td bgcolor="#FEF1E2">TELEFONO</td>

		<td bgcolor="#FEF1E2">TELEFONO<br>

CASA</td>

		<td bgcolor="#FEF1E2">CELULAR</td>

		<td bgcolor="#FEF1E2">¿POR QUÉ MEDIO SE ENTERO?</td>

		<td bgcolor="#FEF1E2">OBSERVACIONES</td>

      </tr>

      <?

		$ContFilas		= 0;

		$ColorFilaPar	= "#FFFFFF";

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

		  <td bgcolor="#FFFFFF"><? echo "$row->epm"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->hermanos"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->nuevo"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->nombreN"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->ApellidoN"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->nacimiento"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->edad"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->talla"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->eps"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->mailN"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->DireccionCasaN"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->barrioN"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->telefonoN"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->direccionNO"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->barrioNO"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->telefonoNO"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->nombrePadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->apellidoPadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->cedulaPadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->emailPadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->empresaPadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->cargoPadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->telefonoPadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->telefonoCasaPadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->celularPadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->nombreMadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->apellidoMadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->cedulaMadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->emailMadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->empresaMadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->cargoMadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->telefonoMadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->telefonoCasaMadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->celularMadre"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->comoEntero"; ?></td>

		  <td bgcolor="#FFFFFF"><? echo "$row->observaciones"; ?></td>

		  

		  <td bgcolor="#FFFFFF"align="center"><a href="registros.php?Accion=Eliminar&Id=<?=$row->iddatos_inscripciones;?>" onClick="return confirm('¿Seguro que desea eliminar este registro?');">

		  <img src="../../image/borrar.gif" border="0" ></a></td>

        </tr>

        <?

        }

        ?>

      <tr>

        <td colspan="37"><? $page->mostrar_enlaces(); ?></td>

      </tr>

	  <tr>

        <td colspan="37" class="nuevo"><a href="registros_excel.php">Generar Archivo Excel</a>

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