<?
  include("../../herramientas/seguridad/seguridad.php");
  include("funciones_correo.php");
  
  
  if ( isset($_GET["idlista"]) ) {
    $IdLista = $_GET["idlista"];
  }
  
  if (!isset ($_GET["accion"])) {
    header("Location: registrar_correo.php".(isset($IdLista)?"?idlista={$IdLista}":""));
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
      CorreoFormNuevo($IdLista);
      break;
    case "editar":
      CorreoFormEditar($_GET["correo"],$IdLista);
      break;
    case "guardar":
      $result = CorreoGuardar($_POST,$IdLista);
      if ( $result != true ) {
        Mensaje($result,"registrar_correo.php");
      }
      break;
    default:
      header("Location: registrar_correo.php".(isset($IdLista)?"?idlista={$IdLista}":""));
      break;
  }
?>
</body>
</html>