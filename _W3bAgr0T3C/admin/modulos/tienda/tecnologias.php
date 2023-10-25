<?
	include("../../herramientas/seguridad/seguridad.php");
	include("tecnologias_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: tecnologias_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de Imágenes</title>
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
<script src="../../herramientas/ckeditor/ckeditor.js"></script>
	</head>
<body>
<? include("../../system_menu.php"); ?><br>
<?
	switch($_GET["Accion"]) {
		case  "Adicionar":
			CabezotesFormNuevo();
		break;
		case "Editar":
			CabezotesFormEditar($_GET["Id"]);
		break;
		case "Eliminar":
			CabezotesEliminar($_GET["Id"]);
		break;
		case "Guardar":
          	CabezotesGuardar($_POST["txtId"],$_POST["nombre"],$_POST["descripcion"]);
          exit;
		default:
			header("Location: tecnologias_listar.php");
			break;
	}
?>
</body>
</html>

