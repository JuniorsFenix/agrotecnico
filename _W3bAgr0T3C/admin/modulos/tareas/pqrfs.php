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
	$_GET["clave"] = "pqrfs";
  		$cError	= "N";
	if ( !isset($_GET["clave"]) )
	{
		$cError = "S";
	}
	else
	{
		$rsContenido	= VerContenido( $_GET["clave"] );
		if( mysqli_num_rows($rsContenido)== 0 ){
		echo "<script language=\"javascript\">location.href='/pagina-no-encontrada'</script>";
		}
		$RegContenido	= mysqli_fetch_array( $rsContenido );
		$cTitulo		= $RegContenido["titulo"];
		$cContenido		= $RegContenido["contenido"];
		if ( !empty($RegContenido["imagen"]) )
		{
			$cImagen	= $cRutaVerImgContenidos . $RegContenido["imagen"];
		}
		else
		{
			$cImagen	= "";
		}
		mysqli_free_result($rsContenido);
	}
  
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));

?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml"
    xmlns:og="http://ogp.me/ns#"
    xmlns:fb="http://www.facebook.com/2008/fbml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title>Peticiones, Quejas, Reclamos, Felicitaciones y Sugerencias - <?php echo $sitioCfg["titulo"]; ?></title>
    
    <meta property="og:title" content="<?php echo $cTitulo; ?> - <?php echo $sitioCfg["titulo"]; ?>"/>
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo "http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}";?>" />
    <meta property="og:image" content="<?php echo $cRutaVerImgContenidos.$RegContenido->imagen ; ?>" />
    <meta property="og:site_name" content="<?php CargarMetaSiteNameFaceBook()?>" />
    <meta property="fb:admins" content="<?php CargarMetaIdFaceBook()?>" />
    <meta property="og:description" content="<?php echo substr(strip_tags($cContenido),0,80)."..."; ?>" />
    
    <meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
    <meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
	<?php echo $RegContenido->contenido; ?>
    <meta content="on" http-equiv="cleartype">
	<meta content="True" name="HandheldFriendly">
	<meta content="320" name="MobileOptimized">
	<meta content="initial-scale=1.0" name="viewport">
    <link href="/css/customfonts/customfonts.css" rel="stylesheet" type="text/css" />
    <link href="/css/estilos.css" rel="stylesheet" type="text/css" />
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!--[if IE]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/php/js/generales.js"></script>
</head>
<body>
    <!--Inicio Header-->
	<header>
    <div class="botones">
    	<span class="telefono">
			<?php
            $RegContenido = mysqli_fetch_object(VerContenido( "telefono" ));
            echo $RegContenido->contenido; ?>
        </span>
        <nav>
			<?php
            $RegContenido = mysqli_fetch_object(VerContenido( "botones" ));
            echo $RegContenido->contenido; ?>
        </nav>
    </div>
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
        <?php echo $sitioCfg["logo"]; ?>
        <?php ImprimirMenuPpal3();?> 
    </nav>
    <!--Final menú-->
    <div class="principal">
        <div id="skrollr-body">
            <!--Inicio Slider-->
            <?php echo cabezoteJqueryIn(6,"carousel"); ?>
            <!--Final Slider-->
            <!--Inicio Servicios-->
        <section class="contenidoInterno">
        	<div class="container">
            	<div class="col1">
                    <h1>Peticiones, Quejas, Reclamos, Felicitaciones y Sugerencias</h1>
                    <form action="/gracias-por-contactarnos" class="formulario3" enctype="multipart/form-data" method="post" onsubmit="return validate1(this)">
                    <input id="ciudad" name="ciudad" type="hidden" value="1" />
                    <input maxlength="100" name="cliente" required placeholder="Nombre del cliente" />
                    <input maxlength="100" name="contacto" required placeholder="Nombre del contacto"  />
                    <input type="tel" maxlength="100" name="telefono" required pattern="\d+" placeholder="Teléfono/Celular"  />
                    <input type="email" maxlength="100" name="mail" required placeholder="Correo"  />
                    <label for="clasificacion">Clasificación</label>
                    <select name="clasificacion">
                        <option value="Petición">Petición</option>
                        <option value="Queja">Queja</option>
                        <option value="Reclamo">Reclamo</option>
                        <option value="Felicitación">Felicitación</option>
                        <option value="Sujerencia">Sujerencia</option>
                    </select>
                    <p class="antispam">Dejar este campo vacio: <input type="text" name="url" /></p>
                    <textarea id="textarea" name="descripcion" rows="2" required placeholder="Descripción" ></textarea><br />
                    <input class="action-button" id="cmdEnviar" name="Submit" type="submit" value="Enviar" size="100"/>
                    <?php 
                    if ($cError=="S")
                    {
                    ?>
                    No  se envio la clave del contenido para mostrar...
                    <?php
                    }
                    else
                    {
                    echo "<p>$cContenido</p>";
                    }
                    ?> 
                        </form>
                     <a class="link" href="/home">
                    <!-- Imprimir Contenido=BotonRegresar-->
                    <?php
                    $RegContenido = mysqli_fetch_object(VerContenido( "BotonRegresar" ));
                    echo $RegContenido->contenido;
                    ?>
                    <!-- Fin Contenido=BotonRegresar-->
                    </a>
                    <div class="clear"></div>
                    <?php echo fbMegusta("http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}");?>
                    <br/>
                    <?php echo fbComentarios("http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}");?>
                </div>
                <div class="col2">
            		<?php CargarFormulario()?>
                </div>
            </div>
        </section>
        <!--Inicio Footer-->
        <footer>
            <?php CargarMapaNavegacion()?>
            <div class="creditos">
                <?php CargarCreditos()?>
            </div>
        </footer>
        <!--Final Footer-->
        </div>
    </div>
</body>
</html>