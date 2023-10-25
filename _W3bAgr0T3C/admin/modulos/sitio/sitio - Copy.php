<?php
	include("../../herramientas/seguridad/seguridad.php");
	include("sitio_funciones.php");
	include("../../vargenerales.php");
	if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista
		header("Location: sitio_listar.php");
	}
?>

<html>
    <head>
        <title>Administración de Sitio</title>
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
        <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
    </head>
    <body onload="initialize()">
        <?php include("../../system_menu.php"); ?><br>
        <?php
        switch ($_GET["Accion"]) {
            case "Adicionar":
                SitioFormNuevo();
                break;
            case "Editar":
                SitioFormEditar();
                break;
            case "Eliminar":
                SitioEliminar($_GET["Id"]);
                break;
            case "Guardar":
                SitioGuardar($_POST["txtId"],$_POST["txtNombre"], $_POST["txtLatitud"], $_POST["txtLongitud"], $_POST["txtCreditos"],$_POST["txtGoogle"], $_POST["txtFacebook"], $_POST["txtEditorial"],$_POST["txtEventos"], $_POST["txtServicios"], $_POST["txtGaleria"],$_POST["txtNoticias"], $_POST["txtTips"], $_POST["txtMusica"],$_POST["txtPizarra"], $_POST["txtVideos"], $_POST["txtAnalytics"]);
                break;
            default:
                header("Location: sitio_listar.php");
                break;
        }
        ?>
    </body>
</html>