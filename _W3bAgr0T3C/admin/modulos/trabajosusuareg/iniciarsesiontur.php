<?
  include("funcioneslogintur.php");
	if ( isset( $_POST["txtUsuario"] ) )
  {
    if ( $_POST["txtUsuario"] != "" or $_POST["txtClave"] != "" )
      {
        ValidarLogin( $_POST["txtUsuario"],$_POST["txtClave"]);
      }
      else
      {
        header("Location: iniciarsesiontur.php?error=si");
      }
  }
?>
<html>
<head>
	<title>.:: Administración de mi cuenta.</title>
<script language="javascript">
function my_focus()
{
	document.frm.txtUsuario.focus();
}
</script>
</head>
<body onLoad="my_focus()">
	<table width="740"  border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td class="tablaPrincipal">

				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td class="tablaContenidos">
							<form method="post" action="iniciarsesiontur.php" name="frm">
								<table width="550" align="center" class="formularioLineaFuera">
									<tr valign="baseline">
										<td colspan="2" align="center">
										<?
										if ( $_GET[ "error" ] == "si" )
										{
											echo "<b>Usuario y Contrase&ntilde;a Vacios</b>";
										}
										else
										{
											echo "<b>Datos para iniciar sesi&oacute;n</b>";
										}
										?>
										<br></td>
									</tr>
									<tr>
										<td>
											<table border="0" align="center">
												<tr valign="baseline">
													<td nowrap class="nombresDelCampo">Usuario:</td>
													<td nowrap class="nombresDelCampo">
													<input type="text" autocomplete="off" id="txtUsuario" name="txtUsuario" maxLength="20">
													</td>
												</tr>
												<tr>
													<td nowrap class="nombresDelCampo">Clave:</td>
													<td nowrap class="nombresDelCampo">
													<input type="password" name="txtClave" id="txtClave" maxlength="20">
													</td>
												</tr>
												<tr>
													
												</tr>
												<tr>
													<td></td>
													<td>
                                                      <input name="submit" type="submit" id="submit" value="Iniciar Sesi&oacute;n">
</td>
												</tr>
												  <tr>
												  <td></td>
    <td align="left"><a href="registertur.php"><< Registrarme >></a></td>
  </tr>
											</table>
										</td>
									</tr>
								</table>
							</form>
						</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>
</body>
</html>
