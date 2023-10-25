<?php
require_once("../../herramientas/seguridad/seguridad.php");
require_once("sedes_funciones.php");
require_once("../../vargenerales.php");
if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista
    header("Location: sedes_listar.php");
}
?>
<html>
    <head>
        <title>Administración de Tickes - Sedes</title>
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
                SedesFormNuevo();
                break;
            case "Editar":
                SedesFormEditar($_GET["Id"]);
                break;
            case "Eliminar":
                SedesEliminar($_GET["Id"]);
                break;
            case "Guardar":
                SedesGuardar($_POST["txtId"], $_POST["nombre"], $_POST["idzona"], $_POST["ciudad"], $_POST["pais"], $_POST["contacto"], 
                        $_POST["correo_contacto"], $_POST["correo_sede"], $_POST["direccion"], $_POST["telefono"], $_POST["gremio"], $_POST["idevaluacion"]);
                break;
            default:
                header("Location: sedes_listar.php");
                break;
        }
        ?>
    </body>
</html>
