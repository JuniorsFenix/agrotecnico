<?php
	include_once("templates/includes.php");
	if(!isset($_GET["documento"])){
		header("Location: /$sitioCfg[carpeta]/documentos");
	}
	
	$documento = datosDocumento($_GET["documento"]);
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
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/actualizarDocumento" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $documento["id_documento"]; ?>" />
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" maxlength="255" value="<?php echo $documento["titulo"]; ?>" />
            <label>Documento</label>
            <textarea name="documento"><?php echo $documento["documento"]; ?></textarea><br>
            <script> CKEDITOR.replace( 'documento' ); </script>
            <label for="activo">Activar:</label>
            Si <input type="radio" name="activo" value="1" <?=$documento["activo"]==1?"checked":"";?> /> No <input type="radio" name="activo" value="0" <?=$documento["activo"]==0?"checked":"";?> /><br>
            <label>Imagen actual:</label>
            <img src="<?php echo "/$sitioCfg[carpeta]/fotos/documentos/$documento[imagen]"; ?>" width="400"/>
            <label>Cambiar imagen:</label>
            <input type="file" name="logo" /><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/documentos" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>