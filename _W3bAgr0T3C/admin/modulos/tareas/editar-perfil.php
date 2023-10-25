<?php
	include_once("templates/includes.php");
	if(!isset($_GET["perfil"])){
		header("Location: /$sitioCfg[carpeta]/perfiles");
	}
	
	$perfil = datosPerfil($_GET["perfil"]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Editar perfil - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Editar perfil</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/actualizarPerfil">
            <input type="hidden" name="id" maxlength="255" value="<?php echo $perfil["id"]; ?>" />
            <label>Nombre perfil:</label>
            <input type="text" name="perfil" maxlength="255" value="<?php echo $perfil["perfil"]; ?>" />
				<label>Permisos</label>
				<div class="gustos">
					<label class="checkbox mitad">Campañas<input name="campana" value="1" type="checkbox" <?=$perfil["campana"]==1?"checked":"";?> ></label>
					<label class="checkbox mitad">Documentos<input name="documentos" value="1" type="checkbox" <?=$perfil["documentos"]==1?"checked":"";?> ></label>
					<label class="checkbox mitad">Ver y editar usuarios<input name="usuarios" value="1" type="checkbox" <?=$perfil["usuarios"]==1?"checked":"";?> ></label>
					<label class="checkbox mitad">Editar encuestas<input name="editar" value="1" type="checkbox" <?=$perfil["editar"]==1?"checked":"";?> ></label>
					<label class="checkbox mitad">Eliminar encuestas<input name="eliminar" value="1" type="checkbox" <?=$perfil["eliminar"]==1?"checked":"";?> ></label>
					<label class="checkbox mitad">Crear encuestas<input name="crear" value="1" type="checkbox" <?=$perfil["crear"]==1?"checked":"";?> ></label>
					<label class="checkbox mitad">Administrar videos<input name="videos" value="1" type="checkbox" <?=$perfil["videos"]==1?"checked":"";?> ></label>
					<label class="checkbox mitad">Configuración general<input name="configuracion" value="1" type="checkbox" <?=$perfil["configuracion"]==1?"checked":"";?> ></label>
				</div><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/perfiles" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>