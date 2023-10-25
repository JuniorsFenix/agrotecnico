<?php
	include_once("templates/includes.php");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Crear campaña - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Crear Campaña</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/guardarCampana" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" maxlength="255" />
            <label>Descripción</label>
            <textarea name="descripcion"></textarea><br>
            <script> CKEDITOR.replace( 'descripcion' ); </script>
            <label>Adjuntar archivos: <a href="#nolink" onClick="nuevoAdjunto();"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/add.png" width="20" height="20" /></a></label>
            <script type="text/javascript">
                function nuevoAdjunto(){
                    $('.files-adjuntos').append('<input type="file" name="adjunto[]" /><br/>');
                }
            </script>
            <div class="files-adjuntos">
                <input type="file" name="adjunto[]" /><br/>
            </div><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/campanas" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>