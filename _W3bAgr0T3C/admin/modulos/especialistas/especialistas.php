<?
	include("../../herramientas/seguridad/seguridad.php");
	include("funciones_especialistas.php");
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
    switch( $_GET["accion"] ) {
      case "adicionar":
        EspecialistaFormNuevo();
        break;
      case "editar":
        EspecialistaFormEditar($_GET["idprofesional"]);
        break;
      case "guardar":
        EspecialistaGuardar($_POST);
        break;
      default:
        header("Location: listar_especialistas.php");
        break;
    }
?>
</body>
</html>