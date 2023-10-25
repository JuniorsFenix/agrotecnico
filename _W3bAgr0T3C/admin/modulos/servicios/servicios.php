<?
	include("../../herramientas/seguridad/seguridad.php");
	include("servicios_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: servicios_listar.php");
	}
	
?>
<html>
	<head>
		<title>Administración de Servicios</title>
		<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<link href="../../herramientas/seocounter.css" rel="stylesheet" type="text/css">
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
<script src="../../herramientas/seocounter.js"></script>
<script src="../../herramientas/ckeditor/ckeditor.js"></script>
<script type="text/javascript"> 
	$(document).ready(function(){
		seocounter();
	}); 
</script>

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
        ServiciosFormNuevo();
        break;
      case "Editar":
        ServiciosFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        ServiciosEliminar($_GET["Id"]);
        break;
      case "Guardar":
        // Subo el archivo al servidor, si es correcto almaceno el registro
        # Comprobamos que el campo file no venga vacio.
        $ArchivoImg 	= $_FILES['txtImagen']['name'][0];
		$ArchivoFlash	= $_FILES['txtEncFlash']['name'][0];
		
		$NomImagen = "*"; // * Indica que no se asigno un archivo
		$NomFlash  = "*"; // * Indica que no se asigno un archivo
				
        if ( !empty($ArchivoImg) )
        {
			$tipos = array("image/jpeg","image/gif","image/pjpeg","image/png","application/x-shockwave-flash");
			$size = 3000000;
			$Campofile = "txtImagen";
			$folder = $cRutaImgServicios;
			if(uploader($Campofile,$folder,$size,$tipos))
			{
				foreach ($uploader_archivos_copiados as $imagen => $detalles)
				{
					$NomImagen = $imagen ;
				}
			}
        }
				
		if ( !empty($ArchivoFlash) )
		{
			$tipos = array("image/jpeg","image/gif","image/pjpeg","image/png","application/x-shockwave-flash");
			$size = 400000;
			$Campofile = "txtEncFlash";
			$folder = $cRutaImgServicios;
			if(uploader($Campofile,$folder,$size,$tipos))
			{
				foreach ($uploader_archivos_copiados as $imagen => $detalles)
				{
					$NomFlash = $imagen ;
				}
			}
		}
		if ( $NomImagen == "*" )
		{
			$NomImagen = "";
		}
		
		if ( $NomFlash == "*" )
		{
			$NomFlash = "";
		}

		ServiciosGuardar($_POST["txtId"],$_POST["cboCategorias"],$_POST["txtServicio"],$_POST["txtDetalle"],$_POST["titulo"],$_POST["metaDescripcion"],$_POST["txtPrecio"],$_POST["txtTags"],$_POST["txtPalabras"],$NomImagen,$NomFlash,$_POST["optPublicar"]);				
				
        break;
      default:
        header("Location: servicios_listar.php");
        break;
    }
?>
</body>
</html>