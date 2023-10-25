<?php
	include("../../herramientas/seguridad/seguridad.php");
	include("../../herramientas/paginar/class.paginaZ.php");
	include("../../funciones_generales.php");
	include("../../vargenerales.php");


//060371
$bloques = 100;
$espera = 2;
$template = $_GET["template"];
$bol = $_GET["bol"];

$nConexion = Conectar();
$sql="select * from tblboletineslistas order by nombre";
$rsListas = mysqli_query($nConexion,$sql);
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

<form action="enviar_iframe.php" target="enviando" method="post" enctype="multipart/form-data">
<input type="hidden" name="bol" value="<?=$bol;?>">
<input type="hidden" name="template" value="<?=$template;?>">

Bloques:<br/>
<input type="text" name="bloques" value="<?=$bloques;?>"><br/>
Espera(Minutos):<br/>
<input type="text" name="espera" value="<?=$espera;?>"><br/>

Asunto:<br/>
<input type="text" name="asunto" value="<?=$asunto;?>" style="width:300px;"><br/>

Lista de Destinatarios:<br/>
<select name="lista">
<option value="-1" selected >SIN LISTA</option>
<option value="0" >TODAS LAS LISTAS</option>
<?php while($rx = mysqli_fetch_assoc($rsListas)):?>
    <option value="<?=$rx["idlista"];?>"><?=$rx["nombre"];?></option>
<?php endwhile;?>
</select>
<br/>
Archivo de Destinatarios:<br/>
<input type="file" name="destinatarios"><br/>

<br/>
<input type="submit" name="bEnviar" value="Enviar">
</form>
<hr/>
<iframe id="enviando" name="enviando" src="" style="width:100%;height:300px;"></iframe>
</body>
</html>