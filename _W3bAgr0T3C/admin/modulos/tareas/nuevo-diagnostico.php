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
    <title>Nuevo diagnóstico - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Nuevo diagnóstico</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/diagnosticos">
            <label>Categoría:</label>
            <select name="idcategoria">
				<?php
                foreach($categorias as $row) { ?>
                <option value="<?php echo $row['idcategoria']; ?>"><?php echo $row['categoria']; ?></option>
                <?php
                }
                ?>
            </select>   <a href="/<?php echo $sitioCfg["carpeta"]; ?>/nueva-categoria">Añadir categoría</a>
            <label>Diagnóstico:</label>
            <input type="text" name="diagnostico" maxlength="255" /><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/diagnosticos" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>