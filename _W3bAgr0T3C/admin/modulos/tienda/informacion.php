<?php 

require_once("../../funciones_generales.php");

require_once("../../herramientas/seguridad/seguridad.php");

require_once '../../herramientas/paginar/dbquery.inc.php';

    $nConexion = Conectar();

    $ca = new DbQuery($nConexion);

    if (isset( $_POST["correos"] )) {

        $ca->prepareUpdate("tblti_info", "correos,asunto1,mensaje1,asunto2,mensaje2");

        $ca->bindValue(":correos", $_POST["correos"], true);

        $ca->bindValue(":asunto1", $_POST["asunto1"], true);

        $ca->bindValue(":mensaje1", $_POST["mensaje1"], true);

        $ca->bindValue(":asunto2", $_POST["asunto2"], true);

        $ca->bindValue(":mensaje2", $_POST["mensaje2"], true);

		$ca->exec();

		$mensaje = "Información actualizada con éxito";

    }

		$ca->prepareSelect("tblti_info", "*");

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

<script src="../../herramientas/ckeditor/ckeditor.js"></script>



  </head>

  <body>

<?php include("../../system_menu.php"); ?><br>

    <form method="post" action="informacion.php" enctype="multipart/form-data">

    <?php echo $mensaje; ?>

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="2" align="center" class="tituloFormulario">

          <b>Información general</b>

        </td>

      </tr>

      <tr valign="baseline">

        <td class="tituloNombres" width="25%"><strong>Correos:</strong></td>

        <td class="contenidoNombres"><input type="text" name="correos" size="50" value="<?php echo $r["correos"] ?>">(si son varios separarlos con comas)</td>

      </tr>

      <tr valign="baseline">

        <td class="tituloNombres" width="25%"><strong>Asunto mensaje interno:</strong></td>

        <td class="contenidoNombres"><input type="text" name="asunto1" size="50" value="<?php echo $r["asunto1"] ?>"></td>

      </tr>

        <tr>

          <td colspan="2" class="tituloNombres">Mensaje interno:</td>

        </tr>

        </table>

            <textarea name="mensaje1"><?php echo $r["mensaje1"] ?></textarea>

            <script>

                CKEDITOR.replace( 'mensaje1' );

            </script>

        <table border="0" width="100%" cellspacing="0" cellpadding="0">

        <tr valign="baseline">

        <td class="tituloNombres" width="25%"><strong>Asunto mensaje cliente:</strong></td>

        <td class="contenidoNombres"><input type="text" name="asunto2" size="50" value="<?php echo $r["asunto2"] ?>"></td>

      </tr>

        <tr>

          <td colspan="2" class="tituloNombres">Mensaje cliente:</td>

        </tr>

        </table>

            <textarea name="mensaje2"><?php echo $r["mensaje2"] ?></textarea>

            <script>

                CKEDITOR.replace( 'mensaje2' );

            </script>

        <table border="0" width="100%" cellspacing="0" cellpadding="0">

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