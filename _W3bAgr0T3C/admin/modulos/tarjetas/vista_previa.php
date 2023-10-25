<?php
	require_once dirname(__FILE__)."/../../herramientas/XPM4-v.0.4/MAIL.php";
	include("../../herramientas/seguridad/seguridad.php");
	include("../../herramientas/paginar/class.paginaZ.php");
	include("../../funciones_generales.php");
	include("../../vargenerales.php");

    $nConexion    = Conectar();

    set_time_limit(0);

    $_SESSION["bol"] = $_POST["bol"];
    $_SESSION["bloques"] = $_POST["bloques"];
    $_SESSION["espera"] = $_POST["espera"];
	$_SESSION["superior"] = $_POST["superior"];
	$_SESSION["izquierdo"] = $_POST["izquierdo"];
    $_SESSION["template"] = $_POST["template"];

    $_SESSION["asunto"] = utf8_encode($_POST["asunto"]);
    
    $_SESSION["tarjeta"] = $_POST["tarjeta"];
    $_SESSION["frase"] = $_POST["frase"];
    
    
    $_SESSION["destinatarios"][]=array("nombre"=>"Nombre Apellido","mail"=>"mantpa@hotmail.com");
    
    //consulto frase
    $sql="select * from tbltarjetas where idtarjeta = {$_SESSION["tarjeta"]}";
    $rsTarjetas = mysqli_query($nConexion,$sql);
    $rxTarjeta = mysqli_fetch_assoc($rsTarjetas);
    
    //consulto frase
    $sql="select * from tblfrases where idfrase={$_SESSION["frase"]}";
    $rsFrases = mysqli_query($nConexion,$sql);
    $rxFrase = mysqli_fetch_assoc($rsFrases);

    $total = count($_SESSION["destinatarios"]);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="en" />
    <title>title</title>
</head>
<body>
<?php
//foreach($_SESSION["destinatarios"] as $r){
    
    $img = imagecreatefrompng("../../../fotos/Image/tarjetas/{$rxTarjeta["archivo"]}");
    $black = imagecolorallocate($img,0,0,0);
    imagestring($img,5,$_SESSION["izquierdo"],$_SESSION["superior"],"{$_SESSION['destinatarios'][0]['nombre']}",$black);
    
    $row=20;
    $frase = html_entity_decode($rxFrase["descripcion"]);
    $frase = str_replace("\r\n"," ",$frase);
    $frase = wordwrap( $frase , 60 , "\n" ,true);
    
    foreach( explode("\n", $frase) as $linea ){
        $linea = str_replace("\r","",$linea);
        imagestring($img,5,$_SESSION["izquierdo"],$_SESSION["superior"]+$row,"{$linea}",$black);
        $row+=12;
    }
    
    ob_start();
    imagejpeg($img,'',100);
    imagedestroy($img);
    $tmp = ob_get_contents();
    ob_end_clean();
    file_put_contents("../../../fotos/Image/tarjetas/tmp.jpg",$tmp);
	?>
	<a href="../../../fotos/Image/tarjetas/tmp.jpg" >Ampliar</a>
	<img src="../../../fotos/Image/tarjetas/tmp.jpg" alt="" width="300" height="300" hspace="0" align="center" border="0" />
	<?
    //$m->attach($tmp,"image/jpg","tarjeta.jpg");
//}
?>
</body>
</html>