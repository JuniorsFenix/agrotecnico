<?php
	include_once("templates/includes.php");
	if(!isset($_GET["accion"])){
		header("Location: acciones.php");
		exit;
	}
	
	$accion = datosAccion($_GET["accion"]);
	$categorias = categoriasQuery();

    $rMC = accionesCategoriasQuery($accion["id"]);

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
    <title>Editar Acción - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
	<?php include("../../system_menu.php"); ?><br>
    <div id="container-inside">
        <h1>Editar Acción</h1>
        <form method="post" action="acciones.php" enctype="multipart/form-data">
            <input type="hidden" name="actualizar" value="1" />
            <input type="hidden" name="id" value="<?php echo $accion["id"]; ?>" />
            <label for="titulo">Acción:</label>
            <input type="text" name="accion" maxlength="255" value="<?php echo $accion["accion"]; ?>" />
            <label for="titulo">Categoría:</label>
            <select name="categorias[]" multiple style="width: 450px;">
                <?php foreach ($categorias as $r): ?>
                    <option value="<?php echo $r["id"]; ?>" <?php echo in_array($r["id"], $rCategoriasE) ? "selected" : ""; ?>><?php echo $r["categoria"]; ?></option>
                <?php endforeach; ?>
            </select><br>
            <a href="acciones.php" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>