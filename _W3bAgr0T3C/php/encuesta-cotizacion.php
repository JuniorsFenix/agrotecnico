<?php
    if(!session_id()) session_start();
	include("../include/funciones_public.php");
	ValCiudad();
	$sitioCfg = sitioAssoc();
	$respuesta = $_GET["url"];
	include("../admin/vargenerales.php");
	require_once ("../admin/herramientas/seguridad/validate.php");
	
	$IdCiudad=varValidator::validateReqInt("get","ciudad",true);
	if(is_null($IdCiudad)){
		echo "Valor de entrada invalido para la variable ciudad";
		exit;
	}
	
		$nConexion = Conectar();
		
		if (!empty($_GET["carro"]) && !empty($_GET["respuesta"])){

			$result = mysqli_query($nConexion,"SELECT encuesta FROM tblti_carro WHERE carro={$_GET["carro"]} AND encuesta=''");
			if (mysqli_num_rows($result))
			{
				$sql="UPDATE tblti_carro SET encuesta='{$_GET["respuesta"]}' WHERE carro={$_GET["carro"]}";	
				mysqli_query($nConexion,$sql);
				
				$mensaje = mysqli_fetch_object(VerContenido( "encuesta-mensaje" ));
			}
			else
			{
				$mensaje = mysqli_fetch_object(VerContenido( "encuesta-contestada" ));
			}
  

		} else {
			header("Location: /");
			exit;
		}
	
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
?>
<!DOCTYPE html>
<html lang="es"> 
<head>
	<meta charset="utf-8">
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title>Gracias por responder la encuesta | Agrotécnico J.O.</title>
    <meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
    <meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
	<?php echo $RegContenido->contenido; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<body>  
	<!--- Sección de menú --->
	<?php require_once("header.php");?>
	<!--- Sección de menú --->
	<div class="principal">
		<div class="contenidoGeneral">
		<div class="container">
			<?php echo $mensaje->contenido; ?>
		</div>
		<div class="fullwrap_moudle">
			<div class="container">
				<a href="<?php echo "$home/"; ?>" class="volver">Volver</a>
			</div>
		</div>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script src="<?php echo $home; ?>/php/slick/slick.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $home; ?>/php/slick/slick.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $home; ?>/php/slick/slick-theme.css">
		<!--- Sección de Creado por --->
		<?php require_once("footer.php");?>
		<!--- Sección de Creado por --->
			<style>
			    .logo{
			        display:none;
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
</body>
</html>