<?php
include_once('db.php');
$db = new DB();
$idArray	= explode(",",$_POST['ids']);
$tabla = 'tblti_categorias';
$db->updateOrderCat($idArray, $tabla);
echo mysqli_error($nConexion);
?>