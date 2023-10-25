<?php
include_once('db.php');
$db = new DB();
$idArray	= explode(",",$_POST['ids']);
$tabla = $_POST['tabla'];
$db->updateOrder($idArray, $tabla);
?>