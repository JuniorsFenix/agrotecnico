<?
	include("../../funciones_generales.php");
	include("../../vargenerales.php");
	$nConexion    = Conectar();
	$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblbanners WHERE idbanner = " . $_GET["id"] ) ;
	mysqli_close( $nConexion ) ;
	$Registro     = mysqli_fetch_object( $Resultado );
	$Banner = $Registro->banner;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Banners</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<center>
<?
	if ( empty($Registro->banner) )
	{
		echo "No se asigno un banner.";
	}
	else
	{
		if ( $Registro->tipo == "I" )
		{
			?><img src="<? echo $cRutaVerBanners . $Registro->banner; ?>"><?
		}
		else
		{
			$Tam_Archivo = getimagesize($cRutaVerBanners . $Registro->banner);
			?>
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" <? echo $Tam_Archivo[3]; ?>>
				<param name="movie" value="<? echo $cRutaVerBanners . $Registro->banner; ?>">
				<param name="quality" value="high">
				<embed src="<? echo $cRutaVerBanners . $Registro->banner; ?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" <? echo $Tam_Archivo[3]; ?>></embed>
			</object>
			<?
		}
	}
?>
</center>
</body>
</html>
