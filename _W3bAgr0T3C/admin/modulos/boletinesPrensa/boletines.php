<?
	include("../../herramientas/seguridad/seguridad.php");
	include("boletines_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: boletines_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de Boletines</title>
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
<script src="../../herramientas/ckeditor/ckeditor.js"></script>

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
        BoletinesFormNuevo();
        break;
      case "Editar":
        BoletinesFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        BoletinesEliminar($_GET["Id"]);
        break;
      case "Guardar":
            BoletinesGuardar($_POST["txtId"],$_POST["txtNombre"],$_POST["txtDescripcion"],$_POST["txtFuente"],$_POST["txtTags"],$_POST["txtPalabras"],$_FILES,$_POST["optPublicar"]);
        break;
      default:
        header("Location: boletines_listar.php");
        break;
    }
?>
</body>
</html>

