<?php include_once("templates/includes.php"); 
	require_once("membresias.inc.php");
	$perfil = datosPerfil($_SESSION["perfil"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Encuestas - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <?php if ($check == false){
		$video = videoEncuesta();
		$url = explode("watch?v=",$video["url"]);
		$url = explode("&",$url[1]);
		$url = $url[0];
		$titulo = $video["titulo"];
	} 
    ?>
</head>

<body>
<div id="dialog-message" title="<?php echo $titulo; ?>">
    <div id="yt-player"></div>
</div>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
    	<div class="contenidosMembresia">
        	<h2>Documentos</h2>
			 <?php if ( ($rMembresia = Membresias::membresiaCargar())!=false ) {
                $rContenidos = Membresias::contenidosCargar();
                //echo "Membresía: $rMembresia[nombre]";
                foreach ($rContenidos as $r): ?>
                    <div class="categorias">
                        <h3><?php echo $r["nombre"]; ?></h3>
                        <?php foreach ($r["contenidos"] as $c): ?>
                            <b>
                                <a href="#<?php //echo $r["idcategoria"];?><?php //echo $c["idcontenido"]; ?>">
                                    <?php echo $c["nombre"]; ?>
                                </a>
                            </b>
                            <br/>
                            <p>
                                <?php if ($c["imagen"] != ""): ?>
                                    <img src="/<?php echo $sitioCfg["carpeta"]; ?>/fotos/documentos/<?php echo "{$c["imagen"]}"; ?>" alt="<?php echo $c["nombre"]; ?>" width="200" hspace="6" align="left" />
                                <?php endif; 
                                 echo $c["contenido"]; ?>...
                                <br /><br />
                                <a href="/<?php echo $sitioCfg["carpeta"]; ?>/documentos-membresia">Ver todos</a>
                            </p>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach;
                ?>
            <?php }?>
    	</div>
    	<div class="contenidosMembresia">
        	<h2>Archivos</h2>
			 <?php if ( ($rMembresia = Membresias::membresiaCargar())!=false ) {
				$rArchivos = Membresias::archivosCargar();
				 foreach ($rArchivos as $r): ?>
                    <div class="categorias">
						<h3><?php echo $r["nombre"]; ?></h3>
                        <ul>
                            <?php foreach ($r["archivos"] as $a): ?>
                            <li>
                                <a href="/<?php echo $sitioCfg["carpeta"]; ?>/fotos/archivos/<?php echo $a["archivo"]; ?>" target="_blank"><?php echo $a["nombre"]; ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
					</div>
				<?php endforeach; ?>
            <?php }?> <br />
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/archivos-membresia">Ver todos</a>
    	</div>
        <div class="videosMembresia">
        	<h2>Videos</h2>
			 <?php if ( ($rMembresia = Membresias::membresiaCargar())!=false ) {
                $rContenidos = Membresias::videosCargar();
                //echo "Membresía: $rMembresia[nombre]";
                foreach ($rContenidos as $r): ?>
                    <div class="categorias">
                        <h3><?php echo $r["nombre"]; ?></h3>
                        <?php foreach ($r["contenidos"] as $c): 
						$url = explode("watch?v=",$c["url"]);
						$url = explode("&",$url[1]);
						$url = $url[0];?>
                        <div class="videoWrapper">
                            <iframe src="https://www.youtube.com/embed/<?php echo $url; ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <?php echo $c["contenido"]; ?>...<br>
                        <a href="/<?php echo $sitioCfg["carpeta"]; ?>/videos">Ver todos</a>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach;
                ?>
            <?php }?>
        </div>
    </div>
    <?php get_footer() ?>
</body>
</html>