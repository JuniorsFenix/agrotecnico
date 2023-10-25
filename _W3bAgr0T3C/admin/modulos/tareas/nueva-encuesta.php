<?php
	include_once("templates/includes.php");
	$encuestas = encuestasQuery();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Crear encuesta - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Crear encuesta</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/guardarEncuesta">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" maxlength="255" />
            <label>Permitir que el usuario vea los resultados de la encuesta:</label>
            Si <input type="radio" name="ver_estadisticas" value="1" /> No <input type="radio" name="ver_estadisticas" value="0" checked />
            <label>Introducción:</label>
            <textarea name="introduccion" rows="4" cols="20"></textarea>
            <label>Mensaje de despedida:</label>
            <textarea name="mensaje_completo" rows="4" cols="20"></textarea>
            <label for="estado">Activar:</label>
            Si <input type="radio" name="estado" value="1" checked /> No <input type="radio" name="estado" value="0" /><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/encuestas" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>