<?php
	include("../../herramientas/seguridad/seguridad.php");
	include("tags_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: tags_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de INFORMACIÓN</title>
		<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
<body>
<?php include("../../system_menu.php"); ?><br>
<?php
    switch($_GET["Accion"])
    {
      case  "Adicionar":
        TagsFormNuevo();
        break;
      case "Editar":
        TagsFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        TagsEliminar($_GET["Id"]);
        break;
      case "Guardar":
        TagsGuardar($_POST);
          exit;
        break;
      default:
        header("Location: tags_listar.php");
        break;
    }
?>
</body>
</html>

