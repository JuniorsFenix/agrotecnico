<?php
    if(!session_id()) session_start();
	include("include/funciones.php");
	$sitioCfg = sitioFetch();
    cancelar($_GET["n"], $_GET["id"]);
	$mensaje = "El cambio de contraseña ha sido invalidado";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Recuperar contraseña - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<header>
    </header>
    <div class="container">
        <form method="post" id="signup">     
            <div class="header">                        
                <h3>Recuperar contraseña</h3>               
            </div>                        
            <div class="sep"></div>                
            <div class="inputs">
                <span class='mensajeCorreo'><?php echo $mensaje; ?></span><br>
                <a href="/<?php echo $sitioCfg["carpeta"]; ?>/">Regresar</a>                
            </div>                
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>