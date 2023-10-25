<?
  include("../../herramientas/seguridad/seguridad.php");
  include("car_clientes_funciones.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: car_clientes_listar.php");
  }
?>
<html>
	<head>
		<title>Administración de Clientes</title>
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
        CarClientesFormNuevo();
        break;
      case "Editar":
        CarClientesFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        CarClientesEliminar($_GET["Id"]);
        break;
      case "Guardar":
      	CarClientesGuardar($_POST["txtId"],$_POST["txtNombres"],$_POST["txtApellidos"],$_POST["txtDireccion"],$_POST["txtTelefono"],$_POST["txtMail"],$_POST["txtClave"]);
        break;
      default:
        header("Location: car_clientes_listar.php");
        break;
    }
?>
</body>
</html>

