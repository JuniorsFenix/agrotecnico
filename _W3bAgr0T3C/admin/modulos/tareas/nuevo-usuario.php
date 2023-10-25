<?php
	include_once("templates/includes.php");
	$perfiles = perfilesQuery();
	$cRiesgos = cRiesgosQuery();
	$riesgos = riesgosQuery();
	$categorias = MembresiasQuery();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Nuevo usuario - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/signature-pad.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Nuevo usuario</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/guardarUsuario" enctype="multipart/form-data" id="form">
            <label>Perfil:</label>
			<select name="perfil" class="mitad">
				<?php foreach($perfiles as $row) { ?>
				<option value="<?php echo $row['id']; ?>"><?php echo $row['perfil']; ?></option>
				<?php } ?>
			</select>
			<select name="membresia" class="mitad">
				<option value="0" >Membresía</option>
				<?php foreach($categorias as $row) { ?>
				<option value="<?php echo $row['idmembresia']; ?>" ><?php echo $row['nombre']; ?></option>
				<?php } ?>
			</select>
            <label>Nombre:</label>
            <input type="text" name="nombre" maxlength="255" placeholder="Nombre" class="mitad" />
            <input type="text" name="apellido" maxlength="255" placeholder="Apellidos" class="mitad" />
            <label>Fecha de nacimiento:</label>
            <input type="text" name="dia" id="dia" placeholder="00" maxlength="2" pattern=".{2,}" />
            <select name="mes" id="mes">
            	<option value="01">Enero</option>
            	<option value="02">Febrero</option>
            	<option value="03">Marzo</option>
            	<option value="04">Abril</option>
            	<option value="05">Mayo</option>
            	<option value="06">Junio</option>
            	<option value="07">Julio</option>
            	<option value="08">Agosto</option>
            	<option value="09">Septiembre</option>
            	<option value="10">Octubre</option>
            	<option value="11">Noviembre</option>
            	<option value="12">Diciembre</option>
            </select>
            <input type="text" name="anio" id="anio" placeholder="0000" maxlength="4" pattern=".{4,}" />
            <label>Sexo:</label>
            <select name="sexo" class="mitad">
            	<option value="Otro">Otro</option>
            	<option value="Hombre">Hombre</option>
            	<option value="Mujer">Mujer</option>
            </select>
            <label>Cédula:</label>
            <input type="number" class="cedula" name="cedula" maxlength="55" class="cedula" />
            <input type="date" class="cedula" name="fecha_expedicion" />
            <input type="text" class="cedula" name="lugar_expedicion" placeholder="Lugar de expedición" />
            <span class='mensajeCedula'></span>
            <label>Correo:</label>
            <input type="text" name="correo" id="correo" maxlength="255" required /> <span class='mensajeCorreo'></span>
            <label>Teléfono:</label>
            <input type="text" name="telefono" maxlength="255" placeholder="Fijo" class="mitad" />
            <input type="text" name="celular" maxlength="255" placeholder="Celular" class="mitad" />
            <label>Ubicación:</label>
            <input type="text" name="pais" maxlength="255" placeholder="País" class="mitad" />
            <input type="text" name="ciudad" maxlength="255" placeholder="Ciudad" class="mitad" />
            <input type="text" name="direccion" maxlength="255" placeholder="Dirección" />
            <div id="laboral">
            	<h4>Laboral</h4>
				<label class="float">
					Departamento:<br>
					<input type="text" name="departamento" maxlength="255" placeholder="Departamento" />
				</label>
				<label class="float">
					Cargo:<br>
					<input type="text" name="cargo" maxlength="255" placeholder="Cargo" />
				</label>
				<label class="float">
					Tipo de contrato:<br>
					<input type="text" name="contrato" maxlength="255" placeholder="Contrato" />
				</label>
				<label class="float">
					Salario:<br>
					<input type="number" name="salario" maxlength="255" placeholder="Salario" />
				</label>
				<label class="float">
					Desde:<br>
					<input type="date" name="desde" maxlength="255" placeholder="Desde" />
				</label>
				<label class="float">
					Hasta:<br>
					<input type="date" name="hasta" maxlength="255" placeholder="Hasta" />
				</label>
				<label>Riesgos</label>
				<div class="gustos">
				<?php foreach($riesgos as $row) { ?>
					<label class="checkbox"><?php echo $row['riesgo']; ?><input name="riesgos[]" value="<?php echo $row['idriesgo']; ?>" type="checkbox" ></label>
				<?php } ?>
				</div>
				<label>Categorías</label>
				<div class="gustos">
				<?php foreach($cRiesgos as $row) { ?>
					<label class="checkbox"><?php echo $row['categoria']; ?><input name="categorias[]" value="<?php echo $row['idcategoria']; ?>" type="checkbox" ></label>
				<?php } ?>
				</div>
			</div>
            <label>Foto:</label>
            <input type="file" name="foto" /><br>
				Firma:<br>
				<div id="signature-pad" class="m-signature-pad" style="width: 50%;">
					<div class="m-signature-pad--body">
						<canvas></canvas>
					</div>
					<div class="m-signature-pad--footer">
						<div class="description">Firme arriba</div>
						<div class="left">
						<button type="button" class="button clear" data-action="clear">Borrar</button>
						</div>
					</div>
				</div><br>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/usuarios" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" data-action="save-png" />
        </form>
		<script>
            $("#correo").on("focusout", function(event) {
                var $correo = $(this).val();
                $.post(
                    '/acciones.php?accion=confirmarCorreo', {
                    correo: $correo,
                },
                function(data) {
                   if (data === 'duplicado') {
                      $('.mensajeCorreo').text('Ya existe este correo en el sistema.');
                   } else {
                      $('.mensajeCorreo').text('');
                   } 
                });
            });
            $("#cedula").on("focusout", function(event) {
                var $cedula = $(this).val();
                $.post(
                    '/acciones.php?accion=confirmarCedula', {
                    cedula: $cedula,
                },
                function(data) {
                   if (data === 'duplicado') {
                      $('.mensajeCedula').text('Ya existe esta cédula en el sistema.');
                   } else {
                      $('.mensajeCedula').text('');
                   } 
                });
            });
        </script>
    </div>
    <?php get_footer() ?>
	<script src="/<?php echo $sitioCfg["carpeta"]; ?>/js/signature_pad.js"></script>
	<script src="/<?php echo $sitioCfg["carpeta"]; ?>/js/app.js"></script>
</body>
</html>