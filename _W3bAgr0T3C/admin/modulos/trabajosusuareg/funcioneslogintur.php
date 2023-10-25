<?
  ###############################################################################
  # funcioneslogintur.php  :  Archivo de funciones para loguearse
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
  function ValidarLogin( $cUsuario,$cClave)
  {
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tbl_registroslogintur  WHERE username='$cUsuario' AND clave='$cClave' AND permitido='Si'" );
    mysqli_close( $nConexion );
    $Registro = mysqli_fetch_array( $Resultado );
    if ( $Registro[ "username" ] == $cUsuario && $Registro[ "clave" ] == $cClave )
	{
      //echo "usuario correcto";
      session_start();
      $_SESSION["UsrValido"]= "SI";
      $_SESSION["UsrNombre"]= $Registro[ "nombres" ];
	  $_SESSION["UsrApellido"]= $Registro[ "apellidos" ];
	  $_SESSION["UsrUser"]  = $Registro[ "usuario" ];
  	  $_SESSION["UsrId"]  = $Registro[ "idlogin" ];
	  header ("Location: cabeceratur.php?ciudad=1");
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