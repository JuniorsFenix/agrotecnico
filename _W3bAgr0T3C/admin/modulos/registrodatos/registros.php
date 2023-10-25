<?
  include("../../herramientas/FCKeditor/fckeditor.php") ;
  include("../../herramientas/seguridad/seguridad.php");
  include("registros_funciones.php");
  include("../../herramientas/upload/uploaderFunction.php");
  include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: registros_listar.php");
  }
?>
<html>
	<head>
		<title>Administración de Registro de Datos</title>
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
			RegistrosFormNuevo();
		break;
		case "Editar":
			RegistrosFormEditar($_GET["Id"]);
		break;
		case "Eliminar":
			RegistrosEliminar($_GET["Id"]);
		break;
		case "Guardar":
			RegistrosGuardar($_POST["txtId"],$_POST);
			break;
		default:
			header("Location: registros_listar.php");
			break;
	}
?>
</body>
</html>

