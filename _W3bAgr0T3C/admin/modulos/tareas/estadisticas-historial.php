<?php
	include_once("templates/includes.php");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Estadísticas - Historial médico</title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" /> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
       <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

google.load("visualization", "1", {packages:["corechart"]});
// Let the callback run a function
google.setOnLoadCallback(function() {
<?php $opciones=diagnosticos(); ?>
	var DataSet =   [
				['Title', 'Afectados'],<?php echo $opciones ?>
			]
	drawChart(DataSet,'chart1','Diagnósticos');


    });
// Give the function some arguments, first is data, second id
// You could do a third for the options attribute
function drawChart(ArrayElem,IdElem,Titulo)
    {
        var data = google.visualization.arrayToDataTable(ArrayElem);
        var options = {'title':Titulo};
        var chart = new google.visualization.ColumnChart(document.getElementById(IdElem));
        chart.draw(data, options);
    }
</script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
    	<h1>Estadísticas historial médico</h1>
        <div class='estadisticasHistorial' id='chart1'></div>
    </div>
    <?php get_footer() ?>
</body>
</html>