<? 
//include("../../funciones_generales.php"); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Nuevo Registro</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body>
<tr>
<td align="center">
  <div align="center"><strong>DATOS PARA REGISTRARSE</strong></div></td>
</tr>

<form action="registertur.php" method="POST">
<table align="center" style="border:1px solid #000000;">
<tr>
<td align="center">
<span class="style1"><span class="style1">*</span>Campos Necesarios</span></td>
</tr>
<tr>
<td align="left"><span class="style1">*</span>Nombres:</td> 
  <td><input type="text" size="50" maxlength="50" name="nombres"></td>
</tr>
<td align="left">
<span class="style1">*</span>Apellidos:</td> 
  <td><input type="text" size="50" maxlength="50" name="apellidos"></td>
</tr>
<td align="left">Ciudad:</td> 
  <td><input type="text" size="50" maxlength="50" name="ciudad"></td>
</tr>
<td align="left">Direcci�n:</td> 
  <td><input type="text" size="50" maxlength="100" name="direccion"></td>
</tr>
<td align="left">Telefono:</td> 
  <td><input type="text" size="15" maxlength="15" name="telefono"></td>
</tr>
<td align="left"><span class="style1">*</span>Email:</td> 
  <td><input type="text" size="50" maxlength="50" name="mail"></td>
</tr>
<tr>
<td align="left"><span class="style1">*</span>User Name/Nick:</td> 
  <td><input type="text" size="20" maxlength="20" name="username"></td>
</tr>
<tr>
<td align="left"><span class="style1">*</span>Clave:</td> 
  <td><input type="password" size="10" maxlength="10" name="clave"></td>
</tr>
<tr>
<td align="left"><span class="style1">*</span>Repita Clave:</td> 
  <td><input type="password" size="10" maxlength="10" name="clave1"></td>
</tr>
</table>
<br>
<table align="center" width="50%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" ><input size="100%" name="submit" type="submit" value="Registrar">
      <br></td>
  </tr>
  <tr>
    <td align="center"><a href="iniciarsesiontur.php"><br>
      << Iniciar Sesi�n >></a></td>
  </tr>
</table>
<br>
<br>
</form>
<?
// Conexi�n a la base de datos
$nConexion = Conectar();
// Preguntaremos si se han enviado ya las variables necesarias
if (isset($_POST["username"])) {
$username = $_POST["username"];
$clave = $_POST["clave"];
$clave1 = $_POST["clave1"];
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$ciudad = $_POST["ciudad"];
$direccion = $_POST["direccion"];
$telefono = $_POST["telefono"];
$email = $_POST["mail"];
// Hay campos en blanco
if($username==NULL|$clave==NULL|$clave1==NULL|$nombres==NULL|$apellidos==NULL|$email==NULL) {
echo "* Campos Necesarios";
}else{
// �Coinciden las contrase�as?
if($clave!=$clave1) {
echo "Las contrase�as no coinciden";
}else{
// Comprobamos si el nombre de usuario o la clave o la cuenta de correo ya exist�an
$checkuser = mysqli_query($nConexion,"SELECT username FROM tbl_registroslogintur  WHERE username='$username'");
$username_exist = mysqli_num_rows($checkuser);

$checkclave = mysqli_query($nConexion,"SELECT clave FROM tbl_registroslogintur  WHERE clave='$clave'");
$clave_exist = mysqli_num_rows($checkclave);

$checkemail = mysqli_query($nConexion,"SELECT mail FROM tbl_registroslogintur WHERE mail='$email'");
$email_exist = mysqli_num_rows($checkemail);

if ($email_exist>0|$clave_exist>0|$username_exist>0) {
echo "EL nombre de usuario o la clave o la cuenta de correo estan ya en uso";
}else{
//Todo parece correcto procedemos con la inserccion
$fechareg = date("Y-m-d");
//echo $fechareg;
$query = "INSERT INTO tbl_registroslogintur (idlogin,nombres,apellidos,ciudad,direccion,telefono,mail,username,clave,permitido,fecharegistro,fechavalidacion,idciudad) VALUES ('','$nombres','$apellidos','$ciudad','$direccion','$telefono','$email','$username','$clave','No','$fechareg','','1')";
mysqli_query($nConexion,$query) or die(mysqli_error($nConexion));
echo "El usuario $nombres $apellidos ha sido registrado de manera satisfactoria<br>
A vuelta de correo recibir� el link de activaci�n<br>
De click al bot�n para enviar la informacion.";

$nConexion = Conectar();
$registros=mysqli_query($nConexion,"select count(*) as cantidad from tbl_registroslogintur");
$reg=mysqli_fetch_array($registros);
//echo "La cantidad de usuarios inscritos es :".$reg['cantidad'];
$Resultado = mysqli_query($nConexion,"SELECT * FROM tbl_registroslogintur ORDER BY idlogin DESC Limit 1") ;
mysqli_close( $nConexion );
$Regis = mysqli_fetch_array( $Resultado );
$codigo = $Regis["idlogin"];
echo "<br>";
echo $codigo. "<br>";
echo $username. "<br>";
echo $clave. "<br>";
echo $nombres. "<br>";
echo $apellidos. "<br>";
echo $email. "<br>";

?>
<form action="envactivartur.php" method="POST">
<input type="hidden" id="txtId" name="txtId" value="<? echo $codigo; ?>" />
<input type="hidden" id="nombres" name="nombres" value="<? echo $nombres; ?>" />
<input type="hidden" id="nick" name="nick" value="<? echo $username; ?>" />
<input type="hidden" id="maile" name="maile" value="<? echo $email; ?>" />
<input type="submit" value="Enviar">
</form>
<!--<a href="envactivar.php">Activar</a>-->
<?
}
}
}
}
?>
</body>
</html>
