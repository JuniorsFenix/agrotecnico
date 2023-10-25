<?php
require_once("../../funciones_generales.php");
include("../../vargenerales.php");
if ( array_key_exists ('file', $_POST ) ) {
$imagen=$_POST['file'];
$ruta= $cRutaImagenTienda . $imagen;
if ( file_exists ( $ruta ) ) {
   unlink( $ruta );
	$nConexion = Conectar();
	$sql=mysqli_query($nConexion,"delete from tblti_cat_imagenes where imagen='$imagen'");
}
}
?>