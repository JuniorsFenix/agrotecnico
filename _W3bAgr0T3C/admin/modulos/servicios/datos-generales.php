<?php 

require_once("../../funciones_generales.php");

require_once("../../herramientas/seguridad/seguridad.php");

require_once '../../herramientas/paginar/dbquery.inc.php';

    $nConexion = Conectar();

    $ca = new DbQuery($nConexion);

    if (isset( $_POST["titulo"] )) {

		$descripcion = strip_tags($_POST["descripcion"]);

		$palabras = strip_tags($_POST["palabras"]);

		$titulo = strip_tags($_POST["titulo"]);

        $ca->prepareUpdate("tbldatos_generales", "titulo_servicios,descripcion_servicios,palabras_servicios");

        $ca->bindValue(":titulo_servicios", $titulo, true);

        $ca->bindValue(":descripcion_servicios", $descripcion, true);

        $ca->bindValue(":palabras_servicios", $palabras, true);

		$ca->exec();

    }

		$ca->prepareSelect("tbldatos_generales", "*");

		$ca->exec();

		$r = $ca->fetch();



    mysqli_close($nConexion);

?>



<html>

  <head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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

<?php include("../../system_menu.php"); ?><br>

    <form method="post" action="datos-generales.php" enctype="multipart/form-data">

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="2" align="center" class="tituloFormulario">

          <b>Datos Generales</b>

        </td>

      </tr>

      <tr valign="baseline">

        <td class="tituloNombres" width="15%"><strong>Título:</strong></td>

        <td class="contenidoNombres"><input type="text" name="titulo" size="50" value="<?php echo $r["titulo_servicios"] ?>"></td>

      </tr>

      <tr valign="baseline">

        <td class="tituloNombres" width="15%"><strong>Descripción:</strong></td>

        <td class="contenidoNombres"><textarea cols="38" name="descripcion"><?php echo $r["descripcion_servicios"] ?></textarea></td>

      </tr>

      <tr valign="baseline">

        <td class="tituloNombres" width="15%"><strong>Palabras Claves:</strong></td>

        <td class="contenidoNombres"><textarea cols="38" name="palabras"><?php echo $r["palabras_servicios"] ?></textarea></td>

      </tr>

      <tr valign="baseline">

        <td colspan="2" class="nuevo">

          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">

        </td>

      </tr>

      <tr>

        <td colspan="2">&nbsp;</td>

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