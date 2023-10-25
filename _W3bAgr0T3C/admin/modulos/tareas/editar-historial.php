<?php
	include_once("templates/includes.php");
	if(!isset($_GET["historial"])){
		header("Location: /$sitioCfg[carpeta]/historial-medico");
	}
	
	$historial = datosHistorial($_GET["historial"]);
	if(isset($_POST["descripcion"])){
        actualizarHistorial($_POST,$_FILES);
		header("Location: /$sitioCfg[carpeta]/historial-medico/{$_POST[idusuario]}");
		exit;
	}
	$usuarios = usuariosQuery();
	$check=checkHistorial($historial["idusuario"],$_GET["historial"]);
	$categorias = categoriasDiagQuery();
	$copias = copiasQuery($_GET["historial"]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Editar historial - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/include/ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Editar historial</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="idhistorial" value="<?php echo $historial["idhistorial"] ?>">
            <label>Usuario:</label>
            <select name="idusuario">
				<?php foreach($usuarios as $row) { ?>
                <option value="<?php echo $row['id']; ?>" <?=$row['id']==$historial["idusuario"]?"selected":"";?>><?php echo "$row[apellido] $row[nombre]"; ?></option>
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
                        <label class="checkbox"><?php echo $row['diagnostico']; ?><input name="diagnosticos[]" value="<?php echo $row['iddiagnostico']; ?>" type="checkbox" <?=in_array($row['iddiagnostico'],$check)?"checked":"";?> ></label>
                    <?php } ?>
                    </div>
                </div>
            <?php } ?>
            </div>
            <label>Descripción (CONFIDENCIAL)</label>
            <textarea name="descripcion"><?php echo $historial["descripcion"]; ?></textarea><br>
            <script> CKEDITOR.replace( 'descripcion' ); </script>
            <label>Recomendaciones</label>
            <textarea name="recomendaciones"><?php echo $historial["recomendaciones"]; ?></textarea><br>
            <script> CKEDITOR.replace( 'recomendaciones' ); </script>
            <div>Activar alertas <input type="checkbox" name="alerta" class="alerta" <?=$historial["alerta"]==1?"checked":"";?>></div>
		    <div class="alertas" style="display:none;">
            	<label>Examen médico</label>
				<textarea name="examen"><?php echo $historial["examen"]; ?></textarea><br>
				<script> CKEDITOR.replace( 'examen' ); </script>
            	<input type="file" name="archivo" /> Examen enviado <input type="checkbox" name="enviado" <?=$historial["enviado"]==1?"checked":"";?>>
            	<label>Fecha límite</label>
            	<input type="date" name="fecha_limite" value="<?php echo $historial["fecha_limite"]; ?>"/>
            	<label>Recordatorio</label>
				<textarea name="recordatorio"><?php echo $historial["recordatorio"]; ?></textarea><br>
				<script> CKEDITOR.replace( 'recordatorio' ); </script>
				Enviar recordatorio <input type="number" name="horas" id="dia" placeholder="00" maxlength="2" value="<?php echo $historial["horas"]; ?>"> horas antes de la fecha límite.<br>
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
				  <?php foreach($copias as $row):?>
					<li><input type="email" name="copia[]" value="<?php echo $row["correo"]; ?>" />
						<a href="#nolink" class="remove"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/eliminar.png" width="15" /></a>
					</li>
				  <?php endforeach;?>
				</ul>
			</div><br>
			<script type="text/javascript">	
				$(document).ready(function(){
						if($('.alerta').is(':checked')){
							$('.alertas').fadeIn('slow');
						}
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