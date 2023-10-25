<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  

  

  if( isset($_GET["accion"]) && $_GET["accion"]=="eliminar" ) {

    $nConexion = Conectar();

    $sql="DELETE FROM tblinvitados WHERE id='{$_GET["id"]}'";

    $r = mysqli_query($nConexion,$sql);

    if(!$r){

	die("fallo eliminando correo ".mysqli_error($nConexion) );

    }

    header("Location: registrar_correo.php");

  }

  

  

  $from_where = "tblinvitados";

  $page=new sistema_paginacion($from_where);

  $page->ordenar_por('nombre');

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

        <td colspan="13" align="center" class="tituloFormulario">

          <b>LISTA DE INVITADOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>

	<!--td bgcolor="#FEF1E2"><b>Id</b></td-->

    <td bgcolor="#FEF1E2"><b>Nombre</b></td>

	<td bgcolor="#FEF1E2"><b>Apellido</b></td>

	<td bgcolor="#FEF1E2"><b>Cargo</b></td>

	<td bgcolor="#FEF1E2"><b>Empresa</b></td>

	<td bgcolor="#FEF1E2"><b>Correo</b></td>

    <td bgcolor="#FEF1E2"><b>Tel&eacute;fono</b></td>

	<td bgcolor="#FEF1E2"><b>Ciudad</b></td>

	<td bgcolor="#FEF1E2"><b>Pais</b></td>

	<td bgcolor="#FEF1E2"><b>Asisti&oacute;</b></td>

	<td bgcolor="#FEF1E2"><b>QR</b></td>

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

		$qr = "";

	  ?>

	  <tr>

	    <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</td>

	    <!--td bgcolor="<? //echo $ColorFila; ?>"><?//=$row["idcorreo"];?></td-->

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row["nombre"];?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row["apellido"];?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row["cargo"];?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row["empresa"];?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row["correo"];?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row["telefono"];?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row["ciudad"];?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row["pais"];?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?=$row["asistio"];?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><a href="qrcode.php?text=<?php echo base64_encode("http://www.sotrames.co/invitado{$row["id"]}");?>">Ver</a></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><a href="correo.php?accion=editar&id=<?=$row["id"];?> ">

	    <img src="../../image/seleccionar.gif" border="0" ></a>

	    </td>

	    <td bgcolor="<? echo $ColorFila; ?>"><a href="registrar_correo.php?accion=eliminar&id=<?=$row["id"];?>" onClick="return confirm('�Seguro que desea eliminar este registro?');">

	    <img src="../../image/borrar.gif" border="0" ></a>

	    </td>

	  </tr>

	  <?

	  }

	}?>

      <tr>

        <td colspan="13"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="13">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="13" class="nuevo">

	    <a href="correo.php?accion=adicionar<?=isset($IdLista)?"&idlista={$IdLista}":"";?>"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Correo."></a>

	    <a href="lista.php?accion=listaimportar">Importar correos</a>

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

