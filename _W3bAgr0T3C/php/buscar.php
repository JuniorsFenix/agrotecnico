<?php
if (!session_id()) session_start();
include("../include/funciones_public.php");
require_once("inc/functions.php");
$sitioCfg = sitioAssoc();
$home = $sitioCfg["url"];
include("../admin/vargenerales.php");

if (!isset($_GET["buscar"])) {
	header("Location: $home");
}

$generales = datosGenerales();
$nConexion = Conectar();

$imagenes = array();
$ras = mysqli_query($nConexion, "select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
while ($imagen = mysqli_fetch_assoc($ras)) {
	$imagenes[$imagen["idproducto"]] = $imagen;
}

if (!empty($generales["titulo_productos"])) {
	$titulo = $generales["titulo_productos"];
} else {
	$titulo = $sitioCfg["titulo"];
}

if (!empty($generales["palabras_productos"])) {
	$palabras = $generales['descripcion_productos'];
} else {
	$palabras = $sitioCfg["palabras_clave"];
}

// $RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
// $descripcion = $generales['descripcion_productos'];
// $currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// $data = file_get_contents($currentURL);

$buscar = $_GET["buscar"];


?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title><?php echo $buscar; ?> - <?php echo $titulo; ?></title>
	<meta name="description" content="<?php echo $rxProducto["metaDescripcion"]; ?>">
	<meta name="keywords" content="<?php echo $palabras; ?>">
	<?php echo $RegContenido->contenido; ?>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

	<!--- <link href="https://fonts.googleapis.com/css?family=Rock+Salt" rel="stylesheet"> --->
	<link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:300,400&subset=latin-ext" rel="stylesheet">
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
		<div id="skrollr-body">
			<!--- Sección de banner --->
			<?php echo cabezoteJqueryIn(2, "carousel"); ?>
			<!--- Sección de banner --->
			<!--- Sección de Noticias/tendencias --->
			<section class="contenidoInterno">
				<?php
				$referencia = $_GET["referencia"];
				$marca = $_GET["marca"];
				$segmento = $_GET["segmento"];
				$hogar = $_GET["hogar"];
				// var_dump($segmento);
				?>
				<div class="container">

					<h2><?php echo $buscar; ?></h2>
					<div class="row">
						<?php
						$nConexion = Conectar();
						mysqli_set_charset($nConexion, 'utf8');

						$marca = mysqli_real_escape_string($nConexion, $marca);
						$referencia = mysqli_real_escape_string($nConexion, $referencia);
						$buscar = mysqli_real_escape_string($nConexion, $buscar);
						$segmento = mysqli_real_escape_string($nConexion, $segmento);

						// Build the SQL query to search for products based on "marca," "referencia," and/or "nombre"
						$query = "SELECT * FROM tblti_productos WHERE activo = 1 AND inventario > 3";

						if (!empty($referencia) && !empty($buscar) && !empty($marca)) {
							$query .= " AND (referencia LIKE '%$referencia%' OR nombre LIKE '%$buscar%')";
						} elseif (!empty($marca)) {
							$marcaQuery = "SELECT idmarca FROM tblti_marcas WHERE nombre = '$marca'";
							$resultMarca = mysqli_query($nConexion, $marcaQuery);
							if ($resultMarca && mysqli_num_rows($resultMarca) > 0) {
								$marcaRow = mysqli_fetch_assoc($resultMarca);
								$query .= " AND idmarca = '{$marcaRow["idmarca"]}'";
							}
						} elseif (!empty($referencia)) {
							$query .= " AND referencia LIKE '%$referencia%'";
						} elseif (!empty($buscar)) {
							$query .= " AND nombre LIKE '%$buscar%'";
						}

						if (!empty($segmento)) {
							$segmentoQuery = "SELECT idcategoria FROM tblti_categorias WHERE nombre = '$segmento'";
							$resultSegmento = mysqli_query($nConexion, $segmentoQuery);
							if ($resultSegmento && mysqli_num_rows($resultSegmento) > 0) {
								$segmentoRow = mysqli_fetch_assoc($resultSegmento);
								$query .= " AND idcategoria = '{$segmentoRow["idcategoria"]}'";
							}
						}
						if (!empty($hogar)) {
							$hogarQuery = "SELECT id FROM agro_categoria WHERE nombre = '$hogar'";
							$resultHogar = mysqli_query($nConexion, $hogarQuery);
							if ($resultHogar && mysqli_num_rows($resultHogar) > 0) {
								// var_dump($resultHogar);
								$hogarRow = mysqli_fetch_assoc($resultHogar);
								$query .= " AND usos = '{$hogarRow["id"]}'";
							}
						}

						$result = mysqli_query($nConexion, $query);

						if ($result) {
							while ($rax = mysqli_fetch_assoc($result)) {
						?>
								<div class="listado col-sm-6 col-lg-3">
									<a class="imagenBlog" href='<?php echo "$home/productos/{$rax["url"]}" ?>'>
										<img alt="<?php echo $rax["nombre"] ?>" src='<?php echo "{$cRutaVerImagenTienda}m_{$imagenes[$rax["idproducto"]]["imagen"]}" ?>'>
									</a>
									<h3><?php echo $rax["nombre"] ?></h3>
									<a href='<?php echo "$home/productos/{$rax["url"]}" ?>' class='link'>Ver más</a>
								</div>
						<?php
							}
						} else {
							echo "Hubo un problema al buscar productos.";
						}
						mysqli_close($nConexion);
						?>
					</div>

					<a href="<?php echo $home; ?>/productos" class="volver">Volver</a>
				</div>
			</section>
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
			<div class="arrow bounce">
				<span class="fa fa-arrow-down fa-2x"></span>
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>