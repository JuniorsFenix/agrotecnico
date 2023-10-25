<?
include("../../herramientas/FCKeditor/fckeditor.php");
include("../../herramientas/seguridad/seguridad.php");
include("productos_opciones_funciones.php");
include("../../herramientas/upload/uploaderFunction.php");
include("../../vargenerales.php");
if (!isset ($_GET["Accion"])){
header("Location: productos__opciones_listar.php");
}
?>
<html>
<head>
<title>Administración de Opciones</title>
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
        ProductosOpcionesFormNuevo();
        break;
      case "Editar":
        ProductosOpcionesFormEditar( $_GET["Id"] , $_GET["IdPlus"] , $_GET["nomplus"] );
        break;
      case "Eliminar":
        ProductosOpcionesEliminar( $_GET["Id"] , $_GET["idplus"] , $_GET["nom"] );
        break;
      case "Guardar":
				ProductosOpcionesGuardar($_POST["txtId"],$_POST["idplus"],$_POST["txtTitulo"],$_POST["txtPrecio"],$_POST["nomplus"]);
        break;
			case "Mover":
				$nIdOpcion	= $_GET["nIdOpcion"] ;
				$NomPlus		= $_GET["NomPlus"] ;
				$IdPlus			= $_GET["idplus"] ;
				OpcionesMover( $_GET["Donde"] , $_GET["nIdOpcion"] , $_GET["nOrdenActual"] , $_GET["idplus"] );
				echo "<script language=\"javascript\">document.location.href=\"productos_opciones_listar.php?Id=$IdPlus&nom=$NomPlus\"</script>";
				break;
      default:
        header("Location: productos_opciones_listar.php");
        break;
    }
?>
</body>
</html>