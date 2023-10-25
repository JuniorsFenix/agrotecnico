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
		<td>APELLIDOS</td>
		<td>MAIL</td>
		<td>NACIMIENTO</td>
		<td>PROFESION</td>
		<td>SEXO</td>
		<td>CIUDAD</td>
		<td>BARRIO</td>
		<td>COMENTARIOS</td>
	</tr>
	<?
		include("../../funciones_generales.php");
		$nConexion = Conectar();
		$rs = mysqli_query($nConexion,"SELECT * FROM tbl_datos ORDER BY iddatos DESC");
		mysqli_close($nConexion);
		while ( $reg = mysqli_fetch_object($rs) )
		{
		?>
		<tr>
			<td><? echo $reg->iddatos; ?></td>
			<td><? echo $reg->nombres; ?></td>
			<td><? echo $reg->apellidos; ?></td>
			<td><? echo $reg->mail; ?></td>
			<td><? echo $reg->nacimiento; ?></td>
			<td><? echo $reg->profesion; ?></td>
			<td><? echo $reg->sexo; ?></td>
			<td><? echo $reg->ciudad; ?></td>
			<td><? echo $reg->barrio; ?></td>
			<td><? echo $reg->comentarios; ?></td>
		</tr>
		<?
		}
		mysqli_free_result($rs);
	?>
</table>
</body>
</html>
