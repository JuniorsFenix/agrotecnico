<?php require_once dirname(__FILE__).("/../../admin/funciones_generales.php");

	session_start();
	$sessionID = $_COOKIE['PHPSESSID'];
  	$nConexion    = Conectar();
	$result=mysqli_query($nConexion,"SELECT SUM(cantidad) AS total from tblti_baskets WHERE basketSession='$sessionID'");

	$row = mysqli_fetch_object( $result );

	echo $row->total;
?>