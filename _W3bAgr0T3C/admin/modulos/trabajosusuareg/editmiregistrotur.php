<?
  include("seguridad2.php");
  include("funciones_editmiregistrotur.php");
  //include("../../herramientas/upload/uploaderFunction.php");
  //include("../../funciones_generales.php");
	include("../../vargenerales.php");
	  
	$IdUsuario =  $_SESSION["UsrId"];
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
   header("Location: cabeceratur.php");
  }
?>
<html>
	<head>
		<title>Edicion de Registros</title>
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
      case "Editar":
        RegistroEditar($_GET["Id"]);
        break;
	  case "Guardar":
        RegistroGuardar($_GET["Id"]);
        break;
      default:
        header("Location: cabeceratur.php");
        break;
    }
?>
</body>
</html>

