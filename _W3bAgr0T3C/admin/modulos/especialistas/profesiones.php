<?php
  include("../../herramientas/seguridad/seguridad.php");
  include("funciones_profesiones.php");
  if ( !isset ($_GET["accion"]) ) {
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
        ProfesionFormNuevo();
        break;
      case "editar":
        ProfesionFormEditar($_GET["idprofesion"]);
        break;
      case "guardar":
        ProfesionGuardar($_POST);
        break;
      default:
        header("Location: listar_profesiones.php");
        break;
    }
?>
</body>
</html>