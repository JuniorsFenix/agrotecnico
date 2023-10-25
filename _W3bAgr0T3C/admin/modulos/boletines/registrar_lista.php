<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  $page=new sistema_paginacion('tblboletineslistas');

  $page->ordenar_por('nombre');

  $page->set_limite_pagina(20);

  $result_page=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900");

  

  if( isset($_GET["accion"]) && $_GET["accion"]=="eliminar" ) {

    $nConexion = Conectar();

    $sql="DELETE FROM tblboletineslistas WHERE idlista='{$_GET["idlista"]}'";

    $r = mysqli_query($nConexion,$sql);

    if(!$r){

	Mensaje("fallo eliminando lista ","registrar_lista.php" );

    }

    $sql="DELETE FROM tblboletinescorreos WHERE idlista='{$_GET["idlista"]}'";

    $r = mysqli_query($nConexion,$sql);

    if(!$r){

	Mensaje("fallo eliminando correos de la lista ","registrar_lista.php" );

    }

    

    header("Location: registrar_lista.php");

  }

  

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

          <b>LISTA DE CORREOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Id Lista</b></td>

	<td bgcolor="#FEF1E2"><b>Nombre</b></td>

	<td bgcolor="#FEF1E2"><b>Ver Correos</b></td>

	<td bgcolor="#FEF1E2"><b>Editar</b></td>

	<td bgcolor="#FEF1E2"><b>Eliminar</b></td>

      </tr>

      <?php

	$ContFilas = 0;

	$ColorFilaPar = "#FFFFFF";

	$ColorFilaImpar	= "#F0F0F0";

	if ( $result_page ) {

	  while ($row = mysqli_fetch_object($result_page)) {

	    $ContFilas = $ContFilas + 1;

	    if ( fmod( $ContFilas,2 ) == 0 ) {

		$ColorFila = $ColorFilaPar;

	    }

	    else {

		$ColorFila = $ColorFilaImpar;

	    }

	  ?>

	  <tr>

	    <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</td>

	    <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idlista"; ?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nombre"; ?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><a href="registrar_correo.php?idlista=<?=$row->idlista;?>">

	    ...</a>

	    </td>

	    <td bgcolor="<? echo $ColorFila; ?>"><a href="lista.php?accion=editar&idlista=<?=$row->idlista;?>">

	    <img src="../../image/seleccionar.gif" border="0" ></a>

	    </td>

	    <td bgcolor="<? echo $ColorFila; ?>">

	    <a href="registrar_lista.php?accion=eliminar&idlista=<?=$row->idlista;?>" onclick="return confirm('�Seguro que desea eliminar este registro?');">

	    <img src="../../image/borrar.gif" border="0" ></a>

	    </td>

	  </tr>

	  <?

	  }

	}?>

      <tr>

        <td colspan="8"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="9">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="9" class="nuevo">

	    <a href="lista.php?accion=adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nueva Lista."></a>

	    <a href="lista.php?accion=listaimportar">Importar correos desde archivo txt</a>

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









