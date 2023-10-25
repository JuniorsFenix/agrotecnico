<?php
    if(!session_id()) session_start();
	if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
		echo "<div class='modal-body'>Debe iniciar sesión para agregar productos a la lista de deseos.<br><a href='/iniciar-sesion'>Inicia sesión</a></div>";
		exit;
	}
	include("../include/funciones_public.php");
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	require_once("../admin/vargenerales.php");
	
    $nConexion = Conectar();

	$url = $_GET["url"];
	$rxProducto = tiendaProductoAssoc($url);
	
	$imagenes=array();
  $ras = mysqli_query($nConexion, "SELECT * from tblti_imagenes where idimagen<>0 order by idimagen desc");
  while( $imagen = mysqli_fetch_assoc($ras) ){
    $imagenes[ $imagen["idproducto"] ] = $imagen;
	}
	
	$Resultado = mysqli_query($nConexion, "SELECT nota FROM tblti_wishlist WHERE idusuario={$_SESSION['usuario']['idusuario']} AND idproducto={$rxProducto["idproducto"]}");

?>
	<link href="<?php echo $home; ?>/php/seocounter/seocounter.css" rel="stylesheet" type="text/css">
	<script src="<?php echo $home; ?>/php/seocounter/seocounter.js"></script>
	<?php 
      if(mysqli_num_rows($Resultado)>0) { 
			$nota = mysqli_fetch_assoc($Resultado);
			?>
				<div class="modal-header">
					<h5 class="modal-title">Editar</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="container">
						<div class="row">
							<div class="col-md-2">
								<img src="<?php echo $cRutaVerImagenTienda."p_".$imagenes[$rxProducto["idproducto"]]["imagen"]; ?>" alt="<?php echo $rxProducto["nombre"];?>"/>
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
							<form action="/mi-cuenta/lista-de-deseos" method="post" id="modal-form">
								<input type="hidden" name="idproducto" value="<?php echo $rxProducto["idproducto"] ?>">
								<input type="hidden" name="editar" value="1">
								<div class="col-md-12">
									<label>Nota (Opcional)</label>
									<textarea maxlength="4000" class="form-fullwidth seocounter_otros" name="nota" id="otros" placeholder="Regalo para un ser querido"><?php echo $nota["nota"] ?></textarea>
								</div>
								<div class="col-md-12 form-boton">
									<button type="submit" name="submit" id="submitForm">Editar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
      <?php } else { ?>
			<div class="modal-header">
				<h5 class="modal-title">Añadir a lista de deseos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="col-md-2">
							<img src="<?php echo $cRutaVerImagenTienda."p_".$imagenes[$rxProducto["idproducto"]]["imagen"]; ?>" alt="<?php echo $rxProducto["nombre"];?>"/>
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
						<form action="/mi-cuenta" method="post" id="modal-form">
							<input type="hidden" name="idproducto" value="<?php echo $rxProducto["idproducto"] ?>">
							<input type="hidden" name="url" id="url" value="<?php echo $url ?>">
							<div class="col-md-12">
								<label>Lista de deseos</label>
								<select name="idlista" required>
								<?php
									$sql="SELECT * FROM tblti_lista_deseos WHERE idusuario = {$_SESSION['usuario']['idusuario']}";
									$stmt = mysqli_query($nConexion, $sql);
									while( $rax=mysqli_fetch_assoc($stmt)): ?>
									<option value="<?php echo $rax["id"];?>"><?php echo $rax["nombre"];?></option>
								<?php endwhile;?>
								</select> <a href="/mi-cuenta/crear-lista">Crear nueva lista</a>
							</div>
							<div class="col-md-12">
								<label>Nota (Opcional)</label>
								<textarea maxlength="4000" class="form-fullwidth seocounter_otros" name="nota" id="otros" placeholder="Regalo para un ser querido"></textarea>
							</div>
							<div class="col-md-12 form-boton">
								<button type="submit" name="submit" id="submitForm">Añadir</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php } ?>
	<script type="text/javascript"> 
		$(function() {
			seocounter();
		}); 
	</script>