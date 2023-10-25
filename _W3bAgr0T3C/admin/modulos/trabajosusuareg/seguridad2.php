<?
//Comprueba si la sesion es valida.
session_start();

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
if ($_SESSION["UsrValido"] != "SI") {
	//si no existe, envio a la página de autentificacion
	header("Location: iniciarsesiontur.php");
	//ademas salgo de este script
	exit();
}
?>
