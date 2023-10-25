<?php
	include_once("templates/includes.php");
	$perfil = datosPerfil($_SESSION["perfil"]);
	if(isset($_GET["video"])){
	$video = datosVideo($_GET["video"]);
	}
	else{
	$video = datosVideo(-1);
	}
	
	$videos = videosQuery();
    $url = explode("watch?v=",$video["url"]);
    $url = explode("&",$url[1]);
    $url = $url[0];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title><?php echo $video["titulo"]; ?> - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/data.table.css" rel="stylesheet" type="text/css" />
	<link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/jqueryui.css" rel="stylesheet" type="text/css" />   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
    	<div class="video">
        	<div class="videoWrapper">
            	<iframe src="https://www.youtube.com/embed/<?php echo $url; ?>" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="descripcion">
                <h1><?php echo $video["titulo"]; ?></h1>
                <strong>Fecha de publicación:</strong> <?php echo $video["fecha"]; ?><br>
                <?php echo $video["descripcion"]; ?>
            </div>
        </div>
        <div class="relacionados">
            <?php if($perfil["videos"]==1){ ?><a class="admin" href="/videosAdmin">Administrar videos</a><?php } ?>
    		
			<?php foreach($videos as $row) { ?>
            <div class="miniatura">
                <a href="/<?php echo $sitioCfg["carpeta"]; ?>/videos/<?php echo $row["id_video"];?>">
                <img src="<?php echo videosYoutubePreview($row["url"]);?>" alt="<?php echo $row["titulo"];?>"  />
                <span class="tituloVideo"><?php echo $row["titulo"];?></span>
                <span class="fechaVideo"><?php echo $row["fecha"];?></span>
                </a>
            </div>
			<?php
                }
            ?>
        </div>
    </div>
    <?php get_footer() ?>
</body>
</html>