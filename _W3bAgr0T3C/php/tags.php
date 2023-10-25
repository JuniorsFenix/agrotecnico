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

	

	$sitioCfg = sitioAssoc();

    $nConexion = Conectar();

	

	$tag = $_GET["tag"];

	$sql2 = "";

	

    switch($_GET["modulo"])

    {

      case  "servicios":

		$modulo = "tblservicios";

        break;

      case "eventos":

		$modulo = "tbleventos";

        break;

      case "escorts":	

		$modulo = "tblti_productos";

		$sql2 = " and (activa=1)";

        break;

      case "noticias":	

		$modulo = "tblnoticias";

        break;

      default:

        header("Location: /home");

        break;

    }

	

	$sql = "SELECT * FROM $modulo WHERE 1=1";

	$sql.=$sql2;

	$sql.=" and tags LIKE '%$tag,%' OR tags LIKE '$,tag,%' OR tags LIKE '%,$tag' OR tags = '$tag'";

	$ca = new DbQuery($nConexion);

	$ca->prepare($sql);	

        //echo "XXXX ".$ca->preparedQuery();

	

	$pag = isset($_GET["pag"]) ? $_GET["pag"]:1;

	$page = $ca->execPage(array("pager"=>true,"page"=>$pag,"count"=>25,"pagerVars"=>"{$pageVars}"));

	

	$imagenes=array();

  $ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0 order by idimagen desc");

  while( $imagen = mysqli_fetch_assoc($ras) ){

    $imagenes[ $imagen["idproducto"] ] = $imagen;

  }

	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));



?>



<!DOCTYPE HTML>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />

    <title><?php echo $tag; ?> - <? echo Titulo_Sitio(); ?></title>

    <? Meta_Tag_General(); ?>

	<?php echo $RegContenido->contenido; ?>

    <meta content="on" http-equiv="cleartype">

	<meta content="True" name="HandheldFriendly">

	<meta content="320" name="MobileOptimized">

	<meta content="initial-scale=1.0" name="viewport">

    <link href="/css/estilos.css" rel="stylesheet" type="text/css" />

    <link href="/css/paginador.css" rel="stylesheet" type="text/css" />

    <link href='https://fonts.googleapis.com/css?family=Exo:400,700' rel='stylesheet' type='text/css'>

    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

	<script src="/php/js/jquery.easing.1.3.js"></script>

    <!--[if IE]>

      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

    <![endif]-->

	<script type="text/javascript" src="/php/js/prefixfree.min.js"></script>

    <script type="text/javascript" src="/php/js/generales.js"></script>        



</head>

<body>

	<header>

        <h1 class="logo">

        	<?php echo $sitioCfg["logo"]; ?>

        </h1>

        <button class="menuP">

          <span>toggle menu</span>

        </button>   

    </header>

    <nav class="menu">

        <?php echo $sitioCfg["logo"];

         	ImprimirMenuPpal3();?>

    </nav>

    <div class="principal">

	<div id="skrollr-body">

        <!--Inicio Slider-->

        <?php echo cabezoteJqueryIn(4,"carousel"); ?>

        <!--Final Slider-->

        <section class="contenidoInterno">

        	<div class="container">

            	<div class="col1">

					<?

                    $imagen="/imagenes/default.jpg";

                    if ( $page["error"] == false )

                    {

                    foreach($page["records"] as $RegTags){

        

                    switch($_GET["modulo"])

                    {

                      case  "servicios":

                        $url = "/servicios/{$RegTags['url']}";

                        if(!empty($RegTags["imagen"])) {

                        $imagen = $cRutaVerImgServicios.$RegTags["imagen"];

                        }

                        $titulo = $RegTags["servicio"];

                        $contenido = $RegTags["detalle"];

                        break;

                      case "eventos":

                        $url = "/eventos/{$RegTags['url']}";

                        if(!empty($RegTags["imagen"])) {

                        $imagen = $cRutaVerImgEventos.$RegTags["imagen"];

                        }

                        $titulo = $RegTags["evento"];

                        $contenido = $RegTags["detalle"];

                        break;

                      case "productos":	

                        $url = "/productos/{$RegTags['url']}";

                        if(!empty($imagenes[$RegTags["idproducto"]]["imagen"])) {

                        $imagen = $cRutaVerImagenTienda."m_".$imagenes[$RegTags["idproducto"]]["imagen"];

                        }

                        $titulo = $RegTags["nombre"];

                        $contenido = $RegTags["descripcion"];

                        break;

                      case "noticias":	

                        $url = "/noticias/{$RegTags['url']}";

                        if(!empty($RegTags["imagen"])) {

                        $imagen = $cRutaVerImgNoticias.$RegTags["imagen"];

                        }

                        $titulo = $RegTags["titular"];

                        $contenido = $RegTags["noticia"];

                        break;

                      default:

                        header("Location: /home");

                        break;

                    }

                    ?>

                    

                    <?php if(!empty($imagen))

                    {

                    ?>

                    <a class="imagenLista" href="<? echo $url; ?>" title="<? echo $titulo; ?>"><img src="<? echo $imagen; ?>" alt="<? echo $titulo; ?>" /></a>

                    <?php 

                    } 

                    ?>

                    <div id="contenidoInterno" class="lista">

                    <h2><?php echo $titulo; ?></h2>

        

                    <p><?php echo substr(strip_tags($contenido),0,250)."..."; ?></p>

        

                    <a href="<?php echo $url; ?>" title="<?php echo $titulo; ?>" class="link">

                    <!-- Imprimir Contenido=BotonVerProductos-->

                    <?

                    $RegContenido = mysqli_fetch_object(VerContenido( "BotonVerMas" ));

                    echo $RegContenido->contenido;

                    ?>

                    <!-- Fin Contenido=BotonVerProductos-->

                    </a>

                    </div>

                    <div class="clear"></div><br>

                    <?php

                    

                    }

                    echo $page["pager"];

                }

                else

                {

                  echo "No se encontraron Tags.";

                }

                ?>

                </div>

                <div class="col2">

            		<?php CargarFormulario()?>

                </div>

            </div>

        </section>

        <!--Inicio Footer-->

            <footer>

                <div class="creditos">

                    <?php CargarCreditos()?>

                </div>

            </footer>

            <!--Final Footer-->
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


    <?php CargarCodigoGoogleAnalitic()?>

</body>

</html>