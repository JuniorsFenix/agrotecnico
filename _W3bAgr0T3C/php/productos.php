<?php
if (!session_id()) session_start();
include("../include/funciones_public.php");
require_once("inc/functions.php");
$sitioCfg = sitioAssoc();
$home = $sitioCfg["url"];
include("../admin/vargenerales.php");

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

$RegContenido = mysqli_fetch_object(VerContenido("metaTags"));
$descripcion = $generales['descripcion_productos'];



// $imagenes = array();
// $ras = mysqli_query($nConexion, "select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
// while ($imagen = mysqli_fetch_assoc($ras)) {
// 	$imagenes[$imagen["idproducto"]] = $imagen;
// }

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title>Productos - <?php echo $titulo; ?></title>
	<meta name="description" content="<?php echo $descripcion; ?>">
	<meta name="keywords" content="<?php echo $palabras; ?>">
	<?php echo $RegContenido->contenido; ?>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

	<!--- <link href="https://fonts.googleapis.com/css?family=Rock+Salt" rel="stylesheet"> --->
	<link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:300,400&subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- Event snippet for Categorías de productos conversion page 
  <script>
    gtag('event', 'conversion', {'send_to': 'AW-665003357/DALICJ2U48gBEN3KjL0C'});
  </script>-->

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
			<!--- Sección de Noticias/tendencias --->
			<section class="contenidoInterno">
				<div class="container">
					<div class="row">
						<div class="col-md-3">
							<div class="col-md-12 barra-lateral-marcas-categorias">
								<span>MARCAS</span>
							</div>
							<div class="marcas-sticky">
								<div class="accordion" id="marcasAcordeon">
									<?php
									$nConexion = Conectar();
									$result = mysqli_query($nConexion, "SELECT * FROM tblti_marcas WHERE idmarca IN (SELECT idmarca FROM tblti_productos WHERE activo=1) ORDER BY orden");
									$index = 0;
									while ($marca = mysqli_fetch_assoc($result)) :
									?>
										<div class="card">
											<div class="card-header" id="marcaHeading<?php echo $index; ?>">
												<h5 class="mb-0">
													<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#marcaCollapse<?php echo $index; ?>" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-controls="marcaCollapse<?php echo $index; ?>">
														<?php
														if ($marca["imagen"] == 'dontus.jpeg') {
															echo "<img class='imagen-marca' src='$home/fotos/tienda/marcas/{$marca["imagen"]}' alt='{$marca["nombre"]}' />";
														} else {
															echo "<img class='imagen-marca' src='$home/fotos/tienda/marcas/{$marca["imagen"]}' alt='{$marca["nombre"]}' />";
														}
														// echo $marca["nombre"];
														?>
													</button>
												</h5>
											</div>
											<div id="marcaCollapse<?php echo $index; ?>" class="collapse <?php echo $index === 0 ? 'show' : ''; ?>" aria-labelledby="marcaHeading<?php echo $index; ?>" data-parent="#marcasAcordeon">
												<div class="card-body">
													<ul class="list-group list-group-flush">
														<?php
														// Ahora, recuperamos las categorías de esta marca
														$marcaId = $marca["idmarca"];
														$marcaUrl = $marca["url"];
														$categoriaQuery = "SELECT * FROM tblti_categorias WHERE idcategoria!=0 AND idcategoria_superior=0 AND (idcategoria IN (SELECT idcategoria FROM tblti_productos WHERE idmarca=$marcaId) OR idcategoria IN (SELECT c.idcategoria_superior FROM tblti_categorias c INNER JOIN tblti_productos p ON c.idcategoria=p.idcategoria WHERE idmarca=$marcaId))";
														// $categoriaQuery = "SELECT * FROM tblti_categorias WHERE idcategoria IN (SELECT idcategoria FROM tblti_productos WHERE idmarca = $marcaId) OR idcategoria IN (SELECT idcategoria_superior FROM tblti_categorias WHERE idcategoria IN (SELECT idcategoria FROM tblti_productos WHERE idmarca = $marcaId))";
														$categoriaResult = mysqli_query($nConexion, $categoriaQuery);

														while ($categoria = mysqli_fetch_assoc($categoriaResult)) {
														?>
															<li class="list-group-item">
																<!-- <a href='<?php echo "$home/productos/marca/{$marca["url"]}/categoria/{$categoria["url"]}" ?>'> -->
																<a href='<?php echo "$home/productos/{$categoria["url"]}/{$marcaUrl}" ?>'>
																	<?php echo $categoria["nombre"]; ?>
																</a>
															</li>
														<?php } ?>
													</ul>
												</div>
											</div>
										</div>
									<?php
										$index++;
									endwhile;
									?>
								</div>
							</div>
						</div>

						<br>
						<br>
						<div class="col-md-9 order-md-1">
							<h2>CATEGORÍAS</h2>
							<div class="row productos-categorias">
								<div class="accordion w-100" id="accordionExample">
									<?php
									$nConexion = Conectar();
									mysqli_set_charset($nConexion, 'utf8');

									$query = "SELECT * FROM tblti_categorias 
									WHERE idcategoria != 0 AND idcategoria_superior = 0 AND 
									(idcategoria IN (SELECT idcategoria FROM tblti_productos) 
									OR idcategoria IN 
									(SELECT c.idcategoria_superior FROM tblti_categorias c INNER JOIN tblti_productos p ON c.idcategoria=p.idcategoria)) 
									ORDER BY orden";

									$result = mysqli_query($nConexion, $query);

									$categoriaCounter = 0; // Variable para rastrear el número de categorías
									while ($categoria = mysqli_fetch_assoc($result)) {

										if (empty($_GET["marca"])) {
											$categoriaCounter++;
									?>
											<div class="card">
												<div class="card-header productslist" id="heading<?php echo $categoriaCounter; ?>">
													<h5 class="mb-0">
														<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $categoriaCounter; ?>" aria-expanded="true" aria-controls="collapse<?php echo $categoriaCounter; ?>">
															<?php echo $categoria["nombre"]; ?>
														</button>
													</h5>
												</div>

												<div id="collapse<?php echo $categoriaCounter; ?>" class="collapse <?php echo ($categoriaCounter === 1) ? 'show' : ''; ?>" aria-labelledby="heading<?php echo $categoriaCounter; ?>" data-parent="#accordionExample">
													<div class="card-body d-flex" style="gap: 10px;">
														<?php
														if (!empty($_GET["categoria"])) {
															$url = $_GET["categoria"];
															$rxProducto = tiendaCategoriaAssoc($url);
														}
														if (!empty($_GET["marca"])) {
															$sql = mysqli_query($nConexion, "SELECT idmarca FROM tblti_marcas WHERE url='{$_GET["marca"]}'");
															$marca = mysqli_fetch_object($sql);
														}
														// Consulta SQL para obtener los productos de esta categoría
														// $sql = "SELECT * FROM tblti_productos WHERE idcategoria = " . $categoria["idcategoria"];

														// $rxProducto = tiendaCategoriaAssoc($categoria["idcategoria"]);
														if (!empty($_GET["marca"])) {
															// echo $rxProducto["idcategoria"];
															// echo $marca->idmarca;
															echo $categoriaUrlFormateada;
															$sql =
																"SELECT * 
														FROM tblti_productos 
														WHERE (
																idcategoria IN (SELECT idcategoria FROM tblti_categorias WHERE idcategoria_superior = {$rxProducto["idcategoria"]})
																And (idmarca = $marca->idmarca AND activo = 1)
															)
															or
															(
																idcategoria IN (SELECT idcategoria FROM tblti_categorias WHERE idcategoria = {$rxProducto["idcategoria"]})
																And (idmarca = $marca->idmarca AND activo = 1)
															)";
														} else {
															$sql = "SELECT * FROM tblti_categorias A 
														INNER JOIN tblti_productos B 
															ON A.idcategoria = B.idcategoria 
														WHERE activo=1 AND ( A.idcategoria_superior={$categoria["idcategoria"]}
															OR A.idcategoria={$categoria["idcategoria"]} )
														ORDER BY B.orden";
														}

														$productosResult = mysqli_query($nConexion, $sql);
														// var_dump($productosResult);

														$productoNum = 0;
														while ($producto = mysqli_fetch_assoc($productosResult)) {
															// var_dump($producto);
															$productoNum++;
															$imagenes = array();
															$ras = mysqli_query($nConexion, "select * from tblti_imagenes where idimagen<>0 order by idimagen desc");

															// Construir el array de imágenes
															while ($imagen = mysqli_fetch_assoc($ras)) {
																$imagenes[$imagen["idproducto"]] = $imagen;
															}

															echo '<div class="content-product-acordion"> 
																	<div class="product--title-container">
																		<h3>' . $producto["nombre"] . '</h3>
																	</div>';
															echo '<a class="imagenBlog" href="' . $home . '/productos/' . $producto["url"] . '">';

															if (isset($imagenes[$producto["idproducto"]])) {
																// Si hay una imagen correspondiente al producto
																$imagen = $imagenes[$producto["idproducto"]];
																echo "<img src='$home/fotos/tienda/productos/m_{$imagen["imagen"]}' alt='{$producto["nombre"]}' />";
															} else {
																// Si no hay una imagen correspondiente al producto, mostrar la imagen predeterminada
																echo "<img src='$home/fotos/Image/contenidos/default.jpg' />";
															}

															echo '</a>';
															echo '<a href="' . $home . '/productos/' . $producto["url"] . '" class="link">Ver más</a>';
															echo '</div>';
														}
														// echo $productoNum;
														?>
													</div>
												</div>
											</div>
											<?php
										} else {
											if (!empty($_GET["marca"]) && $categoria["url"] === $_GET["categoria"]) {
											?>
												<div class="card">
													<div class="card-header productslist" aria-expanded="true" id="heading<?php echo $categoriaCounter; ?>">
														<h5 class="mb-0">
															<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $categoriaCounter; ?>" aria-expanded="true" aria-controls="collapse<?php echo $categoriaCounter; ?>">
																<?php echo $categoria["nombre"]; ?>
															</button>
														</h5>
													</div>

													<div id="collapse<?php echo $categoriaCounter; ?>" class="collapse <?php echo ($categoriaCounter === 1) ? 'show' : ''; ?>" aria-labelledby="heading<?php echo $categoriaCounter; ?>" data-parent="#accordionExample">
														<div class="card-body d-flex" style="gap: 10px;">
															<?php
															if (!empty($_GET["categoria"])) {
																$url = $_GET["categoria"];
																$rxProducto = tiendaCategoriaAssoc($url);
															}
															if (!empty($_GET["marca"])) {
																$sql = mysqli_query($nConexion, "SELECT idmarca FROM tblti_marcas WHERE url='{$_GET["marca"]}'");
																$marca = mysqli_fetch_object($sql);
															}
															// Consulta SQL para obtener los productos de esta categoría
															// $sql = "SELECT * FROM tblti_productos WHERE idcategoria = " . $categoria["idcategoria"];

															// $rxProducto = tiendaCategoriaAssoc($categoria["idcategoria"]);
															if (!empty($_GET["marca"])) {
																// echo $rxProducto["idcategoria"];
																// echo $marca->idmarca;
																echo $categoriaUrlFormateada;
																$sql =
																	"SELECT * 
														FROM tblti_productos 
														WHERE (
																idcategoria IN (SELECT idcategoria FROM tblti_categorias WHERE idcategoria_superior = {$rxProducto["idcategoria"]})
																And (idmarca = $marca->idmarca AND activo = 1)
															)
															or
															(
																idcategoria IN (SELECT idcategoria FROM tblti_categorias WHERE idcategoria = {$rxProducto["idcategoria"]})
																And (idmarca = $marca->idmarca AND activo = 1)
															)";
															} else {
																$sql = "SELECT * FROM tblti_categorias A 
														INNER JOIN tblti_productos B 
															ON A.idcategoria = B.idcategoria 
														WHERE activo=1 AND ( A.idcategoria_superior={$categoria["idcategoria"]}
															OR A.idcategoria={$categoria["idcategoria"]} )
														ORDER BY B.orden";
															}

															$productosResult = mysqli_query($nConexion, $sql);
															// var_dump($productosResult);

															$productoNum = 0;
															while ($producto = mysqli_fetch_assoc($productosResult)) {
																// var_dump($producto);
																$productoNum++;
																$imagenes = array();
																$ras = mysqli_query($nConexion, "select * from tblti_imagenes where idimagen<>0 order by idimagen desc");

																// Construir el array de imágenes
																while ($imagen = mysqli_fetch_assoc($ras)) {
																	$imagenes[$imagen["idproducto"]] = $imagen;
																}

																echo '<div class="content-product-acordion"> 
																	<div class="product--title-container">
																		<h3>' . $producto["nombre"] . '</h3>
																	</div>';
																echo '<a class="imagenBlog" href="' . $home . '/productos/' . $producto["url"] . '">';

																if (isset($imagenes[$producto["idproducto"]])) {
																	// Si hay una imagen correspondiente al producto
																	$imagen = $imagenes[$producto["idproducto"]];
																	echo "<img src='$home/fotos/tienda/productos/m_{$imagen["imagen"]}' alt='{$producto["nombre"]}' />";
																} else {
																	// Si no hay una imagen correspondiente al producto, mostrar la imagen predeterminada
																	echo "<img src='$home/fotos/Image/contenidos/default.jpg' />";
																}

																echo '</a>';
																echo '<a href="' . $home . '/productos/' . $producto["url"] . '" class="link">Ver más</a>';
																echo '</div>';
															}
															// echo $productoNum;
															?>
														</div>
													</div>
												</div>
											<?php } ?>
									<?php }
									}

									// Cierra la conexión a la base de datos
									mysqli_close($nConexion);
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

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
	</div>
	<script>
		$(document).ready(function() {
			// $(".accordion").css("display", "flex");
			// $(".productos--container:first").css("display", "flex");
			// Al hacer clic en cualquier elemento con clase "categoria--desplegable"
			$(document).on("click", ".categoria--desplegable", function() {
				// Seleccionar el elemento a modificar
				var $elemento = $(this).find(".productos--container");

				// Ocultar todos los elementos con la clase "productos--container"
				$(".productos--container").not($elemento).css("display", "none");

				// Comprobar si el elemento está visible
				if ($elemento.is(":visible")) {
					// Si está visible, ocultarlo
					$elemento.css("display", "none");
				} else {
					// Si no está visible, mostrarlo con display: flex
					$elemento.css("display", "flex");
				}
			});
		});

		jQuery('.boton_redes').on("click", function() {
			if (jQuery(this).hasClass("open")) {
				jQuery(this).removeClass("open").next().slideUp(300);
			} else {
				jQuery(this).addClass("open").next().slideDown(300);
			}
		});
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>