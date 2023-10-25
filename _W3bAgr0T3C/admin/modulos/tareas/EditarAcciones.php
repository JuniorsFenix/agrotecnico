<?php
	require_once("include/funciones.php");

	$stmt = $db->prepare("SELECT a.*, at.idusuario FROM acciones a LEFT JOIN acciones_tareas at on a.id=at.idaccion and at.idtarea=:tarea WHERE a.id=:accion");
	$stmt->bindValue(':tarea', $_POST["tarea"], PDO::PARAM_INT);
	$stmt->bindValue(':accion', $_POST["accion"], PDO::PARAM_INT);
	$stmt->execute();
	$accion = $stmt->fetch(PDO::FETCH_ASSOC);
	$usuarios = usuariosQuery();

	$mensajes = $db->query("SELECT m.*, u.nombres, u.siglas, u.color from acciones_mensajes m join tblusuarios u on m.idusuario=u.idusuario WHERE m.idtarea={$_POST["tarea"]} AND m.idaccion={$_POST["accion"]}");

?>

		<div class="modal-dialog" style="width: 70%;">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title">Editar acción</h2>
				</div>
				<div class="modal-body">
					<form id="modal-form" method="post" action="saveAcciones.php" >
						<div class="form-group">
							<input type="hidden"  name="tarea" value="<?php echo $_POST["tarea"] ?>"/>
							<input type="hidden"  name="accion" value="<?php echo $_POST["accion"] ?>"/>
							<label for="usuario">Usuario responsable</label>
							<select name="usuario" class="form-control">
								<?php foreach ($usuarios as $u): ?>
									<option value="<?php echo $u["idusuario"]; ?>" <?php echo $u["idusuario"]==$accion["idusuario"]?"selected":""; ?>><?php echo $u["nombres"]; ?></option>
								<?php endforeach; ?>
							</select>
							<br>
							<div class="mensajes">
								<h3>Mensajes</h3>
								<?php 
									setlocale (LC_TIME, "es_CO");
									foreach($mensajes as $row) {
									$date=new DateTime($row["fecha"]);
									$fecha = strftime("%B %e %Y %R %P", $date->getTimestamp());
								?>
								<div class="mensaje">
									<span class="siglas" style="background: <?php echo $row["color"]; ?>"><?php echo $row["siglas"]; ?></span>
									<strong><?php echo $row["nombres"]; ?></strong> <span class="fecha"><?php echo $fecha; ?></span>
									<p><?php echo $row["mensaje"]; ?></p>
								</div>
								<?php } ?>
							</div>
							<br>
							<label for="usuario">Escribir mensaje</label>
							<textarea name="mensaje" placeholder="Escribir mensaje"></textarea>
							<script>
								CKEDITOR.replace( 'mensaje', {
									customConfig: 'custom/ckeditor_config.js'
								});
							</script>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" id="submitForm" class="btn btn-success" >Guardar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>