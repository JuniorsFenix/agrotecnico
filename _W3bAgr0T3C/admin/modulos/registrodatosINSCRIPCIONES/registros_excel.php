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
		<td>EPM</td>
		<td>HERMANOS</td>
		<td>NUEVO</td>
		<td>NOMBRE NI�O</td>
		<td>APELLIDOS NI�O</td>
		<td>NACIMIENTO</td>
		<td>EDAD</td>
		<td>TALLA</td>
		<td>EPS</td>
		<td>E-MAIL NI�O</td>
		<td>DIRECCI�N CASA</td>
		<td>BARRIO</td>
		<td>TEL�FONO</td>
		<td>DIRECCI�N OPCIONAL</td>
		<td>BARRIO OPCIONAL</td>
		<td>TEL�FONO OPCIONAL</td>
		<td>NOMBRE PADRE</td>
		<td>APELLIDO</td>
		<td>C�DULA</td>
		<td>E-MAIL</td>
		<td>EMPRESA</td>
		<td>CARGO</td>
		<td>TEL�FONO</td>
		<td>TEL�FONO CASA</td>
		<td>CELULAR</td>
		<td>NOMBRE MADRE</td>
		<td>APELLIDO</td>
		<td>C�DULA</td>
		<td>E-MAIL</td>
		<td>EMPRESA</td>
		<td>CARGO</td>
		<td>TEL�FONO</td>
		<td>TEL�FONO CASA</td>
		<td>CELULAR</td>
		<td>�POR QU� MEDIO SE ENTERO?</td>
		<td>OBSERVACIONES</td>
	</tr>
	<?
		include("../../funciones_generales.php");
		$nConexion = Conectar();
		$rs = mysqli_query($nConexion,"SELECT * FROM tbl_datos_incripciones ORDER BY iddatos_inscripciones DESC");
		mysqli_close($nConexion);
		while ( $reg = mysqli_fetch_object($rs) )
		{
		?>
		<tr>
			<td><? echo $reg->epm; ?></td>
			<td><? echo $reg->hermanos; ?></td>
			<td><? echo $reg->nuevo; ?></td>
			<td><? echo $reg->nombreN; ?></td>
			<td><? echo $reg->ApellidoN; ?></td>
			<td><? echo $reg->nacimiento; ?></td>
			<td><? echo $reg->edad; ?></td>
			<td><? echo $reg->talla; ?></td>
			<td><? echo $reg->eps; ?></td>
			<td><? echo $reg->mailN; ?></td>
			<td><? echo $reg->DireccionCasaN; ?></td>
			<td><? echo $reg->barrioN; ?></td>
			<td><? echo $reg->telefonoN; ?></td>
			<td><? echo $reg->direccionNO; ?></td>
			<td><? echo $reg->barrioNO; ?></td>
			<td><? echo $reg->telefonoNO; ?></td>
			<td><? echo $reg->nombrePadre; ?></td>
			<td><? echo $reg->apellidoPadre; ?></td>
			<td><? echo $reg->cedulaPadre; ?></td>
			<td><? echo $reg->emailPadre; ?></td>
			<td><? echo $reg->empresaPadre; ?></td>
			<td><? echo $reg->cargoPadre; ?></td>
			<td><? echo $reg->telefonoPadre; ?></td>
			<td><? echo $reg->telefonoCasaPadre; ?></td>
			<td><? echo $reg->celularPadre; ?></td>
			<td><? echo $reg->nombreMadre; ?></td>
			<td><? echo $reg->apellidoMadre; ?></td>
			<td><? echo $reg->cedulaMadre; ?></td>
			<td><? echo $reg->emailMadre; ?></td>
			<td><? echo $reg->empresaMadre; ?></td>
			<td><? echo $reg->cargoMadre; ?></td>
			<td><? echo $reg->telefonoMadre; ?></td>
			<td><? echo $reg->telefonoCasaMadre; ?></td>
			<td><? echo $reg->celularMadre; ?></td>
			<td><? echo $reg->comoEntero; ?></td>
			<td><? echo $reg->observaciones; ?></td>
		</tr>
		<?
		}
		mysqli_free_result($rs);
	?>
</table>
</body>
</html>
