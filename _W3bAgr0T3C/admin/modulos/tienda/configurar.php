<?
	include("../../herramientas/seguridad/seguridad.php");
	include("functiones_configuracion.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	$_GET["Accion"]="Editar";
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
        //PedidosFormNuevo();
        break;
      case "Editar":
        ConfiguracionFormEditar();
        break;
      case "Eliminar":
        //PedidosEliminar($_GET["Id"]);
        break;
      case "Guardar":
         ConfiguracionGuardar($_POST);
        break;
      default:
        ConfiguracionFormEditar();
        break;
    }
?>
</body>
</html>