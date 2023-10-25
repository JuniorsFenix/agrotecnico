<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  include("../../vargenerales.php");

  $IdCiudad = $_SESSION["IdCiudad"];

  $page=new sistema_paginacion('tblusuarios_externos');

  

  // Si se envio parametro para filtro categorias muestro realizo la condicion



  //$page->set_condicion( "WHERE 1=1 " . $filtro);

  $page->ordenar_por('usuario desc');

  $page->set_limite_pagina(20);

  $result_page=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900");

  

  $nConexion = Conectar();

  $sql="select distinct usuario from tblusuarios_archivos";

  $raUsuarios = mysqli_query($nConexion,$sql);

  $sql="select distinct tipo from tblusuarios_archivos";

  $raTipos = mysqli_query($nConexion,$sql);

  

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

<form  action="<?=$_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="12" align="center" class="tituloFormulario">

          <b>LISTA DE USUARIOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Id</b></td>

        <td bgcolor="#FEF1E2"><b>&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Nombre</b></td>

        <td bgcolor="#FEF1E2"><b>C&eacute;dula</b></td>

        <td bgcolor="#FEF1E2"><b>Correo</b></td>

        <td bgcolor="#FEF1E2"><b>Ciudad</b></td>

        <td bgcolor="#FEF1E2"><b>Dirección:</b></td>

        <td bgcolor="#FEF1E2"><b>Tel&eacute;fono</b></td>

        <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>

	<td bgcolor="#FEF1E2"><b>Eliminar</b></td>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

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

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->idusuario;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->nombre." ".$row->apellido;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->cedula;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->correo_electronico;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->ciudad;?></td>

      <td bgcolor="<? echo $ColorFila; ?>"><?=$row->direccion;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->telefono;?></td>

      <td bgcolor="<? echo $ColorFila; ?>"align="center">

          <a href="usuarios.php?Accion=Editar&Id=<? echo "$row->idusuario"; ?>">

              <img src="../../image/seleccionar.gif" border="0" alt=""/>

          </a>

      </td>

	  <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="usuarios.php?Accion=Eliminar&Id=<?=$row->idusuario;?>" onclick="return confirm('�Seguro que desea eliminar este registro?');">

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

      <tr>

        <td colspan="12" class="nuevo">

          <a href="usuarios.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

        </td>

      </tr>

      </table>

	<br><br><br><br><br>

	<table border="0" width="100%" cellspacing="0" cellpadding="0">

	<tr>

		<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones inform�ticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

	</tr>

	</table>

	</form>

  	</body>

</html>

