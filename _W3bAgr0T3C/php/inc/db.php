<?php

    $ServidorDB = "localhost";			// Nombre del Servidor de Base de Datos.
	$BaseDatos  = "dinalsom_db2017"; 		// Nombre de la base de datos.
    $UsuarioDB  = "dinalsom_db2017"; 		// Nombre del usuario con acceso a la base de datos.
    $ClaveDB    = "D65%RpG,~5^&"; 		// Contraseña del usuario.

    $nCnn = mysqli_connect( $ServidorDB, $UsuarioDB, $ClaveDB );
?>