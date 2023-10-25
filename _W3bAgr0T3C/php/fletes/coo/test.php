<?
// ... please, add composer autoloader first
include_once 'vendor/autoload.php';
include "WebService.php";

if($_REQUEST) {
  if(!$_REQUEST["test"]) {
    // https://agrotecnico.com.co/php/fletes/coo/test.php?alto=20&ancho=25&largo=33&peso=38&cantidad=1&producto=MOTOSIERRA&origen=05001000&destino=73001000&valor=975000
    $alto     = $_REQUEST["alto"];
    $ancho    = $_REQUEST["ancho"];
    $largo    = $_REQUEST["largo"];
    $peso     = $_REQUEST["peso"];
    $cantidad = $_REQUEST["cantidad"];

    $producto = $_REQUEST["producto"];
    $origen   = $_REQUEST["origen"];
    $destino  = $_REQUEST["destino"];
    $valor    = $_REQUEST["valor"];
  }else{
    // https://agrotecnico.com.co/php/fletes/coo/test.php?test=1
    $alto  = "50";
    $ancho = "50";
    $largo = '150';
    $peso  = '10';  
    $cantidad = '1';
    
    $producto = "0";
    $origen   = '05001000';
    $destino  = '73001000';
    $valor    = '800000';  
  }
}

// import webservice class

$apikey   = '2227ccdc-2e43-11ea-978f-2e728ce88125'; // your apikey of Coordinadora
$password = 'w6P4rCeyLyHk'; // your password of Coordinadora
$nit      = '901073241'; //your nit

//guides
$id_client = ''; //your id client
$user_guide = ''; //your user
$password_guide = ''; //your password


try{
    $coordinadora = new WebService($apikey, $password, $nit, $id_client, $user_guide, $password_guide);
    $coordinadora->sandbox_mode(true); //true for tests or false for production
}
catch (\Exception $exception){
    echo $exception->getMessage();
}




$cart_prods = array(
    'ubl' => '0', //Código de la UBL, 0=>Automatica, 1=>Mercancia
    'alto' => "{$alto}",
    'ancho' => $ancho,
    'largo' => $largo,
    'peso' => $peso,
    'unidades' => $cantidad
);

$params = array(
    'div' => "00", //Div asociado a un acuerdo Coordinadora Mercantil, si no se tiene acuerdo el campo puede ir vacio
    'cuenta' => "2",
    'producto' => "{$producto}",
    'origen' => $origen,
    'destino' => $destino,
    'valoracion' => $valor,
    'nivel_servicio' => array(0),
    'detalle' => array(
        'item' => $cart_prods
    )
);

try{
  $data = $coordinadora->Cotizador_cotizar($params);
  //$data = $coordinadora->Cotizador_ciudades();
  //$data = $coordinadora->Cotizador_departamentos();
  
  echo $data;
}
  catch (\Exception $exception){
  echo $exception->getMessage();
}

