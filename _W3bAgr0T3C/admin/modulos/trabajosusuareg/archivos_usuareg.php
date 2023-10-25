<?
	include("../../herramientas/FCKeditor/fckeditor.php") ;
  include("../../herramientas/seguridad/seguridad.php");
  include("archivos_usuareg_funciones.php");
  include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: archivos_usuareg_listar.php");
  }
?>
<html>
	<head>
		<title>Administración de Archivos</title>
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
        ArchivosUsuaregFormNuevo();
        break;
      case "Editar":
        ArchivosUsuaregFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        ArchivosUsuaregEliminar($_GET["Id"]);
        break;
      case "Guardar":
        // Subo el archivo al servidor, si es correcto almaceno el registro
        # Comprobamos que el campo file no venga vacio.
				$ArchivoAdjunto	= $_FILES['txtAdjunto']['name'][0];
				
				$NomAdjunto= "*"; // * Indica que no se asigno un archivo
				
				if ( !empty($ArchivoAdjunto) )
				{
					$tipos = array("image/jpeg","image/gif","image/pjpeg","application/x-shockwave-flash","application/pdf","application/msword","application/vnd.ms-excel","audio/mpeg3","video/mpeg","video/x-motion-jpeg");
					$size = 50000000;
					$Campofile = "txtAdjunto";
					$folder = $cRutaImgFotostur;
					if(uploader($Campofile,$folder,$size,$tipos))
					{
						foreach ($uploader_archivos_copiados as $imagen => $detalles)
						{
							$NomAdjunto = $imagen ;
						}
					}
				}
				
				if ( $NomAdjunto == "*" )
				{
					$NomAdjunto = "";
				}

				ArchivosGuardar($_POST["txtId"],$_POST["cboIdlogin"],$NomAdjunto);
        break;
      default:
        header("Location: archivos_usuareg_listar.php");
        break;
    }
?>
</body>
</html>

