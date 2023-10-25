<?php
	include_once("templates/includes.php");
	$perfiles = perfilesQuery();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Nuevo usuario - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Importar usuarios</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/importarUsuarios" enctype="multipart/form-data">
            <label>Archivo csv:</label>
            <input type="file" name="csv" /><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/usuarios" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>