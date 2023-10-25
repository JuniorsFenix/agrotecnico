<?php
	include_once("templates/includes.php");
	if(!isset($_GET["pregunta"])){
		header("Location: /$sitioCfg[carpeta]/zona/preguntas");
	}
	
	$pregunta = datosPregunta($_GET["pregunta"]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Editar pregunta - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Editar pregunta</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/actualizarPregunta">
            <input type="hidden" name="idpregunta" value="<?php echo $pregunta["id"]; ?>" />
            <input type="hidden" name="idencuesta" value="<?php echo $pregunta["id_encuesta"]; ?>" />
            <label for="texto">Pregunta:</label>
            <input type="text" name="texto" maxlength="255" value="<?php echo $pregunta["texto"]; ?>" />
            <label>Campo obligatorio: 
				<select name="requerido" id="dia">
					<option value="0" <?=$pregunta["requerido"]==0?"selected":"";?> >No</option>
					<option value="1" <?=$pregunta["requerido"]==1?"selected":"";?> >Si</option>
				</select>
            </label>
            <label>Tipo de respuesta:</label>
            <input type="radio" value="1" name="tipo_respuesta" <?=$pregunta["tipo_respuesta"]==1?"checked":"";?>>
            Una respuesta
            <br>
            <input type="radio" value="2" name="tipo_respuesta" <?=$pregunta["tipo_respuesta"]==2?"checked":"";?>>
            Una respuesta con campo "Otro"
            <br>
            <input type="radio" value="3" name="tipo_respuesta" <?=$pregunta["tipo_respuesta"]==3?"checked":"";?>>
            Respuesta múltiple
            <br>
            <input type="radio" value="4" name="tipo_respuesta" <?=$pregunta["tipo_respuesta"]==4?"checked":"";?>>
            Respuesta múltiple con campo "Otro"
            <br>
            <input type="radio" value="5" name="tipo_respuesta" <?=$pregunta["tipo_respuesta"]==5?"checked":"";?>>
            Respuesta abierta (una sola linea)
            <br>
            <input type="radio" value="6" name="tipo_respuesta" <?=$pregunta["tipo_respuesta"]==6?"checked":"";?>>
            Respuesta abierta (varias lineas)
            <label>Si la pregunta tiene respuestas múltiples, por favor ingresar las respuestas en el siguiente cuadro de texto, una respuesta por línea:</label>
            <textarea name="var_text" rows="8" cols="20"><?php echo opcionesQuery($pregunta["id"]); ?></textarea><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/preguntas/<?php echo $pregunta["id_encuesta"]; ?>" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>