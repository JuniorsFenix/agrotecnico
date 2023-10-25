<?
	include("../../herramientas/seguridad/seguridad.php");
	include("cupones_funciones.php");
	include("../../vargenerales.php");
	$IdCategoria = $_GET["idcategoria"];
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: cupones_listar.php");
	}
?>
<html>
  <head>
    <title>Administración de Cupones</title>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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
        ProductosFormNuevo($IdCategoria);
        break;
      case "Editar":
        ProductosFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        ProductosEliminar($_GET["Id"]);
        break;
      case "Guardar":
         ProductosGuardar($_POST);
        break;
      default:
        header("Location: cupones_listar.php?idcategoria={$IdCategoria}");
        break;
    }
?>
</body>
</html>