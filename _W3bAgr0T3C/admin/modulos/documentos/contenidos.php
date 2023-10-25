<?
  include("../../herramientas/FCKeditor/fckeditor.php") ;
  include("../../herramientas/seguridad/seguridad.php");
  include("contenidos_funciones.php");
  include("../../herramientas/upload/uploaderFunction.php");
  include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: contenidos_listar.php");
  }
?>
<html>
  <head>
    <title>Administración de Contenidos</title>
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
    switch($_GET["Accion"]) {
      case  "Adicionar":
	contenidosFormNuevo();
      break;
      case "Editar":
	contenidosFormEditar($_GET["Id"]);
      break;
      case "Eliminar":
	contenidosEliminar($_GET["Id"]);
      break;
      case "Guardar":
	contenidosGuardar($_POST["txtId"],$_POST["titulo"],$_POST["descripcion"]);
	header("Location: contenidos_listar.php");
	break;
      default:
	header("Location: contenidos_listar.php");
	break;
    }
  ?>
</body>
</html>

