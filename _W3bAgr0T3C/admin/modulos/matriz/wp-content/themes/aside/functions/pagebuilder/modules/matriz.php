<?php
    if(!session_id()) session_start();
	include("../include/funciones_public.php");
	ValCiudad();
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	include("../admin/vargenerales.php");
	require_once ("../admin/herramientas/seguridad/validate.php");
	
	$IdCiudad=varValidator::validateReqInt("get","ciudad",true);
	if(is_null($IdCiudad)){
		echo "Valor de entrada invalido para la variable ciudad";
		exit;
	}
	
    $nConexion = Conectar();
	
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $sitioCfg["titulo"]; ?></title>
    <meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
    <meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
	<?php echo $RegContenido->contenido; ?>
	
	<link href="<?php echo $home; ?>/css/loading/center-radar.css" rel="stylesheet" />
    
    <link rel='dns-prefetch' href='//fonts.googleapis.com' />
	<link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:300,400&subset=latin-ext" rel="stylesheet">
   
	<link rel='stylesheet' id='rotatingtweets-css'  href='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/plugins/rotatingtweets/css/style.css?ver=4.6.1' type='text/css' media='all' />

	<link rel='stylesheet' id='font-awesome-css'  href='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/functions/theme/css/font-awesome.min.css?ver=4.0.3' type='text/css' media='screen' />
	<link rel='stylesheet' id='ux-lightbox-default-css'  href='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/js/lightbox/themes/default/jquery.lightbox.css?ver=0.0.1' type='text/css' media='screen' />
	<link rel='stylesheet' id='ux-interface-pagebuild-css'  href='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/styles/pagebuild.css?ver=0.0.1' type='text/css' media='screen' />
	<link rel='stylesheet' id='ux-interface-style-css'  href='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/style.css?ver=0.0.1' type='text/css' media='screen' />
	<link rel='stylesheet' id='ux-googlefont-rotobo-css'  href='http://fonts.googleapis.com/css?family=Roboto%3A400%2C400italic%2C700%2C900&#038;ver=0.0.1' type='text/css' media='screen' />
	<link rel='stylesheet' id='ux-googlefont-playfair-css'  href='http://fonts.googleapis.com/css?family=Playfair+Display%3A700&#038;ver=0.0.1' type='text/css' media='screen' />
	<link rel='stylesheet' id='ux-interface-theme-style-css'  href='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/styles/theme-style.php?ver=0.0.1' type='text/css' media='screen' />
	<link rel='stylesheet' id='ux-admin-theme-icons-css'  href='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/functions/theme/css/icons.css?ver=0.0.1' type='text/css' media='screen' />
	<link rel='https://api.w.org/' href='<?php echo $home; ?>/sadminc/modulos/matriz/wp-json/' />
    <link rel='stylesheet' id='ux-interface-bootstrap-css'  href='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/styles/bootstrap.css?ver=2.0' type='text/css' media='screen' />
    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
    
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-includes/js/jquery/jquery.js?ver=1.12.4'></script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1'></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript">
		var AJAX_M = "<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/functions/pagebuilder/pagebuilder-theme-ajax.php";
	</script>
	<script type="text/javascript">
	var JS_PATH = "<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/js";
    </script>
    
    <!-- IE hack -->
    <!--[if lte IE 9]>
	<link rel='stylesheet' id='cssie'  href='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/styles/ie.css' type='text/css' media='screen' />
	<![endif]-->

	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/js/ie.js"></script>
	<link rel='stylesheet' id='cssie8'  href='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/styles/ie8.css' type='text/css' media='screen' />
	<![endif]-->
	
	<!--[if lte IE 7]>
	<div style="width: 100%;" class="messagebox_orange">Your browser is obsolete and does not support this webpage. Please use newer version of your browser or visit <a href="http://www.ie6countdown.com/" target="_new">Internet Explorer 6 countdown page</a>  for more information. </div>
	<![endif]-->
	
    
    <noscript>
		<style>
            .mask-hover-caption{ top: 0px;left: -100%; -webkit-transition: all 0.3s ease; -moz-transition: all 0.3s ease-in-out; -o-transition: all 0.3s ease-in-out; -ms-transition: all 0.3s ease-in-out; transition: all 0.3s ease-in-out; }
            .mask-hover-inn:hover .mask-hover-caption { left: 0px; }
        </style>
    </noscript>
	<!---->
    
</head>
<body>
	<!--- Sección de menú --->
	<?php require_once("header.php");?>
	<!--- Sección de menú --->
	<div class="principal">
	<div id="skrollr-body">
	<?php
		function url_get_contents ($Url) {
			if (!function_exists('curl_init')){ 
				die('CURL is not installed!');
			}
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $Url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch);
			return $output;
		}
		$matriz = url_get_contents ("http://{$_SERVER['SERVER_NAME']}$home/sadminc/modulos/matriz/{$_GET["pagename"]}/");
		include('../include/simple_html_dom.php');
		$html = new simple_html_dom();
		$html->load($matriz);
		
		foreach($html->find('div#main') as $e)
    	echo $e;
	?>
		<script src="<?php echo $home; ?>/php/slick/slick.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $home; ?>/php/slick/slick.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $home; ?>/php/slick/slick-theme.css">
		<!--- Sección de Creado por --->
		<?php require_once("footer.php");?>
		<!--- Sección de Creado por --->
	</div>
	</div>
	
	<script type='text/javascript' src='<?php echo $home; ?>/php/js/skrollr.js'></script>
	<script>
		jQuery( function() {
			jQuery('.parallaxSeccion').attr('data-bottom-top', 'margin-top: -370px;');
			jQuery('.parallaxSeccion').attr('data-top', 'margin-top: 820px;');
		} );
	</script>
	<script>
		window.onload = function() {
			if(screen.width > 480) {
				var s = skrollr.init({
					forceHeight: false
				});
			}
		};
	</script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/js/bootstrap.js?ver=2.0'></script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/js/lightbox/jquery.lightbox.min.js?ver=1.7.1'></script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/js/waypoints.min.js?ver=1.1.7'></script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/js/jquery.flexslider-min.js?ver=2.2.0'></script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/js/jquery.jplayer.min.js?ver=2.2.0'></script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/js/main.js?ver=0.0.1'></script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/js/custom.theme.isotope.js?ver=0.0.1'></script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/js/custom.theme.js?ver=0.0.1'></script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/functions/pagebuilder/js/theme.pagebuilder.js?ver=0.0.1'></script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-includes/js/wp-embed.min.js?ver=4.6.1'></script>
</body>
</html>
<!-- <div class="contactos" data-bottom-top="opacity:0; left:-150px;" data-top="opacity:1; left:0;"> -->