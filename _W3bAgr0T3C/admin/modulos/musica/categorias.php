<?php
require_once("../../herramientas/seguridad/seguridad.php");
require_once("categorias_funciones.php");
require_once("../../vargenerales.php");
if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista
    header("Location: categorias_listar.php");
}
?>
<html>
    <head>
        <title>Administración de Categorias MP3</title>
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
        <?php require_once("../../system_menu.php"); ?>
        <br/>
        <?php
        switch ($_GET["Accion"]) {
            case "Adicionar":
                CategoriasFormNuevo();
                break;
            case "Editar":
                CategoriasFormEditar($_GET["Id"]);
                break;
            case "Eliminar":
                CategoriasEliminar($_GET["Id"]);
                break;
            case "Guardar":
                CategoriasGuardar($_POST["txtId"], $_POST["nombre"]);
                break;
            default:
                header("Location: categorias_listar.php");
                break;
        }
        ?>
    </body>
</html>

