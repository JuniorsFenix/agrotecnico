<?php
    if(!session_id()) session_start();
	if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
		header("Location: /productos");
		exit;
	}
  
	include("../include/funciones_public.php");
  	updateSession();
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	include("../admin/vargenerales.php");
	require_once("inc/functions.php");

  	$nConexion   = Conectar();

	if(isset($_POST["nombre"]) && $_POST["nombre"]!=""){
		setlocale(LC_ALL, 'en_US.UTF8');
		$url = slug2($_POST["nombre"]);
		$sql="INSERT into tblti_lista_deseos (idusuario, nombre, url, fecha) values ({$_SESSION['usuario']['idusuario']}, '{$_POST["nombre"]}', '$url', NOW())";
		mysqli_query($nConexion,$sql);
		header("Location: /mi-cuenta");
	}

	if(isset($_POST["idlista"]) && $_POST["idlista"]!=""){
		$sql="INSERT into tblti_wishlist (idusuario, idlista, idproducto, nota, fecha) values ({$_SESSION['usuario']['idusuario']}, {$_POST["idlista"]}, {$_POST["idproducto"]}, '{$_POST["nota"]}', NOW())";
		mysqli_query($nConexion,$sql);
		header("Location: /mi-cuenta");
	}
  
  $imagenes=array();
  $ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0");
  while( $imagen = mysqli_fetch_assoc($ras) ){
    $imagenes[ $imagen["idproducto"] ] = $imagen;
  }
	
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
?>
<!DOCTYPE html>
<html lang="es"> 
<head>
	<meta charset="utf-8">
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title>Mi cuenta - <?php echo $sitioCfg["titulo"]; ?></title>
    <meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
    <meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
	<?php echo $RegContenido->contenido; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="<?php echo $home; ?>/php/bar-rating/jquery.barrating.min.js" type="text/javascript"></script>
    
</head>
<body>
	<!--- Sección de menú --->
	<?php require_once("header.php");?>
	<!--- Sección de menú ---> 
	<div class="principal">
		<div id="cabezote">
		<?php echo cabezoteJqueryIn(4,"carousel"); ?>
		</div>
		<div class="contenidoGeneral cuenta">
			<div class="container">
				<div class="row">
				<div class="col-sm-3">
					<nav>
					<h2>Configuración</h2>
						<ul>
							<li><a href="/mi-cuenta/datos-personales">Datos personales</a></li>
							<li><a href="/mi-cuenta/cambiar-clave">Cambio de clave</a></li>
							<li><a class="activo" href="/mi-cuenta">Recientes</a></li>
							<!--<li><a href="/mi-cuenta/datos-facturacion">Datos de facturación</a></li>-->
							<!--<li><a href="/mi-cuenta/direcciones">Direcciones</a></li>-->
                            <?php if(COTIZAR){
                                if($_SESSION["usuario"]["perfil"] == 1) {
                                    echo "<li><a href='$home/cotizaciones'>Cotizaciones</a></li>";
                                }
                                echo "<li><a href='$home/mi-cuenta/mis-compras'>Mis cotizaciones</a></li>";
                            } ?>
						</ul>
					</nav>
					<nav>
					<h2>Listas de deseos</h2>
						<ul>
					<?php
						$sql="SELECT * FROM tblti_lista_deseos WHERE idusuario = {$_SESSION['usuario']['idusuario']}";
						$stmt = mysqli_query($nConexion,$sql);
			  			while( $rax=mysqli_fetch_assoc($stmt)): ?>
							<li><a href="/mi-cuenta/lista-de-deseos/<?php echo $rax["url"];?>"><?php echo $rax["nombre"];?></a></li>
			  		<?php endwhile;?>
						</ul>
						<p style="text-align: center"><a class="crearLista" href="/mi-cuenta/crear-lista">Crear nueva lista</a></p>
					</nav>
				</div>
				<div class="col-sm-9">
				<?php if(COTIZAR){ ?>
					<h3>Cotizaciones recientes</h3>
					<div class="row">
					<?php
            $usuario = $_SESSION['usuario']['idusuario'];
            //$usuario = 17;
			$sql="SELECT  c.fecha, c.carro, c.descripcion, cd.detalle, cd.precio, 
                          cd.talla, cd.color, c.estado, p.idproducto, 
                          p.nombre, p.url, f.factura,
                          count(p.idproducto) as cantidad                          
                    FROM  tblti_carro c 
               LEFT JOIN  tblti_carro_detalle cd 
                      ON  c.carro=cd.carro 
               LEFT JOIN  tblti_productos p 
                      ON  cd.idproducto=p.idproducto 
               LEFT JOIN  tblti_cotizaciones f on c.carro=f.carro 
                   WHERE  c.idusuario = {$usuario} 
                     AND  c.estado ='COTIZADO'
                GROUP BY  carro 
                ORDER BY  c.carro DESC
				   LIMIT  10";

					$nConexion   = Conectar();

						$stmt = mysqli_query($nConexion,$sql);
						if($stmt){
			  			while( $rax=mysqli_fetch_assoc($stmt)): ?>
              <?
                $fecha = new DateTime($rax["fecha"]);
                $fecha = $fecha->format('d/m/Y h:m:s A');
              ?>
						<div class="productoC">
							<div class="row">
							<!--
							<a class="urlProducto col-md-3" href="<?php echo "$home/productos/{$rax["url"]}" ?>">
								<img src="<?php echo "{$cRutaVerImagenTienda}p_{$imagenes[$rax["idproducto"]]["imagen"]}"; ?>" alt="<?=$rax["nombre"];?>" />
							</a>
						  -->
							<div class="col-md-12">
								<h2><?php echo $rax["factura"] ?></h2>
                <h2><?php echo "Fecha: ".$fecha ?></h2>
                <h2><?php echo "Descripción: ".$rax["descripcion"] ?></h2>
								<!--
								<h4 class='titulo-producto'><a style="width:50%" href='<?php echo "$home/productos/{$rax["url"]}" ?>'><?php echo $rax["cantidad"] ." x ". $rax["nombre"] ?></a></h4>
								<p><strong>Talla:</strong> <?=$rax["talla"];?></p>
								<p><strong>Color:</strong> <?=$rax["color"];?></p>
								-->
								<!-- <p><strong>Precio:</strong> $ <?php echo number_format( ($rax["precio"]), 2, '.', '.' ) ?></p> -->
								<p><strong>Estado:</strong> <?=$rax["estado"];?></p>
								<!-- <p>IVA y envío incluidos</p> -->
									<?php if($rax["factura"]!=""){ ?>
                    <a style="color:black;" target='_blank' href='/fotos/tienda/cotizaciones/<?php echo $rax["factura"] ?>'>Ver Cotización</a>
									<?php } ?>
                
							</div>
						</div>
						</div>
			  		<?php endwhile; }?>
					</div>
					<div class="row">
						<div class="col-md-12">
						<?php //ImprimirBanner(3); ?>
						</div>
					</div>
                    <?php } ?>
				</div>
			</div>
			</div>
		</div>
		<!--- Sección de Creado por --->
		<?php require_once("footer.php");?>
		<!--- Sección de Creado por --->
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>