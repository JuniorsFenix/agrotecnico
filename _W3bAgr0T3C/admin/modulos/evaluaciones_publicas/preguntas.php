<?php
include("../../herramientas/FCKeditor/fckeditor.php");
require_once("../../herramientas/seguridad/seguridad.php");
require_once("preguntas_funciones.php");
require_once("../../vargenerales.php");
if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista
    header("Location: preguntas_listar.php");
}
?>
<html>
    <head>
        <title>Administración Preguntas Evaluaciones Publicas</title>
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
<script src="../../herramientas/ckeditor/ckeditor.js"></script>
    </head>
    <body>
        <?php
        require_once("../../system_menu.php");
        ?>
        <br/>
        <?php
        switch ($_GET["Accion"]) {
            case "Adicionar":
                PreguntasFormNuevo();
                break;
            case "Editar":
                PreguntasFormEditar($_GET["Id"]);
                break;
            case "Eliminar":
                PreguntasEliminar($_GET["Id"]);
                break;
            case "Guardar":
                PreguntasGuardar($_POST["txtId"], $_POST["idevaluacion"], $_POST["pregunta"], $_POST["detalle"],$_FILES["imagen"]);
                break;
            default:
                header("Location: preguntas_listar.php");
                break;
        }
        ?>
    </body>
</html>

