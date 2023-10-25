<?php
require_once("../../herramientas/FCKeditor/fckeditor.php");
require_once("../../herramientas/seguridad/seguridad.php");
require_once("contenidos_funciones.php");
require_once("../../herramientas/upload/uploaderFunction.php");
require_once("../../vargenerales.php");
if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista
    header("Location: contenidos_listar.php");
}
?>
<html>
    <head>
        <title>Administración de Contenidos Membresias</title>
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
        <?php include("../../system_menu.php"); ?><br/>
        <?php
        /* Determinar si biene el parametro que establece una accion:
          Adicionar  = Nuevo Registro
          Editar     = Editar Registro
          Eliminar   = Eliminar Registro
          Si no esta determinada la variable accion entonces se muestra la grilla con los registros
         */
        switch ($_GET["Accion"]) {
            case "Adicionar":
                ContenidosFormNuevo();
                break;
            case "Editar":
                ContenidosFormEditar($_GET["Id"]);
                break;
            case "Eliminar":
                ContenidosEliminar($_GET["Id"]);
                break;
            case "Guardar":
                ContenidosGuardar($_POST["txtId"], $_POST["nombre"], $_POST["idscategorias"], $_POST["contenido"], $_FILES["foto"], $_POST["url_informacion"], $_POST["estado"]);
                break;
            default:
                header("Location: contenidos_listar.php");
                break;
        }
        ?>
    </body>
</html>