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

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../admin/herramientas/phpmailer/src/Exception.php';
	require '../admin/herramientas/phpmailer/src/PHPMailer.php';
	
	$nConexion = Conectar();
	
	if (empty($_GET["carro"])) {
		header("Location: /");
		exit;
	}
	    
	if ($_GET["pagar"] == "si") {
		$sessionID = session_id();
		$sql="UPDATE tblti_carro SET session_id='$sessionID' WHERE carro={$_GET["carro"]}";	
		mysqli_query($nConexion,$sql);
	
		header("Location: /confirmar-pedido");
		exit;
	}
	
	if (!empty($_POST)) {
	    $sessionID = $_COOKIE['PHPSESSID'];
	
    	$sql="UPDATE tblti_carro SET estado='{$_POST["estado"]}', comentarios='{$_POST["comentarios"]}' WHERE carro={$_GET["carro"]}";	
    	mysqli_query($nConexion,$sql);

      	$result = mysqli_query($nConexion,"SELECT nombre, correo_electronico FROM tblusuarios_externos WHERE idusuario IN (SELECT usuario FROM tblti_carro WHERE carro={$_GET["carro"]})");
        $asesor = mysqli_fetch_assoc($result);
    	
        $mail = new PHPMailer(true);
        $mail->CharSet   = "UTF-8";
        $mail->From      = VerSitioConfig('correo');
        $mail->FromName  = VerSitioConfig('correo_nombre');
        $mail->AddAddress($asesor["correo_electronico"]);
    
        $body = "<table align='center' border='0' cellpadding='1' cellspacing='1' style='width:100%'>
                  <tbody>
                    <tr>
                      <td style='text-align:center;'>
                        <img alt='Agrotecnico' src='https://agrotecnico.com.co/fotos/Image/mail-logo.png' width='400px' />
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div style='font-family:Century Gothic,Didact Gothic,sans-serif; text-align:center'>
                            Hola {$asesor["nombre"]}, han respondido una cotización en Agrotécnico j.o.<br><br>
                            <strong>Cotización # {$_GET["carro"]}</strong><br>
                            <strong>Estado:</strong> {$_POST["estado"]}<br>
                            <strong>Comentarios:</strong> {$_POST["comentarios"]}
		                </div>
                      </td>
                    </tr>
                  </tbody>
                </table>";
        
        $mail->Subject   = "Han respondido una cotización en Agrotécnico j.o.";
        $mail->Body      = $body;
        $mail->IsHTML(true);
        $mail->Send();
	    
	    if ($_POST["estado"] == "APROBADA") {
	
        	$sql="UPDATE tblti_carro SET session_id='$sessionID' WHERE carro={$_GET["carro"]}";	
        	mysqli_query($nConexion,$sql);
    	
    		header("Location: /confirmar-pedido");
    		exit;
	    }
	}
	$mensaje = mysqli_fetch_object(VerContenido( "respuesta-cotizacion" ));
	
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
?>
<!DOCTYPE html>
<html lang="es"> 
<head>
	<meta charset="utf-8">
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title>Gracias por responder la cotización | Agrotécnico J.O.</title>
    <meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
    <meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
	<?php echo $RegContenido->contenido; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
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
		<div class="contenidoGeneral">
		<div class="container">
			<?php 
			    if (empty($_POST)) { ?>
			    <h2>Responder cotización</h2>
                <form method="post">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="estado1" name="estado" value="APROBADA" class="custom-control-input" checked>
                        <label class="custom-control-label" for="estado1">Aprobada</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="estado2" name="estado" value="RECHAZADA" class="custom-control-input">
                        <label class="custom-control-label" for="estado2">Rechazada</label>
                    </div>
                    <div class="form-group">
                        <label for="comentarios">Comentarios:</label>
                        <textarea class="form-control" id="comentarios" name="comentarios" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
			 <?php } else {
			    echo $mensaje->contenido; 
			 } ?>
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