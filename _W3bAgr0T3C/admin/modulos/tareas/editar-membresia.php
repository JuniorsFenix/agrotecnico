<?php
	include_once("templates/includes.php");
	if(!isset($_GET["membresia"])){
		header("Location: /$sitioCfg[carpeta]/membresias");
		exit;
	}
	
	$membresia = datosMembresias($_GET["membresia"]);
	$categorias = categoriasMembresiasQuery();

    $rMC = membresiasCategoriasQuery($membresia["idmembresia"]);

    foreach ($rMC as $r) {
        $rCategoriasE[] = $r["idcategoria"];
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Editar Membresía - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Editar Membresía</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/membresias" enctype="multipart/form-data">
            <input type="hidden" name="idmembresia" value="<?php echo $membresia["idmembresia"]; ?>" />
            <label for="titulo">Membresía:</label>
            <input type="text" name="membresia" maxlength="255" value="<?php echo $membresia["nombre"]; ?>" />
            <label for="titulo">Categorías:</label>
            <select name="idscategorias[]" multiple style="width: 450px;">
                <?php foreach ($categorias as $r): ?>
                    <option value="<?php echo $r["idcategoria"]; ?>" <?php echo in_array($r["idcategoria"], $rCategoriasE) ? "selected" : ""; ?>><?php echo $r["nombre"]; ?></option>
                <?php endforeach; ?>
            </select><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/membresias" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>