<?php
  if(!session_id()) session_start();
	if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
		header("Location: /");
		exit;
	}
	include("../include/funciones_public.php");
	ValCiudad();
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	include("../admin/vargenerales.php");
	require_once("inc/functions.php");
	require_once ("../admin/herramientas/seguridad/validate.php");
	require_once("funciones.php");	
	
	$IdCiudad=varValidator::validateReqInt("get","ciudad",true);
	if(is_null($IdCiudad)){
		echo "Valor de entrada invalido para la variable ciudad";
		exit;
	}

  	$nConexion   = Conectar();
	$mensaje="";

	if (isset ($_POST["idusuario"]) && !empty($_POST["idusuario"])){
		
		$sql="UPDATE tblusuarios_externos SET nombre='{$_POST["nombre"]}', correo_electronico='{$_POST["correo_electronico"]}', cedula='{$_POST["cedula"]}', sede='{$_POST["sede"]}', direccion='{$_POST["direccion"]}', telefono='{$_POST["telefono"]}' WHERE idusuario={$_POST["idusuario"]}";
		mysqli_query($nConexion,$sql);
		
		$sql="SELECT * FROM tblusuarios_externos WHERE idusuario={$_POST["idusuario"]}";
		$ra = mysqli_query($nConexion,$sql);
		$rax = mysqli_fetch_assoc($ra);
    	$_SESSION["usuario"] = $rax;
	}
	
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
?>
<!DOCTYPE html>
<html lang="es"> 
<head>
	<meta charset="utf-8">
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title>Datos personales - <?php echo $sitioCfg["titulo"]; ?></title>
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
							<li><a class="activo" href="/mi-cuenta/datos-personales">Datos personales</a></li>
							<li><a href="/mi-cuenta/cambiar-clave">Cambio de clave</a></li>
							<li><a href="/mi-cuenta">Recientes</a></li>
							<!--<li><a href="/mi-cuenta/datos-facturacion">Datos de facturación</a></li>-->
							<!--<li><a href="/mi-cuenta/direcciones">Direcciones</a></li>-->
              <?php if($_SESSION["usuario"]["perfil"] == 1) {
                echo "<li><a href='$home/cotizaciones'>Cotizaciones</a></li>";
              } ?>
							<li><a href="/mi-cuenta/mis-compras">Mis cotizaciones</a></li>
						</ul>
					</nav>
				</div>
				<div class="col-sm-9">
					<h3>Datos personales</h3>
					<div class="row review">
						<form method="post">
							<input type="hidden" class="form-fullwidth" name="idusuario" value="<?php echo $_SESSION['usuario']['idusuario'] ?>">
						<div class="col-md-12">
					   		<label>Nombre</label>
					   		<input type="text" class="form-fullwidth" name="nombre" required value="<?php echo $_SESSION['usuario']['nombre'] ?>">
						</div>
						<div class="col-md-12">
					   		<label>Correo electrónico</label>
					   		<input type="text" class="form-fullwidth" name="correo_electronico" required value="<?php echo $_SESSION['usuario']['correo_electronico'] ?>">
						</div>
						<div class="col-md-12">
					   		<label>Cédula</label>
					   		<input type="text" class="form-fullwidth" name="cedula" value="<?php echo $_SESSION['usuario']['cedula'] ?>">
						</div>
						<div class="col-md-12">
					   		<label>Dirección</label>
					   		<input type="text" class="form-fullwidth" name="direccion" value="<?php echo $_SESSION['usuario']['direccion'] ?>">
						</div>
						<div class="col-md-12">
					   		<label>Sede</label>
					   		<input type="text" class="form-fullwidth" name="sede" value="<?php echo $_SESSION['usuario']['sede'] ?>">
						</div>
						<div class="col-md-12">
					   		<label>Teléfono</label>
					   		<input type="text" class="form-fullwidth" name="telefono" value="<?php echo $_SESSION['usuario']['telefono'] ?>">
						</div>
						<div class="col-md-12 form-boton">
							<button type="submit" name="submit">Guardar</button>
						</div>
						</form>
					</div>
					<div class="row">
						<div class="col-md-12">
						<?php ImprimirBanner(3); ?>
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