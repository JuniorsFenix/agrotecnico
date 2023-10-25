<?php
  include("../../herramientas/seguridad/seguridad.php");
  include("idiomas_funciones.php");
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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
<body>
<?php include("../../system_menu.php"); ?><br>
<?php
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
         CiudadesGuardar($_POST["txtId"],$_POST["txtCiudad"],$_POST["codigo"],$_POST["optPublicar"]);
        break;
      default:
        header("Location: idiomas_listar.php");
        break;
    }
?>
</body>
</html>