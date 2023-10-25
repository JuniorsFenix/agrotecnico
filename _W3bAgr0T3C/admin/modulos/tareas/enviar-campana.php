<?php
	include_once("templates/includes.php");
	$mensaje = "";
	if(isset($_POST["asunto"])){
		enviarCampana($_POST);
		$mensaje = "Campaña enviada con éxito";
		$_GET["campana"] = $_POST["campana"];
	}
	if(!isset($_GET["campana"])){
		header("Location: /$sitioCfg[carpeta]/campanas");
	}
	$adjuntos = adjuntosAprobados($_GET["campana"]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Enviar campaña - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
	<script>
		setTimeout(function() {
			$('.mensaje').fadeOut('fast');
		}, 3000);
    </script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
    	<h1>Enviar campaña</h1>
        <form method="post">
            <input type="hidden" name="campana" value="<?php echo $_GET["campana"]; ?>" />
        	<span class="mensaje"><?php echo $mensaje; ?></span>
            Seleccionar adjunto: <select name="adjunto" class="mitad">
            <?php foreach($adjuntos as $row) { ?>
              <option value="<?php echo $row["adjunto"]; ?>"><?php echo $row["adjunto"]; ?></option>
            <?php }?>
            </select>
            <label>Asunto</label>
            <input type="text" name="asunto" maxlength="255" required />
            <label>Mensaje</label>
            <textarea name="mensaje"></textarea><br>
            <script> CKEDITOR.replace( 'mensaje' ); </script>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/campanas" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Enviar" title="Enviar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>