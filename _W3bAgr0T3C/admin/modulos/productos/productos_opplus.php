<?
include("../../herramientas/FCKeditor/fckeditor.php");
include("../../herramientas/seguridad/seguridad.php");
include("productos_opplus_funciones.php");
include("../../herramientas/upload/uploaderFunction.php");
include("../../vargenerales.php");
if (!isset ($_GET["Accion"])){
header("Location: productos__opplus_listar.php");
}
?>
<html>
<head>
<title>Administración de Opciones - Productos</title>
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
  /* Determinar si biene el parametro que establece una accion:
     Adicionar  = Nuevo Registro
     Editar     = Editar Registro
     Eliminar   = Eliminar Registro
     Si no esta determinada la variable accion entonces se muestra la grilla con los registros
  */
    switch($_GET["Accion"])
    {
      case  "Adicionar":
        ProductosOpPlusFormNuevo();
        break;
      case "Editar":
        ProductosOpPlusFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        ProductosOpPlusEliminar($_GET["Id"]);
        break;
      case "Guardar":
				ProductosOpPlusGuardar($_POST["txtId"],$_POST["txtDescripcion"],$_POST["txtTitulo"],$_POST["optPublicar"]);
        break;
      default:
        header("Location: productos__opplus_listar.php");
        break;
    }
?>
</body>
</html>