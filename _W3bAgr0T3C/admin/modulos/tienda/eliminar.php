<?php
require_once("../../funciones_generales.php");
include("../../vargenerales.php");
if ( array_key_exists ('file', $_POST ) ) {
$imagen=$_POST['file'];
$ruta= $cRutaImagenTienda . $imagen;
if ( file_exists ( $ruta ) ) {
   unlink( $ruta );
   unlink( $cRutaImagenTienda."m_".$imagen );
   unlink( $cRutaImagenTienda."p_".$imagen );
	$nConexion = Conectar();
	$sql=mysqli_query($nConexion,"delete from tblti_imagenes where imagen='$imagen'");
}
}
?>