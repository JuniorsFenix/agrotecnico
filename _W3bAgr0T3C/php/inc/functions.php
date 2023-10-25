<?php
if(!session_id()) session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once dirname(__FILE__).('/../../admin/herramientas/phpmailer/src/Exception.php');
require_once dirname(__FILE__).('/../../admin/herramientas/phpmailer/src/PHPMailer.php');
require_once dirname(__FILE__).('/../../admin/herramientas/phpmailer/src/SMTP.php');

require_once dirname(__FILE__).("/../../include/connect.php");
require_once dirname(__FILE__).("/../../include/funciones_public.php");
global $home;
$action = '';

if($_SESSION['loggedin']==true && $_SESSION["usuario"]["cotizacion"]==1){
  define("COTIZAR", true);
} else {
  define("COTIZAR", false);
}

  $sessionID = $_COOKIE['PHPSESSID'];

if($_POST['action'] != '' || $_GET['action'] != '') {
  if($_POST['action'] == '')
  {
    $action 	= $_GET['action'];
    $productID	= $_GET['productID'];
    $basketID	= $_GET['basketID'];
    $cantidad	= $_GET['cantidad'];
    $color	= $_GET['color'];
    $talla	= $_GET['talla'];
    $descuentoCotizar	= $_GET['descuentoCotizar'];
    $noJavaScript = 1;
  } else {
    $action 	= $_POST['action'];
    $productID	= $_POST['productID'];
    $basketID	= $_POST['basketID'];
    $cantidad	= $_POST['cantidad'];
    $color	= $_POST['color'];
    $talla	= $_POST['talla'];
    $descuentoCotizar	= $_POST['descuentoCotizar'];
    $noJavaScript = 0;
  }
}
  
if ($action == "addToBasket"){
  include dirname(__FILE__).("/../diasiniva.php");

  $productInBasket 	= 0;
  $productTotalPrice	= 0;
  $stihl	= 0;

    $nConexion    = Conectar();
  $query  = "SELECT * FROM tblti_productos WHERE idproducto = '" . $productID . "'";
  $result = mysqli_query($nConexion,$query);
  $row = mysqli_fetch_array( $result );

  if($_SESSION['loggedin']==true && $_SESSION["usuario"]["cotizacion"]==1){
    define("COTIZAR", true);
  }
  
  if(COTIZAR===true && $row['precioant'] > 0){
    $productPrice = $row['precioant'];
  }else{
    if(DIASINIVA AND $row["diasiniva"]) {
	  $divisor = 1 + ($row['iva'] / 100);
      $productPrice = $row['precio']/$divisor;
    }else{
      $productPrice = $row['precio'];
    }
  }
  
  $productName		= $row['nombre'];

  //Si es un producto Stihl
  if($row["idmarca"]==1 && !DIASINIVA){
    $stihl	= 1;
    $productPrice = 0;
    if(COTIZAR===true){
        if ($row['precioant'] > 0) {
            $productPrice = $row['precioant'];
        } else {
            $productPrice = $row['precio'];
        }
    }
  }
  
    $query = "INSERT INTO tblti_baskets 
                          (productID, productPrice, basketSession, talla, color, cantidad, stihl) 
                   VALUES ('$productID', '$productPrice', '$sessionID', '$talla', '$color', '$cantidad', $stihl)";
    mysqli_query($nConexion,$query) or die('Error, insert query failed');
  
  $query  = "SELECT * FROM tblti_baskets 
              WHERE productID = " . $productID . " AND basketSession = '" . $sessionID . "'";
  $result = mysqli_query($nConexion,$query) or die(mysqli_error($nConexion));
  
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $totalItems 	= $totalItems + 1;
    if(DIASINIVA AND $row["diasiniva"]) {
      $productTotalPrice 	= $productTotalPrice + $row['productPrice'];
    }else{
      $productTotalPrice 	= $productTotalPrice + $row['productPrice'];
    }
  }
  
  if ($noJavaScript == 1) {
    header("Location: ../index.php");
  } else {
    echo ('<li id="productID_' . $productID . '"><a href="'.$home.'/php/inc/functions.php?action=deleteFromBasket&productID=' . $productID . '" onClick="return false;"><img src="'.$home.'/php/images/delete.png" id="deleteProductID_' . $productID . '"></a> ' . $productName . '(' . $totalItems . ' items) - $' . $productTotalPrice . '</li>');
  }

}


