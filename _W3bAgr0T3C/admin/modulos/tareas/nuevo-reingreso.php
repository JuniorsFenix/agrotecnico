<?php
	include_once("templates/includes.php");
	$link = "";
	if(isset($_GET["usuario"])){
		$link = "/$_GET[usuario]";
	}
	$usuarios = usuariosQuery();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Nuevo Reingreso - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Nuevo Reingreso</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/reingresos">
           <input type="hidden" name="accion" value="nuevo" />
            <label>Usuario:</label>
			<select name="idusuario">
				<?php foreach($usuarios as $row) { ?>
				<option value="<?php echo $row['id']; ?>" <?=$row['id']==$_GET["usuario"]?"selected":"";?> ><?php echo "$row[apellido] $row[nombre]"; ?></option>
				<?php } ?>
			</select>
            <label>Detalle:</label>
            <textarea name="detalle"></textarea><br>
            <script> CKEDITOR.replace( 'detalle' ); </script>
			<label class="float">
				Desde:<br>
				<input type="date" name="reingreso_desde" maxlength="255" placeholder="Desde" />
			</label>
			<label class="float">
				Hasta:<br>
				<input type="date" name="reingreso_hasta" maxlength="255" placeholder="Hasta" />
			</label>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/reingresos<?php echo $link; ?>" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>