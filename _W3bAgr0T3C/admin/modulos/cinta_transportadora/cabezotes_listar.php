<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  include("../../vargenerales.php");

  $IdCiudad = $_SESSION["IdCiudad"];

  $page = new sistema_paginacion('tblimagenes_cinta a join tblcinta_categorias b on (a.idcategoria=b.idcategoria)');



  $page->ordenar_por('a.idcategoria');

  $page->set_limite_pagina(20);

  $rsCabezotes = $page->obtener_consulta();

  if ( !$rsCabezotes ) {

    die ( "Fallo consultando cabezotes" );

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



		<title>Lista de Cabezotes</title>





  </head>

  <body>

<? include("../../system_menu.php"); ?><br>



  <form action="cabezotes_listar.php" method="post">

  </form>



    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="11" align="center" class="tituloFormulario">

          <b>LISTA DE CABEZOTES</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

	<td bgcolor="#FEF1E2"><b>Categoria</b></td>

	<td bgcolor="#FEF1E2"><b>URL</b></td>

	<td bgcolor="#FEF1E2"><b>Target</b></td>

	<td bgcolor="#FEF1E2"><b>Archivo</b></td>

        <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>

        <td align="center" bgcolor="#FEF1E2"><b>Imagen

	<td bgcolor="#FEF1E2"><b>Eliminar</b></td>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

	</b></td>

      </tr>

      <?

	$ContFilas = 0;

	$ColorFilaPar = "#FFFFFF";

	$ColorFilaImpar	= "#F0F0F0";

        while($row = mysqli_fetch_object($rsCabezotes)) {

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

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row->idimagen; ?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row->nombre; ?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row->url; ?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row->target; ?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row->archivo; ?></td>

	    <td bgcolor="<? echo $ColorFila; ?>" align="center"><a href="cabezotes.php?Accion=Editar&Id=<?=$row->idimagen;?>">

	    <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<?=$row->archivo;?>"></a></td>

	    <td bgcolor="<? echo $ColorFila; ?>" align="center">

	    <?

	    if ( !empty($row->archivo) ) {

	      ?><a target="_blank" href="<?=$cRutaImgCinta.$row->archivo;?>">Ver</a>

	      <img src="<?=$cRutaImgCinta.$row->archivo;?>" alt="" width="100" height="100" hspace="0" align="center" border="0" />

	    <?

	    }

	    else {

	      echo "No Asignada";

	    }

	    ?>

	    

	    </td>

	    <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="cabezotes.php?Accion=Eliminar&Id=<?=$row->idimagen;?>" onClick="return confirm('�Seguro que desea eliminar este registro?');">

	    <img src="../../image/borrar.gif" border="0" ></a></td>

	    <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>

	    </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="11"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="11">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="11" class="nuevo">

          <a href="cabezotes.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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