if ($action == "updateQuantity"){
  $sessionID = $_COOKIE['PHPSESSID'];
    $nConexion    = Conectar();
  $query = "UPDATE tblti_baskets SET cantidad = $cantidad WHERE basketID=$basketID AND basketSession='$sessionID'";
  mysqli_query($nConexion,$query) or die(mysqli_error($nConexion));
    
  if ($noJavaScript == 1) {
    header("Location: ../index.php");
  }	
}

if ($action == "updateDescuento"){
  $sessionID = $_COOKIE['PHPSESSID'];
    $nConexion    = Conectar();
  $query = "UPDATE tblti_baskets SET descuento = $descuentoCotizar WHERE basketID=$basketID AND basketSession='$sessionID'";
  mysqli_query($nConexion,$query) or die(mysqli_error($nConexion));
    
  if ($noJavaScript == 1) {
    header("Location: ../index.php");
  }	
}

if ($action == "deleteFromBasket"){
  $sessionID = $_COOKIE['PHPSESSID'];
    $nConexion    = Conectar();
  $query = "DELETE FROM tblti_baskets WHERE basketID=$basketID AND basketSession='$sessionID'";
  mysqli_query($nConexion,$query) or die(mysqli_error($nConexion));
}

if ($action == "useDiscount"){
	$nConexion    = Conectar();
	$codigo = $_POST['descuento'];

	$sql=mysqli_query($nConexion,"SELECT * FROM tblti_cupones WHERE codigo='$codigo' AND activo='1'");
	$count=mysqli_num_rows($sql);
	
	if($count==1){
		$subtotal = totalCarro();
		$descuento = mysqli_fetch_assoc($sql);

		$valorDescuento = $subtotal * ($descuento["efecto"] / 100);

    $data['success'] = true;
		$data['nombre'] = $descuento["nombre"];
		$data['descuento'] = $valorDescuento;
		$data['total'] = $subtotal - $valorDescuento;
	} else {
		$data['success'] = false;
    $data['error']  = "Este código no es válido o ya ha sido usado";
	}
	echo json_encode($data);
}

if ($action == "cambioDoc"){
    $sessionID = $_COOKIE['PHPSESSID'];
	$nConexion    = Conectar();
	$doc = $_POST['doc'];
	
	$data['total'] = totalCarro($doc);
	$data['iva'] = iva($doc);
	$data['sinIva'] = $data['total'] - $data['iva'];
	$data['carro'] = carro($doc);
	
	echo json_encode($data);
}

function getBasket(){
  if(!session_id()) session_start();
  $sessionID = $_COOKIE['PHPSESSID'];
  
    $nConexion    = Conectar();
  $query  = "SELECT * FROM tblti_baskets WHERE basketSession = '" . $sessionID . "' GROUP BY productID ORDER By basketID DESC";
  $result = mysqli_query($nConexion,$query);
  //echo $query;
  
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
  {
    
    $query2  = "SELECT * FROM tblti_productos WHERE idproducto = " . $row['productID'];
    $result2 = mysqli_query($nConexion,$query2);
    $row2 = mysqli_fetch_array( $result2 );
  
    $productID	 		= $row2['idproducto'];
    $productPrice 		= $row2['precio'];
    $productName		= $row2['nombre'];	
  
    $query2  = "SELECT COUNT(*) AS totalItems FROM tblti_baskets WHERE basketSession = '" . $sessionID . "' AND productID = " . $productID;
    $result2 = mysqli_query($nConexion,$query2);
    $totalItems = $row2['totalItems'];
    
    $pros=mysqli_query($nConexion,"select * from tblti_baskets where basketSession='".$sessionID."' and productID='".$productID."'");
    $conteo=mysqli_num_rows($pros);
  
    $basketText = $basketText . '<li id="productID_' . $productID . '">' . $productName . '(' . $conteo . ' items) - $' . ($conteo * $productPrice) . '</li>';
    
  }
    
    $link = '<li><div class="finCompra" href="/carro">Finalizar compra</div></li>';
  echo $basketText.$link;
}

