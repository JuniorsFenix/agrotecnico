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
		<td>FECHA</td>
		<td>DOCUMENTO</td>
		<td>NOMBRES</td>
		<td>TELEFONO</td>
		<td>TIPO</td>
		<td>CLASE</td>
		<td>AREA</td>
		<td>IPS</td>
		<td>DESCRIPCION</td>
	</tr>
	<?
		include("funciones_generales.php");
		$nConexion = Conectar();
		$rs = mysqli_query($nConexion,"SELECT * FROM tblquejas order by fecha desc");
		mysqli_close($nConexion);
		while ( $reg = mysqli_fetch_object($rs) )
		{
		?>
		<tr>
			<td><? echo $reg->id; ?></td>
			<td><? echo $reg->fecha; ?></td>
			<td><? echo $reg->docid; ?></td>
			<td><? echo $reg->nombres; ?></td>
			<td><? echo $reg->telefono; ?></td>
			<td><? echo $reg->tipo; ?></td>
			<td><? echo $reg->clase; ?></td>
			<td><? echo $reg->area; ?></td>
			<td><? echo $reg->ips; ?></td>
			<td><? echo $reg->descripcion; ?></td>
		</tr>
		<?
		}
		mysqli_free_result($rs);
	?>
</table>
</body>
</html>
