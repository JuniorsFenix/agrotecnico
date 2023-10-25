<?php
	include_once("templates/includes.php");
	if(!isset($_GET["categoria"])){
		header("Location: /$sitioCfg[carpeta]/categorias-membresias");
		exit;
	}
	
	$categoria = datosCategoriaMembresias($_GET["categoria"]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Editar Categoría - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Editar Categoría</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/categorias-membresias" enctype="multipart/form-data">
            <input type="hidden" name="idcategoria" value="<?php echo $categoria["idcategoria"]; ?>" />
            <label for="titulo">Categoría:</label>
            <input type="text" name="nombre" maxlength="255" value="<?php echo $categoria["nombre"]; ?>" /><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/categorias-membresias" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>