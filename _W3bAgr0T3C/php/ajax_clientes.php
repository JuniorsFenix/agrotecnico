<?php
	require_once("../include/connect.php");
	$nConexion = Conectar();

	$sql="SELECT *, iddepartamento AS departamento, idciudad AS ciudadDpt, departamento AS strdepartamento, ciudad AS strciudad FROM tblti_cotizaciones_clientes WHERE id={$_POST["id"]}";
	$result = mysqli_query($nConexion,$sql); 
	
	$data = mysqli_fetch_assoc($result);
	echo json_encode($data);
?>