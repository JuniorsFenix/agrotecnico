<?php
require_once dirname(__FILE__).("/../../../include/connect.php");
class DB{
	function __construct(){
    		$nConexion = Conectar();
			$this->connect = $nConexion;
	}
	
	function updateOrder($id_array, $categoria){
		$count = 1;
		foreach ($id_array as $id){
			$update = mysqli_query($this->connect,"UPDATE `tblti_productos` SET orden = $count WHERE idproducto = $id AND idcategoria = $categoria");
			$count ++;	
		}
		return true;
	}
	
	function updateOrderCat($id_array, $tabla){
		$count = 1;
		foreach ($id_array as $id){
			$update = mysqli_query($this->connect,"UPDATE `$tabla` SET orden = $count WHERE idcategoria = $id");
			$count ++;	
		}
		return true;
	}
	
	function updateOrderMarcas($id_array){
		$count = 1;
		foreach ($id_array as $id){
			$update = mysqli_query($this->connect,"UPDATE `tblti_marcas` SET orden = $count WHERE idmarca=$id");
			$count ++;	
		}
		return true;
	}
}
?>