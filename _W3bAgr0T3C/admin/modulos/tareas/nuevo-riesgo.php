<?php
	include_once("templates/includes.php");
	$categorias = categoriasQuery();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Nuevo riesgo - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Nuevo riesgo</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/riesgos">
            <label>Categoría:</label>
            <select name="idcategoria">
				<?php
                foreach($categorias as $row) { ?>
                <option value="<?php echo $row['idcategoria']; ?>"><?php echo $row['categoria']; ?></option>
                <?php
                }
                ?>
            </select>   <a href="/<?php echo $sitioCfg["carpeta"]; ?>/nueva-categoria">Añadir categoría</a>
            <label>Riesgo:</label>
            <input type="text" name="riesgo" maxlength="255" />
            <label>Descripción</label>
            <textarea name="descripcion"></textarea><br>
            <script> CKEDITOR.replace( 'descripcion' ); </script>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/riesgos" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>