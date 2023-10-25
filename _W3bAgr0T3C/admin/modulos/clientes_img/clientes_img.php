<?
  include("../../herramientas/seguridad/seguridad.php");
  include("clientes_img_funciones.php");
	include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: clientes_img_listar.php");
  }
?>
<html>
	<head>
		<title>Administración de Clientes</title>
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
        ClientesImgFormNuevo();
        break;
      case "Editar":
        ClientesImgFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        ClientesImgEliminar($_GET["Id"]);
        break;
      case "Guardar":
				ClientesImgGuardar($_POST["txtId"],$_POST["txtNombres"],$_POST["txtApellidos"],$_POST["txtMail"],$_POST["txtUsuario"],$_POST["txtClave"]);
        break;
      default:
        header("Location: clientes_img_listar.php");
        break;
    }
?>
</body>
</html>

