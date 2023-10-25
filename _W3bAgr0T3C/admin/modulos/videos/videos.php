<?
  include("../../herramientas/seguridad/seguridad.php");
  include("funciones.php");
  $IdCategoria = $_GET["idcategoria"];
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: contenidos_listar.php");
  }
?>
<html>
  <head>
    <title>Administración de Contenidos Generales</title>
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
        VideosFormNuevo($IdCategoria);
        break;
      case "Editar":
        VideosFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        VideosEliminar($_GET["Id"]);
        break;
      case "Guardar":
         VideosGuardar($_POST["IdCategoria"],$_POST["txtIdVideo"],$_POST["txtNombre"],$_POST["txtDescripcion"],$_POST["txtPais"],$_POST["txtDuracion"],$_FILES["archivo"]);
        break;
      default:
        header("Location: listar.php");
        break;
    }
?>
</body>
</html>