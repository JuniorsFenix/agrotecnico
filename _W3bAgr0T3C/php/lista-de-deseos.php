<?php
    if(!session_id()) session_start();
	if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
		header("Location: /");
		exit;
	}
  
	include("../include/funciones_public.php");
  	updateSession();
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	include("../admin/vargenerales.php");
	require_once("inc/functions.php");

  	$nConexion   = Conectar();

	if(isset($_GET["eliminar"]) && $_GET["idproducto"]!=""){
		$sql="DELETE from tblti_wishlist WHERE idusuario='{$_SESSION['usuario']['idusuario']}' and idproducto={$_GET["idproducto"]}";
		mysqli_query($nConexion,$sql);
		header("Location: /mi-cuenta");
		exit;
	}

	if(isset($_POST["editar"]) && $_POST["idproducto"]!=""){
		$sql="UPDATE tblti_wishlist set nota='{$_POST["nota"]}' WHERE idusuario={$_SESSION["usuario"]["idusuario"]} and idproducto={$_POST["idproducto"]}";
		mysqli_query($nConexion,$sql);
		header("Location: /mi-cuenta");
		exit;
	}
	$url = $_GET["url"];
    $sql="select * from tblti_lista_deseos WHERE idusuario={$_SESSION["usuario"]["idusuario"]} AND url = '$url'";
    $ra = mysqli_query($nConexion,$sql);
    if( mysqli_num_rows($ra)== 0 ){
		header("Location: /mi-cuenta");
		exit;
    }
    $lista = mysqli_fetch_assoc($ra);
    
    $imagenes=array();
    $ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
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
    <title>Lista de deseos - <?php echo $sitioCfg["titulo"]; ?></title>
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
					<h3>Lista de deseos - <?php echo $lista["nombre"] ?></h3>
					<div class="row">
					<?php
						$sql="SELECT p.idproducto, p.url, p.nombre, p.precio, w.nota, w.fecha FROM tblti_productos p LEFT JOIN tblti_wishlist w ON p.idproducto=w.idproducto WHERE w.idusuario = {$_SESSION['usuario']['idusuario']} AND w.idlista={$lista["id"]}";
						$stmt = mysqli_query($nConexion,$sql);
						if($stmt){
			  			while($rax=mysqli_fetch_assoc($stmt)): 
							$mensajeSale="";
							$oldPrice="";
							$sql = "SELECT c.id FROM tblti_combos c JOIN tblti_combos_asoc ca ON c.id=ca.idcombo WHERE ca.idproducto={$rax["idproducto"]} AND c.activo=1";
							$ra = mysqli_query($nConexion,$sql);
							$combo = mysqli_fetch_assoc($ra);
							if($combo){
								$sql2 = "SELECT descuento, tipo FROM tblti_combos_rangos WHERE idcombo={$combo["id"]} AND rango1=1 AND rango2=1";
								$ra2 = mysqli_query($nConexion,$sql2);
								$descuento = mysqli_fetch_assoc($ra2);
								if($descuento){
									$oldPrice="<span class='old-price'>$ ".number_format($rax["precio"])."</span>";
									if($descuento["tipo"] == 1){
										$rax["precio"] = ($rax["precio"] * ((100-$descuento["descuento"]) / 100));
										$mensajeSale="<span class='descuento'>-{$descuento["descuento"]}%</span>";
									}else{
										$rax["precio"] = $rax["precio"] - $descuento["descuento"]; // if not a percentage, subtract from price outright
									}
								}
							}?>
						<div class="productoC">
							<div class="row">
							<a class="urlProducto col-md-2" href="<?php echo "$home/productos/{$rax["url"]}" ?>">
								<img src="<?php echo "{$cRutaVerImagenTienda}p_{$imagenes[$rax["idproducto"]]["imagen"]}"; ?>" alt="<?=$rax["nombre"];?>" />
							</a>
							<div class="col-md-10">
								<p><?php echo $rax["fecha"] ?></p>
								<h4 class='titulo-producto'><a href='<?php echo "$home/productos/{$rax["url"]}" ?>'><?php echo $rax["nombre"] ?></a></h4>
								<p><strong>Nota:</strong> <?php echo $rax["nota"] ?><p>
								<div class="precio">
									<?php echo "$mensajeSale"; ?>
									<span class="val">
										<?php echo "$oldPrice"; ?>
										<span class="newPrice">$ <?php echo number_format( round($rax["precio"]), 0, '', '.' ) ?></span>
									</span>				  
								</div>
								<div class="opciones">
									<ul>
										<li><a href="/mi-cuenta/lista-de-deseos/editar/<?php echo $rax["url"] ?>" >Editar</a></li>
										<li><a id="eliminar" href="/mi-cuenta/lista-de-deseos/eliminar/<?php echo $rax["idproducto"] ?>" >Eliminar</a></li>
									</ul>
								</div>
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