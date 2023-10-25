<?php
	require_once("include/funciones.php");

	global $db;

	$stmt = $db->prepare("UPDATE acciones_tareas SET idusuario=:usuario WHERE idtarea=:idtarea and idaccion=:idaccion");
	$stmt->bindValue(':usuario', $_POST["usuario"], PDO::PARAM_INT);
	$stmt->bindValue(':idtarea', $_POST["tarea"], PDO::PARAM_INT);
	$stmt->bindValue(':idaccion', $_POST["accion"], PDO::PARAM_INT);
	$stmt->execute();

if(!empty($_POST["mensaje"])){

	date_default_timezone_set('America/Bogota');
	$stmt = $db->prepare("INSERT INTO acciones_mensajes(idtarea, idaccion, idusuario, mensaje, fecha) VALUES(:idtarea, :idaccion, :idusuario, :mensaje, :fecha)");
	$stmt->bindValue(':idtarea', $_POST["tarea"], PDO::PARAM_INT);
	$stmt->bindValue(':idaccion', $_POST["accion"], PDO::PARAM_INT);
	$stmt->bindValue(':idusuario', $_SESSION["IdUser"], PDO::PARAM_INT);
	$stmt->bindValue(':mensaje', $_POST["mensaje"], PDO::PARAM_STR);
	$stmt->bindValue(':fecha', date('Y-m-d H:i:s'), PDO::PARAM_STR);
	$stmt->execute();
}
?>