function carro($doc="cedula"){
  include dirname(__FILE__).("/../diasiniva.php");

  if(!session_id()) session_start();
  include dirname(__FILE__).("/../../admin/vargenerales.php");
  $sessionID = $_COOKIE['PHPSESSID'];
  
  $nConexion    = Conectar();
  $query  = "SELECT * FROM tblti_baskets WHERE basketSession='$sessionID' AND stihl=0 ORDER By basketID DESC";
  if(COTIZAR===true) {
    $query  = "SELECT * FROM tblti_baskets WHERE basketSession='$sessionID' ORDER By basketID DESC";
  }

  $result = mysqli_query($nConexion,$query);
  //echo $query;
  $imagenes=array();
  $ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
  while( $imagen = mysqli_fetch_assoc($ras) ){
    $imagenes[ $imagen["idproducto"] ] = $imagen;
  }
  
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
  {
    
    $query2  = "SELECT * FROM tblti_productos WHERE idproducto = " . $row['productID'];
    $result2 = mysqli_query($nConexion,$query2);
    $row2 = mysqli_fetch_array( $result2 );
  
    $productID	 		= $row2['idproducto'];
	$divisor = 1 + ($row2['iva'] / 100);
    
    /*if(COTIZAR===true) {
      $productPrice 	= "COP ".number_format( ($row2["precioant"]), 0, ',', '.' );
      $subtotal 	= "COP ".number_format( ( ($row2["precioant"]/$divisor) - ($row['descuento'] * ($row2["precioant"]/$divisor) / 100) ) * $row['cantidad'] , 0, ',', '.' );      
    }else{
      if(DIASINIVA && $row2["diasiniva"] && $doc!="nit" ) {
          $productPrice 	= "COP ".number_format( ($row2["precio"]/$divisor), 0, ',', '.' );
          $subtotal 	= "COP ".number_format( ($row2["precio"]/$divisor * $row['cantidad']), 0, ',', '.' );
      }else{
          $productPrice 	= "COP ".number_format( ($row2["precio"]), 0, ',', '.' );
          $subtotal 	= "COP ".number_format( ($row2["precio"] * $row['cantidad']), 0, ',', '.' );      
      }
    }*/
    
    if(COTIZAR===true) {
      $productPrice 	= "COP ".number_format( ($row['productPrice']), 0, ',', '.' );
      $subtotal 	= "COP ".number_format( ( ($row['productPrice']/$divisor) - ($row['descuento'] * ($row['productPrice']/$divisor) / 100) ) * $row['cantidad'] , 0, ',', '.' );      
    }else{
      if(DIASINIVA && $row2["diasiniva"] && $doc!="nit" ) {
          $productPrice 	= "COP ".number_format( ($row['productPrice']/$divisor), 0, ',', '.' );
          $subtotal 	= "COP ".number_format( ($row['productPrice']/$divisor * $row['cantidad']), 0, ',', '.' );
      }else{
          $productPrice 	= "COP ".number_format( ($row['productPrice']), 0, ',', '.' );
          $subtotal 	= "COP ".number_format( ($row['productPrice'] * $row['cantidad']), 0, ',', '.' );      
      }
    }

    $basketID 	= $row['basketID'];
    $cantidad		= $row['cantidad'];
    $productName= $row2['nombre'];	
    $url				= $row2['url'];	
    $descuentoCotizar	= $row['descuento'];
    
    $tallas=array();
    foreach(explode(",",$row2["tallas"]) as $v){
      $tallas[$v]=$v;
    }
    
      $colores = mysqli_query($nConexion,"SELECT * FROM tblti_colores");
    
    $query2  = "SELECT COUNT(*) AS totalItems FROM tblti_baskets WHERE basketSession = '" . $sessionID . "' AND productID = " . $productID;
    $result2 = mysqli_query($nConexion,$query2);
    $totalItems = $row2['totalItems'];
    
      //$cartTotal += $productPrice;
    
      $price = "$productPrice";
    
    $pros=mysqli_query($nConexion,"select * from tblti_baskets where basketSession='".$sessionID."' and productID='".$productID."'");
    $conteo=mysqli_num_rows($pros);
    
    if(COTIZAR===true){
      $clase = "cantidadCarroCotizar";
      $callback = "carrito-cotizar";
    }else{
      $clase = "cantidadCarro";
      $callback = "carrito";
    }

    $carro = '
      <tr class="first last" id="productID_' . $productID . '">
        <th class="a-center" rowspan="1">
          <a href='.$home.'/php/inc/functions.php?action=deleteFromBasket&productID=' . $basketID . '&callback=' .$callback. ' onClick="return false;">
            <img style="width: 30px;" src="'.$home.'/php/images/delete.png" id="deleteProductID_' . $basketID . '">
          </a>
        </th>
        
        <th class="a-center">
          <span class="nobr">
            <img class="imgCarro" src="' . $cRutaVerImagenTienda . 'p_' . $imagenes[$productID]['imagen'] . '" alt="' . $productName . '" >
          </span>
        </th>
        
        <th rowspan="1">
          <span class="nobr">
            <a href="/productos/' . $url  .'"> ' . $productName . '
            </a>
          </span>
        </th>

        <th class="a-center" rowspan="1">'.$price.'</th>
          
        <th class="a-center">
            <input type="number" class="'.$clase.'" name="cantidad" min="1" value="'.$cantidad.'" data-id="'.$basketID.'">
        </th> 
      ';
  
      if(COTIZAR===true) {
        $carro .= '
          <th class="a-center">
            <input type="number" class="descuentoCotizar" name="descuentoCotizar" min="0" max="100" value="'.$descuentoCotizar.'" data-id="'.$basketID.'">
          </th>
        ';

        // Accesorios
        $carro .= '
          <th class="a-center">
            <select name="accesorios_' .$row2['idproducto']. '[]" id="accesorios_' .$row2['idproducto']. '[]" multiple style="width: 22vw; "> ';
              $sql = "SELECT * FROM tblti_productos A
                         INNER JOIN tblti_imagenes B
                                 ON A.idproducto = B.idproducto
                              WHERE idcategoria = 135";
              $sql = "SELECT * FROM tblti_productos_asociados A 
                         INNER JOIN tblti_productos B
                                 ON B.idproducto = A.idproductoa
                         INNER JOIN tblti_imagenes C
                                 ON A.idproductoa = C.idproducto
                              WHERE A.idproducto = '{$row2["idproducto"]}'  ";

              $accesorios = mysqli_query($nConexion,$sql);
              while($row = mysqli_fetch_array($accesorios)){
                $carro .= "
                  <option value='{$row["idproducto"]}'  style='background-image: url(/fotos/tienda/productos/{$row["imagen"]}); background-size: contain; background-repeat: no-repeat; background-origin: content-box; padding: 0px;' >
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$row["nombre"]}
                  </option>
                ";
              }      
        $carro .= '
            </select>
          </th>
        ' ;
      }

      $carro .= '
        <th class="a-center" colspan="1">'.$subtotal.'</th>
        <th rowspan="1"> </th>
      </tr>';
  
    $basketText = $basketText . $carro;
    
  }
  return $basketText;
}

