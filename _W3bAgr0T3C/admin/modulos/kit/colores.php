<?
	include("../../herramientas/seguridad/seguridad.php");
	include("colores_funciones.php");
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
<!--
body {
	margin-top: 0px;
	margin-bottom:0px;
	margin-left:0px;
	margin-right:0px;
}
-->
</style>
    <link href="../../herramientas/color/css/colorpicker.css" rel="stylesheet" media="screen" type="text/css" />
<script type="text/javascript" src="../../herramientas/color/js/jquery.js"></script>
<script type="text/javascript" src="../../herramientas/color/js/colorpicker.js"></script>
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
          	CabezotesGuardar($_POST["txtId"],$_POST["nombre"],$_POST["color"]);
          exit;
		default:
			header("Location: colores_listar.php");
			break;
	}
?>
</body>
</html>

