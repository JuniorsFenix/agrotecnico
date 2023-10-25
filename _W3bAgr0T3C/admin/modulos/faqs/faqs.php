<?
  include("../../herramientas/seguridad/seguridad.php");
  include("faqs_funciones.php");
  include("../../herramientas/upload/uploaderFunction.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: faqs_listar.php");
  }
?>
<html>
	<head>
		<title>Administración de Faqs</title>
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
        FaqsFormNuevo();
        break;
      case "Editar":
        FaqsFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        FaqsEliminar($_GET["Id"]);
        break;
      case "Guardar":
      	FaqsGuardar($_POST["txtId"],$_POST["txtPregunta"],$_POST["txtRespuesta"],$_POST["optPublicar"]);
        break;
      default:
        header("Location: faqs_listar.php");
        break;
    }
?>
</body>
</html>

