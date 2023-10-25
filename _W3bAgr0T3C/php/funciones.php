<?php
	$db = null;

	function get_db() {
	  global $ServidorDB;
	  global $BaseDatos;
	  global $UsuarioDB;
	  global $ClaveDB;
			$db = new PDO("mysql:host=$ServidorDB;dbname=$BaseDatos", $UsuarioDB, $ClaveDB);
		return $db;
	}
  
  function imagenProductos( $idproducto )
{	
	$db = get_db();
	$stmt = $db->prepare("select imagen from tblti_imagenes where idproducto=? order by idimagen asc limit 1");
	$stmt->execute(array($idproducto));
	$img = $stmt->fetch(PDO::FETCH_ASSOC);
    return $img["imagen"];
}

	function get_cars () { 
		$file_db = get_db();
		$id_where = "";
		$where = "";
		$vals = array();
		$id_vals = array();

		if(isset($_GET["search"]) && $_GET["search"] != "")  {
		 	$words = explode(" ", $_GET['search']);
			
			$id_where = " WHERE ";
			#VERY rudimentary BAD search function for search queries. Also, very inefficient when scaled.
			#just for purposes of demo
			foreach($words as $word) { 
				$word = "%$word%";
				$id_where .= "idcategoria LIKE ? OR sexo LIKE ? OR marca LIKE ? OR deporte LIKE ? OR color LIKE ? OR ";
				array_push($id_vals, $word, $word, $word, $word, $word);
			}

			$id_where = substr($id_where, 0, -3);
		}

		#inefficient to select all matches and then filter down. purely for demo and to
		#have faceted query on its own for demonstration. Look into elasticsearch or solr for efficient faceting!
		$stmt = $file_db->prepare("SELECT idproducto FROM tblti_productos $id_where");
		$stmt->execute($id_vals);

		$ids_list = "";
		while($product = $stmt->fetch()) { 
			$ids_list .= $product['idproducto'] . ",";	
		}
		$ids_list = substr($ids_list, 0, -1);

		#return if we got no results from search!
		if($ids_list == "") { 
			return $stmt;
		}

		unset($_GET['search']);

		#if we have facets
		if(count($_GET) > 0) { 

			#handle specialCases
			if($_GET['onlyPhotos'] == "1") { 
				$where .= " AND image!='' ";	
				unset($_GET['onlyPhotos']);
			}

			if($_GET[minPrice] != "") { 
				$where .= " AND precio >= $_GET[minPrice] ";
			}

			if($_GET[maxPrice] != "") { 
				$where .= " AND precio <= $_GET[maxPrice] ";
			}

			unset($_GET[minPrice]);
			unset($_GET[maxPrice]);

			if($_GET[minYear] != "") {
				$where .= " AND year >= $_GET[minYear] ";
			}


			if($_GET[maxYear] != "") {
				$where .= " AND year <= $_GET[maxYear] ";
			}

			unset($_GET[minYear]);
			unset($_GET[maxYear]);



			foreach($_GET as $key=>$value) {
				if(is_array($value)) {
					$where .= " AND (1=0";
					foreach($value as $el) { 
						$where .= " OR FIND_IN_SET(?, $key)";
						array_push($vals, $el);
					}
					$where .= ") ";
				}
				else { 
					$where .= "AND FIND_IN_SET(?, $key) ";
					array_push($vals, $value);
				}
			}
		}

		$stmt = $file_db->prepare("SELECT * FROM tblti_productos WHERE idproducto IN ($ids_list) $where");
		$stmt->execute($vals);

		return $stmt;
	}

	function grid_view($stmt) { 
	global $home;
		$string = "";
		while ($product = $stmt->fetch()) {

			$imagen = imagenProductos( $product["idproducto"] );
			$string .= "
				<div class='col-md-3 col-sm-6'>
                            <div class='thumbnail'>
                                        <a class='img' href='$home/membresias/$product[url]'><img src='$home/fotos/tienda/productos/m_$imagen' alt='$product[nombre]' /></a>
                                    <div class='caption'>
                                        <h4 class='title'><a href='$home/membresias/$product[url]'>$product[nombre]</a></h4>
                                        <ul class='list-unstyled'>
                                            <li><span><strong>$" . number_format($product["precio"]) . "</strong></span></li>
                                        </ul>
                                    </div>
                                </div>
								</div>
								";
		}	

		if($string == "") { 
			$string = "<h3 style='text-align:center'>NO HAY RESULTADOS</h3>";
		}

		return $string;
	}

	function get_models () { 
		$file_db = get_db();
		return $file_db->query('SELECT nombre, idcategoria FROM tblti_categorias where idcategoria !=0 ORDER BY nombre ASC');
	}

	function get_marcas () { 
		$file_db = get_db();
		return $file_db->query('SELECT * FROM tblti_marcas ORDER BY nombre ASC');
	}
	
	function get_colores () { 
		$file_db = get_db();
		return $file_db->query('SELECT * FROM tblti_colores ORDER BY nombre ASC');
	}
	
	function get_deportes () { 
		$file_db = get_db();
		return $file_db->query('SELECT * FROM tblti_deportes ORDER BY nombre ASC');
	}

	if(isset($_GET["ajax"]) && $_GET["ajax"] == "true") {
		unset($_GET['ajax']);
		echo grid_view(get_cars());
		exit;
	}
?>
