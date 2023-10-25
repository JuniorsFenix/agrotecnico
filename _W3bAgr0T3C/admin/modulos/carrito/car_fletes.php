<?
  include("../../herramientas/seguridad/seguridad.php");
  include("car_fletes_funciones.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: car_clientes_listar.php");
  }
?>
<html>
	<head>
		<title>Administración de Fletes</title>
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
        CarFletesFormNuevo();
        break;
      case "Editar":
        CarFletesFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        CarFletesEliminar($_GET["Id"]);
        break;
      case "Guardar":
      	CarFletesGuardar($_POST["txtId"],$_POST["txtTitulo"],$_POST["txtPrecio"]);
        break;
      default:
        header("Location: car_fletes_listar.php");
        break;
    }
?>
</body>
</html>

