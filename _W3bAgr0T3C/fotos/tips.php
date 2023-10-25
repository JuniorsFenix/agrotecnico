<?php
    if(!session_id()) session_start();
	include("../include/funciones_public.php");
	ValCiudad();
	include("../admin/vargenerales.php");
	require_once ("../admin/herramientas/seguridad/validate.php");
	
	$IdCiudad=varValidator::validateReqInt("get","ciudad",true);
	if(is_null($IdCiudad)){
		echo "Valor de entrada invalido para la variable ciudad";
		exit;
	}
	
	$generales = datosGenerales();
	$sitioCfg = sitioAssoc();
    $nConexion = Conectar();	
	
	
	$sql = "select * from tbleventos where idciudad={$IdCiudad} AND publicar = 'S' order by idevento desc";
	$ca = new DbQuery($nConexion);
	$ca->prepare($sql);	
	$pag = isset($_GET["pag"]) ? $_GET["pag"]:1;
	$page = $ca->execPage(array("pager"=>true,"page"=>$pag,"count"=>8,"pagerVars"=>"ciudad=1&{$pageVars}"));
	
	
	if(!empty($generales["titulo_eventos"]))
	{
		$titulo = $generales["titulo_eventos"];
	}
	else
	{
		$titulo = $sitioCfg["titulo"];
	}
	
	if(!empty($generales["palabras_eventos"]))
	{
		$palabras = $generales['descripcion_eventos'];
	}
	else
	{
		$palabras = $sitioCfg["palabras_clave"];
	}
  
	$RegContenido = mysql_fetch_object(VerContenido( "metaTags" ));

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title><?php echo $titulo; ?></title>
    <meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
    <meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
	<?php echo $RegContenido->contenido; ?>
    <meta content="on" http-equiv="cleartype">
	<meta content="True" name="HandheldFriendly">
	<meta content="320" name="MobileOptimized">
	<meta content="initial-scale=1.0" name="viewport">
    <link href="/css/estilos.css" rel="stylesheet" type="text/css" />
  	<link href="/css/styles.css" rel="stylesheet" type="text/css"  />
    <link href="/css/paginador.css" rel="stylesheet" type="text/css" />
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <script src="/php/js/modernizr.custom.17475.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/php/js/jquery.fullPage.min.js"></script>
    <!--[if IE]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/php/js/generales.js"></script>
	<script type="text/javascript">
		$(document).ready(function() 
		{if(screen.width < 480) { 
			$('#skrollr-body').fullpage({
				scrollingSpeed: 2000,
				autoScrolling:false
			});
		return;
		} else {
			$('#skrollr-body').fullpage({
				autoScrolling:false
			});
		}
		});
	</script>
</head>
<body>
    <!--Inicio Header-->
	<header>
        <h1 class="logo">
        	<?php echo $sitioCfg["logo"]; ?>
        </h1>
        <button class="menuP">
          <span>toggle menu</span>
        </button>    
    </header>
    <!--Final Header-->
    <!--Inicio menú-->
    <nav class="menu">
        <?php echo $sitioCfg["logo"];
         ImprimirMenuPpal3();?>   
    </nav>
    <!--Final menú-->
    <div class="principal">
	<div id="skrollr-body">
    	<!--Inicio Servicios-->
        <section class="contenidoInterno section">
            <h1>
            <!-- Imprimir Contenido=TituloTips-->
            <?
            $RegContenido = mysql_fetch_object(VerContenido( "TituloTips" ));
            echo $RegContenido->contenido;
            ?>
            <!-- Fin Imprimir Contenido=TituloTips-->
            </h1>            <?php
            if ( $page["error"] == false )
            {
            foreach($page["records"] as $rax){
            ?>
                <div class="imagenLista">
                <?php
                if (!empty($rax["imagen"]))
                {
                ?>
                <img src="<?php echo $cRutaVerImgEventos.$rax["imagen"]; ?>" alt="<?php echo $rax["evento"]; ?>" />
				<?php	
                }
                else{
                ?>
                <img src="<?php echo $cRutaVerImgContenidos; ?>default.jpg" alt="<?php echo $rax["evento"]; ?>" />
                <?php	
                }
                ?>
                </div>
            	<div class="lista">
                <h2>
                <?php echo $rax["evento"]; ?>
                </h2>
                <?php echo substr(strip_tags($rax["detalle"]),0,350)."..."; ?>
                <a href="/tips/<?php echo $rax["url"]; ?>" title="<?php echo $rax["evento"]?>" class="link">
                <!-- Imprimir Contenido=BotonVerEventos-->
                <?
                $RegContenido = mysql_fetch_object(VerContenido( "BotonVerEventos" ));
                echo $RegContenido->contenido;
                ?>
                <!-- Fin Imprimir Contenido=BotonVerEventos-->
                </a>
                </div>
                <div class="clear"></div>
                <?php
                }
                echo $page["pager"];
            }
            else
            {
              echo "No se encontraron Eventos.";
            }
            ?>	
        </section>
    	<!--Final Servicios-->
        <section class="mapa section"> 
        	<?php echo CargarMapaGoogle()?>  
            <div class="contactos">
				<?php
                $RegContenido = mysql_fetch_object(VerContenido( "contactos-home" ));
                echo $RegContenido->contenido;
                ?>
            </div>
    		<!--Inicio Footer-->
        	<footer>
                <nav>
					<?php
                    $RegContenido = mysql_fetch_object(VerContenido( "mapanavegacion" ));
                    echo $RegContenido->contenido;
                    ?>
                </nav>
                <div class="creditos">
            		<?php CargarCreditos()?>
                </div>
            </footer>
    		<!--Final Footer-->
        </section>
    </div>
    </div>
    <script src="/php/js/skrollr.js"></script>
	<script type="text/javascript">
	if(screen.width > 480) {
		var s = skrollr.init({
			forceHeight: false
		});
	}
	</script>
</body>
</html>