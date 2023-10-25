<?php
	include_once("templates/includes.php");
	if(!isset($_GET["encuesta"])){
		header("Location: /$sitioCfg[carpeta]/inicio");
	}
	
	$encuesta = datosEncuesta($_GET["encuesta"]);
	$preguntas = preguntasQuery($_GET["encuesta"]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title><?php echo $encuesta["titulo"]; ?> - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/bootstrap.min.css" rel="stylesheet" media="screen">
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
<style>
		
		.droppedField {
			padding-left:5px;
		}

		.droppedField > input,select, button, .checkboxgroup, .selectmultiple, .radiogroup {
			margin-top: 10px;
			
			margin-right: 10px;
			margin-bottom: 10px;
		}

		.action-bar .droppedField {
			float: left;
			padding-left:5px;
		}

	
</style>
		<h1><?php echo $encuesta["titulo"]; ?></h1>
	  <div class="row-fluid">
        	<form action="/<?php echo $sitioCfg["carpeta"]; ?>/respuestasEncuesta" method="post">
            	<input type="hidden" name="idencuesta" value="<?php echo $encuesta['id'] ?>">
				<p><?php echo $encuesta["introduccion"]; ?></p>
				<?php
                    foreach($preguntas as $row) {
                ?>
                <div class="pregunta" style="z-index: 89;" class="draggableField radiogroup ui-draggable droppedField">
            		<input type="hidden" name="idpregunta[]" value="<?php echo $row['id'] ?>">
                    <label class="control-label" style="vertical-align:top"><?php echo $row['texto']; ?></label><br>
                    <?php echo listarRespuestas($row['id'],$row['tipo_respuesta']); ?>
                </div>
                <?php
                    }
                ?>
    			<input type="image" src="/imagenes/guardar.gif" alt="Completar Encuesta" title="Completar Encuesta">
            </form>
    </div>	
		
    </div>
    <?php get_footer() ?>
</body>
</html>