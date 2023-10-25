<?php
	include_once("templates/includes.php");
	if(!isset($_GET["campana"])){
		header("Location: /$sitioCfg[carpeta]/campanas");
	}
	
	$campana = datosCampana($_GET["campana"]);
	$mensajes = mensajesQuery($_GET["campana"]);
	$adjuntosC = adjuntosQuery($_GET["campana"]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Responder Campaña - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1><?php echo $campana["titulo"]; ?></h1>
        <strong>Estado:</strong> <?php echo $campana["estado"]; ?>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/responderCampana" enctype="multipart/form-data">
        <div class="campana staff">
        	<div class="usuario">
            	<?php echo "$campana[nombre] $campana[apellido]"; ?> (Estilo y Diseño)<br>
                <strong><?php echo $campana["cargo"]; ?></strong>
            </div>
            <div class="mensajes">
				<?php echo $campana["descripcion"]; ?><br><br>
                <strong>Adjuntos:</strong><br>
                <?php foreach ($adjuntosC as $row): ?>
                    <div class="adjunto">
                        <a href="<?php echo "/$sitioCfg[carpeta]/fotos/campanas/{$row["adjunto"]}"; ?>" target="_blank">Descargar <?php echo $row["adjunto"]; ?></a>
                        <span>
                        Estado: <select name="estadoA[<?php echo $row["id"]; ?>]" class="mitad">
                                  <option value="Por Aprobar" <?php echo $row["estado"] == "Por Aprobar" ? "selected" : ""; ?>>Por Aprobar</option>
                                  <option value="Aprobado" <?php echo $row["estado"] == "Aprobado" ? "selected" : ""; ?>>Aprobado</option>
                                </select>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php 
		$class = "";
		$empresa = $sitioCfg["nombre"];
		foreach ($mensajes as $m):
		$adjuntosM = adjuntosQuery(-1,$m["id_mensaje"]);
		if($m["correo"]=="andres@estilod.com" || $m["correo"]=="claudio@estilod.com"){
		$class = "staff";
		$empresa = "Estilo y Diseño";
		}
		?>
        <div class="campana <?php echo $class?>">
        	<div class="usuario">
            	<?php echo "$m[nombre] $m[apellido] ($empresa)"; ?><br>
                <strong><?php echo $m["cargo"]; ?></strong>
            </div>
            <div class="mensajes">
				<?php echo $m["descripcion"]; ?><br><br>
                <strong>Adjuntos:</strong><br>
                <?php foreach ($adjuntosM as $row): ?>
                    <div class="adjunto">
                        <a href="<?php echo "/$sitioCfg[carpeta]/fotos/campanas/{$row["adjunto"]}"; ?>" target="_blank">Descargar <?php echo $row["adjunto"]; ?></a>
                        <span>
                        Estado: <select name="estadoA[<?php echo $row["id"]; ?>]" class="mitad">
                                  <option value="Por Aprobar" <?php echo $row["estado"] == "Por Aprobar" ? "selected" : ""; ?>>Por Aprobar</option>
                                  <option value="Aprobado" <?php echo $row["estado"] == "Aprobado" ? "selected" : ""; ?>>Aprobado</option>
                                </select>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <h2>Responder</h2>
            <input type="hidden" name="id" value="<?php echo $campana["id_campana"]; ?>" />
        	Estado: <select name="estado">
                      <option value="Por Aprobar" <?php echo $campana["estado"] == "Por Aprobar" ? "selected" : ""; ?>>Por Aprobar</option>
                      <option value="Aprobado" <?php echo $campana["estado"] == "Aprobado" ? "selected" : ""; ?>>Aprobado</option>
                    </select>
            <label>Descripción</label>
            <textarea name="descripcion"></textarea><br>
            <script> CKEDITOR.replace( 'descripcion' ); </script>
            <label>Adjuntar archivos: <a href="#nolink" onClick="nuevoAdjunto();"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/add.png" width="20" height="20" /></a></label>
            <script type="text/javascript">
                function nuevoAdjunto(){
                    $('.files-adjuntos').append('<input type="file" name="adjunto[]" /><br/>');
                }
            </script>
            <div class="files-adjuntos">
                <input type="file" name="adjunto[]" /><br/>
            </div><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/campanas" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>