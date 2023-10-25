<?php
	include("../include/funciones_public.php");
	include("../admin/vargenerales.php");

	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	$nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');

if($_POST) {
	$page = $_POST['page']; // Current page number
	$per_page = $_POST['per_page']; // Articles per page
	$category = $_POST['category']; // Category
	$orderby = $_POST['orderby']; // Order by
	$order = $_POST['order']; // ASC, DESC
	if ($page != 1) $start = ($page-1) * $per_page;
	else $start=0;
	$articleList = '';
	
	$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE id = $category" ) ;
	$matriz     = mysqli_fetch_array( $Resultado );
	$tabla = $matriz["tabla"];
	
	$sql="SELECT * FROM `$tabla` WHERE publicar='S' ORDER BY $orderby $order LIMIT $start, $per_page";
	$stmt = mysqli_query($nConexion,$sql);
				
	$campos    = mysqli_query($nConexion, "SELECT * FROM campos ca JOIN campos_matriz cm on (ca.campo=cm.campo) WHERE cm.idmatriz = '$category' ORDER BY cm.id ASC" );
	
			
	$sql="SELECT count(id) FROM `$tabla` WHERE publicar='S'";
	$result = mysqli_query($nConexion,$sql);
	$numArticles = mysqli_fetch_array($result);
	
	$numPage = ceil($numArticles[0] / $per_page); // Total number of page
	
		while($Registro=mysqli_fetch_assoc($stmt)){
			$imagen = "";
			$campo = "";
			$fotos    = mysqli_query($nConexion,"SELECT * FROM imagenes_matriz WHERE idmatriz = $category and idcontenido = {$Registro["id"]} LIMIT 1");
			if ( !mysqli_num_rows( $fotos ) ) {
				$imagen = "<a class='imagenBlog' href='$home/$tabla/{$Registro["url"]}'><img alt='{$matriz["titulo"]}' src='$home/fotos/Image/contenidos/default.jpg' /></a>";
			}
			else{
				$Fotos = mysqli_fetch_assoc($fotos);
				$imagen = "<a class='imagenBlog' href='$home/$tabla/{$Registro["url"]}'><img alt='{$matriz["titulo"]}' src='$home/fotos/Image/$tabla/m_{$Fotos["imagen"]}'/></a>";
			}
			while($r = mysqli_fetch_assoc($campos)):
				if($r["campo"]=="Resumen"){
					$campo.= "<p>{$Registro["Resumen"]}</p>";
				} 
				elseif($r["campo"]=="Titulo"){
					$campo.= "<h3>{$Registro["Titulo"]}</h3>";
				}
				elseif($r["campo"]=="Subtitulo") {
					$campo.= "<h4>{$Registro["Subtitulo"]}</h4>";
				}
			endwhile;
			mysqli_data_seek($campos, 0);
		$articleList .= "<div class='blog-wrap listado col-sm-6 col-lg-3'>
					$imagen
           			<div class='campos'>
					$campo
					</div>
					<a href='$home/$tabla/{$Registro["url"]}' class='link'>Ver más</a>
                </div>";
		}
	
	// We send back the total number of page and the article list
	$dataBack = array('numPage' => $numPage, 'articleList' => $articleList);
	$dataBack = json_encode($dataBack);
	
	echo $dataBack;
}
?>
