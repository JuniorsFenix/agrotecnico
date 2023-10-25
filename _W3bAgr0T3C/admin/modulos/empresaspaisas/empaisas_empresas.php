<?
	include("../../herramientas/seguridad/seguridad.php");
	include("empaisas_empresas_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: empaisas_empresas_listar.php");
	}
?>
<html>
	<head>
		<title>Administraci&oacute;n de Empresas Paisas</title>
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
        EmpaisasEmpresasFormNuevo();
        break;
      case "Editar":
        EmpaisasEmpresasFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        EmpaisasEmpresassEliminar($_GET["Id"]);
        break;
      case "Guardar":
        EmpaisasEmpresasGuardar($_POST["txtId"],$_POST["txtempaisas_nomempresa"],"");
		break;
      default:
        header("Location: enpaisas_empresas_listar.php");
        break;
    }
?>
</body>
</html>