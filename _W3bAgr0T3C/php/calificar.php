<?php
	require_once("../include/connect.php");
	$nConexion = Conectar();
	if(!empty($_POST['rating'])){
		function getUserIP(){
			$client  = @$_SERVER['HTTP_CLIENT_IP'];
			$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
			$remote  = $_SERVER['REMOTE_ADDR'];

			if(filter_var($client, FILTER_VALIDATE_IP))
			{
					$ip = $client;
			}
			elseif(filter_var($forward, FILTER_VALIDATE_IP))
			{
					$ip = $forward;
			}
			else
			{
					$ip = $remote;
			}

			return $ip;
		}
		$user_ip = getUserIP();

		$sql="INSERT INTO tblti_rating (ip, idproducto, rating) VALUES('$user_ip', {$_POST['idproduct']}, {$_POST['rating']}) ON DUPLICATE KEY UPDATE rating={$_POST['rating']}";
		mysqli_query($nConexion,$sql);
		echo mysqli_error($nConexion);
	} 
	?>