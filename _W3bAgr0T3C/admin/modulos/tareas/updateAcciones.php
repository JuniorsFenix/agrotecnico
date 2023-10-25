<?php
	require_once("include/funciones.php");

	global $db;

	if($_POST["estado"]=="Disponible"){
	
		$stmt = $db->prepare("DELETE FROM acciones_tareas WHERE idtarea=:idtarea AND idaccion=:idaccion");
		$stmt->bindValue(':idtarea', $_POST["tarea"], PDO::PARAM_INT);
		$stmt->bindValue(':idaccion', $_POST["accion"], PDO::PARAM_INT);
		$stmt->execute();
		
	}else{

		$stmt = $db->prepare("INSERT INTO acciones_tareas (idtarea, idaccion, fecha, estado) VALUES (:idtarea,:idaccion,NOW(),:estado) ON DUPLICATE KEY UPDATE fecha=NOW(),estado=:estado");
		$stmt->bindValue(':estado', $_POST["estado"], PDO::PARAM_STR);
		$stmt->bindValue(':idtarea', $_POST["tarea"], PDO::PARAM_INT);
		$stmt->bindValue(':idaccion', $_POST["accion"], PDO::PARAM_INT);
		$stmt->execute();
	}
?>