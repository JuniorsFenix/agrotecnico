<?php
require_once dirname(__FILE__).("/../../../include/connect.php");
class DB{
	function __construct(){
    		$nConexion = Conectar();
			$this->connect = $nConexion;
	}
	
	function updateOrder($id_array, $tabla){
		$count = 1;
		foreach ($id_array as $id){
			$update = mysqli_query($this->connect,"UPDATE `$tabla` SET orden = $count WHERE id = $id");
			$count ++;	
		}
		return true;
	}
}
?>