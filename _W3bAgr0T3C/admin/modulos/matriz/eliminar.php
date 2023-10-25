<?php
require_once("../../funciones_generales.php");
include("../../vargenerales.php");
if ( array_key_exists ('file', $_POST ) ) {
$imagen=$_POST['file'];
$nConexion = Conectar();
$ruta= $cRutaImagenTienda . $imagen;
/*if ( file_exists ( $ruta ) ) {
   unlink( $ruta );
   unlink( $cRutaImagenTienda."m_".$imagen );
   unlink( $cRutaImagenTienda."p_".$imagen );
}*/
	$sql=mysqli_query($nConexion,"delete from imagenes_matriz where imagen='$imagen'");
}
?>