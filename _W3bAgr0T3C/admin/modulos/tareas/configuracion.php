<?php
	include_once("templates/includes.php");
	
	global $db;
	if(isset($_POST["asunto"])){
		$stmt = $db->prepare("UPDATE config_tareas SET asunto=:asunto, mensaje=:mensaje WHERE id=:id");
		$stmt->bindValue(':asunto', $_POST["asunto"], PDO::PARAM_STR);
		$stmt->bindValue(':mensaje', $_POST["mensaje"], PDO::PARAM_STR);
		$stmt->bindValue(':id', 1, PDO::PARAM_INT);
		$stmt->execute();
		header("Location: configuracion.php");
		exit;
	}

	$stmt = $db->prepare("SELECT * FROM config_tareas");
	$stmt->execute();
	$config = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Configurar Recordatorio - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="estilos/estilo.css" rel="stylesheet" type="text/css" />
	  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="../../herramientas/ckeditor/ckeditor.js"></script>
</head>

<body>
	<?php include("../../system_menu.php"); ?><br>
    <div id="container-inside">
        <h1>Configurar Recordatorio</h1>
        <form method="post">
            <label>Asunto:</label>
            <input type="text" name="asunto" maxlength="255" value="<?php echo $config["asunto"]; ?>" />
            <label>Mensaje</label>
            <textarea name="mensaje"><?php echo $config["mensaje"]; ?></textarea><br>
            <br>
            <a href="tareas.php" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
    <script> CKEDITOR.replace( 'mensaje' ); </script>
</body>
</html>