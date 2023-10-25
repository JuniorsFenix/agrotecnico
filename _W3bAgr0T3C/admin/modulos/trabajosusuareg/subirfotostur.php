<?  
  //include("../../herramientas/FCKeditor/fckeditor.php") ;
  include("seguridad2.php");
  include("funciones_subirfotostur.php");
  //include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: cabeceratur.php");
  }
?>
<html>
	<head>
		<title>Registrados Estilo y Diseño</title>
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
      case "Guardar":
	  {
		SubirFotosturGuardar($_POST,$_FILES);
		}
		break;
      default:
        header("Location: cabeceratur.php");
        break;
    }
?>
</body>
</html>

