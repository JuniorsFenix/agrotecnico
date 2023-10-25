<?
  include("../../herramientas/FCKeditor/fckeditor.php") ;
  include("../../herramientas/seguridad/seguridad.php");
  include("tarjetas_funciones.php");
  include("../../herramientas/upload/uploaderFunction.php");
  include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: tarjetas_listar.php");
  }
?>
<html>
	<head>
		<title>Administración de Tarjetas</title>
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
			TarjetasFormNuevo();
		break;
		case "Editar":
			TarjetasFormEditar($_GET["Id"]);
		break;
		case "Eliminar":
			TarjetasEliminar($_GET["Id"]);
		break;
		case "Guardar":
			// Subo el archivo al servidor, si es correcto almaceno el registro
			# Comprobamos que el campo file no venga vacio.
			
			$NomImagen="*";
			    
			if( isset( $_FILES["txtImagen"]["tmp_name"] ) && $_FILES["txtImagen"]["tmp_name"]!="" ) {
				$nombre_File = $_FILES["txtImagen"]["name"];
				$folder = $cRutaTarjetas;
		            
				if(move_uploaded_file($_FILES["txtImagen"]["tmp_name"],$folder.$nombre_File)) {
					$NomImagen = $nombre_File;
				}
				else {
					Mensaje("Fallo cargando tarjeta","tarjetas_listar.php");
				}
				
			}
			TarjetasGuardar($_POST["txtId"],$_POST["titulo"],$NomImagen);
			header("Location: tarjetas_listar.php");
			break;
		default:
			header("Location: tarjetas_listar.php");
			break;
	}
?>
</body>
</html>

