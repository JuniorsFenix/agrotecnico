<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  

  

  if( isset($_GET["idlista"]) ) {

    $IdLista = $_GET["idlista"];

    $where = " WHERE a.idlista={$IdLista} ";

  }

  

  

  if( isset($_GET["accion"]) && $_GET["accion"]=="eliminar" ) {

    $nConexion = Conectar();

    $sql="DELETE FROM tblboletinescorreos WHERE correo='{$_GET["correo"]}'";

    $r = mysqli_query($nConexion,$sql);

    if(!$r){

	die("fallo eliminando correo ".mysqli_error($nConexion) );

    }

    header("Location: registrar_correo.php".(isset($IdLista)?"?idlista={$IdLista}":""));

  }

  

  

  $from_where = "tblboletinescorreos a JOIN tblboletineslistas b ON (a.idlista=b.idlista)".(isset($where)?$where:"");

  $page=new sistema_paginacion($from_where);

  $page->set_campos("a.*,b.nombre AS nombre_lista");

  $page->ordenar_por('a.nombre');

  $page->set_limite_pagina(20);

  $result_page=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900");

    

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

          <b>LISTA DE CORREOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>

	<!--td bgcolor="#FEF1E2"><b>Id</b></td-->

        <td bgcolor="#FEF1E2"><b>Correo electronico</b></td>

	<td bgcolor="#FEF1E2"><b>Nombre</b></td>

	<td bgcolor="#FEF1E2"><b>Lista</b></td>

	<td bgcolor="#FEF1E2"><b>Editar</b></td>

	<td bgcolor="#FEF1E2"><b>Eliminar</b></td>

      </tr>

      <?php

	$ContFilas = 0;

	$ColorFilaPar = "#FFFFFF";

	$ColorFilaImpar	= "#F0F0F0";

	if ( $result_page ) {

	  while ($row = mysqli_fetch_array($result_page)) {

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

	    <!--td bgcolor="<? //echo $ColorFila; ?>"><?//=$row["idcorreo"];?></td-->

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row["correo"];?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row["nombre"];?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row["nombre_lista"];?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><a href="correo.php?accion=editar&correo=<?=$row["correo"];?><?=isset($IdLista)?"&idlista={$IdLista}":"";?> ">

	    <img src="../../image/seleccionar.gif" border="0" ></a>

	    </td>

	    <td bgcolor="<? echo $ColorFila; ?>"><a href="registrar_correo.php?accion=eliminar&correo=<?=$row["correo"];?><?=isset($IdLista)?"&idlista={$IdLista}":"";?>" onclick="return confirm('�Seguro que desea eliminar este registro?');">

	    <img src="../../image/borrar.gif" border="0" ></a>

	    </td>

	  </tr>

	  <?

	  }

	}?>

      <tr>

        <td colspan="7"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="7">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="7" class="nuevo">

	    <a href="correo.php?accion=adicionar<?=isset($IdLista)?"&idlista={$IdLista}":"";?>"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Correo."></a>

	    <a href="registrar_lista.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>

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

