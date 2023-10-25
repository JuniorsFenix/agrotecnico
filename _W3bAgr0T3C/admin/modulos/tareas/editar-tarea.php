<?php
	include_once("templates/includes.php");
	if(!isset($_GET["tarea"])){
		header("Location: tarea.php");
		exit;
	}
	
	$tarea = datosTarea($_GET["tarea"]);
	$empresas = empresasQuery();
	$usuarios = usuariosQuery();
	$acciones = accionesQuery($tarea["id"],"Todas");
	$acciones2 = accionesQuery($tarea["id"]);
	$categorias = categoriasQuery();
	$tareas = tareasQuery($tarea["id"]);

	$check=checkTareas($tarea["id"]);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Editar Acción - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="estilos/estilo.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../../herramientas/timepicker/jquery-ui-timepicker-addon.css">
	  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	  <script src="../../herramientas/timepicker/jquery-ui-timepicker-addon.js"></script>
	<script src="../../herramientas/ckeditor/ckeditor.js"></script>
	<style type="text/css">
		.gustos {
			text-align: left;
		}
		.gustos .checkbox {
			float: left;
			width: 33.3%;
		}
		.float {
			float: left;
			width: 33.3%;
			padding-right: .6%;
		}
		.Pendiente span:nth-child(2) {
			color:#AF0002;
		}
		.Completada span:nth-child(2) {
			color:#207C00;
		}
		.Pendiente span:nth-child(3) {
			display: none;
		}
		.Completada span:nth-child(3) {
			display: inline;
		}
		.gustos select{
			display: none;
		}
		.mensaje{
			width: 100%;
			position: relative;
			overflow: hidden;
			border-top: 1px solid #e9ebee;
			padding: 12px 12px 12px 77px;
			min-height: 87px;
		}
		.siglas{
			width: 65px;
			height: 65px;
			text-align: center;
			color: #FFF;
			position: absolute;
			top: 12px;
			left: 0;
			border-radius: 50%;
			font-size: 1.8em;
			padding-top: 10px;
			box-sizing: border-box;
			margin-right: 12px;
		}
		.usuario{
			display: inline-block;
		}
		.fecha{
			color:#828790;
			font-size: 13px;
			margin-left: 9px;
		}
	</style>
</head>

