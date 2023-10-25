<?php
	include("../../herramientas/seguridad/seguridad.php");
	include("modulos_funciones.php");
	include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: modulos_listar.php");
	}
?>
<html>
	<head>
		<title>Administración de Imágenes</title>
		<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<link href="../../herramientas/seocounter.css" rel="stylesheet" type="text/css">
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="../../herramientas/seocounter.js"></script>
        <script src="../../herramientas/ckeditor/ckeditor.js"></script>
		<script type="text/javascript"> 
            $(document).ready(function(){
                seocounter();
            }); 
        </script>
	</head>
<body>
<?php include("../../system_menu.php"); ?><br>
<?php
	switch($_GET["Accion"]) {
		case  "Adicionar":
			modulosFormNuevo($_GET["modulo"]);
		break;
		case "Editar":
			modulosFormEditar($_GET["modulo"],$_GET["Id"]);
		break;
		case "Eliminar":
			modulosEliminar($_GET["modulo"],$_GET["Id"]);
		break;
		case "Guardar":
			modulosGuardar($_GET["modulo"],$_POST,$_FILES);
		break;
		default:
			header("Location: modulos_listar.php");
			break;
	}
?>
</body>
</html>

