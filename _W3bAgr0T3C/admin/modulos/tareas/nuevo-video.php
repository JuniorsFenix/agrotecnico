<?php
	include_once("templates/includes.php");
	$encuestas = encuestasQuery();
	$categorias = categoriasMembresiasQuery();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Nuevo video - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Nuevo video</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/guardarVideo" enctype="multipart/form-data">
            <label for="titulo">Url del video:</label>
            <input type="text" name="url" required maxlength="255" />
            <label for="titulo">Título:</label>
            <input type="text" required name="titulo" maxlength="255" />
            <label>Categorías:</label>
            <select name="idscategorias[]" multiple style="width: 450px;">
                <?php foreach ($categorias as $r): ?>
                    <option value="<?php echo $r["idcategoria"]; ?>"><?php echo $r["nombre"]; ?></option>
                <?php endforeach; ?>
            </select>
            <label>Descripción</label>
            <textarea name="descripcion" required></textarea><br>
            <script> CKEDITOR.replace( 'descripcion' ); </script>
            <label for="encuesta">Encuesta relacionada:</label>
            <select name="encuesta">
            	<option value="-1">Ninguna</option>
            	<?php foreach($encuestas as $row) { ?>
            	<option value="<?php echo $row['id']; ?>"><?php echo $row['titulo']; ?></option>
            	<?php } ?>
            </select>
            <label for="activo">Activar:</label>
            Si <input type="radio" name="activo" value="1" checked /> No <input type="radio" name="activo" value="0" /><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/videosAdmin" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>