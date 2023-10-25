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
  	
	$url = $_GET["url"];
	$rxProducto = tiendaProductoAssoc($url);
	if($rxProducto == 0 ){
	echo "<script language=\"javascript\">location.href='/productos'</script>";
	}
	$rxCategoria = tiendaCategoriaAssocId($rxProducto["idcategoria"]);

	$sql="SELECT nota FROM tblti_wishlist WHERE idusuario = {$_SESSION['usuario']['idusuario']} and idproducto={$rxProducto["idproducto"]}";
	$stmt = mysqli_query($nConexion,$sql);
	$nota = mysqli_fetch_assoc($stmt);
	
	$imagenes=array();
  $ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
  while( $imagen = mysqli_fetch_assoc($ras) ){
    $imagenes[ $imagen["idproducto"] ] = $imagen;
  }
  
		$fotos    = mysqli_query($nConexion,"SELECT * FROM tblti_imagenes WHERE idproducto={$rxProducto["idproducto"]} LIMIT 1");
		$num_rows = mysqli_num_rows($fotos);
	
	if(!empty($rxProducto["titulo"]))
	{
		$titulo = $rxProducto["titulo"];
	}
	else
	{
		$titulo = $sitioCfg["titulo"];
	}
	
	if(!empty($rxProducto["metaDescripcion"]))
	{
		$descripcion = $rxProducto["metaDescripcion"];
	}
	else
	{
		$descripcion = $generales['descripcion_productos'];
	}
	
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
?>
<!DOCTYPE html>
<html lang="es"> 
<head>
	<meta charset="utf-8">
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title>Editar lista de deseos - <?php echo $titulo; ?></title>
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
					<h3 class="tituloDirecciones">Editar a lista de deseos</h3>
                    <div class="row">
        				<div class="col-md-12">
        					<div class="row">
        						<div class="col-md-2">
        						<?php if ($num_rows > 0){ ?>
        						  <?php while($Registro = mysqli_fetch_object($fotos) ):?>
        							<img src="<?php echo $cRutaVerImagenTienda."p_".$Registro->imagen; ?>" alt="<?php echo $rxProducto["nombre"];?>"/>
        						  <?php endwhile;?>
        						<?php } ?>
        			   			</div>
        						<div class="col-md-10">
        							<h3><?php echo $rxProducto["nombre"];?></h3>
        							<?php
        							if($rxProducto["referencia_activo"]==1){?>
        							<b>Referencia:</b> <?=$rxProducto["referencia"];?><br />
        							<?php } ?>
        		   					<?php
        							if($rxProducto["precio_activo"]==1){?>
        							<b>Precio:</b> $<?php echo number_format(round($rxProducto["precio"]),0,'','.') ?>
        							<?php } ?>
        			   			</div>
        			   		</div>
        					<div class="row review">
        						<form action="/mi-cuenta/lista-de-deseos" method="post">
        							<input type="hidden" name="idproducto" value="<?php echo $rxProducto["idproducto"] ?>">
        							<input type="hidden" name="editar" value="1">
        						<div class="col-md-12">
        					   		<label>Nota (Opcional)</label>
        					   		<textarea maxlength="4000" class="form-fullwidth seocounter_otros" name="nota" id="otros" placeholder="Regalo para un ser querido"><?php echo $nota["nota"] ?></textarea>
        						</div>
        						<div class="col-md-12 form-boton">
        							<button type="submit" name="submit">Guardar</button>
        						</div>
        		   				</form>
        			   		</div>
        				</div>
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