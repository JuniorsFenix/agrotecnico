<?php
    if(!session_id()) session_start();
    unset($_SESSION['usuario']);
    unset($_SESSION['loggedin']);
	header("Location: /");
	exit;
?>