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
	
	
		$rsCategorias = videosYoutubeSubCategorias();
	if(!$rsCategorias){
	    die("Fallo consultando categorias de videos");    
	}
	    
	
	if( isset($_GET["idvideo"]) ){
	    $rxVideo = videosYoutubeAssoc($_GET["idvideo"]);
	    $rsVideos = videosYoutube($rxVideo["idcategoria"]);  
	}
	else {
	    $rsVideos = videosYoutube( isset($_GET["categoria"]) ? $_GET["categoria"]:-1 ,"rand()");
	    $rxVideo = mysqli_fetch_assoc($rsVideos);
	    $rsVideos = videosYoutube($rxVideo["idcategoria"]);  
	}
	
	$url = explode("watch?v=",$rxVideo["url"]);
	$url = explode("&",$url[1]);
	$url = $url[0];
	$rxCategoria = videosYoutubeCategoriaAssoc($rxVideo["idcategoria"]);
	
		if(!empty($generales["titulo_videos"]))
	{
		$titulo = $generales["titulo_videos"];
	}
	else
	{
		$titulo = $sitioCfg["titulo"];
	}
	
	if(!empty($generales["palabras_videos"]))
	{
		$palabras = $generales['palabras_videos'];
	}
	else
	{
		$palabras = Palabras_Claves();
	}

	
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
	$descripcion = $generales['descripcion_videos'];

?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title><?php echo $titulo; ?></title>
    <meta name="description" content="<?php echo $descripcion; ?>">
    <meta name="keywords" content="<?php echo $palabras; ?>">
	<?php echo $RegContenido->contenido; ?>
    <meta content="on" http-equiv="cleartype">
	<meta content="True" name="HandheldFriendly">
	<meta content="320" name="MobileOptimized">
	<meta content="initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Exo:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <!--[if IE]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->   

</head>
<body>
	<!--- Sección de menú --->
	<?php require_once("header.php");?>
	<!--- Sección de menú --->
    <div class="principal">
	<div id="skrollr-body">
        <!--Inicio Slider-->
        <?php echo cabezoteJqueryIn(5,"carousel"); ?>
        <!--Final Slider-->
        <section class="contenidoInterno">
        	<div class="container">
                    <h1>
                        <!-- Imprimir Contenido=TituloVideos-->
                        <?
                        $RegContenido = mysqli_fetch_object(VerContenido( "TituloVideos" ));
                        echo $RegContenido->contenido;
                        ?>
                        <!-- Fin Imprimir Contenido=TituloVideos-->
                    </h1>
                    <div id="descripcion">
                        <h2><?=$rxVideo["nombre"];?></h2>
                        <p>
                        <?=$rxVideo["descripcion"];?>
                        </p>
                    </div>
                    <div id="video">
						<div class="videoWrapper">
							<iframe src="https://www.youtube.com/embed/<?php echo $url; ?>" frameborder="0" allowfullscreen></iframe>
						</div>
                    </div>
                    <div class="clear"></div>
                    <div id="relacionados">
                          <h1>Videos Relacionados</h1>
                        <?php while($rax=mysqli_fetch_assoc($rsVideos)): ?>
                        <div class="miniatura">
                            <a href="<?php echo $home; ?>/videos/video<?=$rax["idvideo"];?>" class="linkVideo">
                            <img src="<?=videosYoutubePreview($rax["url"]);?>" alt="<?=$rax["nombre"];?>"  />
                            <span class="tituloVideo">
                            <?=$rax["nombre"];?>
                            </span>
                            </a>
                        </div>
                        <?php endwhile;?>
                    </div>
            </div>
        </section>
		<!--- Sección de Creado por --->
		<?php require_once("footer.php");?>
		<!--- Sección de Creado por --->
			<style>
			    .logo{
			        display:none;
			    }
			    .logoBarra {
							opacity: 1;
					}
					header {
							background: #fff;
							opacity: 1;
					}
					.menu-ppal li a {
							color: #333;
					}
					.menu-ppal .activo {
							background: #38892F;
					}
					.menu-ppal .activo a, .menu-ppal .activo:hover a {
							color: #fff;
					}
					@media only screen and (max-width: 820px){
						.logoBarra {
							opacity: 1;
							display: block;
    					right: 70px;
						}
						.logoBarra img {
							height: 38px!important;
							width: auto!important;
						}
					}
			</style>
    </div>
    </div>
	<script>
		window.onload = function() {
			jQuery.each(jQuery('*'), function() { if (jQuery(this).width() > jQuery('body').width()) { console.log(jQuery(this).get(0)); } }).length;
		};
	</script>
</body>
</html>