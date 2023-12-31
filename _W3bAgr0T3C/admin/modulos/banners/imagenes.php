<?
	include("FCKeditor/fckeditor.php") ;
	include("seguridad.php");
	include("imagenes_funciones.php");
	include("uploaderFunction.php");
	include("vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: imagenes_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de Imagenes</title>
		<link href="administrador.css" rel="stylesheet" type="text/css">

<script src="../../herramientas/ckeditor/ckeditor.js"></script>
	</head>
<body>
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
        ImagenesFormNuevo();
        break;
      case "Editar":
        ImagenesFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        ImagenesEliminar($_GET["Id"]);
        break;
      case "Guardar":
        // Subo el archivo al servidor, si es correcto almaceno el registro
        # Comprobamos que el campo file no venga vacio.
        $ArchivoImg 	= $_FILES['txtImagen']['name'][0];
				
				$NomImagen = "*"; // * Indica que no se asigno un archivo
				
        if ( !empty($ArchivoImg) )
        {
					$tipos = array("image/jpeg","image/gif","image/pjpeg","image/png","application/x-shockwave-flash");
					$size = 400000;
					$Campofile = "txtImagen";
					$folder = $cRutaImgGaleria;
					if(uploader($Campofile,$folder,$size,$tipos))
					{
						foreach ($uploader_archivos_copiados as $imagen => $detalles)
						{
							$NomImagen = $imagen ;
						}
					}
        }
				
				ImagenesGuardar($_POST["txtId"],$_POST["cboCategorias"],$_POST["txtDetalle"],$NomImagen,$_POST["optPublicar"]);				
				
        break;
      default:
        header("Location: imagenes_listar.php");
        break;
    }
?>
</body>
</html>

