<?
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=excel.xls"); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<table cellpadding="0" cellspacing="0" border="1">
	<tr>
		<td>ID</td>
		<td>NOMBRES</td>
		<td>MAIL</td>
		<td>CONFIRMADO</td>
	</tr>
	<?
		include("../../funciones_generales.php");
		$nConexion = Conectar();
		$rs = mysqli_query($nConexion,"SELECT * FROM tblregistros ORDER BY idregistro DESC");
		mysqli_close($nConexion);
		while ( $reg = mysqli_fetch_object($rs) )
		{
		?>
		<tr>
			<td><? echo $reg->idregistro; ?></td>
			<td><? echo $reg->nombres; ?></td>
			<td><? echo $reg->email; ?></td>
			<td><? echo $reg->confirmado; ?></td>
		</tr>
		<?
		}
		mysqli_free_result($rs);
	?>
</table>
</body>
</html>
