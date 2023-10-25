<?
  include("../../herramientas/seguridad/seguridad.php");
  include("funciones_mantenimiento.php");
  include("../../funciones_generales.php");
  if (!isset ($_GET["accion"])) {
    header("Location: listar.php");
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

  switch ( $_GET["accion"] ) {
    case  "adicionar":
      MantenimientoFormNuevo();
      break;
    case "editar":
      //ListaFormEditar($_GET["idlista"]);
      break;
    case "guardar":
      $result = MantenimientoGuardar($_POST);
      if ( $result != true ) {
        Mensaje( $result, "listar.php" );
      }
      break;
    default:
      header("Location: listar.php");
      break;
  }
?>
</body>
</html>