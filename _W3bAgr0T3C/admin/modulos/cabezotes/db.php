<?php
require_once dirname(__FILE__).("/../../../include/connect.php");
class DB{
	function __construct(){
    		$nConexion = Conectar();
			$this->connect = $nConexion;
	}
	
	function getRows($idcategoria){
		$query = mysqli_query($this->connect,"SELECT * FROM tblcabezotes cab left join tblcabezotes_categorias cat on (cab.idcategoria=cat.idcategoria) WHERE cab.idcategoria=$idcategoria ORDER BY orden ASC") or die(mysqli_error($nConexion));
		while($row = mysqli_fetch_assoc($query))
		{
			$rows[] = $row;
		}
		return $rows;
	}
	
	function updateOrder($id_array, $idcategoria){
		$count = 1;
		foreach ($id_array as $id){
			$update = mysqli_query($this->connect,"UPDATE tblcabezotes SET orden = $count WHERE idcabezote = $id AND idcategoria=$idcategoria");
			$count ++;	
		}
		return true;
	}
}
?>