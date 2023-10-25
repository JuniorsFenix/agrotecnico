<?php
require_once("../../herramientas/seguridad/seguridad.php");
require_once("regiones_funciones.php");
require_once("../../vargenerales.php");
if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista
    header("Location: regiones_listar.php");
}
?>
<html>
    <head>
        <title>Administración de Tickes - Regiones</title>
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
                RegionesFormNuevo();
                break;
            case "Editar":
                RegionesFormEditar($_GET["Id"]);
                break;
            case "Eliminar":
                RegionesEliminar($_GET["Id"]);
                break;
            case "Guardar":
                RegionesGuardar($_POST["txtId"], $_POST["nombre"], $_POST["idempresa"]);
                break;
            default:
                header("Location: regiones_listar.php");
                break;
        }
        ?>
    </body>
</html>

