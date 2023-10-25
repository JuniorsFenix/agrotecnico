<?
	include("../../herramientas/seguridad/seguridad.php");
	include("noticias_categorias_funciones.php");
	include("../../vargenerales.php");
	include("../../herramientas/upload/SimpleImage.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista de usuarios
	{
	header("Location: servicios_categorias_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de Categorías - Noticias</title>
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
				// Verifico si existe el parametro IdPadre, si existe envio como parametro los valores IdPadre y NomPadre
				// de lo contrario envio valores en blanco
				if ( !isset( $_GET["IdPadre"] ) )
				{
					CategoriasFormNuevo("0","");
				}
				else
				{
        	CategoriasFormNuevo( $_GET["IdPadre"], $_GET["NomPadre"] );
				}
        break;
      case "Editar":
        CategoriasFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        CategoriasEliminar($_GET["Id"]);
        break;
      case "Guardar":
        $Archivo = $_FILES["txtImagen"]["name"];
        if ( empty($Archivo) )
        {
		CategoriasGuardar($_POST["txtIdPadreActual"],$_POST["txtId"],$_POST["txtIdPadre"],$_POST["txtCategoria"],$_POST["txtDescripcion"],"");
        exit;
		}
		
		$NomImagen = "cat_".$_FILES["txtImagen"]["name"];

		$image = new SimpleImage();
		$image->load($_FILES["txtImagen"]["tmp_name"]);
		$image->resizeToWidth(1600);
		$image->save($cRutaImgNoticias . $NomImagen);
		
		CategoriasGuardar($_POST["txtIdPadreActual"],$_POST["txtId"],$_POST["txtIdPadre"],$_POST["txtCategoria"],$_POST["txtDescripcion"],$NomImagen); 
        break;
      default:
        header("Location: servicios_categorias_listar.php");
        break;
    }

?>
</body>
</html>