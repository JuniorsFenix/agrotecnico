<?php
require_once dirname(__FILE__).("/connect.php");

function slug($str, $replace=array(), $delimiter='-') {
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}

	$clean = iconv('ISO-8859-1', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	return $clean;
}
	setlocale(LC_ALL, 'es_ES.iso88591');
    $nConexion = Conectar();

$q = mysqli_query($nConexion,"SELECT idevento,evento FROM tbleventos");

while($rax = mysqli_fetch_assoc($q)):
    $url = slug($rax["evento"]);
	$txtSQL = "UPDATE tbleventos SET url='$url' WHERE idevento=$rax[idevento]";
	mysqli_query($nConexion,$txtSQL);
	echo $url;
endwhile;


?>