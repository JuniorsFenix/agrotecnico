<?
	include("../../herramientas/seguridad/seguridad.php");
	include("archivos_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: archivos_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de Archivos</title>
		<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<link href="dropzone.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="../../herramientas/ckeditor/ckeditor.js"></script>
<script src="../../herramientas/dropzone/dropzone.js"></script>
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
    switch($_GET["Accion"])
    {
      case  "Adicionar":
        ArchivosFormNuevo();
        break;
      case "Editar":
        ArchivosFormEditar($_GET["Id"],$_GET["ciudad"]);
        break;
      case "Eliminar":
        ArchivosEliminar($_GET["Id"]);
        break;
      case "Guardar":
        // Subo el archivo al servidor, si es correcto almaceno el registro
        # Comprobamos que el campo file no venga vacio.
		if(isset($_FILES['file'])){
			foreach ($_POST['titulo'] as $row=>$key)
			{
     
			$tempFile = $_FILES['file']['tmp_name'][$row];
			
			$NomAdjunto = $_FILES['file']['name'][$row];
			
			$ext = pathinfo($NomAdjunto, PATHINFO_EXTENSION);
			
			$titulo = $_POST['titulo'][$row];
			
			setlocale(LC_ALL, 'en_US.UTF8');
			
			$descripcion = $_POST['descripcion'][$row];
			
			$url = $_POST['archivo'];
			
			if ( !empty($NomAdjunto) )
			{
			$url = slug($titulo).".".$ext;
			    
			$targetFile =  $cRutaArchivos. $url;
		 
			move_uploaded_file($tempFile,$targetFile);
			$_POST["optPublicar"] = "S";
			}
		
			
		ArchivosGuardar($_POST["txtId"],$_POST["cboCategorias"],$titulo,$descripcion,$url,$_FILES["imagen"],$_POST["optPublicar"],$_POST["cboCiudades"]);
			}
		}

        break;
      default:
        header("Location: archivos_listar.php");
        break;
    }
?>
</body>
</html>

