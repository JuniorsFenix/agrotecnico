<?
	include("../../herramientas/seguridad/seguridad.php");
	include("funciones_pedidos.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: pedidos_listar.php");
	}
?>
<html>
  <head>
    <title>Administración de Contenidos Generales</title>
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
        PedidosFormNuevo();
        break;
      case "Editar":
        PedidosFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        PedidosEliminar($_GET["Id"]);
        break;
      case "Guardar":
         PedidosGuardar($_POST);
        break;
      default:
        header("Location: listar.php");
        break;
    }
?>
</body>
</html>