<?php
if (!session_id()) session_start();
include("../include/funciones_public.php");
ValCiudad();
$sitioCfg = sitioAssoc();
$home = $sitioCfg["url"];
$modulo = $_GET["modulo"];
$url = $_GET["url"];
include("../admin/vargenerales.php");
require_once("../admin/herramientas/seguridad/validate.php");

$IdCiudad = varValidator::validateReqInt("get", "ciudad", true);
if (is_null($IdCiudad)) {
	echo "Valor de entrada invalido para la variable ciudad";
	exit;
}

$nConexion = Conectar();
mysqli_set_charset($nConexion, 'utf8');
$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE tabla = '$modulo'");
$matriz     = mysqli_fetch_array($Resultado);
$idmatriz = $matriz["id"];

$Resultado    = mysqli_query($nConexion, "SELECT * FROM `$modulo` WHERE url='$url' AND publicar='S'");

if (mysqli_num_rows($Resultado) == 0) {
	header("Location: /$modulo");
	exit;
}

$RegContenido = mysqli_fetch_object(VerContenido("metaTags"));
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle() ?>" />
	<title><?php echo $sitioCfg["titulo"]; ?></title>
	<meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
	<meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
	<?php echo $RegContenido->contenido; ?>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

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
	<!--- Sección de menú --->
	<?php require_once("header.php"); ?>
	<!--- Sección de menú --->
	<div class="principal">
		<div class="contenidoGeneral">
			<div class="container">
				<?php
				//$adjuntos = mysqli_query($nConexion,"SELECT * FROM adjuntos_matriz WHERE idmatriz = $idmatriz and idcontenido = {$Registro["id"]}");
				$campos    = mysqli_query($nConexion, "SELECT * FROM campos ca JOIN campos_matriz cm on (ca.campo=cm.campo) WHERE cm.idmatriz = '$idmatriz' ORDER BY cm.id ASC");

				while ($Registro = mysqli_fetch_assoc($Resultado)) :
					$fotos    = mysqli_query($nConexion, "SELECT * FROM imagenes_matriz WHERE idmatriz = $idmatriz and idcontenido = {$Registro["id"]} LIMIT 1"); ?>
					<h2><?php echo $matriz["titulo"]; ?></h2>
					<div class="row">
						<div class="col-md-4">
							<?php if (!mysqli_num_rows($fotos)) { ?>
								<img class="rounded" src="<?php echo "$home/fotos/Image/contenidos/"; ?>default.jpg" />
							<?php }
							while ($Fotos = mysqli_fetch_object($fotos)) : ?>
								<img class="rounded" src="<?php echo $home . "/fotos/Image/" . $modulo . "/" . $Fotos->imagen; ?>" />
								<p class="text-secondary text-center"><?php echo $Fotos->texto; ?></p>
							<?php endwhile;  ?>
						</div>
						<div class="campos col-md-8">
							<?php while ($r = mysqli_fetch_assoc($campos)) :
								if ($r["campo"] == "Descripcion") { ?>
									<p><?php echo $Registro["Descripcion"]; ?></p>
								<?php } elseif ($r["tipo"] == "file") { ?>
									<ul class="adjuntos">
										<?php /*while($Adjuntos = mysqli_fetch_object($adjuntos) ):?>
				  <li class="<?php echo $Adjuntos->adjunto; ?>">
					<a target="_blank" href="<?php echo $cRutaVerImgGeneral.$modulo."/".$Adjuntos->adjunto; ?>"><?php echo $Adjuntos->adjunto; ?></a>
				  </li>
				<?php endwhile;*/ ?>
									</ul>
									<?php  } else {
									if ($r["campo"] == "Titulo") { ?>
										<h3><?php echo $Registro[$r["campo"]]; ?></h3>
									<?php  } elseif ($r["campo"] == "Subtitulo") { ?>
										<h4><?php echo $Registro[$r["campo"]]; ?></h4>
									<?php  } else { ?>
							<?php }
								}
							endwhile;
							if ($modulo == "servicios") {
								$RegContenido = mysqli_fetch_object(VerContenido("boton-asesoria"));
								echo $RegContenido->contenido;
							} ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
			<div class="fullwrap_moudle">
				<div class="container">
					<a href="<?php echo "$home/$modulo"; ?>" class="volver">Volver</a>
				</div>
			</div>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script src="<?php echo $home; ?>/php/slick/slick.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $home; ?>/php/slick/slick.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $home; ?>/php/slick/slick-theme.css">
		<!--- Sección de Creado por --->
		<?php require_once("footer.php"); ?>
		<!--- Sección de Creado por --->
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
		<div class="arrow bounce">
			<span class="fa fa-arrow-down fa-2x"></span>
		</div>
	</div>
</body>

</html>