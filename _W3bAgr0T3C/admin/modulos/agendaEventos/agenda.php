<?
  include("../../herramientas/FCKeditor/fckeditor.php") ;
  include("../../herramientas/seguridad/seguridad.php");
  include("frases_funciones.php");
  include("../../herramientas/upload/uploaderFunction.php");
  include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: frases_listar.php");
  }
?>
<html>
  <head>
    <title>Administración de Frases</title>
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
    switch($_GET["Accion"]) {
      case  "Adicionar":
	FrasesFormNuevo();
      break;
      case "Editar":
	FrasesFormEditar($_GET["Id"]);
      break;
      case "Eliminar":
	FrasesEliminar($_GET["Id"]);
      break;
      case "Guardar":
	FrasesGuardar($_POST["txtId"],$_POST["descripcion"]);
	header("Location: frases_listar.php");
	break;
      default:
	header("Location: frases_listar.php");
	break;
    }
  ?>
</body>
</html>

