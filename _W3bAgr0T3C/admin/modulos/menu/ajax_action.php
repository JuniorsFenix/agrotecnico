<?php
require_once dirname(__FILE__).("/../../../include/connect.php");
$nConexion = Conectar();

/*function RecursiveWrite($array, $i = 1) {
    foreach ($array as $vals) {
        echo "id: ".$vals['id'] . " Orden: $i<br>";
        if(is_array($vals['children'])){ $i=1; RecursiveWrite($vals['children'], $i++); }
        $i++;
    }
}*/

if(isset($_POST["menu"])){
	$count = 1;
	foreach($_POST["menu"] as $vals){
		$parent = $vals["id"];
        echo "Id: $parent Orden: $count<br>";
		$update = mysqli_query($nConexion,"UPDATE tblmenu SET orden = $count, padre = 0 WHERE idmenu = $parent");
        if(is_array($vals['children'])){
			$child = 1;
			foreach($vals['children'] as $vals){
				echo "Id: {$vals["id"]} Orden: $child<br />";
				$update = mysqli_query($nConexion,"UPDATE tblmenu SET orden = $child, padre = $parent WHERE idmenu = {$vals["id"]}");
				$child++;
			}
		}
		$count++;
	}
	/*foreach ($id_array as $id){
		$count ++;	
	}*/
	
//RecursiveWrite($_POST["menu"]);
};
/*include_once('db.php');
$db = new DB();
$idArray	= explode(",",$_POST['ids']);
$idcategoria = $_POST['categoria'];
$db->updateOrder($idArray, $idcategoria);*/
?>