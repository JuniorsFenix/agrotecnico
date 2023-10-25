<?
  ###############################################################################
  # funcioneslogin.php 	   :  Archivo de funciones para loguearse
  # Desarrollo             :  Estilo y Dise�o
  # Web                    :  http://www.estilod.com
  ###############################################################################
?>
<? //include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : ValidarLogin
  # Descripci�n   : Valida que el usuario y claves existan en la base de datos
  # Parametros    : Usuario, Clave
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function ValidarLogin( $cUsuario,$cClave,$cCodigo)
  {
  $fechaval = date("Y-m-d");
//echo $fechareg;
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tbl_registroslogintur  WHERE username='$cUsuario' AND clave='$cClave' AND idlogin='$cCodigo'" );
    mysqli_close( $nConexion );
    $Registro = mysqli_fetch_array( $Resultado );
    if ( $Registro[ "username" ] == $cUsuario && $Registro[ "clave" ] == $cClave && $Registro[ "idlogin" ] == $cCodigo)
    {
	$nConexion = Conectar();
	mysqli_query($nConexion,"UPDATE tbl_registroslogintur SET permitido = 'Si',fechavalidacion = '$fechaval' WHERE idlogin='$cCodigo'");
	mysqli_close( $nConexion );
	Mensaje( "Su Cuenta ha sido activada correctamente.", "iniciarsesiontur.php?ciudad=1" ) ;
    exit;
    }
    else
    {
//      echo "Usuario y/o contrase�a incorrectos.";
//	  Error( "Usuario y/o contrase�a incorrectos." );
//      exit;
    }
  } // FIN: function UsuariosActualizarClave
  ###############################################################################
?>