<?
include("../../herramientas/seguridad/seguridad.php");
include("diremp_zonas_funciones.php");
include("../../vargenerales.php");
if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista
    header("Location: diremp_zonas_listar.php");
}
?>
<html>
    <head>
        <title>Administraci&oacute;n de Zonas de Directorio Empresarial</title>
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
<? include("../../system_menu.php"); ?><br>
        <?
        /* Determinar si viene el parametro que establece una accion:
          Adicionar  = Nuevo Registro
          Editar     = Editar Registro
          Eliminar   = Eliminar Registro
          Si no esta determinada la variable accion entonces se muestra la grilla con los registros
         */
        switch ($_GET["Accion"]) {
            case "Adicionar":
                dirempZonasFormNuevo();
                break;
            case "Editar":
                dirempZonasFormEditar($_GET["Id"]);
                break;
            case "Eliminar":
                dirempZonasEliminar($_GET["Id"]);
                break;
            case "Guardar":
                dirempZonasGuardar($_POST["txtId"], $_POST["nombre"]);
                break;
            default:
                header("Location: diremp_zonas_listar.php");
                break;
        }
        ?>
    </body>
</html>

