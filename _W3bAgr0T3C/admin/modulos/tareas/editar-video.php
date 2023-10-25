<?php
	include_once("templates/includes.php");
	if(!isset($_GET["video"])){
		header("Location: /$sitioCfg[carpeta]/videosAdmin");
	}
	
	$video = datosVideo($_GET["video"]);
	$encuestas = encuestasQuery();
	
	$categorias = categoriasMembresiasQuery();

    $rMC = membresiasVideosQuery($video["id_video"]);
	$rCategoriasE = array();
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
    <title>Editar video - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Editar video</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/actualizarVideo" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $video["id_video"]; ?>" />
            <label for="url">Url del video:</label>
            <input type="text" name="url" maxlength="255" value="<?php echo $video["url"]; ?>" />
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" maxlength="255" value="<?php echo $video["titulo"]; ?>" />
            <label for="idscategorias">Categorías:</label>
            <select name="idscategorias[]" multiple style="width: 450px;">
                <?php foreach ($categorias as $r): ?>
                    <option value="<?php echo $r["idcategoria"]; ?>" <?php echo in_array($r["idcategoria"], $rCategoriasE) ? "selected" : ""; ?>><?php echo $r["nombre"]; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion"><?php echo $video["descripcion"]; ?></textarea><br>
            <script> CKEDITOR.replace( 'descripcion' ); </script>
            <label for="encuesta">Encuesta relacionada:</label>
            <select name="encuesta">
            	<option value="-1">Ninguna</option>
            	<?php foreach($encuestas as $row) { ?>
            	<option value="<?php echo $row['id']; ?>" <?=$video["id_encuesta"]==$row['id']?"selected":"";?>><?php echo $row['titulo']; ?></option>
            	<?php } ?>
            </select>
            <label for="activo">Activar:</label>
            Si <input type="radio" name="activo" value="1" <?=$video["activo"]==1?"checked":"";?> /> No <input type="radio" name="activo" value="0" <?=$video["activo"]==0?"checked":"";?> /><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/videosAdmin" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>