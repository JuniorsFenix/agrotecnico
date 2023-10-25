<?php
	include("../../herramientas/seguridad/seguridad.php");
	include("cabezotes_funciones.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: cabezotes_listar.php");
	}

  ini_set("memory_limit","128M");
  ini_set("upload_max_filesize", "50M");
  ini_set("max_execution_time","240");//3 MINUTOS
  ini_set("post_max_size","50M");
  ini_set("max_input_time","240");
?>
<html>
	<head>
		<title>Administración de Cabezotes</title>
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
<script src="../../herramientas/ckeditor/ckeditor.js"></script>
	</head>
<body>
<?php include("../../system_menu.php"); ?><br>
<?php
	switch($_GET["Accion"]) {
		case  "Adicionar":
			CabezotesFormNuevo($_GET["Id"]);
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

			if(!empty($_FILES["video"]["tmp_name"])) {
				$video = $_FILES['video']['name'];
				$s = move_uploaded_file( $_FILES["video"]["tmp_name"],$cRutaImgCabezotesjq.$video);
				CabezotesGuardar($_POST["txtId"],$_POST["descripcion"],$_POST["idcategoria"],$_POST["effect"],$_POST["url"],$_POST["target"],"",$video);
				break;
			}
			if (!empty($_FILES['txtImagen']['tmp_name'])) {
			
				$NomImagenG = $_FILES['txtImagen']['name'];
				$NomImagenM = "p-" . $NomImagenG;
	
			  require_once("../../herramientas/upload/SimpleImage.php");
			  $image = new SimpleImage();
			  $image->load($_FILES['txtImagen']['tmp_name']);
			  $image->resizeToWidth(1920);
			  $image->save($cRutaImgCabezotesjq . $NomImagenG);
			  $image->resizeToWidth(250);
			  $image->save($cRutaImgCabezotesjq . $NomImagenM);
			}
			CabezotesGuardar($_POST["txtId"],$_POST["descripcion"],$_POST["idcategoria"],$_POST["effect"],$_POST["url"],$_POST["target"],$NomImagenG,"");
		break;
		default:
			header("Location: cabezotes_listar.php");
			break;
	}
?>
</body>
</html>