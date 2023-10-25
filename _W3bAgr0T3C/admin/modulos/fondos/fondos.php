<?
	include("../../herramientas/seguridad/seguridad.php");
	include("fondos_funciones.php");
	include("../../herramientas/upload/SimpleImage.php");
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
			FondosFormNuevo();
		break;
		case "Editar":
			FondosFormEditar($_GET["Id"]);
		break;
		case "Eliminar":
			FondosEliminar($_GET["Id"]);
		break;
		case "Guardar":
			// Subo el archivo al servidor, si es correcto almaceno el registro
			# Comprobamos que el campo file no venga vacio.
			//die(print_r($_FILES,1));
			$ArchivoImg = $_FILES['txtImagen']['name'][0];
			
			$NomImagen = "*"; // * Indica que no se asigno un archivo
			
			if ( !empty($ArchivoImg) ) {				
			  $NomImagen = $ArchivoImg;
			  $image = new SimpleImage();
			  $image->load($_FILES["txtImagen"]["tmp_name"][0]);
			  $image->resizeToWidth(1600);
			  $image->save($cRutaImgFondos . $NomImagen);
			}
			FondosGuardar($_POST["txtId"],$NomImagen,$_POST["idcategoria"]);
		break;
		default:
			header("Location: fondos_listar.php");
			break;
	}
?>
</body>
</html>

