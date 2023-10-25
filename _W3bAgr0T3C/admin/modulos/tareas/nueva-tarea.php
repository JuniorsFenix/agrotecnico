<?php
	include_once("templates/includes.php");
	$empresas = empresasQuery();
	$usuarios = usuariosQuery();
	$acciones = accionesQuery();
	$categorias = categoriasQuery();
	$tareas = tareasQuery();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Nueva Tarea - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="estilos/estilo.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../../herramientas/timepicker/jquery-ui-timepicker-addon.css">
	  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	  <script src="../../herramientas/timepicker/jquery-ui-timepicker-addon.js"></script>
	<style type="text/css">
		.gustos .checkbox {
			float: left;
			width: 33.3%;
		}
		.float {
			float: left;
			width: 33.3%;
			padding-right: .6%;
		}
		.gustos select{
			display: none;
		}
	</style>
</head>

<body>
	<?php include("../../system_menu.php"); ?><br>
    <div id="container-inside">
        <h1>Nueva Tarea</h1>
        <form method="post" action="tareas.php">
            <input type="hidden" name="guardar" value="1" />
            <label>Tarea:</label>
            <input type="text" name="tarea" maxlength="255" />
            <label>Prioridad:</label>
            <select name="prioridad" style="width: 450px;">
				<option value="Alta">Alta</option>
				<option value="Media" selected>Media</option>
				<option value="Baja">Baja</option>
            </select>
            <label>Empresa:</label>
            <select name="idempresa" style="width: 450px;">
                <?php foreach ($empresas as $r): ?>
                    <option value="<?php echo $r["idempresa"]; ?>"><?php echo $r["nombre"]; ?></option>
                <?php endforeach; ?>
            </select>
            <label>Responsable:</label>
            <select name="idusuario" style="width: 450px;">
                <?php foreach ($usuarios as $r): ?>
                    <option value="<?php echo $r["idusuario"]; ?>"><?php echo $r["nombres"]; ?></option>
                <?php endforeach; ?>
            </select>
            <label>Requisito:</label>
            <select name="requisito" style="width: 450px;">
                <option value="0">Ninguno</option>
                <?php foreach ($tareas as $r): ?>
                <option value="<?php echo $r["id"]; ?>"><?php echo $r["tarea"]; ?></option>
                <?php endforeach; ?>
            </select>
            <label>Categoría:</label>
            <select id="categoria" name="categoria" style="width: 450px;">
                <option value="0">Seleccionar</option>
                <?php foreach ($categorias as $r): ?>
                <option value="<?php echo $r["id"]; ?>"><?php echo $r["categoria"]; ?></option>
                <?php endforeach; ?>
            </select>
            <label>Acciones:</label>
            <div class="gustos" id="acciones">
                <?php foreach ($acciones as $r): ?>
				<label class="checkbox"><?php echo $r["accion"]; ?><input name="acciones[]" value="<?php echo $r["id"]; ?>" type="checkbox"><br>
				<select name="usuario<?php echo $r["id"]; ?>" style="width: 450px;">
					<?php foreach ($usuarios as $r): ?>
						<option value="<?php echo $r["idusuario"]; ?>"><?php echo $r["nombres"]; ?></option>
					<?php endforeach; ?>
				</select></label>
                <?php endforeach; ?>
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
				<input class="fecha" type="text" name="inicio" maxlength="255" placeholder="Inicio" />
			</label>
			<label class="float">
				Fecha de entrega:<br>
				<input class="fecha" type="text" name="entrega" maxlength="255" placeholder="Entrega" />
			</label>
            <label style="clear: both;">Enviar recordatorio <input type="text" value="1" name="recordatorio" maxlength="2" style="width: 50px" />  horas antes de la fecha de entrega</label>
            <label>Anotaciones:</label>
			<textarea name="anotaciones" rows="4" cols="20"></textarea>
            <br>
            <a href="tareas.php" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" />
        </form>
		<script type="text/javascript">
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
	<script>
		$('.fecha').datetimepicker({
		   dateFormat: "yy-mm-dd",
		   timeFormat: 'HH:mm:ss',
		   showSecond: true
		});
	</script>
</body>
</html>