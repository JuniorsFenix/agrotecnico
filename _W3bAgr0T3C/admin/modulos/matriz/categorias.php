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
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="jqueryui/themes/base/jquery-ui.css" />
		<script type="text/javascript" src="bootstrap/js/jquery.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
<body>
<?php include("../../system_menu.php"); ?><br>
<?php
	switch($_GET["Accion"]) {
		case  "Adicionar":
			CategoriasForm();
		break;
		case "Editar":
			CategoriasForm($_GET["Id"]);
		break;
		case "Eliminar":
			CategoriasEliminar($_GET["Id"]);
		break;
		case "Guardar":
			CategoriasGuardar($_POST, $_FILES);
		break;
		default:
			header("Location: categorias_listar.php");
			break;
	}
?>
</body>
</html>