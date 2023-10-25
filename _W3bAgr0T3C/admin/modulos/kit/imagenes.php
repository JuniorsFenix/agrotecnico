<?
	include("../../herramientas/seguridad/seguridad.php");
	include("imagenes_funciones.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: cabezotes_listar.php");
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
<? include("../../system_menu.php"); ?><br>
<?
	switch($_GET["Accion"]) {
		case  "Adicionar":
			ImagenesFormNuevo();
		break;
		case "Editar":
			ImagenesFormEditar($_GET["Id"]);
		break;
		case "Eliminar":
			ImagenesEliminar($_GET["Id"]);
		break;
		case "Guardar":
			// Subo el archivo al servidor, si es correcto almaceno el registro
			# Comprobamos que el campo file no venga vacio.
			//die(print_r($_FILES,1));
			$ArchivoImg = $_FILES['txtImagen']['name'];
			$NomImagen = "*";
			
			
			if ( !empty($ArchivoImg) ) {
			
				$NomImagen = $ArchivoImg;
	
			  require_once("../../herramientas/upload/SimpleImage.php");
			  $image = new SimpleImage();
			  $image->load($_FILES['txtImagen']['tmp_name']);
			  $image->save($cRutaKit . $NomImagen);
			}
			ImagenesGuardar($_POST["txtId"],$NomImagen,$_POST["nombre"]);
		break;
		default:
			header("Location: imagenes_listar.php");
			break;
	}
?>
</body>
</html>

