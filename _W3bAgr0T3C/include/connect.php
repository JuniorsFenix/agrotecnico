<?php
  error_reporting(E_ALL & ~(E_DEPRECATED|E_NOTICE));

  define("PAGO", "wompi");            // payu, wompi

  define("PAGO_PAYU_TEST",  false);    // Modo Test Payu
  define("PAGO_WOMPI_TEST", false);    // Modo Test Wompi
  define("PAGO_PSE_TEST",   true);     // Modo Test PSE

	global $ServidorDB;
	global $BaseDatos;
	global $UsuarioDB;
	global $ClaveDB;

	$ServidorDB = "localhost";			// Nombre del Servidor de Base de Datos.
	$BaseDatos  = "agrotecnicocom_2021"; 		// Nombre de la base de datos.
	$UsuarioDB  = "agrotecnicocom_2021"; 		// Nombre del usuario con acceso a la base de datos.
	$ClaveDB    = "I)uxR#_sDLls"; 		// Contraseña del usuario.
  
  function Conectar() {
	  global $ServidorDB;
	  global $BaseDatos;
	  global $UsuarioDB;
    global $ClaveDB;

    $nCnn = mysqli_connect($ServidorDB, $UsuarioDB, $ClaveDB, $BaseDatos) or die("Error conectando al servidor de bases de datos.");
    mysqli_set_charset($nCnn,'utf8');
    return $nCnn ;
  }
?>