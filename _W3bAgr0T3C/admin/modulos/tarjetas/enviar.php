<?php
	include("../../herramientas/seguridad/seguridad.php");
	include("../../herramientas/paginar/class.paginaZ.php");
	include("../../funciones_generales.php");
	include("../../vargenerales.php");


//060371
$bloques = 100;
$espera = 2;

$nConexion = Conectar();
$sql="select count(*) AS cantidad from tbl_datos a where extract(month from NACIMIENTO) = extract(month from current_date)
and extract(day from NACIMIENTO) = extract(day from current_date)";
$rsCantidad = mysqli_query($nConexion,$sql);
$rxCantidad = mysqli_fetch_assoc($rsCantidad);

$sql="select * from tbl_datos a where extract(month from NACIMIENTO) = extract(month from current_date)
and extract(day from NACIMIENTO) = extract(day from current_date)";
$rsCumplimentados = mysqli_query($nConexion,$sql);

$sql="select * from tbltarjetas order by titulo";
$rsTarjetas = mysqli_query($nConexion,$sql);

$sql="select * from tblfrases order by descripcion";
$rsFrases = mysqli_query($nConexion,$sql);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso8859-1" />
    <meta http-equiv="Content-Language" content="en" />
    <meta name="GENERATOR" content="PHPEclipse 1.2.0" />
    <title>title</title>
</head>
<body>
<? include("../../system_menu.php"); ?><br>

<form name="formulario" action="enviar_iframe.php" target="enviando" method="post" enctype="multipart/form-data">
<input type="hidden" name="bol" value="<?=$bol;?>">
<input type="hidden" name="template" value="<?=$template;?>">

<br>
Envio de tarjetas a cuplimentados
<br><br><br>


Bloques:<br/>
<input type="text" name="bloques" value="<?=$bloques;?>"><br/>
Espera(Minutos):<br/>
<input type="text" name="espera" value="<?=$espera;?>"><br/>

Asunto:<br/>
<input type="text" name="asunto" value="<?=$asunto;?>" style="width:300px;"><br/>
<br>
Cumplimentados: <?=$rxCantidad["cantidad"];?><br>
<?php while($rx = mysqli_fetch_assoc($rsCumplimentados)):?>
<?=$rx["nombres"].' '.$rx["apellidos"];?><br>
<?php endwhile;?>

<br><br>

Lista de tarjetas:<br/>
<select name="tarjeta">
<?php while($rx = mysqli_fetch_assoc($rsTarjetas)):?>
    <option value="<?=$rx["idtarjeta"];?>"><?=$rx["titulo"];?></option>
<?php endwhile;?>
</select>
<br/>

<br>

Lista de frases:<br/>
<select name="frase">
<?php while($rx = mysqli_fetch_assoc($rsFrases)):?>
    <option value="<?=$rx["idfrase"];?>"><?=$rx["descripcion"];?></option>
<?php endwhile;?>
</select>
<br/>
superior:<br/>
<input type="text" name="superior" value=""><br/>
Izquierdo:<br/>
<input type="text" name="izquierdo" value=""><br/>
<br>
<input type="button" name="vistaPrevia" value="Vista Previa" onClick="document.formulario.action='vista_previa.php'; document.formulario.submit()";>
<br/>
<input type="button" name="bEnviar" value="Enviar" onClick="document.formulario.action='enviar_iframe.php'; document.formulario.submit()";>
</form>
<hr/>
<iframe id="enviando" name="enviando" src="" style="width:100%;height:300px;"></iframe>
</body>
</html>