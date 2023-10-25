<?
	include("../../herramientas/seguridad/seguridad.php");
	include("marcas_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: marcas_listar.php");
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
          CabezotesGuardar($_POST["txtId"],$_POST["nombre"],$_POST["url"],"");
          exit;
        }
			
		  $NomImagen = $_FILES['txtImagen']['name'];

		  include("../../herramientas/upload/SimpleImage.php");
		  $image = new SimpleImage();
		  $image->load($_FILES['txtImagen']['tmp_name']);
		  $image->resizeToWidth(200);
			  
		   for ($n=1; file_exists($cRutaImagenMarcas . $NomImagen); $n++)
			{
			$NomImagen = '['.$n.']' . "_" . "eyd" . "_" . $_FILES["txtImagen"]["name"];
			}
				
		  $image->save($cRutaImagenMarcas . $NomImagen);
		  
		  CabezotesGuardar($_POST["txtId"],$_POST["nombre"],$_POST["url"],$NomImagen);
		break;
		default:
			header("Location: marcas_listar.php");
			break;
	}
?>
</body>
</html>

