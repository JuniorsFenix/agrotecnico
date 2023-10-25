<?php

if (!session_id()) session_start();

include("../include/funciones_public.php");

ValCiudad();

$sitioCfg = sitioAssoc();

$home = $sitioCfg["url"];

include("../admin/vargenerales.php");

require_once("../admin/herramientas/seguridad/validate.php");



$IdCiudad = varValidator::validateReqInt("get", "ciudad", true);

if (is_null($IdCiudad)) {

	echo "Valor de entrada invalido para la variable ciudad";

	exit;
}





$generales = datosGenerales();

$nConexion = Conectar();



$cError	= "N";

if (!isset($_GET["clave"])) {

	$cError = "S";
} else {

	$rsContenido	= VerContenido($_GET["clave"]);

	if (mysqli_num_rows($rsContenido) == 0) {

		echo "<script language=\"javascript\">location.href='/pagina-no-encontrada'</script>";
	}

	$RegContenido	= mysqli_fetch_array($rsContenido);

	$cTitulo		= $RegContenido["titulo"];

	$cContenido		= $RegContenido["contenido"];

	if (!empty($RegContenido["imagen"])) {

		$cImagen	= $cRutaVerImgContenidos . $RegContenido["imagen"];
	} else {

		$cImagen	= "";
	}

	mysqli_free_result($rsContenido);
}



$RegContenido = mysqli_fetch_object(VerContenido("metaTags"));



?>



<!DOCTYPE html>

<html lang="es">

<head>

	<meta charset="utf-8">

	<title><?php echo $cTitulo; ?> - <?php echo $sitioCfg["titulo"]; ?></title>

	<meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">

	<meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">

	<?php echo $RegContenido->contenido; ?>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">



	<!--- <link href="https://fonts.googleapis.com/css?family=Rock+Salt" rel="stylesheet"> --->

	<link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:300,400&subset=latin-ext" rel="stylesheet">

	<link href="<?php echo $home; ?>/css/bootstrap.css" rel="stylesheet" type="text/css">

	<link href="<?php echo $home; ?>/css/estilos.css" rel="stylesheet" type="text/css">

	<script src="<?php echo $home; ?>/js/modernizr.custom.37797.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>



</head>



<body>

	<!--- Sección de menú --->

	<?php require_once("header.php"); ?>

	<!--- Sección de menú --->



	<!--- Sección de banner --->

	<?php echo cabezoteJqueryIn(2, "carousel"); ?>

	<!--- Sección de banner --->



	<!--- Sección de Noticias/tendencias --->

	<section class="contenidoInterno">

		<div class="container">

			<?php

			if (!empty($cImagen)) {

			?>

				<img src="<?php echo $cImagen; ?>" alt="<?php echo $cTitulo; ?>" class="imagenInterna" />

			<?php

			}

			?>

			<?php

			if ($cError == "S") {

			?>

				No se envio la clave del contenido para mostrar...

			<?php

			} else {

				echo $cContenido;
			}

			?>

			<div class="clear"></div>

			<a class="link" href="<?php echo $home; ?>/">

				<!-- Imprimir Contenido=BotonRegresar-->

				<?php

				$RegContenido = mysqli_fetch_object(VerContenido("BotonRegresar"));

				echo $RegContenido->contenido;

				?>

				<!-- Fin Contenido=BotonRegresar-->

			</a>

			<div class="clear"></div>

			<?php echo fbMegusta("http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}"); ?>

			<br />

			<?php echo fbComentarios("http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}"); ?>

		</div>

	</section>

	<!--- Sección de Noticias/tendencias --->



	<!--- Sección mapa --->

	<?php echo CargarMapaGoogle(); ?>

	<!--- Sección mapa --->



	<!--- Sección de Creado por --->

	<?php require_once("footer.php"); ?>

	<!--- Sección de Creado por --->
	<style>
		.logo {
			display: none;
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

		.menu-ppal .activo a,
		.menu-ppal .activo:hover a {
			color: #fff;
		}

		@media only screen and (max-width: 820px) {
			.logoBarra {
				opacity: 1;
				display: block;
				right: 70px;
			}

			.logoBarra img {
				height: 38px !important;
				width: auto !important;
			}
		}
	</style>



	<script>
		function myFunction() {

			var x = document.getElementById("myTopnav");

			if (x.className === "topnav") {

				x.className += " responsive";

			} else {

				x.className = "topnav";

			}

		}
	</script>

</body>

</html>



<!-- <div class="contactos" data-bottom-top="opacity:0; left:-150px;" data-top="opacity:1; left:0;"> -->