function total(){
  if(!session_id()) session_start();
  $sessionID = $_COOKIE['PHPSESSID'];
    $nConexion    = Conectar();
  $result=mysqli_query($nConexion,"SELECT SUM(cantidad) AS total from tblti_baskets WHERE basketSession='$sessionID'");

  $row = mysqli_fetch_object( $result );

  echo "<div id='numero'>$row->total</div>";
}

function totalCarro($doc="cedula"){
  include dirname(__FILE__).("/../diasiniva.php");

  if(!session_id()) session_start();	
  $sessionID = $_COOKIE['PHPSESSID'];
  
  $cartTotal = 0;
  $nConexion    = Conectar();	
  
  $query  = "SELECT * FROM tblti_baskets WHERE basketSession = '" . $sessionID . "'";	
  $query  = "SELECT * FROM `tblti_baskets` A
         INNER JOIN tblti_productos B 
                 ON A.productID = B.idproducto
              WHERE basketSession = '" . $sessionID . "'
           ORDER BY A.basketID DESC ";
  
  $result = mysqli_query($nConexion,$query);		
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    if(DIASINIVA && $row["diasiniva"] && $doc=="nit") {
      $productPrice = ($row['precio'] - ($row['precio'] * ($row['descuento'] / 100))) * $row['cantidad'];
    }else{
      $productPrice = ($row['productPrice'] - ($row['productPrice'] * ($row['descuento'] / 100))) * $row['cantidad'];
    }
    $cartTotal += $productPrice ;
  }    

  return($cartTotal);  
}
function iva($doc="cedula"){
    include dirname(__FILE__).("/../diasiniva.php");
    
    if(!session_id()) session_start();	
    $sessionID = $_COOKIE['PHPSESSID'];
    
	$iva = 0;
	$valorDescuento = 0;
	
    $nConexion    = Conectar();
	$query  = "SELECT b.*, p.iva, p.diasiniva, p.precio FROM tblti_baskets b LEFT JOIN tblti_productos p ON b.productID=p.idproducto WHERE basketSession='$sessionID' AND iva!=0";
	$result = mysqli_query($nConexion,$query);
	
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        if(DIASINIVA && $row["diasiniva"] && $doc!="nit") {
            $iva += 0;
        } else {
    		$divisor = 1 + ($row['iva'] / 100);
    		$productPrice = $row['precio'] * $row['cantidad'];
    		$precio = $productPrice - $valorDescuento;
    		$sinIva = $precio / $divisor;
            $iva += $precio - $sinIva;
    	}
	}
	return $iva;
}


