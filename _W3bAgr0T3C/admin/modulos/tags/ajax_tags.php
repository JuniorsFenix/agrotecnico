<?php
require_once("../../funciones_generales.php");

//check we have username post var
if(isset($_POST["palabra"]))
{
    //check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        die();
    }  

$nConexion = Conectar();
   
    $palabra =  strtolower(trim($_POST["palabra"]));
   
    $results = mysqli_query($nConexion,"SELECT idpalabra FROM tbltags_palabras WHERE nombre='$palabra'");
   
    $username_exist = mysqli_num_rows($results);
   
    if($username_exist) {
        echo ' Esta palabra ya existe';
    }else{
        echo '';
    }
   
    //close db connection
     mysqli_close($nConexion);
}

?>