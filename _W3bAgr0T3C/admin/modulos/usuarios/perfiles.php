<?
  include("../../herramientas/seguridad/seguridad.php");
  include("perfiles_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista de usuarios
  {
    header("Location: usuarios_listar.php");
  }
?>
<html>
	<head>
		<title>--Administración de Perfiles--</title>
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
     Adicionar  = Nuevo Registro     Ejemplo: usuarios.php?Accion=adicionar
     Editar     = Editar Registro    Ejemplo: usuarios.php?Accion=editar&Id=1
     Eliminar   = Eliminar Registro  Ejemplo: usuarios.php?Accion=eliminar&Id=1
     Si no esta determinada la variable accion entonces se muestra la grilla con los registros
  */
    switch($_GET["Accion"])
    {
      case  "Adicionar":
        PerfilesFormNuevo();
        break;
      case "Editar":
        PerfilesFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        PerfilesEliminar($_GET["Id"]);
        break;
      case "Guardar":
            PerfilesGuardar($_POST);
        break;
      default:
        header("Location: perfiles_listar.php");
        break;
    }

?>
</body>
</html>

