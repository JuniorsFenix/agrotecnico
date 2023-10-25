<?php
	include_once("templates/includes.php");
	if(!isset($_GET["encuesta"])){
		header("Location: /$sitioCfg[carpeta]/zona/encuestas");
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
    <title>Estadísticas - <?php echo $encuesta["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" /> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
       <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

google.load("visualization", "1", {packages:["corechart"]});
// Let the callback run a function
google.setOnLoadCallback(function() {
<?php
	$charts="";
	foreach($preguntas as $row) {
	$charts.="<div class='estadisticas' id='chart$row[id]'></div>";
	$opciones=opciones($row['id'],$row['id_encuesta']);
?>
	var DataSet<?php echo $row['id'] ?>   =   [
				['Title', '<?php echo $row['texto']; ?>'],<?php echo $opciones ?>
			]
	drawChart(DataSet<?php echo $row['id'] ?>,'chart<?php echo $row['id'] ?>','<?php echo $row['texto']; ?>');
<?php
	}
?>

    });
// Give the function some arguments, first is data, second id
// You could do a third for the options attribute
function drawChart(ArrayElem,IdElem,Titulo)
    {
        var data = google.visualization.arrayToDataTable(ArrayElem);
        var options = {'title':Titulo,
                       'height':400};
        var chart = new google.visualization.PieChart(document.getElementById(IdElem));
        chart.draw(data, options);
    }
</script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
    	<h1><?php echo $encuesta["titulo"]; ?></h1>
        <?php echo $charts; ?>
    </div>
    <?php get_footer() ?>
</body>
</html>