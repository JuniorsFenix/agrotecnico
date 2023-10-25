<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  include("../../vargenerales.php");

  $IdCiudad = $_SESSION["IdCiudad"];

  $page=new sistema_paginacion('tblpdf');

  //$page->set_condicion( "WHERE a.idciudad = " . $IdCiudad );

  // Si se envio parametro para filtro categorias muestro realizo la condicion

  

  $page->ordenar_por('idpdf desc');

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



		<title>Registro de Envios</title>

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

          <b>REGISTRO DE ENVIOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>

	<td bgcolor="#FEF1E2"><b>Usuario</b></td>

	<td bgcolor="#FEF1E2"><b>Correo</b></td>

        <td bgcolor="#FEF1E2"><b>Asunto</b></td>

	<td bgcolor="#FEF1E2"><b>Mensaje</b></td>

	<td bgcolor="#FEF1E2"><b>Ver</b></td>

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idpdf"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fechahora"; ?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->usuario"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->correo"; ?></td>        

	  	  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->asunto"; ?></td>    

	  	  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->mensaje"; ?></td>

	  <td bgcolor="<? echo $ColorFila; ?>" align="center">

            <a target="_blank" href="<? echo $cRutaVerDocumentos . $row->pdf ; ?>">Ver</a>

          

          </td>

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









