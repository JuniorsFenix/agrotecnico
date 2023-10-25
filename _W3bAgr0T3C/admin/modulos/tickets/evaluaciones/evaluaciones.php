<?php
require_once("../../../herramientas/seguridad/seguridad.php");
require_once("evaluaciones_funciones.php");
require_once("../../../vargenerales.php");
if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista
    header("Location: evaluaciones_listar.php");
}
?>
<html>
    <head>
        <title>Administración de Tickes - Evaluaciones Realizadas</title>
        <link href="../../../css/administrador.css" rel="stylesheet" type="text/css"/>
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
        require_once("../../../system_menu.php"); ?>
        <br/>
        <?php
        switch ($_GET["Accion"]) {
            case "GenerarGraficas":
                EvaluacionesGenerarGraficas($_GET["idsede"], $_GET["idempresa"], $_GET["filtro"]);
                break;
            case "GenerarPDF":
                EvaluacionesGenerarPDF($_GET["idsede"], $_GET["idempresa"], $_GET["filtro"]);
                break;
            default:
                header("Location: evaluaciones_listar.php");
                break;
        }
        ?>
    </body>
</html>
