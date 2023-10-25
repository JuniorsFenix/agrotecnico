<?
	include("../../herramientas/seguridad/seguridad.php");
	include("estilos_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: estilos_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de Estilos</title>
		<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
			EstilosFormNuevo();
		break;
		case "Editar":
			EstilosFormEditar($_GET["Id"]);
		break;
		case "Eliminar":
			EstilosEliminar($_GET["Id"]);
		break;
		case "Guardar":
			EstilosGuardar($_POST,$_FILES);
		break;
		default:
			header("Location: estilos_listar.php");
			break;
	}
?>
</body>
</html>