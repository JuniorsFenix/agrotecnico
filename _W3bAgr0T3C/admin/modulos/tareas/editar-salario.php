<?php
	include_once("templates/includes.php");
	if(!isset($_GET["salario"])){
		header("Location: /$sitioCfg[carpeta]/salarios");
	}
	$usuarios = usuariosQuery();
	$salario = datosSalarios($_GET["salario"]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Editar Salario - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Editar Salario</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/salarios/<?php echo $salario["idusuario"]; ?>">
           <input type="hidden" name="idsalario" value="<?php echo $salario["idsalario"]; ?>" />
           <input type="hidden" name="accion" value="actualizar" />
            <label>Usuario:</label>
			<select name="idusuario">
				<?php foreach($usuarios as $row) { ?>
				<option value="<?php echo $row['id']; ?>" <?=$row['id']==$salario["idusuario"]?"selected":"";?> ><?php echo "$row[apellido] $row[nombre]"; ?></option>
				<?php } ?>
			</select>
            <label>Salario:</label>
			<input type="number" name="salario" maxlength="255" placeholder="Salario" value="<?php echo $salario["salario"]; ?>" />
			<label class="float">
				Desde:<br>
				<input type="date" name="salario_desde" maxlength="255" placeholder="Desde" value="<?php echo $salario["salario_desde"]; ?>" />
			</label>
			<label class="float">
				Hasta:<br>
				<input type="date" name="salario_hasta" maxlength="255" placeholder="Hasta" value="<?php echo $salario["salario_hasta"]; ?>" />
			</label>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/salarios/<?php echo $salario["idusuario"]; ?>" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>