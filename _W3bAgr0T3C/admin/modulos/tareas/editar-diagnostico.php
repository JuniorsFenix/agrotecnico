<?php
	include_once("templates/includes.php");
	if(!isset($_GET["diagnostico"])){
		header("Location: /$sitioCfg[carpeta]/diagnosticos");
	}
	$categorias = categoriasQuery();
	$diagnostico = datosDiagnosticos($_GET["diagnostico"]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title>Editar diagnóstico - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Editar diagnóstico</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/diagnosticos">
            <input type="hidden" name="iddiagnostico" value="<?php echo $diagnostico["iddiagnostico"]; ?>" />
            <label>Categoría:</label>
            <select name="idcategoria">
				<?php
                foreach($categorias as $row) { ?>
                <option value="<?php echo $row['idcategoria']; ?>" <?=$row['idcategoria']==$diagnostico["idcategoria"]?"selected":"";?>><?php echo $row['categoria']; ?></option>
                <?php
                }
                ?>
            </select>   <a href="/<?php echo $sitioCfg["carpeta"]; ?>/nueva-categoria">Añadir categoría</a>
            <label>Diagnóstico:</label>
            <input type="text" name="diagnostico" maxlength="255" value="<?php echo $diagnostico['diagnostico']; ?>"/><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/diagnosticos" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>