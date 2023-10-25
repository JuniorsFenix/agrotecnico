<?php
  //exit;
  include("diasiniva.php");

    if(!session_id()) session_start();
	include("../include/funciones_public.php");
	require_once("inc/functions.php");
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	include("../admin/vargenerales.php");
	
	$generales = datosGenerales();
    $nConexion = Conectar();
	
	$url = $_GET["categoria"];
	$rxProducto = tiendaCategoriaAssoc($url);
	if($rxProducto == 0 ){
    echo "<script language=\"javascript\">location.href='$home/productos'</script>";
	}
	if(!empty($_GET["marca"])){
		$sql= mysqli_query($nConexion,"SELECT idmarca FROM tblti_marcas WHERE url='{$_GET["marca"]}'");
		$marca = mysqli_fetch_object($sql);
	}

	$imagenes=array();
  $ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
  while( $imagen = mysqli_fetch_assoc($ras) ){
    $imagenes[ $imagen["idproducto"] ] = $imagen;
  }
	
	if(!empty($generales["titulo_productos"])){
		$titulo = $generales["titulo_productos"];
	}else{
		$titulo = $sitioCfg["titulo"];
	}
	
	if(!empty($generales["palabras_productos"])){
		$palabras = $generales['descripcion_productos'];
	}else{
		$palabras = $sitioCfg["palabras_clave"];
	}
	
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
	$descripcion = $generales['descripcion_productos'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <title><?php echo $rxProducto["nombre"]; ?> - <?php echo $titulo; ?></title>
    <meta name="description" content="<?php echo $rxProducto["metaDescripcion"]; ?>">
    <meta name="keywords" content="<?php echo $palabras; ?>">
	<?php echo $RegContenido->contenido; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <!--- <link href="https://fonts.googleapis.com/css?family=Rock+Salt" rel="stylesheet"> --->
    <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:300,400&subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<style>
		.descripcionS {
			max-height: 100px;
			position: relative;
			overflow: hidden;
			transition: max-height 0.3s ease-in-out;
	    }
		.ampliar {
			display: block;
			float: right;
			color: #FFF;
			padding: 8px 5px;
			overflow: hidden;
			margin: 11px 0 22px 0;
            border-radius: 2rem;
            background: linear-gradient(to right, #AAC148, #509F4E);
		}
		.descripcionS.abierto {
			max-height: 2000px;
		}
		.cat-title{
			font-weight: bold !important;
			color: #38892F;
			font-size: 1.75em !important;
		}
	</style>
    
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
<!-- productosListar -->
<!--- Sección de menú --->
<?php require_once("header.php");?>
	<!--- Sección de menú --->
	<div class="principal">
		<div id="skrollr-body">
		<!--- Sección de Noticias/tendencias --->     
		<section class="contenidoInterno">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h2><?php echo $rxProducto["nombre"]; ?></h2>
						<div class="descripcionS">
							<?php echo $rxProducto["descripcion"]; ?>
						</div>
						<a class="ampliar" href="#">Ampliar información</a>
					</div>
					<div class="col-md-9 order-md-1" >
						<div class="row productos-categorias">
						<?php
							$nConexion = Conectar();
							mysqli_set_charset($nConexion,'utf8');
							if(!empty($_GET["marca"])){
                $sql = "SELECT * FROM tblti_productos WHERE idcategoria={$rxProducto["idcategoria"]} AND idmarca=$marca->idmarca AND activo=1 ORDER BY orden";
							} else {
                $sql = "SELECT * FROM tblti_productos WHERE idcategoria={$rxProducto["idcategoria"]} ORDER BY orden";
                $sql = "SELECT * FROM tblti_categorias A 
                    INNER JOIN tblti_productos B 
                            ON A.idcategoria = B.idcategoria 
                         WHERE activo=1 AND ( A.idcategoria_superior={$rxProducto["idcategoria"]}
                            OR A.idcategoria={$rxProducto["idcategoria"]} )
                       ORDER BY B.orden
                ";
							}              
              $result= mysqli_query($nConexion,$sql);
							@$num_rows = mysqli_num_rows($result);
							while(@$rax=mysqli_fetch_assoc($result)): ?>
								<div class="listado col-sm-6 col-md-5 col-xl-4">
									<div class="content-product">
										<a class="imagenBlog" href='<?php echo "$home/productos/{$rax["url"]}" ?>'>
											<?php if(empty($imagenes[$rax["idproducto"]]["imagen"])){
												echo "<img src='$home/fotos/Image/contenidos/default.jpg' />";
											} else {
												echo "<img src='$home/fotos/tienda/productos/m_{$imagenes[$rax["idproducto"]]["imagen"]}' alt='{$rax["nombre"]}' />";
											} ?>
										</a>
										<h3><?php echo $rax["nombre"] ?></h3>
                    <?php 
                      if($rax["inventario"]>0) {
                        $disponible = "<p class='disponible'  ></p>";
                      }else{
                        $disponible = "<p class='nodisponible'></p>";
                      }

                      if(DIASINIVA AND $rax["diasiniva"]==true) {
                        $diasiniva = "<p class='diasiniva'  >(Sólo días sin IVA)</p>";
                      }else{
                        $diasiniva = "";
                      }
                      echo $disponible;
                      echo $diasiniva;
                    ?>
										<a href='<?php echo "$home/productos/{$rax["url"]}" ?>' class='link'>Ver más</a>
									</div>
								</div>
							<?php endwhile; ?>
							<?php echo mysqli_error($nConexion); ?>
						</div>
						<?php
                         $query = "SELECT * FROM tblti_categorias WHERE idcategoria_superior={$rxProducto["idcategoria"]}";
						$sql= mysqli_query($nConexion,$query);
						while(@$row=mysqli_fetch_assoc($sql)): 
              
                // Determina si la subcategoria tiene productos
                //echo $row["idcategoria"]." ";
                $query = "SELECT count(*) as cantidad FROM tblti_productos WHERE idcategoria={$row["idcategoria"]} and idmarca=$marca->idmarca ";
                $result = mysqli_query($nConexion,$query);
                @$row2 = mysqli_fetch_assoc($result);
                if ($row2["cantidad"]>0) {; ?>

                  <h3 class="cat-title"><?php echo $row["nombre"] ?></h3>
                  <p ><?php echo $row["descripcion"] ?></p>
                  <div class="row productos-categorias">
                    <?php
                    if(!empty($_GET["marca"])){
                      $sql2 = "SELECT * FROM tblti_productos WHERE idcategoria={$row["idcategoria"]} AND idmarca=$marca->idmarca AND activo=1 ORDER BY orden";
                    } else {
                      $sql2 = "SELECT * FROM tblti_productos WHERE idcategoria={$row["idcategoria"]} AND activo=1 ORDER BY orden";
                    }
                    $result= mysqli_query($nConexion,$sql2);

                    //echo($sql);
  
                    $num_rows = mysqli_num_rows($result);
                    while($rax=mysqli_fetch_assoc($result)): ?>
                      <div class="listado col-sm-6 col-md-5 col-xl-4">
                        <div class="content-product">
                          <a class="imagenBlog" href='<?php echo "$home/productos/{$rax["url"]}" ?>'>
                            <?php if(empty($imagenes[$rax["idproducto"]]["imagen"])){
                              echo "<img src='$home/fotos/Image/contenidos/default.jpg' />";
                            } else {
                              echo "<img src='$home/fotos/tienda/productos/m_{$imagenes[$rax["idproducto"]]["imagen"]}' alt='{$rax["nombre"]}' />";
                            } ?>
                          </a>
                          <h3><?php echo $rax["nombre"] ?></h3>                         
                          <?php 
                            if($rax["inventario"]>0) {
                              $disponible = "<p class='disponible'  ></p>";
                            }else{
                              $disponible = "<p class='nodisponible'></p>";
                            }
                            
                            if(DIASINIVA AND $rax["diasiniva"]==true) {
                              $diasiniva = "<p class='diasiniva'  >(Sólo días sin IVA)</p>";
                            }else{
                              $diasiniva = "";
                            }
                            echo $disponible;
                            echo $diasiniva;
                          ?>
                          <a href='<?php echo "$home/productos/{$rax["url"]}" ?>' class='link'>Ver más</a>
                        </div>
                      </div>
                    <?php endwhile; ?>
                  </div>
          <?php } 
              endwhile; ?>
					</div>
					<div class="col-md-3">
					<div class="marcas-sticky">
						<h3>Marcas aliadas</h3>
						<ul class="marcas">
						<?php
							$result= mysqli_query($nConexion,"SELECT * FROM tblti_marcas WHERE idmarca IN (SELECT idmarca FROM tblti_productos ) ORDER BY orden");
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
				<a href="<?php echo $home; ?>/productos" class="volver">Volver</a>
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
	<script type="text/javascript">
		$(window).ready(function() {
			$('.ampliar').on('click', function(e) {
				e.preventDefault();
				$('.descripcionS').toggleClass("abierto");
				$(this).toggleClass("activo");
					var text=$(this).text();
					if(text === "Ampliar información"){
					$(this).html('Reducir información');
					} else{
					$(this).text('Ampliar información');
					}
			});
		});
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>