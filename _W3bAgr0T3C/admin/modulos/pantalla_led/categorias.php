<?
	include("../../herramientas/FCKeditor/fckeditor.php") ;
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
			CategoriasFormNuevo();
		break;
		case "Editar":
			CategoriasFormEditar($_GET["Id"]);
		break;
		case "Eliminar":
			CategoriasEliminar($_GET["Id"]);
		break;
		case "Guardar":
			CategoriasGuardar($_POST["txtId"],$_POST["nombre"],$_POST["width"],$_POST["height"],$_POST["velocidad"]);
		break;
		default:
			header("Location: categorias_listar.php");
			break;
	}
?>
</body>
</html>