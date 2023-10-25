<?php
include_once('db.php');
$db = new DB();
$idArray	= explode(",",$_POST['ids']);
$db->updateOrderMarcas($idArray);
?>