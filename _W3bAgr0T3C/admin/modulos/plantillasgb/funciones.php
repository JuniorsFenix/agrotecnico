<?
include("../../../funciones_generales.php");
function Encabezado( $Boletin ){
	$nConexion    = Conectar();
	$rs = mysqli_query($nConexion, "SELECT encabezado FROM tblboletines WHERE idboletin = $Boletin"  );
	mysqli_close( $nConexion );
	$reg = mysqli_fetch_object($rs);
	echo $reg->encabezado;
	mysqli_free_result( $rs );
}

function Bloques( $Boletin ){
	$nConexion    = Conectar();
	$rs = mysqli_query($nConexion, "SELECT * FROM tblboletines_blo WHERE idboletin = $Boletin ORDER BY orden ASC"  );
	mysqli_close( $nConexion );
	return $rs;
}

function PiePagina( $Boletin ){
	$nConexion    = Conectar();
	$rs = mysqli_query($nConexion, "SELECT piepagina FROM tblboletines WHERE idboletin = $Boletin"  );
	mysqli_close( $nConexion );
	$reg = mysqli_fetch_object($rs);
	echo $reg->piepagina;
	mysqli_free_result( $rs );
}


?>