<?php
session_start();
if ($_SESSION["UsrValido"] != "SI") {
	header("Location: /sadminc");
	exit;
}
?>
