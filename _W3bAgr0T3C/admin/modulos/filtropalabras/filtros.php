<?
  include("../../herramientas/seguridad/seguridad.php");
  include("funciones.php");

  $nConexion = Conectar();
  //@ $exists = mysqli_query($nConexion,"drop table tblmensajes");
  @ $exists = mysqli_query($nConexion,"SELECT 1 FROM tblfiltropalabras LIMIT 0");
  if(!$exists){
    $sql="
      CREATE TABLE `tblfiltropalabras` (
      `idfiltro` int not null  auto_increment,
      `palabra` varchar(200) NOT NULL,
       PRIMARY KEY  (`idfiltro`)
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
    ";

    @ $r = mysqli_query($nConexion, $sql);
    if(!$r){
      die("Fallo creando tabla para almacenar filtros<br/>".mysqli_error($nConexion));
    }
  }

?>
<html>
  <head>
    <title>Administraci�n de Contenidos Generales</title>
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
        FiltrosGuardar($_POST["txtPalabra"]);
        break;
      default:
        FiltrosFormEditar($_GET["Id"]);
        break;
    }
?>
</body>
</html>