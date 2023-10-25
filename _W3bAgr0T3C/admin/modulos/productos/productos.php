<?
	include("../../herramientas/FCKeditor/fckeditor.php") ;
	include("../../herramientas/seguridad/seguridad.php");
	include("productos_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: productos_listar.php");
	}
	
?>
<html>
	<head>
		<title>Administración de Glosario</title>
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
    switch($_GET["Accion"])
    {
      case  "Adicionar":
        ProductosFormNuevo();
        break;
      case "Editar":
        ProductosFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        ProductosEliminar($_GET["Id"]);
        break;
      case "Guardar":
        // Subo el archivo al servidor, si es correcto almaceno el registro
        # Comprobamos que el campo file no venga vacio.
        $ArchivoImg 		= $_FILES['txtImagen']['name'][0];
		$ArchivoFlash		= $_FILES['txtEncFlash']['name'][0];
		$ArchivoAdjunto	= $_FILES['txtAdjunto']['name'][0];
		
		$NomImagen = "*"; // * Indica que no se asigno un archivo
		$NomFlash  = "*"; // * Indica que no se asigno un archivo
		$NomAdjunto= "*"; // * Indica que no se asigno un archivo
				
        if ( !empty($ArchivoImg) )
        {
			$tipos = array("image/jpeg","image/gif","image/pjpeg","image/png","application/x-shockwave-flash");
			$size = 400000;
			$Campofile = "txtImagen";
			$folder = $cRutaImgProductos;
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
				$folder = $cRutaImgProductos;
				if(uploader($Campofile,$folder,$size,$tipos))
				{
					foreach ($uploader_archivos_copiados as $imagen => $detalles)
					{
						$NomFlash = $imagen ;
					}
				}
			}
			
			if ( !empty($ArchivoAdjunto) )
			{
				$tipos = array("image/jpeg","image/gif","image/pjpeg","image/png","application/x-shockwave-flash","application/pdf","application/msword","application/vnd.ms-excel","audio/mpeg3","video/mpeg","video/x-motion-jpeg");
				$size = 50000000;
				$Campofile = "txtAdjunto";
				$folder = $cRutaImgProductosPequenia;
				if(uploader($Campofile,$folder,$size,$tipos))
				{
					foreach ($uploader_archivos_copiados as $imagen => $detalles)
					{
						$NomAdjunto = $imagen ;
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

			if ( $NomAdjunto == "*" )
			{
				$NomAdjunto = "";
			}

			ProductosGuardar($_POST["txtId"],$_POST["cboCategorias"],$_POST["txtProducto"],$_POST["txtDetalle"],$_POST["txtPrecio"],$NomImagen,$NomFlash,$NomAdjunto,$_POST["optPublicar"],$_POST["optCarrito"],$_POST["cboOpciones"]);
        break;
      default:
        header("Location: productos_listar.php");
        break;
    }
?>
</body>
</html>