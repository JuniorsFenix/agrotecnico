<?php
	include_once("templates/includes.php");
	if(!isset($_GET["encuesta"])){
		header("Location: /$sitioCfg[carpeta]/zona/encuestas");
	}
	
	$encuesta = datosEncuesta($_GET["encuesta"]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title>Encuesta realizada - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1><?php echo $encuesta["titulo"]; ?></h1>
        <?php echo $encuesta["mensaje_completo"]; ?><br><br>
        <?php if($encuesta["ver_estadisticas"]==1){?>
        Puede ver los resultados de la encuesta <a href="/<?php echo $sitioCfg["carpeta"]; ?>/estadisticas/<?php echo $encuesta["id"]; ?>" title="Ver resultados de la encuesta" title="Ver resultados de la encuesta">Aquí</a>
        <?php } ?>
    </div>
    <?php get_footer() ?>
</body>
</html>