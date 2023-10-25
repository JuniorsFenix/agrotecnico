<?
include("../../../vargenerales.php");
include( "../funciones.php");
$Boletin = $_GET["bol"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td><?=Encabezado($Boletin);?></td>
	</tr>
	<tr>
		<td><?=Bloques($Boletin);?></td>
	</tr>
	<tr>
		<td><?=PiePagina($Boletin);?></td>
	</tr>
</table>
</body>
</html>
