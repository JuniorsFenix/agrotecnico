<?php
require_once dirname(__FILE__).("/../../../include/connect.php");
class DB{
	function __construct(){
    		$nConexion = Conectar();
			$this->connect = $nConexion;
	}
	
	function getRows(){
		$query = mysqli_query($this->connect,"SELECT * FROM tblimagenes_fondo a join tblfondos_categorias b on (a.idcategoria=b.idcategoria) ORDER BY orden ASC") or die(mysqli_error($nConexion));
		while($row = mysqli_fetch_assoc($query))
		{
			$rows[] = $row;
		}
		return $rows;
	}
	
	function updateOrder($id_array){
		$count = 1;
		foreach ($id_array as $id){
			$update = mysqli_query($this->connect,"UPDATE tblimagenes_fondo SET orden = $count WHERE idimagen = $id");
			$count ++;	
		}
		return true;
	}
}
?>