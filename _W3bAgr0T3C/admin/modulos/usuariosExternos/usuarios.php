<?
  include("../../herramientas/seguridad/seguridad.php");
  include("usuarios_funciones.php");
  include("../../vargenerales.php");
  

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../../herramientas/phpmailer/src/Exception.php';
  require '../../herramientas/phpmailer/src/PHPMailer.php';
  
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: usuarios_listar.php");
  }
?>
<html>
  <head>
    <title>Administraci�n de Usuarios</title>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
		function confirmar() {
      var password = $("#clave").val();
      var confirmPassword = $("#clave2").val();
    
      if (password != confirmPassword)
          $("#mensaje").html("Las contraseñas no coinciden");
      else
          $("#mensaje").html("");
    }
	
	$(document).ready(function () {
   		$("#clave2").keyup(confirmar);
	});
	</script>
    <style type="text/css">
    #mensaje{
      color:#C00003;
    }
  </style>
  </head>
<body>
  <? include("../../system_menu.php"); ?><br>
  <?
    switch($_GET["Accion"]) {
      case  "Adicionar":
	UsuariosFormNuevo();
      break;
      case "Editar":
	UsuariosFormEditar($_GET["Id"]);
      break;
      case "Eliminar":
	UsuariosEliminar($_GET["Id"]);
      break;
      case "Guardar":
	UsuariosGuardar($_POST);
	header("Location: usuarios_listar.php");
	break;
      default:
	header("Location: usuarios_listar.php");
	break;
    }
  ?>
</body>
</html>

