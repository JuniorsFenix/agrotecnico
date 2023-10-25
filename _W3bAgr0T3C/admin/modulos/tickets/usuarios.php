<?php
require_once("../../herramientas/seguridad/seguridad.php");
require_once("usuarios_funciones.php");
require_once("../../vargenerales.php");
if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista
    header("Location: usuarios_listar.php");
}
?>
<html>
    <head>
        <title>Administración de Tickes - Usuarios</title>
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
            case "Editar":
                UsuariosFormEditar($_GET["Id"]);
                break;
            case "Eliminar":
                UsuariosEliminar($_GET["Id"]);
                break;
            case "Guardar":
                $_POST["attr_tipo"] = "0";
                if ( $_POST["tipo"] == "zona" || $_POST["tipo"] == "region" ) {
                    $_POST["attr_tipo"] = $_POST["attr_tipo_".$_POST["tipo"]];
                }
                UsuariosGuardar($_POST["txtId"], $_POST["idsede"], $_POST["tipo"], $_POST["attr_tipo"]);
                break;
            default:
                header("Location: usuarios_listar.php");
                break;
        }
        ?>
    </body>
</html>
