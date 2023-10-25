<?php
  require_once("herramientas/seguridad/seguridad.php");
	require_once("funciones_generales.php");
	$sitioCfg = sitioAssoc2();
	$home = $sitioCfg["url"];
	require_once ("vargenerales.php");
?>
<html>
  <head>
    <link href="<?php echo $home; ?>/sadminc/css/administrador.css" rel="stylesheet" type="text/css">
  </head>
  <body>
	<?php require_once('system_menu.php'); ?>
</body>
</html>