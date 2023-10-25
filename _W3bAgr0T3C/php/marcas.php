<?php
    if(!session_id()) session_start();
	include("../include/funciones_public.php");
	require_once("inc/functions.php");
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	include("../admin/vargenerales.php");
	
	$generales = datosGenerales();
		$nConexion = Conectar();
		
		if(empty($_GET["marca"])){
			echo "<script language=\"javascript\">location.href='$home/productos'</script>";
		}

		$sql= mysqli_query($nConexion,"SELECT * FROM tblti_marcas WHERE url='{$_GET["marca"]}'");
		$marca = mysqli_fetch_object($sql);
	
	if(!empty($generales["titulo_productos"]))
	{
		$titulo = $generales["titulo_productos"];
	}
	else
	{
		$titulo = $sitioCfg["titulo"];
	}
	
	if(!empty($generales["palabras_productos"]))
	{
		$palabras = $generales['descripcion_productos'];
	}
	else
	{
		$palabras = $sitioCfg["palabras_clave"];
	}

	$imagenes=array();
  $ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
  while( $imagen = mysqli_fetch_assoc($ras) ){
    $imagenes[ $imagen["idproducto"] ] = $imagen;
  }
	
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
	$descripcion = $generales['descripcion_productos'];

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


  <!-- Global site tag (gtag.js) - Google Ads: 665003357 --> 
  <!--<script async src="https://www.googletagmanager.com/gtag/js?id=AW-665003357"></script> 
  <script> 
  window.dataLayer = window.dataLayer || []; 
  function gtag(){dataLayer.push(arguments);} 
    gtag('js', new Date());
    gtag('config', 'AW-665003357'
  );
  </script>-->

  <!-- Event snippet for Categorías de productos conversion page -->
  <!--<script>
    gtag('event', 'conversion', {'send_to': 'AW-665003357/DALICJ2U48gBEN3KjL0C'});
  </script>-->
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?php echo $sitioCfg["analytics"]; ?>');</script>
    <!-- End Google Tag Manager -->

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $sitioCfg["analytics"]; ?>"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
<!--- Sección de menú --->
<?php require_once("header.php");?>
	<!--- Sección de menú --->
	<div class="principal">
		<div id="skrollr-body">
		<!--- Sección de Noticias/tendencias ---> 
		<section class="contenidoInterno">
			<div class="container">
				<div class="row">
        
					<div class="col-md-9 order-md-1" >
						<h2><?php echo "<img src='$home/fotos/tienda/marcas/$marca->imagen' alt='$marca->nombre' />" ?></h2>
						<div class="row productos-categorias">
						<?php
							$nConexion = Conectar();
							mysqli_set_charset($nConexion,'utf8');
              $query = "SELECT * FROM tblti_categorias WHERE idcategoria!=0 AND idcategoria_superior=0 AND (idcategoria IN (SELECT idcategoria FROM tblti_productos WHERE idmarca=$marca->idmarca) OR idcategoria IN (SELECT c.idcategoria_superior FROM tblti_categorias c INNER JOIN tblti_productos p ON c.idcategoria=p.idcategoria WHERE idmarca=$marca->idmarca))";
                            
							$result= mysqli_query($nConexion,$query);
								while($rax=mysqli_fetch_assoc($result)):
									$sql= mysqli_query($nConexion,"SELECT idproducto FROM tblti_productos WHERE idmarca=$marca->idmarca AND (idcategoria={$rax["idcategoria"]} OR idcategoria IN (SELECT idcategoria FROM tblti_categorias WHERE idcategoria_superior={$rax["idcategoria"]}))");
									$row = mysqli_fetch_object($sql); ?>
								<div class="listado col-sm-6 col-md-5 col-xl-4">
									<div class="content-product">
									<h3><?php echo $rax["nombre"] ?></h3>
										<a class="imagenBlog" href='<?php echo "$home/productos/categoria/{$rax["url"]}/$marca->url" ?>'>
                            <?php if(empty($imagenes[$row->idproducto]["imagen"])){
												echo "<img src='$home/fotos/Image/contenidos/default.jpg' />";
											} else {
												echo "<img src='$home/fotos/tienda/productos/m_{$imagenes[$row->idproducto]["imagen"]}' alt='{$rax["nombre"]}' />";
											} ?>
										</a>
									<a href='<?php echo "$home/productos/categoria/{$rax["url"]}/$marca->url" ?>' class='link'>Ver más</a>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					</div>

					<div class="col-md-3">
					<div class="marcas-sticky">
						<h3>Marcas aliadas</h3>
						<ul class="marcas">
						<?php
							$nConexion = Conectar();
							$result= mysqli_query($nConexion,"SELECT * FROM tblti_marcas WHERE idmarca IN (SELECT idmarca FROM tblti_productos WHERE activo=1) ORDER BY orden");
							while($rax=mysqli_fetch_assoc($result)): ?>
							<li>
							<a style="display:block;" href='<?php echo "$home/productos/marca/{$rax["url"]}" ?>'>
								<?php echo "<img src='$home/fotos/tienda/marcas/{$rax["imagen"]}' alt='{$rax["nombre"]}' />" ?>
								<div class="arrow bounce2">
									<span class="fa fa-arrow-right fa-2x"></span>
								</div>
								</a>
							</li>
						<?php endwhile; ?>
						</ul>
					</div>
					</div>
          
          
				</div>
			</div>
		</section>    
		<!--- Sección de Creado por --->
		<?php require_once("footer.php");?>
		<!--- Sección de Creado por --->
			<style>
			    .logo{
			        display:none !important;
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
			<div class="arrow bounce">
				<span class="fa fa-arrow-down fa-2x"></span>
			</div>
		</div>
	</div>
	<script>
				
		jQuery('.boton_redes').on("click", function() {
			if (jQuery(this).hasClass("open"))
			{
				jQuery(this).removeClass("open").next().slideUp(300);
			}
			else
			{
				jQuery(this).addClass("open").next().slideDown(300);
			}
		});
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>