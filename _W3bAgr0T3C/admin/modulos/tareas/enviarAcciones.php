<?php
  require_once("include/funciones.php");

	
	global $db;
	if($_POST["checked"]=='true'){$estado="Completada";}
	else{$estado="Pendiente";}
	$stmt = $db->prepare("UPDATE acciones_tareas SET fecha=NOW(),estado=:estado WHERE idtarea=:idtarea and idaccion=:idaccion");	
	$stmt->bindValue(':estado', $estado, PDO::PARAM_STR);
	$stmt->bindValue(':idtarea', $_POST["tarea"], PDO::PARAM_INT);
	$stmt->bindValue(':idaccion', $_POST["accion"], PDO::PARAM_INT);
	$stmt->execute();

	
	$acciones2 = accionesQuery($_POST["tarea"]);
	foreach ($acciones2 as $r): ?>
	<label class="<?php echo $r["estado"]; ?>"><?php echo $r["accion"]; ?><input name="action" value="<?php echo $r["id"]; ?>" type="checkbox" <?php echo "Completada"==$r["estado"]?"checked":""; ?>> <span><?php echo $r["estado"]; ?></span> <span><?php echo $r["fecha"]; ?></span></label>
	<?php endforeach; ?>