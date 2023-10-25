<?php include_once("templates/includes.php"); 
	$perfil = datosPerfil($_SESSION["perfil"]);?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Encuestas - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <nav class="opciones">
        <ul>
        <?php if($perfil["configuracion"]==1){ ?>
            <li>
                <a href="/<?php echo $sitioCfg["carpeta"]; ?>/configuracion">
                    <img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/configuracion.png" alt="Configuración"/>
                    <h1>CONFIGURACIÓN</h1>
                    Incluimos para su comodidad 3 formas de soporte: Línea gratuita Nacional, Sistemas de Tickets y Soporte en Línea.
                    <span class="link">+</span>
                </a>
            </li>
        <?php }
		if($perfil["campana"]==1){ ?>
            <li>
                <a href="/<?php echo $sitioCfg["carpeta"]; ?>/campanas">
        			<img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/campania.png" alt="Campaña"/>
                	<h1>CAMPAÑAS</h1>
                    Incluimos para su comodidad 3 formas de soporte: Línea gratuita Nacional, Sistemas de Tickets y Soporte en Línea.
                    <span class="link">+</span>
                </a>
            </li>
        <?php }
		if($perfil["ver"]==1){ ?>
            <li>
                <a href="/<?php echo $sitioCfg["carpeta"]; ?>/encuestas">
        			<img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/estadisticas.png" alt="Configuración"/>
                	<h1>ENCUESTAS</h1>
                    Incluimos para su comodidad 3 formas de soporte: Línea gratuita Nacional, Sistemas de Tickets y Soporte en Línea.
                    <span class="link">+</span>
                </a>
            </li>
        <?php } ?>
        </ul>
    </nav>
    <?php get_footer() ?>
</body>
</html>