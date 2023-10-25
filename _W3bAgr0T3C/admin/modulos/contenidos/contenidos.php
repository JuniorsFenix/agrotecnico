<?php  ini_set('memory_limit','256M');
	error_reporting(E_ALL ^ E_NOTICE);
	include("../../herramientas/seguridad/seguridad.php");
	include("contenidos_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	include("../../herramientas/upload/SimpleImage.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: contenidos_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de Contenidos Generales</title>
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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
        ContenidosFormNuevo();
        break;
      case "Editar":
        ContenidosFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        ContenidosEliminar($_GET["Id"]);
        break;
      case "Guardar":
        $Archivo = $_FILES["txtImagen"]["name"];
        if ( empty($Archivo) )
        {
          ContenidosGuardar($_POST["txtId"],$_POST["txtTitulo"],$_POST["txtContenido"],"",$_POST["optPublicar"],$_POST["optHome"],$_POST["optNosotros"]);
          exit;
        }
		
		$NomImagenG = $_FILES["txtImagen"]["name"];
		$NomImagenM = "m_" . $_FILES["txtImagen"]["name"];

	  $image = new SimpleImage();
	  $image->load($_FILES["txtImagen"]["tmp_name"]);
	  $image->resizeToWidth(1600);
	  $image->save($cRutaImgContenidos . $NomImagenG);
	  $image->resizeToWidth(500);
	  $image->save($cRutaImgContenidos . $NomImagenM);
	  
            ContenidosGuardar($_POST["txtId"],$_POST["txtTitulo"],$_POST["txtContenido"],$NomImagenG,$_POST["optPublicar"],$_POST["optHome"],$_POST["optNosotros"]);

        break;
      default:
        header("Location: contenidos_listar.php");
        break;
    }
?>
</body>
</html>