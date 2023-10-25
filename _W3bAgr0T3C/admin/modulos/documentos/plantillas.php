<?
  include("../../herramientas/FCKeditor/fckeditor.php") ;
  include("../../herramientas/seguridad/seguridad.php");
  include("plantillas_funciones.php");
  include("../../herramientas/upload/uploaderFunction.php");
  include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: plantillas_listar.php");
  }
?>
<html>
	<head>
		<title>Administración de plantillas</title>
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
  /* Determinar si biene el parametro que establece una accion:
     Adicionar  = Nuevo Registro
     Editar     = Editar Registro
     Eliminar   = Eliminar Registro
     Si no esta determinada la variable accion entonces se muestra la grilla con los registros
  */
	switch($_GET["Accion"]) {
		case  "Adicionar":
			plantillasFormNuevo();
		break;
		case "Editar":
			plantillasFormEditar($_GET["Id"]);
		break;
		case "Eliminar":
			plantillasEliminar($_GET["Id"]);
		break;
		case "Guardar":
			// Subo el archivo al servidor, si es correcto almaceno el registro
			# Comprobamos que el campo file no venga vacio.
			
			$NomImagen="*";
			    
			if( isset( $_FILES["txtImagen"]["tmp_name"] ) && $_FILES["txtImagen"]["tmp_name"]!="" ) {
				$nombre_File = $_FILES["txtImagen"]["name"];
				$folder = $cRutaPlantillas;
		            
				if(move_uploaded_file($_FILES["txtImagen"]["tmp_name"],$folder.$nombre_File)) {
					$NomImagen = $nombre_File;
				}
				else {
					Mensaje("Fallo cargando plantilla","plantillas_listar.php");
				}
				
			}
			plantillasGuardar($_POST["txtId"],$_POST["titulo"],$NomImagen);
			header("Location: plantillas_listar.php");
			break;
		default:
			header("Location: plantillas_listar.php");
			break;
	}
?>
</body>
</html>

