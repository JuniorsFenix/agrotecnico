<?
  include("../../herramientas/seguridad/seguridad.php");
  include("imagenes_cli_funciones.php");
  include("../../herramientas/upload/uploaderFunction.php");
  include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: imagenes_cli_listar.php");
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
					$tipos = array("image/jpeg","image/gif","image/pjpeg","application/x-shockwave-flash");
					$size = 400000;
					$Campofile = "txtImagen";
					$folder = $cRuraImgClientes;
					if(uploader($Campofile,$folder,$size,$tipos))
					{
						foreach ($uploader_archivos_copiados as $imagen => $detalles)
						{
							$NomImagen = $imagen ;
						}
					}
        }
				ImagenesGuardar($_POST["txtId"],$_POST["idcliente"],$_POST["txtDescripcion"],$NomImagen);	
        break;
      default:
        header("Location: clientes_img_listar.php");
        break;
    }
?>
</body>
</html>

