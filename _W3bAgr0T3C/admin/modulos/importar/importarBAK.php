<!DOCTYPE HTML>
<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

		<title>Importar/Actualizar productos</title>

  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
  <?php include("../../system_menu.php"); ?><br>
<?php
	use PhpOffice\PhpSpreadsheet\IOFactory;
	require_once __DIR__ . '/../../herramientas/PhpSpreadsheet/src/Bootstrap.php';
  require_once("../../funciones_generales.php");

	$nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
	setlocale(LC_ALL, 'en_US.UTF8');
	$message = '<div class="alert alert-danger">Productos actualizados con éxito.</div>';

	if($_FILES["archivo"]["name"] != '') {
		$allowed_extension = array('xls', 'xlsx');
		$file_array = explode(".", $_FILES['archivo']['name']);
		$file_extension = end($file_array);
		if(in_array($file_extension, $allowed_extension)) {

			$spreadsheet = IOFactory::load($_FILES['archivo']['tmp_name']);
		
			/*
			$categorias = $spreadsheet->getSheet(0)->toArray(null, true, true, true);
			array_shift($categorias);
		
			foreach ($categorias as $row){
				if(!empty($row["A"])){
					$url = slug($row["C"]);
			
					$sql="SELECT vpath FROM tblti_categorias WHERE idcategoria = {$row["B"]} ";
					$ra = mysql_query($sql);
					$dCat = mysql_fetch_assoc( $ra );
			
					$vpath = $dCat["vpath"];
					if( $vpath=="/" ) $vpath="";
					$vpath="{$vpath}/{$row["C"]}";
			
					$sql="INSERT INTO tblti_categorias
					(idciudad, idcategoria, nombre, descripcion, vpath, url, idcategoria_superior, titulo, metaDescripcion, tags, publicar) VALUES
					(1,'{$row["A"]}','{$row["C"]}','{$row["D"]}','$vpath','$url',{$row["B"]},'{$row["E"]}','{$row["F"]}','{$row["G"]}',1) ON DUPLICATE KEY UPDATE
					nombre='{$row["C"]}', descripcion='{$row["D"]}', vpath='$vpath', url='$url', idcategoria_superior='{$row["B"]}', titulo='{$row["E"]}', metaDescripcion='{$row["F"]}', tags='{$row["G"]}'";
					mysql_query($sql);
				}
			}
		
			$marcas = $spreadsheet->getSheet(1)->toArray(null, true, true, true);
			array_shift($marcas);
		
			foreach ($marcas as $row){
				if(!empty($row["A"])){
					$sql = "INSERT INTO tblti_marcas ( idmarca, nombre ) VALUES ('{$row["A"]}', '{$row["B"]}') ON DUPLICATE KEY UPDATE nombre='{$row["B"]}'";
					mysql_query($sql);
				}
			}
		
			$colores = $spreadsheet->getSheet(2)->toArray(null, true, true, true);
			array_shift($colores);
		
			foreach ($colores as $row){
				if(!empty($row["A"])){
					$sql = "INSERT INTO tblti_colores ( id, nombre, color ) VALUES ('{$row["A"]}', '{$row["B"]}', '{$row["C"]}') ON DUPLICATE KEY UPDATE nombre='{$row["B"]}', color='{$row["C"]}'";
					mysql_query($sql);
				}
			}
		*/
			$productos = $spreadsheet->getSheet(0)->toArray(null, true, true, true);
			array_shift($productos);
		    
		    $i = 2;
			foreach ($productos as $row){
				if(!empty($row["A"])){
					$url = slug($row["B"]);
					$activo=1;
					$inventario_activo=1;
					if ($row["F"]==0) {
						$inventario_activo=0;
					}
					$campos = "precioant={$row["C"]}, precio={$row["D"]}, diasiniva={$row["G"]}, precioa_activo={$row["H"]}";
					/*if ($row["E"]!="NA") {
						$campos .= ", iva={$row["E"]}";
					}
					if ($row["F"]!="NA") {
						$campos .= ", inventario={$row["F"]}";
					}*/
					mysqli_query($nConexion, "UPDATE tblti_productos SET $campos, activo=$activo, inventario_activo=$inventario_activo, precio_activo=1 WHERE codigowo='{$row["A"]}'");
					echo mysqli_error($nConexion);
					echo "$i. {$row["A"]} - {$row["B"]} - Precio Ant.: {$row["C"]} - Precio: {$row["D"]} IVA: {$row["G"]}<br>";
					printf("Affected rows: %d\n", mysqli_affected_rows($nConexion));
					echo "<br>";
					$i++;
				}
			}
		} else {
			$message = '<div class="alert alert-danger">Solo archivos .xls o .xlsx son permitidos</div>';
		}
	} else {
		$message = '<div class="alert alert-danger">Por favor suba un archivo.</div>';
	}

	echo $message;

?>
	</body>
</html>