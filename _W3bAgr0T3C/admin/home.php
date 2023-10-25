<?php
  require_once("herramientas/seguridad/seguridad.php");
	require_once("funciones_generales.php");
	$sitioCfg = sitioAssoc2();
	$home = $sitioCfg["url"];
  require_once("vargenerales.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>.:: Sitio de Administraci&oacute;n Portal ClicKee ::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<frameset rows="152,*,1" cols="*" frameborder="NO" border="0" framespacing="0">
  <frame src="<?php echo $home; ?>/sadminc/cabecera.php" name="cabecera" frameborder="no" scrolling="NO" noresize id="cabecera">
    <frame src="<?php echo $home; ?>/sadminc/contenedor.php" name="contenedor" frameborder="no" scrolling="auto" id="contenedor">
<!--<frame src="UntitledFrame-7"></frameset>-->
<noframes><body>
</body></noframes>
</html>
