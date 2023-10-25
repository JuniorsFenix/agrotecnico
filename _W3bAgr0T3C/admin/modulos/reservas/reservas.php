<?
	include("../../herramientas/FCKeditor/fckeditor.php") ;
  include("../../herramientas/seguridad/seguridad.php");
  include("reservas_funciones.php");
  include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: reservas_listar.php");
  }
?>
<html>
<head>
<title>Administración de Reservas</title>
<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="../../herramientas/jscalendar/skins/aqua/theme.css" title="Aqua" />
<script type="text/javascript" src="../../herramientas/jscalendar/calendar.js"></script>
<script type="text/javascript" src="../../herramientas/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="../../herramientas/jscalendar/calendar-setup.js"></script>
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
    switch($_GET["Accion"])
    {
      case  "Adicionar":
        ReservasFormNuevo();
        break;
      case "Editar":
        ReservasFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        ReservasEliminar($_GET["Id"]);
        break;
      case "Guardar":
        ReservasGuardar($_POST);
        break;
      default:
        header("Location: reservas_listar.php");
        break;
    }
?>
</body>
</html>

