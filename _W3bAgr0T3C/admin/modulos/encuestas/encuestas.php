<?
  include("../../herramientas/seguridad/seguridad.php");
  include("encuestas_funciones.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: encuestas_listar.php");
  }
?>
<html>
	<head>
	<title>Administración de Encuestas</title>
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
        EncuestasFormNuevo();
        break;
      case "Editar":
        EncuestasFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        EncuestasEliminar($_GET["Id"]);
        break;
      case "Guardar":
      	EncuestasGuardar($_POST["txtId"],$_POST["txtnombre"],$_POST["txtpregunta"],$_POST["optActivar"],$_POST["txtrespuesta01"],$_POST["txtrespuesta02"],$_POST["txtrespuesta03"],$_POST["txtrespuesta04"],$_POST["txtrespuesta05"],$_POST["txtrespuesta06"],$_POST["txtrespuesta07"],$_POST["txtrespuesta08"],$_POST["txtrespuesta09"],$_POST["txtrespuesta10"],$_POST["optPublicar"]);
        break;
      default:
        header("Location: encuestas_listar.php");
        break;
    }
?>
</body>
</html>