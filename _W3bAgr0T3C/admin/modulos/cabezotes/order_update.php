<?php
include_once('db.php');
$db = new DB();
$idArray	= explode(",",$_POST['ids']);
$idcategoria = $_POST['categoria'];
$db->updateOrder($idArray, $idcategoria);
?>