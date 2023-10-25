<?

  require_once("../../herramientas/seguridad/seguridad.php");

  require_once("../../herramientas/paginar/class.paginaZ.php");

  require_once("../../funciones_generales.php");

  require_once("../../vargenerales.php");

  $IdCiudad = $_SESSION["IdCiudad"];

  

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



<title>Lista de CSS</title>



  </head>

  <body>

<? require_once("../../system_menu.php"); ?><br>



    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="6" align="center" class="tituloFormulario">

          <b>LISTA DE CSS</b>

          <br>

        </td>

      </tr>

      <tr>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

        <td bgcolor="#FEF1E2"><b>Descripción</b></td>

        <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>

	<td bgcolor="#FEF1E2"><b>Eliminar</b></td>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

	</b></td>

      </tr>

      <?

	$ContFilas			= 0;

	$ColorFilaPar		= "#FFFFFF";

	$ColorFilaImpar	= "#F0F0F0";

	  $ContFilas = $ContFilas+ 1 ;

	  if ( fmod( $ContFilas,2 ) == 0 ) // Si devuelve cero el numero es par

	  {

	    $ColorFila = $ColorFilaPar;

	  }

	  else

	  {

	    $ColorFila = $ColorFilaImpar;

	  }

	  

  

  $dir = "../../../css/";

 

	//get all image files with a .css extension.

	$archivos = glob($dir . "*.css");

	 

	//print each file name

	 foreach($archivos as $archivo)

        {

	print_r($archivo);

	exit;}

        ?>

        <tr>

        

		<?php foreach($archivos as $archivo)

        {?>

	  <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>

          <td bgcolor="<? echo $ColorFila; ?>"><?php echo $archivo;?></td>

          <td bgcolor="<? echo $ColorFila; ?>" align="center"><a href="frases.php?Accion=Editar&Id=<?php echo $archivo;?>">

	  <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<?php echo $archivo;?>"></a></td>

	  <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>

        <?

        }

      ?>

        </tr>

      <tr>

      </tr>

      <tr>

        <td colspan="6">&nbsp;</td>

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

