<?php
  // Por convencion, la marca de agua debe ser cuadrada

	// Fichero y nuevo tamaño
	$nombre_fichero = $_GET["img"];

	// Tipo de contenido
	header('Content-Type: image/jpeg');

	// Obtener los nuevos tamaños
	list($ancho, $alto) = getimagesize($nombre_fichero);

	$proporcion = $ancho/$alto;
	$nuevo_alto = $_GET["h"];
	$nuevo_ancho = $nuevo_alto * $proporcion;

	// Cargar
	$thumb = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
	$origen = imagecreatefromjpeg($nombre_fichero);

	// Cambiar el tamaño
	imagecopyresized($thumb, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);

	// Imprimir
	imagejpeg($thumb, NULL, 80);
	imagedestroy($thumb);
?>