<?
	include("../../herramientas/seguridad/seguridad.php");
	include("banners_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: banners_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de Banners</title>
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
<script language="javascript">
function apagar_url_newwindo(){
document.frm.txtDirWeb.disabled = true;
}
function prender_url_newwindo(){
document.frm.txtDirWeb.disabled = false;
}
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
        BannersFormNuevo();
        break;
      case "Editar":
        BannersFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        BannersEliminar($_GET["Id"]);
        break;
      case "Guardar":
        // Subo el archivo al servidor, si es correcto almaceno el registro
        # Comprobamos que el campo file no venga vacio.
        $Archivo 	= $_FILES['txtBanner']['name'][0];
				$NomArchivo = "*"; // * Indica que no se asigno un archivo
        if ( !empty($Archivo) )
        {
					$tipos = array("image/jpeg","image/gif","image/pjpeg","image/png","application/x-shockwave-flash");
					$size = 20000000;
					$Campofile = "txtBanner";
					$folder = $cRutaBanners;
					if(uploader($Campofile,$folder,$size,$tipos))
					{
						foreach ($uploader_archivos_copiados as $imagen => $detalles)
						{
							$NomArchivo = $imagen ;
						}
					}
        }
				BannersGuardar($_POST["txtId"],$_POST["cboBloques"],$_POST["cboTipo"],$NomArchivo,$_POST["txtDirWeb"],$_POST["optPublicar"],$_POST["NewWindow"]);				
        break;
      default:
        header("Location: banners_listar.php");
        break;
    }
?>
</body>
</html>

