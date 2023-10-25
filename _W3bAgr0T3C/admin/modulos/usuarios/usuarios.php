<?
  include("../../herramientas/seguridad/seguridad.php");
  include("usuarios_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista de usuarios
  {
    header("Location: usuarios_listar.php");
  }
?>
<html>
	<head>
		<title>--Administración de Usuarios--</title>
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

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
<body>
<? include("../../system_menu.php"); ?><br>
<?
  /* Determinar si biene el parametro que establece una accion:
     Adicionar  = Nuevo Registro     Ejemplo: usuarios.php?Accion=adicionar
     Editar     = Editar Registro    Ejemplo: usuarios.php?Accion=editar&Id=1
     Eliminar   = Eliminar Registro  Ejemplo: usuarios.php?Accion=eliminar&Id=1
     Si no esta determinada la variable accion entonces se muestra la grilla con los registros
  */
    switch($_GET["Accion"])
    {
      case  "Adicionar":
        UsuariosFormNuevo();
        break;
      case "Editar":
        UsuariosFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        UsuariosEliminar($_GET["Id"]);
        break;
      case "Guardar":
        $ArchivoImg = $_FILES['txtImagen']['name'];
		
		$NomImagen = "*"; // * Indica que no se asigno un archivo
		
        if ( !empty($ArchivoImg) )
        {
		  $NomImagen = "eyd" . "_" . $_FILES['txtImagen']['name'];

		  include("../../herramientas/upload/SimpleImage.php");
		  $image = new SimpleImage();
		  $image->load($_FILES['txtImagen']['tmp_name']);
		  $image->resizeToWidth(150);
			  
			$NomImagen = "eyd_" . $_FILES["txtImagen"]["name"];
				
		  $image->save($cRutaFirmas . $NomImagen);
        }
		if ( $NomImagen == "*" )
		{
			$NomImagen = "";
		}
            UsuariosGuardar($_POST["txtNombres"],$_POST["txtClave"],$_POST["txtConfirmar"],$_POST["txtId"],$_POST["cboPerfil"],$_POST["txtCorreoElectronico"],$_POST["cedula"],$_POST["cargo"],$NomImagen);
        

        break;
      case "Clave":
        UsuariosFormClave($_GET["Id"]);
        break;
      case "ActualizarClave":
        UsuariosActualizarClave($_POST["txtClaveAnt"],$_POST["txtClave1"],$_POST["txtClave2"],$_POST["txtId"]);
        break;
      default:
        header("Location: usuarios_listar.php");
        break;
    }

?>
</body>
</html>

