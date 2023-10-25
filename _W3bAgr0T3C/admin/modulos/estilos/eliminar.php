<?php
require_once("../../funciones_generales.php");
include("../../vargenerales.php");
if ( array_key_exists ('file', $_POST ) ) {
$imagen=$_POST['file'];
$ruta= $cRutaEstilos . $imagen;
if ( file_exists ( $ruta ) ) {
   unlink( $ruta );
	$nConexion = Conectar();
	$sql=mysqli_query($nConexion,"delete from tblimagenes_estilos where imagen='$imagen'");
}
}
?>