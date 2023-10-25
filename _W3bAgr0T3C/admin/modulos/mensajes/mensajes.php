<?
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
        MensajesFormNuevo();
        break;
      case "Editar":
        MensajesFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        MensajesEliminar($_GET["Id"]);
        break;
      case "Guardar":
         MensajesGuardar($_POST["txtIdMensaje"],$_POST["txtTitulo"],$_POST["txtMensaje"],$_POST["txtNombre"],$_POST["txtEmail"],$_FILES["archivo"]);
        break;
      default:
        header("Location: listar.php");
        break;
    }
?>
</body>
</html>