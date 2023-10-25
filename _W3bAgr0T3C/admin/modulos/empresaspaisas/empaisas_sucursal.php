<?
	include("../../herramientas/seguridad/seguridad.php");
	include("empaisas_sucursal_funciones.php");
	//include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: empaisas_sucursal_listar.php");
	}
?>
<html>
	<head>
		<title>Administraci&oacute;n de Sucursales de Empresas Paisas</title>
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
  /* Determinar si viene el parametro que establece una accion:
     Adicionar  = Nuevo Registro
     Editar     = Editar Registro
     Eliminar   = Eliminar Registro
     Si no esta determinada la variable accion entonces se muestra la grilla con los registros
  */
    switch($_GET["Accion"])
    {
      case  "Adicionar":
        EmpaisasSucursalFormNuevo();
        break;
      case "Editar":
        EmpaisasSucursalFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        EmpaisasSucursalEliminar($_GET["Id"]);
        break;
      case "Guardar":
        EmpaisasSucursalGuardar($_POST["txtId"],$_POST["id_nombempaisa"],$_POST["txtnombresucempaisa"],"");
		break;
      default:
        header("Location: empaisas_sucursal_listar.php");
        break;
    }
?>
</body>
</html>