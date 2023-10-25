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
    <title>Nueva acción - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
	<?php include("../../system_menu.php"); ?><br>
    <div id="container-inside">
        <h1>Nueva acción</h1>
        <form method="post" action="acciones.php">
            <input type="hidden" name="guardar" value="1" />
            <label>Acción:</label>
            <input type="text" name="accion" maxlength="255" />
            <label>Categoría:</label>
            <select name="categorias[]" multiple style="width: 450px;">
                <?php foreach ($categorias as $r): ?>
                    <option value="<?php echo $r["id"]; ?>"><?php echo $r["categoria"]; ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <a href="acciones.php" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>