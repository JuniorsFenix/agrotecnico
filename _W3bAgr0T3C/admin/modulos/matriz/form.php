<?php
    if(!session_id()) session_start();
	$_SESSION["form"] = $_POST["form"];
	echo $_POST["form"]." Hola";
	die();
?>