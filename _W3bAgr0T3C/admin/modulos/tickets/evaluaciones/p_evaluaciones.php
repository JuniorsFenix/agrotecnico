<?php
require_once("../../../herramientas/seguridad/seguridad.php");
require_once("p_evaluaciones_funciones.php");
require_once("../../../vargenerales.php");
if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista
    header("Location: p_evaluaciones_listar.php");
}
?>
<html>
    <head>
        <title>Administración de Tickes - Evaluaciones</title>
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
        require_once("../../../system_menu.php"); 
        ?>
        <br/>
        <?php
        switch ($_GET["Accion"]) {
            case "Adicionar":
                EvaluacionesFormNuevo();
                break;
            case "Evaluar":
                EvaluacionesFormEvaluar($_GET["idsede"]);
                break;
            case "GuardarEvaluar":
                EvaluacionesGuardarEvaluar($_POST);
                break;
            case "Editar":
                EvaluacionesFormEditar($_GET["Id"]);
                break;
            case "Eliminar":
                EvaluacionesEliminar($_GET["Id"]);
                break;
            case "Guardar":
                EvaluacionesGuardar($_POST["txtId"], $_POST["nombre"]);
                break;
            default:
                header("Location: p_evaluaciones_listar.php");
                break;
        }
        ?>
    </body>
</html>

