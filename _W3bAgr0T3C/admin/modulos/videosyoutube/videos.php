<?php
  include("../../herramientas/seguridad/seguridad.php");
  include("funciones.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: contenidos_listar.php");
  }
?>
<html>
  <head>
    <title>Administración de Contenidos Generales</title>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
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
        VideosFormNuevo();
        break;
      case "Editar":
        VideosFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        VideosEliminar($_GET["Id"]);
        break;
      case "Guardar":
         VideosGuardar($_POST["IdCategoria"],$_POST["txtIdVideo"],$_POST["txtNombre"],$_POST["txtDescripcion"],$_POST["url"]);
        break;
      default:
        header("Location: listar.php?idcategoria=1");
        break;
    }
?>
<script>
    $("textarea").addClass("ckeditor");
</script>
</body>
</html>