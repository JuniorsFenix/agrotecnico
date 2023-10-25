<?
	include("../../herramientas/seguridad/seguridad.php");
	include("especificaciones_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: especificaciones_listar.php");
	}
?>
<html>
	<head>
		<title>Administraci�n de Im�genes</title>
		<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
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
		
        $Archivo = $_FILES['txtImagen']['name'];
        if ( empty($Archivo) )
        {
          CabezotesGuardar($_POST["txtId"],$_POST["nombre"],$_POST["url"],"",$_POST["target"]);
          exit;
        }
			
		  $NomImagen = $_FILES['txtImagen']['name'];

		  include("../../herramientas/upload/SimpleImage.php");
		  $image = new SimpleImage();
		  $image->load($_FILES['txtImagen']['tmp_name']);
		  $image->resizeToWidth(200);
			  
		   for ($n=1; file_exists($cRutaImagenEspec . $NomImagen); $n++)
			{
			$NomImagen = '['.$n.']' . "_" . "eyd" . "_" . $_FILES["txtImagen"]["name"];
			}
				
		  $image->save($cRutaImagenEspec . $NomImagen);
		  
		  CabezotesGuardar($_POST["txtId"],$_POST["nombre"],$_POST["url"],$NomImagen,$_POST["target"]);
		break;
		default:
			header("Location: especificaciones_listar.php");
			break;
	}
?>
</body>
</html>

