<?
include("funciones_public.php");
$nConexion		= Conectar();
$IdBanner		= $_GET["id"];
$rs_Banner	= mysqli_query($nConexion,"SELECT * FROM tblimagenes_banners WHERE (idbanner = '$IdBanner')");
$reg_Banner	= mysqli_fetch_object($rs_Banner);
$nContador	= $reg_Banner->click + 1;
$cDirWeb		= $reg_Banner->url;
mysqli_query($nConexion,"UPDATE tblimagenes_banners SET click = $nContador WHERE idbanner = $IdBanner");
mysqli_close($nConexion);
mysqli_free_result($rs_Banner);
echo "<script language=\"javascript\">location.href='$cDirWeb'</script>";
?>

