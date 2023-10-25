<?php
	include_once("templates/includes.php");
	$link = "";
	if(isset($_GET["usuario"])){
		$link = "/$_GET[usuario]";
	}
	if(isset($_POST["descripcion"])){
        guardarHistorial($_POST,$_FILES);
		header("Location: /$sitioCfg[carpeta]/historial-medico{$link}");
		exit;
	}
	$usuarios = usuariosQuery();
	$categorias = categoriasDiagQuery();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Nuevo historial - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Nuevo historial</h1>
        <form method="post" enctype="multipart/form-data">
            <label>Usuario:</label>
            <select name="idusuario">
				<?php
                foreach($usuarios as $row) { ?>
                <option value="<?php echo $row['id']; ?>" <?=$row['id']==$_GET["usuario"]?"selected":"";?>><?php echo "$row[apellido] $row[nombre]"; ?></option>
                <?php
                }
                ?>
            </select><br><br>
            <label>Diagnósticos:</label>
            <div class="containerDiag">
			<?php foreach($categorias as $row) { 
				$diagnosticos = diagnosticosQuery2($row["idcategoria"]);?>
                <div class="diagnosticos">
                    <label><?php echo $row["categoria"] ?></label>
                    <div class="gustos">
                    <?php foreach($diagnosticos as $row) { ?>
                        <label class="checkbox"><?php echo $row['diagnostico']; ?><input name="diagnosticos[]" value="<?php echo $row['iddiagnostico']; ?>" type="checkbox" ></label>
                    <?php } ?>
                    </div>
                </div>
            <?php } ?>
            </div>
            <label>Descripción (CONFIDENCIAL)</label>
            <textarea name="descripcion"></textarea><br>
            <script> CKEDITOR.replace( 'descripcion' ); </script>
            <label>Recomendaciones</label>
            <textarea name="recomendaciones"></textarea><br>
            <script> CKEDITOR.replace( 'recomendaciones' ); </script>
            <div>Activar alertas <input type="checkbox" name="alerta" class="alerta"></div>
		    <div class="alertas" style="display:none;">
            	<label>Examen médico</label>
				<textarea name="examen"></textarea><br>
				<script> CKEDITOR.replace( 'examen' ); </script>
            	<input type="file" name="archivo" /> Examen enviado <input type="checkbox" name="enviado">
            	<label>Fecha límite</label>
            	<input type="date" name="fecha_limite"/>
            	<label>Recordatorio</label>
				<textarea name="recordatorio"></textarea><br>
				<script> CKEDITOR.replace( 'recordatorio' ); </script>
				Enviar recordatorio <input type="number" name="horas" id="dia" placeholder="00" maxlength="2" value="01"> horas antes de la fecha límite.<br>
            	<label>
            		Copias <a href="#nolink" onclick="nuevaImagen();"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/add.png" width="15" /></a
            	</label>
				<script type="text/javascript">

				function nuevaImagen(){

					$('.copias').append('<li><input type="email" name="copia[]" /> <a href="#nolink" class="remove"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/eliminar.png" width="15" /></a></li>');
				}

				$(document).on("click", ".remove", function(){
				   $(this).parent('li').remove();
				});
				</script>
				<ul class="copias">
				<li><input type="email" name="copia[]" value="andres@estilod.com" /></li>
				</ul>
			</div><br>
			<script type="text/javascript">	
				$(document).ready(function(){
					$('.alerta').change(function(){
						if(this.checked)
							$('.alertas').fadeIn('slow');
						else
							$('.alertas').fadeOut('slow');

					});
				});
			</script> 
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/historial-medico<?php echo $link; ?>" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>