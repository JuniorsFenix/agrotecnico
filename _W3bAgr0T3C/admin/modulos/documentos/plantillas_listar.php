<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  include("../../vargenerales.php");

  $IdCiudad = $_SESSION["IdCiudad"];

  $page=new sistema_paginacion('tblplantillas');

  //$page->set_condicion( "WHERE a.idciudad = " . $IdCiudad );

  // Si se envio parametro para filtro categorias muestro realizo la condicion

  

  $page->ordenar_por('idplantilla desc');

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



		<title>Lista de Plantillas</title>

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

        <td colspan="8" align="center" class="tituloFormulario">

          <b>LISTA DE PLANTILLAS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>

	<td bgcolor="#FEF1E2"><b>Titulo</b></td>

	<td bgcolor="#FEF1E2"><b>Imagen</b></td>

        <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>

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

	  <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idplantilla"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fecha"; ?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->titulo"; ?></td>

	  <td bgcolor="<? echo $ColorFila; ?>" align="center">

            <?

              if ( !empty($row->archivo) ) {

                ?><a target="_blank" href="<? echo $cRutaVerPlantillas . $row->archivo ; ?>">Ver</a>

		<img src="<? echo $cRutaVerPlantillas . $row->archivo; ?>" alt="" width="100" height="100" hspace="0" align="center" border="0" />

              <?

	      }

              else {

                echo "No Asignada" ;

              }

            ?>

          

          </td>

          <td bgcolor="<? echo $ColorFila; ?>" align="center"><a href="plantillas.php?Accion=Editar&Id=<? echo "$row->idplantilla"; ?>">

	  <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->archivo"; ?>"></a></td>

          

	  <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="plantillas.php?Accion=Eliminar&Id=<?=$row->idplantilla;?>" onClick="return confirm('�Seguro que desea eliminar este registro?');">

	  <img src="../../image/borrar.gif" border="0" ></a></td>

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

          <a href="plantillas.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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









