<?
  include("../../herramientas/seguridad/seguridad.php");
  include("funciones.php");

  $nConexion = Conectar();

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
    $_GET["Accion"] = isset($_GET["Accion"]) ? $_GET["Accion"]:"";
    switch($_GET["Accion"])
    {
      case "Guardar":
        DireccionesIpGuardar($_POST["txtPalabra"]);
        break;
      default:
        DireccionesIpFormEditar();
        break;
    }
?>
</body>
</html>