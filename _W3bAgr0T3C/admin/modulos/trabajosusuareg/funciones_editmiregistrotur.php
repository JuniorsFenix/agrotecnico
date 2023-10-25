<?
   include("../../funciones_generales.php"); 
   //include("../../vargenerales.php");
   //require_once '../../herramientas/FCKeditor/fckeditor.php';
?>
    <?
  ###############################################################################
  # Nombre        : Editmiregistro
  # Descripci�n   : Muestra el formulario para editar mi registros
  # Parametros    : $IdUsuario =  $_SESSION["UsrId"];
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function RegistroEditar( $IdUsuario )
  {
	include("../../vargenerales.php");
	  $IdUsuario =  $_SESSION["UsrId"];
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tbl_registroslogintur WHERE idlogin = '$IdUsuario'" ) ;
	$Registro = mysqli_fetch_array( $Resultado );
	mysqli_close( $nConexion ) ;
	
?>
    <!-- Formulario Edici�n -->
    <style type="text/css">
<!--
.style1 {color: #FF0000}
-->
    </style>
    
	<table align="center" width="70%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td bgcolor="#DFDFDF">
			<table align="left" bgcolor="#DFDFDF">
				<tr>
					<td>
						<b class="fecha">
							<?
								session_start();
								echo "Sesi�n Iniciada por: " . $_SESSION["UsrNombre"] . " " . $_SESSION["UsrApellido"] ;
							?>
						</b>
					</td>
					
				</tr>
			</table>
		</td>
		<td bgcolor="#DFDFDF">
			<table align="right" bgcolor="#DFDFDF">
				<tr>
					<td><a href="logout.php" class="botonesBloque"><img src="../../image/iconoSesion.gif" border="0" width="18" height="10" align="absmiddle" alt="Cerrar Sesi&oacute;n"></a></td>
					<td><a href="logout.php" class="botonesBloque">cerrar sesi&oacute;n</a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>	
	
	<form action="editmiregistrotur.php?Accion=Guardar&Id=<? echo "$IdUsuario"; ?>" method="POST"onSubmit="return validate1(this)">
	<div align="center"><span class="tituloFormulario"><b>    MODIFICAR DATOS DEL REGISTRO </b></span><br>
      </div>
      <table align="center" style="border:1px solid #000000;">
	  
	  
	  
<tr>
<td align="center">
<span class="style1">*Campos Necesarios</span></td>
</tr>
<tr>
<td align="left"><span class="style1">*</span>Nombres:</td> 
  <td><input name="nombres" type="text" id="nombres" style="WIDTH: 300px; HEIGHT: 22px" value="<? echo $Registro["nombres"]; ?>" maxlength="200"></td>
</tr>
<td align="left">
<span class="style1">*</span>Apellidos:</td> 
  <td><input name="apellidos" type="text" id="apellidos" style="WIDTH: 300px; HEIGHT: 22px" value="<? echo $Registro["apellidos"]; ?>" maxlength="200"></td>
</tr>
<td align="left">Ciudad:</td> 
  <td><input name="ciudad" type="text" id="ciudad" style="WIDTH: 300px; HEIGHT: 22px" value="<? echo $Registro["ciudad"]; ?>" maxlength="200"></td>
</tr>
<td align="left">Direcci�n:</td> 
  <td><input name="direccion" type="text" id="direccion" style="WIDTH: 300px; HEIGHT: 22px" value="<? echo $Registro["direccion"]; ?>" maxlength="200"></td>
</tr>
<td align="left">Telefono:</td> 
  <td><input name="telefono" type="text" id="telefono" style="WIDTH: 100px; HEIGHT: 22px" value="<? echo $Registro["telefono"]; ?>" maxlength="50"></td>
</tr>
<td align="left"><span class="style1">*</span>Email:</td> 
  <td><input name="mail" type="text" id="mail" style="WIDTH: 300px; HEIGHT: 22px" value="<? echo $Registro["mail"]; ?>" maxlength="200"></td>
</tr>
<tr>
<td align="left"><span class="style1">*</span>User Name/Nick:</td> 
  <td><input name="username" type="text" id="username" style="WIDTH: 100px; HEIGHT: 22px" value="<? echo $Registro["username"]; ?>" maxlength="100"></td>
</tr>
<tr>
<td align="left"><span class="style1">*</span>Clave:</td> 
  <td><input name="clave" type="password" id="clave" style="WIDTH: 75px; HEIGHT: 22px" value="<? echo $Registro["clave"]; ?>" maxlength="50"></td>
</tr>
</table>
      <div align="center"><br>
        <br>
          <span class="nuevo">
  <input name="image" type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
  <a href="cabeceratur.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a> </span><br>
      </div>
	</form>
<script language="JavaScript">
<!--// La variable form, de la funci�n, contiene los datos del objeto formulario, y permite manipular sus propiedades.
function validate1 (form) {
// VARIABLES
// Variable para controlar si los campos necesarios estan llenos
r=1;
// TEST DE CAMPOS
// Si vale "" , se alerta, r=0, alerta al usuario y coloca el foco en el campo nombre
if (form.nombres.value==""){r=0;alert("Favor, llenar nombres!");form.nombres.focus};
if (form.apellidos.value==""){r=0;alert("Favor, llenar apellidos!");form.apellidos.focus};
if (form.mail.value.indexOf('@',0)==-1) {r=0;alert("Mail no es correcto, le falta @!");form.mail.focus};
if (form.mail.value.indexOf('.',0)==-1) {r=0;alert("Mail no es correcto, le falta .!");form.mail.focus};
if (form.username.value==""){r=0;alert("Favor, llenar User Name/Nick!");form.username.focus};
if (form.clave.value==""){r=0;alert("Favor, llenar clave!");form.clave.focus};

// RETORNAR AL ENV�O
// Si ha hay campos sin cubrir, interrumpimos el env�o del correo -return false-
if (r==0) { return false; }
// Si todo est� bien, te dispones a enviar el contenido del formulario al script php, -return true-
// Adem�s, alertas al usuario para que no pulse mas veces, a�n as�, la gente, no se cansa.
	else { alert ("Se esta procesando su informacion, click aceptar para continuar");return true; }
} 
//---->
</script>
</p>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript">
	_uacct = "UA-1321799-1";
	urchinTracker();
</script>	
    <?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>

    <?
  ###############################################################################
  # Nombre        : RegistroGuardar
  # Descripci�n   : Guarda los cambios del Registro
  # Parametros    : $IdUsuario
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function RegistroGuardar( $IdUsuario )
  {
	//include("../../vargenerales.php");
  	$IdUsuario =  $_SESSION["UsrId"];
	$nombres = $_POST["nombres"];
	$apellidos = $_POST["apellidos"];
	$ciudad = $_POST["ciudad"];
	$direccion = $_POST["direccion"];
	$telefono = $_POST["telefono"];
	$email = $_POST["mail"];
	$username = $_POST["username"];
	$clave = $_POST["clave"];
    $IdUsuario =  $_SESSION["UsrId"];

    $nConexion = Conectar();
	// Actualizar Registro Existente
    mysqli_query($nConexion, "UPDATE tbl_registroslogintur  SET nombres = '$nombres', apellidos = '$apellidos', ciudad = '$ciudad', direccion = '$direccion', telefono = '$telefono', mail = '$email', username = '$username', clave = '$clave' WHERE idlogin = '$IdUsuario'" );
  	
  mysqli_close( $nConexion );
  Mensaje( "El registro ha sido actualizado correctamente.", "cabeceratur.php" ) ;
  exit;
}	 // FIN: function 
  ###############################################################################
?>
