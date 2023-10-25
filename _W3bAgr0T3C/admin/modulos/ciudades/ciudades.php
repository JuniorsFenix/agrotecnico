<?
  include("../../herramientas/seguridad/seguridad.php");
  include("ciudades_funciones.php");
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
        CiudadesFormNuevo();
        break;
      case "Editar":
        CiudadesFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        CiudadesEliminar($_GET["Id"]);
        break;
      case "Guardar":
         CiudadesGuardar($_POST["txtId"],$_POST["txtCiudad"],$_POST["optPublicar"]);
        break;
      default:
        header("Location: ciudades_listar.php");
        break;
    }
?>
</body>
</html>