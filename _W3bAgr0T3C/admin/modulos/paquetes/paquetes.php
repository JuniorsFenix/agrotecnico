<?
	include("../../herramientas/FCKeditor/fckeditor.php") ;
  include("../../herramientas/seguridad/seguridad.php");
  include("paquetes_funciones.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: paquetes_listar.php");
  }
?>
<html>
	<head>
		<title>Administración de Paquetes</title>
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
        PaquetesFormNuevo();
        break;
      case "Editar":
        PaquetesFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        PaquetesEliminar($_GET["Id"]);
        break;
      case "Guardar":
        PaquetesGuardar($_POST["txtId"],$_POST["txtTitulo"],$_POST["txtDescripcion"],$_POST["txtPrecio"],$_POST["optPublicar"]);
        break;
      default:
        header("Location: paquetes_listar.php");
        break;
    }
?>
</body>
</html>

