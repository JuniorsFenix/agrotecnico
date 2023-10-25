<?php
	include_once("templates/includes.php");
	if(!isset($_GET["documento"])){
		header("Location: /$sitioCfg[carpeta]/documentos-membresia");
	}
	
	$documento = datosContenidoMembresias($_GET["documento"]);
	$categorias = categoriasMembresiasQuery();

    $rMC = membresiasContenidosQuery($documento["idcontenido"]);

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
    <title>Editar documento - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Editar documento</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/documentos-membresia" enctype="multipart/form-data">
            <input type="hidden" name="idcontenido" value="<?php echo $documento["idcontenido"]; ?>" />
            <label for="titulo">Nombre:</label>
            <input type="text" name="titulo" maxlength="255" value="<?php echo $documento["nombre"]; ?>" />
            <label for="idscategorias">Categorías:</label>
            <select name="idscategorias[]" multiple style="width: 450px;">
                <?php foreach ($categorias as $r): ?>
                    <option value="<?php echo $r["idcategoria"]; ?>" <?php echo in_array($r["idcategoria"], $rCategoriasE) ? "selected" : ""; ?>><?php echo $r["nombre"]; ?></option>
                <?php endforeach; ?>
            </select>
            <label>Documento</label>
            <textarea name="contenido"><?php echo $documento["contenido"]; ?></textarea><br>
            <script> CKEDITOR.replace( 'contenido' ); </script>
            <label for="titulo">Url:</label>
            <input type="text" name="url_informacion" value="<?php echo $documento["url_informacion"]; ?>" maxlength="255" />
            <label for="estado">Activar:</label>
            Si <input type="radio" name="estado" value="1" <?=$documento["estado"]==1?"checked":"";?> /> No <input type="radio" name="activo" value="0" <?=$documento["estado"]==0?"checked":"";?> /><br>
            <label>Imagen actual:</label>
            <img src="<?php echo "/$sitioCfg[carpeta]/fotos/documentos/$documento[imagen]"; ?>" width="400"/>
            <label>Cambiar imagen:</label>
            <input type="file" name="imagen" /><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/documentos-membresia" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>