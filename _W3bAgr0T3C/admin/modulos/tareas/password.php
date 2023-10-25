<?php
    if(!session_id()) session_start();
	include("include/funciones.php");
	$sitioCfg = sitioFetch();
	$mensaje = "";
	if(isset($_POST["password"]) && !empty($_POST["password"])){
        cambiarClave($_POST["password"], $_POST["txtClave"], $_POST["txtUsuario"]);
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Endomarketing - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
</head>
<body>
	<header>
    </header>
    <div class="container">
        <form method="post" id="signup"> 
            <input type="hidden" name="txtClave" id="txtClave" value="<?php echo $_GET["n"]; ?>"/>
            <input type="hidden" name="txtUsuario" id="txtClave" value="<?php echo $_GET["id"]; ?>"/>    
            <div class="header">                        
                <h3>Iniciar sesión</h3>                            
                <p>Encuestas</p>                            
            </div>                        
            <div class="sep"></div>                
            <div class="inputs">
            <label>Cambiar contraseña:</label>
            <input type="password" name="password" id="password" maxlength="255" placeholder="Nueva contraseña" class="mitad" />
            <input type="password" name="confirm_password" id="confirm_password" maxlength="255" placeholder="Confirmar contraseña" class="mitad" /> <span id='message'></span>
                <button id="submit" type="submit">ENVIAR</button>                       
            </div>                
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>