function nuevoCarro($d) {

  require_once dirname(__FILE__).("/../../admin/vargenerales.php");
  include dirname(__FILE__).("/../diasiniva.php");
  
  include("../php/fletes/coo/calculo.php");
  
  if($_SESSION['loggedin']==true && $_SESSION["usuario"]["cotizacion"]==1){
    define("COTIZAR", true);
  } else {
    define("COTIZAR", false);
  }
  
  if(!session_id()) session_start();
  $sessionID = $_COOKIE['PHPSESSID'];
  $now = time();
    $nConexion    = Conectar();

  if(!isset($_SESSION['usuario']['idusuario'])){
    $_SESSION['usuario']['idusuario'] = 0;
  }
  
  $query  = "SELECT country FROM countries WHERE id={$d["country"]}";
  $result = mysqli_query($nConexion,$query);
  $row = mysqli_fetch_array( $result );

  //EFP
  $idusuario = $_SESSION["usuario"]["idusuario"];

  /* EFP Lenguaje */
  $sin_iva=$d["sinIva"];
  $iva=$d["iva"];
  $total=$d["total"];
  $nombre=$d["nombre"];
  $apellido=$d["apellido"];
  $tipoid=$d["tipoid"];
  $identificacion=$d["identificacion"];
  $direccion=$d["direccion"];
  $telefono=$d["telefono"];
  $ciudad=$d["strciudad"];
  $country=$d["country"];
  $state=$d["strdepartamento"];
  $zipcode=$d["ciudadDpt"];
  $correo=$d["correo_electronico"];
  $extra=$d["extra"];
  $descripcion="Pedido a nombre de $nombre por valor total de COP $total";

  $observaciones=$d["metodo"];

  if( isset($d["valorDescuento"]) ) {
    $descuento = $d["valorDescuento"];
    //EFP
    $sql="INSERT INTO tblti_carro (
              session_id,usuario,idusuario, fecha, descripcion, descuento, tipoID, identificacion, sin_iva, iva,
              precio_total, nombre, apellido, direccion, telefono, ciudad, 
              country, state, zipcode, correo_electronico, extra, observaciones, latitud, longitud, valorEnvioEN, codigoDescuento)
          VALUES ('$sessionID','$idusuario','$idusuario', FROM_UNIXTIME($now), 
              '$descripcion', '$descuento', '$tipoid', '$identificacion', '$sin_iva', '$iva', '$total', '$nombre', '$apellido', 
              '$direccion', '$telefono', '$ciudad','$country', '$state', 
              '$zipcode', '$correo', '$extra', '$observaciones', '{$d["latitud"]}', '{$d["longitud"]}', '{$d["valorEnvioEN"]}', '{$d["codigoDescuento"]}')";              
    $r = mysqli_query($nConexion,$sql);
  } else{
    //EFP
    $sql="INSERT INTO tblti_carro (
              session_id,usuario,idusuario, fecha, descripcion, tipoID, identificacion, sin_iva, iva,
              precio_total, nombre, apellido, direccion, telefono, ciudad, 
              country, state, zipcode, correo_electronico, extra, latitud, longitud, valorEnvioEN, codigoDescuento) 
          VALUES ('$sessionID','$idusuario','$idusuario', FROM_UNIXTIME($now), 
              '$descripcion', '$tipoid', '$identificacion', '$sin_iva', '$iva', '$total', '$nombre', '$apellido', 
              '$direccion', '$telefono', '$ciudad', '$country', '$state',
              '$zipcode', '$correo', '$extra', '{$d["latitud"]}', '{$d["longitud"]}', '{$d["valorEnvioEN"]}', '{$d["codigoDescuento"]}')";              
    $r = mysqli_query($nConexion,$sql);
  }
    
  $idcarro = mysqli_insert_id($nConexion);
  $titulo = VerSitioConfig('titulo');
  $idc = str_pad($idcarro, 5, "0", STR_PAD_LEFT);
  $referenciaPayU = $titulo.$idc."CO";

  mysqli_query($nConexion,"UPDATE tblti_carro 
                  SET referenciaPayU = '$referenciaPayU' 
                WHERE carro = '$idcarro'");

  $query  = "SELECT a.basketID,a.cantidad,b.nombre,b.referencia,a.productPrice,a.descuento,a.stihl,
                    b.idproducto,b.peso,b.ancho,b.alto,b.largo,b.precio
               FROM tblti_baskets a join tblti_productos b 
                 ON (a.productID=b.idproducto) 
              WHERE basketSession = '$sessionID'";
  //echo $query;
  
  $result = mysqli_query($nConexion,$query);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $id = $row['basketID'];
    $cantidad = $row['cantidad'];
    $nombre = $row['nombre'];
    $referencia = $row['referencia'];
    $precio = $row['productPrice'];
    $idproducto=$row["idproducto"];
    $descuento=$row["descuento"];
    $stihl=$row["stihl"];

    $peso = $row['peso'];
    $alto = $row['alto'];
    $ancho = $row['ancho'];
    $largo = $row['largo'];


    $dim["alto"]     = $row['alto'];
    $dim["ancho"]    = $row['ancho'];
    $dim["largo"]    = $row['largo'];
    $dim["peso"]     = $row['peso'];
    $dim["cantidad"] = 1;

    $dim["producto"] = $row['idproducto'];
    $dim["origen"]   = "05001000";  // Medellin Antioquia
    $dim["destino"]  = $d["ciudadDpt"];
    $dim["valor"]    = $row['productPrice'];


    $flete = json_decode(calcularEnvio($dim));
    $flete_total = $flete->flete_total ;
    $dias        = $flete->dias_entrega ;
    $volumen     = $flete->volumen ;

    if(DIASINIVA && $tipoid=="nit" && !COTIZAR) {
    $precio = $row['precio'];    
    }

    if( isset($d["color{$id}"]) ) {
      $color=$d["color{$id}"];
      $talla=$d["talla{$id}"];
    }
    $sql="INSERT INTO tblti_carro_detalle 
                      (carro, idproducto, item, unidades, precio, talla, color, 
                      observaciones, peso, alto, ancho, largo, flete, dias, volumen, descuento, stihl) 
               VALUES ('$idcarro', '$idproducto', '$nombre', $cantidad, '$precio',  
                      '$talla', '$color', '$observaciones', 
                      '{$peso}', '{$alto}', '{$ancho}', '{$largo}', 
                      '{$flete_total}', '{$dias}', '{$volumen}', '{$descuento}', $stihl )";	
                      
    $r = mysqli_query($nConexion,$sql);
  }
  
  $query  = "SELECT p.nombre FROM tblti_baskets c LEFT JOIN tblti_productos p ON c.productID=p.idproducto WHERE c.basketSession='$sessionID' AND c.stihl=1 ORDER BY c.basketID DESC";
  $result = mysqli_query($nConexion,$query);
  if(mysqli_num_rows($result)>0){

    $RegContenido = mysqli_fetch_object(VerContenido( "mensaje-stihl" ));
    $mensaje = "
    Han pedido una cotización desde el sitio web de Agrotécnico!<br><br>
    Nombre: {$d["nombre"]} $apellido<br>
    Identificación: $identificacion<br>
    Dirección: $direccion<br>
    Ciudad: $ciudad<br>
    Correo: $correo<br>
    Teléfono: $telefono<br><br>
    <h3>Productos para cotizar</h3>";
    while($rax=mysqli_fetch_object($result)):
      $mensaje .= "- $rax->nombre<br>";
    endwhile;
    
    $mail = new PHPMailer(true);
    $mail->CharSet   = "UTF-8";
    $mail->IsHTML(true);
    $mail->From      = VerSitioConfig('correo');
    $mail->FromName  = VerSitioConfig('correo_nombre');
    $mail->Subject   = "Cotización Agrotécnico";
    $mail->Body      = $RegContenido->contenido;
    $mail->AddAddress($correo);
    $mail->Send();

    $mail2 = new PHPMailer(true);
    $mail2->CharSet = "UTF-8";
    $mail2->IsHTML(true);
    $mail2->From      = $mail->From;
    $mail2->FromName  = $mail->FromName;    
    $mail2->Subject   = $mail->Subject;
    $mail2->Body      = $mensaje;
    $mail2->AddAddress("comunicaciones@agrotecnico.com.co");
    $mail2->AddAddress("Administracion@agrotecnico.com.co");
    $mail2->Send();
  }
}
?>