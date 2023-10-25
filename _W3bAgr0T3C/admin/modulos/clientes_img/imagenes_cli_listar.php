<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

	include("../../vargenerales.php");

  $page=new sistema_paginacion('tblimagenescli');



  if ( ( isset ($_GET["idcliente"]) ) && ( isset($_GET["cliente"]) ) ) 

  {

    $page->set_condicion("WHERE idcliente = " . $_GET["idcliente"]);

  }

	else

	{

		header("Location: clientes_img_listar.php");

	}

  $page->ordenar_por('idimagen DESC');

  $page->set_limite_pagina(20);

  $result_page=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900")

?>



<html>

  <head>

    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">

		<title>Lista de Imagenes</title>

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

        <td colspan="6" align="center" class="tituloFormulario">

				<center>

          <b>LISTA DE IMAGENES: <? echo $_GET["cliente"]; ?></b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

					</center>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

				<td bgcolor="#FEF1E2"><b>Descripci�n</b></td>

        <td bgcolor="#FEF1E2"><b>Archivo</b></td>

				<td bgcolor="#FEF1E2"><b>Vista Imagen</b></td>

        <td bgcolor="#FEF1E2"><b>Editar</b></td>

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idimagen"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->descripcion"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->imagen"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><img src="<? echo $cRuraVerImgClientes . $row->imagen ; ?>" height="80" border="0" vspace="0" hspace="0"></td>

          <td bgcolor="<? echo $ColorFila; ?>" align="center"><a href="imagenes_cli.php?Accion=Editar&Id=<? echo "$row->idimagen"; ?>&idcliente=<? echo $_GET["idcliente"];  ?>&cliente=<? echo $_GET["cliente"]; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->imagen"; ?>"></a></td>

          <td bgcolor="<? echo $ColorFila; ?>" align="center">

            <?

              if ( !empty($row->imagen) )

              {

                ?><a target="_blank" href="<? echo $cRuraVerImgClientes . $row->imagen ; ?>">Ver</a><?

              }

              else

              {

                echo "No Asignada" ;

              }

              

            ?>

          

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

          <a href="imagenes_cli.php?Accion=Adicionar&idcliente=<? echo $_GET["idcliente"]; ?>&cliente=<? echo $_GET["cliente"]; ?>"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

        </td>

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









