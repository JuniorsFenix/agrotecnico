<?php
	include("../../herramientas/seguridad/seguridad.php");
	include("funciones_productos.php");
	include("../../vargenerales.php");
	$IdCategoria = $_GET["idcategoria"];
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: contenidos_listar.php");
	}
?>
<html>
  <head>
    <title>Administraci�n de Contenidos Generales</title>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
	<link href="../../herramientas/seocounter.css" rel="stylesheet" type="text/css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="../../herramientas/ckeditor/ckeditor.js"></script>
	<script src="../../herramientas/seocounter.js"></script>
	<script type="text/javascript"> 
	$(document).ready(function(){
		seocounter();
	}); 
  </script>
    <style>
      .campos input{
        width:300px;
      }
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
        ProductosFormNuevo($IdCategoria);
        break;
      case "Editar":
        ProductosFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        ProductosEliminar($_GET["Id"]);
        break;
      case "Guardar":
         ProductosGuardar($_POST,$_FILES);
        break;
      default:
        header("Location: listar_productos.php?idcategoria={$IdCategoria}");
        break;
    }
?>
</body>
</html>