<?php
  require_once("herramientas/seguridad/seguridad.php");
	require_once("funciones_generales.php");
	$sitioCfg = sitioAssoc2();
	$home = $sitioCfg["url"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="<?php echo $home; ?>/sadminc/css/administrador.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td bgcolor="#DFDFDF">
			<table align="left" bgcolor="#DFDFDF">
				<tr>
					<td>
						<b class="fecha">
							<?php
								$NomPerfil = "";
								if ( $_SESSION["UsrPerfil"] == "1" )
								{
									$NomPerfil = "Super Administrador";
								}
								if ( $_SESSION["UsrPerfil"] == "2" )
								{
									$NomPerfil = "Administrador";
								}
								if ( $_SESSION["UsrPerfil"] == "3" )
								{
									$NomPerfil = "Publicador";
								}
								if ( $_SESSION["UsrPerfil"] == "4" )
								{
									$NomPerfil = "Editor";
								}
								if ( $_SESSION["UsrPerfil"] == "5" )
								{
									$NomPerfil = "General";
								}
								echo "Bienvenido: " . $_SESSION["UsrNombre"] . " | Tu perfil es: " . $NomPerfil ;
							?>
						</b>
					</td>
					
				</tr>
			</table>
		</td>
		<td bgcolor="#DFDFDF">
			<table align="right" bgcolor="#DFDFDF">
				<tr>
					<td><a href="mailto:soporte@clickee.com" class="botonesBloque"><img src="image/iconoCorreo.gif" border="0" width="10" height="7" align="absmiddle" alt="Soporte"></a></td>
					<td><a href="mailto:soporte@clickee.com" class="botonesBloque">Soporte&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
					<td><a href="http://www.tutoriales.estilod.com" target="_blank" class="botonesBloque"><img src="image/iconoAyuda.gif" border="0" width="11" height="11" align="absmiddle" alt="Ayuda"></a></td>
					<td><a href="http://www.tutoriales.estilod.com" target="_blank" class="botonesBloque">Ayuda&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
					<td><a href="logout.php" class="botonesBloque"><img src="image/iconoSesion.gif" border="0" width="18" height="10" align="absmiddle" alt="Cerrar Sesi&oacute;n"></a></td>
					<td><a href="logout.php" class="botonesBloque">cerrar sesi&oacute;n</a></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="tablaPrincipal">
			<table border="0" width="100%" bgcolor="#090909">
				<tr>
					<td class="cabecera" style="width: 80%;">
						<img src="<?php echo $home; ?>/sadminc/image/cabezote2.jpg" style="max-width:100%;max-height:126px">
					</td>
					<td align="left" style="width: 20%;">
						<form name="frmCiudad" id="frmCiudad" method="post" action="actciudades.php" style="margin-top:0px;padding-top:0px">
						<table border="0" cellpadding="2" cellspacing="0">
							<tr>
								<td><span style="color:#FFF; font-weight:bold">Idioma:</span></td>
						  <td>
									<?php
									$nConexion 	= Conectar();
									$rsCiudades	= mysqli_query($nConexion,"SELECT * FROM tblciudades WHERE publicar = 'S' ORDER BY ciudad");
									mysqli_close($nConexion);
									//$regCiudades = mysqli_fetch_object($rsCiudades);
									//$NomCiudad = $regCiudades->ciudad;
									$IdCiudad  = $_SESSION["IdCiudad"];
									echo "<select name=\"cboCiudad\" id=\"cboCiudad\">";
									while ( $regCiudades = mysqli_fetch_object( $rsCiudades ) ){
										if ( $regCiudades->idciudad == $IdCiudad ){
											echo "<option selected value=\"$regCiudades->idciudad\"\n>$regCiudades->idciudad&nbsp;-&nbsp;$regCiudades->ciudad</option>";
										}
										else{
											echo "<option value=\"$regCiudades->idciudad\"\n>$regCiudades->idciudad&nbsp;-&nbsp;$regCiudades->ciudad</option>";
										}
									}
									echo "</select>";
									
									
									mysqli_free_result($rsCiudades);
									?>
								</td>
								<td><input type="submit" name="cmdActCiudades" value="Actualizar"></td>
							</tr>
						</table>
						</form>
					</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
