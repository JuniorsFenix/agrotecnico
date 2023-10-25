<?php
	include("../../herramientas/seguridad/seguridad.php");
	include("plantillas_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: plantillas_listar.php");
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
	</head>
<body>
<?php include("../../system_menu.php"); ?><br>
<?php
	switch($_GET["Accion"]) {
		case  "Adicionar":
			plantillasFormNuevo();
		break;
		case "Editar":
			plantillasFormEditar($_GET["Id"]);
		break;
		case "Eliminar":
			plantillasEliminar($_GET["Id"]);
		break;
		case "Guardar":
			plantillasGuardar($_POST,$_FILES);
		break;
		default:
			header("Location: plantillas_listar.php");
			break;
	}
?>
</body>
</html>

