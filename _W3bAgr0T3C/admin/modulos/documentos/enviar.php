<?php
	include("../../herramientas/seguridad/seguridad.php");
	include("../../herramientas/paginar/class.paginaZ.php");
	include("../../funciones_generales.php");
	include("../../vargenerales.php");



$nConexion = Conectar();
$sql="select * from tblplantillas order by titulo";
$rsPlantillas = mysqli_query($nConexion,$sql);

$sql="select * from tbldocumentos order by titulo";
$rsDocumentos = mysqli_query($nConexion,$sql);

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

<br>
Documentos Especiales
<br>


Asunto:<br/>
<input type="text" name="asunto" style="width:300px;"><br/>
<br>

Mensaje:<br/>
<textarea name="mensaje" cols="45" rows="5"></textarea><br/>
<br>

Correo:<br/>
<input type="text" name="correo" style="width:300px;"><br/>
<br>

Lista de Plantillas:<br/>
<select name="plantilla">
<?php while($rx = mysqli_fetch_assoc($rsPlantillas)):?>
    <option value="<?=$rx["idplantilla"];?>"><?=$rx["titulo"];?></option>
<?php endwhile;?>
</select>
<br/>

<br>

Lista de Documentos:<br/>
<select name="documento">
<?php while($rx = mysqli_fetch_assoc($rsDocumentos)):?>
    <option value="<?=$rx["idcontenido"];?>"><?=$rx["titulo"];?></option>
<?php endwhile;?>
</select>
<br/>

Nombre del archivo:<br/>
<input type="text" name="nombre" style="width:300px;"><br/>
<br>
<input type="button" name="vistaPrevia" value="Selecionar" onClick="document.formulario.action='vista_previa.php'; document.formulario.submit()";>
<br/>
</form>
<hr/>
<iframe id="enviando" name="enviando" src="" style="width:100%;height:500px;"></iframe>
</body>
</html>