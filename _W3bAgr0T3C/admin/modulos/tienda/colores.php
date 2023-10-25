<?
	include("../../herramientas/seguridad/seguridad.php");
	include("colores_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: colores_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de Colores</title>
		<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
<style type="text/css">
</style>
    <link href="../../herramientas/color/css/colorpicker.css" rel="stylesheet" media="screen" type="text/css" />
	</head>
<body>
<? include("../../system_menu.php"); ?><br>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="../../herramientas/color/js/colorpicker.js"></script>
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
          	CabezotesGuardar($_POST["txtId"],$_POST["nombre"],$_POST["color"]);
          exit;
		default:
			header("Location: colores_listar.php");
			break;
	}
?>
</body>
</html>

