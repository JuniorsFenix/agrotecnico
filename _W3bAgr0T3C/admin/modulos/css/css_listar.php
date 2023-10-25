<?php

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  include("../../vargenerales.php");

  $IdCiudad = $_SESSION["IdCiudad"];

  

  

	

	if (isset($_POST["bGuardarDatos"])) {

  

	  $dir = "../../../css/diccionario.css";

	  

	  file_put_contents($dir, $_POST["css"]);

	

	}

?>







<html>

  <head>

    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">

    <link href="../../herramientas/color/css/colorpicker.css" rel="stylesheet" media="screen" type="text/css" />

<script type="text/javascript" src="../../herramientas/color/js/jquery.js"></script>

<script type="text/javascript" src="../../herramientas/color/js/colorpicker.js"></script>



<style type="text/css">

body {

	margin:0;

}

#css{

	float:left;

	width:70%;

}

#color{

	float:left;

	width:30%;

}

.clear{

	clear:both;

	height:0px;

}

</style>



<title>CSS</title>

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

<?php include("../../system_menu.php"); ?><br>



<?php $css = file_get_contents("../../../css/diccionario.css");?>



<div id="css">

<form name="vform" method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">

<textarea name="css" rows="30" cols="100"><?php echo stripslashes(html_entity_decode($css)); ?></textarea><br/><br/><br>

<input type="submit" Value="Guardar" name="bGuardarDatos"/>

</form>

</div>

<div id="color">

	<p id="colorpickerHolder"></p>

    <script type="text/javascript">

    $('#colorpickerHolder').ColorPicker({flat: true});

	</script>

</div>

<div class="clear"></div>





	  

  

  <?php $dir = "../../../css/diccionario.css";

 

	//get all image files with a .css extension.

	$archivos = glob($dir . "*.css");

	 

	//print each file name

	 foreach($archivos as $archivo)

        {

	print_r($archivo);

	exit;

	} 

	?>



	<br><br><br><br><br>

	<table border="0" width="100%" cellspacing="0" cellpadding="0">

	<tr>

		<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

	</tr>

	</table>

  	</body>

</html>

