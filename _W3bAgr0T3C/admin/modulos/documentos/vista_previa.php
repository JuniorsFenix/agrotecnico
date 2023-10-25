<?php
	require_once dirname(__FILE__)."/../../herramientas/XPM4-v.0.4/MAIL.php";
	include("../../herramientas/seguridad/seguridad.php");
	include("../../herramientas/paginar/class.paginaZ.php");
	include("../../funciones_generales.php");
	include("../../vargenerales.php");

    $nConexion    = Conectar();

    set_time_limit(0);

    $_SESSION["bol"] = $_POST["bol"];
    $_SESSION["correo"] = $_POST["correo"];
    $_SESSION["nombre"] = $_POST["nombre"];
    $_SESSION["mensaje"] = $_POST["mensaje"];

    $_SESSION["asunto"] = utf8_encode($_POST["asunto"]);
    
    $_SESSION["plantilla"] = $_POST["plantilla"];
    $_SESSION["documento"] = $_POST["documento"];
    
    
    $_SESSION["destinatarios"][]=array("nombre"=>"Nombre Apellido","mail"=>"mantpa@hotmail.com");
    
    //consulto plantilla
    $sql="select * from tblplantillas where idplantilla = {$_SESSION["plantilla"]}";
    $rsPlantillas = mysqli_query($nConexion,$sql);
    $rxPlantilla = mysqli_fetch_assoc($rsPlantillas);
    
    //consulto frase
    $sql="select * from tbldocumentos where idcontenido={$_SESSION["documento"]}";
    $rsDocumentos = mysqli_query($nConexion,$sql);
    $rxDocumento = mysqli_fetch_assoc($rsDocumentos);

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
<form action="preview.php" method="post" target="POPUPW"
    onsubmit="POPUPW = window.open('about:blank','POPUPW',
   'scrollbars=yes,width=845,height=800');">
<?php 
	ob_start(); 
?>
<page>
<div id="container" style=" background:url(<?=$cRutaPlantillas . $rxPlantilla["archivo"];?>) no-repeat; width: 816px; height: 1056px;">
    <div id="contenido" style=" padding:80px 40px 40px 40px;">
    	<? echo run_php2(stripslashes($rxDocumento["descripcion"]));?>
    </div>
</div>
</page>
<?php $_SESSION['preview'] = ob_get_contents(); ?>
<button type="submit">Previsualizar</button>
</form>
</body>
</html>