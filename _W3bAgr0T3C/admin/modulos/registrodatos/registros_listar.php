<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  $page=new sistema_paginacion('tbl_datos');

  $page->ordenar_por('iddatos desc');

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

        <td colspan="12" align="center" class="tituloFormulario">

          <b>LISTA DE REGISTRO DE DATOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

		<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

        <td bgcolor="#FEF1E2"><b>Nombres</b></td>

		<td bgcolor="#FEF1E2"><b>Apellidos</b></td>

		<td bgcolor="#FEF1E2"><b>Mail</b></td>

		<td bgcolor="#FEF1E2"><b>Nacimiento</b></td>

		<td bgcolor="#FEF1E2"><b>Profesion</b></td>

        <td bgcolor="#FEF1E2"><b>Sexo</b></td>

		<td bgcolor="#FEF1E2"><b>Ciudad</b></td>

		<td bgcolor="#FEF1E2"><b>Barrio</b></td>

		<td bgcolor="#FEF1E2"><b>Comentarios</b></td>

		<td bgcolor="#FEF1E2"><b>Seleccionar</b></td>

		<td bgcolor="#FEF1E2"><b>Eliminar</b></td>

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

		  <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;&nbsp;</td>

		  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->iddatos"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nombres"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->apellidos"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->mail"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nacimiento"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->profesion"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->sexo"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->ciudad"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->barrio"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->comentarios"; ?></td>

		  

		  <td bgcolor="<? echo $ColorFila; ?>" align="center"><a href="registros.php?Accion=Editar&Id=<?=$row->iddatos; ?>">

		  <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->iddatos"; ?>"></a></td>

		  

		  <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="registros.php?Accion=Eliminar&Id=<?=$row->iddatos;?>" onClick="return confirm('¿Seguro que desea eliminar este registro?');">

		  <img src="../../image/borrar.gif" border="0" ></a></td>

        </tr>

        <?

        }

        ?>

      <tr>

        <td colspan="12"><? $page->mostrar_enlaces(); ?></td>

      </tr>

	  <tr>

        <td colspan="12" class="nuevo">

          <a href="registros.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>&nbsp;&nbsp;&nbsp;

		  <a href="registros_excel.php">Generar Archivo Excel</a>

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









