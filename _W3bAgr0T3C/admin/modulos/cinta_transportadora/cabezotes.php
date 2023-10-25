<?
	include("../../herramientas/seguridad/seguridad.php");
	include("cabezotes_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
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
			CabezotesFormNuevo();
		break;
		case "Editar":
			CabezotesFormEditar($_GET["Id"]);
		break;
		case "Eliminar":
			CabezotesEliminar($_GET["Id"]);
		break;
		case "Guardar":
			// Subo el archivo al servidor, si es correcto almaceno el registro
			# Comprobamos que el campo file no venga vacio.
			//die(print_r($_FILES,1));
			$ArchivoImg = $_FILES['txtImagen']['name'][0];
			
			$NomImagen = "*"; // * Indica que no se asigno un archivo
			
			if ( !empty($ArchivoImg) ) {
				$tipos = array("image/png","image/jpeg","image/gif","image/pjpeg","image/png","application/x-shockwave-flash");
				$size = 400000;
				$Campofile = "txtImagen";
				$folder = $cRutaImgCinta;
				if(uploader($Campofile,$folder,$size,$tipos)) {
					foreach ($uploader_archivos_copiados as $imagen => $detalles) {
						$NomImagen = $imagen ;
					}
				}
			}
			CabezotesGuardar($_POST["txtId"],$_POST["url"],$_POST["target"],$NomImagen,$_POST["idcategoria"]);
		break;
		default:
			header("Location: cabezotes_listar.php");
			break;
	}
?>
</body>
</html>

