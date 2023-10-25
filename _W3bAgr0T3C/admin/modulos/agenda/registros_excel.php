<?
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=agenda.xls");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<table cellpadding="0" cellspacing="0" border="1">
	<tr>
		<td>Id</td>
		<td>Salon</td>
                <td>Fecha</td>
                <td>IdHorario</td>
		<td>Descripcion</td>
		<td>HoraInicio</td>
		<td>HoraFin</td>
		<td>Grupo</td>
		<td>Nombre</td>
	</tr>
	<?
		include("../../funciones_generales.php");
		$nConexion = Conectar();
		
		$sql = "select
					a.idreservaciones,
					a.idsalon,
					a.fecha,
					a.idhorario,
					a.carro,
					b.descripcion,
					b.hora_inicio,
					b.hora_fin,
					b.grupo,
					case when b.grupo<>3 then a.nombre else 'MANTENIMIENTO' end as nombre
				from tblreservaciones a
					join tblreservacioneshorarios b on (a.idhorario=b.idhorario)
				order by a.fecha desc";
		
		$rs = mysqli_query($nConexion,$sql);
		mysqli_close($nConexion);
		while ( $reg = mysqli_fetch_object($rs) )
		{
		?>
		<tr>
			<td><? echo $reg->idreservaciones; ?></td>
			<td><? echo $reg->idsalon; ?></td>
			<td><? echo $reg->fecha; ?></td>
			<td><? echo $reg->idhorario; ?></td>
			<td><? echo $reg->descripcion; ?></td>
			<td><? echo $reg->hora_inicio; ?></td>
			<td><? echo $reg->hora_fin; ?></td>
			<td><? echo $reg->grupo; ?></td>
			<td><? echo $reg->nombre; ?></td>
		</tr>
		<?
		}
		mysqli_free_result($rs);
	?>
</table>
</body>
</html>
