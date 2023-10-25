<?php
require_once("../../herramientas/seguridad/seguridad.php");
require_once("zonas_funciones.php");
require_once("../../vargenerales.php");
if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista
    header("Location: zonas_listar.php");
}
?>
<html>
    <head>
        <title>Administración de Tickes - Zonas</title>
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
        <?php 
        require_once("../../system_menu.php"); ?>
        <br/>
        <?php
        switch ($_GET["Accion"]) {
            case "Adicionar":
                ZonasFormNuevo();
                break;
            case "Editar":
                ZonasFormEditar($_GET["Id"]);
                break;
            case "Eliminar":
                ZonasEliminar($_GET["Id"]);
                break;
            case "Guardar":
                ZonasGuardar($_POST["txtId"], $_POST["nombre"], $_POST["idregion"]);
                break;
            default:
                header("Location: zonas_listar.php");
                break;
        }
        ?>
    </body>
</html>

