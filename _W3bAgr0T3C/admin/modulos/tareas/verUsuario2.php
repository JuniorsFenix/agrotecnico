<?php
	include_once("templates/includes.php");
	if(!isset($_GET["usuario"])){
		header("Location: /$sitioCfg[carpeta]/usuarios");
	}
	$usuario = datosUsuario($_GET["usuario"]);
	
	if(isset($_POST["mensaje"])){
        guardarMensaje($_POST);
	}
	
	$mensajes = muroQuery($usuario["id"]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title><?php echo "$usuario[nombre] $usuario[apellido]"; ?> - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
    	<h1><?php echo "$usuario[nombre] $usuario[apellido]"; ?></h1>
    	<div class="col1">
            <?php if($usuario["foto"]!=""){ ?>
            <img src="<?php echo "/fotos/perfiles/$usuario[foto]"; ?>"/>
			<?php } else { ?>
            <img src="<?php echo "/fotos/perfiles/$usuario[sexo].png"; ?>"/>
			<?php } ?>
        </div>
    	<div class="col2">
        	<div id="mensajes">
                <h2>Escribir mensaje</h2>
                <form method="post">
                	<input type="hidden" value="<?php echo $usuario["id"]; ?>" name="idusuario">
                	<input type="hidden" value="<?php echo $_SESSION["id"]; ?>" name="idusuario2">
                    <div class="imagenMensaje">
                        <?php if($_SESSION["foto"]!=""){ ?>
                        <img src="<?php echo "/fotos/perfiles/$_SESSION[foto]"; ?>" alt="<?php echo "$_SESSION[nombre] $_SESSION[apellido]"; ?>"/>
                        <?php } else { ?>
                        <img src="<?php echo "/fotos/perfiles/$_SESSION[sexo].png"; ?>" alt="<?php echo $_SESSION["sexo"]; ?>"/>
                        <?php } ?>
                    </div>
                    <textarea name="mensaje"></textarea><br>
                    <input type="submit" value="Enviar">
                </form>
            <?php
                foreach($mensajes as $row) {
            ?>
            <div class="mensajes">
                <a class="imagenMensaje" href="/usuarios/<?php echo $row['id']; ?>">
                    <?php if($row["foto"]!=""){ ?>
                    <img src="<?php echo "/fotos/perfiles/$row[foto]"; ?>" alt="<?php echo "$row[nombre] $row[apellido]"; ?>"/>
                    <?php } else { ?>
                    <img src="<?php echo "/fotos/perfiles/$row[sexo].png"; ?>" alt="<?php echo $row["sexo"]; ?>"/>
                    <?php } ?>
                </a>
                <a class="nombreUsuario" href="/usuarios/<?php echo $row['id']; ?>"><?php echo "$row[nombre] $row[apellido]"; ?></a>
                <?php echo $row["mensaje"]; ?>
                <form method="post">
                	<input type="hidden" value="<?php echo $_SESSION["id"]; ?>" name="idusuario">
                	<input type="hidden" value="<?php echo $row['idmensaje']; ?>" name="idmensaje">
                    <div class="imagenMensaje">
                        <?php if($_SESSION["foto"]!=""){ ?>
                        <img src="<?php echo "/fotos/perfiles/$_SESSION[foto]"; ?>" alt="<?php echo "$_SESSION[nombre] $_SESSION[apellido]"; ?>"/>
                        <?php } else { ?>
                        <img src="<?php echo "/fotos/perfiles/$_SESSION[sexo].png"; ?>" alt="<?php echo $_SESSION["sexo"]; ?>"/>
                        <?php } ?>
                    </div>
                    <textarea name="respuesta" placeholder="Responder"></textarea><br>
                    <input type="submit" value="Enviar">
                </form>
            </div>
            <?php
                }
            ?>
            </div>
        </div>
    </div>
    <?php get_footer() ?>
</body>
</html>