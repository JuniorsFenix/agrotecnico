<?
  include("../../herramientas/seguridad/seguridad.php");
  include("funciones.php");
  if (!isset ($_GET["accion"])) // Si no se envio la accion muestro la lista
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
    switch($_GET["accion"])
    {
      case  "adicionar":
        CategoriaFormNuevo();
        break;
      case "editar":
        CategoriaFormEditar($_GET["idcategoria"]);
        break;
      case "guardar":
         CategoriaGuardar($_POST);
        break;
      default:
        header("Location: listar_categorias.php");
        break;
    }
?>
</body>
</html>