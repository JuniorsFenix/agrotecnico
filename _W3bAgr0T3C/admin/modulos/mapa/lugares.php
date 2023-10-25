<?
	include("../../herramientas/FCKeditor/fckeditor.php") ;
	include("../../herramientas/seguridad/seguridad.php");
	include("lugares_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: lugares_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de lugares</title>
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
<script language="javascript">
function apagar_url_newwindo(){
document.frm.txtDirWeb.disabled = true;
}
function prender_url_newwindo(){
document.frm.txtDirWeb.disabled = false;
}
</script>
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
        lugaresFormNuevo();
        break;
      case "Editar":
        lugaresFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        lugaresEliminar($_GET["Id"]);
        break;
      case "Guardar":
		lugaresGuardar($_POST["txtId"],$_POST["txtNombre"],$_POST["txtDescripcion"],$_POST["txtPosicionX"],$_POST["txtPosicionY"]);				
        break;
      default:
        header("Location: lugares_listar.php");
        break;
    }
?>
</body>
</html>

