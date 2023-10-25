<?php
  define("RECAPTCHA_V3_SECRET_KEY", '6Le2UngjAAAAABeha_C68WdPWMb9QHVzEKLA0723');

  $token = $_POST['token'];
  $action = $_POST['action'];
   
  // call curl to POST request
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  curl_close($ch);
  $arrResponse = json_decode($response, true);
  $captcha = false;

  // verify the response
  if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
    $captcha=true;
    unset($_POST["token"]);
    unset($_POST["action"]);
  }

    if(!session_id()) session_start();
	include("../include/funciones_public.php");
	require_once("inc/functions.php");
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	include("../admin/vargenerales.php");
	require_once ("../admin/herramientas/paginar/dbquery.inc.php");

    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);

    if (isset( $_POST["idform"] )) {
		$ca->prepareSelect("configuracion_form", "*","idform = {$_POST["idform"]}");
		$ca->exec();
    if ($ca->size()>0) {
		$r = $ca->fetch();
	}
	}
		$correos = explode(',', $r["correo"]);
  
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
	$d = $_POST;

?>
<!DOCTYPE HTML>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title>Gracias por contactarnos - <?php echo $sitioCfg["titulo"]; ?></title>    
    <meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
    <meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
	<?php echo $RegContenido->contenido; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    
    <!--- <link href="https://fonts.googleapis.com/css?family=Rock+Salt" rel="stylesheet"> --->
	<link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:300,400&subset=latin-ext" rel="stylesheet">
    <link href="<?php echo $home; ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
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
		<div class="fullwrap_moudle">
		<br><br><br>
		<div class="container">
			<h2>Gracias por contactarnos</h2>
            <?php
            
    if($captcha) {            
				$nConexion = Conectar();
				mysqli_set_charset($nConexion,'utf8');
            if(isset($d['url']) && $d['url'] == ''){

				$sql="INSERT INTO contactenos (Nombre,Correo,Apellido,Telefono,Mensaje,fecha)
				VALUES ('{$d["Nombre"]}','{$d["Correo"]}','{$d["Apellido"]}','{$d["Telefono"]}','{$d["Mensaje"]}',NOW())";

				$ra = mysqli_query($nConexion,$sql);
				if(!$ra){
					echo "Fallo guardando en base de datos.";
				}


				$retorno="<br>";
				$mail = new PHPMailer(true);
				$mail->CharSet = "UTF-8";
				$mail->From      = "serviciocliente@agrotecnico.co";
				$mail->FromName  = "Agrotécnico";
				$mail->AddAddress( $d["Correo"] );
				$mail->Subject   = $r["asunto"];
				$mail->Body      = $r["mensaje2"];
				$mail->IsHTML(true);
				$resultado =$mail->Send();

				$mfinal = $retorno;
				$mfinal .= "Nombre: ".$d["Nombre"]." ".$d["Apellido"];
				$mfinal .= $retorno;
				$mfinal .= "Correo: ".$d["Correo"];
				$mfinal .= $retorno;
				$mfinal .= "Teléfono: ".$d["Telefono"];
				$mfinal .= $retorno;
				$mfinal .= "Mensaje: ".$d["Mensaje"];
				$mfinal .= $retorno;
				$mail2 = new PHPMailer(true);
				$mail2->CharSet = "UTF-8";
				$mail2->From      = "serviciocliente@agrotecnico.co";
				$mail2->FromName  = "Agrotécnico";
				foreach($correos as $correo) {
					$mail2->AddAddress( $correo );
				}
				$mail2->Subject   = "Contactos Agrotécnico";
				$mail2->Body      = $mfinal;
				$mail2->IsHTML(true);
				$mail2->Send();
				if ($resultado ==true) 
				{
				  ## Si no hay p&aacute;gina de gracias carga las p&aacute;gina de defecto
				echo $r["mensaje1"] ;
				}
				  ## Si se ha producido un error, advierte al usuario
				else echo "Error al enviar el mail" ;
				}
				else{
				echo $r["mensaje1"] ;
            }
}            
            ?>
			<a href="<?php echo $home; ?>/" class="volver">Volver</a>
		</div>
		<br><br><br>
		</div>
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
</body>
</html>