<?php 
	include_once("templates/includes.php");
	$perfil = datosPerfil($_SESSION["perfil"]);
	$user = $_SESSION["id"];
	if(isset($_GET["usuario"])){
	$user = $_GET["usuario"];
	}
	$usuario = datosUsuario($user);
	$historial = historialQuery($user,3);
	$perfiles = perfilesQuery();
	$categorias = MembresiasQuery();
	$categoriasGustos = categoriasGustosQuery();
	$nacimiento = explode("-",$usuario['nacimiento']);
	$check=check($user);
	$checkRiesgos=checkRiesgos($user);
	$checkRiesgosC=checkRiesgosC($user);
	$cRiesgos = cRiesgosQuery();
	$riesgos = riesgosQuery();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title>Editar usuario - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/signature-pad.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
		function confirmar() {
		var password = $("#password").val();
		var confirmPassword = $("#confirm_password").val();
	
		if (password != confirmPassword)
        $("#message").html("Las contraseñas no coinciden");
    else
        $("#message").html("");
	}
	
	$(document).ready(function () {
   		$("#confirm_password").keyup(confirmar);
	});
	</script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Editar usuario</h1>
        <form method="post" action="/<?php echo $sitioCfg["carpeta"]; ?>/actualizarUsuario" enctype="multipart/form-data" id="form">
            <input type="hidden" name="idusuario" value="<?php echo $user ?>">
            <label>Perfil:</label>
			<select name="perfil" class="mitad">
				<?php foreach($perfiles as $row) { ?>
				<option value="<?php echo $row['id']; ?>" <?=$usuario["id_perfil"]==$row['id']?"selected":"";?> ><?php echo $row['perfil']; ?></option>
				<?php } ?>
			</select>
			<select name="membresia" class="mitad">
				<option value="0" <?=$usuario["idmembresia"]==0?"selected":"";?> >Membresía</option>
				<?php foreach($categorias as $row) { ?>
				<option value="<?php echo $row['idmembresia']; ?>" <?=$usuario["idmembresia"]==$row['idmembresia']?"selected":"";?> ><?php echo $row['nombre']; ?></option>
				<?php } ?>
			</select>
            <label>Nombre:</label>
            <input type="text" name="nombre" maxlength="255" placeholder="Nombre" class="mitad" value="<?php echo $usuario['nombre']; ?>" />
            <input type="text" name="apellido" maxlength="255" placeholder="Apellidos" class="mitad" value="<?php echo $usuario['apellido']; ?>" />
            <label>Fecha de nacimiento:</label>
            <input type="text" name="dia" id="dia" placeholder="00" maxlength="2" pattern=".{2,}" value="<?php echo $nacimiento[2]; ?>" />
            <select name="mes" id="mes">
            	<option value="01" <?=$nacimiento[1]==01?"selected":"";?> >Enero</option>
            	<option value="02" <?=$nacimiento[1]==02?"selected":"";?> >Febrero</option>
            	<option value="03" <?=$nacimiento[1]==03?"selected":"";?> >Marzo</option>
            	<option value="04" <?=$nacimiento[1]==04?"selected":"";?> >Abril</option>
            	<option value="05" <?=$nacimiento[1]==05?"selected":"";?> >Mayo</option>
            	<option value="06" <?=$nacimiento[1]==06?"selected":"";?> >Junio</option>
            	<option value="07" <?=$nacimiento[1]==07?"selected":"";?> >Julio</option>
            	<option value="08" <?=$nacimiento[1]==08?"selected":"";?> >Agosto</option>
            	<option value="09" <?=$nacimiento[1]==09?"selected":"";?> >Septiembre</option>
            	<option value="10" <?=$nacimiento[1]==10?"selected":"";?> >Octubre</option>
            	<option value="11" <?=$nacimiento[1]==11?"selected":"";?> >Noviembre</option>
            	<option value="12" <?=$nacimiento[1]==12?"selected":"";?> >Diciembre</option>
            </select>
            <input type="text" name="anio" id="anio" placeholder="0000" maxlength="4" pattern=".{4,}" value="<?php echo $nacimiento[0]; ?>" />
            <label>Ciudad de nacimiento:</label>
            <input type="text" name="ciudad_nacimiento" maxlength="255" placeholder="Ciudad de nacimiento" value="<?php echo $usuario['ciudad_nacimiento']; ?>" />
            <label>Sexo:</label>
            <select name="sexo">
            	<option value="Otro" <?=$usuario["sexo"]=="Otro"?"selected":"";?> >Otro</option>
            	<option value="Hombre" <?=$usuario["sexo"]=="Hombre"?"selected":"";?> >Hombre</option>
            	<option value="Mujer" <?=$usuario["sexo"]=="Mujer"?"selected":"";?> >Mujer</option>
            </select>
            <label>Estado civil:</label>
            <select name="estado_civil">
            	<option value="Soltero(a)" <?=$usuario["estado_civil"]=="Soltero(a)"?"selected":"";?> >Soltero(a)</option>
            	<option value="Casado(a)" <?=$usuario["estado_civil"]=="Casado(a)"?"selected":"";?> >Casado(a)</option>
            	<option value="Viudo(a)" <?=$usuario["estado_civil"]=="Viudo(a)"?"selected":"";?> >Viudo(a)</option>
            	<option value="Unión libre" <?=$usuario["estado_civil"]=="Unión libre"?"selected":"";?> >Unión libre</option>
            </select>
            <label>Cédula:</label>
            <input type="number" class="cedula" name="cedula" maxlength="55" value="<?php echo $usuario['cedula']; ?>" class="cedula" />
            <input type="date" class="cedula" name="fecha_expedicion" value="<?php echo $usuario['fecha_expedicion']; ?>" />
            <input type="text" class="cedula" name="lugar_expedicion" placeholder="Lugar de expedición" value="<?php echo $usuario['lugar_expedicion']; ?>" />
            <label>Correo:</label>
            <input type="email" name="correo" maxlength="255" required value="<?php echo $usuario['correo']; ?>" />
            <label>Cambiar contraseña:</label>
            <input type="password" name="password" id="password" maxlength="255" placeholder="Nueva contraseña" class="mitad" />
            <input type="password" name="confirm_password" id="confirm_password" maxlength="255" placeholder="Confirmar contraseña" class="mitad" /> <span id='message'></span>
            <label>Teléfono:</label>
            <input type="text" name="telefono" maxlength="255" placeholder="Fijo" class="mitad" value="<?php echo $usuario['telefono']; ?>" />
            <input type="text" name="celular" maxlength="255" placeholder="Celular" class="mitad" value="<?php echo $usuario['celular']; ?>" />
            <label>Ubicación:</label>
            <input type="text" name="pais" maxlength="255" placeholder="País" class="mitad" value="<?php echo $usuario['pais']; ?>" />
            <input type="text" name="ciudad" maxlength="255" placeholder="Ciudad" class="mitad" value="<?php echo $usuario['ciudad']; ?>" />
            <input type="text" name="direccion" maxlength="255" placeholder="Dirección" value="<?php echo $usuario['direccion']; ?>" />
            <label>EPS:</label>
            <input type="text" name="eps" maxlength="255" placeholder="EPS" value="<?php echo $usuario['eps']; ?>" />
            <label>Fondo de pensiones:</label>
            <input type="text" name="pensiones" maxlength="255" placeholder="Fondo de pensiones" value="<?php echo $usuario['pensiones']; ?>" />
            <label>Caja de compensación:</label>
            <input type="text" name="compensacion" maxlength="255" placeholder="Caja de compensación" value="<?php echo $usuario['compensacion']; ?>" />
            <label>Cónyugue:</label>
            <input type="text" name="conyugue" maxlength="255" placeholder="Cónyugue" value="<?php echo $usuario['conyugue']; ?>" />
            <label>Ocupación del cónyugue:</label>
            <input type="text" name="ocupacion_conyugue" maxlength="255" placeholder="Ocupación del cónyugue" value="<?php echo $usuario['ocupacion_conyugue']; ?>" />
            <label>Fecha de nacimiento del cónyugue:</label>
			<input type="date" name="nacimiento_conyugue" maxlength="255" placeholder="Fecha de nacimiento" value="<?php echo $usuario['nacimiento_conyugue']; ?>" />
            <div id="laboral">
            	<h4>Laboral</h4>
				<label class="float">
					Departamento:<br>
					<input type="text" name="departamento" maxlength="255" placeholder="Departamento" value="<?php echo $usuario['departamento']; ?>" />
				</label>
				<label class="float">
					Cargo:<br>
					<input type="text" name="cargo" maxlength="255" placeholder="Cargo" value="<?php echo $usuario['cargo']; ?>" />
				</label>
				<label class="float">
					Tipo de contrato:<br>
					<input type="text" name="contrato" maxlength="255" placeholder="Contrato" value="<?php echo $usuario['contrato']; ?>" />
				</label>
				<label class="float">
					Salario:<br>
					<input type="number" name="salario" maxlength="255" placeholder="Salario" value="<?php echo $usuario['salario']; ?>" />
				</label>
				<label class="float">
					Desde:<br>
					<input type="date" name="desde" maxlength="255" placeholder="Desde" value="<?php echo $usuario['desde']; ?>" />
				</label>
				<label class="float">
					Hasta:<br>
					<input type="date" name="hasta" maxlength="255" placeholder="Hasta" value="<?php echo $usuario['hasta']; ?>" />
				</label>
				<label>Riesgos</label>
				<div class="gustos">
				<?php foreach($riesgos as $row) { ?>
					<label class="checkbox"><?php echo $row['riesgo']; ?><input name="riesgos[]" value="<?php echo $row['idriesgo']; ?>" type="checkbox" <?=in_array($row['idriesgo'],$checkRiesgos)?"checked":"";?> ></label>
				<?php } ?>
				</div>
				<label>Categorías</label>
				<div class="gustos">
				<?php foreach($cRiesgos as $row) { ?>
					<label class="checkbox"><?php echo $row['categoria']; ?><input name="categorias[]" value="<?php echo $row['idcategoria']; ?>" type="checkbox" <?=in_array($row['idcategoria'],$checkRiesgosC)?"checked":"";?> ></label>
				<?php } ?>
				</div>
            	<a href="/<?php echo $sitioCfg["carpeta"]; ?>/reingresos/<?php echo $user ?>" class="cancelar" />Ver Reingresos</a>
			    <a href="/<?php echo $sitioCfg["carpeta"]; ?>/salarios/<?php echo $user ?>" class="action-button">Ver Salarios</a>
			</div>
			<?php foreach($categoriasGustos as $row) { 
				$gustos = gustosQuery($row["id"]);?>
				<label><?php echo $row["texto"] ?></label>
				<div class="gustos">
				<?php foreach($gustos as $row) { ?>
					<label class="checkbox mitad"><?php echo $row['nombre']; ?><input name="gustos[]" value="<?php echo $row['id']; ?>" type="checkbox" <?=in_array($row['id'],$check)?"checked":"";?> ></label>
				<?php } ?>
				</div>
            <?php } ?>
            <label>¿Qué hace en su tiempo libre?</label>
            <textarea name="tiempo_libre" rows="4" cols="20"><?php echo $usuario['tiempo_libre']; ?></textarea>
            <label>¿Qué es lo más perezoso que ha hecho en su vida?</label>
            <textarea name="pereza" rows="4" cols="20"><?php echo $usuario['pereza']; ?></textarea>
            <label>¿Qué te gusta que te regalen?</label>
            <textarea name="regalos" rows="4" cols="20"><?php echo $usuario['regalos']; ?></textarea><br>
            <div class="imagen">
                <label>Imagen actual:</label>
                <?php if($usuario["foto"]!=""){ ?>
                <img src="<?php echo "/$sitioCfg[carpeta]/fotos/perfiles/$usuario[foto]"; ?>"/>
                <?php } else { ?>
                <img src="<?php echo "/$sitioCfg[carpeta]/fotos/perfiles/$usuario[sexo].png"; ?>"/>
                <?php } ?>
                <label>Cambiar foto:</label>
                <input type="file" name="foto" />
                <div>
			   <?php if($perfil["historial"]==1){ ?>
                    <h3>Historial médico</h3>
					<?php foreach($historial as $row) { ?>
                    <div class="historial">
						<strong>Fecha: </strong><?php echo $row['fecha']; ?><br>
						<p><?php echo strip_tags(substr($row["descripcion"],0,180))."..."; ?></p>
                    </div>
					<?php
                    }
                        echo "<a href='/$sitioCfg[carpeta]/historial-medico/$user'>Ver todo el historial</a>";
				} ?>
				</div><br>
                <label>Firma actual:</label>
                <?php if($usuario["firma"]!=""){ ?>
                <img src="<?php echo "/$sitioCfg[carpeta]/fotos/perfiles/$usuario[firma]"; ?>"/>
                <?php } else { echo "No se ha asignado una firma.";} ?>
				Firma:<br>
				<div id="signature-pad" class="m-signature-pad">
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
            	<a href="/<?php echo $sitioCfg["carpeta"]; ?>/certificado/<?php echo $user ?>" class="cancelar" />Generar certificado laboral</a>
            	<a href="/<?php echo $sitioCfg["carpeta"]; ?>/certificados/<?php echo $user ?>" class="action-button" />Ver certificados</a>
            </div>
            <a href="/<?php echo $sitioCfg["carpeta"]; ?>/usuarios" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Guardar" title="Guardar" data-action="save-png" />
        </form>
    </div>
    <?php get_footer() ?>
	<script src="/<?php echo $sitioCfg["carpeta"]; ?>/js/signature_pad.js"></script>
	<script src="/<?php echo $sitioCfg["carpeta"]; ?>/js/app.js"></script>
</body>
</html>