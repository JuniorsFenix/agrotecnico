<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  include("../../vargenerales.php");

  $IdCiudad = $_SESSION["IdCiudad"];

  $page=new sistema_paginacion('tblusuarios_archivos');

  //$page->set_condicion( "WHERE a.idciudad = " . $IdCiudad );

  // Si se envio parametro para filtro categorias muestro realizo la condicion

  

  $page->ordenar_por('usuario desc');

  $page->set_limite_pagina(20);

  $result_page=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900");

  

  $nConexion = Conectar();

  $sql="select distinct usuario from tblusuarios_archivos";

  $ra = mysqli_query($nConexion,$sql);

  

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



<title>Lista de Archivos</title>

    <script>

    <!--

    function land(ref, target) {

    lowtarget=target.toLowerCase();

    if (lowtarget=="_self") {window.location=loc;}

    else {if (lowtarget=="_top") {top.location=loc;}

    else {if (lowtarget=="_blank") {window.open(loc);}

    else {if (lowtarget=="_parent") {parent.location=loc;}

    else {parent.frames[target].location=loc;};

    }}}

    }

    function jump(menu)

    {

    ref=menu.cboCategorias.options[menu.cboCategorias.selectedIndex].value;

    splitc=ref.lastIndexOf("*");

    target="";

    if (splitc!=-1)

    {loc=ref.substring(0,splitc);

    target=ref.substring(splitc+1,1000);}

    else {loc=ref; target="_self";};

    if (ref != "") {land(loc,target);}

    }

    //-->

    </script>



  </head>

  <body>

<? include("../../system_menu.php"); ?><br>



    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="12" align="center" class="tituloFormulario">

          <b>LISTA DE ARCHIVOS</b>

          <br>

			<p align="left">Usuario: <select name="filtro" id="filtro" align="left">

		  <option value="Todos">Todos</option>

			<?php while ( $row=mysqli_fetch_array($ra)):?>

		  <option value="<?=$row['usuario'];?>"><?=$row['usuario'];?></option>

		  <?php endwhile;?>

		</select></p>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

		

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Id</b></td>

		<td bgcolor="#FEF1E2"><b>&nbsp;</b></td>

		<td bgcolor="#FEF1E2"><b>Usuario</b></td>

		<td bgcolor="#FEF1E2"><b>&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Nombre</b></td>

        <td bgcolor="#FEF1E2"><b>Descripcion</b></td>

		<td bgcolor="#FEF1E2"><b>Fecha</b></td>

		<td bgcolor="#FEF1E2"><b>Archivo</b></td>

		<td bgcolor="#FEF1E2"><b>Tipo archivo</b></td>

	<td bgcolor="#FEF1E2"><b>Eliminar</b></td>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

	</b></td>

      </tr>

      <?

	$ContFilas			= 0;

	$ColorFilaPar		= "#FFFFFF";

	$ColorFilaImpar	= "#F0F0F0";

        while($row = mysqli_fetch_object($result_page)) {

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

		  <?php

/*  ` int(11) NOT NULL auto_increment,

  `` varchar(100) NOT NULL,

  `descripcion` text NOT NULL,

  `fechahora` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,

  `archivo` varchar(200) NOT NULL,

  `usuario` varchar(50) NOT NULL,

  `tipo`

*/

switch($row->tipo){

    case "VIDEOS":

        $op = "&op=videopreview";

		break;

        

    case "OFFICE":

        $op = "";

		break;

        

    case "FOTO":

        $op = "&view=1";

		break;

        

	default:

		break;

}



?>

	  <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->idarchivo;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->usuario;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->nombre;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->descripcion;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->fechahora;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>">

	  <a href="../../../php/logueoDescargarArchivo.php?ciudad=<?=$IdCiudad;?>&idarchivo=<?=$row->idarchivo;?>">

	  <img src="../../../php/logueoDescargarArchivo.php?ciudad=<?=$IdCiudad;?>&idarchivo=<?=$row->idarchivo.$op;?>" border="0" width="44" height="44" alt="Doc" />

	  </a>

	  </td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->tipo;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="usuarios.php?Accion=Eliminar&Id=<?=$row->idarchivo;?>" onclick="return confirm('�Seguro que desea eliminar este registro?');">

	  <img src="../../image/borrar.gif" border="0" ></a></td>

	  <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="12"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="12">&nbsp;</td>

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

