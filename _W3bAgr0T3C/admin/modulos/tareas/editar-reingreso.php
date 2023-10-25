<?php
	include_once("templates/includes.php");
	if(!isset($_GET["reingreso"])){
		header("Location: /$sitioCfg[carpeta]/reingresos");
	}
	$usuarios = usuariosQuery();
	$reingreso = datosReingresos($_GET["reingreso"]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Editar Reingreso - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Editar Reingreso</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/reingresos/<?php echo $reingreso["idusuario"]; ?>">
           <input type="hidden" name="idreingreso" value="<?php echo $reingreso["idreingreso"]; ?>" />
           <input type="hidden" name="accion" value="actualizar" />
            <label>Usuario:</label>
			<select name="idusuario">
				<?php foreach($usuarios as $row) { ?>
				<option value="<?php echo $row['id']; ?>" <?=$row['id']==$reingreso["idusuario"]?"selected":"";?> ><?php echo "$row[apellido] $row[nombre]"; ?></option>
				<?php } ?>
			</select>
            <label>Detalle:</label>
            <textarea name="detalle"><?php echo $reingreso["detalle"]; ?></textarea><br>
            <script> CKEDITOR.replace( 'detalle' ); </script>
			<label class="float">
				Desde:<br>
				<input type="date" name="reingreso_desde" maxlength="255" placeholder="Desde" value="<?php echo $reingreso["reingreso_desde"]; ?>" />
			</label>
			<label class="float">
				Hasta:<br>
				<input type="date" name="reingreso_hasta" maxlength="255" placeholder="Hasta" value="<?php echo $reingreso["reingreso_hasta"]; ?>" />
			</label>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/reingresos/<?php echo $reingreso["idusuario"]; ?>" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>