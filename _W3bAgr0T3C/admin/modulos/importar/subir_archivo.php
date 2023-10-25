<?php
require_once("../../herramientas/seguridad/seguridad.php");
require_once("../../funciones_generales.php");
require_once ("../../vargenerales.php");

  $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
?>
<!DOCTYPE HTML>
<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

		<title>Actualizar productos</title>

  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
  <?php include("../../system_menu.php"); ?><br>
    <h1 class="tituloFormulario">ACTUALIZAR PRODUCTOS</h1>
    <form method="post" action="importar.php" enctype="multipart/form-data">
	  <table width="100%">
	    <tr>
	      <td class="tituloNombres">Archivo .xlsx:</td>
	      <td class="contenidoNombres"><input type="file" id="archivo" name="archivo" accept=".xls,.xlsx"></td>
	    </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
	</table>
	
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
						<button type="submit" style="width: 96px;height: 28px;vertical-align: top;border: 1px solid #000;font-weight: bold;cursor: pointer;">Actualizar</button>
          </td>
        </tr>
      </table>
    </form>
      <br><br><br><br><br>
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
      </tr>
      </table>
    </body>
</html>
