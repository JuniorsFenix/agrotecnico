<?
// ... please, add composer autoloader first
include_once 'vendor/autoload.php';
include "WebService.php";

$apikey   = '2227ccdc-2e43-11ea-978f-2e728ce88125'; // your apikey of Coordinadora
$password = 'w6P4rCeyLyHk'; // your password of Coordinadora
$nit      = '901073241'; //your nit

//guides
$id_client      = ''; //your id client
$user_guide     = ''; //your user
$password_guide = ''; //your password


if($_REQUEST["test"]) {
  // https://agrotecnico.com.co/php/fletes/coo/calculo.php?test=true&alto=54&ancho=24&largo=43&peso=5&cantidad=1&producto=0&origen=05001000&destino=73001000&valor=975000
  $dim["alto"] = $_REQUEST["alto"];
  $dim["ancho"] = $_REQUEST["ancho"];
  $dim["largo"] = $_REQUEST["largo"];
  $dim["peso"] = $_REQUEST["peso"];
  $dim["cantidad"] = $_REQUEST["cantidad"];

  $dim["producto"] = $_REQUEST["producto"];
  $dim["origen"] = $_REQUEST["origen"];
  $dim["destino"] = $_REQUEST["destino"];
  $dim["valor"] = $_REQUEST["valor"];

  echo calcularEnvio($dim);
}

if($_REQUEST["listarDepartamentos"]) {
  echo (listarDepartamentos());
}

if($_REQUEST["listarCiudades"]) {
  echo (listarCiudades());
}


function calcularEnvio($dim) {
  global $apikey, $password, $nit, $id_client, $user_guide, $password_guide;

  $apikey   = '2227ccdc-2e43-11ea-978f-2e728ce88125'; // your apikey of Coordinadora
  $password = 'w6P4rCeyLyHk'; // your password of Coordinadora
  $nit      = '901073241'; //your nit

  //guides
  $id_client      = ''; //your id client
  $user_guide     = ''; //your user
  $password_guide = ''; //your password

  try{
    $coordinadora = new WebService($apikey, $password, $nit, $id_client, $user_guide, $password_guide);
    $coordinadora->sandbox_mode(true); //true for tests or false for production
  }catch (\Exception $exception){
    return $exception->getMessage();
  }

  $cart_prods = array(
      'ubl'   => '0', //Código de la UBL, 0=>Automatica, 1=>Mercancia
      'alto'  => $dim["alto"],
      'ancho' => $dim["ancho"],
      'largo' => $dim["largo"],
      'peso'  => $dim["peso"],
      'unidades' => $dim["cantidad"]
  );

  $params = array(
      'div'         => "00", //Div asociado a un acuerdo Coordinadora Mercantil, si no se tiene acuerdo el campo puede ir vacio
      'cuenta'      => "2",
      'producto'    => $dim["producto"],
      'origen'      => $dim["origen"],
      'destino'     => $dim["destino"],
      'valoracion'  => $dim["valor"],
      'nivel_servicio' => array(0),
      'detalle'     => array(
          'item' => $cart_prods
      )
  );

  try{
    $data = $coordinadora->Cotizador_cotizar($params);
    trigger_error($data);

    return $data;
  }
    catch (\Exception $exception){
    return $exception->getMessage();
  }
}

function listarCiudades() {
  global $apikey, $password, $nit, $id_client, $user_guide, $password_guide;

  try{
    $coordinadora = new WebService($apikey, $password, $nit, $id_client, $user_guide, $password_guide);
    $coordinadora->sandbox_mode(true); //true for tests or false for production
  }catch (\Exception $exception){
    return $exception->getMessage();
  }

  try{
    $data = $coordinadora->Cotizador_ciudades();
    return($data);
  }
    catch (\Exception $exception){
    return $exception->getMessage();
  }
}

function listarDepartamentos() {
  global $apikey, $password, $nit, $id_client, $user_guide, $password_guide;

  try{
    $coordinadora = new WebService($apikey, $password, $nit, $id_client, $user_guide, $password_guide);
    $coordinadora->sandbox_mode(true); //true for tests or false for production
  }catch (\Exception $exception){
    return $exception->getMessage();
  }

  try{
    $data = $coordinadora->Cotizador_departamentos();
    return($data);
  }
    catch (\Exception $exception){
    return $exception->getMessage();
  }
}
