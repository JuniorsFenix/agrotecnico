<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  include("../../vargenerales.php");

  $IdCiudad = $_SESSION["IdCiudad"];

  $page=new sistema_paginacion('tblcabezotes_categorias');



  $page->ordenar_por('idcategoria');

  $page->set_limite_pagina(20);

  $rsCategorias = $page->obtener_consulta();

  if ( !$rsCategorias ) {

    die ( "Fallo consultando categorias" );

  }

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



		<title>Lista de Categorias</title>



  </head>

  <body>

<? include("../../system_menu.php"); ?><br>



  <form action="cabezotes_listar.php" method="post">

  </form>



    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="8" align="center" class="tituloFormulario">

          <b>LISTA DE CATEGORIAS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

    <td bgcolor="#FEF1E2"><b>Id.</b></td>

   	<td bgcolor="#FEF1E2"><b>Nombre</b></td>

	<td bgcolor="#FEF1E2"><b>Textura</b></td>

	<td bgcolor="#FEF1E2"><b>Opacidad</b></td>

	<td bgcolor="#FEF1E2"><b>Cabezotes</b></td>

    <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>

	<td bgcolor="#FEF1E2"><b>Eliminar</b></td>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

	</b></td>

      </tr>

      <?

	$ContFilas = 0;

	$ColorFilaPar = "#FFFFFF";

	$ColorFilaImpar	= "#F0F0F0";

        while($row = mysqli_fetch_object($rsCategorias)) {

	    $ContFilas = $ContFilas+ 1 ;

	    if ( fmod( $ContFilas,2 ) == 0 ) {

	      $ColorFila = $ColorFilaPar;

	    }

	    else {

	      $ColorFila = $ColorFilaImpar;

	    }

	    ?>

	    <tr>

	    <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row->idcategoria; ?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row->nombre; ?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><div id="pattern" class="<?=$row->textura; ?>"></div></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row->opacidad; ?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><a href="cabezotes_listar.php?idcategoria=<?=$row->idcategoria;?>">Ver cabezotes<a></td>

	    <td bgcolor="<? echo $ColorFila; ?>" align="center"><a href="categorias.php?Accion=Editar&Id=<?=$row->idcategoria;?>">

	    <img src="../../image/seleccionar.gif" border="false" alt="Seleccionar"></a></td>

	    <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="categorias.php?Accion=Eliminar&Id=<?=$row->idcategoria;?>" onClick="return confirm('�Seguro que desea eliminar este registro?');">

	    <img src="../../image/borrar.gif" border="false" ></a></td>

	    <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>

	    </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="8"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="8">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="8" class="nuevo">

          <a href="categorias.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="false" alt="Crear Nuevo Registro."></a>

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

