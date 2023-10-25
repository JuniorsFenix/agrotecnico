<?php
	$dsn = 'mysql:host=localhost;dbname=midoctor_base18;charset=utf8';
	$user = 'midoctor_base18';
	$password = 'I@o!*VQmh;%y';
	function get_db() {
		global $dsn, $user, $password;
		try {
			$db = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			exit;
		}
		return $db;
	}
?>