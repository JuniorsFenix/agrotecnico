<?php
    if(!session_id()) session_start();
	include("include/funciones.php");
	$sitioCfg = sitioFetch();
	$mensaje = "";
	if(isset($_POST["correo"]) && !empty($_POST["correo"])){
		$login = login($_POST["correo"], $_POST["password"]);
		if($login == "correo"){
		$mensaje = "El correo y la contraseña no coinciden.";
		}
		elseif($login == "password"){
		$mensaje = "El correo y la contraseña no coinciden.";
		}
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Endomarketing - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="estilos/estilo.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<header>
    </header>
    <div class="container">
        <form method="post" id="signup">     
            <div class="header">                        
                <h3>Iniciar sesión</h3>                            
                <p>Encuestas</p>                            
            </div>                        
            <div class="sep"></div>                
            <div class="inputs">
                <label>Correo</label>                        
                <input type="email" name="correo" required class="input-small"><br>
                <label>Contraseña</label>                        
                <input type="password" name="password" required class="input-small"><br>
                <span class='mensajeCorreo'><?php echo $mensaje; ?></span><br>  
                <button id="submit" type="submit">ENTRAR</button>
                <a href="recuperar-password.php">¿Olvidó su contraseña?</a>                        
            </div>                
        </form>
    </div>
</body>
</html>