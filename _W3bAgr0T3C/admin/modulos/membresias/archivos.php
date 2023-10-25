<?php
require_once("../../herramientas/FCKeditor/fckeditor.php");
require_once("../../herramientas/seguridad/seguridad.php");
require_once("archivos_funciones.php");
require_once("../../herramientas/upload/uploaderFunction.php");
require_once("../../vargenerales.php");
if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista
    header("Location: archivos_listar.php");
}
?>
<html>
    <head>
        <title>Administración de Archivos Membresias</title>
        <link href="../../css/administrador.css" rel="stylesheet" type="text/css"/>
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
        <?php include("../../system_menu.php"); ?><br/>
        <?php
        switch ($_GET["Accion"]) {
            case "Adicionar":
                ArchivosFormNuevo();
                break;
            case "Editar":
                ArchivosFormEditar($_GET["Id"]);
                break;
            case "Eliminar":
                ArchivosEliminar($_GET["Id"]);
                break;
            case "Guardar":
                ArchivosGuardar($_POST["txtId"], $_POST["nombre"], $_POST["idscategorias"], $_POST["contenido"], $_FILES["archivo"], $_POST["url_informacion"], $_POST["estado"]);
                break;
            default:
                header("Location: archivos_listar.php");
                break;
        }
        ?>
    </body>
</html>