<?php
  include("../../herramientas/seguridad/seguridad.php");
  include("categorias_funciones.php");
  include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: categorias_listar.php");
  }
?>
<html>
	<head>
		<title>Administración de Categorias</title>
		<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
<body>
<?php include("../../system_menu.php"); ?><br>
<?php
	switch($_GET["Accion"]) {
		case  "Adicionar":
			CategoriasFormNuevo();
		break;
		case "Editar":
			CategoriasFormEditar($_GET["Id"]);
		break;
		case "Eliminar":
			CategoriasEliminar($_GET["Id"]);
		break;
		case "Guardar":
			CategoriasGuardar($_POST["txtId"],$_POST["nombre"],$_POST["opacidad"],$_POST["textura"]);
		break;
		default:
			header("Location: categorias_listar.php");
			break;
	}
?>
</body>
</html>

