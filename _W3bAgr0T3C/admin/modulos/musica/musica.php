<?
  include("../../herramientas/seguridad/seguridad.php");
  include("funciones.php");
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
        MusicaFormNuevo();
        break;
      case "Editar":
        MusicaFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        MusicaEliminar($_GET["Id"]);
        break;
      case "Guardar":
        $Archivo = $_FILES['txtImagen']['name'][0];
        if ( empty($Archivo) )
        {
          MusicaGuardar($_POST["txtIdMusica"],$_POST["txtIdCategoria"],$_POST["txtNombre"],$_POST["txtPais"],$_POST["txtCiudad"],$_POST["txtArtista"],$_POST["txtGenero"],$_POST["txtDuracion"],$_POST["txtOrden"],"",$_FILES["archivo"]);
          exit;
        }
		
		  $NomImagen = "eyd" . "_" . $_FILES['txtImagen']['name'];

		  include("../../herramientas/upload/SimpleImage.php");
		  $image = new SimpleImage();
		  $image->load($_FILES['txtImagen']['tmp_name']);
		  $image->resizeToWidth(400);
			  
		   for ($n=1; file_exists($cRutaImgMusica . $NomImagen); $n++)
			{
			$NomImagen = '['.$n.']' . "_" . "eyd" . "_" . $_FILES["txtImagen{$i}"]["name"];
			}
				
		  $image->save($cRutaImgMusica . $NomImagen);
		  
            
          MusicaGuardar($_POST["txtIdMusica"],$_POST["txtIdCategoria"],$_POST["txtNombre"],$_POST["txtPais"],$_POST["txtCiudad"],$_POST["txtArtista"],$_POST["txtGenero"],$_POST["txtDuracion"],$NomImagen,$_FILES["archivo"]);
        break;
      default:
        header("Location: listar.php");
        break;
    }
?>
</body>
</html>