<?php
if (!session_id()) session_start();
include("../include/funciones_public.php");
include('../include/simple_html_dom.php');
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

$nConexion = Conectar();

$RegContenido = mysqli_fetch_object(VerContenido("metaTags"));
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle() ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php echo $sitioCfg["titulo"]; ?></title>
	<meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
	<meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
	<?php echo $RegContenido->contenido; ?>

	<link rel='stylesheet' id='ux-interface-pagebuild-css' href='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/styles/pagebuild.css?ver=0.0.1' type='text/css' media='screen' />
	<link rel='stylesheet' id='ux-interface-theme-style-css' href='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/styles/theme-style.php?ver=0.0.1' type='text/css' media='screen' />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $home; ?>/php/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $home; ?>/php/slick/slick-theme.css">
	<link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<?php if ($_GET["pagename"] == "contactenos") { ?>
		<!-- Event snippet for Contacto conversion page 
    <script>
      gtag('event', 'conversion', {'send_to': 'AW-665003357/wsqPCP6v1MgBEN3KjL0C'});
    </script>-->
	<?php } ?>

	<!-- Google Tag Manager -->
	<script>
		(function(w, d, s, l, i) {
			w[l] = w[l] || [];
			w[l].push({
				'gtm.start': new Date().getTime(),
				event: 'gtm.js'
			});
			var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s),
				dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
			f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', '<?php echo $sitioCfg["analytics"]; ?>');
	</script>
	<!-- End Google Tag Manager -->
</head>

<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $sitioCfg["analytics"]; ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<!-- matriz. -->
	<!--- Sección de menú --->
	<?php require_once("header.php"); ?>
	<!--- Sección de menú --->
	<div class="principal">
		<div id="skrollr-body">
			<?php
			// $url = "https://{$_SERVER['SERVER_NAME']}$home/sadminc/modulos/matriz/{$_GET["pagename"]}/";
			$protocolo = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
			$url = $protocolo . "{$_SERVER['SERVER_NAME']}$home/sadminc/modulos/matriz/{$_GET["pagename"]}/";
			// $url = "http://{$_SERVER['SERVER_NAME']}$home/sadminc/modulos/matriz/{$_GET["pagename"]}/";
			$html = file_get_html($url);
			// var_dump($html);
			foreach ($html->find('div#main') as $e)
				echo $e;
			?>
			<?php if ($_GET["pagename"] == "quienes-somos") { ?>
				<style>
					.volver{
						background: transparent;
						color: #AAAAAA;
						position: absolute;
						bottom:134vh;
						left: 0;
					}
					.volver>span{
						color: #243A44;
						font-size: 0.8rem;
						font-weight: 800;
					}
					.volver:hover{
						background: transparent;
						color: #AAAAAA;
						text-decoration: none;
					}
					.slider{
						display: none;
					}
					.container-producto{
						background-color: #EFEFEF;
						padding-top: 1rem;
						border-radius: 10px;
						
					}
					.mision-vision--container {
						display: flex;
						justify-content: center;
						width: 100%;
						gap: 20px;
						flex-wrap: wrap;
						/* position: relative; */
					}

					.mision-vision-campo--container {
						width: 32%;
						height: 200px;
						padding: 1rem 1.2rem;
						background-color: #243A44;
						border-radius: 20px;
						display: flex;
						flex-direction: column;
						justify-content: space-between;
					}

					.mision-vision-campo--container>h2 {
						color: #C8E638;
						font-weight: 800;
						font-size: 1.2rem;
					}

					.mision-vision-campo--container>p {
						color: #FFFFFF;
						font-size: 0.8rem;
					}

					.cell h2{
						color: #243A44;
						font-weight: 800;
						font-family: var(----fuente-sitio3);
					}
					.cell p{
						color: #243A44;
						font-size: 0.8rem;
					}
					.cell iframe{
						height: 100%;
						width: 100%;
					}
					.quienes-somos--layout {
						display: grid;
						grid-template-columns: repeat(3, 1fr);
						grid-template-rows: 1fr 1fr;

						gap: 30px;
						width: 100%;
						height: 100%;
						margin-top: 30px;
						padding: 0px 10px;
						/* max-height: 80%; */
					}

					.flex--container{
						display: flex;
					}
					
					.cell:nth-child(1) {
						grid-column: 1 / 2;
						grid-row: 1 / 3;
					}

					.cell:nth-child(2) {
						grid-column: 2 / 4;
						grid-row: 1 / 2;
						border-radius: 30px;
						overflow: hidden;
					}

					.cell:nth-child(3) {
						grid-column: 2 / 3;
						grid-row: 2 / 3;
					}

					.cell:nth-child(4) {
						grid-column: 3 / 4;
						grid-row: 2 / 3;
					}

					@media(max-width:1000px){
						.mision-vision-campo--container{
							min-width: 281px;
							padding: 1rem 1rem;
						}
						
					}
					@media(max-width:756px){
						.mision-vision-campo--container{
							min-width: 281px;
							padding: 1rem 1rem;
						}
						.quienes-somos--layout{
							display: flex;
							flex-direction: column;

						}
					}
				</style>
				<script type="text/javascript">
					$(window).ready(function() {
						$('.ampliar').on('click', function(e) {
							e.preventDefault();
							$('.descripcionS').toggleClass("abierto");
							$(this).toggleClass("activo");
							var text = $(this).text();
							if (text === "Ver más") {
								$(this).html('Ver menos');
							} else {
								$(this).text('Ver más');
							}
						});
					});
				</script>
			<?php } ?>
			<?php if ($_GET["pagename"] != "home") { ?>
				<div class="fullwrap_moudle pb-5">
					<div class="container">
						<a href="<?php echo $home; ?>/" class="volver"><span><</span> Volver</a>
					</div>
				</div>
				<style>
					.logo {
						display: none !important;
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
			<?php } ?>
			<script src="<?php echo $home; ?>/php/slick/slick.js" type="text/javascript"></script>
			<!--- Sección de Creado por --->
			<!-- <?php require_once("footer.php"); ?> -->
			<!--- Sección de Creado por 
			<div class="arrow bounce">
				<span class="fa fa-arrow-down fa-2x"></span>
			</div>--->
		</div>
	</div>
	<?php if ($_GET["pagename"] == "home") { ?>
		<script type='text/javascript' src='<?php echo $home; ?>/php/js/skrollr.js'></script>
		<script>
			$(".tablinks").click(function() {
				var i, tabcontent, tablinks;
				tabcontent = $("#p-destacados .slick-slider");
				for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
				}
				tablinks = document.getElementsByClassName("tablinks");
				for (i = 0; i < tabcontent.length; i++) {
					tablinks[i].classList.remove("active");
				}
				document.getElementById($(this).data("id")).style.display = "block";
				$(this).addClass("active");
				tabcontent.slick('setPosition');
			});
			document.getElementById("defaultOpen").click();
		</script>
	<?php } ?>
	<script>
		window.onload = function() {
			if (screen.width > 480) {
				var s = skrollr.init({
					forceHeight: false
				});
			}
		};
	</script>
	<?php if ($_GET["pagename"] == "home") { ?>
		<script>
			jQuery(function() {
				jQuery('.columna-der .row').attr({
					'data-bottom-top': 'opacity: 0; left: 200px;',
					'data-bottom-bottom': 'opacity: 1; left: 0px;'
				});
			});
		</script>
	<?php } ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/js/main.js?ver=0.0.1'></script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/js/custom.theme.isotope.js?ver=0.0.1'></script>
	<script type='text/javascript' src='<?php echo $home; ?>/sadminc/modulos/matriz/wp-content/themes/aside/functions/pagebuilder/js/theme.pagebuilder.js?ver=0.0.1'></script>
</body>

</html>