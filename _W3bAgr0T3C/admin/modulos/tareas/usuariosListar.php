<?php
	include_once("templates/includes.php");
	$usuarios = usuariosQuery();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Usuarios - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
    	<h1>Usuarios</h1>
        <INPUT class="filtro" id="txtExpresion" type="text" name="txtExpresion" placeholder="Filtrar">
        <ul class="usuarios">
        <?php
            foreach($usuarios as $row) {
            ?>
            <li>
                <a class="imagenUsuario" href="/<?php echo $sitioCfg["carpeta"]; ?>/usuarios/<?php echo $row['id']; ?>">
                    <?php if($row["foto"]!=""){ ?>
                    <img src="<?php echo "/$sitioCfg[carpeta]/fotos/perfiles/$row[foto]"; ?>" alt="<?php echo "$row[apellido] $row[nombre]"; ?>"/>
                    <?php } else { ?>
                    <img src="<?php echo "/$sitioCfg[carpeta]/fotos/perfiles/$row[sexo].png"; ?>" alt="<?php echo $row["sexo"]; ?>"/>
                    <?php } ?>
                </a>
                <div class="infoUsuario">
                    <a class="nombreUsuario" href="/<?php echo $sitioCfg["carpeta"]; ?>/usuarios/<?php echo $row['id']; ?>"><?php echo "$row[apellido] $row[nombre]"; ?></a>
                    <?php echo $row['cargo']; ?>
                    <a class="nombreUsuario" href="/<?php echo $sitioCfg["carpeta"]; ?>/usuarios/<?php echo $row['id']; ?>">Ver muro</a>
                </div>
            </li>
            <?php
                }
            ?>
        </ul>
    </div>
    <?php get_footer() ?>
    <script>
        function updateTemas(opts){
        $.ajax({
        type: "POST",
        url: "submit",
        cache: false, 
        data: {query: opts},
        success: function(html)
        {
        $(".usuarios").html(html);
        } 
        });
        }
        
        $("#txtExpresion").keyup(function(e) {
    	clearTimeout($.data(this, 'timer'));
		var search_string = $(this).val();
         $(this).data('timer', setTimeout(updateTemas(search_string),100));
        });
        
        updateTemas();
    </script> 
</body>
</html>