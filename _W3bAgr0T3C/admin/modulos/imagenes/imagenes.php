<?
	include("../../herramientas/seguridad/seguridad.php");
	include("imagenes_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: imagenes_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de Imagenes</title>
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
<? include("../../system_menu.php"); ?><br>
<?
  /* Determinar si biene el parametro que establece una accion:
     Adicionar  = Nuevo Registro
     Editar     = Editar Registro
     Eliminar   = Eliminar Registro
     Si no esta determinada la variable accion entonces se muestra la grilla con los registros
  */
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
			$NomImagenG= "*";
			$ArchivoImg = $_FILES['txtImagen']['name'];
			if ( !empty($ArchivoImg) ) {
			
				$NomImagenG = $ArchivoImg;
				$NomImagenM = "m_" . $ArchivoImg;
	
			  require_once("../../herramientas/upload/SimpleImage.php");
			  $image = new SimpleImage();
			  $image->load($_FILES['txtImagen']['tmp_name']);
			  $image->resizeToWidth(1440);
			  $image->save($cRutaImgGaleria . $NomImagenG);
			  $image->resizeToWidth(500);
			  $image->save($cRutaImgGaleria . $NomImagenM);
			}
			
			ImagenesGuardar($_POST["txtId"],$_POST["cboCategorias"],$_POST["txtDetalle"],$NomImagenG,$_POST["optPublicar"]);					
		break;
		case "GuardarVarias":
			
			$NomImagenG= "*";
			for($i=0;$i<10;$i++){
			    
			if( isset( $_FILES["txtImagen{$i}"]["tmp_name"] ) && $_FILES["txtImagen{$i}"]["tmp_name"]!="" ) {
			
				$NomImagenG = $_FILES["txtImagen{$i}"]["name"];
				$NomImagenM = "m_" . $NomImagenG;
	
			  require_once("../../herramientas/upload/SimpleImage.php");
			  $image = new SimpleImage();
			  $image->load($_FILES["txtImagen{$i}"]["tmp_name"]);
			  $image->resizeToWidth(1440);
			  $image->save($cRutaImgGaleria . $NomImagenG);
			  $image->resizeToWidth(500);
			  $image->save($cRutaImgGaleria . $NomImagenM);
				
				
				ImagenesGuardar(0,$_POST["cboCategorias"],$_POST["txtDetalle{$i}"],$NomImagenG,$_POST["optPublicar{$i}"],true);	
			}
				
			}
			header("Location: imagenes_listar.php");
			break;
			
		default:
			header("Location: imagenes_listar.php");
			break;
	}
?>
</body>
</html>