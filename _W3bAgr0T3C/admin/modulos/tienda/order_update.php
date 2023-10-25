<?php
include_once('db.php');
$db = new DB();
$idArray	= explode(",",$_POST['ids']);
$categoria = $_POST['categoria'];
$db->updateOrder($idArray, $categoria);
?>