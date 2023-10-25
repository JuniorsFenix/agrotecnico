<?
	include("../../herramientas/FCKeditor/fckeditor.php") ;
  include("../../herramientas/seguridad/seguridad.php");
  include("archivos_login_funciones_usuareg.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista de usuarios
  {
    header("Location: archivos_login_listar_usuareg.php");
  }
?>
<html>
	<head>
		<title>Administración de Categorías - Modulo Archivos</title>
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
        UsuaregLoginFormNuevo();
        break;
      case "Editar":
        UsuaregLoginFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        UsuaregLoginEliminar($_GET["Id"]);
        break;
      case "Guardar":
		UsuaregLoginGuardar($_POST["txtId"],$_POST["txtNombres"],$_POST["txtApellidos"],$_POST["txtCiudad"],$_POST["txtDireccion"],$_POST["txtTel"],$_POST["txtMail"],$_POST["txtUsername"],$_POST["txtClave"],$_POST["optPermitido"]);
        break;
      default:
        header("Location: archivos_login_listar_usuareg.php");
        break;
    }

?>
</body>
</html>

