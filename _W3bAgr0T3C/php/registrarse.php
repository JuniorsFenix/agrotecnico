<?php
    if(!session_id()) session_start();
  include("../include/funciones_public.php");
  ValCiudad();
  $sitioCfg = sitioAssoc();
  $home = $sitioCfg["url"];
  include("../admin/vargenerales.php");
  require_once("inc/functions.php");
  require_once("../admin/herramientas/seguridad/validate.php");
  
  $IdCiudad=varValidator::validateReqInt("get","ciudad",true);
  if(is_null($IdCiudad)){
    echo "Valor de entrada invalido para la variable ciudad";
    exit;
  }

  $mensaje = "";
  if(isset($_POST["correo"])){
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
      
    if($captcha) {
        $login = usuariosRegistrar($_POST);
        if($login===true){
          header("Location: /productos");
          exit;
        }else{
          $mensaje = "<h4>No se pudo registrar el usuario</h4>
          <p>{$login}</p>";
        }
    } else {
        $mensaje = "Error con captcha. Por favor intente de nuevo.";
    }
  }
  
  $RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
?>
<!DOCTYPE html>
<html lang="es"> 
<head>
  <meta charset="utf-8">
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title>Registro - <?php echo $sitioCfg["titulo"]; ?></title>
    <meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
    <meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
  <?php echo $RegContenido->contenido; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    function confirmar() {
    var password = $("#password").val();
    var confirmPassword = $("#confirm_password").val();
  
    if (password != confirmPassword)
        $("#message").html("Las contraseñas no coinciden");
    else
        $("#message").html("");
  }
  
  $(document).ready(function () {
       $("#confirm_password").keyup(confirmar);
  });
  </script>
    <style type="text/css">
    #message{
      color:#C00003;
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
  <!--- Sección de menú --->
  <?php require_once("header.php");?>
  <!--- Sección de menú --->
  <div class="principal">
    <div id="cabezote">
    <?php echo cabezoteJqueryIn(4,"carousel"); ?>
    </div>
    <div class="contenidoGeneral">
    <div class="container">
      <div class="login">
      <?php if($mensaje != ""){
        echo "<div class='error'>$mensaje</div>";
      } ?>
        <form class="formulario3 formulario-captcha" method="post">
            <input type="hidden" name="action" value="home">
            <input type="hidden" name="token" class="token" value="">
          <h2>Registro</h2>
          <input type="text" maxlength="200" name="nombre" required placeholder="Nombre*">
          <input type="email" maxlength="100" name="correo" required placeholder="Correo*">
          <input type="password" name="clave" id="password" required placeholder="Contraseña*">
          <input type="password" name="clave2" id="confirm_password" required placeholder="Confirmar contraseña*">  <span id='message'></span>
          <br>
          <input style="margin:20px 0;" class="action-button" id="cmdEnviar" name="Submit" type="submit" value="Registrar" size="100">
        </form>
        <!-- <div class="link-registro">¿Ya está registrado? <a href="<?php echo $home; ?>/iniciar-sesion">Iniciar sesión</a>.</div> -->
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