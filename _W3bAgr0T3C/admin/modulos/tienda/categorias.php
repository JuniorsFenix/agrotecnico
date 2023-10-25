<?php
	include("../../herramientas/seguridad/seguridad.php");
	include("funciones.php");
	if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
	{
	header("Location: contenidos_listar.php");
	}
?>
<html>
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Administración de Contenidos Generales</title>
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
  </head>
<body>
<?php include("../../system_menu.php"); ?><br>
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
        CategoriasFormNuevo();
        break;
      case "Editar":
        CategoriasFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        CategoriasEliminar($_GET["Id"]);
        break;
      case "Guardar":
         CategoriasGuardar($_POST,$_FILES);
        break;
      default:
        header("Location: listar_categorias.php");
        break;
    }
?>
</body>
</html>