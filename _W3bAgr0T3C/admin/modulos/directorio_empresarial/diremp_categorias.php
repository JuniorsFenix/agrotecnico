<?php
  include("../../herramientas/seguridad/seguridad.php");
  include("diremp_categorias_funciones.php");
  include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: diremp_categorias_listar.php");
  }
?>
<html>
	<head>
		<title>Administraci&oacute;n de Categorias Directorio Empresarial</title>
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
<?php
  /* Determinar si biene el parametro que establece una accion:
     Adicionar  = Nuevo Registro
     Editar     = Editar Registro
     Eliminar   = Eliminar Registro
     Si no esta determinada la variable accion entonces se muestra la grilla con los registros
  */
    switch($_GET["Accion"])
    {
      case  "Adicionar":
        dirempCategoriasFormNuevo();
        break;
      case "Editar":
        dirempCategoriasFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        dirempCategoriasEliminar($_GET["Id"]);
        break;
      case "Guardar":
        dirempCategoriasGuardar($_POST["txtId"],$_POST["txtnombre"],"");
		break;
      default:
        header("Location: diremp_categorias_listar.php");
        break;
    }
?>
</body>
</html>