<body>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Editar Tarea</h1>
        <form method="post" action="tareas.php" enctype="multipart/form-data">
            <input type="hidden" name="actualizar" value="1" />
            <input type="hidden" name="id" id="tarea" value="<?php echo $tarea["id"]; ?>" />
            <label>Tarea:</label>
            <input type="text" name="tarea" maxlength="255" value="<?php echo $tarea["tarea"]; ?>" />
            <label>Prioridad:</label>
            <select name="prioridad" style="width: 450px;">
				<option value="Alta" <?php echo "Alta"==$tarea["prioridad"] ? "selected" : ""; ?>>Alta</option>
				<option value="Media" <?php echo "Media"==$tarea["prioridad"] ? "selected" : ""; ?>>Media</option>
				<option value="Baja" <?php echo "Baja"==$tarea["prioridad"] ? "selected" : ""; ?>>Baja</option>
            </select>
            <label>Empresa:</label>
            <select name="idempresa" style="width: 450px;">
                <?php foreach ($empresas as $r): ?>
                    <option value="<?php echo $r["idempresa"]; ?>" <?php echo $r["idempresa"]==$tarea["idempresa"] ? "selected" : ""; ?>><?php echo $r["nombre"]; ?></option>
                <?php endforeach; ?>
            </select>
            <label>Responsable:</label>
            <select name="idusuario" style="width: 450px;">
                <?php foreach ($usuarios as $r): ?>
                    <option value="<?php echo $r["idusuario"]; ?>" <?php echo $r["idusuario"]==$tarea["idusuario"] ? "selected" : ""; ?>><?php echo $r["nombres"]; ?></option>
                <?php endforeach; ?>
            </select>
            <label>Requisito:</label>
            <select name="requisito" style="width: 450px;">
                <option value="0">Ninguno</option>
                <?php foreach ($tareas as $r): ?>
                <option value="<?php echo $r["id"]; ?>" <?php echo $r["id"]==$tarea["requisito"] ? "selected" : ""; ?>><?php echo $r["tarea"]; ?></option>
                <?php endforeach; ?>
            </select>
            <label>Categoría:</label>
            <select id="categoria" name="categoria" style="width: 450px;">
                <?php foreach ($categorias as $r): ?>
                    <option value="<?php echo $r["id"]; ?>" <?php echo $r["id"]==$tarea["idcategoria"] ? "selected" : ""; ?>><?php echo $r["categoria"]; ?></option>
                <?php endforeach; ?>
            </select>
            <label>Acciones:</label>
            <div class="gustos" id="acciones">
				<div class="list-wrapper">
					<div class="list">
						<div class="list-header">
							<h2>Disponibles</h2>
						</div>
						<div class="list-actions" data-estado="Disponible">
						<?php 
							$db = get_db();
							$query= "SELECT a.* FROM acciones a LEFT JOIN acciones_tareas at on a.id=at.idaccion and at.idtarea={$tarea["id"]} WHERE at.idaccion IS NULL ORDER BY a.accion";
							$acciones = $stmt = $db->query($query);
							foreach ($acciones as $r): ?>
							<div class="list-action openmodal" id="accion-<?php echo $r["id"]; ?>" data-id="<?php echo $r["id"]; ?>">
								<?php echo $r["accion"]; ?>
								<img src="imagenes/editar.png" alt="Editar" width="15px">
							</div>
						<?php endforeach; ?>
						</div>
					</div>
				</div>
            <div class="list-wrapper">
				<div class="list">
					<div class="list-header">
						<h2>Seleccionadas</h2>
					</div>
					<div class="list-actions" data-estado="Pendiente">
						<?php 
							$db = get_db();
							$query= "SELECT a.* FROM acciones a JOIN acciones_tareas at on a.id=at.idaccion WHERE at.idtarea={$tarea["id"]} AND estado='Pendiente'";
							$acciones = $stmt = $db->query($query);
							foreach ($acciones as $r): ?>
							<div class="list-action openmodal" id="accion-<?php echo $r["id"]; ?>" data-id="<?php echo $r["id"]; ?>">
								<?php echo $r["accion"]; ?>
								<img src="imagenes/editar.png" alt="Editar" width="15px">
							</div>
						<?php endforeach; ?>
					</div>
				</div>
            </div>
            <div class="list-wrapper">
				<div class="list">
					<div class="list-header">
						<h2>En proceso</h2>
					</div>
					<div class="list-actions" data-estado="En proceso">
						<?php 
							$db = get_db();
							$query= "SELECT a.* FROM acciones a JOIN acciones_tareas at on a.id=at.idaccion WHERE at.idtarea={$tarea["id"]} AND estado='En proceso'";
							$acciones = $stmt = $db->query($query);
							foreach ($acciones as $r): ?>
							<div class="list-action openmodal" id="accion-<?php echo $r["id"]; ?>" data-id="<?php echo $r["id"]; ?>">
								<?php echo $r["accion"]; ?>
								<img src="imagenes/editar.png" alt="Editar" width="15px">
							</div>
						<?php endforeach; ?>
					</div>
				</div>
            </div>
            <div class="list-wrapper">
				<div class="list">
					<div class="list-header">
						<h2>Completadas</h2>
					</div>
					<div class="list-actions" data-estado="Completada">
						<?php 
							$db = get_db();
							$query= "SELECT a.* FROM acciones a JOIN acciones_tareas at on a.id=at.idaccion WHERE at.idtarea={$tarea["id"]} AND estado='Completada'";
							$acciones = $stmt = $db->query($query);
							foreach ($acciones as $r): ?>
							<div class="list-action openmodal" id="accion-<?php echo $r["id"]; ?>" data-id="<?php echo $r["id"]; ?>">
								<?php echo $r["accion"]; ?>
								<img src="imagenes/editar.png" alt="Editar" width="15px">
							</div>
						<?php endforeach; ?>
					</div>
				</div>
            </div>
			</div>
            <script>
			$('body').on('change', '#categoria', function(event) {
                event.preventDefault();
                var pcategoria = $('#categoria').val();
                $.post(
                    'ajaxAcciones.php', {
                    categoria: pcategoria
                },
                function(data) {
                    $('#acciones').html(data);
                });
            });
			</script>
			<label class="float">
				Fecha de inicio:<br>
				<input class="fecha" type="text" name="inicio" maxlength="255" placeholder="Inicio" value="<?php echo $tarea["inicio"]; ?>" />
			</label>
			<label class="float">
				Fecha de entrega:<br>
				<input class="fecha" type="text" name="entrega" maxlength="255" placeholder="Entrega" value="<?php echo $tarea["entrega"]; ?>" />
			</label>
			<label class="float">
				Fecha de culminación:<br>
				<input type="text" disabled name="culminacion" maxlength="255" placeholder="Culminación" value="<?php echo $tarea["culminacion"]; ?>" />
			</label>
            <br>
            <label style="clear: both;">Enviar recordatorio <input value="<?php echo $tarea["recordatorio"]; ?>" type="text" name="recordatorio" maxlength="2" style="width: 50px" />  horas antes de la fecha de entrega</label>
            <label>Anotaciones:</label>
			<textarea name="anotaciones" rows="4" cols="20"><?php echo $tarea["anotaciones"]; ?></textarea>
            <br>
            <a href="tareas.php" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
            <div class="imagen">
				<label>Estado:</label>
				<select name="estado" style="width: 450px;">
					<option value="En Proceso" <?php echo "En Proceso"==$tarea["estado"]?"selected":""; ?>>En Proceso</option>
					<option value="Retenida" <?php echo "Retenida"==$tarea["estado"]?"selected":""; ?>>Retenida</option>
					<option value="Completada" <?php echo "Completada"==$tarea["estado"]?"selected":""; ?>>Completada</option>
				</select>
       		</div>
        </form>
		<script type="text/javascript">
			$("body").on("change", "input[name='action']", function(){
				var ptarea = $('#tarea').val();
				var pcheckbox = $(this).val();
				var pchecked = $(this).prop('checked');
				$.post(
					'enviarAcciones.php', {
					accion: pcheckbox, checked: pchecked, tarea: ptarea
				},
				function(data) {
					$('#actions').html(data);
				});  
			});
			$("body").on("change", "input[name='acciones[]']", function(){
				var select = "select[name='usuario"+$(this).val()+"']";
				$( select ).toggle("fast");
			});
			$('.checkbox input:checked').each(function(i, e) {
				var select = "select[name='usuario"+$(this).val()+"']";
				$( select ).toggle("fast");
			});
		</script>
    </div>
    <?php get_footer() ?>
	<div class="modal fade" id="myModal" role="dialog">
	</div>
	<script>
		$( function() {
			$('.fecha').datetimepicker({
			   dateFormat: "yy-mm-dd",
			   timeFormat: 'HH:mm:ss',
			   showSecond: true
			});
			$( ".list-actions" ).sortable({
    			connectWith: ".list-actions",
				helper : 'clone',
				receive: function (e, ui) {

					var estado = $(this).data('estado');
        			var accion = ui.item.data('id');
					var tarea = $('#tarea').val();
					
					$.ajax({
						data: "&estado=" + estado + "&tarea=" + tarea + "&accion=" + accion,
						type: 'POST',
						url: 'updateAcciones.php'
					});	

				}
			});
			$(".list-actions:not(:first)").on("click", ".openmodal", function() {
				var tarea = $('#tarea').val();
				var accion = $(this).data('id');

				$('#myModal').modal({
					show: true
				});
				$.post(
					'EditarAcciones.php', {
					accion: accion, tarea: tarea
				},
				function(data) {
					$('#myModal').html(data);
				});

			});
			
			$("#myModal").on("submit", "#modal-form", function(e) {
				
				for ( instance in CKEDITOR.instances )
       				CKEDITOR.instances[instance].updateElement();
				
				var postData = $(this).serializeArray();
				var formURL = $(this).attr("action");
				$.ajax({
					url: formURL,
					type: "POST",
					data: postData,
					success: function(data, textStatus, jqXHR) {
						$('#myModal').modal('hide');
						},
					error: function(jqXHR, status, error) {
						console.log(status + ": " + error);
					}
				});
				e.preventDefault();
			});

			$("#myModal").on('click', "#submitForm", function() {
				$("#modal-form").submit();
			});
			
		} );
	</script>
</body>
</html>