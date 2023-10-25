<?
	include("../../herramientas/seguridad/seguridad.php");
	include("cuerdas_funciones.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: cuerdas_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de Cuerdas</title>
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
	switch($_GET["Accion"]) {
		case  "Adicionar":
			CuerdasFormNuevo();
		break;
		case "Editar":
			CuerdasFormEditar($_GET["Id"]);
		break;
		case "Eliminar":
			CuerdasEliminar($_GET["Id"]);
		break;
		case "Guardar":
          CuerdasGuardar($_POST["txtId"],$_POST["nombre"],$_POST["url"]);
		break;
		default:
			header("Location: cuerdas_listar.php");
			break;
	}
?>
</body>
</html>

