<?php 
require_once("../../funciones_generales.php");
require_once("../../herramientas/seguridad/seguridad.php");
require_once '../../herramientas/paginar/dbquery.inc.php';
  $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    if (isset( $_POST["asunto"] )) {
        $ca->prepareUpdate("configuracion_form", "correo,mensaje1,asunto,mensaje2", "idform=:idform");
        $ca->bindValue(":correo", $_POST["correo"], true);
        $ca->bindValue(":mensaje1", $_POST["mensaje1"], true);
        $ca->bindValue(":asunto", $_POST["asunto"], true);
        $ca->bindValue(":mensaje2", $_POST["mensaje2"], true);
        $ca->bindValue(":idform", $_POST["modulo"], false);
		$ca->exec();
    }
    if (isset( $_GET["modulo"] )) {
		$ca->prepareSelect("configuracion_form", "*","idform = {$_GET["modulo"]}");
		$ca->exec();
    if ($ca->size()>0) {
		$r = $ca->fetch();
	}
	}
    mysqli_close($nConexion);
?>

<html>
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
<script src="../../herramientas/ckeditor/ckeditor.js"></script>
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
<?php include("../../system_menu.php"); ?><br>
    <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="modulo" value="<?php echo $r["idform"] ?>">
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario">
          <b>Mensajes</b>
        </td>
      </tr>
      <tr valign="baseline">
        <td class="tituloNombres" width="15%"><strong>Correos:</strong></td>
        <td class="contenidoNombres"><input type="text" name="correo" size="100" value="<?php echo $r["correo"] ?>"> (separados por coma)
        </td>
      </tr>
      <tr valign="baseline">
        <td class="tituloNombres" width="15%"><strong>Mensaje:</strong></td>
        <td class="contenidoNombres"><textarea name="mensaje1"><?php echo $r["mensaje1"] ?></textarea>
            <script> CKEDITOR.replace( 'mensaje1' ); </script>
        </td>
      </tr>
      <tr valign="baseline">
        <td class="tituloNombres" width="15%"><strong>Asunto:</strong></td>
        <td class="contenidoNombres"><input type="text" name="asunto" size="100" value="<?php echo $r["asunto"] ?>"></td>
      </tr>
      <tr valign="baseline">
        <td class="tituloNombres" width="15%"><strong>Mensaje del correo:</strong></td>
        <td class="contenidoNombres"><textarea name="mensaje2"><?php echo $r["mensaje2"] ?></textarea>
            <script> CKEDITOR.replace( 'mensaje2' ); </script>
        </td>
      </tr>
      <tr valign="baseline">
        <td colspan="2" class="nuevo"><br><br>
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
        </td>
      </tr>
      </table>
    </form>
      <br><br><br>
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
	<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
      </tr>
      </table>
  	</body>
</html>