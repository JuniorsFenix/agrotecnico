<?php
	include_once("templates/includes.php");
	if(!isset($_GET["encuesta"])){
		header("Location: /$sitioCfg[carpeta]/encuestas");
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Nueva Pregunta - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Nueva Pregunta</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/guardarPregunta">
        	<input type="hidden" value="<?php echo $_GET["encuesta"] ?>" name="idencuesta">
            <label for="texto">Pregunta:</label>
            <input type="text" name="texto" maxlength="255" />
            <label>Campo obligatorio: 
				<select name="requerido" id="dia">
					<option value="0" >No</option>
					<option value="1" >Si</option>
				</select>
            </label>
            <label>Tipo de respuesta:</label>
            <input type="radio" checked="checked" value="1" name="tipo_respuesta">
            Una respuesta
            <br>
            <input type="radio" value="2" name="tipo_respuesta">
            Una respuesta con campo "Otro"
            <br>
            <input type="radio" value="3" name="tipo_respuesta">
            Respuesta múltiple
            <br>
            <input type="radio" value="4" name="tipo_respuesta">
            Respuesta múltiple con campo "Otro"
            <br>
            <input type="radio" value="5" name="tipo_respuesta">
            Respuesta abierta (una sola linea)
            <br>
            <input type="radio" value="6" name="tipo_respuesta">
            Respuesta abierta (varias lineas)
            <label>Si la pregunta tiene respuestas múltiples, por favor ingresar las respuestas en el siguiente cuadro de texto, una respuesta por línea:</label>
            <textarea name="var_text" rows="8" cols="20"></textarea><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/preguntas/<?php echo $_GET["encuesta"]; ?>" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>