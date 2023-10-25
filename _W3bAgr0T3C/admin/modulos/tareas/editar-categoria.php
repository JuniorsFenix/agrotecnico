<?php
	include_once("templates/includes.php");
	if(!isset($_GET["categoria"])){
		header("Location: acciones-categorias.php");
	}
	$categoria = datosCategorias($_GET["categoria"]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Editar categoría - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
	<?php include("../../system_menu.php"); ?><br>
    <div id="container-inside">
        <h1>Editar categoría</h1>
        <form method="post" action="acciones-categorias.php">
            <input type="hidden" name="actualizar" value="1" />
            <input type="hidden" name="id" value="<?php echo $categoria["id"]; ?>" />
            <label>Categoría:</label>
            <input type="text" name="categoria" maxlength="255" value="<?php echo $categoria["categoria"]; ?>" /><br>
            <a href="acciones-categorias.php" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>